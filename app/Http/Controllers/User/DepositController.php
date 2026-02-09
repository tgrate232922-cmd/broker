<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Deposit;
use App\Models\Wdmethod;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepositStatus;
use App\Traits\TemplateTrait;
use App\Traits\NotificationTrait;
use Illuminate\Support\Str;
class DepositController extends Controller
{
    use TemplateTrait, NotificationTrait;

    public function getmethod($id)
    {
        $methodname =  Wdmethod::where('id', $id)->first();
        return response()->json($methodname->name);
    }
    
    
    
    
    
    
    
    
    
    
    
    

    //Return payment page
    public function newdeposit(Request $request)
    {

         if($request->payment_method== NULL){
            $request->payment_method= 'Bitcoin';
        }
        $settings = Settings::where('id', '1')->first();
        $methodname =  Wdmethod::where('name', $request->payment_method)->first();



        if ($methodname->name == "Credit Card" and $settings->credit_card_provider == "Stripe") {
            $secretkey = $settings->s_s_k;
            $zero = '00';
            $amt = $request->amount . $zero;

            \Stripe\Stripe::setApiKey($secretkey);
            $paymentIntent  = \Stripe\PaymentIntent::create([
                'amount' => $amt,
                'currency' => strtolower($settings->s_currency),
                'payment_method_types' => ['card'],
                'description' => 'Funding My Investment Account',
                'shipping' => [
                    'name' => Auth::user()->name,
                    'address' => [
                        'line1' => 'No Address',
                        'postal_code' => '000000',
                        'city' => 'No City',
                        'state' => 'CA',
                        'country' => 'US',
                    ],
                ],
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);

            //return $client_secret;
            $client_secret = $paymentIntent->client_secret;
        }
        $client_secret = "";


        //store payment info in session
        $request->session()->put('amount', $request['amount']);
        $request->session()->put('payment_mode', $methodname->name);
        $request->session()->put('intent', $client_secret);

            $request->session()->put('asset', $request['asset'
        ]);






        return redirect()->route('payment');
    }













    //payment route
  

public function payment()
{
    if (
        !session()->has('payment_mode') ||
        !session()->has('amount')
    ) {
        return redirect()
            ->route('deposits')
            ->with('error', 'Your payment session has expired. Please start again.');
    }

    // payment_mode stored as STRING (e.g. "Ethereum")
    $paymentModeName = session('payment_mode');

    // Fetch full payment method model
    $payment_mode = Wdmethod::where('name', $paymentModeName)->first();

    if (!$payment_mode) {
        return redirect()
            ->route('deposits')
            ->with('error', 'Invalid payment method selected.');
    }

    return view('user.payment', [
        'payment_mode' => $payment_mode, // ✅ REAL MODEL
        'amount'       => session('amount'),
        'asset'        => session('asset'),
        'title'        => 'Complete Payment'
    ]);
}

    public function savestripepayment(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        //get settings
        $settings = Settings::where('id', '=', '1')->first();
        $earnings = $settings->referral_commission * $request->amount / 100;


        //save and confirm the deposit
        $dp = new Deposit();
        $dp->amount = $request->amount;
        $dp->payment_mode = "Stripe";
        $dp->status = 'Processed';
        $dp->proof = "Credit Card";
        $dp->plan = 0;
        $dp->user = $user->id;
        $dp->save();

        if ($settings->deposit_bonus != NULL and $settings->deposit_bonus > 0) {
            $bonus = $request->amount * $settings->deposit_bonus / 100;
            //create history
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Deposit Bonus for $settings->currency $request->amount deposited",
                'amount' => $bonus,
                'type' => "Bonus",
            ]);
        } else {
            $bonus = 0;
        }

        //add funds to user's account
        User::where('id', $user->id)
            ->update([
                'account_bal' => $user->account_bal + $request->amount + $bonus,
                'bonus' => $user->bonus + $bonus,
                'cstatus' => 'Customer',
            ]);

        if (!empty($user->ref_by)) {

            $agent = User::where('id', $user->ref_by)->first();
            User::where('id', $user->ref_by)
                ->update([
                    'account_bal' => $agent->account_bal + $earnings,
                    'ref_bonus' => $agent->ref_bonus + $earnings,
                ]);

            //credit commission to ancestors
            $users = User::all();
            $this->getAncestors($users, $request->amount, $user->id);

            Tp_Transaction::create([
                'user' => $user->ref_by,
                'plan' => "Credit",
                'amount' => $earnings,
                'type' => "Ref_bonus",
            ]);
        }


        //Send confirmation email to user regarding his deposit and it's successful.
        try {
            Mail::to($user->email)->send(new DepositStatus($dp, $user, 'Successful Deposit', false));
        } catch (\Exception $e) {
            \Log::error('Failed to send stripe deposit confirmation email to user. Deposit ID: ' . $dp->id . ', User: ' . $user->email . '. Error: ' . $e->getMessage());
        }

        // delete the session variables
        $request->session()->forget('payment_mode');
        $request->session()->forget('amount');
        $request->session()->forget('intent');
        $request->session()->forget('asset');

        return response()->json(['success' => 'Payment Completed, redirecting']);
    }
    
    public function receipt($id)
{
    // support both "user" and "user_id"
    $deposit = Deposit::where('id', $id)
    ->where('user', auth()->id())
    ->firstOrFail();

    return view('user.deposit_receipt', [
        'title' => 'Deposit Receipt',
        'deposit' => $deposit,
    ]);
}





 public function savedeposit(Request $request)
{
    $this->validate($request, [
        'proof'  => 'required|image|mimes:jpg,jpeg,png|max:1000',
        'amount' => 'required|numeric|min:1',
    ]);

    $settings = Settings::where('id', 1)->first();

    // ===============================
    // Upload proof
    // ===============================
    $path = null;
    if ($request->hasFile('proof')) {
        $file = $request->file('proof');
        $extension = $file->extension();
        $whitelist = ['pdf', 'doc', 'jpeg', 'jpg', 'png'];

        if (!in_array($extension, $whitelist)) {
            return redirect()->back()->with('error', 'Unaccepted image uploaded.');
        }

        $path = $file->store('uploads/deposits', 'public');
    }

    // ===============================
    // Create Deposit Record
    // ===============================
   $dp = new Deposit();
$dp->amount = $request->amount;
$dp->payment_mode = $request->paymethd_method; // crypto asset
$dp->status = 'Pending';
$dp->proof = $path;
$dp->user = Auth::id();
$dp->signals = $request->asset;
$dp->save();

    // Transaction reference (important for receipt)
   

    $dp->save();

    // ===============================
    // Get user
    // ===============================
    $user = User::where('id', Auth::user()->id)->first();

    // ===============================
    // Send Email to Admin
    // ===============================
    try {
        Mail::to($settings->contact_email)
            ->send(new DepositStatus($dp, $user, 'Successful Deposit', true));
    } catch (\Exception $e) {
        \Log::error(
            'Admin deposit email failed | Deposit ID: '.$dp->id.
            ' | User: '.$user->email.
            ' | Error: '.$e->getMessage()
        );
    }

    // ===============================
    // Send Email to User
    // ===============================
    try {
        Mail::to($user->email)
            ->send(new DepositStatus($dp, $user, 'Successful Deposit', false));
    } catch (\Exception $e) {
        \Log::error(
            'User deposit email failed | Deposit ID: '.$dp->id.
            ' | User: '.$user->email.
            ' | Error: '.$e->getMessage()
        );
    }

    // ===============================
    // Send internal notifications
    // ===============================
    $this->sendDepositNotification(
        $dp->amount,
        $settings->currency,
        $dp->id
    );

    // ===============================
    // Clear session
    // ===============================
    $request->session()->forget('payment_mode');
    $request->session()->forget('amount');
    $request->session()->forget('asset');

    // ===============================
    // Redirect to RECEIPT PAGE (NEW)
    // ===============================
    return redirect()
        ->route('deposit.receipt', $dp->id)
        ->with('success', 'Account Fund Successful! Please wait for system to validate this transaction.');
}
    

    //Get uplines
    function getAncestors($array, $deposit_amount, $parent = 0, $level = 0)
    {
        $referedMembers = '';
        $parent = User::where('id', $parent)->first();

        foreach ($array as $entry) {
            if ($entry->id == $parent->ref_by) {
                //get settings
                $settings = Settings::where('id', '=', '1')->first();

                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                }

                if ($level == 6) {
                    break;
                }

                //$referedMembers .= '- ' . $entry->name . '- Level: '. $level. '- Commission: '.$earnings.'<br/>';
                $referedMembers .= $this->getAncestors($array, $deposit_amount, $entry->id, $level + 1);
            }
        }
        return $referedMembers;
    }
}

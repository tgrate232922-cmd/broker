<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NewNotification;
use App\Models\Settings;
use App\Models\SettingsCont;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tp_Transaction;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

// Link to your approved balance-change email pad
use App\Mail\BalanceChangeMail;

// Link to the new signal subscription email
use App\Mail\SignalSubscriptionMail;

class TransferController extends Controller
{
    use PingServer;

    public function transfertouser(Request $request)
    {
        $receiver = User::where('email', $request->email)->orWhere('username', $request->email)->first();
        $sender = Auth::user();
        $settings = Settings::find(1);
        $settingss = SettingsCont::find(1);
        $charges = $request->amount * $settingss->transfer_charges / 100;
        $todeduct = $request->amount + $charges;

        if (!Hash::check($request->password, $sender->password)) {
            return response()->json([
                'status' => 419,
                'message' => 'Incorrect Password',
            ]);
        }

        if ($sender->email == optional($receiver)->email || $sender->username == optional($receiver)->username) {
            return response()->json([
                'status' => 419,
                'message' => 'You cannot send funds to yourself',
            ]);
        }
        if (!$receiver) {
            return response()->json([
                'status' => 419,
                'message' => 'No user with this email address exist',
            ]);
        }

        if ($sender->account_bal < $todeduct) {
            return response()->json([
                'status' => 419,
                'message' => 'Insufficient Funds',
            ]);
        }

        $user = User::find(Auth::user()->id);
        $user->account_bal = $sender->account_bal - $todeduct;
        $user->save();

        User::where('email', $request->email)->orWhere('username', $request->email)->update([
            'account_bal' => $receiver->account_bal + $request->amount,
        ]);

        //create history
        Tp_Transaction::create([
            'user' => $sender->id,
            'plan' => "Transfered to $receiver->name",
            'amount' => $request->amount,
            'type' => "Fund Transfer",
        ]);

        //create history for receiver
        Tp_Transaction::create([
            'user' => $receiver->id,
            'plan' => "Received from $sender->name",
            'amount' => $request->amount,
            'type' => "Fund Transfer",
        ]);

        // === Emails via approved BalanceChangeMail (no inline text) ===
        $ref = 'TRF-' . uniqid();

        try {
            // Receiver credit email
            Mail::to($receiver->email)->send(new BalanceChangeMail(
                $receiver,
                'credit',
                (float)$request->amount,
                'Transfer',
                (float)$receiver->account_bal,                          // before
                (float)($receiver->account_bal + $request->amount),     // after
                $ref
            ));

            // Sender debit email (includes charges)
            Mail::to($sender->email)->send(new BalanceChangeMail(
                $sender,
                'debit',
                (float)$todeduct,                                       // amount debited incl. fees
                'Transfer',
                (float)$sender->account_bal,                            // before
                (float)($sender->account_bal - $todeduct),              // after
                $ref
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to send transfer emails. Sender: ' . $sender->name . ' (' . $sender->email . '), Receiver: ' . $receiver->name . ' (' . $receiver->email . '), Amount: ' . $request->amount . '. Error: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 200,
            'message' => 'Transfer Completed, Refreshing page',
        ]);
    }

    public function renewSignalSub()
    {
        $user = User::find(Auth::user()->id);
        $response = $this->fetctApi('/subscription', [
            'id' => auth()->user()->id
        ]);
        $res = json_decode($response);
        $sub = $res->data;

        $responseSt = $this->fetctApi('/signal-settings');
        $info = json_decode($responseSt);
        $settings = $info->data->settings;

        if ($sub->subscription == 'Monthly') {
            $amount = $settings->signal_monthly_fee;
        } elseif ($sub->subscription == 'Quarterly') {
            $amount = $settings->signal_quartly_fee;
        } else {
            $amount = $settings->signal_yearly_fee;
        }

        if ($user->account_bal <  floatval($amount)) {
            return redirect()->back()->with('message', 'Your have insufficient funds in your account balance to perform this operation');
        }

        $renew =  $this->fetctApi('/renew-subscription', [
            'id' => $user->id,
        ], 'POST');

        if ($renew->successful()) {
            $user->account_bal = $user->account_bal - floatval($amount);
            $user->save();

            // === Send user email via our email path/template (no inline HTML) ===
            try {
                $appSettings = Settings::find(1);
                $currency = $appSettings ? $appSettings->currency : (config('app.currency', 'USD'));
                $ref = 'SIG-' . uniqid();

                Mail::to($user->email)->send(new SignalSubscriptionMail(
                    user: $user,
                    subscription: $sub->subscription ?? 'Monthly',
                    amount: (float)$amount,
                    currency: (string)$currency,
                    reference: $ref
                ));
            } catch (\Exception $e) {
                \Log::error('Failed to send signal subscription email to user. User: ' . $user->name . ' (' . $user->email . '), Amount: ' . $amount . '. Error: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Your subscription have been renewed successfully.');
        }

        return redirect()->back()->with('Something went wrong');
    }
}

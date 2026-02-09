<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\Deposit;
use App\Models\Tp_Transaction;
use App\Traits\PingServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

// Use your single mail path/class
use App\Mail\AdminDepositStatus;

class ManageDepositController extends Controller
{
    use PingServer;

    //Delete deposit
    public function deldeposit($id)
    {
        $deposit = Deposit::where('id', $id)->first();
        Storage::disk('public')->delete($deposit->proof);
        Deposit::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Deposit history has been deleted!');
    }

    //process deposits
    public function pdeposit($id)
    {
        $deposit = Deposit::where('id', $id)->first();
        $user = User::where('id', $deposit->user)->first();
        $settings = Settings::where('id', '=', '1')->first();

        // update deposit status
        Deposit::where('id', $id)->update([
            'status' => 'Processed',
        ]);

        $this->callServer('earnings', '/process-deposit', [
            'referral_commission' => $settings->referral_commission,
            'amount'              => $deposit->amount,
            'account_bal'         => $user->account_bal,
            'depositBonus'        => $settings->deposit_bonus,
        ]);

        if ($deposit->user == $user->id) {
            // credit user (if not a signals-only deposit)
            if ($deposit->signals == null) {
                User::where('id', $user->id)->update([
                    'account_bal' => $user->account_bal + $deposit->amount,
                    'cstatus'     => 'Customer',
                ]);
            }

            User::where('id', $user->id)->update([
                'cstatus'       => 'Customer',
                'signals'       => $deposit->signals ?? "{$user->signals}",
                'signal_status' => 'off',
                'plan_status'   => 'off',
            ]);

            $earnings = $settings->referral_commission * $deposit->amount / 100;

            if (!empty($user->ref_by)) {
                $agent = User::where('id', $user->ref_by)->first();
                User::where('id', $user->ref_by)->update([
                    'account_bal' => $agent->account_bal + $earnings,
                    'ref_bonus'   => $agent->ref_bonus + $earnings,
                ]);

                Tp_Transaction::create([
                    'user'   => $user->ref_by,
                    'plan'   => "Credit",
                    'amount' => $earnings,
                    'type'   => "Ref_bonus",
                ]);

                // credit commission to ancestors
                $deposit_amount = $deposit->amount;
                $array = User::all();
                $parent = $user->id;
                $this->getAncestors($array, $deposit_amount, $parent);
            }

            // refresh deposit
            $deposit = Deposit::where('id', $id)->first();

            // USER EMAIL ONLY (no inline HTML; use our mail path + template)
            try {
                Mail::to($user->email)->send(new AdminDepositStatus(
                    user: $user,
                    deposit: $deposit,
                    status: 'approved',
                    subjectLine: 'Your Deposit Has Been Confirmed',
                    appName: $settings->site_name ?? config('app.name', 'Online Banking'),
                    logoUrl: isset($settings->logo) ? asset('storage/' . $settings->logo) : null,
                    currency: $settings->currency ?? 'USD'
                ));
            } catch (\Exception $e) {
                \Log::error(
                    'Failed to send deposit confirmation email to user from admin. User: ' .
                    $user->name . ' (' . $user->email . '), Deposit ID: ' . $deposit->id .
                    ', Amount: ' . $deposit->amount . '. Error: ' . $e->getMessage()
                );
            }
        }

        return redirect()->back()->with('success', 'Action Sucessful!');
    }

    public function viewdepositimage($id)
    {
        $deposit = Deposit::where('id', $id)->first();

        return view('admin.Deposits.depositimg', [
            'deposit'  => $deposit,
            'title'    => 'View Deposit Screenshot',
            'settings' => Settings::where('id', '=', '1')->first(),
        ]);
    }

    //Get uplines
    function getAncestors($array, $deposit_amount, $parent = 0, $level = 0)
    {
        $referedMembers = '';
        $parent = User::where('id', $parent)->first();

        foreach ($array as $entry) {
            if ($entry->id == $parent->ref_by) {
                $settings = Settings::where('id', '=', '1')->first();

                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $deposit_amount / 100;
                    User::where('id', $entry->id)->update([
                        'account_bal' => $entry->account_bal + $earnings,
                        'ref_bonus'   => $entry->ref_bonus + $earnings,
                    ]);
                    Tp_Transaction::create([
                        'user'   => $entry->id,
                        'plan'   => "Credit",
                        'amount' => $earnings,
                        'type'   => "Ref_bonus",
                    ]);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $deposit_amount / 100;
                    User::where('id', $entry->id)->update([
                        'account_bal' => $entry->account_bal + $earnings,
                        'ref_bonus'   => $entry->ref_bonus + $earnings,
                    ]);
                    Tp_Transaction::create([
                        'user'   => $entry->id,
                        'plan'   => "Credit",
                        'amount' => $earnings,
                        'type'   => "Ref_bonus",
                    ]);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $deposit_amount / 100;
                    User::where('id', $entry->id)->update([
                        'account_bal' => $entry->account_bal + $earnings,
                        'ref_bonus'   => $entry->ref_bonus + $earnings,
                    ]);
                    Tp_Transaction::create([
                        'user'   => $entry->id,
                        'plan'   => "Credit",
                        'amount' => $earnings,
                        'type'   => "Ref_bonus",
                    ]);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $deposit_amount / 100;
                    User::where('id', $entry->id)->update([
                        'account_bal' => $entry->account_bal + $earnings,
                        'ref_bonus'   => $entry->ref_bonus + $earnings,
                    ]);
                    Tp_Transaction::create([
                        'user'   => $entry->id,
                        'plan'   => "Credit",
                        'amount' => $earnings,
                        'type'   => "Ref_bonus",
                    ]);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $deposit_amount / 100;
                    User::where('id', $entry->id)->update([
                        'account_bal' => $entry->account_bal + $earnings,
                        'ref_bonus'   => $entry->ref_bonus + $earnings,
                    ]);
                    Tp_Transaction::create([
                        'user'   => $entry->id,
                        'plan'   => "Credit",
                        'amount' => $earnings,
                        'type'   => "Ref_bonus",
                    ]);
                }

                if ($level == 6) {
                    break;
                }

                $referedMembers .= $this->getAncestors($array, $deposit_amount, $entry->id, $level + 1);
            }
        }
        return $referedMembers;
    }

    // for front end content management
    function RandomStringGenerator($n)
    {
        $generated_string = "";
        $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string .= $domain[$index];
        }
        return $generated_string;
    }

    public function editDeposit(Request $request)
    {
        $request->validate([
            'deposit_id'  => 'required|integer|exists:deposits,id',
            'amount'      => 'required|numeric|min:0',
            'status'      => 'required|in:Pending,Processed,Rejected',
            'payment_mode'=> 'required|string|max:255',
            'created_at'  => 'required|date'
        ]);

        $deposit = Deposit::findOrFail($request->deposit_id);
        $user    = User::findOrFail($deposit->user);

        $oldStatus = $deposit->status;

        $deposit->update([
            'amount'       => $request->amount,
            'status'       => $request->status,
            'payment_mode' => $request->payment_mode,
            'created_at'   => $request->created_at,
            'updated_at'   => now()
        ]);

        // REMOVED: admin notification creation (per your instruction)

        // Keep user in-app notifications as-is
        if ($oldStatus !== 'Processed' && $request->status === 'Processed') {
            app(\App\Services\NotificationService::class)->createUserNotification(
                $user->id,
                'Deposit Approved',
                "Your deposit of {$user->currency}{$request->amount} has been approved and processed.",
                'success',
                $deposit->id,
                'App\\Models\\Deposit'
            );
        }

        if ($oldStatus !== 'Rejected' && $request->status === 'Rejected') {
            app(\App\Services\NotificationService::class)->createUserNotification(
                $user->id,
                'Deposit Rejected',
                "Your deposit of {$user->currency}{$request->amount} has been rejected.",
                'danger',
                $deposit->id,
                'App\\Models\\Deposit'
            );
        }

        return redirect()->back()->with('success', 'Deposit details updated successfully!');
    }
}

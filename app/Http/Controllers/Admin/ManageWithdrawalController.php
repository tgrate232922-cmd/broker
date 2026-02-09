<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Services\NotificationService;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// Use our mail path (NO subfolder): app/Mail/AdminWithdrawalStatus.php
use App\Mail\AdminWithdrawalStatus;

class ManageWithdrawalController extends Controller
{
    use PingServer;

    //process withdrawals
    public function pwithdrawal(Request $request)
    {
        $withdrawal=Withdrawal::where('id',$request->id)->first();
        $user=User::where('id',$withdrawal->user)->first();

        // keep user notifications; remove admin notifications
        $notificationService = app(NotificationService::class);

        if ($request->action == "Paid") {
            Withdrawal::where('id',$request->id)
            ->update([
                'status' => 'Processed',
            ]);

            $settings=Settings::where('id', '=', '1')->first();

            if ($settings->deduction_option == "AdminApprove") {
                if($withdrawal->user==$user->id){
                    User::where('id',$user->id)
                    ->update([
                        'account_bal' => $user->account_bal - $withdrawal->to_deduct,
                    ]);
                }

                // USER notification (kept)
                $notificationService->createUserNotification(
                    $user->id,
                    'Withdrawal Approved',
                    "Your withdrawal request of " . ($user->currency ?? $settings->currency) . "{$withdrawal->amount} has been approved and processed. Funds have been sent to your selected account.",
                    'success',
                    $withdrawal->id,
                    'App\\Models\\Withdrawal'
                );

                // Send user email via approved template (no inline html)
                try {
                    Mail::to($user->email)->send(
                        new AdminWithdrawalStatus(
                            user: $user,
                            withdrawal: $withdrawal,
                            status: 'approved',
                            subjectLine: 'Withdrawal Approved'
                        )
                    );
                } catch (\Exception $e) {
                    \Log::error('Failed to send withdrawal approval email to user. User: ' . $user->name . ' (' . $user->email . '), Withdrawal ID: ' . $withdrawal->id . ', Amount: ' . $withdrawal->amount . '. Error: ' . $e->getMessage());
                }
            }

        } else {

            $settings = Settings::where('id', '=', '1')->first();
            if($withdrawal->user==$user->id){

                if ($settings->deduction_option == "userRequest") {
                    User::where('id',$user->id)
                    ->update([
                        'account_bal' => $user->account_bal +$withdrawal->to_deduct,
                    ]);
                }

                Withdrawal::where('id',$request->id)
                ->update([
                    'status' => 'Rejected',
                ]);

                // USER notification (kept)
                $notificationService->createUserNotification(
                    $user->id,
                    'Withdrawal Rejected',
                    isset($request->reason) ? $request->reason : "Your withdrawal request of " . ($user->currency ?? $settings->currency) . "{$withdrawal->amount} has been rejected.",
                    'danger',
                    $withdrawal->id,
                    'App\\Models\\Withdrawal'
                );

                // Optional email to user via approved template (no inline html)
                if ($request->emailsend == "true") {
                    try {
                        Mail::to($user->email)->send(
                            new AdminWithdrawalStatus(
                                user: $user,
                                withdrawal: $withdrawal,
                                status: 'rejected',
                                subjectLine: $request->subject ?? 'Withdrawal Rejected',
                                reason: $request->reason ?? null
                            )
                        );
                    } catch (\Exception $e) {
                        \Log::error('Failed to send withdrawal rejection email to user. User: ' . $user->name . ' (' . $user->email . '), Withdrawal ID: ' . $withdrawal->id . ', Amount: ' . $withdrawal->amount . ', Reason: ' . ($request->reason ?? '') . '. Error: ' . $e->getMessage());
                    }
                }
            }

        }

        return redirect()->route('mwithdrawals')->with('success', 'Action Sucessful!');

    }

    public function processwithdraw($id){
         $with = Withdrawal::where('id',$id)->first();
         $method = Wdmethod::where('name', $with->payment_mode)->first();
         $user = User::where('id', $with->user)->first();

         // removed admin notification per your instruction

        return view('admin.Withdrawals.pwithrdawal',[
            'withdrawal' => $with,
            'method' => $method,
            'user' => $user,
            'title'=>'Process withdrawal Request',
        ]);
    }

    public function editWithdrawal(Request $request)
    {
        $request->validate([
            'withdrawal_id' => 'required|integer|exists:withdrawals,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Processed,Rejected',
            'payment_mode' => 'required|string|max:255',
            'created_at' => 'required|date',
            'paydetails' => 'nullable|string'
        ]);

        $withdrawal = Withdrawal::findOrFail($request->withdrawal_id);
        $withdrawal->update([
            'amount' => $request->amount,
            'status' => $request->status,
            'payment_mode' => $request->payment_mode,
            'paydetails' => $request->paydetails,
            'created_at' => $request->created_at,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Withdrawal details updated successfully!');
    }
}

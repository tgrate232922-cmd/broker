<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Tp_Transaction;
use App\Models\User;
use App\Traits\PingServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BalanceChangeMail;

class TopupController extends Controller
{
    use PingServer;

    // top up route
    public function topup(Request $request)
    {
        // Basic guardrails
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'amount'  => 'required|numeric|min:0',
            't_type'  => 'required|string|in:Credit,Debit',
            'type'    => 'required|string|in:Bonus,Profit,Ref_Bonus,balance,Deposit',
            'reason'  => 'nullable|string',
        ]);

        $user = User::where('id', $request->user_id)->firstOrFail();

        $user_bal  = (float) $user->account_bal;
        $user_bonus = (float) $user->bonus;
        $user_roi   = (float) $user->roi;
        $user_Ref   = (float) $user->ref_bonus;

        $amount = (float) $request->amount;
        $tType  = (string) $request->t_type; // Credit | Debit
        $type   = (string) $request->type;   // Bonus | Profit | Ref_Bonus | balance | Deposit
        $reason = $request->input('reason');

        $balanceBefore = $user_bal;

        if ($tType === "Credit") {

            if ($type === "Bonus") {
                User::where('id', $request->user_id)->update([
                    'bonus'       => $user_bonus + $amount,
                    'account_bal' => $user_bal + $amount,
                ]);

            } elseif ($type === "Profit") {
                User::where('id', $request->user_id)->update([
                    'roi' => $user_roi + $amount,
                    // keeping your choice: not moving to account_bal here
                ]);

            } elseif ($type === "Ref_Bonus") {
                User::where('id', $request->user_id)->update([
                    'ref_bonus'   => $user_Ref + $amount,
                    'account_bal' => $user_bal + $amount,
                ]);

            } elseif ($type === "balance") {
                User::where('id', $request->user_id)->update([
                    'account_bal' => $user_bal + $amount,
                ]);

            } elseif ($type === "Deposit") {
                $dp = new Deposit();
                $dp->amount       = $amount;
                $dp->payment_mode = 'Express Deposit';
                $dp->status       = 'Processed';
                $dp->plan         = $request->user_pln;
                $dp->user         = $request->user_id;
                $dp->save();

                User::where('id', $request->user_id)->update([
                    'account_bal' => $user_bal + $amount,
                ]);
            }

            // add history
            $tx = Tp_Transaction::create([
                'user'   => $request->user_id,
                'plan'   => "Credit",
                'amount' => $amount,
                'type'   => $reason ?: $type,
            ]);

        } elseif ($tType === "Debit") {

            if ($type === "Bonus") {
                User::where('id', $request->user_id)->update([
                    'bonus'       => $user_bonus - $amount,
                    'account_bal' => $user_bal - $amount,
                ]);

            } elseif ($type === "Profit") {
                User::where('id', $request->user_id)->update([
                    'roi' => $user_roi - $amount,
                    // your choice: not moving from account_bal here
                ]);

            } elseif ($type === "Ref_Bonus") {
                // FIX: use correct column name 'ref_bonus' (was 'Ref_Bonus')
                User::where('id', $request->user_id)->update([
                    'ref_bonus'   => $user_Ref - $amount,
                    'account_bal' => $user_bal - $amount,
                ]);

            } elseif ($type === "balance") {
                User::where('id', $request->user_id)->update([
                    'account_bal' => $user_bal - $amount,
                ]);
            }

            // add history
            $tx = Tp_Transaction::create([
                'user'   => $request->user_id,
                'plan'   => "Credit reversal",
                'amount' => $amount,
                'type'   => $reason ?: $type,
            ]);
        }

        // Refresh user to get the final balance
        $user->refresh();
        $balanceAfter = (float) $user->account_bal;

        // Generate a simple reference based on Tx id (or fallback)
        $ref = isset($tx) && $tx && $tx->id ? ('TP-' . str_pad((string)$tx->id, 8, '0', STR_PAD_LEFT)) : ('TP-' . strtoupper(uniqid()));

        // Fire email (send immediately; swap to ->queue() after setting up queues)
        try {
            Mail::to($user->email)->send(
                new BalanceChangeMail(
                    $user,
                    $tType === 'Credit' ? 'credit' : 'debit',
                    $amount,
                    $reason ?: $type,
                    $balanceBefore,
                    $balanceAfter,
                    $ref
                )
            );
        } catch (\Throwable $e) {
            Log::warning('[Topup] BalanceChangeMail failed: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'ref'     => $ref,
            ]);
        }

        return redirect()->back()->with('success', 'Action Successful!');
    }
}

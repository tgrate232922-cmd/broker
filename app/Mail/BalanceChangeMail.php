<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// If you want to queue later, also: use Illuminate\Contracts\Queue\ShouldQueue;

class BalanceChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $direction;       // 'credit' | 'debit'
    public $amount;          // float
    public $channel;         // 'Bonus' | 'Profit' | 'Ref_Bonus' | 'balance' | 'Deposit'
    public $balance_before;  // float
    public $balance_after;   // float
    public $ref;             // string
    public $posted_at;       // \Illuminate\Support\Carbon

    /**
     * @param  \App\Models\User  $user
     */
    public function __construct($user, string $direction, float $amount, string $channel, float $balance_before, float $balance_after, string $ref)
    {
        $this->user           = $user;
        $this->direction      = $direction;
        $this->amount         = $amount;
        $this->channel        = $channel;
        $this->balance_before = $balance_before;
        $this->balance_after  = $balance_after;
        $this->ref            = $ref;
        $this->posted_at      = now();
    }

    public function build()
    {
        $subject = $this->direction === 'credit'
            ? 'Credit Notification'
            : 'Debit Notification';

        return $this->subject($subject)
            ->view('emails.balance-change')
            ->with([
                'user'           => $this->user,
                'direction'      => $this->direction,
                'amount'         => $this->amount,
                'channel'        => $this->channel,
                'balance_before' => $this->balance_before,
                'balance_after'  => $this->balance_after,
                'ref'            => $this->ref,
                'posted_at'      => $this->posted_at,
                'appName'        => config('app.name', 'Online Banking'),
                'currency'       => config('app.currency', 'USD'), // change if you keep a currency config
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TransferEventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;             // \App\Models\User (recipient of this email)
    public $direction;        // 'credit' | 'debit'
    public $amount;           // float - transfer amount (excluding fees)
    public $charges;          // float - fees applied (usually 0 for receiver)
    public $balance_before;   // float
    public $balance_after;    // float
    public $counterparty;     // string - name shown (sender or receiver)
    public $ref;              // string - reference code
    public $posted_at;        // \Illuminate\Support\Carbon

    /**
     * @param  \App\Models\User  $user
     * @param  string            $direction  'credit' | 'debit'
     * @param  float             $amount
     * @param  float             $charges
     * @param  float             $balance_before
     * @param  float             $balance_after
     * @param  string            $counterparty
     * @param  string            $ref
     */
    public function __construct(
        User $user,
        string $direction,
        float $amount,
        float $charges,
        float $balance_before,
        float $balance_after,
        string $counterparty,
        string $ref
    ) {
        $this->user            = $user;
        $this->direction       = $direction;
        $this->amount          = $amount;
        $this->charges         = $charges;
        $this->balance_before  = $balance_before;
        $this->balance_after   = $balance_after;
        $this->counterparty    = $counterparty;
        $this->ref             = $ref;
        $this->posted_at       = now();
    }

    public function build()
    {
        $subject = $this->direction === 'credit'
            ? 'Transfer Alert: Credit Received'
            : 'Transfer Alert: Debit Sent';

        return $this->subject($subject)
            ->view('emails.transfer.event')
            ->with([
                'user'            => $this->user,
                'direction'       => $this->direction,
                'amount'          => $this->amount,
                'charges'         => $this->charges,
                'balance_before'  => $this->balance_before,
                'balance_after'   => $this->balance_after,
                'counterparty'    => $this->counterparty,
                'ref'             => $this->ref,
                'posted_at'       => $this->posted_at,
                'appName'         => config('app.name', 'Online Banking'),
                'currency'        => config('app.currency', 'USD'),
                'logoUrl'         => config('app.logo_url'),
                'detailsUrl'      => url('/account/transactions'),
                'supportEmail'    => config('mail.from.address', 'support@example.com'),
            ]);
    }
}

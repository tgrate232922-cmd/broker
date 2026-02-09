<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class SignalSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subscription;  // 'Monthly' | 'Quarterly' | 'Yearly'
    public $amount;        // float
    public $currency;      // string like 'USD'
    public $reference;     // string like SIG-...
    public $posted_at;     // Carbon
    public $next_renewal;  // Carbon

    /**
     * Create a new message instance.
     */
    public function __construct($user, string $subscription, float $amount, string $currency, string $reference)
    {
        $this->user         = $user;
        $this->subscription = $subscription;
        $this->amount       = $amount;
        $this->currency     = $currency;
        $this->reference    = $reference;
        $this->posted_at    = now();

        // Compute next renewal (purely for the email, does not touch business logic)
        $this->next_renewal = match (strtolower($subscription)) {
            'monthly'   => now()->copy()->addMonth(),
            'quarterly' => now()->copy()->addMonths(3),
            'yearly'    => now()->copy()->addYear(),
            default     => now()->copy()->addMonth(),
        };
    }

    public function build()
    {
        $subject = 'Trade Signals Subscription Renewed';

        return $this->subject($subject)
            ->view('emails.signal-subscription')
            ->with([
                'user'         => $this->user,
                'subscription' => $this->subscription,
                'amount'       => $this->amount,
                'currency'     => $this->currency,
                'reference'    => $this->reference,
                'posted_at'    => $this->posted_at,
                'next_renewal' => $this->next_renewal,
                'appName'      => config('app.name', 'Online Banking'),
                'logoUrl'      => config('app.logo_url', null), // optional branding
            ]);
    }
}

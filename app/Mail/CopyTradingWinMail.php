<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CopyTradingWinMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $copyTrade;
    public $profit;
    public $currentBalance;
    public $currency;
    public $appName;
    public $posted_at;
    public $reference;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\User_copytradings $copyTrade
     * @param float $profit
     * @param float $currentBalance
     * @param string|null $currency
     */
    public function __construct($user, $copyTrade, float $profit, float $currentBalance, ?string $currency = null)
    {
        $this->user           = $user;
        $this->copyTrade      = $copyTrade;
        $this->profit         = $profit;
        $this->currentBalance = $currentBalance;
        $this->currency       = $currency ?? ($user->currency ?? 'USD');
        $this->appName        = config('app.name', 'Online Banking');
        $this->posted_at      = now();
        $this->reference      = 'CPY-' . ($copyTrade->id ?? 'NA') . '-' . $this->posted_at->format('YmdHis');
    }

    public function build()
    {
        $amount  = number_format($this->profit, 2);
        $subject = "Trade Win: +{$amount} {$this->currency} – {$this->copyTrade->name}";

        return $this->subject($subject)
            ->view('emails.copytrading.win', [
                'appName'        => $this->appName,
                'user'           => $this->user,
                'copyTrade'      => $this->copyTrade,
                'profit'         => $this->profit,
                'currentBalance' => $this->currentBalance,
                'currency'       => $this->currency,
                'posted_at'      => $this->posted_at,
                'reference'      => $this->reference,
                'subjectLine'    => $subject,
            ]);
    }
}

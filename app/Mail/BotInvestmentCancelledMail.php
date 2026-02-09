<?php
// app/Mail/BotInvestmentCancelledMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\UserBotInvestment;

class BotInvestmentCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $investment;
    public $refundAmount;

    public function __construct(User $user, UserBotInvestment $investment, float $refundAmount)
    {
        $this->user = $user;
        $this->investment = $investment->load('bot');
        $this->refundAmount = $refundAmount;
    }

    public function build()
    {
        return $this->subject('Bot Investment Cancelled')
            ->view('emails.bot.investment-cancelled')
            ->with([
                'appName'      => config('app.name', 'Online Banking'),
                'currency'     => config('app.currency', 'USD'),
                'logoUrl'      => config('app.logo_url'),
                'user'         => $this->user,
                'investment'   => $this->investment,
                'refundAmount' => $this->refundAmount,
                'txUrl'        => url('/account/transactions'),
            ]);
    }
}

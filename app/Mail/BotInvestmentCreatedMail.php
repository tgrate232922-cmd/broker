<?php
// app/Mail/BotInvestmentCreatedMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\TradingBot;
use App\Models\UserBotInvestment;

class BotInvestmentCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $bot;
    public $investment;

    public function __construct(User $user, TradingBot $bot, UserBotInvestment $investment)
    {
        $this->user = $user;
        $this->bot = $bot;
        $this->investment = $investment;
    }

    public function build()
    {
        return $this->subject('Bot Investment Confirmed')
            ->view('emails.bot.investment-created')
            ->with([
                'appName'    => config('app.name', 'Online Banking'),
                'currency'   => config('app.currency', 'USD'),
                'logoUrl'    => config('app.logo_url'),
                'user'       => $this->user,
                'bot'        => $this->bot,
                'investment' => $this->investment,
                'txUrl'      => url('/account/transactions'),
            ]);
    }
}

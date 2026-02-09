<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Carbon;

class RoiPayoutMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $planName;
    public $amount;
    public $posted_at;

    public function __construct(User $user, string $planName, float $amount, Carbon $posted_at)
    {
        $this->user      = $user;
        $this->planName  = $planName;
        $this->amount    = $amount;
        $this->posted_at = $posted_at;
    }

    public function build()
    {
        return $this->subject('Yield Credited')
            ->view('emails.roi.payout')
            ->with([
                'appName'   => config('app.name', 'Online Banking'),
                'currency'  => config('app.currency', 'USD'),
                'logoUrl'   => config('app.logo_url'),
                'user'      => $this->user,
                'planName'  => $this->planName,
                'amount'    => $this->amount,
                'posted_at' => $this->posted_at,
                'txUrl'     => url('/account/transactions'),
            ]);
    }
}

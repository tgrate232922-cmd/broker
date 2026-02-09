<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Withdrawal;

class WithdrawalEventMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Models\User */
    public $user;

    /** @var \App\Models\Withdrawal */
    public $withdrawal;

    /** @var string */
    public $subjectLine;

    /** @var \Illuminate\Support\Carbon */
    public $posted_at;

    public function __construct(User $user, Withdrawal $withdrawal)
    {
        $this->user       = $user;
        $this->withdrawal = $withdrawal;
        $this->posted_at  = now();
        $this->subjectLine = 'Withdrawal Request Received';
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.withdrawal.request')
            ->with([
                'appName'     => config('app.name', 'Online Banking'),
                'currency'    => config('app.currency', 'USD'),
                'logoUrl'     => config('app.logo_url'),
                'supportEmail'=> config('mail.from.address', 'support@example.com'),

                'user'        => $this->user,
                'withdrawal'  => $this->withdrawal,
                'subjectLine' => $this->subjectLine,
                'posted_at'   => $this->posted_at,

                'detailsUrl'  => url('/account/transactions'),
            ]);
    }
}

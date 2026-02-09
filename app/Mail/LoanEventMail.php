<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Loan;

class LoanEventMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Models\User */
    public $user;

    /** @var \App\Models\Loan */
    public $loan;

    /** @var string  user|admin */
    public $audience;

    /** @var string */
    public $subjectLine;

    /** @var string */
    public $ref;

    /** @var \Illuminate\Support\Carbon */
    public $posted_at;

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loan  $loan
     * @param  string $audience  'user' or 'admin'
     */
    public function __construct(User $user, Loan $loan, string $audience = 'user')
    {
        $this->user      = $user;
        $this->loan      = $loan;
        $this->audience  = $audience;
        $this->posted_at = now();

        $this->ref = 'LOAN-' . str_pad((string)$loan->id, 8, '0', STR_PAD_LEFT);

        $this->subjectLine = $audience === 'admin'
            ? 'New Loan Application Submitted'
            : 'Loan Application Received';
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.loan.event')
            ->with([
                'appName'      => config('app.name', 'Online Banking'),
                'logoUrl'      => config('app.logo_url'),
                'subjectLine'  => $this->subjectLine,
                'currency'     => config('app.currency', 'USD'),
                'supportEmail' => config('mail.from.address', 'support@example.com'),
                'detailsUrl'   => url('/account/loans'),

                'user'      => $this->user,
                'loan'      => $this->loan,
                'audience'  => $this->audience,
                'ref'       => $this->ref,
                'posted_at' => $this->posted_at,
            ]);
    }
}

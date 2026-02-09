<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminLoanStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loan;
    public $status;
    public $subjectLine;
    public $posted_at;
    public $reference;
    public $currency;
    public $appName;
    public $logoUrl;

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Loan $loan
     * @param string $status  e.g. Approved / Rejected
     * @param string|null $subjectLine
     * @param string|null $currency
     * @param string|null $logoUrl
     */
    public function __construct($user, $loan, string $status, ?string $subjectLine = null, ?string $currency = null, ?string $logoUrl = null)
    {
        $this->user        = $user;
        $this->loan        = $loan;
        $this->status      = $status;
        $state             = strtolower($status);
        $this->subjectLine = $subjectLine
            ?? ($state === 'approved' || $state === 'active' ? 'Loan Approved'
                : ($state === 'rejected' || $state === 'declined' ? 'Loan Rejected' : 'Loan Update'));
        $this->posted_at   = now();
        $this->reference   = 'LOAN-' . ($loan->id ?? uniqid());
        $this->currency    = $currency ?? ($user->currency ?? 'USD');
        $this->appName     = config('app.name');
        $this->logoUrl     = $logoUrl;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.loan.admin-loan-status');
    }
}

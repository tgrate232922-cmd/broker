<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminDepositStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $deposit;
    public $status;       // 'approved' | 'rejected' | 'updated'
    public $subjectLine;
    public $appName;
    public $logoUrl;
    public $currency;

    public function __construct($user, $deposit, $status = 'approved', $subjectLine = null, $appName = null, $logoUrl = null, $currency = null)
    {
        $this->user        = $user;
        $this->deposit     = $deposit;
        $this->status      = $status;
        $this->subjectLine = $subjectLine ?? ($status === 'approved' ? 'Deposit Approved' : ($status === 'rejected' ? 'Deposit Rejected' : 'Deposit Update'));
        $this->appName     = $appName ?? config('app.name', 'Online Banking');
        $this->logoUrl     = $logoUrl;
        $this->currency    = $currency ?? 'USD';
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.deposits.admin-deposit-status')
            ->with([
                'user'        => $this->user,
                'deposit'     => $this->deposit,
                'status'      => $this->status,
                'subjectLine' => $this->subjectLine,
                'appName'     => $this->appName,
                'logoUrl'     => $this->logoUrl,
                'currency'    => $this->currency,
                'reference'   => 'DEP-' . ($this->deposit->id ?? '0000'),
                'posted_at'   => $this->deposit->updated_at ?? $this->deposit->created_at,
            ]);
    }
}

<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminWithdrawalStatus extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Withdrawal $withdrawal,
        public string $status = 'approved', // 'approved' | 'rejected' | 'updated'
        public ?string $subjectLine = null,
        public ?string $reason = null,
        public ?string $currency = null,
        public ?string $appName = null,
        public ?string $logoUrl = null,      // ignored by template (no logo)
        public ?string $reference = null,
        public ?string $posted_at = null
    ) {}

    public function build()
    {
        $subject = $this->subjectLine ?? match (strtolower($this->status)) {
            'approved' => 'Withdrawal Approved',
            'rejected' => 'Withdrawal Rejected',
            default     => 'Withdrawal Update',
        };

        $ref = $this->reference ?: ('WTH-' . $this->withdrawal->id);

        return $this->subject($subject)
            ->view('emails.withdrawals.admin-withdrawal-status')
            ->with([
                'user'       => $this->user,
                'withdrawal' => $this->withdrawal,
                'status'     => $this->status,
                'subjectLine'=> $subject,
                'reason'     => $this->reason,
                'currency'   => $this->currency,
                'appName'    => $this->appName,
                'logoUrl'    => $this->logoUrl,
                'reference'  => $ref,
                'posted_at'  => $this->posted_at ?: now(),
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminKycStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $status;        // 'Verified' | 'Rejected'
    public $subjectLine;   // string (can be empty; will fallback)
    public $adminMessage;  // string (optional custom note from admin)
    public $brand;         // app name
    public $logoUrl;       // optional brand logo
    public $posted_at;     // Carbon

    /**
     * @param \App\Models\User $user
     */
    public function __construct($user, string $status, string $subjectLine = '', string $adminMessage = '')
    {
        $this->user         = $user;
        $this->status       = $status;
        $this->subjectLine  = trim($subjectLine) !== '' ? $subjectLine : "KYC Verification {$status}";
        $this->adminMessage = $adminMessage;
        $this->brand        = config('app.name', 'Online Banking');
        $this->logoUrl      = config('app.logo_url', null);
        $this->posted_at    = now();
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.kyc-status')
            ->with([
                'user'         => $this->user,
                'status'       => $this->status,
                'subjectLine'  => $this->subjectLine,
                'adminMessage' => $this->adminMessage,
                'appName'      => $this->brand,
                'logoUrl'      => $this->logoUrl,
                'posted_at'    => $this->posted_at,
            ]);
    }
}

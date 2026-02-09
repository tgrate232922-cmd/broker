<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Contracts\Queue\ShouldQueue;

class KycStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $kyc;
    public $status;     // 'under_review' | 'approved' | 'rejected'
    public $ref;        // string
    public $posted_at;  // \Illuminate\Support\Carbon

    public function __construct($user, $kyc, string $status, ?string $ref = null)
    {
        $this->user      = $user;
        $this->kyc       = $kyc;
        $this->status    = $status;
        $this->ref       = $ref ?: ('KYC-' . str_pad((string)$kyc->id, 8, '0', STR_PAD_LEFT));
        $this->posted_at = now();
    }

    public function build()
    {
        // Subjects: use colons (no dashes)
        $subjects = [
            'under_review' => 'KYC Update: Application Received',
            'approved'     => 'KYC Update: Application Approved',
            'rejected'     => 'KYC Update: Application Decision',
        ];
        $subject = $subjects[$this->status] ?? 'KYC Update: Application Status';

        return $this->subject($subject)
            ->view('emails.kyc.status')
            ->with([
                'user'         => $this->user,
                'kyc'          => $this->kyc,
                'status'       => $this->status,
                'ref'          => $this->ref,
                'posted_at'    => $this->posted_at,
                'appName'      => config('app.name', 'Online Banking'),
                'logoUrl'      => config('app.logo_url'),    // optional
                'portalUrl'    => url('/account/kyc'),       // adjust if needed
                'supportEmail' => config('mail.from.address', 'support@example.com'),
            ]);
    }
}

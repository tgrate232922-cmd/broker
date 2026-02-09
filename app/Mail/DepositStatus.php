<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class DepositStatus extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Models\Deposit */
    public $deposit;

    /** @var \App\Models\User */
    public $userModel;

    /** @var string */
    public $subjectLine;

    /** @var bool */
    public $isAdmin;

    /** @var string */
    public $ref;

    /** @var string|null */
    public $proofUrl;

    public function __construct(Deposit $deposit, User $user, string $subjectLine = 'Deposit Update', bool $isAdmin = false)
    {
        $this->deposit     = $deposit;
        $this->userModel   = $user;
        $this->subjectLine = $subjectLine;
        $this->isAdmin     = $isAdmin;

        // DP reference (human-friendly)
        $this->ref = 'DP-' . str_pad((string)($deposit->id ?? 0), 8, '0', STR_PAD_LEFT);

        // Public URL to proof (if stored on 'public' disk)
        $this->proofUrl = !empty($deposit->proof)
            ? (Storage::disk('public')->exists($deposit->proof) ? Storage::disk('public')->url($deposit->proof) : null)
            : null;
    }

    public function build()
    {
        // Use the subject exactly as passed from your controller
        return $this->subject($this->subjectLine)
            ->view('emails.deposits.status')
            ->with([
                'brand'         => config('app.name', 'Online Banking'),
                'logoUrl'       => config('app.logo_url'), // optional
                'isAdmin'       => $this->isAdmin,

                'ref'           => $this->ref,
                'amount'        => (float) ($this->deposit->amount ?? 0),
                'currency'      => config('app.currency', 'USD'),
                'payment_mode'  => (string) ($this->deposit->payment_mode ?? 'N/A'),
                'status'        => (string) ($this->deposit->status ?? 'Pending'),
                'proofUrl'      => $this->proofUrl,
                'submitted_at'  => $this->deposit->created_at ?? now(),

                'userFullName'  => trim(($this->userModel->first_name ?? '').' '.($this->userModel->last_name ?? '')) ?: ($this->userModel->name ?? $this->userModel->username ?? 'Customer'),
                'userEmail'     => (string) ($this->userModel->email ?? ''),

                // Portals
                'userPortalUrl'  => url('/account/deposits'),
                'adminPortalUrl' => url('/admin/dashboard/deposits/'.($this->deposit->id ?? '')),

                'supportEmail'  => config('mail.from.address', 'support@example.com'),
                'subjectLine'   => $this->subjectLine,
            ]);
    }
}

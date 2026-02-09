<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Investment;

class InvestmentEventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $investment;
    public $event;       // investment_purchased | investment_cancelled
    public $subjectLine;
    public $ref;
    public $posted_at;

    public function __construct(User $user, Investment $investment, string $event)
    {
        $this->user       = $user;
        $this->investment = $investment->loadMissing('dplan');
        $this->event      = $event;

        $subjects = [
            'investment_purchased' => 'DAO pool Update: Active',
            'investment_cancelled' => 'DAO pool Update: Cancelled',
        ];
        $this->subjectLine = $subjects[$event] ?? 'DAO pool Update: Pool Activity';

        $this->ref       = 'INV-' . str_pad((string)$investment->id, 8, '0', STR_PAD_LEFT);
        $this->posted_at = now();
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.investment.event')
            ->with([
                'appName'      => config('app.name', ''),
                'logoUrl'      => config('app.logo_url'),
                'subjectLine'  => $this->subjectLine,
                'ref'          => $this->ref,
                'posted_at'    => $this->posted_at,
                'detailsUrl'   => url('/account/plans'),
                'currency'     => config('app.currency', 'USD'),
                'supportEmail' => config('mail.from.address', 'support@example.com'),

                'user'         => $this->user,
                'planName'     => optional($this->investment->dplan)->name ?? 'Staking Pool',
                'amount'       => (float)($this->investment->amount ?? 0),
                'status'       => ($this->event === 'investment_cancelled') ? 'Cancelled' : 'Active',
                'activated_at' => $this->investment->activated_at,
                'expires_at'   => $this->investment->expire_date,
            ]);
    }
}

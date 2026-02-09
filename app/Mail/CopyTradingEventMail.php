<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\User_copytradings;

class CopyTradingEventMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Models\User */
    public $user;

    /** @var \App\Models\User_copytradings */
    public $copyTrade;

    /** @var string  'started'|'stopped'|'profit' */
    public $event;

    /** @var array  extra numbers like ['profit' => 12.34, 'total_return' => 100.00] */
    public $extras;

    /** @var string */
    public $subjectLine;

    /** @var string */
    public $ref;

    /** @var \Illuminate\Support\Carbon */
    public $posted_at;

    /**
     * @param  \App\Models\User              $user
     * @param  \App\Models\User_copytradings $copyTrade
     * @param  string                        $event        'started' | 'stopped' | 'profit'
     * @param  array                         $extras       Optional: ['profit'=>..., 'total_return'=>..., 'current_balance'=>...]
     */
    public function __construct(User $user, User_copytradings $copyTrade, string $event, array $extras = [])
    {
        $this->user      = $user;
        $this->copyTrade = $copyTrade->loadMissing('expert');
        $this->event     = $event;
        $this->extras    = $extras;
        $this->posted_at = now();

        $name = $this->copyTrade->name ?? optional($this->copyTrade->expert)->name ?? 'Expert';
        $map  = [
            'started' => "Copy Trading Started – {$name}",
            'stopped' => "Copy Trading Stopped – {$name}",
            'profit'  => "Copy Trading Profit – {$name}",
        ];
        $this->subjectLine = $map[$event] ?? "Copy Trading Update – {$name}";

        $this->ref = 'CPY-' . str_pad((string)$this->copyTrade->id, 8, '0', STR_PAD_LEFT);
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.copytrading.event')
            ->with([
                'appName'       => config('app.name', 'Online Banking'),
                'currency'      => config('app.currency', 'USD'),
                'logoUrl'       => config('app.logo_url'),
                'supportEmail'  => config('mail.from.address', 'support@example.com'),

                'user'          => $this->user,
                'copyTrade'     => $this->copyTrade,
                'event'         => $this->event,
                'extras'        => $this->extras,
                'subjectLine'   => $this->subjectLine,
                'ref'           => $this->ref,
                'posted_at'     => $this->posted_at,

                // helpful links
                'dashboardUrl'  => url('/copy/dashboard'),
                'detailsUrl'    => url('/copy/details/'.$this->copyTrade->id),
            ]);
    }
}

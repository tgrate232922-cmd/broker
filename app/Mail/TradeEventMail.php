<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TradeEventMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Models\User */
    public $user;

    /** @var array */
    public $data; // asset, symbol, type, leverage, amount, expire_at, user_plan_id

    /** @var string */
    public $subjectLine;

    /** @var string */
    public $ref;

    /** @var \Illuminate\Support\Carbon */
    public $posted_at;

    /**
     * @param  \App\Models\User  $user
     * @param  array  $data  keys: user_plan_id, asset, symbol, type, leverage, amount, expire_at
     * @param  string $subjectLine
     */
    public function __construct(User $user, array $data, string $subjectLine = 'Trade Update: Order Opened')
    {
        $this->user        = $user;
        $this->data        = $data;
        $this->subjectLine = $subjectLine;
        $this->ref         = 'TRD-' . str_pad((string)($data['user_plan_id'] ?? 0), 8, '0', STR_PAD_LEFT);
        $this->posted_at   = now();
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.trade.event')
            ->with([
                'appName'      => config('app.name', 'Online Banking'),
                'logoUrl'      => config('app.logo_url'),
                'subjectLine'  => $this->subjectLine,
                'ref'          => $this->ref,
                'posted_at'    => $this->posted_at,
                'detailsUrl'   => url('/account/trades'),
                'currency'     => config('app.currency', 'USD'),
                'supportEmail' => config('mail.from.address', 'support@example.com'),
                'user'         => $this->user,
                'asset'        => (string)($this->data['asset'] ?? ''),
                'symbol'       => (string)($this->data['symbol'] ?? ''),
                'type'         => (string)($this->data['type'] ?? ''),
                'leverage'     => (float)($this->data['leverage'] ?? 1),
                'amount'       => (float)($this->data['amount'] ?? 0),
                'expire_at'    => $this->data['expire_at'] ?? null,
                'status'       => 'Active',
            ]);
    }
}

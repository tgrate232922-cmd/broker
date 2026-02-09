<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AdminUserMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subjectLine;
    public $body;
    public $appName;
    public $posted_at;

    public function __construct($user, string $subjectLine, string $body, ?string $appName = null, ?Carbon $posted_at = null)
    {
        $this->user        = $user;
        $this->subjectLine = $subjectLine;
        $this->body        = $body;
        $this->appName     = $appName ?? config('app.name', 'Online Banking');
        $this->posted_at   = $posted_at ?? now();
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.admin-user-message')
            ->with([
                'user'        => $this->user,
                'subjectLine' => $this->subjectLine,
                'messageBody' => $this->body,
                'appName'     => $this->appName,
                'posted_at'   => $this->posted_at,
            ]);
    }
}

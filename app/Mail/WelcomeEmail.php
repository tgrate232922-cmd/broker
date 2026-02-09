<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $appName;
    public $posted_at;
    public $subjectLine;

    /**
     * @param \App\Models\User $user
     */
    public function __construct($user)
    {
        $this->user       = $user;
        $this->appName    = config('app.name', 'Online Banking');
        $this->posted_at  = now();
        $this->subjectLine = "Welcome to {$this->appName}";
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.welcome', [
                'user'        => $this->user,
                'appName'     => $this->appName,
                'posted_at'   => $this->posted_at,
                'subjectLine' => $this->subjectLine,
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Plan;
use App\Models\UserPlan;
use Illuminate\Support\Carbon;

class PlanCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plan;
    public $userPlan;
    public $posted_at;

    public function __construct(User $user, Plan $plan, UserPlan $userPlan)
    {
        $this->user      = $user;
        $this->plan      = $plan;
        $this->userPlan  = $userPlan;
        $this->posted_at = now();
    }

    public function build()
    {
        return $this->subject('DAO staking session completed')
            ->view('emails.plans.completed')
            ->with([
                'appName'   => config('app.name', 'Online Banking'),
                'currency'  => config('app.currency', 'USD'),
                'logoUrl'   => config('app.logo_url'),
                'user'      => $this->user,
                'plan'      => $this->plan,
                'userPlan'  => $this->userPlan,
                'posted_at' => $this->posted_at,
                'txUrl'     => url('/account/transactions'),
            ]);
    }
}

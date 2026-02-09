<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\Plan;

class PlanEventMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Models\User */
    public $user;

    /** @var \App\Models\UserPlan */
    public $userPlan;

    /** @var \App\Models\Plan|null */
    public $plan;

    /** @var string */
    public $event; // purchase_active | purchase_pending | payment_marked | plan_cancelled | compounding_updated | payout_processed | plan_completed

    /** @var array */
    public $data;

    /** @var string */
    public $ref;

    /** @var \Illuminate\Support\Carbon */
    public $posted_at;

    public function __construct(User $user, UserPlan $userPlan, string $event, array $data = [])
    {
        $this->user     = $user;
        $this->userPlan = $userPlan->loadMissing('plan');
        $this->plan     = $this->userPlan->plan;
        $this->event    = $event;
        $this->data     = $data;
        $this->ref      = 'PLAN-' . str_pad((string)($userPlan->id ?? 0), 8, '0', STR_PAD_LEFT);
        $this->posted_at = now();
    }

    public function build()
    {
        // Subjects (use colons, no dashes)
        $subjects = [
            'purchase_active'     => 'Plan Update: Purchase Confirmed',
            'purchase_pending'    => 'Plan Update: Payment Pending',
            'payment_marked'      => 'Plan Update: Payment Reference Received',
            'plan_cancelled'      => 'Plan Update: Plan Cancelled',
            'compounding_updated' => 'Plan Update: Compounding Updated',
            'payout_processed'    => 'Plan Update: Payout Processed',
            'plan_completed'      => 'Plan Update: Plan Completed',
        ];
        $subject = $subjects[$this->event] ?? 'Plan Update: Account Activity';

        // Compute a safe details URL (adjust route name if yours differs)
        $detailsUrl = route('user.plans.details', $this->userPlan->id);

        return $this->subject($subject)
            ->view('emails.plan.event')
            ->with([
                'appName'        => config('app.name', 'Online Banking'),
                'logoUrl'        => config('app.logo_url'),     // optional
                'subjectLine'    => $subject,
                'event'          => $this->event,
                'user'           => $this->user,
                'userPlan'       => $this->userPlan,
                'plan'           => $this->plan,
                'ref'            => $this->ref,
                'posted_at'      => $this->posted_at,
                'detailsUrl'     => $detailsUrl,
                // Handy fields for the template
                'invested'       => (float)$this->userPlan->invested_amount,
                'payment_method' => (string)($this->userPlan->payment_method ?? 'balance'),
                'status'         => (string)($this->userPlan->status ?? 'pending'),
                'activated_at'   => $this->userPlan->activated_at,
                'expires_at'     => $this->userPlan->expires_at,
                'expected_return'=> (float)($this->userPlan->expected_return ?? 0),
                'comp_enabled'   => (bool)($this->userPlan->compounding_enabled ?? false),
                'comp_percent'   => $this->userPlan->compounding_percentage,
                // Optional extras per event (e.g., payout amount/time)
                'extra'          => $this->data,
                'currency'       => config('app.currency', 'USD'),
                'supportEmail'   => config('mail.from.address', 'support@example.com'),
            ]);
    }
}

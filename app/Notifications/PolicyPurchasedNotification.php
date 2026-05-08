<?php

namespace App\Notifications;

use App\Models\Policy;
use App\Mail\PolicyIssuedMail;
use Illuminate\Notifications\Notification;

class PolicyPurchasedNotification extends Notification
{
    public $policy;

    public function __construct(Policy $policy)
    {
        $this->policy = $policy;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable)
    {
        // Reuse our existing premium Mailable which has the PDF generation logic!
        return (new PolicyIssuedMail($this->policy))->to($notifiable->email);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'purchase',
            'title'      => 'Policy Purchased',
            'message'    => 'Congratulations! Your ' . $this->policy->plan->name . ' is now active. Policy No: ' . $this->policy->policy_number,
            'action_url' => route('policy.show', $this->policy->id),
            'icon'       => 'bi-shield-check',
            'icon_color' => 'success',
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Policy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpcomingRenewalNotification extends Notification
{
    use Queueable;

    public $policy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Policy $policy)
    {
        $this->policy = $policy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Upcoming Policy Renewal - ' . $this->policy->plan->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('This is a friendly reminder that your ' . $this->policy->plan->name . ' insurance policy is due for renewal soon.')
            ->line('Policy Number: ' . $this->policy->policy_number)
            ->line('Expiration Date: ' . $this->policy->next_renewal_date->format('F d, Y'))
            ->action('Renew Now', route('policy.renew', $this->policy->id))
            ->line('Ensure continuous coverage by renewing your policy today.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'renewal',
            'title' => 'Policy Renewal Upcoming',
            'message' => 'Your ' . $this->policy->plan->name . ' policy is due for renewal on ' . $this->policy->next_renewal_date->format('M d, Y'),
            'action_url' => route('policy.renew', $this->policy->id),
            'icon' => 'bi-shield-exclamation',
            'icon_color' => 'warning'
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Claim;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimSubmittedNotification extends Notification
{
    use Queueable;

    public $claim;

    /**
     * Create a new notification instance.
     */
    public function __construct(Claim $claim)
    {
        $this->claim = $claim;
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
            ->subject('Claim Submitted Successfully - ' . $this->claim->claim_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We have received your claim request for policy ' . $this->claim->policy->policy_number . '.')
            ->line('Claim Number: ' . $this->claim->claim_number)
            ->line('Claim Amount: ₹' . number_format($this->claim->claim_amount, 2))
            ->line('Our team will review your claim and get back to you within 3-5 business days.')
            ->action('View Claim Status', route('home'))
            ->line('Thank you for choosing InsureMate.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'claim',
            'title' => 'Claim Submitted',
            'message' => 'Your claim ' . $this->claim->claim_number . ' has been received and is under review.',
            'action_url' => route('home'),
            'icon' => 'bi-file-medical',
            'icon_color' => 'info'
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Claim;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimStatusUpdatedNotification extends Notification
{
    public $claim;
    public $status;

    public function __construct(Claim $claim, string $status)
    {
        $this->claim  = $claim;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $isApproved = $this->status === 'approved';

        $subject = $isApproved
            ? '✅ Your Claim Has Been Approved - ' . $this->claim->claim_number
            : '❌ Update on Your Claim - ' . $this->claim->claim_number;

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.claim-status', [
                'claim'      => $this->claim,
                'status'     => $this->status,
                'isApproved' => $isApproved,
                'userName'   => $notifiable->name,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        $isApproved = $this->status === 'approved';

        return [
            'type'       => 'claim_update',
            'title'      => $isApproved ? 'Claim Approved 🎉' : 'Claim Update',
            'message'    => $isApproved
                            ? 'Your claim ' . $this->claim->claim_number . ' has been approved!'
                            : 'Your claim ' . $this->claim->claim_number . ' status has been updated to: ' . ucfirst($this->status),
            'action_url' => route('home'),
            'icon'       => $isApproved ? 'bi-check-circle-fill' : 'bi-x-circle-fill',
            'icon_color' => $isApproved ? 'success' : 'danger',
        ];
    }
}

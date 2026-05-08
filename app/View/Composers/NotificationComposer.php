<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\SupportTicket;
use App\Models\ContactMessage;
use App\Models\User;
use App\Models\Payment;

class NotificationComposer
{
    public function compose(View $view): void
    {
        $since = now()->subHours(48);

        // New open support tickets (unread = no admin reply yet)
        $newTickets = SupportTicket::with('user')
            ->whereNull('admin_reply')
            ->latest()
            ->take(5)
            ->get();

        // New contact messages (last 48h)
        $newContacts = ContactMessage::where('created_at', '>=', $since)
            ->latest()
            ->take(5)
            ->get();

        // New user registrations (last 48h)
        $newUsers = User::where('created_at', '>=', $since)
            ->latest()
            ->take(3)
            ->get();

        // Failed payments (last 48h)
        $failedPayments = Payment::with('user')
            ->where('status', 'failed')
            ->where('created_at', '>=', $since)
            ->latest()
            ->take(3)
            ->get();

        $totalNotifCount = $newTickets->count()
            + $newContacts->count()
            + $newUsers->count()
            + $failedPayments->count();

        $view->with(compact(
            'newTickets',
            'newContacts',
            'newUsers',
            'failedPayments',
            'totalNotifCount'
        ));
    }
}

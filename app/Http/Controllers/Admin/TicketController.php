<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\SupportTicket::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tickets = $query->get();
        $allTickets = \App\Models\SupportTicket::all();
        $totalCount = $allTickets->count();
        $openCount = $allTickets->where('status', 'open')->count();
        $pendingCount = $allTickets->whereIn('status', ['pending', 'resolved'])->count();
        $closedCount = $allTickets->where('status', 'closed')->count();

        return view('admin.tickets.index', compact(
            'tickets',
            'totalCount',
            'openCount',
            'pendingCount',
            'closedCount'
        ));
    }

    public function show(\App\Models\SupportTicket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\SupportTicket $ticket)
    {
        // If ticket already has a reply, only allow status updates (no new reply)
        if ($ticket->hasReply()) {
            $request->validate(['status' => 'required|in:open,closed,resolved,pending']);
            $ticket->update(['status' => $request->status]);
            return redirect()->route('admin.tickets.show', $ticket)
                ->with('success', 'Ticket status updated successfully.');
        }

        // First-time reply
        $request->validate([
            'reply_message' => 'required|string|min:5|max:5000',
            'status' => 'required|in:open,closed,resolved,pending',
        ]);

        $ticket->update([
            'admin_reply' => $request->reply_message,
            'replied_at' => now(),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', 'Reply sent to customer and ticket status updated.');
    }
}

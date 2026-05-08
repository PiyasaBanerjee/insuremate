<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = \App\Models\SupportTicket::where('user_id', \Illuminate\Support\Facades\Auth::id())->latest()->get();
        return view('frontend.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('frontend.tickets.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\SupportTicket::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Support ticket created successfully.');
    }

    public function show(\App\Models\SupportTicket $ticket)
    {
        if ($ticket->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }
        return view('frontend.tickets.show', compact('ticket'));
    }
}

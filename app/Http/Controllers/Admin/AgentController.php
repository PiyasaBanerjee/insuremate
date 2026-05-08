<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentCommission;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::with('user')->withCount('commissions')->orderByDesc('created_at')->paginate(20);
        return view('admin.agents.index', compact('agents'));
    }

    public function show(Agent $agent)
    {
        $agent->load(['user', 'commissions.policy', 'commissions.client', 'clients']);
        return view('admin.agents.show', compact('agent'));
    }

    public function approve(Agent $agent)
    {
        $agent->update(['status' => 'approved']);
        return back()->with('success', 'Agent ' . $agent->user->name . ' has been approved.');
    }

    public function reject(Request $request, Agent $agent)
    {
        $agent->update([
            'status' => 'rejected',
            'notes' => $request->input('notes'),
        ]);
        return back()->with('success', 'Agent ' . $agent->user->name . ' has been rejected.');
    }

    public function markPaid(Agent $agent)
    {
        // Mark all pending commissions as paid and clear the pending payout
        $agent->commissions()->where('status', 'pending')->update(['status' => 'paid']);
        $agent->update(['pending_payout' => 0]);
        return back()->with('success', 'Commissions marked as paid for ' . $agent->user->name . '.');
    }
}

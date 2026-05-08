<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentCommission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('agent')->only('index');
    }

    public function index()
    {
        $agent = auth()->user()->agent;

        $totalSales = $agent->commissions()->count();
        $totalEarned = $agent->total_earnings;
        $pendingPayout = $agent->pending_payout;
        $paidOut = $totalEarned - $pendingPayout;

        $recentCommissions = $agent->commissions()
            ->with(['policy', 'client'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $clients = $agent->clients()->withCount('policies')->orderByDesc('created_at')->take(10)->get();

        $referralLink = url('/register?ref=' . $agent->agent_code);

        return view('agent.dashboard', compact(
            'agent',
            'totalSales',
            'totalEarned',
            'pendingPayout',
            'paidOut',
            'recentCommissions',
            'clients',
            'referralLink'
        ));
    }

    public function applyForm()
    {
        return view('agent.apply');
    }

    public function applyStore(Request $request)
    {
        $user = auth()->user();

        if ($user->agent) {
            return back()->with('error', 'You have already submitted an agent application.');
        }

        $agent = Agent::create([
            'user_id' => $user->id,
            'agent_code' => 'AGT-' . strtoupper(substr(uniqid(), -6)),
            'status' => 'pending',
        ]);

        $user->update(['role' => 'agent']);

        return redirect()->route('home')
            ->with('success', 'Your agent application has been submitted! An admin will review and approve it shortly.');
    }
}

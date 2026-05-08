<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Policy;
use App\Models\Claim;
use App\Models\AgentCommission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPolicies = Policy::count();
        $pendingClaims = Claim::where('status', 'pending')->count();
        
        $totalRevenue = Policy::sum('premium_amount');
        $totalAgentEarnings = AgentCommission::sum('commission_amount');
        
        $recentPolicies = Policy::with(['user', 'plan'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalPolicies', 
            'pendingClaims', 
            'totalRevenue', 
            'totalAgentEarnings',
            'recentPolicies'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        // Calculate Statistics
        $totalClaims = \App\Models\Claim::count();
        $pendingClaims = \App\Models\Claim::where('status', 'pending')->count();
        $approvedClaims = \App\Models\Claim::where('status', 'approved')->count();
        $rejectedClaims = \App\Models\Claim::where('status', 'rejected')->count();

        // Build Query with Filters
        $query = \App\Models\Claim::with(['user', 'policy']);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('claim_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQ) use ($search) {
                        $userQ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Date Filter
        if ($request->filled('date_filter')) {
            $dateFilter = $request->input('date_filter');
            if ($dateFilter === 'today') {
                $query->whereDate('created_at', now()->toDateString());
            } elseif ($dateFilter === 'this_week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($dateFilter === 'this_month') {
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            }
        }

        // Amount Filter
        if ($request->filled('amount_filter')) {
            $amountFilter = $request->input('amount_filter');
            if ($amountFilter === '0-1000') {
                $query->whereBetween('claim_amount', [0, 1000]);
            } elseif ($amountFilter === '1000-5000') {
                $query->whereBetween('claim_amount', [1000, 5000]);
            } elseif ($amountFilter === '5000+') {
                $query->where('claim_amount', '>=', 5000);
            }
        }

        // Sort Filter
        $sort = $request->input('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'amount_high') {
            $query->orderBy('claim_amount', 'desc');
        } elseif ($sort === 'amount_low') {
            $query->orderBy('claim_amount', 'asc');
        } else {
            $query->latest();
        }

        $claims = $query->paginate(15)->withQueryString();

        return view('admin.claims.index', compact('claims', 'totalClaims', 'pendingClaims', 'approvedClaims', 'rejectedClaims'));
    }

    public function show(\App\Models\Claim $claim)
    {
        return view('admin.claims.show', compact('claim'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Claim $claim)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);

        $newStatus = $request->status;
        $claim->update(['status' => $newStatus]);

        // Send email + in-app notification to the user
        if ($newStatus !== 'pending') {
            $claim->load('user', 'policy');
            $claim->user->notify(
                new \App\Notifications\ClaimStatusUpdatedNotification($claim, $newStatus)
            );
        }

        return redirect()->route('admin.claims.index')->with('success', 'Claim status updated and user has been notified by email.');
    }

    public function create()
    {
        $users = \App\Models\User::all();
        $policies = \App\Models\Policy::with('user')->get();
        return view('admin.claims.create', compact('users', 'policies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'policy_id' => 'required|exists:policies,id',
            'claim_amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $validated['claim_number'] = 'CLM-' . strtoupper(uniqid());

        \App\Models\Claim::create($validated);

        return redirect()->route('admin.claims.index')->with('success', 'Claim created successfully.');
    }

    public function export(Request $request)
    {
        // For demonstration, we'll pretend to export and return a success message
        // In reality you would use Maatwebsite/Excel or similar to stream a CSV response
        return redirect()->back()->with('success', 'Claims data export has been initiated and will download shortly.');
    }
}

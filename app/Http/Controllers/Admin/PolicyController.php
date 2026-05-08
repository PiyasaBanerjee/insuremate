<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Policy::with(['user', 'plan']);

        // Stats
        $totalPolicies = \App\Models\Policy::count();
        $activePolicies = \App\Models\Policy::where('status', 'active')->count();
        $expiringSoon = \App\Models\Policy::where('status', 'active')
            ->where('end_date', '<=', now()->addDays(30))
            ->count();

        // Calculate Total Revenue using the premium_amount column on policies
        $totalRevenue = \App\Models\Policy::where('status', 'active')->sum('premium_amount');

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('plan', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by Date Range (created_at or start_date)
        if ($request->filled('date_filter')) {
            $dateFilter = $request->input('date_filter');
            if ($dateFilter === 'today') {
                $query->whereDate('start_date', now()->toDateString());
            } elseif ($dateFilter === 'this_week') {
                $query->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($dateFilter === 'this_month') {
                $query->whereMonth('start_date', now()->month)->whereYear('start_date', now()->year);
            }
        }

        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        $allowedSortFields = ['id', 'start_date', 'end_date', 'created_at', 'status'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $policies = $query->paginate(10)->withQueryString();

        return view('admin.policies.index', compact(
            'policies',
            'totalPolicies',
            'activePolicies',
            'expiringSoon',
            'totalRevenue'
        ));
    }

    public function show(\App\Models\Policy $policy)
    {
        return view('admin.policies.show', compact('policy'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        $plans = \App\Models\InsurancePlan::where('is_active', true)->get();
        return view('admin.policies.create', compact('users', 'plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:insurance_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'premium_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,pending,expired,cancelled',
        ]);

        $validated['policy_number'] = 'POL-' . strtoupper(uniqid());
        $plan = \App\Models\InsurancePlan::find($request->plan_id);
        $validated['coverage_amount'] = $plan->coverage_amount;
        $validated['next_renewal_date'] = \Carbon\Carbon::parse($request->end_date)->addDay();

        \App\Models\Policy::create($validated);

        return redirect()->route('admin.policies.index')->with('success', 'Policy created successfully.');
    }

    public function edit(\App\Models\Policy $policy)
    {
        $users = \App\Models\User::all();
        $plans = \App\Models\InsurancePlan::where('is_active', true)->get();
        return view('admin.policies.edit', compact('policy', 'users', 'plans'));
    }

    public function update(Request $request, \App\Models\Policy $policy)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:insurance_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'premium_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,pending,expired,cancelled',
        ]);

        $policy->update($validated);

        return redirect()->route('admin.policies.index')->with('success', 'Policy updated successfully.');
    }

    public function resendDocument(Request $request, \App\Models\Policy $policy)
    {
        // In a real application, you would:
        // 1. Generate the PDF
        // 2. Queue an email to the user
        // Mail::to($policy->user->email)->send(new PolicyDocumentMail($policy));

        // For now, we simulate success
        return redirect()->back()->with('success', 'Policy document has been successfully queued for delivery to ' . ($policy->user ? $policy->user->email : 'the client') . '.');
    }
}

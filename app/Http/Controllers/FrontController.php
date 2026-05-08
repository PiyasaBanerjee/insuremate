<?php

namespace App\Http\Controllers;

use App\Models\InsuranceCategory;
use App\Models\InsurancePlan;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $categories = InsuranceCategory::where('is_active', true)->get();
        return view('frontend.home', compact('categories'));
    }

    public function category(Request $request, $slug)
    {
        $category = InsuranceCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $query = $category->plans()->where('is_active', true);

        // Filter by Price Range
        if ($request->has('min_premium') && $request->min_premium != '') {
            $query->where('base_premium', '>=', $request->min_premium);
        }
        if ($request->has('max_premium') && $request->max_premium != '') {
            $query->where('base_premium', '<=', $request->max_premium);
        }

        // Filter by Coverage
        if ($request->has('min_coverage') && $request->min_coverage != '') {
            $query->where('coverage_amount', '>=', $request->min_coverage);
        }

        $plans = $query->get();

        return view('frontend.category', compact('category', 'plans'));
    }

    public function showApplyForm(InsurancePlan $plan)
    {
        return view('frontend.apply', compact('plan'));
    }

    public function submitApplication(Request $request, InsurancePlan $plan)
    {
        // Simple application logic
        $policy = \App\Models\Policy::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'policy_number' => 'POL-' . strtoupper(uniqid()),
            'premium_amount' => $plan->base_premium,
            'coverage_amount' => $plan->coverage_amount,
            'start_date' => now(),
            'end_date' => now()->addYears($plan->duration_years),
            'status' => 'active',
            'next_renewal_date' => now()->addYear(),
        ]);

        return redirect()->route('home')->with('success', 'Policy purchased successfully!');
    }

    public function showPlan($slug)
    {
        $plan = InsurancePlan::where('slug', $slug)->firstOrFail();
        return view('frontend.plan', compact('plan'));
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function compare(Request $request)
    {
        $planIds = explode(',', $request->query('plans', ''));
        $plans = InsurancePlan::whereIn('id', $planIds)->limit(3)->get();

        return view('frontend.compare', compact('plans'));
    }
}

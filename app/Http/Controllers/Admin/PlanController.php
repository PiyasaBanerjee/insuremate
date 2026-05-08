<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsuranceCategory;
use App\Models\InsurancePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $query = InsurancePlan::with('category');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Premium Range Filter
        if ($request->filled('premium_range')) {
            $range = $request->premium_range;
            if ($range === '0-50') {
                $query->whereBetween('base_premium', [0, 50]);
            } elseif ($range === '51-100') {
                $query->whereBetween('base_premium', [51, 100]);
            } elseif ($range === '101+') {
                $query->where('base_premium', '>', 100);
            }
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        if ($sort === 'price_high') {
            $query->orderBy('base_premium', 'desc');
        } elseif ($sort === 'price_low') {
            $query->orderBy('base_premium', 'asc');
        } elseif ($sort === 'name_asc') {
            $query->orderBy('name', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $plans = $query->paginate(10)->withQueryString();

        $categories = InsuranceCategory::all();

        // Statistics
        $totalPlans = InsurancePlan::count();

        // Count by category name mapping
        $categoryStats = [];
        $colorClasses = ['info', 'success', 'warning', 'danger', 'primary', 'secondary'];
        $icons = ['bi-shield-check', 'bi-heart-pulse', 'bi-file-medical', 'bi-car-front', 'bi-airplane', 'bi-house'];

        foreach ($categories as $index => $cat) {
            $catName = strtolower($cat->name);
            $count = InsurancePlan::where('category_id', $cat->id)->count();

            // Assign some color and icon based on category name or index
            $color = $colorClasses[$index % count($colorClasses)];
            $icon = $icons[$index % count($icons)];

            if (str_contains($catName, 'life')) {
                $icon = 'bi-heart-pulse';
                $color = 'info';
            } elseif (str_contains($catName, 'health')) {
                $icon = 'bi-file-medical';
                $color = 'success';
            } elseif (str_contains($catName, 'car') || str_contains($catName, 'auto')) {
                $icon = 'bi-car-front';
                $color = 'warning';
            } elseif (str_contains($catName, 'travel')) {
                $icon = 'bi-airplane';
                $color = 'primary';
            }

            $categoryStats[] = (object) [
                'name' => $cat->name,
                'count' => $count,
                'color' => $color,
                'icon' => $icon
            ];
        }

        return view('admin.plans.index', compact(
            'plans',
            'categories',
            'totalPlans',
            'categoryStats'
        ));
    }

    public function create()
    {
        $categories = InsuranceCategory::all();
        return view('admin.plans.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:insurance_categories,id',
            'name' => 'required',
            'base_premium' => 'required|numeric',
            'coverage_amount' => 'required|numeric',
            'duration_years' => 'required|integer',
            'benefits' => 'nullable|string',
            'features' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('plans', 'public');
        }

        InsurancePlan::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'base_premium' => $request->base_premium,
            'coverage_amount' => $request->coverage_amount,
            'duration_years' => $request->duration_years,
            'benefits' => $request->benefits ? array_map('trim', explode(',', $request->benefits)) : [],
            'features' => $request->features ? array_map('trim', explode(',', $request->features)) : [],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(InsurancePlan $plan)
    {
        $categories = InsuranceCategory::all();
        return view('admin.plans.edit', compact('plan', 'categories'));
    }

    public function update(Request $request, InsurancePlan $plan)
    {
        $request->validate([
            'category_id' => 'required|exists:insurance_categories,id',
            'name' => 'required',
            'base_premium' => 'required|numeric',
            'coverage_amount' => 'required|numeric',
            'duration_years' => 'required|integer',
            'benefits' => 'nullable|string',
            'features' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imagePath = $plan->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('plans', 'public');
        }

        $plan->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'base_premium' => $request->base_premium,
            'coverage_amount' => $request->coverage_amount,
            'duration_years' => $request->duration_years,
            'benefits' => $request->benefits ? array_map('trim', explode(',', $request->benefits)) : [],
            'features' => $request->features ? array_map('trim', explode(',', $request->features)) : [],
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(InsurancePlan $plan)
    {
        if ($plan->image_path && Storage::disk('public')->exists($plan->image_path)) {
            Storage::disk('public')->delete($plan->image_path);
        }
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully.');
    }
}

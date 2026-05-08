<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsuranceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = InsuranceCategory::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:insurance_categories,name',
            'description' => 'nullable',
            'benefits' => 'nullable',
            'premium_info' => 'nullable',
        ]);

        InsuranceCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'benefits' => $request->benefits,
            'premium_info' => $request->premium_info,
            'image' => null, // Placeholder for file upload
            'is_active' => true,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(InsuranceCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, InsuranceCategory $category)
    {
        $request->validate([
            'name' => 'required|unique:insurance_categories,name,' . $category->id,
            'description' => 'nullable',
            'benefits' => 'nullable',
            'premium_info' => 'nullable',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'benefits' => $request->benefits,
            'premium_info' => $request->premium_info,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(InsuranceCategory $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}

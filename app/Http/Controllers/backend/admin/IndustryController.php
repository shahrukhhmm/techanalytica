<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::with('suggestedByVendor')->orderBy('name')->get();

        return view('backend.admin.content.industries.index', compact('industries'));
    }

    public function create()
    {
        $vendors = Vendor::with('user')->get();

        return view('backend.admin.content.industries.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:industries,slug',
            'description' => 'nullable|string',
            'suggested_by_vendor_id' => 'nullable|exists:vendors,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Industry::create($validated);

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry created successfully.');
    }

    public function edit(Industry $industry)
    {
        $vendors = Vendor::with('user')->get();

        return view('backend.admin.content.industries.edit', compact('industry', 'vendors'));
    }

    public function update(Request $request, Industry $industry)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:industries,slug,'.$industry->id,
            'description' => 'nullable|string',
            'suggested_by_vendor_id' => 'nullable|exists:vendors,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $industry->update($validated);

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry updated successfully.');
    }

    public function destroy(Industry $industry)
    {
        $industry->delete();

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry deleted successfully.');
    }
}

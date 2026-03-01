<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\PricingTier;
use Illuminate\Http\Request;

class PricingTierController extends Controller
{
    public function index()
    {
        $tiers = PricingTier::all();

        return view('backend.admin.content.pricing_tiers.index', compact('tiers'));
    }

    public function create()
    {
        return view('backend.admin.content.pricing_tiers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'monthly_price' => 'nullable|numeric|min:0',
            'annual_price' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        // Clean features array
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features']);
        }

        PricingTier::create($validated);

        return redirect()->route('admin.pricing_tiers.index')->with('success', 'Pricing tier created successfully.');
    }

    public function edit(PricingTier $pricing_tier)
    {
        return view('backend.admin.content.pricing_tiers.edit', compact('pricing_tier'));
    }

    public function update(Request $request, PricingTier $pricing_tier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'monthly_price' => 'nullable|numeric|min:0',
            'annual_price' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features']);
        }

        $pricing_tier->update($validated);

        return redirect()->route('admin.pricing_tiers.index')->with('success', 'Pricing tier updated successfully.');
    }

    public function destroy(PricingTier $pricing_tier)
    {
        $pricing_tier->delete();

        return redirect()->route('admin.pricing_tiers.index')->with('success', 'Pricing tier deleted successfully.');
    }
}

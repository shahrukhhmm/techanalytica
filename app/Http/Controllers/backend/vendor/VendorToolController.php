<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Industry;
use App\Models\PricingTier;
use App\Models\Tool;
use App\Models\ToolMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorToolController extends Controller
{
    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            return redirect()->route('dashboard.analytics')->with('error', 'No vendor profile associated with this account.');
        }

        $tools = Tool::where('vendor_id', $vendor->id)
            ->with(['tier'])
            ->latest()
            ->get();

        return view('backend.vendor.content.tools.index', compact('tools'));
    }

    public function show(Tool $tool)
    {
        if ($tool->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        $tool->load(['tier', 'categories', 'industries', 'media', 'reviews' => function ($query) {
            $query->latest()->take(10);
        }]);
        $tool->loadCount('reviews');

        return view('backend.vendor.content.tools.show', compact('tool'));
    }

    public function create()
    {
        $tiers = PricingTier::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $industries = Industry::orderBy('name')->get();

        return view('backend.vendor.content.tools.create', compact('tiers', 'categories', 'industries'));
    }

    public function store(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tools,slug',
            'ai_type' => 'nullable|string|max:255',
            'logo_url' => 'nullable|url|max:2048',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'pros' => 'nullable|array',
            'pros.*' => 'nullable|string',
            'cons' => 'nullable|array',
            'cons.*' => 'nullable|string',
            'website_url' => 'nullable|url',
            'pricing_structured' => 'nullable|array',
            'pricing_text' => 'nullable|string',
            'cta_type' => 'nullable|in:website,signup,demo,free_trial,contact_sales',
            'cta_url' => 'nullable|url',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'industries' => 'array',
            'industries.*' => 'exists:industries,id',
        ]);

        $validated['vendor_id'] = $vendor->id;
        $validated['status'] = 'draft';

        $basicTier = PricingTier::where('name', 'Free')->first();
        if ($basicTier) {
            $validated['tier_id'] = $basicTier->id;
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if (isset($validated['pros'])) {
            $validated['pros'] = array_values(array_filter($validated['pros']));
        }
        if (isset($validated['cons'])) {
            $validated['cons'] = array_values(array_filter($validated['cons']));
        }

        $tool = Tool::create($validated);

        if (isset($validated['categories'])) {
            $tool->categories()->sync($validated['categories']);
        }

        if (isset($validated['industries'])) {
            $tool->industries()->sync($validated['industries']);
        }

        if ($request->filled('media_screenshot_url')) {
            ToolMedia::create([
                'tool_id' => $tool->id,
                'type' => 'screenshot',
                'url' => $request->media_screenshot_url,
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('vendor.tools.index')->with('success', 'Tool created as draft. You can now submit it for editorial review.');
    }

    public function edit(Tool $tool)
    {
        if ($tool->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        $tiers = PricingTier::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $industries = Industry::orderBy('name')->get();

        return view('backend.vendor.content.tools.edit', compact('tool', 'tiers', 'categories', 'industries'));
    }

    public function update(Request $request, Tool $tool)
    {
        if ($tool->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tools,slug,' . $tool->id,
            'ai_type' => 'nullable|string|max:255',
            'logo_url' => 'nullable|url|max:2048',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'pros' => 'nullable|array',
            'pros.*' => 'nullable|string',
            'cons' => 'nullable|array',
            'cons.*' => 'nullable|string',
            'website_url' => 'nullable|url',
            'pricing_structured' => 'nullable|array',
            'pricing_text' => 'nullable|string',
            'cta_type' => 'nullable|in:website,signup,demo,free_trial,contact_sales',
            'cta_url' => 'nullable|url',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'industries' => 'array',
            'industries.*' => 'exists:industries,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if (isset($validated['pros'])) {
            $validated['pros'] = array_values(array_filter($validated['pros']));
        }
        if (isset($validated['cons'])) {
            $validated['cons'] = array_values(array_filter($validated['cons']));
        }

        if ($tool->status === 'published') {
            // Shadow update: store changes in pending_data
            $tool->update([
                'pending_data' => $validated,
                'has_pending_update' => true,
            ]);
            return redirect()->route('vendor.tools.index')->with('success', 'Changes saved and pending admin approval. Live product remains unchanged.');
        }

        $data = $validated;
        unset($data['categories'], $data['industries']);

        $tool->update($data);
        $tool->categories()->sync($request->input('categories', []));
        $tool->industries()->sync($request->input('industries', []));

        return redirect()->route('vendor.tools.index')->with('success', 'Tool updated successfully.');
    }

    public function submitForReview(Tool $tool)
    {
        if ($tool->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        if ($tool->status === 'draft') {
            $tool->update(['status' => 'pending']);
            return back()->with('success', 'Tool submitted for admin review.');
        }

        return back()->with('error', 'Only draft tools can be submitted for review.');
    }

    public function unpublish(Tool $tool)
    {
        if ($tool->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        if ($tool->status === 'published') {
            $tool->update(['status' => 'draft']);
            return back()->with('success', 'Tool unpublished and moved to drafts.');
        }

        return back()->with('error', 'Only published tools can be unpublished.');
    }

    public function destroy(Tool $tool)
    {
        if ($tool->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        $tool->delete();

        return redirect()->route('vendor.tools.index')->with('success', 'Tool deleted successfully.');
    }

    public function pricing(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $tools = $vendor->tools;
        if ($tools->isEmpty()) {
            return redirect()->route('vendor.tools.create')->with('info', 'Please create a product first before configuring pricing.');
        }

        $activeToolId = session('active_tool_id');
        $tool = $activeToolId ? $vendor->tools()->find($activeToolId) : $tools->first();
        if (!$tool) {
            $tool = $tools->first();
        }

        return view('backend.vendor.content.tools.pricing', compact('tool', 'tools'));
    }

    public function updatePricing(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $validated = $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'pricing_text' => 'nullable|string|max:255',
            'cta_type' => 'nullable|in:website,signup,demo,free_trial,contact_sales',
            'cta_url' => 'nullable|url|max:2048',
            'plan_names' => 'nullable|array',
            'plan_names.*' => 'nullable|string|max:100',
            'plan_prices' => 'nullable|array',
            'plan_prices.*' => 'nullable|string|max:50',
            'plan_features' => 'nullable|array',
            'plan_features.*' => 'nullable|string',
        ]);

        $tool = $vendor->tools()->findOrFail($validated['tool_id']);

        // Build structured pricing array
        $pricingStructured = [];
        if (!empty($validated['plan_names'])) {
            foreach ($validated['plan_names'] as $index => $planName) {
                if (!empty($planName)) {
                    $pricingStructured[] = [
                        'name' => $planName,
                        'price' => $validated['plan_prices'][$index] ?? 'Free',
                        'features' => !empty($validated['plan_features'][$index]) ? array_map('trim', explode("\n", $validated['plan_features'][$index])) : [],
                    ];
                }
            }
        }

        $updateData = [
            'pricing_text' => $validated['pricing_text'],
            'cta_type' => $validated['cta_type'] ?? 'website',
            'cta_url' => $validated['cta_url'],
            'pricing_structured' => $pricingStructured,
        ];

        if ($tool->status === 'published') {
            $pendingData = $tool->pending_data ?? [];
            $tool->update([
                'pending_data' => array_merge($pendingData, $updateData),
                'has_pending_update' => true,
            ]);
            return redirect()->back()->with('success', 'Pricing updates submitted for administrative review.');
        }

        $tool->update($updateData);
        return redirect()->back()->with('success', 'Product pricing and CTA details updated successfully.');
    }

    public function features(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $tools = $vendor->tools;
        if ($tools->isEmpty()) {
            return redirect()->route('vendor.tools.create')->with('info', 'Please create a product first before configuring features.');
        }

        $activeToolId = session('active_tool_id');
        $tool = $activeToolId ? $vendor->tools()->find($activeToolId) : $tools->first();
        if (!$tool) {
            $tool = $tools->first();
        }

        return view('backend.vendor.content.tools.features', compact('tool', 'tools'));
    }

    public function updateFeatures(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $validated = $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'pros' => 'nullable|array',
            'pros.*' => 'nullable|string',
            'cons' => 'nullable|array',
            'cons.*' => 'nullable|string',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
        ]);

        $tool = $vendor->tools()->findOrFail($validated['tool_id']);

        $pros = isset($validated['pros']) ? array_values(array_filter($validated['pros'])) : [];
        $cons = isset($validated['cons']) ? array_values(array_filter($validated['cons'])) : [];

        $updateData = [
            'pros' => $pros,
            'cons' => $cons,
            'short_description' => $validated['short_description'],
            'long_description' => $validated['long_description'],
        ];

        if ($tool->status === 'published') {
            $pendingData = $tool->pending_data ?? [];
            $tool->update([
                'pending_data' => array_merge($pendingData, $updateData),
                'has_pending_update' => true,
            ]);
            return redirect()->back()->with('success', 'Feature updates submitted for administrative review.');
        }

        $tool->update($updateData);
        return redirect()->back()->with('success', 'Product features, pros, and cons updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Industry;
use App\Models\PricingTier;
use App\Models\Tool;
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
            ->get();

        return view('backend.vendor.content.tools.index', compact('tools'));
    }

    public function show(Tool $tool)
    {
        // Ensure tool belongs to vendor
        if ($tool->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        $tool->load(['tier', 'categories', 'industries', 'reviews' => function($query) {
            $query->latest()->take(5);
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
        if (!$vendor) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tools,slug',
            'logo_url' => 'nullable|url|max:2048',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
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
        $validated['status'] = 'draft'; // Always start as draft
        
        // Use default basic tier initially
        $basicTier = PricingTier::where('name', 'Free')->first();
        if ($basicTier) {
            $validated['tier_id'] = $basicTier->id;
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tool = Tool::create($validated);

        if (isset($validated['categories'])) {
            $tool->categories()->sync($validated['categories']);
        }

        if (isset($validated['industries'])) {
            $tool->industries()->sync($validated['industries']);
        }

        return redirect()->route('vendor.tools.index')->with('success', 'Tool created as draft. You can now submit it for review.');
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
            'slug' => 'nullable|string|max:255|unique:tools,slug,'.$tool->id,
            'logo_url' => 'nullable|url|max:2048',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
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

        if ($tool->status === 'published') {
            // Shadow update: store changes in pending_data
            $tool->update([
                'pending_data' => $validated,
                'has_pending_update' => true
            ]);
            return redirect()->route('vendor.tools.index')->with('success', 'Changes saved and pending admin approval. Live product remains unchanged.');
        }

        // Draft/Pending: Update directly
        $tool->update($validated);
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
            return back()->with('success', 'Tool submitted for review.');
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

    public function compare()
    {
        $allTools = Tool::select('id', 'name')->orderBy('name')->get();

        return view('backend.vendor.content.tools.compare', compact('allTools'));
    }

    public function destroy(Tool $tool)
    {
        if ($tool->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }
        
        $tool->delete();

        return redirect()->route('vendor.tools.index')->with('success', 'Tool deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Industry;
use App\Models\PricingTier;
use App\Models\Tool;
use App\Models\ToolMedia;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $tools = Tool::with(['vendor', 'tier', 'categories'])->latest()->get();

        return view('backend.admin.content.tools.index', compact('tools'));
    }

    public function show(Tool $tool)
    {
        $tool->load(['vendor', 'tier', 'categories', 'industries', 'media', 'reviews' => function ($query) {
            $query->latest()->take(10);
        }]);
        $tool->loadCount('reviews');

        return view('backend.admin.content.tools.show', compact('tool'));
    }

    public function create()
    {
        $vendors = Vendor::orderBy('company_name')->get();
        $tiers = PricingTier::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $industries = Industry::orderBy('name')->get();

        return view('backend.admin.content.tools.create', compact('vendors', 'tiers', 'categories', 'industries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tools,slug',
            'vendor_id' => 'nullable|exists:vendors,id',
            'tier_id' => 'nullable|exists:pricing_tiers,id',
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
            'status' => 'required|in:draft,pending,published,archived',
            'is_featured' => 'boolean',
            'rank' => 'integer',
            'is_verified' => 'boolean',
            'is_locked' => 'boolean',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'industries' => 'array',
            'industries.*' => 'exists:industries,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
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

        // Handle Media Screenshot URL if provided
        if ($request->filled('media_screenshot_url')) {
            ToolMedia::create([
                'tool_id' => $tool->id,
                'type' => 'screenshot',
                'url' => $request->media_screenshot_url,
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('admin.tools.index')->with('success', 'Tool created successfully.');
    }

    public function edit(Tool $tool)
    {
        $vendors = Vendor::orderBy('company_name')->get();
        $tiers = PricingTier::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $industries = Industry::orderBy('name')->get();

        return view('backend.admin.content.tools.edit', compact('tool', 'vendors', 'tiers', 'categories', 'industries'));
    }

    public function update(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tools,slug,' . $tool->id,
            'vendor_id' => 'nullable|exists:vendors,id',
            'tier_id' => 'nullable|exists:pricing_tiers,id',
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
            'status' => 'required|in:draft,pending,published,archived',
            'is_featured' => 'boolean',
            'rank' => 'integer',
            'is_verified' => 'boolean',
            'is_locked' => 'boolean',
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

        if ($validated['status'] === 'published' && !$tool->published_at) {
            $validated['published_at'] = now();
        }

        $data = $validated;
        unset($data['categories'], $data['industries']);

        $tool->update($data);

        $tool->categories()->sync($request->input('categories', []));
        $tool->industries()->sync($request->input('industries', []));

        return redirect()->route('admin.tools.index')->with('success', 'Tool updated successfully.');
    }

    public function pendingUpdates()
    {
        $tools = Tool::where('has_pending_update', true)->with(['vendor', 'tier', 'categories', 'industries'])->get();
        $allCategories = Category::pluck('name', 'id')->toArray();
        $allIndustries = Industry::pluck('name', 'id')->toArray();

        return view('backend.admin.content.tools.pending-updates', compact('tools', 'allCategories', 'allIndustries'));
    }

    public function approveUpdate(Tool $tool)
    {
        if (!$tool->has_pending_update || empty($tool->pending_data)) {
            return back()->with('error', 'No pending update found for this tool.');
        }

        $data = $tool->pending_data;
        $categories = $data['categories'] ?? [];
        $industries = $data['industries'] ?? [];

        unset($data['categories'], $data['industries']);

        $tool->update($data);

        $tool->categories()->sync($categories);
        $tool->industries()->sync($industries);

        $tool->update([
            'pending_data' => null,
            'has_pending_update' => false,
        ]);

        return redirect()->route('admin.tools.index')->with('success', 'Tool update approved and applied.');
    }

    public function rejectUpdate(Tool $tool)
    {
        if (!$tool->has_pending_update) {
            return back()->with('error', 'No pending update found for this tool.');
        }

        $tool->update([
            'pending_data' => null,
            'has_pending_update' => false,
        ]);

        return redirect()->route('admin.tools.pending-updates')->with('success', 'Pending update rejected and discarded.');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();

        return redirect()->route('admin.tools.index')->with('success', 'Tool deleted successfully.');
    }

    public function compare()
    {
        $allTools = Tool::select('id', 'name')->orderBy('name')->get();

        return view('backend.admin.content.tools.compare', compact('allTools'));
    }

    public function toggleFeatured(Tool $tool)
    {
        $tool->update(['is_featured' => !$tool->is_featured]);
        $status = $tool->is_featured ? 'marked as Featured' : 'unmarked from Featured';
        return redirect()->back()->with('success', "Tool {$tool->name} has been {$status}.");
    }
}

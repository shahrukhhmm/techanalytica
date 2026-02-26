<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Industry;
use App\Models\PricingTier;
use App\Models\Tool;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ToolController extends Controller
{
    public function index(Request $request)
    {

        $tools = Tool::with(['vendor', 'tier'])->select('tools.*')->get();

        return view('backend.admin.content.tools.index', compact('tools'));
    }

    public function show(Tool $tool)
    {
        $tool->load(['vendor', 'tier', 'categories', 'industries']);

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
            'logo_url' => 'nullable|url|max:2048',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'website_url' => 'nullable|url',
            'pricing_structured' => 'nullable|array',
            'pricing_text' => 'nullable|string',
            'cta_type' => 'nullable|in:website,signup,demo,free_trial,contact_sales',
            'cta_url' => 'nullable|url',
            'status' => 'required|in:draft,pending,published,archived',
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

        $tool = Tool::create($validated);

        if (isset($validated['categories'])) {
            $tool->categories()->sync($validated['categories']);
        }

        if (isset($validated['industries'])) {
            $tool->industries()->sync($validated['industries']);
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
            'slug' => 'nullable|string|max:255|unique:tools,slug,'.$tool->id,
            'vendor_id' => 'nullable|exists:vendors,id',
            'tier_id' => 'nullable|exists:pricing_tiers,id',
            'logo_url' => 'nullable|url|max:2048',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'website_url' => 'nullable|url',
            'pricing_structured' => 'nullable|array',
            'pricing_text' => 'nullable|string',
            'cta_type' => 'nullable|in:website,signup,demo,free_trial,contact_sales',
            'cta_url' => 'nullable|url',
            'status' => 'required|in:draft,pending,published,archived',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'industries' => 'array',
            'industries.*' => 'exists:industries,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($validated['status'] === 'published' && ! $tool->published_at) {
            $validated['published_at'] = now();
        }

        $tool->update($validated);

        $tool->categories()->sync($request->input('categories', []));
        $tool->industries()->sync($request->input('industries', []));

        return redirect()->route('admin.tools.index')->with('success', 'Tool updated successfully.');
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
}

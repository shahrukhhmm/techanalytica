<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VendorBlogController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) abort(403);

        $blogs = Blog::where('vendor_id', $vendor->id)->latest()->get();
        return view('backend.vendor.content.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('backend.vendor.content.blogs.create');
    }

    public function store(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            // Default to draft or pending for vendors
            'status' => 'required|in:draft,published', 
        ]);

        $validated['vendor_id'] = $vendor->id;
        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('blogs', 'public');
            $validated['og_image'] = $path;
        }

        Blog::create($validated);

        return redirect()->route('vendor.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        if ($blog->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }
        return view('backend.vendor.content.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        if ($blog->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('og_image')) {
            // Delete old image
            if ($blog->og_image) {
                Storage::disk('public')->delete($blog->og_image);
            }
            $path = $request->file('og_image')->store('blogs', 'public');
            $validated['og_image'] = $path;
        }

        $blog->update($validated);

        return redirect()->route('vendor.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        if ($blog->og_image) {
            Storage::disk('public')->delete($blog->og_image);
        }
        
        $blog->delete();

        return redirect()->route('vendor.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}

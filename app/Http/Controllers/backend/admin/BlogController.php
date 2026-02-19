<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('author')->latest()->get();
        return view('backend.admin.content.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('backend.admin.content.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['author_id'] = auth()->id();

        if ($request->hasFile('og_image')) {
            $imageName = time() . '.' . $request->og_image->extension();
            $request->og_image->move(public_path('uploads/blogs'), $imageName);
            $validated['og_image'] = 'uploads/blogs/' . $imageName;
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('backend.admin.content.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->title);

        if ($request->hasFile('og_image')) {
            // Delete old image
            if ($blog->og_image && File::exists(public_path($blog->og_image))) {
                File::delete(public_path($blog->og_image));
            }

            $imageName = time() . '.' . $request->og_image->extension();
            $request->og_image->move(public_path('uploads/blogs'), $imageName);
            $validated['og_image'] = 'uploads/blogs/' . $imageName;
        }

        if ($validated['status'] === 'published' && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->og_image && File::exists(public_path($blog->og_image))) {
            File::delete(public_path($blog->og_image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // Load categories with parent and children count, ordered by parent_id and weight (for table)
        $categories = Category::with('parent')
            ->withCount('children')
            ->orderByRaw('COALESCE(parent_id, id)')
            ->orderBy('weight')
            ->orderBy('name')
            ->get();

        // Load root categories with their children (for hierarchical dropdown)
        $rootCategories = Category::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->orderBy('weight')->orderBy('name');
            }])
            ->orderBy('weight')
            ->orderBy('name')
            ->get();
        
        return view('backend.admin.content.categories.index', compact('categories', 'rootCategories'));
    }

    public function create(Request $request)
    {
        // Load all categories for the parent dropdown, ordered by hierarchy
        $categories = Category::with('parent')
            ->orderByRaw('COALESCE(parent_id, id)')
            ->orderBy('name')
            ->get();
        
        // Check if parent_id is provided in query string (for quick subcategory creation)
        $parentCategory = null;
        if ($request->has('parent_id')) {
            $parentCategory = Category::find($request->parent_id);
        }
        
        return view('backend.admin.content.categories.create', compact('categories', 'parentCategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'weight' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        // Get all categories except this one and its descendants (to prevent circular references)
        $descendantIds = $category->getAllDescendants()->pluck('id')->toArray();
        $excludeIds = array_merge([$category->id], $descendantIds);
        
        $categories = Category::with('parent')
            ->whereNotIn('id', $excludeIds)
            ->orderByRaw('COALESCE(parent_id, id)')
            ->orderBy('name')
            ->get();
        
        return view('backend.admin.content.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    if ($value) {
                        // Prevent setting self as parent
                        if ($value == $category->id) {
                            $fail('A category cannot be its own parent.');
                            return;
                        }
                        
                        // Prevent circular references (setting a descendant as parent)
                        if ($category->hasDescendant($value)) {
                            $fail('Cannot set a subcategory as the parent of its ancestor.');
                        }
                    }
                },
            ],
            'weight' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}

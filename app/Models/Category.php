<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'weight',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'tool_category');
    }

    /**
     * Get the full hierarchy path for this category
     * Example: "Parent > Child > Grandchild"
     */
    public function getHierarchyPath($separator = ' > ')
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode($separator, $path);
    }

    /**
     * Get all descendants (children, grandchildren, etc.) recursively
     */
    public function getAllDescendants()
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }

    /**
     * Check if a given category is a descendant of this category
     * Used to prevent circular references
     */
    public function hasDescendant($categoryId)
    {
        if ($this->id == $categoryId) {
            return true;
        }

        return $this->getAllDescendants()->contains('id', $categoryId);
    }

    /**
     * Get the depth level of this category in the hierarchy
     * Root categories have depth 0
     */
    public function getDepth()
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }
}

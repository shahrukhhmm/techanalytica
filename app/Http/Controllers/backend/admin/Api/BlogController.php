<?php

namespace App\Http\Controllers\backend\admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('author')
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return response()->json($blogs);
    }

    public function show($slug)
    {
        $blog = Blog::with('author')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json($blog);
    }
}

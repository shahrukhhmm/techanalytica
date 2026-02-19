<?php

namespace App\Http\Controllers\backend\admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::with(['vendor', 'tier', 'categories', 'industries'])
            ->where('status', 'published')
            ->latest('published_at')
            ->get();

        return ToolResource::collection($tools);
    }

    public function show($slug)
    {
        $tool = Tool::with(['vendor', 'tier', 'categories', 'industries'])
            ->where('slug', $slug)
            ->firstOrFail();

        return new ToolResource($tool);
    }
}

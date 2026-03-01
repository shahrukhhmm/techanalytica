<?php

namespace App\Http\Controllers\backend\admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index($tool_id)
    {
        $reviews = Review::where('tool_id', $tool_id)
            ->where('status', 'approved')
            ->latest()
            ->get();

        return ReviewResource::collection($reviews);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tool_id' => 'required|exists:tools,id',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $review = Review::create([
            'tool_id' => $request->tool_id,
            'user_id' => auth()->id(), // null if guest
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending',
        ]);

        return new ReviewResource($review);
    }
}

<?php

namespace App\Http\Controllers\backend\admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $subscriber = Subscriber::create([
            'email' => $request->email,
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Successfully subscribed to the newsletter!',
            'data' => $subscriber
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class VendorReviewController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            return redirect()->route('dashboard.analytics')->with('error', 'No vendor profile associated with this account.');
        }

        $toolIds = $vendor->tools()->pluck('id');
        
        $reviews = Review::whereIn('tool_id', $toolIds)
            ->with('tool')
            ->latest()
            ->get();

        return view('backend.vendor.content.reviews.index', compact('reviews'));
    }
}

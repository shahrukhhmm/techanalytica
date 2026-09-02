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

    public function reply(Request $request, Review $review)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        // Verify that this review belongs to one of this vendor's tools
        if ($review->tool->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized to reply to this review.');
        }

        $validated = $request->validate([
            'vendor_reply' => 'required|string|max:2000',
        ]);

        $review->update([
            'vendor_reply' => $validated['vendor_reply'],
            'vendor_replied_at' => now(),
        ]);

        return back()->with('success', 'Your official response to the review has been published.');
    }
}

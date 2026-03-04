<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Category;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        return view('backend.vendor.content.submission.guidelines');
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.vendor.content.submission.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'description' => 'required|string',
            'deployment_options' => 'required|array',
            'category_id' => 'required|exists:categories,id',
            'target_market' => 'required|string',
            'company_size' => 'required|string',
            'is_ai_focused' => 'required|accepted',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('submissions/logos', 'public');
            $validated['logo_url'] = $path;
        }

        // Store in session for review
        session(['pending_submission' => $validated]);

        return redirect()->route('vendor.submit.review');
    }

    public function review()
    {
        $submission = session('pending_submission');
        if (!$submission) {
            return redirect()->route('vendor.submit.create');
        }

        $category = Category::find($submission['category_id'], ['*']);
        return view('backend.vendor.content.submission.review', compact('submission', 'category'));
    }

    public function confirm()
    {
        $submission = session('pending_submission');
        if (!$submission) {
            return redirect()->route('vendor.submit.create');
        }

        $submissionRecord = Submission::create([
            'vendor_id' => auth()->user()->vendor->id,
            'tool_name' => $submission['product_name'],
            'fields' => $submission,
            'status' => 'pending',
        ]);

        // Notify Vendor
        \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\SubmissionReceived($submissionRecord, false));
        
        // Notify Admin
        \Illuminate\Support\Facades\Mail::to('admin@techanalytica.com')->send(new \App\Mail\SubmissionReceived($submissionRecord, true));

        session()->forget('pending_submission');

        return redirect()->route('vendor.dashboard')->with('success', 'Your product listing request has been successfully submitted for review.');
    }
}

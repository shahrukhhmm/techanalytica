<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        $query = Tool::where('is_claimed', '=', false, 'and')->where('status', '=', 'published', 'and');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tools = $query->latest()->paginate(12);

        return view('backend.vendor.content.claim.index', compact('tools'));
    }

    public function create(Tool $tool)
    {
        if ($tool->is_claimed) {
            return redirect()->route('vendor.claim')->with('error', 'This product is already claimed.');
        }

        return view('backend.vendor.content.claim.create', compact('tool'));
    }

    public function store(Request $request, Tool $tool)
    {
        $request->validate([
            'business_email' => 'required|email',
            'reason' => 'required|string|min:20',
        ]);

        $vendor = auth()->user()->vendor;

        // Automation idea: If domain matches
        $toolDomain = parse_url($tool->website_url, PHP_URL_HOST);
        $emailDomain = substr(strrchr($request->business_email, "@"), 1);

        $status = 'pending';
        if (str_contains($toolDomain, $emailDomain)) {
            $status = 'approved';
            $tool->update(['is_claimed' => true, 'vendor_id' => $vendor->id]);
        }

        Claim::create([
            'tool_id' => $tool->id,
            'vendor_id' => $vendor->id,
            'status' => $status,
            'reason' => $request->reason . " (Email: " . $request->business_email . ")",
        ]);

        $claim = Claim::where('tool_id', '=', $tool->id, 'and')->where('vendor_id', '=', $vendor->id, 'and')->latest()->first();

        // Notify Vendor
        \Illuminate\Support\Facades\Mail::to($request->business_email)->send(new \App\Mail\ClaimSubmitted($claim, false));
        
        // Notify Admin
        \Illuminate\Support\Facades\Mail::to('admin@techanalytica.com')->send(new \App\Mail\ClaimSubmitted($claim, true));

        if ($status === 'approved') {
            return redirect()->route('vendor.dashboard')->with('success', 'Product claimed successfully! It is now linked to your account.');
        }

        return redirect()->route('vendor.dashboard')->with('success', 'Your claim has been submitted and is under review.');
    }
}

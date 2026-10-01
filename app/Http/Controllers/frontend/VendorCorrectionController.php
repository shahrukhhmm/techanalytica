<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\ReviewException;
use App\Models\Tool;
use App\Models\VendorCorrection;
use Illuminate\Http\Request;

/**
 * Handles the public "Report a factual error / Request re-evaluation" form.
 * Spec §12: creates VendorCorrection + ReviewException; no admin can directly
 * set a final TA Score; system recalculates after accepted correction.
 */
class VendorCorrectionController extends Controller
{
    public function create(Tool $tool)
    {
        return view('frontend.pages.tools.correction', compact('tool'));
    }

    public function store(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'correction_type'  => 'required|in:incorrect_info,feature_change,pricing_change,integration_change,security_compliance,category_fit,other',
            'claim'            => 'required|string|min:20|max:2000',
            'evidence_url'     => 'nullable|url|max:500',
            'evidence_file'    => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $filePath = $request->file('evidence_file')->store('corrections', 'public');
        }

        $correction = VendorCorrection::create([
            'tool_id'         => $tool->id,
            'submitter_id'    => auth()->id(),
            'correction_type' => $validated['correction_type'],
            'claim'           => $validated['claim'],
            'evidence_url'    => $validated['evidence_url'] ?? null,
            'evidence_file'   => $filePath,
            'status'          => 'pending',
        ]);

        // Auto-create a ReviewException so founders see it in the queue
        ReviewException::create([
            'tool_id'      => $tool->id,
            'trigger_type' => 'vendor_correction',
            'severity'     => 'medium',
            'description'  => "Vendor submitted a factual correction: {$validated['correction_type']}.",
            'status'       => 'open',
        ]);

        return back()->with('success', 'Your correction request has been submitted. We will review it and notify you of the outcome.');
    }
}

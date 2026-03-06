<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with('vendor')->latest()->get();
        return view('backend.admin.content.submissions.index', compact('submissions'));
    }

    public function show(Submission $submission)
    {
        return view('backend.admin.content.submissions.show', compact('submission'));
    }

    public function updateStatus(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        $submission->update($validated);

        if ($validated['status'] === 'approved') {
            // Logic to create a tool listing from submission
            $fields = $submission->fields;
            
            $toolData = [
                'name' => $submission->tool_name,
                'slug' => Str::slug($submission->tool_name),
                'vendor_id' => $submission->vendor_id,
                'status' => 'published',
                'published_at' => now(),
            ];

            // Map fields if they exist
            if (isset($fields['short_description'])) $toolData['short_description'] = $fields['short_description'];
            if (isset($fields['long_description'])) $toolData['long_description'] = $fields['long_description'];
            if (isset($fields['website_url'])) $toolData['website_url'] = $fields['website_url'];
            if (isset($fields['logo_url'])) $toolData['logo_url'] = $fields['logo_url'];

            $tool = Tool::create($toolData);

            return redirect()->route('admin.submissions.index')->with('success', 'Submission approved and Tool listing created.');
        }

        return back()->with('success', 'Submission status updated.');
    }

    public function destroy(Submission $submission)
    {
        $submission->delete();
        return redirect()->route('admin.submissions.index')->with('success', 'Submission deleted.');
    }
}

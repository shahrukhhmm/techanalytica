<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class VendorLeadController extends Controller
{
    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $toolIds = $vendor->tools()->pluck('id');

        $query = Lead::whereIn('tool_id', $toolIds)->with('tool');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leads = $query->latest()->paginate(15);

        return view('backend.vendor.content.leads.index', compact('leads'));
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor || $lead->tool->vendor_id !== $vendor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:new,contacted,qualified,closed',
        ]);

        $lead->update($validated);

        return back()->with('success', 'Lead status updated.');
    }

    public function export()
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $toolIds = $vendor->tools()->pluck('id');
        $leads = Lead::whereIn('tool_id', $toolIds)->with('tool')->latest()->get();

        $fileName = 'vendor_leads_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $callback = function() use ($leads) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Product', 'Name', 'Email', 'Company', 'Team Size', 'Intent Type', 'Status', 'Message', 'Date']);
            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->id,
                    $lead->tool->name,
                    $lead->name,
                    $lead->email,
                    $lead->company_name ?? 'N/A',
                    $lead->company_size ?? 'N/A',
                    $lead->intent_type,
                    $lead->status,
                    $lead->message,
                    $lead->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::with(['tool', 'vendor'])->latest()->get();
        return view('backend.admin.content.tools.claims.index', compact('claims'));
    }

    public function updateStatus(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $claim->update(['status' => $validated['status']]);

        // Logic to transfer tool ownership if status is approved could be added here

        return redirect()->back()->with('success', 'Claim status updated successfully.');
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->back()->with('success', 'Claim record deleted successfully.');
    }
}

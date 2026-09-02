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

        if ($validated['status'] === 'approved') {
            \Illuminate\Support\Facades\DB::transaction(function () use ($claim) {
                // Check if user account already exists or create new vendor user
                $email = $claim->work_email ?? $claim->email ?? ('vendor_' . $claim->id . '@example.com');
                $user = \App\Models\User::where('email', $email)->first();

                if (!$user) {
                    $randomPassword = \Illuminate\Support\Str::random(10);
                    $user = \App\Models\User::create([
                        'name' => $claim->full_name ?? $claim->contact_name ?? 'Vendor User',
                        'email' => $email,
                        'password' => \Illuminate\Support\Facades\Hash::make($randomPassword),
                    ]);
                }

                $vendor = \App\Models\Vendor::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'company_name' => $claim->company_name ?? ($claim->tool ? $claim->tool->name . ' Team' : 'Vendor Company'),
                        'company_website' => $claim->company_website ?? ($claim->tool ? $claim->tool->website_url : null),
                    ]
                );

                if ($claim->tool) {
                    $claim->tool->update([
                        'vendor_id' => $vendor->id,
                        'is_claimed' => true,
                    ]);
                }

                $claim->update(['vendor_id' => $vendor->id]);
            });
        }

        return redirect()->back()->with('success', 'Claim status updated successfully and vendor account provisioned.');
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->back()->with('success', 'Claim record deleted successfully.');
    }
}

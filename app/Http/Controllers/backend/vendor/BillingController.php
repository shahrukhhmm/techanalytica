<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\BillingTransaction;
use App\Models\PricingTier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    public function index()
    {
        $tiers = PricingTier::all();
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            return redirect()->route('dashboard.analytics')->with('error', 'No vendor profile associated with this account.');
        }

        $activeToolId = session('active_tool_id');
        $activeTool = $activeToolId ? $vendor->tools()->find($activeToolId) : $vendor->tools()->first();

        $transactions = BillingTransaction::where('vendor_id', $vendor->id)->latest()->take(10)->get();

        return view('backend.vendor.content.billing.index', compact('tiers', 'activeTool', 'transactions'));
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'tier_id' => 'required|exists:pricing_tiers,id',
        ]);

        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $tool = $vendor->tools()->findOrFail($validated['tool_id']);
        $tier = PricingTier::findOrFail($validated['tier_id']);

        $tool->update([
            'tier_id' => $tier->id,
            'is_featured' => $tier->is_featured ?? true,
        ]);

        BillingTransaction::create([
            'vendor_id' => $vendor->id,
            'tool_id' => $tool->id,
            'amount' => $tier->monthly_price ?? 0.00,
            'currency' => 'USD',
            'type' => 'upgrade',
            'status' => 'paid',
            'external_tx_id' => 'tx_' . Str::random(12),
        ]);

        return redirect()->back()->with('success', "Successfully upgraded to the {$tier->name} plan for {$tool->name}!");
    }
}

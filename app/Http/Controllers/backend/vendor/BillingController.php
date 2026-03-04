<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\PricingTier;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $tiers = PricingTier::all();
        $vendor = auth()->user()->vendor;
        $activeToolId = session('active_tool_id');
        $activeTool = $activeToolId ? $vendor->tools()->find($activeToolId) : $vendor->tools()->first();
        
        return view('backend.vendor.content.billing.index', compact('tiers', 'activeTool'));
    }
}

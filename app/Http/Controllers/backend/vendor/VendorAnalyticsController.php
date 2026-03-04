<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorAnalyticsController extends Controller
{
    public function index()
    {
        $activeToolId = session('active_tool_id');
        $vendor = auth()->user()->vendor;
        
        if (!$activeToolId || !$vendor) {
            return redirect()->route('vendor.tools.index')->with('warning', 'Please select a tool first.');
        }

        $tool = $vendor->tools()->find($activeToolId);

        return view('backend.vendor.content.analytics.index', compact('tool'));
    }
}

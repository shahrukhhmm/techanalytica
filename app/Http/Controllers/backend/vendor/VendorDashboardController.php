<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $tools = $vendor->tools;
        $activeToolId = session('active_tool_id');
        $activeTool = $activeToolId ? $vendor->tools()->find($activeToolId) : $tools->first();

        if ($activeTool && !$activeToolId) {
            session(['active_tool_id' => $activeTool->id]);
        }

        return view('backend.vendor.content.dashboard', compact('vendor', 'tools', 'activeTool'));
    }

    public function switchTool($id)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            abort(403);
        }

        $tool = $vendor->tools()->findOrFail($id);
        session(['active_tool_id' => $tool->id]);

        return redirect()->back()->with('success', 'Switched to tool: ' . $tool->name);
    }
}

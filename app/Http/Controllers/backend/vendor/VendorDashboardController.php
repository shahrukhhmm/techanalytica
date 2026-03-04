<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
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

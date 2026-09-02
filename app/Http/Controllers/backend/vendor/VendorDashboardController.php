<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;

        if (! $vendor) {
            abort(403);
        }

        $vendor->load(['tier', 'tools']);

        $vendorId = $vendor->id;
        $tools = $vendor->tools;

        // 1. Total Counts
        $totalTools = \App\Models\Tool::where('vendor_id', $vendorId)->count();

        // 2. Tools by Category
        $toolsByCategory = \App\Models\Category::whereHas('tools', function ($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        })
            ->withCount(['tools as tools_count' => function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            }])
            ->get();

        $categoryNames = $toolsByCategory->pluck('name')->toArray();
        $categoryCounts = $toolsByCategory->pluck('tools_count')->toArray();

        // 3. Tools Status
        $toolsStatusCounts = \App\Models\Tool::where('vendor_id', $vendorId)
            ->select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statuses = ['published', 'pending', 'rejected'];

        $statusCounts = [];
        foreach ($statuses as $status) {
            $statusCounts[] = $toolsStatusCounts[$status] ?? 0;
        }

        // 4. Claimed vs Unclaimed
        $claimedToolsCount = \App\Models\Tool::where('vendor_id', $vendorId)
            ->where('is_claimed', true)
            ->count();

        $unclaimedToolsCount = \App\Models\Tool::where('vendor_id', $vendorId)
            ->where('is_claimed', false)
            ->count();

        // 5. Tools Added Trend (Last 6 Months - Single Grouped Query)
        $startDate = \Carbon\Carbon::now()->subMonths(5)->startOfMonth();
        $monthlyData = \App\Models\Tool::where('vendor_id', $vendorId)
            ->where('created_at', '>=', $startDate)
            ->select(
                \Illuminate\Support\Facades\DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"),
                \Illuminate\Support\Facades\DB::raw('count(*) as total')
            )
            ->groupBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        $months = [];
        $toolsAddedCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = \Carbon\Carbon::now()->subMonths($i);
            $ym = $month->format('Y-m');
            $months[] = $month->format('M Y');
            $toolsAddedCounts[] = $monthlyData[$ym] ?? 0;
        }

        return view('backend.vendor.content.dashboard', compact(
            'vendor',
            'tools',
            'totalTools',
            'categoryNames',
            'categoryCounts',
            'statuses',
            'statusCounts',
            'claimedToolsCount',
            'unclaimedToolsCount',
            'months',
            'toolsAddedCounts'
        ));
    }

    public function profile()
    {
        $vendor = auth()->user()->vendor;

        return view('backend.vendor.content.profile', compact('vendor'));
    }

    public function switchTool($id)
    {
        $vendor = auth()->user()->vendor;
        if ($vendor) {
            $tool = $vendor->tools()->find($id);
            if ($tool) {
                session(['active_tool_id' => $tool->id]);
                return redirect()->back()->with('success', "Switched active product to {$tool->name}.");
            }
        }

        return redirect()->back()->with('error', 'Product not found in your inventory.');
    }
}

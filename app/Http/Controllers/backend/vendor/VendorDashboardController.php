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

        // 5. Tools Added Trend (Last 6 Months)
        $months = [];
        $toolsAddedCounts = [];

        for ($i = 5; $i >= 0; $i--) {

            $month = \Carbon\Carbon::now()->subMonths($i);

            $months[] = $month->format('M Y');

            $toolsAddedCounts[] = \App\Models\Tool::where('vendor_id', $vendorId)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
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
}

<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Lead;
use App\Models\Review;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;

        if (! $vendor) {
            abort(403, 'Unauthorized vendor account.');
        }

        $vendor->load(['tier']);
        $vendorId = $vendor->id;

        // 1. Fetch vendor's tools with relationships eager loaded (Single optimized query)
        $tools = Tool::where('vendor_id', $vendorId)
            ->with(['categories', 'tier'])
            ->get();

        $allToolIds = $tools->pluck('id')->toArray();
        $totalTools = $tools->count();

        // Active tool switcher / filter handling
        $requestedToolId = $request->query('tool_id');
        if ($requestedToolId !== null) {
            if ($requestedToolId === 'all') {
                session()->forget('active_tool_id');
                $activeToolId = 'all';
                $activeTool = null;
            } else {
                $found = $tools->firstWhere('id', (int) $requestedToolId);
                if ($found) {
                    session(['active_tool_id' => $found->id]);
                    $activeToolId = $found->id;
                    $activeTool = $found;
                } else {
                    $activeToolId = 'all';
                    $activeTool = null;
                }
            }
        } else {
            $sessToolId = session('active_tool_id');
            if ($sessToolId && $tools->firstWhere('id', $sessToolId)) {
                $activeToolId = $sessToolId;
                $activeTool = $tools->firstWhere('id', $sessToolId);
            } else {
                $activeToolId = 'all';
                $activeTool = null;
            }
        }

        // Targeted tool IDs for visitor stats
        $filterToolIds = $activeTool ? [$activeTool->id] : $allToolIds;

        // 2. Batch Aggregated Visitor & Telemetry Data (Zero N+1)
        $todayStart = Carbon::today()->toDateTimeString();
        $monthStart = Carbon::now()->startOfMonth()->toDateTimeString();

        $viewsByTool = [];
        $clicksByTool = [];
        $leadsByTool = [];
        $reviewsByTool = [];

        if (!empty($allToolIds)) {
            // Views & Unique Visitors grouped by tool
            $viewsByTool = AnalyticsEvent::whereIn('tool_id', $allToolIds)
                ->where('event_type', 'view')
                ->select(
                    'tool_id',
                    DB::raw('COUNT(*) as total_views'),
                    DB::raw('COUNT(DISTINCT COALESCE(session_id, id)) as unique_visitors'),
                    DB::raw("COUNT(CASE WHEN timestamp >= '{$todayStart}' THEN 1 END) as today_views"),
                    DB::raw("COUNT(CASE WHEN timestamp >= '{$monthStart}' THEN 1 END) as month_views")
                )
                ->groupBy('tool_id')
                ->get()
                ->keyBy('tool_id');

            // Clicks grouped by tool
            $clicksByTool = AnalyticsEvent::whereIn('tool_id', $allToolIds)
                ->whereIn('event_type', ['cta_click', 'click'])
                ->select('tool_id', DB::raw('COUNT(*) as total_clicks'))
                ->groupBy('tool_id')
                ->pluck('total_clicks', 'tool_id');

            // Leads grouped by tool
            $leadsByTool = Lead::whereIn('tool_id', $allToolIds)
                ->select('tool_id', DB::raw('COUNT(*) as total_leads'))
                ->groupBy('tool_id')
                ->pluck('total_leads', 'tool_id');

            // Reviews rating grouped by tool
            $reviewsByTool = Review::whereIn('tool_id', $allToolIds)
                ->where('status', 'approved')
                ->select(
                    'tool_id',
                    DB::raw('COUNT(*) as total_reviews'),
                    DB::raw('AVG(rating) as avg_rating')
                )
                ->groupBy('tool_id')
                ->get()
                ->keyBy('tool_id');
        }

        // 3. Compute View-Level KPI Totals (All tools or Selected tool)
        $totalViews = 0;
        $uniqueVisitors = 0;
        $todayViews = 0;
        $monthViews = 0;
        $totalClicks = 0;
        $totalLeads = 0;

        foreach ($filterToolIds as $tId) {
            if (isset($viewsByTool[$tId])) {
                $totalViews += (int) $viewsByTool[$tId]->total_views;
                $uniqueVisitors += (int) $viewsByTool[$tId]->unique_visitors;
                $todayViews += (int) $viewsByTool[$tId]->today_views;
                $monthViews += (int) $viewsByTool[$tId]->month_views;
            }
            $totalClicks += (int) ($clicksByTool[$tId] ?? 0);
            $totalLeads += (int) ($leadsByTool[$tId] ?? 0);
        }

        $conversionRate = $totalViews > 0
            ? round((($totalClicks + $totalLeads) / $totalViews) * 100, 1)
            : 0.0;

        // 4. Monthly Visitor Traffic Trend (Last 6 Months)
        $months = [];
        $viewsTrend = [];
        $uniqueVisitorsTrend = [];
        $clicksTrend = [];
        $toolsAddedCounts = [];

        $startDate = Carbon::now()->subMonths(5)->startOfMonth();

        $monthlyVisitorData = [];
        if (!empty($filterToolIds)) {
            $monthlyVisitorData = AnalyticsEvent::whereIn('tool_id', $filterToolIds)
                ->where('timestamp', '>=', $startDate)
                ->select(
                    DB::raw("DATE_FORMAT(timestamp, '%Y-%m') as ym"),
                    DB::raw("COUNT(CASE WHEN event_type = 'view' THEN 1 END) as views_count"),
                    DB::raw("COUNT(DISTINCT CASE WHEN event_type = 'view' THEN COALESCE(session_id, id) END) as unique_count"),
                    DB::raw("COUNT(CASE WHEN event_type IN ('cta_click', 'click') THEN 1 END) as clicks_count")
                )
                ->groupBy('ym')
                ->get()
                ->keyBy('ym');
        }

        // Monthly tools added trend computed from loaded collection
        $toolsAddedByYm = $tools->where('created_at', '>=', $startDate)
            ->groupBy(function ($item) {
                return $item->created_at ? $item->created_at->format('Y-m') : '';
            })
            ->map->count();

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $ym = $month->format('Y-m');
            $months[] = $month->format('M Y');

            $mItem = $monthlyVisitorData[$ym] ?? null;
            $viewsTrend[] = $mItem ? (int) $mItem->views_count : 0;
            $uniqueVisitorsTrend[] = $mItem ? (int) $mItem->unique_count : 0;
            $clicksTrend[] = $mItem ? (int) $mItem->clicks_count : 0;
            $toolsAddedCounts[] = $toolsAddedByYm[$ym] ?? 0;
        }

        // 5. Per-Tool Visitor & Performance Breakdown
        $toolMetrics = $tools->map(function ($t) use ($viewsByTool, $clicksByTool, $leadsByTool, $reviewsByTool) {
            $views = (int) ($viewsByTool[$t->id]->total_views ?? 0);
            $uniques = (int) ($viewsByTool[$t->id]->unique_visitors ?? 0);
            $today = (int) ($viewsByTool[$t->id]->today_views ?? 0);
            $month = (int) ($viewsByTool[$t->id]->month_views ?? 0);
            $clicks = (int) ($clicksByTool[$t->id] ?? 0);
            $leads = (int) ($leadsByTool[$t->id] ?? 0);
            $conversion = $views > 0 ? round((($clicks + $leads) / $views) * 100, 1) : 0.0;
            $reviewInfo = $reviewsByTool[$t->id] ?? null;

            return (object) [
                'id' => $t->id,
                'name' => $t->name,
                'slug' => $t->slug,
                'logo_url' => $t->logo_url,
                'status' => $t->status,
                'is_claimed' => $t->is_claimed,
                'tier' => $t->tier->name ?? 'Free',
                'category' => $t->categories->first()->name ?? 'AI Tool',
                'total_views' => $views,
                'unique_visitors' => $uniques,
                'today_views' => $today,
                'month_views' => $month,
                'clicks' => $clicks,
                'leads' => $leads,
                'conversion_rate' => $conversion,
                'rating' => $reviewInfo ? round($reviewInfo->avg_rating, 1) : 4.8,
                'reviews_count' => $reviewInfo ? $reviewInfo->total_reviews : 0,
            ];
        });

        // 6. Top Traffic Referrers
        $referrers = [];
        if (!empty($filterToolIds)) {
            $referrers = AnalyticsEvent::whereIn('tool_id', $filterToolIds)
                ->where('event_type', 'view')
                ->whereNotNull('referrer')
                ->where('referrer', '!=', '')
                ->select('referrer', DB::raw('COUNT(*) as total'))
                ->groupBy('referrer')
                ->orderByDesc('total')
                ->limit(5)
                ->get()
                ->map(function ($r) {
                    $host = parse_url($r->referrer, PHP_URL_HOST) ?: $r->referrer;
                    return [
                        'source' => $host ?: 'Direct / Internal',
                        'count' => $r->total,
                    ];
                })
                ->toArray();
        }

        // 7. Categories & Status derived from $tools collection (0 queries)
        $categoryMap = [];
        foreach ($tools as $t) {
            foreach ($t->categories as $c) {
                $categoryMap[$c->name] = ($categoryMap[$c->name] ?? 0) + 1;
            }
        }
        $categoryNames = array_keys($categoryMap);
        $categoryCounts = array_values($categoryMap);

        $statuses = ['published', 'pending', 'rejected'];
        $statusCounts = [
            $tools->where('status', 'published')->count(),
            $tools->where('status', 'pending')->count(),
            $tools->where('status', 'rejected')->count(),
        ];

        $claimedToolsCount = $tools->where('is_claimed', true)->count();
        $unclaimedToolsCount = $tools->where('is_claimed', false)->count();

        return view('backend.vendor.content.dashboard', compact(
            'vendor',
            'tools',
            'activeTool',
            'activeToolId',
            'totalTools',
            'totalViews',
            'uniqueVisitors',
            'todayViews',
            'monthViews',
            'totalClicks',
            'totalLeads',
            'conversionRate',
            'months',
            'viewsTrend',
            'uniqueVisitorsTrend',
            'clicksTrend',
            'toolMetrics',
            'referrers',
            'categoryNames',
            'categoryCounts',
            'statuses',
            'statusCounts',
            'claimedToolsCount',
            'unclaimedToolsCount',
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

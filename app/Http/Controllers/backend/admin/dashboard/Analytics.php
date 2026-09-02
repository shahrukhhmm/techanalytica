<?php

namespace App\Http\Controllers\backend\admin\dashboard;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Claim;
use App\Models\Lead;
use App\Models\Review;
use App\Models\Tool;
use App\Models\User;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Analytics extends Controller
{
    public function index(Request $request)
    {
        $totalTools = Tool::count();
        $totalUsers = User::count();
        $totalVendors = Vendor::count();
        $totalBlogs = Blog::count();
        $totalLeads = Lead::count();
        $totalReviews = Review::count();

        // 2. Tools by Category
        $toolsByCategory = Category::withCount('tools')->get();
        $categoryNames = $toolsByCategory->pluck('name')->toArray();
        $categoryCounts = $toolsByCategory->pluck('tools_count')->toArray();

        // 3. Tools Status
        $toolsStatusCounts = Tool::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statuses = ['published', 'pending', 'draft', 'archived'];
        $statusCounts = [];
        foreach ($statuses as $status) {
            $statusCounts[] = $toolsStatusCounts[$status] ?? 0;
        }

        // 4. Tools Claimed vs Unclaimed
        $claimedToolsCount = Tool::where('is_claimed', true)->count();
        $unclaimedToolsCount = Tool::where('is_claimed', false)->count();

        // 5. Tools Added Trend (Last 6 Months - Single Grouped Query)
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();
        $monthlyData = Tool::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        $months = [];
        $toolsAddedCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $carbonMonth = Carbon::now()->subMonths($i);
            $ym = $carbonMonth->format('Y-m');
            $months[] = $carbonMonth->format('M Y');
            $toolsAddedCounts[] = $monthlyData[$ym] ?? 0;
        }

        return view('backend.admin.content.dashboard.dashboards-analytics', compact(
            'totalTools',
            'totalUsers',
            'totalVendors',
            'totalBlogs',
            'totalLeads',
            'totalReviews',
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

    public function pdf()
    {
        $totalTools = Tool::count();
        $totalUsers = User::count();
        $totalVendors = Vendor::count();
        $totalLeads = Lead::count();
        $totalReviews = Review::count();
        $topTools = Tool::withCount('reviews')->orderBy('reviews_count', 'desc')->take(10)->get();

        $pdf = Pdf::loadView('backend.admin.content.dashboard.analytics-pdf', compact(
            'totalTools',
            'totalUsers',
            'totalVendors',
            'totalLeads',
            'totalReviews',
            'topTools'
        ));

        return $pdf->download('TechAnalytica_Executive_Report_' . date('Y-m-d') . '.pdf');
    }

    public function compareTools(Request $request)
    {
        $tool1Id = $request->query('tool1');
        $tool2Id = $request->query('tool2');

        $tool1 = Tool::with(['reviews', 'categories', 'tier'])->find($tool1Id);
        $tool2 = Tool::with(['reviews', 'categories', 'tier'])->find($tool2Id);

        if (!$tool1 || !$tool2) {
            return response()->json(['error' => 'One or both tools not found'], 404);
        }

        return response()->json([
            'tool1' => [
                'name' => $tool1->name,
                'rating' => $tool1->reviews->avg('rating') ?: 0,
                'reviews_count' => $tool1->reviews->count(),
                'score' => $tool1->score,
                'tier' => $tool1->tier->name ?? 'N/A',
                'categories' => $tool1->categories->pluck('name'),
            ],
            'tool2' => [
                'name' => $tool2->name,
                'rating' => $tool2->reviews->avg('rating') ?: 0,
                'reviews_count' => $tool2->reviews->count(),
                'score' => $tool2->score,
                'tier' => $tool2->tier->name ?? 'N/A',
                'categories' => $tool2->categories->pluck('name'),
            ]
        ]);
    }
}

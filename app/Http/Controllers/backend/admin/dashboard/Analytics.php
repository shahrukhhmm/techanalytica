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
        $tool1Id = $request->query('t1', $request->query('tool1'));
        $tool2Id = $request->query('t2', $request->query('tool2'));

        if (!$tool1Id && !$tool2Id) {
            return response()->json(['status' => 'error', 'message' => 'No tool ID provided'], 400);
        }

        $formatTool = function ($id) {
            if (!$id) {
                return null;
            }

            $tool = Tool::with(['vendor', 'tier', 'categories', 'industries'])
                ->withCount(['categories', 'industries', 'media', 'reviews'])
                ->find($id);

            if (!$tool) {
                return null;
            }

            $logoUrl = null;
            if ($tool->logo_url) {
                $logoUrl = filter_var($tool->logo_url, FILTER_VALIDATE_URL) 
                    ? $tool->logo_url 
                    : asset('storage/' . $tool->logo_url);
            }

            return [
                'id' => $tool->id,
                'name' => $tool->name,
                'slug' => $tool->slug,
                'logo_url' => $logoUrl,
                'short_description' => $tool->short_description,
                'status' => $tool->status,
                'pricing_text' => $tool->pricing_text,
                'website_url' => $tool->website_url,
                'cta_type' => $tool->cta_type,
                'cta_url' => $tool->cta_url,
                'vendor' => $tool->vendor ? ['company_name' => $tool->vendor->company_name] : null,
                'tier' => $tool->tier ? [
                    'name' => $tool->tier->name,
                    'monthly_price' => $tool->tier->monthly_price,
                ] : null,
                'categories' => $tool->categories->map(fn($c) => ['name' => $c->name])->values(),
                'industries' => $tool->industries->map(fn($i) => ['name' => $i->name])->values(),
                'categories_count' => $tool->categories_count ?? 0,
                'industries_count' => $tool->industries_count ?? 0,
                'media_count' => $tool->media_count ?? 0,
                'reviews_count' => $tool->reviews_count ?? 0,
            ];
        };

        $result = ['status' => 'success'];
        if ($tool1Id) {
            $formatted1 = $formatTool($tool1Id);
            if ($formatted1) {
                $result['tool1'] = $formatted1;
            }
        }
        if ($tool2Id) {
            $formatted2 = $formatTool($tool2Id);
            if ($formatted2) {
                $result['tool2'] = $formatted2;
            }
        }

        return response()->json($result);
    }
}

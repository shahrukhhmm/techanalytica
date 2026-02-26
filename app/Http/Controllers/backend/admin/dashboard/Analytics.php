<?php

namespace App\Http\Controllers\backend\admin\dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\Tool;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Blog;
use App\Models\Category;

class Analytics extends Controller
{
  public function index(Request $request)
  {
    // 1. Total Counts
    $totalTools = Tool::count();
    $totalUsers = User::count();
    $totalVendors = Vendor::count();
    $totalBlogs = Blog::count();

    // 2. Tools by Category
    $toolsByCategory = Category::withCount('tools')->get();
    $categoryNames = $toolsByCategory->pluck('name')->toArray();
    $categoryCounts = $toolsByCategory->pluck('tools_count')->toArray();

    // 3. Tools Status
    $toolsStatusCounts = Tool::select('status', DB::raw('count(*) as total'))
      ->groupBy('status')
      ->pluck('total', 'status')
      ->toArray();
    
    $statuses = ['published', 'pending', 'rejected']; // Assuming these are the common statuses
    $statusCounts = [];
    foreach ($statuses as $status) {
        $statusCounts[] = $toolsStatusCounts[$status] ?? 0;
    }

    // 4. Tools Claimed vs Unclaimed
    $claimedToolsCount = Tool::where('is_claimed', true)->count();
    $unclaimedToolsCount = Tool::where('is_claimed', false)->count();

    // 5. Tools Added Trend (Last 6 Months)
    $months = [];
    $toolsAddedCounts = [];
    for ($i = 5; $i >= 0; $i--) {
        $monthStr = Carbon::now()->subMonths($i)->format('Y-m');
        $months[] = Carbon::now()->subMonths($i)->format('M Y');
        $toolsAddedCounts[] = Tool::where('created_at', 'like', $monthStr . '%')->count();
    }

    return view('backend.admin.content.dashboard.dashboards-analytics', compact(
        'totalTools',
        'totalUsers',
        'totalVendors',
        'totalBlogs',
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

  public function compareTools(Request $request)
  {
      $tool1Id = $request->query('t1');
      $tool2Id = $request->query('t2');

      if (!$tool1Id && !$tool2Id) {
          return response()->json(['status' => 'error', 'message' => 'Missing tool IDs']);
      }

      $tool1 = null;
      if ($tool1Id) {
          $tool1 = Tool::with(['vendor', 'tier', 'categories', 'industries'])
              ->withCount(['categories', 'industries', 'media'])
              ->find($tool1Id);
      }
      
      $tool2 = null;
      if ($tool2Id) {
          $tool2 = Tool::with(['vendor', 'tier', 'categories', 'industries'])
              ->withCount(['categories', 'industries', 'media'])
              ->find($tool2Id);
      }

      if (($tool1Id && !$tool1) || ($tool2Id && !$tool2)) {
          return response()->json(['status' => 'error', 'message' => 'Tool not found']);
      }

      return response()->json([
          'status' => 'success',
          'tool1' => $tool1,
          'tool2' => $tool2
      ]);
  }

}

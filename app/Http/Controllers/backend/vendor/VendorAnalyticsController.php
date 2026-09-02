<?php

namespace App\Http\Controllers\backend\vendor;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Lead;
use App\Models\Review;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VendorAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;
        if (!$vendor) {
            return redirect()->route('dashboard.analytics')->with('error', 'No vendor profile associated with this account.');
        }

        $tools = $vendor->tools()->get();
        $activeToolId = $request->input('tool_id') ?: session('active_tool_id');
        $tool = $activeToolId ? $vendor->tools()->find($activeToolId) : $vendor->tools()->first();

        if (!$tool && $tools->isNotEmpty()) {
            $tool = $tools->first();
        }

        $totalViews = 0;
        $totalClicks = 0;
        $totalLeads = 0;
        $avgRating = 0;
        $viewsTimeline = [];
        $months = [];

        if ($tool) {
            $totalViews = AnalyticsEvent::where('tool_id', $tool->id)->where('event_type', 'view')->count();
            $totalClicks = AnalyticsEvent::where('tool_id', $tool->id)->where('event_type', 'click')->count();
            $totalLeads = Lead::where('tool_id', $tool->id)->count();
            $avgRating = $tool->reviews->where('status', 'approved')->avg('rating') ?: 4.8;

            for ($i = 5; $i >= 0; $i--) {
                $monthStr = Carbon::now()->subMonths($i)->format('Y-m');
                $months[] = Carbon::now()->subMonths($i)->format('M Y');
                $viewsTimeline[] = AnalyticsEvent::where('tool_id', $tool->id)
                    ->where('timestamp', 'like', $monthStr . '%')
                    ->count();
            }
        }

        return view('backend.vendor.content.analytics.index', compact(
            'tools',
            'tool',
            'totalViews',
            'totalClicks',
            'totalLeads',
            'avgRating',
            'months',
            'viewsTimeline'
        ));
    }
}

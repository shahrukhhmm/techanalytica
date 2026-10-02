@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Vendor Dashboard')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('content')

    {{-- Welcome Banner --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, rgba(224, 67, 133, 0.12) 0%, rgba(164, 53, 138, 0.08) 50%, rgba(13, 5, 19, 0.6) 100%); border: 1px solid rgba(224, 67, 133, 0.25) !important;">
                <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-label-primary px-3 py-1 rounded-pill fw-semibold"><i class="bx bx-check-shield me-1"></i> Verified Vendor</span>
                            @if(isset($vendor->tier))
                                <span class="badge bg-label-success px-3 py-1 rounded-pill fw-semibold"><i class="bx bx-crown me-1"></i> {{ $vendor->tier->name }} Plan</span>
                            @endif
                        </div>
                        <h3 class="card-title mb-1 text-white fw-bold">Welcome, {{ $vendor->company_name ?? auth()->user()->name }}</h3>
                        <p class="card-text text-muted mb-0">Track visitors, monitor conversions, and manage your AI product listings.</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('vendor.billing') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                            <i class="bx bx-credit-card"></i> Manage Subscription
                        </a>
                        <a href="{{ route('vendor.tools.index') }}" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bx bx-wrench"></i> Manage Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tool Switcher Filter --}}
    @if($tools->count() > 1)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3 d-flex align-items-center flex-wrap gap-2">
                    <span class="fw-semibold text-muted me-2 small"><i class="bx bx-filter-alt me-1"></i> Filter by Product:</span>
                    <a href="{{ url()->current() }}?tool_id=all"
                       class="btn btn-sm {{ $activeToolId === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                        All Products
                    </a>
                    @foreach($tools as $t)
                        <a href="{{ url()->current() }}?tool_id={{ $t->id }}"
                           class="btn btn-sm {{ $activeToolId == $t->id ? 'btn-primary' : 'btn-outline-secondary' }}">
                            {{ $t->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- KPI Visitor Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-pink"><i class="bx bx-show"></i></span>
                        <span class="badge bg-label-primary font-size-xs">Lifetime</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Total Page Views</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ number_format($totalViews) }}</h3>
                    <small class="text-muted">{{ number_format($todayViews) }} today &bull; {{ number_format($monthViews) }} this month</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-purple"><i class="bx bx-user-check"></i></span>
                        <span class="badge bg-label-info font-size-xs">Unique</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Unique Visitors</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ number_format($uniqueVisitors) }}</h3>
                    <small class="text-muted">Sessions tracked over 6 months</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-blue"><i class="bx bx-mouse-alt"></i></span>
                        <span class="badge bg-label-success font-size-xs">CTA</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Outbound Clicks</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ number_format($totalClicks) }}</h3>
                    <small class="text-muted">{{ $conversionRate }}% conversion rate</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-green"><i class="bx bx-user-voice"></i></span>
                        <span class="badge bg-label-warning font-size-xs">Leads</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">High-Intent Leads</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ number_format($totalLeads) }}</h3>
                    <small class="text-muted">Qualified buyer inquiries</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Visitor Traffic Trend + Referrers --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div>
                        <h5 class="card-title mb-0">Visitor Traffic Trend</h5>
                        <small class="text-muted">Page views &amp; unique visitors — last 6 months</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary chart-maximize"
                        data-chart="visitorTrendChart" title="Full Screen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="visitorTrendChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h5 class="card-title mb-0">Top Traffic Sources</h5>
                    <small class="text-muted">Where your visitors come from</small>
                </div>
                <div class="card-body">
                    @if(count($referrers) > 0)
                        @foreach($referrers as $ref)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="avatar avatar-xs rounded bg-label-primary">
                                    <i class="bx bx-globe" style="font-size:14px;"></i>
                                </span>
                                <span class="text-truncate small fw-semibold" style="max-width:140px;" title="{{ $ref['source'] }}">
                                    {{ $ref['source'] }}
                                </span>
                            </div>
                            <span class="badge bg-label-info">{{ number_format($ref['count']) }}</span>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bx bx-globe bx-lg mb-2"></i>
                            <p class="small">Referrer data will appear as visitors arrive.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Per-Tool Performance Table --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Product Performance Breakdown</h5>
                        <small class="text-muted">Visitors, clicks, leads &amp; conversions per product</small>
                    </div>
                    <a href="{{ route('vendor.analytics') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bx bx-bar-chart-alt-2 me-1"></i> Full Analytics
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Status</th>
                                <th class="text-center">Total Views</th>
                                <th class="text-center">Today</th>
                                <th class="text-center">This Month</th>
                                <th class="text-center">Unique Visitors</th>
                                <th class="text-center">Clicks</th>
                                <th class="text-center">Leads</th>
                                <th class="text-center">Conversion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($toolMetrics as $tm)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($tm->logo_url)
                                            <img src="{{ $tm->logo_url }}" class="rounded" width="32" height="32" alt="{{ $tm->name }}">
                                        @else
                                            <span class="avatar avatar-sm rounded bg-label-primary">
                                                <i class="bx bx-bot" style="font-size:16px;"></i>
                                            </span>
                                        @endif
                                        <div>
                                            <div class="fw-semibold small">{{ $tm->name }}</div>
                                            <small class="text-muted">{{ $tm->category }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($tm->status === 'published')
                                        <span class="badge bg-label-success">Published</span>
                                    @elseif($tm->status === 'pending')
                                        <span class="badge bg-label-warning">Pending</span>
                                    @else
                                        <span class="badge bg-label-danger">{{ ucfirst($tm->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center fw-semibold">{{ number_format($tm->total_views) }}</td>
                                <td class="text-center">
                                    <span class="badge bg-label-info">{{ number_format($tm->today_views) }}</span>
                                </td>
                                <td class="text-center">{{ number_format($tm->month_views) }}</td>
                                <td class="text-center">{{ number_format($tm->unique_visitors) }}</td>
                                <td class="text-center">{{ number_format($tm->clicks) }}</td>
                                <td class="text-center">{{ number_format($tm->leads) }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $tm->conversion_rate >= 10 ? 'bg-label-success' : ($tm->conversion_rate >= 5 ? 'bg-label-warning' : 'bg-label-secondary') }}">
                                        {{ $tm->conversion_rate }}%
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">No products listed yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row: Category, Status, Claimed, Tools Trend --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div>
                        <h5 class="card-title mb-0">Products by Category</h5>
                        <small class="text-muted">Catalog distribution</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary chart-maximize"
                        data-chart="toolsByCategoryChart" title="Full Screen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="toolsByCategoryChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div>
                        <h5 class="card-title mb-0">Publishing Status</h5>
                        <small class="text-muted">Review &amp; live states</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary chart-maximize"
                        data-chart="toolsStatusChart" title="Full Screen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="toolsStatusChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div>
                        <h5 class="card-title mb-0">Ownership Verification</h5>
                        <small class="text-muted">Claimed tools status</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary chart-maximize"
                        data-chart="toolsClaimedChart" title="Full Screen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="toolsClaimedChart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Products Added History --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Products Added History (Last 6 Months)</h5>
                        <small class="text-muted">Monthly listing cadence</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary chart-maximize"
                        data-chart="toolsAddedTrendChart" title="Full Screen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="toolsAddedTrendChart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Modal --}}
    <div class="modal fade" id="chartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between">
                    <h5 class="modal-title" id="chartModalTitle">Chart View</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalChartContainer" style="min-height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
<script>
const dashboardData = {
    categoryNames: @json($categoryNames),
    categoryCounts: @json($categoryCounts),
    statuses: @json($statuses),
    statusCounts: @json($statusCounts),
    claimedToolsCount: {{ $claimedToolsCount }},
    unclaimedToolsCount: {{ $unclaimedToolsCount }},
    months: @json($months),
    toolsAddedCounts: @json($toolsAddedCounts),
    viewsTrend: @json($viewsTrend),
    uniqueVisitorsTrend: @json($uniqueVisitorsTrend),
    clicksTrend: @json($clicksTrend),
};
</script>
@vite('resources/assets/js/dashboards-analytics.js')
<script>
(function () {
    'use strict';

    const fontFamily = "'Plus Jakarta Sans', 'Inter', sans-serif";
    const pinkColor   = '#e04385';
    const purpleColor = '#a4358a';
    const cyanColor   = '#00f2fe';
    const labelColor  = '#9a8c9e';
    const borderColor = 'rgba(255,255,255,0.08)';

    // Visitor Traffic Trend Chart (Area - Multi-series)
    const visitorTrendEl = document.querySelector('#visitorTrendChart');
    if (visitorTrendEl && dashboardData.months && dashboardData.months.length) {
        const vtConfig = {
            chart: {
                type: 'area',
                height: 280,
                fontFamily: fontFamily,
                background: 'transparent',
                toolbar: { show: false },
            },
            series: [
                { name: 'Page Views', data: dashboardData.viewsTrend },
                { name: 'Unique Visitors', data: dashboardData.uniqueVisitorsTrend },
                { name: 'CTA Clicks', data: dashboardData.clicksTrend },
            ],
            xaxis: {
                categories: dashboardData.months,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: labelColor, fontFamily: fontFamily, fontSize: '12px' } },
            },
            yaxis: {
                labels: { style: { colors: labelColor, fontFamily: fontFamily } },
                min: 0,
            },
            colors: [pinkColor, purpleColor, cyanColor],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [0, 90, 100] },
            },
            stroke: { curve: 'smooth', width: 2 },
            dataLabels: { enabled: false },
            legend: {
                show: true,
                position: 'top',
                labels: { colors: labelColor },
                fontFamily: fontFamily,
            },
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                padding: { top: -5, bottom: -5, left: 10, right: 10 },
            },
            tooltip: { theme: 'dark' },
        };
        new ApexCharts(visitorTrendEl, vtConfig).render();
    }
})();
</script>
@endsection

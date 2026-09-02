@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Analytics Dashboard')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('content')
    <!-- Header Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, rgba(224, 67, 133, 0.12) 0%, rgba(164, 53, 138, 0.08) 50%, rgba(13, 5, 19, 0.6) 100%); border: 1px solid rgba(224, 67, 133, 0.25) !important;">
                <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <span class="badge bg-label-primary px-3 py-1 mb-2 rounded-pill fw-semibold"><i class="bx bx-trending-up me-1"></i> Executive Control Center</span>
                        <h3 class="card-title mb-1 text-white fw-bold">Platform Overview & Live Metrics</h3>
                        <p class="card-text text-muted mb-0">Real-time performance tracking for AI tools, vendor claims, and user engagement.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.analytics.pdf') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                            <i class="bx bx-download"></i> Export Executive PDF
                        </a>
                        <a href="{{ route('admin.tools.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bx bx-plus"></i> Add New AI Tool
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-pink">
                            <i class="bx bx-bot"></i>
                        </span>
                        <span class="badge bg-label-primary font-size-xs">+Live</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Total AI Tools</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ $totalTools }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-purple">
                            <i class="bx bx-user-check"></i>
                        </span>
                        <span class="badge bg-label-success font-size-xs">Active</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Total Users</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-blue">
                            <i class="bx bx-store-alt"></i>
                        </span>
                        <span class="badge bg-label-info font-size-xs">Verified</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Total Vendors</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ $totalVendors }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-green">
                            <i class="bx bx-star"></i>
                        </span>
                        <span class="badge bg-label-warning font-size-xs">Reviews</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Community Reviews</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ $totalReviews ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-pink">
                            <i class="bx bx-envelope"></i>
                        </span>
                        <span class="badge bg-label-primary font-size-xs">Inquiries</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Captured Leads</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ $totalLeads ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-card-icon stat-icon-purple">
                            <i class="bx bx-news"></i>
                        </span>
                        <span class="badge bg-label-success font-size-xs">Published</span>
                    </div>
                    <p class="card-text text-muted mb-1 fs-7">Blog Articles</p>
                    <h3 class="card-title mb-0 text-white fw-bold">{{ $totalBlogs }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row g-4 mb-4">
        <!-- Tools by Category Chart -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div>
                        <h5 class="card-title mb-0">Tools by Category</h5>
                        <small class="text-muted">Distribution across taxonomy</small>
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

        <!-- Tools Status Chart -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div>
                        <h5 class="card-title mb-0">Tools Status Breakdown</h5>
                        <small class="text-muted">Published vs Pending vs Draft</small>
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

        <!-- Tools Claimed vs Unclaimed Donut -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div>
                        <h5 class="card-title mb-0">Claim Status</h5>
                        <small class="text-muted">Verified Owner vs Unclaimed</small>
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

    <!-- Charts Row 2: Trend Chart -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Platform Growth Trend (Last 6 Months)</h5>
                        <small class="text-muted">New AI tools published over time</small>
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

    <!-- Chart Modal -->
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
        // Pass PHP variables to JavaScript
        const dashboardData = {
            categoryNames: @json($categoryNames),
            categoryCounts: @json($categoryCounts),
            statuses: @json($statuses),
            statusCounts: @json($statusCounts),
            claimedToolsCount: {{ $claimedToolsCount }},
            unclaimedToolsCount: {{ $unclaimedToolsCount }},
            months: @json($months),
            toolsAddedCounts: @json($toolsAddedCounts)
        };
    </script>
    @vite('resources/assets/js/dashboards-analytics.js')
@endsection

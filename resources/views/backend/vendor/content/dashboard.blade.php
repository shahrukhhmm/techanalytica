@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Vendor Dashboard')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('content')
    <div class="row">
        <!-- Total Statistics Cards -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">Total Tools</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $totalTools }}</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bx-wrench bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <!-- Tools by Category Chart -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Tools by Category</h5>
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
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Tools Status Overview</h5>
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
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Tool Claim Status</h5>
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

    <div class="row">
        <!-- Tools Added Trend Chart -->
        <div class="col-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Tools Added Trend (Last 6 Months)</h5>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="chartModalTitle">Chart View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalChartContainer" style="min-height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <style>
        #chartModal .btn-close {
            background-color: #fff;
            border-radius: 0.5rem;
            opacity: 1;
            padding: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            margin: 0;
            position: relative;
            z-index: 1;
        }

        #chartModal .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ebedef;
            background-color: #f8f9fa;
            padding: 1rem 1.5rem;
        }
    </style>
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

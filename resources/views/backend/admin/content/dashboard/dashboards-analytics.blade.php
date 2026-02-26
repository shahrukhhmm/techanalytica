@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Analytics Dashboard')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('content')
    <div class="row">
        <!-- Total Statistics Cards -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
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
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">Total Users</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $totalUsers }}</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-user bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">Total Vendors</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $totalVendors }}</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-info rounded p-2">
                                <i class="bx bx-store-alt bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">Total Blogs</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $totalBlogs }}</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-warning rounded p-2">
                                <i class="bx bx-news bx-sm"></i>
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
                </div>
                <div class="card-body">
                    <div id="toolsAddedTrendChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- <!-- Sales Trend -->
    <div class="col-lg-6 col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Sales Trend (Last 12 Months)</h5>
        </div>
        <div class="card-body">
          <div id="salesChart" style="height: 340px;"></div>
        </div>
      </div>
    </div>

    <!-- Expenses Trend -->
    <div class="col-lg-6 col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Expenses Trend (Last 12 Months)</h5>
        </div>
        <div class="card-body">
          <div id="expensesChart" style="height: 340px;"></div>
        </div>
      </div>
    </div>

    <!-- Comparison Bar -->
    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Sales vs Expenses Comparison</h5>
        </div>
        <div class="card-body">
          <div id="comparisonChart" style="height: 380px;"></div>
        </div>
      </div>
    </div>

    <!-- Donut -->
    <div class="col-lg-6 col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Financial Overview</h5>
        </div>
        <div class="card-body">
          <div id="donutChart" style="height: 340px;"></div>
        </div>
      </div>
    </div>

    <!-- Department Pie - only when all departments selected -->
    @if (!$selectedDepartment && isset($departmentSalesData) && $departmentSalesData->isNotEmpty())
      <div class="col-lg-6 col-12 mb-4">
        <div class="card">
          <div class="card-header">
            <h5>Sales Distribution by Department</h5>
          </div>
          <div class="card-body">
            <div id="deptPieChart" style="height: 340px;"></div>
          </div>
        </div>
      </div>
    @endif --}}
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

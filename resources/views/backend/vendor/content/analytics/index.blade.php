@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Product Telemetry & Analytics')

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Product Telemetry /</span> {{ $tool->name ?? 'Overview' }}
            </h4>

            @if(isset($tools) && $tools->count() > 1)
                <form action="{{ route('vendor.analytics') }}" method="GET" class="d-flex align-items-center gap-2">
                    <label class="form-label mb-0 fw-bold">Select Product:</label>
                    <select name="tool_id" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto;">
                        @foreach($tools as $t)
                            <option value="{{ $t->id }}" {{ ($tool && $tool->id == $t->id) ? 'selected' : '' }}>{{ $t->name }}</option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>

        @if($tool)
            <!-- KPI Overview Cards -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-show fs-4"></i></span>
                            </div>
                            <div>
                                <span class="d-block text-muted small">Total Page Views</span>
                                <h3 class="card-title mb-0">{{ number_format($totalViews) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-pointer fs-4"></i></span>
                            </div>
                            <div>
                                <span class="d-block text-muted small">CTA Outbound Clicks</span>
                                <h3 class="card-title mb-0">{{ number_format($totalClicks) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-user-pin fs-4"></i></span>
                            </div>
                            <div>
                                <span class="d-block text-muted small">High-Intent Leads</span>
                                <h3 class="card-title mb-0">{{ number_format($totalLeads) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-star fs-4"></i></span>
                            </div>
                            <div>
                                <span class="d-block text-muted small">Average Rating</span>
                                <h3 class="card-title mb-0">{{ number_format($avgRating, 1) }} / 5.0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visual Graph Card -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Monthly Traffic & Engagement Trend</h5>
                            <span class="badge bg-label-primary">Last 6 Months</span>
                        </div>
                        <div class="card-body">
                            <div id="trafficTrendChart" style="min-height: 320px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card shadow-sm border-0 text-center py-5">
                <div class="card-body">
                    <i class="bx bx-layer-plus text-primary mb-3" style="font-size: 48px;"></i>
                    <h4>No Products Listed Yet</h4>
                    <p class="text-muted">Create or claim an AI product to unlock live buyer analytics.</p>
                    <a href="{{ route('vendor.tools.create') }}" class="btn btn-primary">Add Product Now</a>
                </div>
            </div>
        @endif
    </div>

    @if($tool)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const options = {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: { show: false }
                },
                series: [{
                    name: 'Page Views',
                    data: @json($viewsTimeline)
                }],
                xaxis: {
                    categories: @json($months),
                    labels: { style: { colors: '#a1acb8' } }
                },
                yaxis: {
                    labels: { style: { colors: '#a1acb8' } }
                },
                colors: ['#e04385'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 }
            };

            const chart = new ApexCharts(document.querySelector("#trafficTrendChart"), options);
            chart.render();
        });
    </script>
    @endif
@endsection

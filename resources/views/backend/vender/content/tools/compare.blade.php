@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Tool Comparison')

@section('page-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('page-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/js/tools-compare.js'])
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Products /</span> Compare Tools
        </h4>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="mb-0">Select Products to Compare</h5>
                    </div>
                    <div class="card-body pt-4">
                        <div class="row mb-4">
                            <div class="col-md-5">
                                <label for="compareTool1" class="form-label fw-bold">Select Product 1</label>
                                <select id="compareTool1" class="form-select select2" data-allow-clear="true">
                                    <option value="">Select a product...</option>
                                    @foreach ($allTools as $tool)
                                        <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end justify-content-center pb-2">
                                <span class="fw-bold fs-4 text-primary">VS</span>
                            </div>
                            <div class="col-md-5">
                                <label for="compareTool2" class="form-label fw-bold">Select Product 2</label>
                                <select id="compareTool2" class="form-select select2" data-allow-clear="true">
                                    <option value="">Select a product...</option>
                                    @foreach ($allTools as $tool)
                                        <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center" id="comparisonLoading" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <div id="comparisonChartContainer">
                            <!-- Tool Details Side-by-Side -->
                            <div class="row mt-4 mb-4">
                                <!-- Tool 1 Details -->
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-label-secondary shadow-none border h-100">
                                        <div class="card-body" id="tool1Details">
                                            <div class="text-center text-muted d-flex align-items-center justify-content-center"
                                                style="min-height: 200px;">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="bx bx-pointer fs-1 mb-2"></i>
                                                    <span>Select a product above to view details.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tool 2 Details -->
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-label-secondary shadow-none border h-100">
                                        <div class="card-body" id="tool2Details">
                                            <div class="text-center text-muted d-flex align-items-center justify-content-center"
                                                style="min-height: 200px;">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="bx bx-pointer fs-1 mb-2"></i>
                                                    <span>Select a product above to view details.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="radarChartSection" class="d-none">
                                <hr class="my-5">
                                <!-- Radar Chart -->
                                <h5 class="text-center mb-4 fw-bold">Metrics Comparison</h5>
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div id="toolComparisonRadarChart" style="min-height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

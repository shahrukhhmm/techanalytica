@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Analytics')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Analytics /</span> {{ $tool->name }}</h4>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bx bx-bar-chart-alt-2 text-primary mb-3" style="font-size: 48px;"></i>
                        <h4>Analytics Dashboard</h4>
                        <p class="text-muted">Detailed performance metrics for {{ $tool->name }} will appear here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Review Submission')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-header bg-label-secondary p-4 border-0">
                        <h4 class="mb-0 fw-bold">Review Your Submission 📝</h4>
                        <p class="mb-0 opacity-75">Double check your product details before final submission.</p>
                    </div>
                    <div class="card-body p-4 pt-5">
                        <div class="row g-4">
                            <div class="col-md-3 text-center border-end">
                                <h6 class="text-muted small text-uppercase mb-3">Product Logo</h6>
                                @if (isset($submission['logo_url']))
                                    <img src="{{ asset('storage/' . $submission['logo_url']) }}" alt="Logo"
                                        class="rounded shadow-sm img-fluid" style="max-width: 120px;">
                                @else
                                    <div class="bg-label-primary rounded d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 100px; height: 100px;">
                                        <i class="bx bx-package fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h3 class="fw-bold mb-1">{{ $submission['product_name'] }}</h3>
                                <p class="badge bg-label-info mb-4">{{ $category->name ?? 'Uncategorized' }}</p>

                                <h6 class="fw-bold small mb-2 text-uppercase">Description</h6>
                                <p class="text-muted">{{ $submission['description'] }}</p>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold px-0 py-2" style="width: 250px;">Deployment Options:</td>
                                                <td class="text-muted py-2">
                                                    {{ implode(', ', $submission['deployment_options'] ?? []) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold px-0 py-2">End User Personas:</td>
                                                <td class="text-muted py-2">{{ $submission['target_market'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold px-0 py-2">Target Company Size:</td>
                                                <td class="text-muted py-2">{{ $submission['company_size'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold px-0 py-2">AI Focused:</td>
                                                <td class="text-muted py-2"><i
                                                        class="bx bx-check-circle text-success me-1"></i> Confirmed</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('vendor.submit.confirm') }}" method="POST"
                            class="mt-5 pt-3 border-top d-flex justify-content-between">
                            @csrf
                            <a href="{{ route('vendor.submit.create') }}" class="btn btn-label-secondary">
                                <i class="bx bx-left-arrow-alt me-1"></i> Edit Details
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                Submit for Review <i class="bx bx-rocket ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

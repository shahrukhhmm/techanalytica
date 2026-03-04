@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Product Submission Guidelines')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-header bg-label-success p-4 border-0">
                        <h4 class="mb-0 fw-bold text-success">List Your Product on TechAnalytica 🚀</h4>
                        <p class="mb-0 opacity-75">Follow these guidelines to ensure a smooth review process</p>
                    </div>
                    <div class="card-body p-4 pt-5">
                        <div class="mb-5">
                            <h5 class="fw-bold mb-3"><i class="bx bx-info-circle me-1 text-primary"></i> Listing Policy</h5>
                            <p>We're excited to have you! To maintain the quality of our marketplace, please ensure your
                                product meets the following criteria:</p>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item bg-transparent px-0 py-3 d-flex align-items-start border-0">
                                    <i class="bx bx-check-circle text-success me-3 mt-1 fs-4"></i>
                                    <div>
                                        <h6 class="mb-1 fw-bold">AI-Focused Solution</h6>
                                        <p class="mb-0 small text-muted">Your tool or software must leverage Artificial
                                            Intelligence, Machine Learning, or related core technologies.</p>
                                    </div>
                                </li>
                                <li class="list-group-item bg-transparent px-0 py-3 d-flex align-items-start border-0">
                                    <i class="bx bx-check-circle text-success me-3 mt-1 fs-4"></i>
                                    <div>
                                        <h6 class="mb-1 fw-bold">B2B or B2C Application</h6>
                                        <p class="mb-0 small text-muted">We accept both business-oriented and
                                            consumer-facing AI products that provide clear value.</p>
                                    </div>
                                </li>
                                <li class="list-group-item bg-transparent px-0 py-3 d-flex align-items-start border-0">
                                    <i class="bx bx-check-circle text-success me-3 mt-1 fs-4"></i>
                                    <div>
                                        <h6 class="mb-1 fw-bold">Functional & Secure</h6>
                                        <p class="mb-0 small text-muted">Ensure your product is beyond the 'ideation' phase
                                            and has a working demonstration or live access.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-label-warning p-4 rounded mb-5 border-0">
                            <div class="d-flex">
                                <i class="bx bx-error fs-3 me-3 mt-1 text-warning"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold text-warning">Important Disclaimer</h6>
                                    <p class="mb-0 small">TechAnalytica reserves the right to reject products that do not
                                        align with our quality standards or AI-focused mission. Submission does not
                                        guarantee listing.</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('vendor.dashboard') }}" class="btn btn-label-secondary">Cancel</a>
                            <a href="{{ route('vendor.submit.create') }}" class="btn btn-primary px-5 shadow-sm">I
                                Understand, Let's Begin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

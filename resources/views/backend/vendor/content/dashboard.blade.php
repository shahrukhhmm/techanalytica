@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Vendor Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card shadow-none bg-label-primary border-0">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome Back, {{ auth()->user()->name }}! 🎉</h5>
                                <p class="mb-4">
                                    You have <span class="fw-bold">{{ $tools->count() }}</span> active products on
                                    TechAnalytica. Manage your listings and view performance analytics.
                                </p>
                                <a href="{{ route('vendor.tools.index') }}" class="btn btn-sm btn-outline-primary">View
                                    Products</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4 text-end">
                                <img src="{{ asset('resources/assets/vendor/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-12 mb-4">
                <h5 class="fw-bold mb-3">Quick Actions</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 cursor-pointer"
                            onclick="window.location.href='{{ route('vendor.claim') }}'">
                            <div class="card-body text-center p-4">
                                <div class="avatar avatar-lg bg-label-info mx-auto mb-3">
                                    <span class="avatar-initial rounded"><i class="bx bx-check-shield fs-3"></i></span>
                                </div>
                                <h6 class="mb-1">Claim your Product</h6>
                                <p class="text-muted small mb-0">Found your software? Claim it today.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 cursor-pointer"
                            onclick="window.location.href='{{ route('vendor.submit') }}'">
                            <div class="card-body text-center p-4">
                                <div class="avatar avatar-lg bg-label-success mx-auto mb-3">
                                    <span class="avatar-initial rounded"><i class="bx bx-plus-circle fs-3"></i></span>
                                </div>
                                <h6 class="mb-1">Submit a Product</h6>
                                <p class="text-muted small mb-0">Got something new? List it here.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 cursor-pointer"
                            onclick="window.location.href='{{ route('vendor.blogs.create') }}'">
                            <div class="card-body text-center p-4">
                                <div class="avatar avatar-lg bg-label-primary mx-auto mb-3">
                                    <span class="avatar-initial rounded"><i class="bx bx-news fs-3"></i></span>
                                </div>
                                <h6 class="mb-1">Write an Article</h6>
                                <p class="text-muted small mb-0">Share your expertise with our users.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($activeTool)
                <!-- Current Active Tool Stats -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Active Product: <span
                                    class="fw-bold text-primary">{{ $activeTool->name }}</span></h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('vendor.tools.edit', $activeTool) }}">Edit
                                        Details</a>
                                    <a class="dropdown-item" href="{{ route('vendor.analytics') }}">Full Analytics</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center border-end">
                                    <h2 class="fw-bold mb-1">{{ $activeTool->reviews_count ?? 0 }}</h2>
                                    <p class="text-muted mb-0">Total Reviews</p>
                                </div>
                                <div class="col-md-4 text-center border-end">
                                    <h2 class="fw-bold mb-1">{{ $activeTool->analytics_events_count ?? 0 }}</h2>
                                    <p class="text-muted mb-0">Page Views</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h2 class="fw-bold mb-1">{{ $activeTool->cta_clicks_count ?? 0 }}</h2>
                                    <p class="text-muted mb-0">CTA Clicks</p>
                                </div>
                            </div>
                            <div class="mt-4 pt-2">
                                <div class="alert alert-info d-flex border-0 bg-label-info shadow-none" role="alert">
                                    <span class="badge badge-center rounded-pill bg-info h-px-20 w-px-20 me-2"><i
                                            class="bx bx-info-circle"></i></span>
                                    <div class="d-flex flex-column ps-1">
                                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Boost visibility!
                                        </h6>
                                        <span class="small">Upgrade to a premium plan to unlock more analytics and lead
                                            generation features.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100 bg-primary text-white overflow-hidden">
                    <div class="card-body position-relative z-1 p-4">
                        <h3 class="fw-bold text-white mb-3">Upgrade to Premium</h3>
                        <p class="mb-4">Get verified, list more features, and get more leads with our tiered plans.</p>
                        <a href="{{ route('vendor.billing') }}"
                            class="btn btn-white text-primary fw-bold shadow-sm">Explore Plans</a>
                    </div>
                    <div class="position-absolute bottom-0 end-0 p-3 opacity-25">
                        <i class="bx bx-rocket" style="font-size: 8rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

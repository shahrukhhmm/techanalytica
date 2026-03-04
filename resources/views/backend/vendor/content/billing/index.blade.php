@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Pricing & Plans')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="text-center mb-5 mt-3">
            <h2 class="fw-bold">Ready to Grow Your Product? 🚀</h2>
            <p class="text-muted">Choose the plan that's right for your business and unlock premium features.</p>

            @if ($activeTool)
                <div class="badge bg-label-primary p-2 px-3 mt-2">
                    Currently managing: <span class="fw-bold">{{ $activeTool->name }}</span>
                </div>
            @endif
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($tiers as $tier)
                <div class="col-lg-4 col-md-6">
                    <div
                        class="card h-100 border-0 shadow-sm {{ $activeTool && $activeTool->tier_id == $tier->id ? 'border-2 border-primary' : '' }}">
                        @if ($activeTool && $activeTool->tier_id == $tier->id)
                            <div class="position-absolute top-0 start-50 translate-middle">
                                <span class="badge bg-primary px-3 rounded-pill shadow-sm">Current Plan</span>
                            </div>
                        @endif

                        <div class="card-body p-5 d-flex flex-column">
                            <div class="text-center">
                                <h4 class="fw-bold mb-1">{{ $tier->name }}</h4>
                                <div class="d-flex align-items-center justify-content-center my-4">
                                    <span class="fs-4 align-top text-muted">$</span>
                                    <h1 class="display-4 fw-bold mb-0 text-primary">
                                        {{ number_format($tier->monthly_price, 0) }}
                                    </h1>
                                    <span class="text-muted ms-1 small">/mo</span>
                                </div>
                            </div>

                            <ul class="list-unstyled text-start mb-5 pb-3">
                                @foreach ($tier->features ?? [] as $feature)
                                    <li class="mb-3 d-flex align-items-center">
                                        <i class="bx bx-check text-success me-2 fs-4"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach

                                {{-- Add some standard vendor workflow features if not present --}}
                                @if ($tier->monthly_price > 0)
                                    <li class="mb-3 d-flex align-items-center">
                                        <i class="bx bx-check text-success me-2 fs-4"></i>
                                        <span class="fw-bold">Lead Generation Tools</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-center">
                                        <i class="bx bx-check text-success me-2 fs-4"></i>
                                        <span>Advanced Analytics Dashboards</span>
                                    </li>
                                @endif
                            </ul>

                            <div class="mt-auto">
                                @if ($activeTool && $activeTool->tier_id == $tier->id)
                                    <button class="btn btn-label-secondary w-100 disabled py-3" disabled>Your Current
                                        Plan</button>
                                @else
                                    <a href="javascript:void(0);"
                                        class="btn btn-primary w-100 py-3 shadow-sm text-white">Upgrade Today</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Support Section -->
        <div class="row mt-5 pt-3">
            <div class="col-12">
                <div class="card border-0 bg-label-info shadow-none">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-3">Need a custom solution or have questions?</h5>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="mailto:support@techanalytica.com" class="btn btn-info px-4">
                                <i class="bx bx-envelope me-2"></i> Contact Support
                            </a>
                            <a href="#" class="btn btn-outline-info px-4">
                                <i class="bx bx-calendar me-2"></i> Schedule a Demo Call
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

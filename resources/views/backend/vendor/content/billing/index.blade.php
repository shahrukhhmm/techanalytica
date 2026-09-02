@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Pricing & Plans')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="text-center mb-5 mt-3">
            <h2 class="fw-bold">Vendor Pricing & Subscription Plans 🚀</h2>
            <p class="text-muted max-w-600 mx-auto">
                TechAnalytica is <strong>100% free for visitors & users</strong> to explore, benchmark, and review software.
                Upgrade your product listing below to unlock verified badges, lead capture, and advanced analytics.
            </p>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show max-w-600 mx-auto mt-3" role="alert">
                    <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($activeTool)
                <div class="badge bg-label-primary p-2 px-3 mt-2 fs-6">
                    Managing Subscription for: <span class="fw-bold">{{ $activeTool->name }}</span>
                </div>
            @else
                <div class="alert alert-warning max-w-600 mx-auto mt-3">
                    <i class="bx bx-info-circle me-1"></i> Please create or select a product before upgrading a plan.
                </div>
            @endif
        </div>

        <div class="row g-4 justify-content-center mb-5">
            @foreach ($tiers as $tier)
                @php
                    $isCurrent = $activeTool && $activeTool->tier_id == $tier->id;
                @endphp
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm {{ $isCurrent ? 'border border-2 border-primary' : '' }}">
                        @if ($isCurrent)
                            <div class="position-absolute top-0 start-50 translate-middle">
                                <span class="badge bg-primary px-3 rounded-pill shadow-sm">Current Plan</span>
                            </div>
                        @endif

                        <div class="card-body p-4 d-flex flex-column">
                            <div class="text-center">
                                <h4 class="fw-bold mb-1">{{ $tier->name }}</h4>
                                <div class="d-flex align-items-center justify-content-center my-3">
                                    <span class="fs-5 align-top text-muted">$</span>
                                    <h2 class="display-5 fw-bold mb-0 text-primary">
                                        {{ number_format($tier->monthly_price, 0) }}
                                    </h2>
                                    <span class="text-muted ms-1 small">/mo</span>
                                </div>
                                @if($tier->annual_price > 0)
                                    <small class="text-muted d-block mb-3">${{ number_format($tier->annual_price, 0) }}/year billed annually</small>
                                @else
                                    <small class="text-success d-block mb-3 fw-semibold">Free Forever</small>
                                @endif
                            </div>

                            <hr class="my-2">

                            <ul class="list-unstyled text-start mb-4 flex-grow-1">
                                @foreach ($tier->features ?? [] as $feature)
                                    <li class="mb-2 d-flex align-items-start small">
                                        <i class="bx bx-check text-success me-2 fs-5 flex-shrink-0"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-auto">
                                @if ($isCurrent)
                                    <button class="btn btn-label-secondary w-100 py-2 disabled" disabled>
                                        <i class="bx bx-check me-1"></i> Active Plan
                                    </button>
                                @elseif($activeTool)
                                    <form action="{{ route('vendor.billing.subscribe') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tool_id" value="{{ $activeTool->id }}">
                                        <input type="hidden" name="tier_id" value="{{ $tier->id }}">
                                        <button type="submit" class="btn {{ $tier->monthly_price > 0 ? 'btn-primary' : 'btn-outline-primary' }} w-100 py-2 shadow-sm">
                                            {{ $tier->monthly_price > 0 ? 'Upgrade to ' . $tier->name : 'Switch to ' . $tier->name }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('vendor.tools.create') }}" class="btn btn-primary w-100 py-2 shadow-sm">
                                        Create Tool First
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Transaction History -->
        @if(isset($transactions) && $transactions->count() > 0)
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-receipt me-1 text-primary"></i> Recent Billing Transactions</h5>
                    <span class="badge bg-label-info">{{ $transactions->count() }} Transactions</span>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Transaction Ref</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $tx)
                                <tr>
                                    <td><code>{{ $tx->external_tx_id ?? '#' . $tx->id }}</code></td>
                                    <td><strong>{{ $tx->tool->name ?? 'All Products' }}</strong></td>
                                    <td>${{ number_format($tx->amount, 2) }} {{ $tx->currency }}</td>
                                    <td><span class="badge bg-label-secondary">{{ ucfirst($tx->type) }}</span></td>
                                    <td>
                                        <span class="badge bg-label-{{ in_array($tx->status, ['paid', 'completed']) ? 'success' : ($tx->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($tx->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $tx->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Support Section -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 bg-label-info shadow-none">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-2">Need a tailored enterprise plan or sponsorship?</h5>
                        <p class="text-muted small mb-3">Custom multi-product packages and priority featured placement are available.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="mailto:support@techanalytica.com" class="btn btn-info px-4">
                                <i class="bx bx-envelope me-2"></i> Contact Billing Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Tool Details - ' . $tool->name)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Tools /</span> Details</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.tools.edit', $tool) }}" class="btn btn-primary">
                    <i class="bx bx-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-xl-8 col-lg-7 col-md-12">
                <!-- Tool Header Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="tool-logo-wrapper me-4">
                                @if ($tool->logo_url)
                                    <img src="{{ $tool->logo_url }}" alt="{{ $tool->name }}" class="rounded shadow-sm"
                                        height="120" width="120"
                                        style="object-fit: contain; background: #f8f9fa; padding: 10px; border: 1px solid #eee;">
                                @else
                                    <div class="avatar avatar-xl h-auto">
                                        <span
                                            class="avatar-initial rounded bg-label-primary fs-1 shadow-sm">{{ substr($tool->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="tool-title-wrapper flex-grow-1">
                                <h2 class="mb-1 fw-bold">{{ $tool->name }}</h2>
                                <div class="d-flex align-items-center gap-3">
                                    <code class="text-primary small">{{ $tool->slug }}</code>
                                    <span
                                        class="badge @php
$class = [
                                            'draft' => 'bg-label-secondary',
                                            'pending' => 'bg-label-warning',
                                            'published' => 'bg-label-success',
                                            'archived' => 'bg-label-danger',
                                        ][$tool->status] ?? 'bg-label-info';
                                        echo $class; @endphp text-uppercase">
                                        {{ $tool->status }}
                                    </span>
                                </div>
                            </div>
                            @if ($tool->website_url)
                                <div class="ms-auto d-none d-sm-block">
                                    <a href="{{ $tool->website_url }}" target="_blank" class="btn btn-outline-primary">
                                        Visit Website <i class="bx bx-link-external ms-1 small"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="description-section">
                            <div class="mb-4">
                                <h5 class="section-title border-start border-primary border-4 ps-2 mb-3">About
                                    {{ $tool->name }}</h5>
                                <p class="lead text-dark">
                                    {{ $tool->short_description ?: 'No short description available.' }}</p>
                            </div>

                            <div class="mb-0">
                                <h5 class="section-title border-start border-primary border-4 ps-2 mb-3">Detailed
                                    Description</h5>
                                <div class="long-description p-3 bg-light rounded text-muted">
                                    {!! nl2br(e($tool->long_description)) ?: 'No detailed description provided.' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features & Pricing -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-none border">
                            <div class="card-header bg-label-info py-2">
                                <h6 class="mb-0 text-info fw-bold">Pricing Details</h6>
                            </div>
                            <div class="card-body pt-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar avatar-sm bg-label-info me-2">
                                        <i class="bx bx-wallet fs-4"></i>
                                    </div>
                                    <div>
                                        <span
                                            class="d-block fw-bold text-dark">{{ $tool->tier->name ?? 'Free Tier' }}</span>
                                        <small class="text-muted">Current Pricing Model</small>
                                    </div>
                                </div>
                                @if ($tool->pricing_text)
                                    <div class="pricing-text border-top pt-2">
                                        <p class="small mb-0">{{ $tool->pricing_text }}</p>
                                    </div>
                                @endif

                                @if ($tool->pricing_structured)
                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-label-info w-100" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#pricingJson">
                                            View Structured Pricing
                                        </button>
                                        <div class="collapse mt-2" id="pricingJson">
                                            <pre class="bg-dark text-white p-2 rounded small mb-0"><code>{{ json_encode($tool->pricing_structured, JSON_PRETTY_PRINT) }}</code></pre>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-none border">
                            <div class="card-header bg-label-primary py-2">
                                <h6 class="mb-0 text-primary fw-bold">Calls to Action</h6>
                            </div>
                            <div class="card-body pt-3">
                                @if ($tool->cta_type && $tool->cta_url)
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ $tool->cta_url }}" target="_blank" class="btn btn-primary">
                                            @php
                                                $ctaLabels = [
                                                    'website' => 'Visit Website',
                                                    'signup' => 'Sign Up Now',
                                                    'demo' => 'Book a Demo',
                                                    'free_trial' => 'Start Free Trial',
                                                    'contact_sales' => 'Contact Sales',
                                                ];
                                                echo $ctaLabels[$tool->cta_type] ?? 'Action Link';
                                            @endphp
                                            <i class="bx bx-right-arrow-alt ms-1"></i>
                                        </a>
                                        <small class="text-muted text-center">Type:
                                            {{ ucfirst(str_replace('_', ' ', $tool->cta_type)) }}</small>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="bx bx-info-circle text-muted mb-2 fs-2"></i>
                                        <p class="text-muted small mb-0">No active calls to action defined.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-12">
                <!-- Taxonomy Card -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3 d-flex align-items-center">
                                <i class="bx bx-category me-2"></i> Categories
                            </h6>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($tool->categories as $category)
                                    <span class="badge bg-label-primary rounded-pill">{{ $category->name }}</span>
                                @empty
                                    <span class="text-muted small italic">No categories</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="mb-0">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3 d-flex align-items-center">
                                <i class="bx bx-buildings me-2"></i> Industries
                            </h6>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($tool->industries as $industry)
                                    <span class="badge bg-label-success rounded-pill">{{ $industry->name }}</span>
                                @empty
                                    <span class="text-muted small italic">No industries</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vendor Card -->
                <div class="card mb-4 shadow-sm border-0 bg-label-secondary">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Vendor Information</h6>
                        @if ($tool->vendor)
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md me-2">
                                    <span class="avatar-initial rounded bg-white text-secondary shadow-sm fw-bold">
                                        {{ substr($tool->vendor->company_name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">{{ $tool->vendor->company_name }}</h6>
                                    <span class="badge bg-white text-dark small">ID #{{ $tool->vendor->id }}</span>
                                </div>
                            </div>
                            <ul class="list-unstyled mb-0 border-top pt-2">
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="text-muted">Email:</span>
                                    <span class="text-dark small">{{ $tool->vendor->user->email ?? 'N/A' }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <span class="text-muted">Verified:</span>
                                    <span class="badge {{ $tool->is_claimed ? 'bg-success' : 'bg-secondary' }} badge-xs">
                                        {{ $tool->is_claimed ? 'Claimed' : 'Unclaimed' }}
                                    </span>
                                </li>
                            </ul>
                        @else
                            <p class="text-muted mb-0 small">No vendor assigned to this tool.</p>
                        @endif
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Record Stats</h6>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Record Created</small>
                                <small class="fw-bold">{{ $tool->created_at->format('M d, Y') }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Last Modified</small>
                                <small class="fw-bold">{{ $tool->updated_at->diffForHumans() }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Publication Date</small>
                                <small
                                    class="text-success fw-bold">{{ $tool->published_at ? $tool->published_at->format('M d, Y') : 'Not Published' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-style')
    <style>
        .section-title {
            color: #1c96ed;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .long-description {
            line-height: 1.6;
        }

        .bg-label-info.py-2,
        .bg-label-primary.py-2 {
            border-bottom: 0px;
        }

        .avatar-initial.shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }
    </style>
@endpush

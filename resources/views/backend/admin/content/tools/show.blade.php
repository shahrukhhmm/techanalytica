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
            <!-- Main Details -->
            <div class="col-xl-8 col-lg-7 col-md-7">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4 border-bottom pb-3 mb-3">
                            @if ($tool->logo_url)
                                <img src="{{ $tool->logo_url }}" alt="tool-logo" class="d-block rounded" height="100"
                                    width="100" id="uploadedAvatar" />
                            @else
                                <div class="avatar avatar-xl d-block h-auto">
                                    <span
                                        class="avatar-initial rounded bg-label-primary fs-2">{{ substr($tool->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="button-wrapper">
                                <h3 class="mb-1">{{ $tool->name }}</h3>
                                <p class="text-muted mb-0"><code>{{ $tool->slug }}</code></p>
                                <span
                                    class="badge @php
$class = [
                                    'draft' => 'bg-label-secondary',
                                    'pending' => 'bg-label-warning',
                                    'published' => 'bg-label-success',
                                    'archived' => 'bg-label-danger',
                                ][$tool->status] ?? 'bg-label-info';
                                echo $class; @endphp mt-2">
                                    {{ ucfirst($tool->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="info-container">
                            <div class="mb-4">
                                <h5 class="fw-bold mb-2">Short Description</h5>
                                <p>{{ $tool->short_description ?: 'No description provided.' }}</p>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold mb-2">Long Description</h5>
                                <div class="text-wrap">
                                    {!! nl2br(e($tool->long_description)) ?: 'No detailed description provided.' !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted text-uppercase small fw-bold">Website</h6>
                                    @if ($tool->website_url)
                                        <a href="{{ $tool->website_url }}" target="_blank"
                                            class="text-primary d-flex align-items-center">
                                            {{ $tool->website_url }} <i class="bx bx-link-external ms-1 small"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">Not specified</span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted text-uppercase small fw-bold">Pricing</h6>
                                    <span
                                        class="badge bg-label-info me-2">{{ $tool->tier->name ?? 'Not specified' }}</span>
                                    @if ($tool->pricing_text)
                                        <span class="text-muted small">{{ $tool->pricing_text }}</span>
                                    @endif
                                </div>
                            </div>

                            @if ($tool->cta_type && $tool->cta_url)
                                <div class="mt-2">
                                    <a href="{{ $tool->cta_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-right-arrow-alt me-1"></i>
                                        @php
                                            $ctaLabels = [
                                                'website' => 'Visit Website',
                                                'signup' => 'Sign Up Now',
                                                'demo' => 'Book a Demo',
                                                'free_trial' => 'Start Free Trial',
                                                'contact_sales' => 'Contact Sales',
                                            ];
                                            echo $ctaLabels[$tool->cta_type] ?? 'Visit';
                                        @endphp
                                    </a>
                                </div>
                            @endif

                            @if ($tool->pricing_structured)
                                <div class="mt-4">
                                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Structured Pricing Data</h6>
                                    <pre class="bg-light p-2 rounded small"><code>{{ json_encode($tool->pricing_structured, JSON_PRETTY_PRINT) }}</code></pre>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Details -->
            <div class="col-xl-4 col-lg-5 col-md-5">
                <!-- Vendor Info -->
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">Vendor Information</h5>
                    </div>
                    <div class="card-body pt-3">
                        @if ($tool->vendor)
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-sm me-2">
                                    <span
                                        class="avatar-initial rounded bg-label-success">{{ substr($tool->vendor->company_name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $tool->vendor->company_name }}</h6>
                                    <small class="text-muted">ID: #{{ $tool->vendor->id }}</small>
                                </div>
                            </div>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><span class="fw-bold">Contact Email:</span>
                                    {{ $tool->vendor->user->email ?? 'N/A' }}</li>
                                <li><span class="fw-bold">Claimed:</span>
                                    <span
                                        class="badge {{ $tool->is_claimed ? 'bg-label-success' : 'bg-label-secondary' }}">
                                        {{ $tool->is_claimed ? 'Yes' : 'No' }}
                                    </span>
                                </li>
                            </ul>
                        @else
                            <p class="text-muted mb-0">No vendor assigned.</p>
                        @endif
                    </div>
                </div>

                <!-- Taxonomy -->
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">Taxonomy</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">Categories</h6>
                            @forelse($tool->categories as $category)
                                <span class="badge bg-label-primary mb-1 me-1">{{ $category->name }}</span>
                            @empty
                                <span class="text-muted small italic">No categories</span>
                            @endforelse
                        </div>
                        <div class="mb-0">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">Industries</h6>
                            @forelse($tool->industries as $industry)
                                <span class="badge bg-label-success mb-1 me-1">{{ $industry->name }}</span>
                            @empty
                                <span class="text-muted small italic">No industries</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Stats/Dates -->
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">Metadata</h5>
                    </div>
                    <div class="card-body pt-3">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex justify-content-between">
                                <span class="fw-bold">Created:</span>
                                <span class="text-muted small">{{ $tool->created_at->format('M d, Y H:i') }}</span>
                            </li>
                            <li class="mb-2 d-flex justify-content-between">
                                <span class="fw-bold">Last Updated:</span>
                                <span class="text-muted small">{{ $tool->updated_at->format('M d, Y H:i') }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="fw-bold">Published At:</span>
                                <span
                                    class="text-muted small">{{ $tool->published_at ? $tool->published_at->format('M d, Y') : 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

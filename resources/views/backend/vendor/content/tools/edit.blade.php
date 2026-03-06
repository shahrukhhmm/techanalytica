@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Edit Product')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Products /</span> Edit {{ $tool->name }}
            </h4>
            <a href="{{ route('vendor.tools.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Back to List
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body pt-4">
                <form action="{{ route('vendor.tools.update', $tool->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                        $permissions = auth()->user()->vendor->tier->permissions ?? [];
                        $hasLongDescription = in_array('manage_long_description', $permissions);
                        $hasMultipleIndustries = in_array('manage_multiple_industries', $permissions);
                        $hasPremiumCTA = in_array('manage_premium_cta', $permissions);
                    @endphp

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label fw-bold">Product Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $tool->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="website_url" class="form-label fw-bold">Website URL</label>
                            <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                                id="website_url" name="website_url" value="{{ old('website_url', $tool->website_url) }}"
                                placeholder="https://">
                            @error('website_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label for="logo_url" class="form-label fw-bold">Product Logo URL</label>
                            <input type="url" class="form-control @error('logo_url') is-invalid @enderror"
                                id="logo_url" name="logo_url" value="{{ old('logo_url', $tool->logo_url) }}"
                                placeholder="https://example.com/logo.png">
                            <small class="text-muted">A direct URL to your product's logo</small>
                            @error('logo_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="short_description" class="form-label fw-bold">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                            name="short_description" rows="2" placeholder="Brief hook (e.g. The modern CRM for sales teams)">{{ old('short_description', $tool->short_description) }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="long_description" class="form-label fw-bold">
                            Product Overview
                            @if (!$hasLongDescription)
                                <span class="badge bg-label-warning ms-1"><i class="bx bx-lock-alt me-1"></i>Starter+</span>
                            @endif
                        </label>
                        <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description"
                            name="long_description" rows="5" placeholder="Detailed description of your product features and benefits"
                            {{ !$hasLongDescription ? 'readonly disabled' : '' }}>{{ old('long_description', $tool->long_description) }}</textarea>
                        @if (!$hasLongDescription)
                            <div class="mt-2">
                                <a href="{{ route('vendor.billing') }}" class="small text-warning fw-bold"><i
                                        class="bx bx-up-arrow-alt me-1"></i>Upgrade to Starter to unlock long
                                    description</a>
                            </div>
                        @endif
                        @error('long_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5 class="mt-5 mb-3 fw-bold border-bottom pb-2">Classification</h5>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold mb-2">Categories</label>
                            <p class="text-muted small mb-2">Select the categories that best describe your software.</p>
                            <div class="border rounded p-3"
                                style="max-height: 250px; overflow-y: auto; background-color: #f8f9fa;">
                                @php $selectedCategories = $tool->categories->pluck('id')->toArray(); @endphp
                                @foreach ($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" id="cat-{{ $category->id }}"
                                            {{ is_array(old('categories', $selectedCategories)) && in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat-{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold mb-2">
                                Targeted Industries
                                @if (!$hasMultipleIndustries)
                                    <span class="badge bg-label-warning ms-1"><i
                                            class="bx bx-lock-alt me-1"></i>Growth+</span>
                                @endif
                            </label>
                            <p class="text-muted small mb-2">Which industries does your product cater to? @if (!$hasMultipleIndustries)
                                    <span class="text-warning fw-bold">(Limited to 1)</span>
                                @endif
                            </p>
                            <div class="border rounded p-3"
                                style="max-height: 250px; overflow-y: auto; background-color: #f8f9fa;">
                                @php $selectedIndustries = $tool->industries->pluck('id')->toArray(); @endphp
                                @foreach ($industries as $industry)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input industry-check" type="checkbox" name="industries[]"
                                            value="{{ $industry->id }}" id="ind-{{ $industry->id }}"
                                            {{ is_array(old('industries', $selectedIndustries)) && in_array($industry->id, old('industries', $selectedIndustries)) ? 'checked' : '' }}
                                            {{ !$hasMultipleIndustries && count($selectedIndustries) >= 1 && !in_array($industry->id, $selectedIndustries) ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="ind-{{ $industry->id }}">
                                            {{ $industry->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @if (!$hasMultipleIndustries)
                                <div class="mt-2">
                                    <a href="{{ route('vendor.billing') }}" class="small text-warning fw-bold"><i
                                            class="bx bx-up-arrow-alt me-1"></i>Upgrade to Growth to unlock up to 5
                                        industries</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3 fw-bold border-bottom pb-2">Call to Action & Status</h5>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="cta_type" class="form-label fw-bold">
                                Call-to-Action Type
                                @if (!$hasPremiumCTA)
                                    <span class="badge bg-label-warning ms-1"><i
                                            class="bx bx-lock-alt me-1"></i>Starter+</span>
                                @endif
                            </label>
                            <select class="form-select @error('cta_type') is-invalid @enderror" id="cta_type"
                                name="cta_type">
                                <option value="">Select Primary CTA</option>
                                <option value="website"
                                    {{ old('cta_type', $tool->cta_type) == 'website' ? 'selected' : '' }}>Visit Website
                                </option>
                                <option value="signup"
                                    {{ old('cta_type', $tool->cta_type) == 'signup' ? 'selected' : '' }}
                                    {{ !$hasPremiumCTA ? 'disabled' : '' }}>Sign Up @if (!$hasPremiumCTA)
                                        (Starter+)
                                    @endif
                                </option>
                                <option value="demo" {{ old('cta_type', $tool->cta_type) == 'demo' ? 'selected' : '' }}
                                    {{ !$hasPremiumCTA ? 'disabled' : '' }}>Book a Demo @if (!$hasPremiumCTA)
                                        (Starter+)
                                    @endif
                                </option>
                                <option value="free_trial"
                                    {{ old('cta_type', $tool->cta_type) == 'free_trial' ? 'selected' : '' }}
                                    {{ !$hasPremiumCTA ? 'disabled' : '' }}>Start Free Trial @if (!$hasPremiumCTA)
                                        (Starter+)
                                    @endif
                                </option>
                                <option value="contact_sales"
                                    {{ old('cta_type', $tool->cta_type) == 'contact_sales' ? 'selected' : '' }}
                                    {{ !$hasPremiumCTA ? 'disabled' : '' }}>Contact Sales @if (!$hasPremiumCTA)
                                        (Starter+)
                                    @endif
                                </option>
                            </select>
                            @if (!$hasPremiumCTA)
                                <div class="mt-2">
                                    <a href="{{ route('vendor.billing') }}" class="small text-warning fw-bold"><i
                                            class="bx bx-up-arrow-alt me-1"></i>Upgrade to Starter for custom CTAs</a>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="cta_url" class="form-label fw-bold">CTA Destination URL</label>
                            <input type="url" class="form-control @error('cta_url') is-invalid @enderror"
                                id="cta_url" name="cta_url" value="{{ old('cta_url', $tool->cta_url) }}"
                                placeholder="https://">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 mb-4">
                            @if ($tool->status === 'published')
                                <div class="alert alert-warning border-0 shadow-none mb-0">
                                    <i class="bx bx-info-circle me-1"></i> This product is <strong>Published</strong>. Any
                                    changes you save here will be submitted as a <strong>Pending Update</strong> and won't
                                    affect the live product until an admin approves them.
                                </div>
                            @else
                                <div class="alert alert-info border-0 shadow-none mb-0">
                                    <i class="bx bx-info-circle me-1"></i> This product is currently in
                                    <strong>{{ ucfirst($tool->status) }}</strong> state.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-2">
                        <a href="{{ route('vendor.tools.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

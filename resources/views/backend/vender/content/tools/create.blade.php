@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Add New Product')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Products /</span> Add New
            </h4>
            <a href="{{ route('vendor.tools.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Back to List
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body pt-4">
                <form action="{{ route('vendor.tools.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label fw-bold">Product Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="Enter your software name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="website_url" class="form-label fw-bold">Website URL</label>
                            <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                                id="website_url" name="website_url" value="{{ old('website_url') }}" placeholder="https://">
                            @error('website_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label for="logo_url" class="form-label fw-bold">Product Logo URL</label>
                            <input type="url" class="form-control @error('logo_url') is-invalid @enderror"
                                id="logo_url" name="logo_url" value="{{ old('logo_url') }}"
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
                            name="short_description" rows="2" placeholder="Brief hook (e.g. The modern CRM for sales teams)">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="long_description" class="form-label fw-bold">Product Overview</label>
                        <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description"
                            name="long_description" rows="5" placeholder="Detailed description of your product features and benefits">{{ old('long_description') }}</textarea>
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
                                @foreach ($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" id="cat-{{ $category->id }}"
                                            {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat-{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold mb-2">Targeted Industries</label>
                            <p class="text-muted small mb-2">Which industries does your product cater to?</p>
                            <div class="border rounded p-3"
                                style="max-height: 250px; overflow-y: auto; background-color: #f8f9fa;">
                                @foreach ($industries as $industry)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="industries[]"
                                            value="{{ $industry->id }}" id="ind-{{ $industry->id }}"
                                            {{ is_array(old('industries')) && in_array($industry->id, old('industries')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ind-{{ $industry->id }}">
                                            {{ $industry->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('industries')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3 fw-bold border-bottom pb-2">Call to Action & Status</h5>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="cta_type" class="form-label fw-bold">Call-to-Action Type</label>
                            <select class="form-select @error('cta_type') is-invalid @enderror" id="cta_type"
                                name="cta_type">
                                <option value="">Select Primary CTA</option>
                                <option value="website" {{ old('cta_type') == 'website' ? 'selected' : '' }}>Visit Website
                                </option>
                                <option value="signup" {{ old('cta_type') == 'signup' ? 'selected' : '' }}>Sign Up
                                </option>
                                <option value="demo" {{ old('cta_type') == 'demo' ? 'selected' : '' }}>Book a Demo
                                </option>
                                <option value="free_trial" {{ old('cta_type') == 'free_trial' ? 'selected' : '' }}>Start
                                    Free Trial</option>
                                <option value="contact_sales" {{ old('cta_type') == 'contact_sales' ? 'selected' : '' }}>
                                    Contact Sales</option>
                            </select>
                            @error('cta_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="cta_url" class="form-label fw-bold">CTA Destination URL</label>
                            <input type="url" class="form-control @error('cta_url') is-invalid @enderror"
                                id="cta_url" name="cta_url" value="{{ old('cta_url') }}" placeholder="https://">
                            @error('cta_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="alert alert-info border-0 shadow-none mb-0">
                                <i class="bx bx-info-circle me-1"></i> New products are saved as <strong>Draft</strong>.
                                You can submit them for admin review from the product list after saving.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-2">
                        <a href="{{ route('vendor.tools.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Submit a New Product')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white p-4 border-bottom">
                        <h4 class="mb-0 fw-bold"><i class="bx bx-plus me-1 text-primary"></i> Listing Request Form</h4>
                        <p class="text-muted small mb-0 mt-1">Provide accurate details for a faster review.</p>
                    </div>
                    <div class="card-body p-4 pt-5">
                        <form action="{{ route('vendor.submit.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-4">
                                <!-- Basic Information -->
                                <div class="col-12 border-bottom pb-4 mb-2">
                                    <h6 class="fw-bold mb-3">1. Basic Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input type="text"
                                                class="form-control @error('product_name') is-invalid @enderror"
                                                id="product_name" name="product_name" placeholder="e.g., TechBot AI"
                                                value="{{ old('product_name') }}" required>
                                            @error('product_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="logo" class="form-label">Product Logo (PNG/JPG, max 2MB)</label>
                                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                                id="logo" name="logo" accept="image/*">
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="description" class="form-label">Product Overview /
                                                Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                rows="5" placeholder="Share what your product does, its core value proposition, and key AI features..."
                                                required>{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Categorization -->
                                <div class="col-12 border-bottom pb-4 mb-2">
                                    <h6 class="fw-bold mb-3">2. Categorization & Deployment</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="category_id" class="form-label">Primary Category</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                                <option value="" disabled selected>Select category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Deployment Options</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="deployment_options[]" value="SaaS" id="dep_saas">
                                                    <label class="form-check-label" for="dep_saas">SaaS / Cloud</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="deployment_options[]" value="On-Premise" id="dep_onprem">
                                                    <label class="form-check-label" for="dep_onprem">On-Premise</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="deployment_options[]" value="Mobile App" id="dep_mobile">
                                                    <label class="form-check-label" for="dep_mobile">Mobile App</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Target Market -->
                                <div class="col-12 border-bottom pb-4 mb-2">
                                    <h6 class="fw-bold mb-3">3. Target Market & Personas</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="target_market" class="form-label">End User Personas</label>
                                            <input type="text"
                                                class="form-control @error('target_market') is-invalid @enderror"
                                                id="target_market" name="target_market"
                                                placeholder="e.g., Data Scientists, Marketing Managers..."
                                                value="{{ old('target_market') }}" required>
                                            @error('target_market')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="company_size" class="form-label">Target Company Size</label>
                                            <select class="form-select @error('company_size') is-invalid @enderror"
                                                id="company_size" name="company_size" required>
                                                <option value="" disabled selected>Select size</option>
                                                <option value="Startups">Startups</option>
                                                <option value="SME">Small to Mid-Size Enterprise (SME)</option>
                                                <option value="Large Enterprise">Large Enterprise</option>
                                                <option value="All Sizes">All Sizes</option>
                                            </select>
                                            @error('company_size')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Validation -->
                                <div class="col-12">
                                    <div class="bg-label-primary p-3 rounded-3 mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_ai_focused"
                                                id="is_ai_focused" required>
                                            <label class="form-check-label fw-bold py-1" for="is_ai_focused">
                                                I confirm this product is AI-focused and complies with TechAnalytica's
                                                listing policy.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('vendor.submit') }}" class="btn btn-label-secondary">Back to
                                    Guidelines</a>
                                <button type="submit" class="btn btn-primary px-5 shadow-sm">Review & Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

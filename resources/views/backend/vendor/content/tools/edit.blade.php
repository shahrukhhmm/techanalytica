@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Edit Product')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Products /</span> Edit: {{ $tool->name }}
            </h4>
            <a href="{{ route('vendor.tools.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Back to List
            </a>
        </div>

        @if ($tool->has_pending_update)
            <div class="alert alert-warning mb-4 shadow-sm" role="alert">
                <h5 class="alert-heading mb-1"><i class="bx bx-time-five me-1"></i> Changes Pending Approval</h5>
                <p class="mb-0">You have previously submitted modifications to this product that are awaiting administrative review. Submitting new changes will update your pending request.</p>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body pt-4">
                <form action="{{ route('vendor.tools.update', $tool) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $tool->name) }}" required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="ai_type" class="form-label fw-bold">AI Type Classification</label>
                            <select class="form-select @error('ai_type') is-invalid @enderror" id="ai_type" name="ai_type">
                                <option value="">Select AI Type</option>
                                <option value="LLM & Conversational AI" {{ old('ai_type', $tool->ai_type) == 'LLM & Conversational AI' ? 'selected' : '' }}>LLM & Conversational AI</option>
                                <option value="Computer Vision & Image" {{ old('ai_type', $tool->ai_type) == 'Computer Vision & Image' ? 'selected' : '' }}>Computer Vision & Image</option>
                                <option value="Voice, Audio & Speech" {{ old('ai_type', $tool->ai_type) == 'Voice, Audio & Speech' ? 'selected' : '' }}>Voice, Audio & Speech</option>
                                <option value="Code Assistant & Dev AI" {{ old('ai_type', $tool->ai_type) == 'Code Assistant & Dev AI' ? 'selected' : '' }}>Code Assistant & Dev AI</option>
                                <option value="Video Generation & Studio" {{ old('ai_type', $tool->ai_type) == 'Video Generation & Studio' ? 'selected' : '' }}>Video Generation & Studio</option>
                                <option value="Autonomous Agent & CLI" {{ old('ai_type', $tool->ai_type) == 'Autonomous Agent & CLI' ? 'selected' : '' }}>Autonomous Agent & CLI</option>
                                <option value="Data Analytics & Predictive" {{ old('ai_type', $tool->ai_type) == 'Data Analytics & Predictive' ? 'selected' : '' }}>Data Analytics & Predictive</option>
                                <option value="Workflow & Productivity" {{ old('ai_type', $tool->ai_type) == 'Workflow & Productivity' ? 'selected' : '' }}>Workflow & Productivity</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="website_url" class="form-label fw-bold">Website URL</label>
                            <input type="url" class="form-control" id="website_url" name="website_url" value="{{ old('website_url', $tool->website_url) }}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="logo_url" class="form-label fw-bold">Product Logo URL</label>
                            <input type="url" class="form-control" id="logo_url" name="logo_url" value="{{ old('logo_url', $tool->logo_url) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="short_description" class="form-label fw-bold">Short Description</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="2">{{ old('short_description', $tool->short_description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="long_description" class="form-label fw-bold">Long Overview & Architecture</label>
                        <textarea class="form-control" id="long_description" name="long_description" rows="4">{{ old('long_description', $tool->long_description) }}</textarea>
                    </div>

                    <!-- Pros & Cons Grid -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-success fw-bold"><i class="bx bx-check-circle"></i> Key Advantages (Pros)</label>
                            <div id="vendor-pros-container">
                                @php
                                    $prosList = old('pros', $tool->pros ?? ['High scalability and low inference latency', 'Native REST API support']);
                                @endphp
                                @foreach($prosList as $pro)
                                    <input type="text" name="pros[]" class="form-control mb-2" value="{{ $pro }}" placeholder="Enter advantage">
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="addVendorPro()">+ Add Pro</button>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-warning fw-bold"><i class="bx bx-x-circle"></i> Potential Drawbacks (Cons)</label>
                            <div id="vendor-cons-container">
                                @php
                                    $consList = old('cons', $tool->cons ?? ['Requires fine-tuning for custom domain datasets']);
                                @endphp
                                @foreach($consList as $con)
                                    <input type="text" name="cons[]" class="form-control mb-2" value="{{ $con }}" placeholder="Enter drawback">
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="addVendorCon()">+ Add Con</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="pricing_text" class="form-label fw-bold">Pricing Label</label>
                            <input type="text" class="form-control" id="pricing_text" name="pricing_text" value="{{ old('pricing_text', $tool->pricing_text) }}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="cta_type" class="form-label fw-bold">Call To Action Button</label>
                            <select class="form-select" id="cta_type" name="cta_type">
                                <option value="website" {{ old('cta_type', $tool->cta_type) == 'website' ? 'selected' : '' }}>Visit Website</option>
                                <option value="signup" {{ old('cta_type', $tool->cta_type) == 'signup' ? 'selected' : '' }}>Sign Up</option>
                                <option value="demo" {{ old('cta_type', $tool->cta_type) == 'demo' ? 'selected' : '' }}>Book Demo</option>
                                <option value="free_trial" {{ old('cta_type', $tool->cta_type) == 'free_trial' ? 'selected' : '' }}>Start Free Trial</option>
                                <option value="contact_sales" {{ old('cta_type', $tool->cta_type) == 'contact_sales' ? 'selected' : '' }}>Contact Sales</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Categories</label>
                            <div class="border p-3 rounded" style="max-height: 180px; overflow-y: auto;">
                                @php $selectedCats = old('categories', $tool->categories->pluck('id')->toArray()); @endphp
                                @foreach ($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" id="vcat-{{ $category->id }}"
                                            {{ in_array($category->id, $selectedCats) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vcat-{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Industries</label>
                            <div class="border p-3 rounded" style="max-height: 180px; overflow-y: auto;">
                                @php $selectedInds = old('industries', $tool->industries->pluck('id')->toArray()); @endphp
                                @foreach ($industries as $industry)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="industries[]"
                                            value="{{ $industry->id }}" id="vind-{{ $industry->id }}"
                                            {{ in_array($industry->id, $selectedInds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vind-{{ $industry->id }}">
                                            {{ $industry->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('vendor.tools.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            {{ $tool->status === 'published' ? 'Save & Submit for Approval' : 'Update Draft' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addVendorPro() {
            const c = document.getElementById('vendor-pros-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'pros[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter advantage';
            c.appendChild(input);
        }

        function addVendorCon() {
            const c = document.getElementById('vendor-cons-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'cons[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter drawback';
            c.appendChild(input);
        }
    </script>
@endsection

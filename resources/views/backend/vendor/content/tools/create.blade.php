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
                            <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="Enter your software name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="ai_type" class="form-label fw-bold">AI Type Classification</label>
                            <select class="form-select @error('ai_type') is-invalid @enderror" id="ai_type" name="ai_type">
                                <option value="">Select AI Type</option>
                                <option value="LLM & Conversational AI" {{ old('ai_type') == 'LLM & Conversational AI' ? 'selected' : '' }}>LLM & Conversational AI</option>
                                <option value="Computer Vision & Image" {{ old('ai_type') == 'Computer Vision & Image' ? 'selected' : '' }}>Computer Vision & Image</option>
                                <option value="Voice, Audio & Speech" {{ old('ai_type') == 'Voice, Audio & Speech' ? 'selected' : '' }}>Voice, Audio & Speech</option>
                                <option value="Code Assistant & Dev AI" {{ old('ai_type') == 'Code Assistant & Dev AI' ? 'selected' : '' }}>Code Assistant & Dev AI</option>
                                <option value="Video Generation & Studio" {{ old('ai_type') == 'Video Generation & Studio' ? 'selected' : '' }}>Video Generation & Studio</option>
                                <option value="Autonomous Agent & CLI" {{ old('ai_type') == 'Autonomous Agent & CLI' ? 'selected' : '' }}>Autonomous Agent & CLI</option>
                                <option value="Data Analytics & Predictive" {{ old('ai_type') == 'Data Analytics & Predictive' ? 'selected' : '' }}>Data Analytics & Predictive</option>
                                <option value="Workflow & Productivity" {{ old('ai_type') == 'Workflow & Productivity' ? 'selected' : '' }}>Workflow & Productivity</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="website_url" class="form-label fw-bold">Website URL</label>
                            <input type="url" class="form-control" id="website_url" name="website_url" value="{{ old('website_url') }}" placeholder="https://example.com">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="logo_url" class="form-label fw-bold">Product Logo URL</label>
                            <input type="url" class="form-control" id="logo_url" name="logo_url" value="{{ old('logo_url') }}" placeholder="https://example.com/logo.png">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="short_description" class="form-label fw-bold">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                            name="short_description" rows="2" placeholder="Brief hook (e.g. The modern generative AI assistant for software developers)">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="long_description" class="form-label fw-bold">Long Overview & Architecture</label>
                        <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description"
                            name="long_description" rows="4" placeholder="Detailed product capabilities and specs...">{{ old('long_description') }}</textarea>
                    </div>

                    <!-- Pros & Cons Grid -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-success fw-bold"><i class="bx bx-check-circle"></i> Key Advantages (Pros)</label>
                            <div id="vendor-pros-container">
                                <input type="text" name="pros[]" class="form-control mb-2" placeholder="e.g. 10x faster response time than GPT-4">
                                <input type="text" name="pros[]" class="form-control mb-2" placeholder="e.g. End-to-end data encryption & SOC2">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="addVendorPro()">+ Add Pro</button>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-warning fw-bold"><i class="bx bx-x-circle"></i> Potential Drawbacks (Cons)</label>
                            <div id="vendor-cons-container">
                                <input type="text" name="cons[]" class="form-control mb-2" placeholder="e.g. GPU compute requires self-hosting for enterprise">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="addVendorCon()">+ Add Con</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="pricing_text" class="form-label fw-bold">Pricing Label</label>
                            <input type="text" class="form-control" id="pricing_text" name="pricing_text" value="{{ old('pricing_text') }}" placeholder="e.g. Free Tier / $19/mo">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="cta_type" class="form-label fw-bold">Call To Action Button</label>
                            <select class="form-select" id="cta_type" name="cta_type">
                                <option value="website">Visit Website</option>
                                <option value="signup">Sign Up</option>
                                <option value="demo">Book Demo</option>
                                <option value="free_trial">Start Free Trial</option>
                                <option value="contact_sales">Contact Sales</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Categories</label>
                            <div class="border p-3 rounded" style="max-height: 180px; overflow-y: auto;">
                                @foreach ($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" id="vcat-{{ $category->id }}"
                                            {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
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
                                @foreach ($industries as $industry)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="industries[]"
                                            value="{{ $industry->id }}" id="vind-{{ $industry->id }}"
                                            {{ is_array(old('industries')) && in_array($industry->id, old('industries')) ? 'checked' : '' }}>
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
                        <button type="submit" class="btn btn-primary px-4">Save Product as Draft</button>
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

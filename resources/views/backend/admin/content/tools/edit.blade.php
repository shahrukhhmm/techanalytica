@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Edit Tool')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Edit Tool: {{ $tool->name }}</h4>
            <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.tools.update', $tool) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $tool->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="slug" class="form-label">Slug (Optional)</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $tool->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="ai_type" class="form-label">AI Type Classification</label>
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
                        <div class="col-md-6 mb-3">
                            <label for="vendor_id" class="form-label">Vendor</label>
                            <select class="form-select @error('vendor_id') is-invalid @enderror" id="vendor_id"
                                name="vendor_id">
                                <option value="">Select Vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ old('vendor_id', $tool->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->company_name ?? ($vendor->user->name ?? 'Vendor #'.$vendor->id) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tier_id" class="form-label">Pricing Tier</label>
                            <select class="form-select @error('tier_id') is-invalid @enderror" id="tier_id"
                                name="tier_id">
                                <option value="">Select Tier</option>
                                @foreach ($tiers as $tier)
                                    <option value="{{ $tier->id }}"
                                        {{ old('tier_id', $tool->tier_id) == $tier->id ? 'selected' : '' }}>
                                        {{ $tier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="logo_url" class="form-label">Logo URL</label>
                            <input type="url" class="form-control" id="logo_url" name="logo_url" value="{{ old('logo_url', $tool->logo_url) }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="website_url" class="form-label">Website URL</label>
                            <input type="url" class="form-control" id="website_url" name="website_url" value="{{ old('website_url', $tool->website_url) }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="pricing_text" class="form-label">Pricing Text</label>
                            <input type="text" class="form-control" id="pricing_text" name="pricing_text" value="{{ old('pricing_text', $tool->pricing_text) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cta_type" class="form-label">CTA Type</label>
                            <select class="form-select" id="cta_type" name="cta_type">
                                <option value="">Select CTA Type</option>
                                <option value="website" {{ old('cta_type', $tool->cta_type) == 'website' ? 'selected' : '' }}>Website</option>
                                <option value="signup" {{ old('cta_type', $tool->cta_type) == 'signup' ? 'selected' : '' }}>Sign Up</option>
                                <option value="demo" {{ old('cta_type', $tool->cta_type) == 'demo' ? 'selected' : '' }}>Demo</option>
                                <option value="free_trial" {{ old('cta_type', $tool->cta_type) == 'free_trial' ? 'selected' : '' }}>Free Trial</option>
                                <option value="contact_sales" {{ old('cta_type', $tool->cta_type) == 'contact_sales' ? 'selected' : '' }}>Contact Sales</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cta_url" class="form-label">CTA URL</label>
                            <input type="url" class="form-control" id="cta_url" name="cta_url" value="{{ old('cta_url', $tool->cta_url) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="2">{{ old('short_description', $tool->short_description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="long_description" class="form-label">Long Description</label>
                        <textarea class="form-control" id="long_description" name="long_description" rows="4">{{ old('long_description', $tool->long_description) }}</textarea>
                    </div>

                    <!-- Pros & Cons Grid -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-success fw-bold"><i class="bx bx-check-circle"></i> Key Advantages (Pros)</label>
                            <div id="pros-container">
                                @php
                                    $prosList = old('pros', $tool->pros ?? ['Exceptional enterprise AI performance', 'Native API & Webhook support', 'High user satisfaction rating']);
                                @endphp
                                @foreach($prosList as $pro)
                                    <input type="text" name="pros[]" class="form-control mb-2" value="{{ $pro }}" placeholder="Enter advantage">
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="addProField()">+ Add Pro</button>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-warning fw-bold"><i class="bx bx-x-circle"></i> Potential Drawbacks (Cons)</label>
                            <div id="cons-container">
                                @php
                                    $consList = old('cons', $tool->cons ?? ['Requires onboarding for non-technical team members', 'Advanced features limited to higher tiers']);
                                @endphp
                                @foreach($consList as $con)
                                    <input type="text" name="cons[]" class="form-control mb-2" value="{{ $con }}" placeholder="Enter drawback">
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="addConField()">+ Add Con</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categories</label>
                            <div class="border p-3 rounded" style="max-height: 200px; overflow-y: auto;">
                                @php $selectedCats = old('categories', $tool->categories->pluck('id')->toArray()); @endphp
                                @foreach ($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" id="cat-{{ $category->id }}"
                                            {{ in_array($category->id, $selectedCats) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat-{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Industries</label>
                            <div class="border p-3 rounded" style="max-height: 200px; overflow-y: auto;">
                                @php $selectedInds = old('industries', $tool->industries->pluck('id')->toArray()); @endphp
                                @foreach ($industries as $industry)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="industries[]"
                                            value="{{ $industry->id }}" id="ind-{{ $industry->id }}"
                                            {{ in_array($industry->id, $selectedInds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ind-{{ $industry->id }}">
                                            {{ $industry->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="draft" {{ old('status', $tool->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending" {{ old('status', $tool->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="published" {{ old('status', $tool->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status', $tool->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-center mt-4">
                            <div class="form-check">
                                <input type="hidden" name="is_featured" value="0">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $tool->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_featured">Featured Badge</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-center mt-4">
                            <div class="form-check">
                                <input type="hidden" name="is_verified" value="0">
                                <input class="form-check-input" type="checkbox" name="is_verified" value="1" id="is_verified" {{ old('is_verified', $tool->is_verified) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_verified">Verified Leader</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Update Tool</button>
                        <a href="{{ route('admin.tools.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addProField() {
            const container = document.getElementById('pros-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'pros[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter advantage';
            container.appendChild(input);
        }

        function addConField() {
            const container = document.getElementById('cons-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'cons[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter drawback';
            container.appendChild(input);
        }
    </script>
@endsection

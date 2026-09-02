@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Create Tool')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Create Tool</h4>
            <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.tools.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="slug" class="form-label">Slug (Optional)</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="ai_type" class="form-label">AI Type Classification</label>
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
                            @error('ai_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                        {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->company_name ?? ($vendor->user->name ?? 'Vendor #'.$vendor->id) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vendor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tier_id" class="form-label">Pricing Tier</label>
                            <select class="form-select @error('tier_id') is-invalid @enderror" id="tier_id"
                                name="tier_id">
                                <option value="">Select Tier</option>
                                @foreach ($tiers as $tier)
                                    <option value="{{ $tier->id }}"
                                        {{ old('tier_id') == $tier->id ? 'selected' : '' }}>
                                        {{ $tier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="logo_url" class="form-label">Logo URL</label>
                            <input type="url" class="form-control @error('logo_url') is-invalid @enderror"
                                id="logo_url" name="logo_url" value="{{ old('logo_url') }}"
                                placeholder="https://example.com/logo.png">
                            @error('logo_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="website_url" class="form-label">Website URL</label>
                            <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                                id="website_url" name="website_url" value="{{ old('website_url') }}">
                            @error('website_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="pricing_text" class="form-label">Pricing Text</label>
                            <input type="text" class="form-control @error('pricing_text') is-invalid @enderror"
                                id="pricing_text" name="pricing_text" value="{{ old('pricing_text') }}"
                                placeholder="e.g. Freemium / Starting from $20/mo">
                            @error('pricing_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cta_type" class="form-label">CTA Type</label>
                            <select class="form-select @error('cta_type') is-invalid @enderror" id="cta_type"
                                name="cta_type">
                                <option value="">Select CTA Type</option>
                                <option value="website" {{ old('cta_type') == 'website' ? 'selected' : '' }}>Website</option>
                                <option value="signup" {{ old('cta_type') == 'signup' ? 'selected' : '' }}>Sign Up</option>
                                <option value="demo" {{ old('cta_type') == 'demo' ? 'selected' : '' }}>Demo</option>
                                <option value="free_trial" {{ old('cta_type') == 'free_trial' ? 'selected' : '' }}>Free Trial</option>
                                <option value="contact_sales" {{ old('cta_type') == 'contact_sales' ? 'selected' : '' }}>Contact Sales</option>
                            </select>
                            @error('cta_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cta_url" class="form-label">CTA URL</label>
                            <input type="url" class="form-control @error('cta_url') is-invalid @enderror" id="cta_url"
                                name="cta_url" value="{{ old('cta_url') }}">
                            @error('cta_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                            name="short_description" rows="2">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="long_description" class="form-label">Long Description</label>
                        <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description"
                            name="long_description" rows="4">{{ old('long_description') }}</textarea>
                        @error('long_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Pros -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-success fw-bold"><i class="bx bx-check-circle"></i> Key Advantages (Pros)</label>
                            <div id="pros-container">
                                <input type="text" name="pros[]" class="form-control mb-2" placeholder="e.g. Exceptional LLM context window size">
                                <input type="text" name="pros[]" class="form-control mb-2" placeholder="e.g. Seamless API & webhook integration">
                                <input type="text" name="pros[]" class="form-control mb-2" placeholder="e.g. Generous free starter tier">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="addProField()">+ Add Pro</button>
                        </div>

                        <!-- Cons -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-warning fw-bold"><i class="bx bx-x-circle"></i> Potential Drawbacks (Cons)</label>
                            <div id="cons-container">
                                <input type="text" name="cons[]" class="form-control mb-2" placeholder="e.g. Steep learning curve for non-technical users">
                                <input type="text" name="cons[]" class="form-control mb-2" placeholder="e.g. Enterprise add-on pricing can be high">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="addConField()">+ Add Con</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categories</label>
                            <div class="border p-3 rounded" style="max-height: 200px; overflow-y: auto;">
                                @foreach ($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" id="cat-{{ $category->id }}"
                                            {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
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
                                @foreach ($industries as $industry)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="industries[]"
                                            value="{{ $industry->id }}" id="ind-{{ $industry->id }}"
                                            {{ is_array(old('industries')) && in_array($industry->id, old('industries')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ind-{{ $industry->id }}">
                                            {{ $industry->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="media_screenshot_url" class="form-label">Demo Screenshot Image URL (Optional)</label>
                            <input type="url" class="form-control" id="media_screenshot_url" name="media_screenshot_url" placeholder="https://example.com/screenshot.jpg">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Create Tool</button>
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
            input.placeholder = 'Enter additional advantage';
            container.appendChild(input);
        }

        function addConField() {
            const container = document.getElementById('cons-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'cons[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter additional drawback';
            container.appendChild(input);
        }
    </script>
@endsection

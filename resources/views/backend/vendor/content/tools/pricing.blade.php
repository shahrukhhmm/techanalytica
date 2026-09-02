@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Product Pricing Configuration')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1"><span class="text-muted fw-light">Products /</span> Pricing Configuration</h4>
                <p class="text-muted small mb-0">Configure the public pricing model, tiers, and call-to-action (CTA) for your software product.</p>
            </div>
            @if ($tools->count() > 1)
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bx bx-wrench me-1"></i> Managing: <strong>{{ $tool->name }}</strong>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($tools as $t)
                            <li>
                                <a class="dropdown-item {{ $t->id === $tool->id ? 'active' : '' }}"
                                    href="{{ route('vendor.switch-tool', $t->id) }}">
                                    {{ $t->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header border-bottom py-3 bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bx bx-tag me-1 text-primary"></i> Pricing Model & Tiers for {{ $tool->name }}</h5>
                        <span class="badge bg-label-info">{{ $tool->ai_type ?? 'AI Product' }}</span>
                    </div>
                    <div class="card-body pt-4">
                        <form action="{{ route('vendor.pricing.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tool_id" value="{{ $tool->id }}">

                            <!-- Pricing Display Label -->
                            <div class="mb-4">
                                <label for="pricing_text" class="form-label fw-bold">Public Pricing Summary Label</label>
                                <input type="text" class="form-control" id="pricing_text" name="pricing_text"
                                    value="{{ old('pricing_text', $tool->pricing_text) }}"
                                    placeholder="e.g. Free Tier Available / From $19/mo / Custom Enterprise">
                                <small class="text-muted">This badge label appears on your product card across directory grids and comparisons.</small>
                            </div>

                            <!-- Call to Action -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="cta_type" class="form-label fw-bold">Primary Call-to-Action (CTA)</label>
                                    <select class="form-select" id="cta_type" name="cta_type">
                                        <option value="website" {{ old('cta_type', $tool->cta_type) == 'website' ? 'selected' : '' }}>Visit Official Website</option>
                                        <option value="signup" {{ old('cta_type', $tool->cta_type) == 'signup' ? 'selected' : '' }}>Sign Up Now</option>
                                        <option value="demo" {{ old('cta_type', $tool->cta_type) == 'demo' ? 'selected' : '' }}>Request Demo</option>
                                        <option value="free_trial" {{ old('cta_type', $tool->cta_type) == 'free_trial' ? 'selected' : '' }}>Start Free Trial</option>
                                        <option value="contact_sales" {{ old('cta_type', $tool->cta_type) == 'contact_sales' ? 'selected' : '' }}>Contact Sales Team</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="cta_url" class="form-label fw-bold">CTA Target URL</label>
                                    <input type="url" class="form-control" id="cta_url" name="cta_url"
                                        value="{{ old('cta_url', $tool->cta_url ?? $tool->website_url) }}"
                                        placeholder="https://yourproduct.com/pricing">
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Structured Pricing Cards for the Product -->
                            <h6 class="fw-bold mb-3"><i class="bx bx-layer me-1 text-primary"></i> Product Pricing Tiers (Shown on Detail Page)</h6>

                            <div id="pricing-plans-container">
                                @php
                                    $existingPlans = old('plan_names', $tool->pricing_structured ?? []);
                                    if (empty($existingPlans)) {
                                        $existingPlans = [
                                            ['name' => 'Free / Starter', 'price' => '$0/mo', 'features' => ['Basic access', 'Community support']],
                                            ['name' => 'Pro / Team', 'price' => '$29/mo', 'features' => ['Unlimited API calls', 'Priority support', 'Team analytics']],
                                        ];
                                    }
                                @endphp

                                @foreach ($existingPlans as $idx => $plan)
                                    @php
                                        $pName = is_array($plan) ? ($plan['name'] ?? '') : $plan;
                                        $pPrice = is_array($plan) ? ($plan['price'] ?? '') : (old('plan_prices')[$idx] ?? '');
                                        $pFeats = is_array($plan) ? (isset($plan['features']) && is_array($plan['features']) ? implode("\n", $plan['features']) : '') : (old('plan_features')[$idx] ?? '');
                                    @endphp
                                    <div class="card bg-label-secondary border-0 mb-3 plan-card-item">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-bold small text-uppercase">Tier #<span class="plan-num">{{ $loop->iteration }}</span></span>
                                                <button type="button" class="btn btn-xs btn-outline-danger" onclick="this.closest('.plan-card-item').remove()">
                                                    <i class="bx bx-trash"></i> Remove
                                                </button>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small mb-1">Plan Name</label>
                                                    <input type="text" name="plan_names[]" class="form-control form-control-sm"
                                                        value="{{ $pName }}" placeholder="e.g. Starter, Pro, Enterprise">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small mb-1">Price Tag</label>
                                                    <input type="text" name="plan_prices[]" class="form-control form-control-sm"
                                                        value="{{ $pPrice }}" placeholder="e.g. Free, $29/mo, Custom">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label class="form-label small mb-1">Features (One per line)</label>
                                                    <textarea name="plan_features[]" rows="2" class="form-control form-control-sm"
                                                        placeholder="Feature 1&#10;Feature 2&#10;Feature 3">{{ $pFeats }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-primary mb-4" onclick="addPricingPlan()">
                                <i class="bx bx-plus me-1"></i> Add Another Pricing Tier
                            </button>

                            <div class="d-flex justify-content-end gap-2 border-top pt-3">
                                <a href="{{ route('vendor.tools.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-save me-1"></i> Save Pricing Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Side Info Card -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4 bg-label-primary">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2"><i class="bx bx-bulb me-1"></i> Pricing Best Practices</h6>
                        <p class="small text-muted mb-3">
                            Buyers on TechAnalytica look for clear, transparent pricing tiers before making software purchase decisions.
                        </p>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2"><i class="bx bx-check text-success me-1"></i> Mention free trials or freemium tiers clearly.</li>
                            <li class="mb-2"><i class="bx bx-check text-success me-1"></i> Provide a direct CTA linking to your checkout or demo page.</li>
                            <li class="mb-0"><i class="bx bx-check text-success me-1"></i> Keep pricing updated to maintain trust with buyers.</li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">Platform Subscription</h6>
                        <p class="small text-muted mb-3">
                            Current platform tier for this product: <span class="badge bg-primary">{{ $tool->tier->name ?? 'Free Plan' }}</span>
                        </p>
                        <a href="{{ route('vendor.billing') }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bx bx-credit-card me-1"></i> Manage Vendor Subscription
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addPricingPlan() {
            const container = document.getElementById('pricing-plans-container');
            const count = container.querySelectorAll('.plan-card-item').length + 1;
            const card = document.createElement('div');
            card.className = 'card bg-label-secondary border-0 mb-3 plan-card-item';
            card.innerHTML = `
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold small text-uppercase">Tier #<span class="plan-num">${count}</span></span>
                        <button type="button" class="btn btn-xs btn-outline-danger" onclick="this.closest('.plan-card-item').remove()">
                            <i class="bx bx-trash"></i> Remove
                        </button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small mb-1">Plan Name</label>
                            <input type="text" name="plan_names[]" class="form-control form-control-sm" placeholder="e.g. Starter, Pro, Enterprise">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small mb-1">Price Tag</label>
                            <input type="text" name="plan_prices[]" class="form-control form-control-sm" placeholder="e.g. Free, $29/mo, Custom">
                        </div>
                        <div class="col-12 mt-2">
                            <label class="form-label small mb-1">Features (One per line)</label>
                            <textarea name="plan_features[]" rows="2" class="form-control form-control-sm" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(card);
        }
    </script>
@endsection

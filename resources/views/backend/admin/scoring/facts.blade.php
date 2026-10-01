@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Product Facts — ' . $tool->name)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.scoring.dashboard') }}">Scoring</a></li>
            <li class="breadcrumb-item active">{{ $tool->name }} — Facts</li>
        </ol>
    </nav>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-3" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">
        {{-- Tool Info + Score Trigger --}}
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex gap-3 align-items-center mb-3">
                        @if($tool->logo_url)
                            <img src="{{ $tool->logo_url }}" alt="" style="width:48px;height:48px;border-radius:8px;object-fit:contain;">
                        @endif
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $tool->name }}</h5>
                            <span class="badge bg-{{ $tool->status === 'published' ? 'success' : 'secondary' }}">{{ $tool->status }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Trigger Re-Score After Editing Facts</label>
                        <form action="{{ route('admin.scoring.score-product') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tool_id" value="{{ $tool->id }}">
                            <div class="mb-2">
                                <select name="category_id" class="form-select form-select-sm" required>
                                    <option value="">Select category…</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" name="publish" value="1" id="publish_fact" class="form-check-input">
                                <label for="publish_fact" class="form-check-label small">Publish immediately</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="bx bx-calculator me-1"></i>Re-Score Now
                            </button>
                        </form>
                    </div>
                    <div class="alert alert-info small mb-0">
                        <i class="bx bx-shield-check me-1"></i>
                        <strong>Scoring integrity:</strong> Editing facts here, not the score directly. The deterministic engine recalculates from facts.
                    </div>
                </div>
            </div>

            {{-- Add New Fact --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-plus-circle text-success me-2"></i>Add / Update Fact</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.scoring.facts.update', $tool->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Field Key</label>
                            <input type="text" name="field_key" class="form-control form-control-sm"
                                placeholder="e.g. has_api, capability_depth_score" required
                                list="fact-keys">
                            <datalist id="fact-keys">
                                {{-- Core capability facts --}}
                                <option value="capability_depth_score">
                                <option value="capability_count">
                                <option value="ai_relevance_score">
                                <option value="ai_capability_depth_score">
                                <option value="ai_control_score">
                                <option value="ai_differentiation_score">
                                <option value="onboarding_score">
                                <option value="workflow_clarity_score">
                                <option value="time_to_value_score">
                                <option value="adoption_support_score">
                                <option value="has_api">
                                <option value="has_webhooks">
                                <option value="has_data_export">
                                <option value="extensibility_score">
                                <option value="team_workflow_fit_score">
                                <option value="pricing_public">
                                <option value="pricing_terms_clear">
                                <option value="pricing_transparency_score">
                                <option value="entry_value_score">
                                <option value="capability_price_value_score">
                                <option value="has_free_trial">
                                <option value="has_monthly_billing">
                                <option value="commercial_flexibility_score">
                                <option value="has_privacy_policy">
                                <option value="has_data_deletion">
                                <option value="privacy_score">
                                <option value="security_score">
                                <option value="has_status_page">
                                <option value="has_support_channel">
                                <option value="reliability_score">
                                <option value="governance_score">
                                <option value="business_readiness_score">
                                <option value="customer_theme_score">
                                <option value="has_release_last_12m">
                                <option value="has_maintained_docs">
                                <option value="maintenance_activity_score">
                                <option value="product_progress_score">
                                <option value="is_abandoned">
                                <option value="is_core_broken">
                                <option value="platform_continuity_score">
                                <option value="integration_count">
                            </datalist>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Value</label>
                            <input type="text" name="value" class="form-control form-control-sm"
                                placeholder="true / false / 0-100 / text">
                            <small class="text-muted">Boolean: true/false. Score: 0–100. Presence: true/false.</small>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Status</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="verified">Verified</option>
                                <option value="unverified" selected>Unverified</option>
                                <option value="disputed">Disputed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Reason for change</label>
                            <input type="text" name="reason" class="form-control form-control-sm" placeholder="Why are you setting this?">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100">Save Fact</button>
                    </form>
                </div>
            </div>

            {{-- Add Evidence Source --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-link text-info me-2"></i>Add Evidence Source</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.scoring.evidence-sources.store', $tool->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <select name="source_type" class="form-select form-select-sm" required>
                                <option value="">Source Type…</option>
                                <option value="vendor_homepage">Vendor Homepage</option>
                                <option value="product_docs">Product Documentation</option>
                                <option value="pricing_page">Pricing Page</option>
                                <option value="security_trust">Security/Trust Center</option>
                                <option value="changelog">Changelog/Release Notes</option>
                                <option value="integration_directory">Integration Directory</option>
                                <option value="review_platform">Review Platform</option>
                                <option value="manual_entry">Manual Entry</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <select name="source_family" class="form-select form-select-sm" required>
                                <option value="">Source Family…</option>
                                <option value="vendor_controlled">Vendor Controlled</option>
                                <option value="g2">G2</option>
                                <option value="gartner_digital_markets">Gartner Digital Markets (Capterra/GetApp/SA)</option>
                                <option value="trustradius">TrustRadius</option>
                                <option value="app_marketplace">App Marketplace</option>
                                <option value="reddit_community">Reddit/Community (qualitative only)</option>
                                <option value="techanalytica">TechAnalytica Reviews</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <input type="url" name="url" class="form-control form-control-sm" placeholder="https://…" required>
                        </div>
                        <div class="mb-2">
                            <select name="authority_level" class="form-select form-select-sm">
                                <option value="primary">Primary</option>
                                <option value="secondary">Secondary</option>
                                <option value="corroborating">Corroborating</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <select name="allowed_usage_mode" class="form-select form-select-sm">
                                <option value="full">Full</option>
                                <option value="aggregate_only">Aggregate Only</option>
                                <option value="manual_entry">Manual Entry</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="number" name="refresh_ttl_days" class="form-control form-control-sm" placeholder="Refresh TTL (days, optional)">
                        </div>
                        <button type="submit" class="btn btn-info btn-sm w-100 text-white">Add Source</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Product Facts Table + Review Aggregates --}}
        <div class="col-lg-8">

            {{-- Product Facts --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-semibold"><i class="bx bx-table text-primary me-2"></i>
                        Product Facts ({{ $productFacts->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($productFacts->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="bx bx-data display-4 opacity-25"></i>
                            <p class="mt-2">No facts entered yet. Use the form on the left to add scoring inputs.</p>
                        </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Field Key</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                    <th>Last Verified</th>
                                    <th>Evidence IDs</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productFacts as $fact)
                                <tr>
                                    <td class="fw-semibold font-monospace">{{ $fact->field_key }}</td>
                                    <td class="text-truncate" style="max-width:180px;" title="{{ $fact->value }}">{{ $fact->value ?? '<null>' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $fact->status === 'verified' ? 'success' : ($fact->status === 'disputed' ? 'danger' : 'secondary') }}">
                                            {{ $fact->status }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $fact->last_verified_at?->diffForHumans() ?? '—' }}</td>
                                    <td class="text-muted">
                                        @if(!empty($fact->evidence_item_ids))
                                            {{ implode(', ', $fact->evidence_item_ids) }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.scoring.facts.delete', [$tool->id, $fact->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this fact?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Review Aggregates --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold"><i class="bx bx-star text-warning me-2"></i>External Review Aggregates</h5>
                    <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#add-review-modal">
                        <i class="bx bx-plus me-1"></i>Add
                    </button>
                </div>
                <div class="card-body p-0">
                    @php $aggs = \App\Models\ReviewAggregate::where('tool_id', $tool->id)->get(); @endphp
                    @if($aggs->isEmpty())
                        <div class="text-center text-muted py-4">
                            <p>No review aggregates yet. Add Bayesian-adjusted data from G2, Gartner Digital Markets, or TrustRadius.</p>
                        </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light"><tr><th>Source Family</th><th>Rating (raw)</th><th>Rating (norm)</th><th>Review Count</th><th>Retrieved</th></tr></thead>
                            <tbody>
                                @foreach($aggs as $agg)
                                <tr>
                                    <td class="fw-semibold">{{ $agg->source_family }}</td>
                                    <td>{{ $agg->rating_raw ?? '—' }} / 5</td>
                                    <td>{{ $agg->rating_norm ?? '—' }} / 100</td>
                                    <td>{{ number_format($agg->review_count) }}</td>
                                    <td class="text-muted small">{{ $agg->retrieved_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Evidence Sources --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-semibold"><i class="bx bx-link-alt text-info me-2"></i>Evidence Sources ({{ $evidenceSources->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    @forelse($evidenceSources as $src)
                    <div class="border-bottom px-3 py-2">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-secondary me-1">{{ $src->source_family }}</span>
                                <span class="badge bg-light text-dark me-1">{{ $src->source_type }}</span>
                                <span class="badge bg-{{ $src->authority_level === 'primary' ? 'primary' : 'secondary' }}">{{ $src->authority_level }}</span>
                            </div>
                            <small class="text-muted">{{ $src->evidenceItems->count() }} items</small>
                        </div>
                        <a href="{{ $src->url }}" target="_blank" class="small text-truncate d-block mt-1" style="max-width:400px;">{{ $src->url }}</a>

                        {{-- Add evidence item inline --}}
                        <details class="mt-2">
                            <summary class="small text-primary" style="cursor:pointer;">Add evidence item…</summary>
                            <form action="{{ route('admin.scoring.evidence-items.store', $src->id) }}" method="POST" class="mt-2">
                                @csrf
                                <div class="row g-1">
                                    <div class="col-4">
                                        <input type="text" name="field_key" class="form-control form-control-sm" placeholder="field_key" required>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" name="extracted_value" class="form-control form-control-sm" placeholder="value">
                                    </div>
                                    <div class="col-2">
                                        <select name="verified_status" class="form-select form-select-sm">
                                            <option value="unverified">Unverified</option>
                                            <option value="verified">Verified</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-sm btn-success w-100">Add</button>
                                    </div>
                                </div>
                            </form>
                        </details>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3 small">No evidence sources. Add one using the form on the left.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Review Aggregate Modal --}}
<div class="modal fade" id="add-review-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.scoring.review-aggregates.store', $tool->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-star text-warning me-2"></i>Add Review Aggregate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning small">
                        <strong>Note:</strong> Capterra, GetApp and Software Advice must all be entered as <code>gartner_digital_markets</code> (one source family per spec).
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Source Family</label>
                        <select name="source_family" class="form-select" required>
                            <option value="g2">G2</option>
                            <option value="gartner_digital_markets">Gartner Digital Markets (Capterra/GetApp/Software Advice)</option>
                            <option value="trustradius">TrustRadius</option>
                            <option value="app_marketplace">App Marketplace</option>
                            <option value="techanalytica">TechAnalytica Reviews</option>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label class="form-label">Rating (raw, 0–5)</label>
                            <input type="number" name="rating_raw" class="form-control" step="0.01" min="0" max="5" placeholder="e.g. 4.2">
                        </div>
                        <div class="col">
                            <label class="form-label">Rating (normalised, 0–100)</label>
                            <input type="number" name="rating_norm" class="form-control" step="0.1" min="0" max="100" placeholder="Auto-calculated if blank">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-semibold">Review Count</label>
                        <input type="number" name="review_count" class="form-control" min="0" required>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-semibold">Recency Breakdown (optional)</label>
                        <div class="row g-2">
                            <div class="col"><label class="form-label small">0–6 mo</label><input type="number" name="recency_data[0_6]" class="form-control form-control-sm" min="0"></div>
                            <div class="col"><label class="form-label small">6–12 mo</label><input type="number" name="recency_data[6_12]" class="form-control form-control-sm" min="0"></div>
                            <div class="col"><label class="form-label small">12–18 mo</label><input type="number" name="recency_data[12_18]" class="form-control form-control-sm" min="0"></div>
                            <div class="col"><label class="form-label small">18–24 mo</label><input type="number" name="recency_data[18_24]" class="form-control form-control-sm" min="0"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Save Aggregate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

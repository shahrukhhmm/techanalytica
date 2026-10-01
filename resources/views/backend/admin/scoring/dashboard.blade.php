@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'TA Scoring Engine — Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bx bx-star text-warning me-2"></i>TA Scoring Engine
            </h4>
            <p class="text-muted mb-0">Deterministic scoring dashboard — v1.0</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.scoring.exceptions') }}" class="btn btn-outline-danger">
                <i class="bx bx-error-circle me-1"></i>Exception Queue
                @if($stats['open_exceptions'] > 0)
                    <span class="badge bg-danger ms-1">{{ $stats['open_exceptions'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.scoring.methodology') }}" class="btn btn-outline-secondary">
                <i class="bx bx-cog me-1"></i>Methodology
            </a>
            <a href="{{ route('admin.scoring.templates') }}" class="btn btn-outline-secondary">
                <i class="bx bx-category me-1"></i>Templates
            </a>
            <a href="{{ route('admin.scoring.audit-log') }}" class="btn btn-outline-secondary">
                <i class="bx bx-history me-1"></i>Audit Log
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-2">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2" style="background:#fff3cd;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bx bx-time-five text-warning fs-4"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">{{ $stats['awaiting_first_score'] }}</h3>
                    <small class="text-muted">Awaiting First Score</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2" style="background:#d1fae5;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bx bx-check-circle text-success fs-4"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">{{ $stats['successful_runs'] }}</h3>
                    <small class="text-muted">Published Runs</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2" style="background:#fee2e2;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bx bx-error text-danger fs-4"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">{{ $stats['failed_runs'] }}</h3>
                    <small class="text-muted">Flagged Runs</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2" style="background:#ede9fe;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bx bx-hourglass text-purple fs-4"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">{{ $stats['provisional_products'] }}</h3>
                    <small class="text-muted">Provisional</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2" style="background:#fef3c7;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bx bx-bell text-warning fs-4"></i>
                    </div>
                    <h3 class="mb-0 fw-bold text-{{ $stats['open_exceptions'] > 0 ? 'danger' : 'muted' }}">{{ $stats['open_exceptions'] }}</h3>
                    <small class="text-muted">Open Exceptions</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avatar mx-auto mb-2" style="background:#dbeafe;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bx bx-edit text-primary fs-4"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">{{ $stats['pending_corrections'] }}</h3>
                    <small class="text-muted">Pending Corrections</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Score a Product --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0"><i class="bx bx-calculator text-primary me-2"></i>Score a Product</h5>
                    <p class="text-muted small mb-0">Run the deterministic engine for a tool + category pair.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.scoring.score-product') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tool</label>
                            <select name="tool_id" class="form-select" required>
                                <option value="">Select tool…</option>
                                @foreach(\App\Models\Tool::orderBy('name')->get() as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select category…</option>
                                @foreach(\App\Models\Category::orderBy('name')->get() as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dry_run" value="1" id="dry_run">
                                <label class="form-check-label" for="dry_run">Dry Run</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="publish" value="1" id="publish_run">
                                <label class="form-check-label" for="publish_run">Publish immediately</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-play me-1"></i>Run Scoring Engine
                        </button>
                    </form>

                    <hr>
                    <h6 class="text-muted small fw-semibold text-uppercase mb-2">Score Entire Category</h6>
                    <form action="" method="POST" id="score-category-form">
                        @csrf
                        <div class="mb-2">
                            <select id="score-cat-select" class="form-select form-select-sm">
                                <option value="">Select category…</option>
                                @foreach(\App\Models\Category::orderBy('name')->get() as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="scoreCategorySubmit()">
                            <i class="bx bx-layer me-1"></i>Score All in Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Recent Score Runs --}}
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between">
                    <h5 class="mb-0"><i class="bx bx-list-ul text-secondary me-2"></i>Recent Score Runs</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tool</th>
                                    <th>Category</th>
                                    <th>TA Score</th>
                                    <th>Confidence</th>
                                    <th>Status</th>
                                    <th>Run At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentRuns as $run)
                                    <tr>
                                        <td class="fw-semibold">{{ $run->tool->name ?? '—' }}</td>
                                        <td class="text-muted small">{{ $run->category->name ?? '—' }}</td>
                                        <td>
                                            <span class="fw-bold fs-5 text-primary">{{ number_format($run->public_score, 1) }}</span>
                                            <small class="text-muted">/10</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{
                                                $run->confidence_label === 'High' ? 'success' :
                                                ($run->confidence_label === 'Moderate' ? 'warning' : 'danger')
                                            }}">{{ $run->confidence_label }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{
                                                $run->status === 'ranked' ? 'success' :
                                                ($run->status === 'provisional' ? 'warning text-dark' : 'secondary')
                                            }}">{{ ucfirst($run->status) }}</span>
                                            @if($run->is_published)
                                                <i class="bx bx-globe text-success ms-1" title="Published"></i>
                                            @endif
                                            @if($run->flagged_for_review)
                                                <i class="bx bx-flag text-danger ms-1" title="Flagged"></i>
                                            @endif
                                        </td>
                                        <td class="text-muted small">{{ $run->run_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('admin.scoring.show', $run->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-show"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No score runs yet. Score a product to get started.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- High-Impact Exceptions --}}
        @if($highImpactExceptions->count() > 0)
        <div class="col-12">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white border-0">
                    <h5 class="mb-0"><i class="bx bx-error-circle me-2"></i>High-Impact Exceptions — Require Founder Review</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tool</th>
                                    <th>Trigger</th>
                                    <th>Severity</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($highImpactExceptions as $exc)
                                <tr>
                                    <td class="fw-semibold">{{ $exc->tool->name ?? '—' }}</td>
                                    <td><code class="small">{{ $exc->trigger_type }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $exc->severity === 'critical' ? 'dark' : 'danger' }}">
                                            {{ ucfirst($exc->severity) }}
                                        </span>
                                    </td>
                                    <td class="small text-muted" style="max-width:280px;">{{ \Str::limit($exc->description, 80) }}</td>
                                    <td class="small text-muted">{{ $exc->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.scoring.exceptions') }}" class="btn btn-sm btn-danger">Review</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Build Principle Reminder --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body d-flex gap-3 align-items-start">
                    <i class="bx bx-shield-check text-primary fs-3 mt-1 flex-shrink-0"></i>
                    <div>
                        <h6 class="mb-1 fw-semibold">Build Principle — Commercial Integrity</h6>
                        <p class="mb-0 text-muted small">
                            <strong>Paid plans, sponsorships, advertising, affiliate relationships and vendor spend must never change TA Score or organic category rank.</strong>
                            No admin field allows direct score entry. Only editing evidence/facts triggers a deterministic re-calculation.
                            Every change is recorded in the <a href="{{ route('admin.scoring.audit-log') }}">audit log</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function scoreCategorySubmit() {
    const catId = document.getElementById('score-cat-select').value;
    if (!catId) { alert('Please select a category.'); return; }
    if (!confirm('Score all published tools in this category?')) return;

    const form = document.getElementById('score-category-form');
    form.action = `/admin/scoring/score-category/${catId}`;
    form.submit();
}
</script>
@endpush
@endsection

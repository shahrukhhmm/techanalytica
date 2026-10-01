@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Score Run — ' . $scoreRun->tool->name ?? '')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.scoring.dashboard') }}">Scoring</a></li>
            <li class="breadcrumb-item active">Score Run #{{ $scoreRun->id }}</li>
        </ol>
    </nav>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Hero Score Card --}}
    <div class="card shadow-sm mb-4 border-0" style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 100%); color: #fff;">
        <div class="card-body p-4">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        @if($scoreRun->tool->logo_url)
                            <img src="{{ $scoreRun->tool->logo_url }}" alt="" style="width:48px;height:48px;border-radius:8px;object-fit:contain;background:#fff;padding:4px;">
                        @endif
                        <div>
                            <h4 class="text-white mb-0 fw-bold">{{ $scoreRun->tool->name }}</h4>
                            <small class="opacity-75">{{ $scoreRun->category->name ?? '—' }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-end gap-2 mt-3">
                        <span class="display-4 fw-bold text-white">{{ number_format($scoreRun->public_score, 1) }}</span>
                        <span class="fs-5 opacity-75 mb-2">/10 TA Score</span>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        <span class="badge fs-6 bg-{{
                            $scoreRun->confidence_label === 'High' ? 'success' :
                            ($scoreRun->confidence_label === 'Moderate' ? 'warning text-dark' : 'danger')
                        }}">
                            {{ $scoreRun->confidence_label }} Confidence
                        </span>
                        <span class="badge fs-6 bg-{{
                            $scoreRun->status === 'ranked' ? 'success' :
                            ($scoreRun->status === 'provisional' ? 'warning text-dark' : 'secondary')
                        }}">
                            {{ ucfirst($scoreRun->status) }}
                        </span>
                        @if($scoreRun->is_published)
                            <span class="badge fs-6 bg-success"><i class="bx bx-globe me-1"></i>Published</span>
                        @else
                            <span class="badge fs-6 bg-secondary">Unpublished</span>
                        @endif
                        @if($scoreRun->flagged_for_review)
                            <span class="badge fs-6 bg-danger"><i class="bx bx-flag me-1"></i>Flagged</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    @if($rank)
                        <div class="text-center">
                            <div style="font-size:3.5rem;font-weight:800;line-height:1;">#{{ $rank['rank'] }}</div>
                            <div class="opacity-75">of {{ $rank['eligible_count'] }} eligible</div>
                            <div class="small opacity-50">{{ \Carbon\Carbon::parse($rank['snapshot_date'])->format('M j, Y') }}</div>
                        </div>
                    @else
                        <div class="text-center opacity-50">
                            <i class="bx bx-bar-chart-alt-2 display-4"></i>
                            <div class="small">No rank snapshot yet</div>
                        </div>
                    @endif
                </div>
                <div class="col-md-3 text-md-end">
                    <div class="small opacity-75 mb-1">Run: {{ $scoreRun->run_at->format('M j, Y H:i') }}</div>
                    <div class="small opacity-75 mb-1">Methodology: {{ $scoreRun->methodologyVersion->version_name ?? '—' }}</div>
                    <div class="small opacity-75 mb-3">Template: {{ $scoreRun->template_version }}</div>
                    <div class="d-flex gap-2 justify-content-md-end flex-wrap">
                        @if(!$scoreRun->is_published)
                            <form action="{{ route('admin.scoring.runs.publish', $scoreRun->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm" {{ $scoreRun->flagged_for_review ? 'disabled' : '' }}>
                                    <i class="bx bx-check me-1"></i>Publish
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.scoring.runs.unpublish', $scoreRun->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-light btn-sm">Unpublish</button>
                            </form>
                        @endif
                        <a href="{{ route('admin.scoring.facts', $scoreRun->tool_id) }}" class="btn btn-outline-light btn-sm">
                            <i class="bx bx-data me-1"></i>Edit Facts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Dimension Breakdown --}}
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bx bx-pie-chart text-primary me-2"></i>Dimension Breakdown</h5>
                    <p class="text-muted small mb-0">Internal score: {{ number_format($scoreRun->internal_score, 2) }}/100</p>
                </div>
                <div class="card-body">
                    @php
                    $dimLabels = [
                        'use_case_fit'      => ['Use-Case Fit & Capability Depth', 25, 'primary'],
                        'ai_utility'        => ['AI Utility & Product Depth', 15, 'info'],
                        'usability'         => ['Usability & Time to Value', 15, 'success'],
                        'workflow_fit'      => ['Workflow & Integration Fit', 10, 'warning'],
                        'value_pricing'     => ['Value & Pricing', 10, 'orange'],
                        'trust_readiness'   => ['Trust & Business Readiness', 10, 'purple'],
                        'customer_evidence' => ['Customer Evidence', 10, 'teal'],
                        'product_health'    => ['Product Health & Momentum', 5, 'secondary'],
                    ];
                    @endphp
                    @foreach($dimLabels as $key => [$label, $maxPts, $color])
                        @php
                            $dimData = $dimensionSummary[$key] ?? ['points' => 0, 'max' => $maxPts, 'pct' => 0];
                            $pts = $dimData['points'];
                            $pct = $dimData['pct'];
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-semibold">{{ $label }}</span>
                                <span class="small fw-bold">{{ number_format($pts, 1) }} / {{ $maxPts }} pts ({{ $pct }}%)</span>
                            </div>
                            <div class="progress" style="height: 10px; border-radius: 6px;">
                                <div class="progress-bar bg-{{ $color === 'orange' ? 'warning' : ($color === 'purple' ? 'primary' : ($color === 'teal' ? 'info' : $color)) }}"
                                    role="progressbar"
                                    style="width: {{ $pct }}%; border-radius: 6px;"
                                    aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sub-criterion Detail --}}
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bx bx-list-check text-secondary me-2"></i>Sub-criterion Audit Trail</h5>
                </div>
                <div class="card-body p-0" style="max-height: 450px; overflow-y: auto;">
                    <div class="accordion accordion-flush" id="breakdown-accordion">
                        @php $idx = 0; @endphp
                        @foreach($scoreRun->breakdowns->groupBy('dimension_key') as $dimKey => $bds)
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $idx > 0 ? 'collapsed' : '' }} py-2 small fw-semibold"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#dim-{{ $idx }}">
                                    {{ str_replace('_', ' ', ucwords($dimKey, '_')) }}
                                    <span class="ms-auto badge bg-light text-dark me-3">
                                        {{ number_format($bds->sum('points_awarded'), 1) }}/{{ $bds->sum('max_points') }}
                                    </span>
                                </button>
                            </h2>
                            <div id="dim-{{ $idx }}" class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}" data-bs-parent="#breakdown-accordion">
                                <div class="accordion-body pt-0 px-3">
                                    <table class="table table-sm table-borderless mb-0">
                                        @foreach($bds as $bd)
                                        <tr>
                                            <td class="small text-muted ps-0">{{ str_replace('_', ' ', $bd->subcriterion_key) }}</td>
                                            <td class="text-end small fw-semibold">{{ number_format($bd->points_awarded, 2) }}/{{ $bd->max_points }}</td>
                                        </tr>
                                        @if($bd->reasoning)
                                        <tr>
                                            <td colspan="2" class="small text-muted ps-0 pb-2" style="font-size:0.75rem;"><i>{{ $bd->reasoning }}</i></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        @php $idx++; @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Score History Chart --}}
        @if($history->count() > 1)
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bx bx-trending-up text-success me-2"></i>Score History</h5>
                </div>
                <div class="card-body">
                    <canvas id="scoreHistoryChart" height="120"></canvas>
                </div>
            </div>
        </div>
        @endif

        {{-- Exceptions for this run --}}
        @if($scoreRun->exceptions->count() > 0)
        <div class="{{ $history->count() > 1 ? 'col-lg-4' : 'col-12' }}">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark border-0">
                    <h5 class="mb-0"><i class="bx bx-bell me-2"></i>Exceptions ({{ $scoreRun->exceptions->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    @foreach($scoreRun->exceptions as $exc)
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-{{ $exc->severity === 'high' ? 'danger' : 'warning text-dark' }}">{{ $exc->severity }}</span>
                            <span class="badge bg-{{ $exc->status === 'open' ? 'danger' : 'success' }}">{{ $exc->status }}</span>
                        </div>
                        <div class="small mt-1"><code>{{ $exc->trigger_type }}</code></div>
                        <div class="small text-muted mt-1">{{ $exc->description }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('admin.scoring.exceptions') }}" class="btn btn-sm btn-outline-warning w-100">Manage Exceptions</a>
                </div>
            </div>
        </div>
        @endif

        {{-- Product Facts --}}
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between">
                    <h5 class="mb-0"><i class="bx bx-data text-info me-2"></i>Product Facts Used in Scoring</h5>
                    <a href="{{ route('admin.scoring.facts', $scoreRun->tool_id) }}" class="btn btn-sm btn-outline-info">
                        <i class="bx bx-edit me-1"></i>Edit Facts
                    </a>
                </div>
                <div class="card-body">
                    @if($productFacts->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="bx bx-data display-4 opacity-25"></i>
                            <p class="mt-2">No product facts entered yet. <a href="{{ route('admin.scoring.facts', $scoreRun->tool_id) }}">Add facts</a> to improve score accuracy.</p>
                        </div>
                    @else
                        <div class="row g-2">
                            @foreach($productFacts as $fact)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="border rounded p-2 small h-100">
                                    <div class="fw-semibold text-truncate" title="{{ $fact->field_key }}">{{ $fact->field_key }}</div>
                                    <div class="text-muted text-truncate" title="{{ $fact->value }}">{{ $fact->value ?? '<null>' }}</div>
                                    <span class="badge bg-{{ $fact->status === 'verified' ? 'success' : ($fact->status === 'disputed' ? 'danger' : 'secondary') }} mt-1">{{ $fact->status }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($history->count() > 1)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('scoreHistoryChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($history->pluck('run_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M j'))),
        datasets: [{
            label: 'TA Score',
            data: @json($history->pluck('public_score')),
            borderColor: '#696cff',
            backgroundColor: 'rgba(105,108,255,0.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 5,
        }]
    },
    options: {
        scales: { y: { min: 0, max: 10 } },
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
@endif

@endsection

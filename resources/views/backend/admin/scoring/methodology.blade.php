@extends('backend.admin.layouts.contentNavbarLayout')
@section('title', 'Methodology Versions — TA Scoring')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bx bx-cog text-secondary me-2"></i>Methodology Versions</h4>
            <p class="text-muted mb-0">Any change to weights creates a new version. Historical score runs retain the version used at calculation time.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-methodology-modal">
            <i class="bx bx-plus me-1"></i>New Version
        </button>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible mb-3" role="alert">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Current Active --}}
    @if($current)
    <div class="card shadow-sm mb-4 border-success">
        <div class="card-header bg-success text-white border-0">
            <h5 class="mb-0"><i class="bx bx-check-circle me-2"></i>Active: {{ $current->version_name }}</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="fw-semibold mb-3">Dimension Weights</h6>
                    @php $dimLabels = ['use_case_fit'=>'Use-Case Fit','ai_utility'=>'AI Utility','usability'=>'Usability','workflow_fit'=>'Workflow Fit','value_pricing'=>'Value & Pricing','trust_readiness'=>'Trust & Readiness','customer_evidence'=>'Customer Evidence','product_health'=>'Product Health']; @endphp
                    @foreach($dimLabels as $key => $label)
                        @php $w = ($current->weights[$key] ?? 0) * 100; @endphp
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small">{{ $label }}</span>
                            <span class="small fw-bold">{{ number_format($w, 0) }}%</span>
                        </div>
                        <div class="progress mb-2" style="height:6px;">
                            <div class="progress-bar bg-success" style="width:{{ $w * 4 }}%;"></div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <h6 class="fw-semibold mb-3">Global Parameters</h6>
                    <table class="table table-sm table-borderless">
                        @foreach($current->global_parameters ?? [] as $param => $value)
                        @if(!is_array($value))
                        <tr>
                            <td class="small text-muted ps-0">{{ str_replace('_', ' ', $param) }}</td>
                            <td class="small fw-semibold text-end">{{ $value }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                    <div class="text-muted small mt-2">
                        Effective: {{ $current->effective_date?->format('M j, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-warning">No active methodology version. Create one to enable scoring.</div>
    @endif

    {{-- Version History --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0"><h5 class="mb-0">Version History</h5></div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Version</th><th>Effective</th><th>Published</th><th>Active</th><th>Score Runs</th></tr></thead>
                <tbody>
                    @foreach($versions as $v)
                    <tr>
                        <td class="fw-semibold">{{ $v->version_name }}</td>
                        <td class="small text-muted">{{ $v->effective_date?->format('M j, Y') }}</td>
                        <td class="small text-muted">{{ $v->published_at?->format('M j, Y') ?? '—' }}</td>
                        <td>@if($v->is_active)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Historical</span>@endif</td>
                        <td>{{ $v->scoreRuns()->count() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="new-methodology-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.scoring.methodology.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">New Methodology Version</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="alert alert-info small">Creating a new version will deactivate the current one. All future score runs will use the new weights. Historical runs are preserved.</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Version Name</label>
                            <input type="text" name="version_name" class="form-control" placeholder="e.g. TA Score v1.1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Effective Date</label>
                            <input type="date" name="effective_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12"><h6 class="fw-semibold">Dimension Weights <small class="text-muted">(must sum to 1.0)</small></h6></div>
                        @php $dims = ['use_case_fit'=>['Use-Case Fit & Capability Depth','0.25'],'ai_utility'=>['AI Utility & Product Depth','0.15'],'usability'=>['Usability & Time to Value','0.15'],'workflow_fit'=>['Workflow & Integration Fit','0.10'],'value_pricing'=>['Value & Pricing','0.10'],'trust_readiness'=>['Trust & Business Readiness','0.10'],'customer_evidence'=>['Customer Evidence','0.10'],'product_health'=>['Product Health & Momentum','0.05']]; @endphp
                        @foreach($dims as $key => [$label, $default])
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label small fw-semibold">{{ $label }}</label>
                            <input type="number" name="weights[{{ $key }}]" class="form-control form-control-sm" value="{{ $default }}" step="0.01" min="0" max="1" required>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create & Activate Version</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

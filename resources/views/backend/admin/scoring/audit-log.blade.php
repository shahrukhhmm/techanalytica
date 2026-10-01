@extends('backend.admin.layouts.contentNavbarLayout')
@section('title', 'Scoring Audit Log')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bx bx-history text-secondary me-2"></i>Scoring Audit Log</h4>
            <p class="text-muted mb-0">Complete audit trail of every scoring action, input change, and human correction.</p>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-auto">
                    <select name="entity_type" class="form-select form-select-sm">
                        <option value="">All Entities</option>
                        @foreach(['ScoreRun','ProductFact','EvidenceItem','EvidenceSource','CategoryTemplate','MethodologyVersion','ReviewException','VendorCorrection'] as $et)
                        <option value="{{ $et }}" {{ request('entity_type')===$et?'selected':'' }}>{{ $et }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <select name="action" class="form-select form-select-sm">
                        <option value="">All Actions</option>
                        @foreach(['create','update','delete','publish','unpublish','resolve','recalculate'] as $act)
                        <option value="{{ $act }}" {{ request('action')===$act?'selected':'' }}>{{ ucfirst($act) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Filter</button>
                    <a href="{{ route('admin.scoring.audit-log') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Time</th><th>Actor</th><th>Entity</th><th>ID</th><th>Action</th><th>Reason</th><th>Before → After</th></tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="small text-muted text-nowrap">{{ $log->timestamp->format('M j H:i') }}</td>
                            <td class="small">{{ $log->actor->name ?? 'System' }}</td>
                            <td><code class="small">{{ $log->entity_type }}</code></td>
                            <td class="small text-muted">{{ $log->entity_id }}</td>
                            <td>
                                <span class="badge bg-{{ match($log->action) {
                                    'create'  => 'success',
                                    'delete'  => 'danger',
                                    'publish' => 'primary',
                                    'resolve' => 'info',
                                    default   => 'secondary'
                                } }}">{{ $log->action }}</span>
                            </td>
                            <td class="small text-muted" style="max-width:160px;">{{ \Str::limit($log->reason, 40) ?? '—' }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-1"
                                    data-bs-toggle="tooltip" title="{{ json_encode(['before'=>$log->before,'after'=>$log->after], JSON_PRETTY_PRINT) }}">
                                    <i class="bx bx-code-alt small"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">No audit records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())<div class="card-footer">{{ $logs->withQueryString()->links() }}</div>@endif
    </div>
</div>
@push('scripts')
<script>
const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
tooltipEls.forEach(el => new bootstrap.Tooltip(el, { placement:'left', html:false }));
</script>
@endpush
@endsection

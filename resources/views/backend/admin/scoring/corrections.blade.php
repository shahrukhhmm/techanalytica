@extends('backend.admin.layouts.contentNavbarLayout')
@section('title', 'Vendor Corrections — TA Scoring')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bx bx-edit text-warning me-2"></i>Vendor Correction Requests</h4>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible mb-3" role="alert">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    <div class="card shadow-sm mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-auto">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
                        <option value="accepted" {{ request('status')==='accepted'?'selected':'' }}>Accepted</option>
                        <option value="rejected" {{ request('status')==='rejected'?'selected':'' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Filter</button>
                    <a href="{{ route('admin.scoring.corrections') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Tool</th><th>Type</th><th>Claim</th><th>Evidence</th><th>Submitter</th><th>Status</th><th>Created</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($corrections as $c)
                        <tr>
                            <td class="fw-semibold">{{ $c->tool->name ?? '—' }}</td>
                            <td><span class="badge bg-secondary small">{{ str_replace('_', ' ', $c->correction_type) }}</span></td>
                            <td class="small text-muted" style="max-width:220px;">{{ \Str::limit($c->claim, 60) }}</td>
                            <td>
                                @if($c->evidence_url)<a href="{{ $c->evidence_url }}" target="_blank" class="small">URL <i class="bx bx-link-external"></i></a>@endif
                                @if($c->evidence_file)<span class="small text-info ms-1">File</span>@endif
                                @if(!$c->evidence_url && !$c->evidence_file)<span class="text-muted small">—</span>@endif
                            </td>
                            <td class="small">{{ $c->submitter->name ?? 'Guest' }}</td>
                            <td>
                                <span class="badge bg-{{ match($c->status) { 'pending'=>'warning text-dark','accepted'=>'success',default=>'danger' } }}">
                                    {{ ucfirst($c->status) }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $c->created_at->diffForHumans() }}</td>
                            <td>
                                @if($c->status === 'pending')
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#resolve-corr-{{ $c->id }}">Review</button>
                                @else
                                <span class="small text-muted">{{ \Str::limit($c->resolution, 30) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted py-5">No correction requests.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($corrections->hasPages())<div class="card-footer">{{ $corrections->withQueryString()->links() }}</div>@endif
    </div>
</div>

@foreach($corrections as $c)
@if($c->status === 'pending')
<div class="modal fade" id="resolve-corr-{{ $c->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.scoring.corrections.resolve', $c->id) }}" method="POST">
                @csrf @method('PATCH')
                <div class="modal-header"><h5 class="modal-title">Review Correction #{{ $c->id }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3 p-3 bg-light rounded small">
                        <strong>Tool:</strong> {{ $c->tool->name ?? '—' }}<br>
                        <strong>Type:</strong> {{ str_replace('_', ' ', $c->correction_type) }}<br>
                        <strong>Claim:</strong><br>{{ $c->claim }}
                        @if($c->evidence_url)<br><strong>Evidence:</strong> <a href="{{ $c->evidence_url }}" target="_blank">{{ $c->evidence_url }}</a>@endif
                    </div>
                    <div class="alert alert-warning small">
                        <i class="bx bx-info-circle me-1"></i><strong>Accepted corrections</strong> will update product facts and trigger an automatic score recalculation. You cannot directly edit the TA Score.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Decision</label>
                        <select name="status" class="form-select" required>
                            <option value="accepted">Accept — update facts & recalculate score</option>
                            <option value="rejected">Reject — no change to score</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Resolution Notes</label>
                        <textarea name="resolution" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Decision</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection

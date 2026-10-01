@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Exception Queue — TA Scoring')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bx bx-error-circle text-danger me-2"></i>Exception Queue</h4>
            <p class="text-muted mb-0">Only exceptions requiring founder review. Reviewers may approve/reject/correct evidence but cannot directly set a TA Score.</p>
        </div>
        <a href="{{ route('admin.scoring.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-arrow-back me-1"></i>Dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-3" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Filters --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-auto">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_review" {{ request('status') === 'in_review' ? 'selected' : '' }}>In Review</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="dismissed" {{ request('status') === 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                    </select>
                </div>
                <div class="col-auto">
                    <select name="severity" class="form-select form-select-sm">
                        <option value="">All Severity</option>
                        <option value="critical" {{ request('severity') === 'critical' ? 'selected' : '' }}>Critical</option>
                        <option value="high" {{ request('severity') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('severity') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ request('severity') === 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <div class="col-auto">
                    <select name="trigger_type" class="form-select form-select-sm">
                        <option value="">All Triggers</option>
                        @foreach(['score_change','rank_jump','confidence_drop','top_10_entry','vendor_correction','source_conflict'] as $trigger)
                            <option value="{{ $trigger }}" {{ request('trigger_type') === $trigger ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($trigger)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Filter</button>
                    <a href="{{ route('admin.scoring.exceptions') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tool</th>
                            <th>Trigger</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Score Run</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exceptions as $exc)
                        <tr class="{{ $exc->status === 'open' && in_array($exc->severity, ['high','critical']) ? 'table-danger' : '' }}">
                            <td class="text-muted small">{{ $exc->id }}</td>
                            <td class="fw-semibold">{{ $exc->tool->name ?? '—' }}</td>
                            <td><code class="small">{{ $exc->trigger_type }}</code></td>
                            <td>
                                <span class="badge bg-{{ match($exc->severity) {
                                    'critical' => 'dark',
                                    'high'     => 'danger',
                                    'medium'   => 'warning text-dark',
                                    default    => 'secondary'
                                } }}">{{ ucfirst($exc->severity) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ match($exc->status) {
                                    'open'      => 'danger',
                                    'in_review' => 'warning text-dark',
                                    'resolved'  => 'success',
                                    default     => 'secondary'
                                } }}">{{ ucfirst($exc->status) }}</span>
                            </td>
                            <td class="small text-muted" style="max-width:260px;">{{ \Str::limit($exc->description, 70) }}</td>
                            <td>
                                @if($exc->scoreRun)
                                    <a href="{{ route('admin.scoring.show', $exc->scoreRun->id) }}" class="small text-primary">
                                        Run #{{ $exc->scoreRun->id }}
                                        <br><strong>{{ number_format($exc->scoreRun->public_score, 1) }}/10</strong>
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $exc->created_at->diffForHumans() }}</td>
                            <td>
                                @if(in_array($exc->status, ['open','in_review']))
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal" data-bs-target="#resolve-modal-{{ $exc->id }}">
                                    Resolve
                                </button>
                                @else
                                    <span class="small text-muted">{{ $exc->resolution ? \Str::limit($exc->resolution, 30) : '—' }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">
                                <i class="bx bx-check-circle display-4 text-success opacity-50"></i>
                                <p class="mt-2">No exceptions match the current filters.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($exceptions->hasPages())
        <div class="card-footer">{{ $exceptions->withQueryString()->links() }}</div>
        @endif
    </div>
</div>

{{-- Resolve Modals --}}
@foreach($exceptions as $exc)
@if(in_array($exc->status, ['open','in_review']))
<div class="modal fade" id="resolve-modal-{{ $exc->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.scoring.exceptions.resolve', $exc->id) }}" method="POST">
                @csrf @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Resolve Exception #{{ $exc->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small mb-3">
                        <strong>{{ $exc->tool->name ?? '—' }}</strong>: {{ $exc->description }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Resolution Action</label>
                        <select name="status" class="form-select" required>
                            <option value="resolved">Resolved — no score change needed</option>
                            <option value="dismissed">Dismissed — false positive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Resolution Notes</label>
                        <textarea name="resolution" class="form-control" rows="3" placeholder="Explain the decision…"></textarea>
                    </div>
                    <div class="alert alert-warning small mb-0">
                        <i class="bx bx-info-circle me-1"></i>To change the score, edit <strong>product facts or evidence</strong> instead. The engine will recalculate automatically.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Resolution</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection

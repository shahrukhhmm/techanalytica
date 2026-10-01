@extends('backend.admin.layouts.contentNavbarLayout')
@section('title', 'Score History — ' . $tool->name)
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.scoring.dashboard') }}">Scoring</a></li>
            <li class="breadcrumb-item active">{{ $tool->name }} — History</li>
        </ol>
    </nav>
    <div class="d-flex align-items-center gap-3 mb-4">
        @if($tool->logo_url)
            <img src="{{ $tool->logo_url }}" alt="" style="width:40px;height:40px;border-radius:8px;object-fit:contain;">
        @endif
        <div>
            <h4 class="fw-bold mb-0">{{ $tool->name }}</h4>
            <small class="text-muted">All score runs across categories</small>
        </div>
        <a href="{{ route('admin.scoring.facts', $tool->id) }}" class="btn btn-outline-primary btn-sm ms-auto">
            <i class="bx bx-data me-1"></i>Manage Facts
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Category</th><th>TA Score</th><th>Internal</th><th>Confidence</th><th>Status</th><th>Published</th><th>Flagged</th><th>Methodology</th><th>Run At</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse($runs as $run)
                        <tr>
                            <td class="text-muted small">{{ $run->id }}</td>
                            <td>{{ $run->category->name ?? '—' }}</td>
                            <td>
                                <span class="fw-bold fs-5 text-primary">{{ number_format($run->public_score, 1) }}</span>
                                <small class="text-muted">/10</small>
                            </td>
                            <td class="small text-muted">{{ number_format($run->internal_score, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $run->confidence_label==='High'?'success':($run->confidence_label==='Moderate'?'warning text-dark':'danger') }}">
                                    {{ $run->confidence_label }}
                                </span>
                                <small class="text-muted">({{ $run->confidence_score }})</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $run->status==='ranked'?'success':($run->status==='provisional'?'warning text-dark':'secondary') }}">{{ ucfirst($run->status) }}</span>
                            </td>
                            <td>@if($run->is_published)<i class="bx bx-check text-success fs-5"></i>@else<i class="bx bx-x text-muted fs-5"></i>@endif</td>
                            <td>@if($run->flagged_for_review)<i class="bx bx-flag text-danger fs-5"></i>@else<span class="text-muted">—</span>@endif</td>
                            <td class="small text-muted">{{ $run->methodologyVersion->version_name ?? '—' }}</td>
                            <td class="small text-muted text-nowrap">{{ $run->run_at->format('M j, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.scoring.show', $run->id) }}" class="btn btn-sm btn-outline-primary"><i class="bx bx-show"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="11" class="text-center text-muted py-5">No score runs for this tool yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($runs->hasPages())<div class="card-footer">{{ $runs->withQueryString()->links() }}</div>@endif
    </div>
</div>
@endsection

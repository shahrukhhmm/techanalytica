@extends('backend.admin.layouts.contentNavbarLayout')
@section('title', 'Category Leaderboard — ' . $category->name)
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bx bx-trophy text-warning me-2"></i>{{ $category->name }} — Leaderboard</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.scoring.ranks.publish', $category->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Publish rank snapshots for this category?')">
                    <i class="bx bx-check me-1"></i>Publish Rank Snapshot
                </button>
            </form>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible mb-3" role="alert">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    <div class="alert alert-info small mb-4">
        <i class="bx bx-info-circle me-1"></i>
        <strong>Ranking rules:</strong> Ranked by TA Score descending. Scores within 0.1 of each other are tied.
        Tie-break: confidence score → Use-Case Fit → Customer Evidence.
        <strong>Paid plans and sponsorships are never considered.</strong>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Rank</th><th>Tool</th><th>TA Score</th><th>Confidence</th><th>Status</th><th>Run At</th><th></th></tr>
                    </thead>
                    <tbody>
                        @php $rank = 1; @endphp
                        @forelse($runs as $i => $run)
                        <tr class="{{ $run->status==='ranked'?'':($run->status==='provisional'?'table-warning':'table-secondary') }}">
                            <td>
                                @if($run->status === 'ranked')
                                    <span class="fw-bold fs-5 text-{{ $rank===1?'warning':($rank===2?'secondary':($rank===3?'danger':'muted')) }}">#{{ $rank }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($run->tool->logo_url)
                                        <img src="{{ $run->tool->logo_url }}" alt="" style="width:32px;height:32px;border-radius:4px;object-fit:contain;">
                                    @endif
                                    <span class="fw-semibold">{{ $run->tool->name ?? '—' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold fs-5 text-primary">{{ number_format($run->public_score, 1) }}</span>
                                <small class="text-muted">/10</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $run->confidence_label==='High'?'success':($run->confidence_label==='Moderate'?'warning text-dark':'danger') }}">
                                    {{ $run->confidence_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $run->status==='ranked'?'success':($run->status==='provisional'?'warning text-dark':'secondary') }}">
                                    {{ ucfirst($run->status) }}
                                </span>
                                @if(!$run->is_published)<span class="badge bg-light text-dark">Unpublished</span>@endif
                            </td>
                            <td class="small text-muted">{{ $run->run_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('admin.scoring.show', $run->id) }}" class="btn btn-sm btn-outline-primary"><i class="bx bx-show"></i></a>
                            </td>
                        </tr>
                        @php if($run->status === 'ranked') $rank++; @endphp
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">No published score runs for this category.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

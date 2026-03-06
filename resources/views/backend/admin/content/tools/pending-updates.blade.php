@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Pending Tool Updates')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Tools /</span> Pending Updates
            </h4>
            <span class="badge bg-label-warning fs-6">{{ $tools->count() }} Pending</span>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($tools->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bx bx-check-circle text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 mb-1">All clear!</h5>
                    <p class="text-muted">No pending tool updates to review.</p>
                </div>
            </div>
        @else
            @foreach ($tools as $tool)
                @php
                    $pending = $tool->pending_data ?? [];
                    $liveCatIds = $tool->categories->pluck('id')->toArray();
                    $liveIndIds = $tool->industries->pluck('id')->toArray();
                    $pendingCatIds = $pending['categories'] ?? $liveCatIds;
                    $pendingIndIds = $pending['industries'] ?? $liveIndIds;
                    $liveCatNames = $tool->categories->pluck('name')->join(', ') ?: '—';
                    $liveIndNames = $tool->industries->pluck('name')->join(', ') ?: '—';
                    $pendingCatNames =
                        collect($pendingCatIds)->map(fn($id) => $allCategories[$id] ?? '#' . $id)->join(', ') ?: '—';
                    $pendingIndNames =
                        collect($pendingIndIds)->map(fn($id) => $allIndustries[$id] ?? '#' . $id)->join(', ') ?: '—';
                    $catsChanged = (function ($a, $b) {
                        sort($a);
                        sort($b);
                        return $a !== $b;
                    })($pendingCatIds, $liveCatIds);
                    $indsChanged = (function ($a, $b) {
                        sort($a);
                        sort($b);
                        return $a !== $b;
                    })($pendingIndIds, $liveIndIds);
                @endphp
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center bg-label-warning">
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $tool->name }}</h5>
                            <small class="text-muted">
                                Vendor: <strong>{{ $tool->vendor->company_name ?? 'N/A' }}</strong> &mdash;
                                Updated: {{ $tool->updated_at->diffForHumans() }}
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.tools.approve-update', $tool->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bx bx-check me-1"></i> Approve Update
                                </button>
                            </form>
                            <form action="{{ route('admin.tools.reject-update', $tool->id) }}" method="POST"
                                onsubmit="return confirm('Reject and discard this update?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bx bx-x me-1"></i> Reject
                                </button>
                            </form>
                            <a href="{{ route('admin.tools.show', $tool->id) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bx bx-show me-1"></i> View Live
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Live (Current) Data -->
                            <div class="col-md-6 border-end">
                                <h6 class="fw-bold text-muted mb-3"><i class="bx bx-broadcast me-1 text-success"></i>
                                    Current Live Data</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="fw-semibold text-muted" style="width:40%">Name</td>
                                        <td>{{ $tool->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Website</td>
                                        <td>{{ $tool->website_url ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Short Desc</td>
                                        <td>{{ $tool->short_description ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Long Desc</td>
                                        <td>{{ Str::limit($tool->long_description, 120) ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">CTA Type</td>
                                        <td>{{ $tool->cta_type ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">CTA URL</td>
                                        <td>{{ $tool->cta_url ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Logo URL</td>
                                        <td>{{ $tool->logo_url ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Categories</td>
                                        <td>{{ $liveCatNames }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Industries</td>
                                        <td>{{ $liveIndNames }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- Pending (Proposed) Data -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-muted mb-3"><i class="bx bx-time me-1 text-warning"></i> Proposed
                                    Changes</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="fw-semibold text-muted" style="width:40%">Name</td>
                                        <td
                                            class="{{ ($pending['name'] ?? $tool->name) !== $tool->name ? 'text-warning fw-bold' : '' }}">
                                            {{ $pending['name'] ?? $tool->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Website</td>
                                        <td
                                            class="{{ ($pending['website_url'] ?? $tool->website_url) !== $tool->website_url ? 'text-warning fw-bold' : '' }}">
                                            {{ $pending['website_url'] ?? '—' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Short Desc</td>
                                        <td
                                            class="{{ ($pending['short_description'] ?? $tool->short_description) !== $tool->short_description ? 'text-warning fw-bold' : '' }}">
                                            {{ $pending['short_description'] ?? '—' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Long Desc</td>
                                        <td
                                            class="{{ ($pending['long_description'] ?? $tool->long_description) !== $tool->long_description ? 'text-warning fw-bold' : '' }}">
                                            {{ Str::limit($pending['long_description'] ?? '', 120) ?: '—' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">CTA Type</td>
                                        <td
                                            class="{{ ($pending['cta_type'] ?? $tool->cta_type) !== $tool->cta_type ? 'text-warning fw-bold' : '' }}">
                                            {{ $pending['cta_type'] ?? '—' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">CTA URL</td>
                                        <td
                                            class="{{ ($pending['cta_url'] ?? $tool->cta_url) !== $tool->cta_url ? 'text-warning fw-bold' : '' }}">
                                            {{ $pending['cta_url'] ?? '—' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Logo URL</td>
                                        <td
                                            class="{{ ($pending['logo_url'] ?? $tool->logo_url) !== $tool->logo_url ? 'text-warning fw-bold' : '' }}">
                                            {{ $pending['logo_url'] ?? '—' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Categories</td>
                                        <td class="{{ $catsChanged ? 'text-warning fw-bold' : '' }}">
                                            {{ $pendingCatNames }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Industries</td>
                                        <td class="{{ $indsChanged ? 'text-warning fw-bold' : '' }}">
                                            {{ $pendingIndNames }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <p class="text-muted small mt-2 mb-0">
                            <i class="bx bx-info-circle me-1"></i>
                            <span class="text-warning fw-semibold">Yellow text</span> indicates a changed field.
                        </p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

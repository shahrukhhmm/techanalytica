@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Manage My Products')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Products /</span> List
        </h4>
        <a href="{{ route('vendor.tools.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bx bx-plus"></i> Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Summary Stat Pills --}}
    @php
        $sumViews   = $tools->sum('stat_total_views');
        $sumUnique  = $tools->sum('stat_unique');
        $sumToday   = $tools->sum('stat_today');
        $sumMonth   = $tools->sum('stat_month');
        $sumClicks  = $tools->sum('stat_clicks');
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(224,67,133,0.1);border:1px solid rgba(224,67,133,0.25);">
                <i class="bx bx-show text-pink" style="color:#e04385;font-size:18px;"></i>
                <div>
                    <div class="fw-bold text-white lh-1">{{ number_format($sumViews) }}</div>
                    <small class="text-muted" style="font-size:11px;">Total Views</small>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(164,53,138,0.1);border:1px solid rgba(164,53,138,0.25);">
                <i class="bx bx-user-check" style="color:#a4358a;font-size:18px;"></i>
                <div>
                    <div class="fw-bold text-white lh-1">{{ number_format($sumUnique) }}</div>
                    <small class="text-muted" style="font-size:11px;">Unique Visitors</small>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);">
                <i class="bx bx-calendar-check" style="color:#10b981;font-size:18px;"></i>
                <div>
                    <div class="fw-bold text-white lh-1">{{ number_format($sumToday) }}</div>
                    <small class="text-muted" style="font-size:11px;">Today</small>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(0,242,254,0.07);border:1px solid rgba(0,242,254,0.2);">
                <i class="bx bx-calendar-month" style="color:#00f2fe;font-size:18px;"></i>
                <div>
                    <div class="fw-bold text-white lh-1">{{ number_format($sumMonth) }}</div>
                    <small class="text-muted" style="font-size:11px;">This Month</small>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);">
                <i class="bx bx-mouse-alt" style="color:#f59e0b;font-size:18px;"></i>
                <div>
                    <div class="fw-bold text-white lh-1">{{ number_format($sumClicks) }}</div>
                    <small class="text-muted" style="font-size:11px;">CTA Clicks</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Tools Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tools-table">
                    <thead>
                        <tr>
                            <th class="ps-4" style="min-width:220px;">Product</th>
                            <th>Tier</th>
                            <th>Status</th>
                            <th class="text-center" title="Total page views since launch">
                                <i class="bx bx-show me-1"></i>Views
                            </th>
                            <th class="text-center" title="Unique sessions tracked">
                                <i class="bx bx-user me-1"></i>Unique
                            </th>
                            <th class="text-center" title="Views today">
                                <i class="bx bx-sun me-1"></i>Today
                            </th>
                            <th class="text-center" title="Views this month">
                                <i class="bx bx-calendar me-1"></i>Month
                            </th>
                            <th class="text-center" title="CTA outbound clicks">
                                <i class="bx bx-mouse-alt me-1"></i>Clicks
                            </th>
                            <th class="text-center" title="Click / view conversion rate">
                                <i class="bx bx-trending-up me-1"></i>CVR
                            </th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tools as $tool)
                        <tr>
                            {{-- Product Name --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    @if($tool->logo_url)
                                        <img src="{{ $tool->logo_url }}" alt="{{ $tool->name }}"
                                             class="rounded" style="width:36px;height:36px;object-fit:contain;">
                                    @else
                                        <div class="avatar avatar-sm rounded bg-label-primary d-flex align-items-center justify-content-center">
                                            <i class="bx bx-bot" style="font-size:16px;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $tool->name }}</div>
                                        <small class="text-muted text-truncate d-block" style="max-width:180px;">
                                            {{ $tool->categories->first()->name ?? ($tool->website_url ?? 'No website') }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            {{-- Tier --}}
                            <td>
                                <span class="badge bg-label-secondary">{{ $tool->tier->name ?? 'None' }}</span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="badge {{ $tool->status === 'published' ? 'bg-label-success' : ($tool->status === 'pending' ? 'bg-label-warning' : 'bg-label-secondary') }}">
                                        {{ ucfirst($tool->status) }}
                                    </span>
                                    @if($tool->status === 'published' && $tool->has_pending_update)
                                        <span class="badge bg-label-info" style="font-size:0.7rem;">
                                            <i class="bx bx-revision me-1"></i>Update Pending
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Total Views --}}
                            <td class="text-center">
                                @if($tool->stat_total_views > 0)
                                    <span class="fw-bold" style="color:#e04385;">
                                        {{ number_format($tool->stat_total_views) }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            {{-- Unique Visitors --}}
                            <td class="text-center">
                                @if($tool->stat_unique > 0)
                                    <span class="fw-semibold text-white">{{ number_format($tool->stat_unique) }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            {{-- Today --}}
                            <td class="text-center">
                                @if($tool->stat_today > 0)
                                    <span class="badge bg-label-success">{{ number_format($tool->stat_today) }}</span>
                                @else
                                    <span class="badge bg-label-secondary">0</span>
                                @endif
                            </td>

                            {{-- This Month --}}
                            <td class="text-center">
                                @if($tool->stat_month > 0)
                                    <span class="badge bg-label-info">{{ number_format($tool->stat_month) }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            {{-- CTA Clicks --}}
                            <td class="text-center">
                                @if($tool->stat_clicks > 0)
                                    <span class="fw-semibold" style="color:#f59e0b;">
                                        {{ number_format($tool->stat_clicks) }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            {{-- Conversion Rate --}}
                            <td class="text-center">
                                @php
                                    $cvr = $tool->stat_conversion;
                                    $cvrClass = $cvr >= 10 ? 'bg-label-success' : ($cvr >= 5 ? 'bg-label-warning' : 'bg-label-secondary');
                                @endphp
                                <span class="badge {{ $cvrClass }}">{{ $cvr }}%</span>
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <a href="{{ route('vendor.tools.show', $tool->id) }}"
                                       class="btn btn-sm btn-icon btn-outline-secondary"
                                       data-bs-toggle="tooltip" title="View Details">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="{{ route('vendor.tools.edit', $tool->id) }}"
                                       class="btn btn-sm btn-icon btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Edit Product">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="{{ route('vendor.analytics') }}?tool_id={{ $tool->id }}"
                                       class="btn btn-sm btn-icon btn-outline-info"
                                       data-bs-toggle="tooltip" title="View Full Analytics">
                                        <i class="bx bx-bar-chart-alt-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="bx bx-layer-plus bx-lg text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-3">No products listed yet.</p>
                                <a href="{{ route('vendor.tools.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus me-1"></i> Add Your First Product
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});
</script>
@endsection
@endsection

@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Manage My Products')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Products /</span> List</h4>
            <a href="{{ route('vendor.tools.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Add New Product
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="tools-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Pricing Tier</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tools as $tool)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($tool->logo_url)
                                                <img src="{{ $tool->logo_url }}" alt="Logo" class="rounded me-3"
                                                    style="width: 32px; height: 32px; object-fit: contain;">
                                            @else
                                                <div class="bg-label-primary rounded me-3 d-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="bx bx-wrench"></i>
                                                </div>
                                            @endif
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">{{ $tool->name }}</span>
                                                <small class="text-muted">{{ $tool->website_url ?? 'No Website' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary">{{ $tool->tier->name ?? 'None' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-start">
                                            <span
                                                class="badge {{ $tool->status === 'published' ? 'bg-label-success' : ($tool->status === 'pending' ? 'bg-label-warning' : 'bg-label-secondary') }} mb-1">
                                                {{ ucfirst($tool->status) }}
                                            </span>
                                            @if ($tool->status === 'published' && $tool->has_pending_update)
                                                <span class="badge bg-label-info" style="font-size: 0.7rem;">
                                                    <i class="bx bx-revision me-1"></i> Update Pending
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <div class="ms-2 d-flex">
                                                <a href="{{ route('vendor.tools.edit', $tool->id) }}"
                                                    class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="tooltip"
                                                    title="Edit Details">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="{{ route('vendor.switch-tool', $tool->id) }}"
                                                    class="btn btn-sm btn-icon btn-outline-info ms-1"
                                                    data-bs-toggle="tooltip" title="Switch Context">
                                                    <i class="bx bx-log-in-circle"></i>
                                                </a>
                                            </div>
                                            @if ($tool->status === 'draft')
                                                <form action="{{ route('vendor.tools.submit', $tool->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-label-warning"
                                                        data-bs-toggle="tooltip" title="Submit for Review">
                                                        <i class="bx bx-send me-1"></i> Submit
                                                    </button>
                                                </form>
                                            @elseif($tool->status === 'published')
                                                <form action="{{ route('vendor.tools.unpublish', $tool->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to unpublish this product? It will be moved to drafts.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-label-danger"
                                                        data-bs-toggle="tooltip" title="Unpublish Product">
                                                        <i class="bx bx-cloud-download me-1"></i> Unpublish
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof DataTable !== 'undefined') {
                new DataTable('#tools-table');
            }

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
@endsection

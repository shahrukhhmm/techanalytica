@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Vendor Details - ' . $vendor->company_name)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Vendors /</span> Details</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-primary">
                    <i class="bx bx-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Info -->
            <div class="col-xl-4 col-lg-5 col-md-12">
                <!-- Vendor Profile Card -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body text-center p-5">
                        <div class="avatar avatar-xl h-auto mx-auto mb-4">
                            <span class="avatar-initial rounded bg-label-primary fs-1 shadow-sm px-4 py-3">
                                {{ substr($vendor->company_name ?: $vendor->user->name ?? 'V', 0, 1) }}
                            </span>
                        </div>
                        <h4 class="mb-1 fw-bold">{{ $vendor->company_name ?: 'N/A' }}</h4>
                        <p class="text-muted mb-4">{{ $vendor->designation ?: 'Vendor Profile' }}</p>

                        <div class="d-flex justify-content-center gap-3">
                            <div class="text-center">
                                <h5 class="mb-0 fw-bold">{{ $vendor->tools->count() }}</h5>
                                <small class="text-muted">Tools</small>
                            </div>
                            <div class="divider divider-vertical"></div>
                            <div class="text-center">
                                <h5 class="mb-0 fw-bold">{{ $vendor->claims->count() }}</h5>
                                <small class="text-muted">Claims</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small fw-bold mb-3">Contact Information</h6>
                        <ul class="list-unstyled mb-0 space-y-3">
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-user me-2 text-primary"></i>
                                <span>{{ $vendor->user->name ?? 'No User Linked' }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-envelope me-2 text-primary"></i>
                                <span class="text-truncate">{{ $vendor->user->email ?? 'N/A' }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-phone me-2 text-primary"></i>
                                <span>{{ $vendor->phone ?: 'N/A' }}</span>
                            </li>
                            @if ($vendor->company_website)
                                <li class="d-flex align-items-center">
                                    <i class="bx bx-globe me-2 text-primary"></i>
                                    <a href="{{ $vendor->company_website }}" target="_blank"
                                        class="text-primary text-truncate">
                                        {{ str_replace(['https://', 'http://'], '', $vendor->company_website) }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-xl-8 col-lg-7 col-md-12">
                <!-- Company Details -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">Company Details</h5>
                    </div>
                    <div class="card-body pt-4">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Department</label>
                                <p class="text-dark fw-medium mb-0">{{ $vendor->department ?: 'Not Specified' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Company Size</label>
                                <p class="text-dark fw-medium mb-0">{{ $vendor->company_size ?: 'Not Specified' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Billing Details</label>
                                <div class="bg-light rounded p-3 mt-1">
                                    <p class="mb-2"><span class="fw-bold">Email:</span>
                                        {{ $vendor->billing_email ?: 'N/A' }}</p>
                                    <p class="mb-0"><span
                                            class="fw-bold">Address:</span><br>{{ $vendor->billing_address ?: 'No address provided' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Associated Tools -->
                <div class="card shadow-sm border-0">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Associated Tools</h5>
                        <span class="badge bg-label-info">{{ $vendor->tools->count() }} Total</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tool Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vendor->tools as $tool)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($tool->logo_url)
                                                        <img src="{{ $tool->logo_url }}" alt="{{ $tool->name }}"
                                                            class="rounded me-2" width="32" height="32"
                                                            style="object-fit: contain;">
                                                    @endif
                                                    <span class="fw-bold">{{ $tool->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($tool->categories->take(2) as $category)
                                                    <span
                                                        class="badge bg-label-secondary badge-xs">{{ $category->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <span
                                                    class="badge @if ($tool->status == 'published') bg-label-success @else bg-label-warning @endif">
                                                    {{ ucfirst($tool->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.tools.show', $tool) }}"
                                                    class="btn btn-sm btn-icon btn-outline-secondary">
                                                    <i class="bx bx-chevron-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted small">
                                                No tools associated with this vendor yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

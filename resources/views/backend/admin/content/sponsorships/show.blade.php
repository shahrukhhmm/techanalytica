@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Manage Sponsorship')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Sponsorships /</span> Manage</h4>

        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
                    <h5 class="card-header">Sponsorship Details</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tool</label>
                                <p>{{ $sponsorship->tool->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Vendor</label>
                                <p>{{ $sponsorship->vendor->company_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Placement Type</label>
                                <p><span
                                        class="badge bg-label-info">{{ ucfirst($sponsorship->placement_type ?? 'Standard') }}</span>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Category/Industry</label>
                                <p>{{ $sponsorship->category->name ?? ($sponsorship->industry->name ?? 'Global') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <h5 class="card-header">Sponsorship Control</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.sponsorships.update-status', $sponsorship) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="pending" {{ $sponsorship->status == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="active" {{ $sponsorship->status == 'active' ? 'selected' : '' }}>Active
                                        (Visible)</option>
                                    <option value="completed" {{ $sponsorship->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="cancelled" {{ $sponsorship->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="starts_at" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="starts_at" name="starts_at"
                                    value="{{ $sponsorship->starts_at ? $sponsorship->starts_at->format('Y-m-d') : '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="ends_at" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="ends_at" name="ends_at"
                                    value="{{ $sponsorship->ends_at ? $sponsorship->ends_at->format('Y-m-d') : '' }}">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update Sponsorship</button>
                        </form>

                        <form action="{{ route('admin.sponsorships.destroy', $sponsorship) }}" method="POST"
                            class="mt-3" onsubmit="return confirm('Delete this sponsorship?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">Delete Record</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

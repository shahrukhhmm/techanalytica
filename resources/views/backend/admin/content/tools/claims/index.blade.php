@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Tool Claim Requests')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Tools /</span> Claim Requests</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header border-bottom">
                <h5 class="mb-0">Claim Records</h5>
            </div>
            <div class="card-body pt-4">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover" id="claims-table">
                        <thead>
                            <tr>
                                <th>Tool</th>
                                <th>Claimant (Vendor)</th>
                                <th>Status</th>
                                <th>Date Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($claims as $claim)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded bg-label-primary"><i
                                                        class="bx bx-wrench"></i></span>
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block">{{ $claim->tool->name }}</span>
                                                <small class="text-muted">ID: {{ $claim->tool->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-primary">{{ $claim->vendor->name }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.tools.claims.update-status', $claim) }}"
                                            method="POST" class="status-form">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status"
                                                class="form-select form-select-sm status-select @if ($claim->status == 'approved') border-success text-success @elseif($claim->status == 'rejected') border-danger text-danger @endif"
                                                onchange="this.form.submit()">
                                                <option value="pending" {{ $claim->status == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="approved"
                                                    {{ $claim->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected"
                                                    {{ $claim->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ $claim->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-info me-2"
                                                data-bs-toggle="modal" data-bs-target="#claimReason{{ $claim->id }}"
                                                title="View Reason">
                                                <i class="bx bx-info-circle"></i>
                                            </button>
                                            <form action="{{ route('admin.tools.claims.destroy', $claim) }}" method="POST"
                                                onsubmit="return confirm('Delete this claim record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Reason Modal -->
                                        <div class="modal fade" id="claimReason{{ $claim->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header border-bottom">
                                                        <h5 class="modal-title fw-bold">Claim Reason -
                                                            {{ $claim->tool->name }}
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="mb-0">{{ $claim->reason ?: 'No reason provided.' }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x me-1"></i> Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
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
@endsection
@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#claims-table');
        });
    </script>
@endsection

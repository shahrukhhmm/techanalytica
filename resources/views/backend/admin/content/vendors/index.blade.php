@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Vendors')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Vendors</h4>
            <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Add Vendor
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="vendors-table">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Contact Person</th>
                                <th>Website</th>
                                <th>Phone</th>
                                <th>Tools</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr>
                                    <td>
                                        <strong>{{ $vendor->company_name ?: 'N/A' }}</strong>
                                        <div class="text-muted small">Size: {{ $vendor->company_size ?: '-' }}</div>
                                    </td>
                                    <td>
                                        {{ $vendor->user->name ?? 'No User' }}
                                        <div class="text-muted small">{{ $vendor->user->email ?? '-' }}</div>
                                    </td>
                                    <td>
                                        @if ($vendor->company_website)
                                            <a href="{{ $vendor->company_website }}" target="_blank"
                                                class="btn btn-sm btn-icon btn-outline-secondary">
                                                <i class="bx bx-link-external"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $vendor->phone ?: '-' }}</td>
                                    <td>
                                        <span
                                            class="badge bg-label-primary shadow-sm">{{ $vendor->tools_count ?? $vendor->tools->count() }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.vendors.show', $vendor) }}"
                                                class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="{{ route('admin.vendors.edit', $vendor) }}"
                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this vendor?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger"
                                                    title="Delete">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#vendors-table');
        });
    </script>
@endsection

@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Industries')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Industries</h4>
            <a href="{{ route('admin.industries.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Add Industry
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
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Suggested By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($industries as $industry)
                                <tr>
                                    <td>{{ $industry->name }}</td>
                                    <td>{{ $industry->slug }}</td>
                                    <td>{{ $industry->suggestedByVendor->company_name ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.industries.edit', $industry) }}"
                                            class="btn btn-sm btn-outline-primary"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('admin.industries.destroy', $industry) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                    class="bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing {{ $industries->firstItem() ?? 0 }} to {{ $industries->lastItem() ?? 0 }} of {{ $industries->total() }} entries
                    </div>
                    <div>
                        {{ $industries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('table')) {
                new DataTable('#table', {
                    paging: false,
                    info: false
                });
            }
        });
    </script>
@endsection

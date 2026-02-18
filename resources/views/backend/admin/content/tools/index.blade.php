@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Tools')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Tools</h4>
            <a href="{{ route('admin.tools.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Add Tool
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
                                <th>Vendor</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tools as $tool)
                                <tr>
                                    <td>{{ $tool->name }}</td>
                                    <td>{{ $tool->slug }}</td>
                                    <td>{{ $tool->vendor->company_name ?? '-' }}</td>
                                    <td>{{ $tool->status }}</td>
                                    <td>
                                        <a href="{{ route('admin.tools.show', $tool->id) }}" class="btn btn-info btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('admin.tools.edit', $tool->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tools.destroy', $tool->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
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
            new DataTable('#table');
        });
    </script>
@endsection

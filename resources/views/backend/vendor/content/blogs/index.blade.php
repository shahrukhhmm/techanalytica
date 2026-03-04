@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Blogs')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Blogs /</span> My Articles</h4>
            <a href="{{ route('vendor.blogs.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Add New Article
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="blogs-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($blog->og_image)
                                                <img src="{{ asset('storage/' . $blog->og_image) }}" alt="Image"
                                                    class="rounded me-2"
                                                    style="width: 40px; height: 30px; object-fit: cover;">
                                            @else
                                                <div class="bg-label-secondary rounded me-2 d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 30px;">
                                                    <i class="bx bx-news"></i>
                                                </div>
                                            @endif
                                            <span class="fw-bold">{{ Str::limit($blog->title, 40) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $blog->status === 'published' ? 'label-success' : 'label-warning' }}">
                                            {{ ucfirst($blog->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('vendor.blogs.edit', $blog) }}"
                                                class="btn btn-sm btn-icon btn-outline-primary" title="Edit"><i
                                                    class="bx bx-edit"></i></a>
                                            <form action="{{ route('vendor.blogs.destroy', $blog) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this article?')">
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
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof DataTable !== 'undefined') {
                new DataTable('#blogs-table');
            }
        });
    </script>
@endsection

@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Blog Details - ' . $blog->title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Blogs /</span> Details</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-primary">
                    <i class="bx bx-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Blog Content -->
            <div class="col-xl-8 col-lg-7 col-md-12">
                <!-- Featured Image -->
                <div class="card mb-4 overflow-hidden">
                    @if ($blog->og_image)
                        <img src="{{ asset($blog->og_image) }}" alt="{{ $blog->title }}" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-label-primary d-flex align-items-center justify-content-center"
                            style="height: 300px;">
                            <i class="bx bx-image fs-1 opacity-25"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span
                                class="badge {{ $blog->status === 'published' ? 'bg-label-success' : 'bg-label-warning' }} me-2">
                                {{ ucfirst($blog->status) }}
                            </span>
                            <span class="text-muted small">
                                <i class="bx bx-calendar me-1"></i>
                                {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Drafted on ' . $blog->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <h2 class="mb-4">{{ $blog->title }}</h2>
                        <div class="blog-content">
                            {!! $blog->body !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog Meta Information -->
            <div class="col-xl-4 col-lg-5 col-md-12">
                <!-- Author Info -->
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">Post Information</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    {{ substr($blog->author->name ?? 'U', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $blog->author->name ?? 'Unknown Author' }}</h6>
                                <small class="text-muted">Author</small>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex justify-content-between">
                                <span class="fw-bold">Created:</span>
                                <span class="text-muted small">{{ $blog->created_at->format('M d, Y H:i') }}</span>
                            </li>
                            <li class="mb-2 d-flex justify-content-between">
                                <span class="fw-bold">Last Updated:</span>
                                <span class="text-muted small">{{ $blog->updated_at->format('M d, Y H:i') }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="fw-bold">Slug:</span>
                                <span class="text-muted small"><code>{{ $blog->slug }}</code></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- SEO Information -->
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">SEO & Metadata</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-3">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">Meta Title</h6>
                            <p class="mb-0">{{ $blog->meta_title ?: 'Not set' }}</p>
                        </div>
                        <div class="mb-0">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">Meta Description</h6>
                            <p class="mb-0 small text-wrap">{{ $blog->meta_description ?: 'Not set' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="card bg-label-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Quick Actions</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.blogs.edit', $blog) }}"
                                class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="bx bx-edit-alt me-2"></i> Edit Post
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                                    <i class="bx bx-trash me-2"></i> Delete Post
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-style')
    <style>
        .blog-content {
            line-height: 1.8;
            font-size: 1.1rem;
            color: #333;
        }

        .blog-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        [data-bs-theme="dark"] .blog-content {
            color: #ddd;
        }
    </style>
@endpush

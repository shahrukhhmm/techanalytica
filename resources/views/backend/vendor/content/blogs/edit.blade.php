@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Edit Blog')

@section('page-script')
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.key', 'no-api-key') }}/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: 'textarea#body',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 400,
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Blogs /</span> Edit Article</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('vendor.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="title" class="form-label fw-bold">Title</label>
                                    <input class="form-control @error('title') is-invalid @enderror" type="text"
                                        id="title" name="title" value="{{ old('title', $blog->title) }}" required
                                        autofocus />
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                        <option value="draft"
                                            {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>
                                            Draft</option>
                                        <option value="published"
                                            {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>
                                            Published</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="body" class="form-label fw-bold">Content</label>
                                    <textarea id="body" name="body" class="form-control @error('body') is-invalid @enderror">{{ old('body', $blog->body) }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="og_image" class="form-label fw-bold">Featured Image</label>
                                    @if ($blog->og_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $blog->og_image) }}" alt="Featured Image"
                                                class="img-thumbnail" style="max-width: 200px">
                                        </div>
                                    @endif
                                    <input class="form-control @error('og_image') is-invalid @enderror" type="file"
                                        id="og_image" name="og_image" />
                                    @error('og_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="meta_title" class="form-label fw-bold">SEO Title</label>
                                    <input class="form-control @error('meta_title') is-invalid @enderror" type="text"
                                        id="meta_title" name="meta_title"
                                        value="{{ old('meta_title', $blog->meta_title) }}" />
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="meta_description" class="form-label fw-bold">SEO Description</label>
                                    <textarea id="meta_description" name="meta_description" rows="2"
                                        class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">Update Article</button>
                                <a href="{{ route('vendor.blogs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

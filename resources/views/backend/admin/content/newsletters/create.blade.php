@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Create Newsletter')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Newsletters /</span> Create</h4>

        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Newsletter Content</h5>
                        <small class="text-muted">Draft your campaign</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.newsletters.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label" for="subject">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" value="{{ old('subject') }}"
                                    placeholder="Enter newsletter subject..." required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="content">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="12"
                                    placeholder="Enter newsletter content..." required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">You can use HTML tags for basic formatting.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Save As</label>
                                <div class="d-flex gap-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_draft"
                                            value="draft" checked>
                                        <label class="form-check-label" for="status_draft">Draft</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_sent"
                                            value="sent">
                                        <label class="form-check-label" for="status_sent">Mark as Sent</label>
                                    </div>
                                </div>
                                <div class="form-text">"Mark as Sent" is for tracking purposes in this version.</div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.newsletters.index') }}"
                                    class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary px-5">Save Newsletter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

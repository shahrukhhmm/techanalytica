@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Review Submission')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Submissions /</span> Review</h4>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <h5 class="card-header">Submission Details - {{ $submission->tool_name }}</h5>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($submission->fields as $key => $value)
                                <div class="col-md-12 mb-3">
                                    <label
                                        class="form-label fw-bold text-capitalize">{{ str_replace('_', ' ', $key) }}</label>
                                    @if (filter_var($value, FILTER_VALIDATE_URL))
                                        <p><a href="{{ $value }}" target="_blank">{{ $value }}</a></p>
                                    @else
                                        <p>{{ $value ?: '-' }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h5 class="card-header">Action Panel</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.submissions.update-status', $submission) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="status" class="form-label">Update Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="pending" {{ $submission->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ $submission->status == 'approved' ? 'selected' : '' }}>
                                        Approve (Creates Listing)</option>
                                    <option value="rejected" {{ $submission->status == 'rejected' ? 'selected' : '' }}>
                                        Reject</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="admin_note" class="form-label">Note to Vendor</label>
                                <textarea class="form-control" id="admin_note" name="admin_note" rows="3">{{ old('admin_note', $submission->admin_note) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit Decision</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Product Reviews & Feedback')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Reviews & Customer Feedback</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="reviews-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Reviewer</th>
                                <th>Rating</th>
                                <th>Feedback</th>
                                <th>Official Reply</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                                <tr>
                                    <td><strong>{{ $review->tool->name }}</strong></td>
                                    <td>
                                        <strong>{{ $review->user_name ?? ($review->user->name ?? 'Anonymous') }}</strong><br>
                                        <small class="text-muted">{{ $review->user_email ?? ($review->user->email ?? '') }}</small>
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bx {{ $i <= $review->rating ? 'bxs-star text-warning' : 'bx-star text-muted' }}"></i>
                                        @endfor
                                        <span class="fw-bold ms-1">{{ $review->rating }}.0</span>
                                    </td>
                                    <td>
                                        <div style="max-width: 260px; font-size: 13px;">
                                            "{{ $review->comment }}"
                                        </div>
                                    </td>
                                    <td>
                                        @if($review->vendor_reply)
                                            <div class="p-2 rounded bg-lighter" style="max-width: 220px; font-size: 12px; border-left: 3px solid #e04385;">
                                                <small class="text-muted d-block mb-1">Replied on {{ $review->vendor_replied_at ? $review->vendor_replied_at->format('M d, Y') : '' }}</small>
                                                "{{ Str::limit($review->vendor_reply, 80) }}"
                                            </div>
                                        @else
                                            <span class="text-muted fs-7">No reply yet</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge @if ($review->status == 'approved') bg-label-success @elseif($review->status == 'pending') bg-label-warning @else bg-label-danger @endif">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyModal-{{ $review->id }}">
                                            <i class="bx bx-reply me-1"></i> {{ $review->vendor_reply ? 'Edit Reply' : 'Reply' }}
                                        </button>

                                        <!-- Reply Modal -->
                                        <div class="modal fade" id="replyModal-{{ $review->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('vendor.reviews.reply', $review->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reply to {{ $review->user_name ?? 'User' }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-muted mb-2"><strong>Review:</strong> "{{ $review->comment }}"</p>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Your Official Vendor Response</label>
                                                                <textarea name="vendor_reply" rows="4" required class="form-control" placeholder="Thank the reviewer or address their feedback directly...">{{ $review->vendor_reply }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Publish Response</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No customer reviews recorded yet for your products.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

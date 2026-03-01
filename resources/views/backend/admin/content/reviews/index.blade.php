@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Reviews')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Reviews</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="reviews-table">
                        <thead>
                            <tr>
                                <th>Tool</th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td><strong>{{ $review->tool->name }}</strong></td>
                                    <td>
                                        {{ $review->user_name }}<br>
                                        <small class="text-muted">{{ $review->user_email }}</small>
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="bx {{ $i <= $review->rating ? 'bxs-star text-warning' : 'bx-star text-muted' }}"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ $review->comment }}">
                                            {{ $review->comment }}
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge @if ($review->status == 'approved') bg-label-success @elseif($review->status == 'pending') bg-label-warning @else bg-label-danger @endif">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if ($review->status != 'approved')
                                                <form action="{{ route('admin.reviews.update-status', $review) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-success"
                                                        title="Approve">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($review->status != 'rejected')
                                                <form action="{{ route('admin.reviews.update-status', $review) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-warning"
                                                        title="Reject">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?')">
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
            new DataTable('#reviews-table');
        });
    </script>
@endsection

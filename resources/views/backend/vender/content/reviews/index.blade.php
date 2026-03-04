@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Reviews')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Reviews for My Products</h4>

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
                                <th>User</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td><strong>{{ $review->tool->name }}</strong></td>
                                    <td>
                                        {{ $review->user_name ?? ($review->user->name ?? 'Anonymous') }}<br>
                                        <small
                                            class="text-muted">{{ $review->user_email ?? ($review->user->email ?? '') }}</small>
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="bx {{ $i <= $review->rating ? 'bxs-star text-warning' : 'bx-star text-muted' }}"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        <div style="max-width: 300px; white-space: normal;" title="{{ $review->comment }}">
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
                new DataTable('#reviews-table');
            }
        });
    </script>
@endsection

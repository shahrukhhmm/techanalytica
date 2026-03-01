@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Newsletter Subscribers')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Newsletter Subscribers</h4>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0">Subscriber List</h5>
                <span class="badge bg-label-primary">{{ $subscribers->count() }} Total</span>
            </div>
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table class="table table-sm table-hover" id="subscribers-table">
                        <thead>
                            <tr>
                                <th>Email Address</th>
                                <th>Status</th>
                                <th>Subscribed Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscribers as $subscriber)
                                <tr>
                                    <td><strong>{{ $subscriber->email }}</strong></td>
                                    <td>
                                        <span
                                            class="badge @if ($subscriber->status == 'active') bg-label-success @else bg-label-secondary @endif">
                                            {{ ucfirst($subscriber->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $subscriber->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST"
                                            onsubmit="return confirm('Remove this subscriber?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-outline-danger"
                                                title="Delete Subscriber">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">No subscribers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#subscribers-table');
        });
    </script>
@endsection

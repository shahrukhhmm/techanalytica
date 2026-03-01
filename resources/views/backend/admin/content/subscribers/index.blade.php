@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Newsletter Subscribers')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Newsletter Subscribers</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Subscription Date</th>
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
                                            onsubmit="return confirm('Are you sure you want to remove this subscriber?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-outline-danger"
                                                title="Remove">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No subscribers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $subscribers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

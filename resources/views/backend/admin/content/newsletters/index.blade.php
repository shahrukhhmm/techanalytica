@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Newsletters & Subscribers')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Newsletter Management</h4>
            <a href="{{ route('admin.newsletters.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Create Newsletter
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Newsletters Table -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Newsletters</h5>
                        <small class="text-muted">History of drafted and sent newsletters</small>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="newsletter-table">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Sent Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($newsletters as $newsletter)
                                        <tr>
                                            <td><strong>{{ $newsletter->subject }}</strong></td>
                                            <td>
                                                <span
                                                    class="badge @if ($newsletter->status == 'sent') bg-label-success @else bg-label-warning @endif">
                                                    {{ ucfirst($newsletter->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $newsletter->created_at->format('M d, Y') }}</td>
                                            <td>{{ $newsletter->sent_at ? $newsletter->sent_at->format('M d, Y H:i') : '-' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.newsletters.show', $newsletter) }}"
                                                        class="btn btn-sm btn-icon btn-outline-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    @if ($newsletter->status == 'draft')
                                                        <a href="{{ route('admin.newsletters.edit', $newsletter) }}"
                                                            class="btn btn-sm btn-icon btn-outline-primary"
                                                            title="Edit Newsletter">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.newsletters.send', $newsletter) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Send this newsletter to all subscribers?')">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-icon btn-outline-success"
                                                                title="Send Newsletter">
                                                                <i class="bx bx-paper-plane"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('admin.newsletters.destroy', $newsletter) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-icon btn-outline-danger">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No newsletters found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#newsletter-table');
        });
    </script>
@endsection

@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Users Management')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Management /</span> Users</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <span class="tf-icons bx bx-plus"></span>&nbsp; Add User
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <h5 class="card-header">Users List</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" id="users-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Verified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center user-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-primary">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="text-body text-truncate">
                                                <span class="fw-medium">{{ $user->name }}</span>
                                            </a>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-capitalize">{{ $user->role }}</span>
                                </td>
                                <td>
                                    @if ($user->is_suspended)
                                        <span class="badge bg-label-danger">Suspended</span>
                                    @else
                                        <span class="badge bg-label-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-label-success">Verified</span>
                                    @else
                                        <span class="badge bg-label-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.users.show', $user) }}"><i
                                                    class="bx bx-show-alt me-1"></i> View</a>
                                            <a class="dropdown-item" href="{{ route('admin.users.edit', $user) }}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>

                                            <form action="{{ route('admin.users.toggle-suspension', $user) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i
                                                        class="bx {{ $user->is_suspended ? 'bx-user-check' : 'bx-user-x' }} me-1"></i>
                                                    {{ $user->is_suspended ? 'Unsuspend' : 'Suspend' }}
                                                </button>
                                            </form>

                                            @if (!$user->email_verified_at)
                                                <form action="{{ route('admin.users.verify-email', $user) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item"><i
                                                            class="bx bx-check-shield me-1"></i> Verify Email</button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.users.force-password-reset', $user) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Force password reset for this user?')"><i
                                                        class="bx bx-key me-1"></i> Force Reset Pwd</button>
                                            </form>

                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i
                                                        class="bx bx-trash me-1"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin: 1rem 1.5rem;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 1rem 1.5rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('users-table')) {
                new DataTable('#users-table', {
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    language: {
                        search: "",
                        searchPlaceholder: "Search Users...",
                        lengthMenu: "_MENU_"
                    },
                    pageLength: 10,
                    responsive: true
                });

                // Add Bootstrap classes to search/length
                document.querySelectorAll('.dataTables_filter input').forEach(el => el.classList.add(
                    'form-control'));
                document.querySelectorAll('.dataTables_length select').forEach(el => el.classList.add(
                    'form-select'));
            }
        });
    </script>
@endsection

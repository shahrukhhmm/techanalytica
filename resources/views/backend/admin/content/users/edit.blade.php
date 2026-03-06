@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Edit User')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Users /</span> Edit User</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">User Settings</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ old('name', $user->name) }}" required />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}" required />
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <select id="role" name="role" class="select2 form-select" required>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor
                                        </option>
                                        <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor
                                        </option>
                                        <option value="public" {{ $user->role == 'public' ? 'selected' : '' }}>Public
                                        </option>
                                    </select>
                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="is_suspended" class="form-label">Status</label>
                                    <select id="is_suspended" name="is_suspended" class="select2 form-select">
                                        <option value="0" {{ !$user->is_suspended ? 'selected' : '' }}>Active</option>
                                        <option value="1" {{ $user->is_suspended ? 'selected' : '' }}>Suspended
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="suspension_reason" class="form-label">Suspension Reason (if
                                        suspended)</label>
                                    <textarea class="form-control" id="suspension_reason" name="suspension_reason" rows="2">{{ old('suspension_reason', $user->suspension_reason) }}</textarea>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Update User</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Add New User')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Users /</span> Add New User</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">User Information</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ old('name') }}" required autofocus />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ old('email') }}" required />
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" id="password" name="password" required />
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <select id="role" name="role" class="select2 form-select" required>
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="editor">Editor</option>
                                        <option value="vendor">Vendor</option>
                                        <option value="public">Public</option>
                                    </select>
                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save User</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

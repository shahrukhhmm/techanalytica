@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Edit Vendor')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Vendors /</span> Edit Vendor</h4>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Vendor Details</h5>
                        <small class="text-muted float-end">Edit Vendor Account</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" for="user_id">Associate User <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                    name="user_id" required>
                                    <option value="">Select a user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $vendor->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="company_name">Company Name</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                    id="company_name" name="company_name"
                                    value="{{ old('company_name', $vendor->company_name) }}" placeholder="e.g. Acme Inc.">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="company_website">Company Website</label>
                                    <input type="url"
                                        class="form-control @error('company_website') is-invalid @enderror"
                                        id="company_website" name="company_website"
                                        value="{{ old('company_website', $vendor->company_website) }}"
                                        placeholder="https://example.com">
                                    @error('company_website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="company_size">Company Size</label>
                                    <input type="text" class="form-control @error('company_size') is-invalid @enderror"
                                        id="company_size" name="company_size"
                                        value="{{ old('company_size', $vendor->company_size) }}"
                                        placeholder="e.g. 50-100 employees">
                                    @error('company_size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="designation">Designation</label>
                                    <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                        id="designation" name="designation"
                                        value="{{ old('designation', $vendor->designation) }}" placeholder="e.g. CTO">
                                    @error('designation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="department">Department</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror"
                                        id="department" name="department"
                                        value="{{ old('department', $vendor->department) }}" placeholder="e.g. IT">
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $vendor->phone) }}"
                                        placeholder="+1234567890">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="billing_email">Billing Email</label>
                                    <input type="email" class="form-control @error('billing_email') is-invalid @enderror"
                                        id="billing_email" name="billing_email"
                                        value="{{ old('billing_email', $vendor->billing_email) }}"
                                        placeholder="billing@example.com">
                                    @error('billing_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="billing_address">Billing Address</label>
                                <textarea class="form-control @error('billing_address') is-invalid @enderror" id="billing_address"
                                    name="billing_address" rows="3" placeholder="Full billing address...">{{ old('billing_address', $vendor->billing_address) }}</textarea>
                                @error('billing_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Vendor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('backend.admin.layouts.blankLayout')

@section('title', 'Vendor Registration')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-6">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">@include('_partials.macros')</span>
                            <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1 text-center">Join Our Vendor Network 🚀</h4>
                    <p class="mb-6 text-center">Create your account to manage your products and connect with users.</p>

                    <form id="formAuthentication" class="mb-6" action="{{ route('register-vendor.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" autofocus required />
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Business Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="john@company.com" required />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Acme Inc." required />
                                @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="company_website" class="form-label">Company Website</label>
                                <input type="url" class="form-control @error('company_website') is-invalid @enderror" id="company_website" name="company_website" value="{{ old('company_website') }}" placeholder="https://acme.com" required />
                                @error('company_website')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" name="designation" value="{{ old('designation') }}" placeholder="Product Manager" required />
                                @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" value="{{ old('department') }}" placeholder="Marketing" required />
                                @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="company_size" class="form-label">Company Size</label>
                                <select class="form-select @error('company_size') is-invalid @enderror" id="company_size" name="company_size" required>
                                    <option value="" disabled selected>Select size</option>
                                    <option value="1-10" {{ old('company_size') == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                    <option value="11-50" {{ old('company_size') == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                    <option value="51-200" {{ old('company_size') == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                    <option value="201-500" {{ old('company_size') == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                    <option value="501-1000" {{ old('company_size') == '501-1000' ? 'selected' : '' }}>501-1000 employees</option>
                                    <option value="1000+" {{ old('company_size') == '1000+' ? 'selected' : '' }}>1000+ employees</option>
                                </select>
                                @error('company_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000" required />
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required />
                                <label class="form-check-label" for="terms-conditions">
                                    I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100 shadow-sm">Create Account</button>
                    </form>

                    <p class="text-center">
                        <span>Already have an account?</span>
                        <a href="{{ route('auth-login-basic') }}">
                            <span>Sign in instead</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
</div>
@endsection

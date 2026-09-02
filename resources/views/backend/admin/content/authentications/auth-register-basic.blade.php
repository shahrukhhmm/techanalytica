@extends('backend.admin.layouts.blankLayout')

@section('title', 'Register - TechAnalytica')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card px-sm-6 px-0 shadow-sm border-0">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-heading fw-bold fs-3">TechAnalytica</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1">Create an Account 🚀</h4>
                    <p class="mb-4 text-muted">Join the leading AI software comparison and vendor network.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-4" action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Work / Contact Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required />
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">I am joining as: <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required onchange="toggleVendorFields(this.value)">
                                <option value="public" {{ old('role') == 'public' ? 'selected' : '' }}>Software Buyer / Researcher (Visitor)</option>
                                <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>AI Software Vendor / Product Owner</option>
                            </select>
                        </div>

                        <div id="vendorFields" style="display: {{ old('role') == 'vendor' ? 'block' : 'none' }};">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company / Product Name</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. OpenAI or Synthesia" />
                            </div>
                            <div class="mb-3">
                                <label for="company_website" class="form-label">Company Website URL</label>
                                <input type="url" class="form-control @error('company_website') is-invalid @enderror" id="company_website" name="company_website" value="{{ old('company_website') }}" placeholder="https://example.com" />
                            </div>
                        </div>

                        <div class="form-password-toggle mb-3">
                            <label class="form-label" for="password">Password (min. 8 characters) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary d-grid w-100">Create Account</button>
                    </form>

                    <p class="text-center mb-0">
                        <span>Already have an account?</span>
                        <a href="{{ route('auth-login-basic') }}">
                            <span>Sign in</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
</div>

<script>
    function toggleVendorFields(role) {
        const vFields = document.getElementById('vendorFields');
        if (role === 'vendor') {
            vFields.style.display = 'block';
        } else {
            vFields.style.display = 'none';
        }
    }
</script>
@endsection
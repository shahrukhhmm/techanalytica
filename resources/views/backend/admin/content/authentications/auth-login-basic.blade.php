@extends('backend.admin.layouts.blankLayout')

@section('title', 'Sign In - TechAnalytica')

@section('content')
  <div class="d-flex align-items-center justify-content-center min-vh-100 p-3 position-relative" style="z-index: 2;">
    <div class="card border-0 shadow-lg" style="max-width: 440px; width: 100%; background: #150d1a !important; border: 1px solid rgba(224, 67, 133, 0.25) !important; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.6), 0 0 30px rgba(224, 67, 133, 0.15) !important;">
      <div class="card-body p-4 p-sm-5">
        <!-- Logo Header -->
        <div class="text-center mb-4">
          <a href="{{ url('/') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-3">
            <div class="logo-dots-brand">
              <span></span><span></span><span></span>
              <span></span><span></span><span></span>
              <span></span><span></span><span></span>
            </div>
            <span class="fw-bold fs-3 text-white tracking-tight">Tech<span style="background: linear-gradient(135deg, #e04385 0%, #a4358a 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Analytica</span></span>
          </a>
          <h4 class="text-white fw-bold mb-1">Welcome Back</h4>
          <p class="text-muted small mb-0">Sign in to access your portal & analytics</p>
        </div>

        @if(session('error'))
          <div class="alert alert-danger py-2 px-3 small rounded-3 mb-4" role="alert">
            <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
          </div>
        @endif

        @if(session('success'))
          <div class="alert alert-success py-2 px-3 small rounded-3 mb-4" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
          </div>
        @endif

        <!-- Login Form -->
        <form id="formAuthentication" action="{{ route('login') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label text-white small fw-medium">Email or Username</label>
            <div class="input-group">
              <span class="input-group-text bg-dark border-secondary text-muted" style="background-color: #120917 !important; border-color: rgba(255,255,255,0.1) !important;">
                <i class="bx bx-user"></i>
              </span>
              <input type="text" class="form-control @error('email-username') is-invalid @enderror" id="email"
                name="email-username" value="{{ old('email-username') }}" placeholder="admin@techanalytica.com"
                required autofocus />
            </div>
            @error('email-username')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label text-white small fw-medium mb-0" for="password">Password</label>
              <a href="{{ url('auth/forgot-password-basic') }}" class="small" style="color: #e04385;">Forgot?</a>
            </div>
            <div class="input-group">
              <span class="input-group-text bg-dark border-secondary text-muted" style="background-color: #120917 !important; border-color: rgba(255,255,255,0.1) !important;">
                <i class="bx bx-lock-alt"></i>
              </span>
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                name="password" placeholder="••••••••" required />
            </div>
            @error('password')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember-me" id="remember-me" />
              <label class="form-check-label text-muted small" for="remember-me">Remember me</label>
            </div>
          </div>

          <div class="mb-3">
            <button class="btn btn-primary d-grid w-100 py-2 fw-semibold" type="submit" style="background: linear-gradient(90deg, #e04385 0%, #fa709a 100%) !important; border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(224, 67, 133, 0.4);">
              Sign In to Portal
            </button>
          </div>
        </form>

        <div class="text-center mt-4">
          <a href="{{ url('/') }}" class="text-muted small text-decoration-none hover-pink">
            <i class="bx bx-arrow-back me-1"></i> Back to TechAnalytica Home
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

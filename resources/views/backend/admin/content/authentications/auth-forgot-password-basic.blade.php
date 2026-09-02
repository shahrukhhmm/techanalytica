@extends('backend.admin.layouts.blankLayout')

@section('title', 'Forgot Password - TechAnalytica')

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
          <h4 class="text-white fw-bold mb-1">Reset Password 🔒</h4>
          <p class="text-muted small mb-0">Enter your email and we'll send recovery instructions</p>
        </div>

        @if (session('status'))
          <div class="alert alert-success py-2 px-3 small rounded-3 mb-4" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('status') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger py-2 px-3 small rounded-3 mb-4" role="alert">
            <ul class="mb-0 ps-3">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="formAuthentication" action="{{ route('auth-reset-password-basic') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label for="email" class="form-label text-white small fw-medium">Registered Email</label>
            <div class="input-group">
              <span class="input-group-text bg-dark border-secondary text-muted" style="background-color: #120917 !important; border-color: rgba(255,255,255,0.1) !important;">
                <i class="bx bx-envelope"></i>
              </span>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="user@company.com" required autofocus />
            </div>
          </div>
          <button type="submit" class="btn btn-primary d-grid w-100 py-2 fw-semibold mb-3" style="background: linear-gradient(90deg, #e04385 0%, #fa709a 100%) !important; border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(224, 67, 133, 0.4);">
            Send Recovery Link
          </button>
        </form>

        <div class="text-center mt-3">
          <a href="{{ route('auth-login-basic') }}" class="text-muted small text-decoration-none">
            <i class="bx bx-arrow-back me-1"></i> Return to login
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

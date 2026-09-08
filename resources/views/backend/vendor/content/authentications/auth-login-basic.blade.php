@extends('backend.admin.layouts.blankLayout')

@section('title', 'Sign In - TechAnalytica Portal')

@section('page-style')
<style>
  .auth-login-wrapper {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    z-index: 2;
    overflow: hidden;
  }
  .auth-ambient-glow {
    position: absolute;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 59, 123, 0.16) 0%, rgba(159, 85, 255, 0.06) 45%, transparent 70%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    z-index: 1;
  }
  .auth-glass-card {
    max-width: 450px;
    width: 100%;
    background: linear-gradient(145deg, rgba(26, 12, 36, 0.94) 0%, rgba(14, 7, 20, 0.98) 100%) !important;
    border: 1px solid rgba(255, 59, 123, 0.28) !important;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.75), 0 0 40px rgba(255, 59, 123, 0.12) !important;
    position: relative;
    z-index: 3;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
  }
  .auth-logo-dots {
    display: inline-grid;
    grid-template-columns: repeat(2, 6px);
    grid-gap: 5px;
    margin-right: 4px;
  }
  .auth-logo-dots div {
    width: 6px;
    height: 6px;
    border-radius: 50%;
  }
  .auth-input-group {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
  }
  .auth-input-group:focus-within {
    border-color: #ff3b7b;
    background: rgba(255, 255, 255, 0.06);
    box-shadow: 0 0 0 3px rgba(255, 59, 123, 0.18);
  }
  .auth-input-icon {
    padding: 12px 14px;
    color: #9a8c9e;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .auth-input-field {
    width: 100%;
    background: transparent !important;
    border: none !important;
    color: #ffffff !important;
    font-size: 14px;
    padding: 12px 14px 12px 0;
    outline: none !important;
    box-shadow: none !important;
  }
  .auth-input-field::placeholder {
    color: #6d6274;
  }
  .auth-btn-radiant {
    background: linear-gradient(90deg, #ff3b7b 0%, #ff735c 100%) !important;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 14.5px;
    border: none !important;
    border-radius: 12px;
    padding: 13px;
    width: 100%;
    box-shadow: 0 8px 24px rgba(255, 59, 123, 0.35);
    transition: all 0.25s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
  }
  .auth-btn-radiant:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(255, 59, 123, 0.55);
    color: #fff !important;
  }
  .toggle-pwd-btn {
    background: transparent;
    border: none;
    color: #9a8c9e;
    padding: 0 14px;
    cursor: pointer;
    transition: color 0.2s;
  }
  .toggle-pwd-btn:hover {
    color: #ff3b7b;
  }
</style>
@endsection

@section('content')
  <div class="auth-login-wrapper">
    <div class="auth-ambient-glow"></div>

    <div class="auth-glass-card">
      <!-- Logo Header -->
      <div class="text-center mb-4">
        <a href="{{ url('/') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-3">
          <div class="auth-logo-dots">
            <div style="background: #ff3b7b;"></div>
            <div style="background: #ff735c;"></div>
            <div style="background: #d83b7d;"></div>
            <div style="background: #ff3b7b;"></div>
            <div style="background: #a4358a;"></div>
            <div style="background: #ff735c;"></div>
          </div>
          <span style="font-size: 24px; font-weight: 800; color: #ffffff; letter-spacing: -0.02em;">
            Tech<span style="font-weight: 400; color: rgba(255,255,255,0.9);">Analytica</span>
          </span>
        </a>
        <h3 style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 6px;">Portal Sign In</h3>
        <p style="color: var(--text-secondary); font-size: 13.5px; margin: 0;">Access your vendor dashboard, analytics, or administrative portal.</p>
      </div>

      @if(session('error'))
        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-4" role="alert" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5;">
          <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
        </div>
      @endif

      @if(session('success'))
        <div class="alert alert-success py-2 px-3 small rounded-3 mb-4" role="alert" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #6ee7b7;">
          <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
      @endif

      <!-- Login Form -->
      <form id="formAuthentication" action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="email" class="form-label text-white small fw-semibold mb-2">Email or Username</label>
          <div class="auth-input-group">
            <span class="auth-input-icon">
              <i class="fa-solid fa-user"></i>
            </span>
            <input type="text" class="auth-input-field @error('email-username') is-invalid @enderror" id="email"
              name="email-username" value="{{ old('email-username') }}" placeholder="admin@techanalytica.com"
              required autofocus />
          </div>
          @error('email-username')
            <div class="text-danger small mt-1" style="font-size: 12px;">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <label class="form-label text-white small fw-semibold mb-0" for="password">Password</label>
            <a href="{{ url('auth/forgot-password-basic') }}" style="color: #ff735c; font-size: 12.5px; font-weight: 600; text-decoration: none;">Forgot password?</a>
          </div>
          <div class="auth-input-group">
            <span class="auth-input-icon">
              <i class="fa-solid fa-lock"></i>
            </span>
            <input type="password" id="password" class="auth-input-field @error('password') is-invalid @enderror"
              name="password" placeholder="••••••••••••" required />
            <button type="button" class="toggle-pwd-btn" onclick="togglePasswordVisibility()" aria-label="Toggle Password Visibility">
              <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
            </button>
          </div>
          @error('password')
            <div class="text-danger small mt-1" style="font-size: 12px;">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-4 d-flex justify-content-between align-items-center">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember-me" id="remember-me" style="background-color: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.2);" />
            <label class="form-check-label text-muted small" for="remember-me" style="cursor: pointer;">Remember me on this browser</label>
          </div>
        </div>

        <div class="mb-3">
          <button class="auth-btn-radiant" type="submit">
            <span>Sign In to Portal</span>
            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
          </button>
        </div>
      </form>

      <div class="text-center mt-4 pt-3 border-top border-secondary border-opacity-10">
        <span class="text-muted small">New software vendor?</span>
        <a href="{{ route('auth-register-basic') }}" style="color: #ff735c; font-weight: 700; font-size: 13px; text-decoration: none; margin-left: 4px;">Create Vendor Account</a>
      </div>

      <div class="text-center mt-3">
        <a href="{{ url('/') }}" style="color: var(--text-secondary); font-size: 12.5px; text-decoration: none;" onmouseover="this.style.color='#ff3b7b'" onmouseout="this.style.color='var(--text-secondary)'">
          <i class="fa-solid fa-arrow-left me-1"></i> Back to TechAnalytica Home
        </a>
      </div>
    </div>
  </div>

  <script>
    function togglePasswordVisibility() {
      const pwdInput = document.getElementById('password');
      const icon = document.getElementById('togglePasswordIcon');
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        icon.className = 'fa-regular fa-eye-slash';
      } else {
        pwdInput.type = 'password';
        icon.className = 'fa-regular fa-eye';
      }
    }
  </script>
@endsection

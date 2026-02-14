@extends('backend.admin.layouts.blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card px-sm-6 px-0">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              {{-- <a href="{{ url('/') }}" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">@include('_partials.macros')</span>
                <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
              </a> --}}
              <a href="{{ url('/') }}" class="app-brand-link gap-2">
                {{-- <span class="app-brand-logo demo">@include('_partials.macros')</span> --}}
                {{-- <span class="app-brand-text demo menu-text fw-bold ms-2">Golden Peak Trading</span> --}}
                <img class="app-brand-logo demo" src="{{ asset('assets/img/gplogo.png') }}" alt="" width="70%"
                  style="margin: auto">
              </a>

            </div>
            <!-- /Logo -->
            {{-- <h4 class="mb-1">Welcome to {{ config('variables.templateName') }}! 👋</h4> --}}
            <p class="mb-6">Please sign-in to your account and start the adventure</p>

            <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
              @csrf <!-- VERY IMPORTANT -->

              <div class="mb-6">
                <label for="email" class="form-label">Email or Username</label>
                <input type="text" class="form-control @error('email-username') is-invalid @enderror" id="email"
                  name="email-username" value="{{ old('email-username') }}" placeholder="Enter your email or username"
                  autofocus />

                @error('email-username')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="············" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                </div>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- <div class="mb-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" name="remember-me" id="remember-me" />
                    <label class="form-check-label" for="remember-me">Remember Me</label>
                  </div>
                  <a href="{{ url('auth/forgot-password-basic') }}">
                    <span>Forgot Password?</span>
                  </a>
                </div>
              </div> --}}

              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
              </div>
            </form>
            {{-- <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{ url('auth/register-basic') }}">
                <span>Create an account</span>
              </a>
            </p> --}}
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
@endsection

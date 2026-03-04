@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
@endphp

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
            <span
                class="app-brand-text demo menu-text fw-bold text-heading">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base bx bx-menu icon-md"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        {{-- <div class="nav-item d-flex align-items-center">
            <i class="icon-base bx bx-search icon-md"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search...">
        </div> --}}
    </div>
    <!-- /Search -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Tool Selector -->
        @include('backend.vendor.layouts.sections.navbar.tool-selector')

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                        class="w-px-40 h-auto rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                <small class="text-muted">Vendor</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('vendor.billing') }}">
                        <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i><span
                                class="flex-grow-1 align-middle">Billing & Plan</span>
                        </span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <a class="dropdown-item" href="javascript:void(0);"
                            onclick="document.getElementById('logout-form').submit();">
                            <i class="icon-base bx bx-power-off icon-md me-3 text-danger"></i><span
                                class="text-danger">Log Out</span>
                        </a>
                    </form>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

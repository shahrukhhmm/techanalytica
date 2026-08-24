<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('/assets') . '/' }}" dir="ltr"
    data-skin="default" data-base-url="{{ url('/') }}" data-framework="laravel" data-bs-theme="light"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js" type="text/javascript"></script>
    <title>
        @yield('title') | {{ config('variables.templateName') ? config('variables.templateName') : 'TemplateName' }}
        - {{ config('variables.templateSuffix') ? config('variables.templateSuffix') : 'TemplateSuffix' }}
    </title>
    <meta name="description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
    <meta name="keywords"
        content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}" />
    <meta property="og:title" content="{{ config('variables.ogTitle') ? config('variables.ogTitle') : '' }}" />
    <meta property="og:type" content="{{ config('variables.ogType') ? config('variables.ogType') : '' }}" />
    <meta property="og:url" content="{{ config('variables.productPage') ? config('variables.productPage') : '' }}" />
    <meta property="og:image" content="{{ config('variables.ogImage') ? config('variables.ogImage') : '' }}" />
    <meta property="og:description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
    <meta property="og:site_name"
        content="{{ config('variables.creatorName') ? config('variables.creatorName') : '' }}" />
    <meta name="robots" content="noindex, nofollow" />
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Include Styles -->
    @include('backend.vendor.layouts.sections.styles')

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('backend.vendor.layouts.sections.scriptsIncludes')

    <style>
        :root {
            --tech-bg: #0a040e;
            --tech-card: #13071a;
            --tech-card-hover: #190922;
            --tech-border: rgba(224, 67, 133, 0.18);
            --tech-pink: #e04385;
            --tech-gradient: linear-gradient(135deg, #e04385 0%, #a4358a 100%);
            --tech-text-primary: #f8fafc;
            --tech-text-muted: #94a3b8;
        }

        body, .layout-wrapper, .layout-container, .layout-page, .content-wrapper {
            background-color: var(--tech-bg) !important;
            color: var(--tech-text-primary) !important;
        }

        /* Sidebar Navigation */
        .bg-menu-theme {
            background: linear-gradient(180deg, #0d0413 0%, #08020d 100%) !important;
            border-right: 1px solid var(--tech-border) !important;
        }

        .bg-menu-theme .menu-link, .bg-menu-theme .menu-text {
            color: #cbd5e1 !important;
        }

        .bg-menu-theme .menu-item.active > .menu-link {
            background: var(--tech-gradient) !important;
            color: #fff !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 18px rgba(224, 67, 133, 0.45) !important;
            border-radius: 8px !important;
        }

        .bg-menu-theme .menu-item.active > .menu-link .menu-icon,
        .bg-menu-theme .menu-item.active > .menu-link .menu-text {
            color: #fff !important;
        }

        .bg-menu-theme .menu-link:hover {
            background: rgba(224, 67, 133, 0.1) !important;
            color: #fff !important;
        }

        .menu-header-text {
            color: var(--tech-pink) !important;
            font-weight: 700 !important;
            letter-spacing: 0.8px;
        }

        /* Top Navbar */
        .layout-navbar {
            background: rgba(13, 4, 19, 0.85) !important;
            backdrop-filter: blur(12px) !important;
            border-bottom: 1px solid var(--tech-border) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
        }

        /* Cards */
        .card {
            background: var(--tech-card) !important;
            border: 1px solid var(--tech-border) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4) !important;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .card:hover {
            border-color: rgba(224, 67, 133, 0.45) !important;
            box-shadow: 0 12px 35px rgba(224, 67, 133, 0.15) !important;
        }

        .card-title, .card h4, .card h5, .card h6 {
            color: #fff !important;
            font-weight: 700 !important;
        }

        .card-text, .text-muted {
            color: var(--tech-text-muted) !important;
        }

        /* Badges */
        .bg-label-primary {
            background-color: rgba(224, 67, 133, 0.15) !important;
            color: var(--tech-pink) !important;
        }

        .bg-label-success {
            background-color: rgba(16, 185, 129, 0.15) !important;
            color: #10b981 !important;
        }

        .bg-label-info {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #3b82f6 !important;
        }

        .bg-label-warning {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #f59e0b !important;
        }

        /* Buttons */
        .btn-primary {
            background: var(--tech-gradient) !important;
            border: none !important;
            box-shadow: 0 4px 14px rgba(224, 67, 133, 0.4) !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(224, 67, 133, 0.6) !important;
        }

        .btn-outline-primary {
            border-color: var(--tech-pink) !important;
            color: var(--tech-pink) !important;
        }

        .btn-outline-primary:hover {
            background: var(--tech-pink) !important;
            color: #fff !important;
        }

        /* Modal */
        .modal-content {
            background-color: #120619 !important;
            border: 1px solid var(--tech-border) !important;
            color: #fff !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--tech-border) !important;
            background: #0d0413 !important;
        }

        /* Tables */
        .table {
            color: #cbd5e1 !important;
        }

        .table th {
            color: #fff !important;
            border-bottom: 1px solid var(--tech-border) !important;
            background: rgba(255, 255, 255, 0.02) !important;
        }

        .table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
    </style>
</head>

<body>
    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->



    <!-- Include Scripts -->
    @include('backend.vendor.layouts.sections.scripts')
</body>

</html>

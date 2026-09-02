<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('/assets') . '/' }}" dir="ltr"
    data-skin="default" data-base-url="{{ url('/') }}" data-framework="laravel" data-bs-theme="dark"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | TechAnalytica Vendor Portal</title>
    <meta name="description" content="TechAnalytica Vendor Management & Analytics Dashboard" />
    <meta name="robots" content="noindex, nofollow" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Google Fonts: Plus Jakarta Sans & Inter (Matching Frontend) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Include Styles -->
    @include('backend.vendor.layouts.sections.styles')

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('backend.vendor.layouts.sections.scriptsIncludes')

    <style>
        :root {
            --bg-dark: #0a050d;
            --bg-card: #150d1a;
            --bg-card-hover: #1f1326;
            --text-primary: #ffffff;
            --text-secondary: #9a8c9e;
            --accent-pink: #e04385;
            --accent-gradient: linear-gradient(135deg, #e04385 0%, #a4358a 50%, #6e278d 100%);
            --button-pink: #d83b7d;
            --button-gradient: linear-gradient(90deg, #e04385 0%, #fa709a 100%);
            --border-dark: rgba(255, 255, 255, 0.08);
            --card-glow: rgba(224, 67, 133, 0.15);
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
            background-color: var(--bg-dark) !important;
            color: var(--text-primary) !important;
            min-height: 100vh;
            position: relative;
        }

        /* Ambient Background Wave Overlay (Matching Frontend) */
        .bg-wave-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 50% 20%, rgba(224, 67, 133, 0.18) 0%, transparent 60%),
                radial-gradient(circle at 100% 70%, rgba(164, 53, 138, 0.12) 0%, transparent 50%),
                radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 0);
            background-size: 100% 100%, 100% 100%, 28px 28px;
            pointer-events: none;
            z-index: 0;
        }

        .layout-wrapper, .layout-container, .layout-page, .content-wrapper {
            background-color: transparent !important;
            position: relative;
            z-index: 1;
        }

        /* Brand Logo */
        .app-brand {
            padding: 1.25rem 1.5rem;
        }
        .logo-dots-brand {
            display: grid;
            grid-template-columns: repeat(3, 5px);
            gap: 3px;
        }
        .logo-dots-brand span {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--accent-pink);
        }
        .logo-dots-brand span:nth-child(2n) {
            background: #a4358a;
        }
        .logo-dots-brand span:nth-child(3n) {
            background: #e04385;
        }

        /* Sidebar Navigation */
        .bg-menu-theme {
            background: linear-gradient(180deg, #0d0513 0%, #08020d 100%) !important;
            border-right: 1px solid var(--border-dark) !important;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.4) !important;
        }

        .bg-menu-theme .menu-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            border-radius: 10px;
            margin: 2px 12px;
            transition: all 0.2s ease;
        }

        .bg-menu-theme .menu-link:hover {
            background: rgba(224, 67, 133, 0.12) !important;
            color: #ffffff !important;
        }

        .bg-menu-theme .menu-item.active > .menu-link {
            background: var(--accent-gradient) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 18px rgba(224, 67, 133, 0.45) !important;
        }

        .bg-menu-theme .menu-item.active > .menu-link i,
        .bg-menu-theme .menu-item.active > .menu-link div {
            color: #ffffff !important;
        }

        .menu-header-text {
            color: var(--accent-pink) !important;
            font-weight: 700 !important;
            font-size: 0.72rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Top Navbar */
        .layout-navbar {
            background: rgba(18, 10, 24, 0.85) !important;
            backdrop-filter: blur(16px) !important;
            border-bottom: 1px solid var(--border-dark) !important;
            border-radius: 14px;
            margin-top: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35) !important;
        }

        /* Cards */
        .card {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-dark) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .card:hover {
            border-color: rgba(224, 67, 133, 0.35) !important;
            box-shadow: 0 12px 35px var(--card-glow) !important;
        }

        .card-title, .card h4, .card h5, .card h6 {
            color: #ffffff !important;
            font-weight: 700 !important;
            letter-spacing: -0.3px;
        }

        .card-text, .text-muted {
            color: var(--text-secondary) !important;
        }

        /* Stat Cards */
        .stat-card-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .stat-icon-pink {
            background: rgba(224, 67, 133, 0.15);
            color: #e04385;
            border: 1px solid rgba(224, 67, 133, 0.3);
        }
        .stat-icon-purple {
            background: rgba(164, 53, 138, 0.15);
            color: #a4358a;
            border: 1px solid rgba(164, 53, 138, 0.3);
        }
        .stat-icon-blue {
            background: rgba(0, 242, 254, 0.15);
            color: #00f2fe;
            border: 1px solid rgba(0, 242, 254, 0.3);
        }
        .stat-icon-green {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* Badges */
        .bg-label-primary {
            background-color: rgba(224, 67, 133, 0.15) !important;
            color: var(--accent-pink) !important;
            border: 1px solid rgba(224, 67, 133, 0.3);
        }
        .bg-label-success {
            background-color: rgba(16, 185, 129, 0.15) !important;
            color: #10b981 !important;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .bg-label-info {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #3b82f6 !important;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        .bg-label-warning {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #f59e0b !important;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        /* Buttons */
        .btn-primary {
            background: var(--button-pink) !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 14px rgba(224, 67, 133, 0.35) !important;
            transition: all 0.2s ease !important;
        }
        .btn-primary:hover {
            background: #c22f6d !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(224, 67, 133, 0.5) !important;
        }

        .btn-outline-primary {
            border-color: var(--accent-pink) !important;
            color: var(--accent-pink) !important;
            border-radius: 8px !important;
        }
        .btn-outline-primary:hover {
            background: var(--accent-pink) !important;
            color: #ffffff !important;
        }

        /* Tables */
        .table {
            color: #cbd5e1 !important;
        }
        .table th {
            color: #ffffff !important;
            border-bottom: 1px solid var(--border-dark) !important;
            background: rgba(255, 255, 255, 0.03) !important;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        /* Form Controls */
        .form-control, .form-select {
            background-color: #120917 !important;
            border: 1px solid var(--border-dark) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-pink) !important;
            box-shadow: 0 0 0 3px rgba(224, 67, 133, 0.2) !important;
        }

        /* Modals & Dropdowns */
        .modal-content, .dropdown-menu {
            background-color: #150d1a !important;
            border: 1px solid var(--border-dark) !important;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.6) !important;
            border-radius: 14px !important;
            color: #ffffff !important;
        }
        .dropdown-item {
            color: var(--text-secondary) !important;
        }
        .dropdown-item:hover {
            background: rgba(224, 67, 133, 0.15) !important;
            color: #ffffff !important;
        }
    </style>
</head>

<body>
    <!-- Ambient Pattern -->
    <div class="bg-wave-pattern"></div>

    <!-- Layout Content -->
    @yield('layoutContent')

    <!-- Include Scripts -->
    @include('backend.vendor.layouts.sections.scripts')
</body>

</html>

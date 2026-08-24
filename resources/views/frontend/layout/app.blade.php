<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', 'TechAnalytica - Find AI tools Worth Adopting')</title>
    <meta name="description" content="@yield('meta_description', 'Discover and review the best AI tools and software on TechAnalytica.')">
    <link rel="canonical" href="@yield('canonical_url', request()->url())">
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
            line-height: 1.5;
            position: relative;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* SVG Background Grid/Dot Wave */
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        /* Top Bar Navigation Header */
        header {
            padding: 20px 0;
            position: relative;
            z-index: 100;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(18, 10, 24, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-dark);
            padding: 12px 24px;
            border-radius: 16px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 22px;
            letter-spacing: -0.5px;
        }

        .logo-dots {
            display: grid;
            grid-template-columns: repeat(3, 6px);
            gap: 3px;
        }

        .logo-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent-pink);
        }

        .logo-dot:nth-child(2n) {
            background: #a4358a;
        }

        .logo-dot:nth-child(3n) {
            background: #e04385;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .nav-links a:hover {
            color: #fff;
        }

        .nav-dropdown {
            position: relative;
            cursor: pointer;
        }

        .nav-dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 0;
        }

        .nav-arrow {
            font-size: 11px;
            transition: transform 0.3s ease;
        }

        .nav-dropdown:hover .nav-arrow {
            transform: rotate(180deg);
            color: var(--accent-pink);
        }

        /* Hover Dropdown Menu Card */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: -20px;
            padding-top: 14px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px) scale(0.96);
            transition: opacity 0.25s cubic-bezier(0.2, 0.8, 0.2, 1), transform 0.25s cubic-bezier(0.2, 0.8, 0.2, 1), visibility 0.25s ease;
            z-index: 500;
        }

        .nav-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .dropdown-menu-inner {
            width: 320px;
            background: #140a1b;
            border: 1px solid rgba(224, 67, 133, 0.3);
            border-radius: 16px;
            padding: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7), 0 0 30px rgba(224, 67, 133, 0.15);
            backdrop-filter: blur(20px);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px 12px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .dropdown-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .dropdown-title {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .dropdown-desc {
            font-size: 11px;
            color: var(--text-secondary);
            line-height: 1.3;
        }


        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-calc {
            background: var(--button-gradient);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(224, 67, 133, 0.3);
        }

        .btn-calc:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 8px 25px rgba(224, 67, 133, 0.6), 0 0 15px rgba(250, 112, 154, 0.5);
            background: linear-gradient(90deg, #f05497 0%, #ff83aa 100%);
        }

        .btn-search {
            background: var(--button-pink);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(216, 59, 125, 0.4);
        }

        .btn-search:hover {
            background: #f0488d;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 8px 25px rgba(240, 72, 141, 0.7);
        }

        .btn-view-all {
            background: rgba(224, 67, 133, 0.15);
            color: #ff7bb3;
            border: 1px solid rgba(224, 67, 133, 0.5);
            padding: 12px 32px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-view-all:hover {
            background: var(--button-pink);
            color: #ffffff;
            border-color: #ff7bb3;
            transform: translateY(-3px) scale(1.04);
            box-shadow: 0 10px 28px rgba(224, 67, 133, 0.6);
        }

        .btn-cta-pink {
            background: var(--button-pink);
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(216, 59, 125, 0.35);
        }

        .btn-cta-pink:hover {
            background: #0f0714;
            color: #ff7bb3;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.4);
        }

        .btn-cta-outline {
            background: transparent;
            border: 1.5px solid #5c2045;
            color: #5c2045;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-cta-outline:hover {
            background: #5c2045;
            color: #ffffff;
            border-color: #5c2045;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 6px 20px rgba(92, 32, 69, 0.35);
        }

        .btn-submit-ai {
            background: var(--button-pink);
            color: #fff;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(216, 59, 125, 0.35);
        }

        .btn-submit-ai:hover {
            background: #f0488d;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 8px 24px rgba(240, 72, 141, 0.6);
        }

        .btn-visit {
            color: var(--accent-pink);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .btn-visit:hover {
            color: #ffffff;
            background: rgba(224, 67, 133, 0.2);
            transform: translateX(3px);
        }

        .pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-secondary);
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .pill.active, .pill:hover {
            background: var(--button-pink);
            color: #fff;
            border-color: #ff7bb3;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(224, 67, 133, 0.4);
        }


        .hamburger-btn {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .hamburger-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Fullscreen Overlay Menu */
        .overlay-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(6, 2, 8, 0.96);
            backdrop-filter: blur(24px);
            z-index: 999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .overlay-menu.active {
            opacity: 1;
            visibility: visible;
        }

        .overlay-close-btn {
            position: absolute;
            top: 28px;
            right: 40px;
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 28px;
            cursor: pointer;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.2s;
            z-index: 1000;
        }

        .overlay-close-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.1);
        }

        .overlay-menu-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 36px;
            text-align: center;
            z-index: 1000;
        }

        .overlay-link {
            font-size: 42px;
            font-weight: 800;
            color: #ffffff;
            transition: color 0.2s ease, transform 0.2s ease;
            letter-spacing: -0.5px;
        }

        .overlay-link:hover {
            color: var(--accent-pink);
            transform: scale(1.05);
        }

        /* Curved Red Wave Overlay Graphic */
        .overlay-wave-graphic {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60%;
            pointer-events: none;
            opacity: 0.5;
            background: radial-gradient(ellipse at bottom left, rgba(224, 67, 133, 0.35) 0%, transparent 65%);
        }

        /* Hero Section */
        .hero-section {
            padding: 90px 0 60px;
            text-align: center;
            position: relative;
        }

        .hero-title {
            font-size: 52px;
            font-weight: 800;
            letter-spacing: -1.5px;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .hero-subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 40px;
        }

        .search-box-wrapper {
            max-width: 680px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            padding: 8px 8px 8px 24px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .search-box-wrapper i {
            color: var(--text-secondary);
            font-size: 18px;
        }

        .search-input {
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 15px;
            flex: 1;
            font-family: inherit;
        }

        .search-input::placeholder {
            color: #6c5a72;
        }

        .btn-search {
            background: var(--button-pink);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-search:hover {
            opacity: 0.9;
        }

        /* Infinite Horizontal Scrolling Ticker */
        .sponsors-bar-wrapper {
            overflow: hidden;
            width: 100%;
            padding: 40px 0 80px;
            position: relative;
            mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
        }

        .sponsors-bar-track {
            display: flex;
            align-items: center;
            gap: 60px;
            width: max-content;
            animation: scrollTicker 30s linear infinite;
        }

        .sponsors-bar-track:hover {
            animation-play-state: paused;
        }

        .sponsor-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 700;
            color: #d1c4d6;
            white-space: nowrap;
            opacity: 0.8;
            transition: opacity 0.2s, color 0.2s;
        }

        .sponsor-item:hover {
            opacity: 1;
            color: #ffffff;
        }

        @keyframes scrollTicker {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }


        /* Section Header */
        .section-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .section-title {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -0.8px;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .section-desc {
            color: var(--text-secondary);
            font-size: 14px;
        }

        /* 3D Curved Wireframe Mesh Wave Background Overlays */
        .mesh-wave-hero, .mesh-wave-tools, .mesh-wave-categories, .mesh-wave-cta, .mesh-wave-faq {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background-repeat: no-repeat;
            z-index: 0;
        }

        .mesh-wave-hero {
            background-image: 
                radial-gradient(ellipse at 15% 40%, rgba(224, 67, 133, 0.22) 0%, transparent 50%),
                radial-gradient(circle at 80% 30%, rgba(164, 53, 138, 0.15) 0%, transparent 45%),
                repeating-radial-gradient(circle at 20% 50%, rgba(224, 67, 133, 0.08) 0, rgba(224, 67, 133, 0.08) 2px, transparent 4px, transparent 24px);
            opacity: 0.85;
        }

        .mesh-wave-tools {
            background-image: 
                radial-gradient(ellipse at 85% 60%, rgba(224, 67, 133, 0.12) 0%, transparent 50%),
                repeating-radial-gradient(circle at 10% 40%, rgba(164, 53, 138, 0.05) 0, rgba(164, 53, 138, 0.05) 2px, transparent 3px, transparent 28px);
        }

        .mesh-wave-categories {
            background-image: 
                radial-gradient(ellipse at 10% 50%, rgba(224, 67, 133, 0.18) 0%, transparent 50%),
                radial-gradient(ellipse at 90% 70%, rgba(164, 53, 138, 0.12) 0%, transparent 50%);
        }

        .mesh-wave-cta {
            background-image: radial-gradient(circle at 50% 50%, rgba(224, 67, 133, 0.08) 0%, transparent 60%);
        }

        .mesh-wave-faq {
            background-image: radial-gradient(circle at 15% 70%, rgba(224, 67, 133, 0.14) 0%, transparent 50%);
        }

        /* 1. Hero Section */
        .hero-section {
            padding: 90px 0 40px;
            text-align: center;
            position: relative;
        }

        .hero-title {
            font-size: 56px;
            font-weight: 800;
            letter-spacing: -1.8px;
            margin-bottom: 16px;
            color: #ffffff;
            line-height: 1.15;
        }

        .hero-subtitle {
            font-size: 16px;
            color: #a89bb0;
            margin-bottom: 40px;
        }

        .search-box-wrapper {
            max-width: 660px;
            margin: 0 auto 40px;
            background: rgba(20, 10, 26, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(16px);
            padding: 8px 8px 8px 24px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.6), 0 0 20px rgba(224, 67, 133, 0.1);
        }

        .search-box-wrapper i {
            color: #8f7d96;
            font-size: 18px;
        }

        .search-input {
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 15px;
            flex: 1;
            font-family: inherit;
        }

        .search-input::placeholder {
            color: #6e5c75;
        }

        /* 2. Tools Showcase Section */
        .tools-showcase-section {
            padding: 40px 0 80px;
            position: relative;
        }

        .tools-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 44px;
        }

        .tool-card {
            background: #140b19;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 24px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .tool-card:hover {
            transform: translateY(-6px);
            border-color: rgba(224, 67, 133, 0.5);
            box-shadow: 0 16px 36px rgba(224, 67, 133, 0.2), 0 0 20px rgba(0, 0, 0, 0.6);
        }

        .tool-badge {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-featured {
            background: rgba(224, 67, 133, 0.2);
            color: #ff7bb3;
            border: 1px solid rgba(224, 67, 133, 0.4);
        }

        .badge-pro {
            background: rgba(164, 53, 138, 0.2);
            color: #d67cd6;
            border: 1px solid rgba(164, 53, 138, 0.4);
        }

        .badge-trending {
            background: rgba(245, 158, 11, 0.2);
            color: #fbb73d;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }

        .badge-popular {
            background: rgba(59, 130, 246, 0.2);
            color: #7cb3ff;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        .badge-verified {
            background: rgba(16, 185, 129, 0.2);
            color: #4ade80;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .badge-new {
            background: rgba(6, 182, 212, 0.2);
            color: #38bdf8;
            border: 1px solid rgba(6, 182, 212, 0.4);
        }

        .tool-header {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 16px;
        }

        .tool-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .icon-red { background: linear-gradient(135deg, #ef4444, #b91c1c); color: #fff; }
        .icon-purple { background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: #fff; }
        .icon-orange { background: linear-gradient(135deg, #f97316, #c2410c); color: #fff; }
        .icon-blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: #fff; }
        .icon-yellow { background: linear-gradient(135deg, #eab308, #a16207); color: #fff; }
        .icon-cyan { background: linear-gradient(135deg, #06b6d4, #0e7490); color: #fff; }

        .tool-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #ffffff;
        }

        .tool-category {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .tool-desc {
            font-size: 13px;
            color: #b5a4bb;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .tool-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding-top: 16px;
            font-size: 13px;
        }

        .pricing-tag {
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 12px;
        }

        /* 3. Why TechAnalytica? (White Section) */
        .why-section {
            background: #ffffff;
            color: #111;
            padding: 100px 0;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .why-section .section-title {
            color: #0e0513;
            font-size: 38px;
            font-weight: 800;
            letter-spacing: -0.8px;
            margin-bottom: 10px;
        }

        .why-section .section-desc {
            color: #645a6c;
            font-size: 15px;
            margin-bottom: 60px;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
        }

        .why-card {
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .why-card:hover {
            transform: translateY(-6px);
        }

        .why-icon {
            width: 68px;
            height: 68px;
            background: #fdebf2;
            color: #d83b7d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 22px;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .why-card:hover .why-icon {
            transform: scale(1.1) rotate(6deg);
            background: #fcd5e5;
        }

        .why-card h4 {
            font-size: 18px;
            font-weight: 800;
            color: #150a1b;
            margin-bottom: 10px;
        }

        .why-card p {
            font-size: 13px;
            color: #6e6475;
            line-height: 1.6;
        }

        /* 4. Browse Categories */
        .categories-section {
            padding: 100px 0;
            background: var(--bg-dark);
            position: relative;
        }

        .category-pills {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 44px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 44px;
        }

        .cat-card {
            background: #140b19;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 26px;
            transition: all 0.3s ease;
            text-align: left;
        }

        .cat-card:hover {
            transform: translateY(-4px);
            border-color: var(--accent-pink);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        }

        .cat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            margin-bottom: 18px;
        }

        .icon-cat-green { background: #10b981; }
        .icon-cat-purple { background: #8b5cf6; }
        .icon-cat-orange { background: #f59e0b; }
        .icon-cat-blue { background: #3b82f6; }

        .cat-card h4 {
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .cat-card p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .cat-btn-wrapper {
            text-align: center;
        }

        .btn-explore-cats {
            background: var(--button-gradient);
            color: #fff;
            border: none;
            padding: 12px 36px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 20px rgba(224, 67, 133, 0.4);
        }

        .btn-explore-cats:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 28px rgba(224, 67, 133, 0.6);
        }

        /* 5. Dual CTA Banners Section */
        .cta-section {
            padding: 40px 0 100px;
            position: relative;
        }

        .cta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }

        .cta-banner-card {
            border-radius: 24px;
            padding: 44px 40px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 250px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .banner-vendor, .banner-reviewer {
            background: linear-gradient(135deg, #fef0f6 0%, #fbd5e5 50%, #f8bcd4 100%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }

        .cta-banner-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 50px rgba(224, 67, 133, 0.25);
        }

        .cta-banner-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(224, 67, 133, 0.18);
            color: #d83b7d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .cta-banner-card h3 {
            font-size: 26px;
            font-weight: 800;
            color: #2d0b21;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .cta-banner-card p {
            font-size: 14px;
            color: #5e2648;
            margin-bottom: 28px;
            line-height: 1.5;
            max-width: 90%;
        }

        .cta-buttons {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        /* 6. Community Testimonials */
        .testimonial-section {
            padding: 60px 0 100px;
            position: relative;
        }

        .testimonial-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 60px;
            align-items: center;
        }

        .testimonial-text h2 {
            font-size: 38px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 14px;
            color: #fff;
        }

        .testimonial-text p {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 28px;
            max-width: 440px;
        }

        .btn-join-community {
            background: var(--button-gradient);
            color: #fff;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 16px rgba(224, 67, 133, 0.4);
        }

        .btn-join-community:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(224, 67, 133, 0.6);
        }

        .testimonial-cards {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .t-card {
            background: #140b19;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            align-items: flex-start;
            gap: 18px;
            transition: all 0.3s ease;
        }

        .t-card:hover {
            transform: translateX(6px);
            border-color: rgba(224, 67, 133, 0.4);
            box-shadow: 0 10px 28px rgba(0,0,0,0.5);
        }

        .t-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            border: 2px solid var(--accent-pink);
            flex-shrink: 0;
        }

        .t-info h5 {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 2px;
        }

        .t-info p {
            font-size: 12px;
            color: #9a8c9e;
            margin-bottom: 8px;
        }

        .t-quote {
            font-size: 13px;
            color: #d1c4d6;
            font-style: italic;
            line-height: 1.4;
        }

        .t-stars {
            margin-left: auto;
            color: #ffb400;
            font-size: 13px;
            letter-spacing: 2px;
            flex-shrink: 0;
        }

        /* 7. AI Insights Section (White) */
        .insights-section {
            background: #ffffff;
            color: #111;
            padding: 100px 0;
            position: relative;
            z-index: 2;
        }

        .insights-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 48px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .insights-header-row .section-title {
            font-size: 36px;
            font-weight: 800;
            color: #0d0413;
            letter-spacing: -0.8px;
            margin-bottom: 6px;
        }

        .insights-header-row .section-desc {
            font-size: 14px;
            color: #645a6c;
        }

        .newsletter-quick-box {
            display: flex;
            align-items: center;
            background: #f5f2f7;
            border: 1px solid #e2dbe6;
            border-radius: 50px;
            padding: 4px 4px 4px 18px;
        }

        .newsletter-quick-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: #333;
            width: 220px;
        }

        .btn-quick-sub {
            background: var(--button-pink);
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-quick-sub:hover {
            background: #f0488d;
        }

        .insights-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
        }

        .featured-insight-card {
            background: #0d0413;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .featured-insight-card:hover {
            transform: translateY(-4px);
        }

        .featured-insight-visual {
            background: radial-gradient(circle at 70% 30%, rgba(224, 67, 133, 0.4) 0%, rgba(13, 4, 19, 0.95) 70%);
            padding: 60px 40px 40px;
            position: relative;
            min-height: 240px;
            display: flex;
            align-items: flex-end;
        }

        .neon-wave-graphic {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 200px;
            height: 100px;
            opacity: 0.85;
        }

        .hero-visual-title {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            letter-spacing: -0.5px;
            z-index: 1;
        }

        .featured-insight-body {
            padding: 30px 40px 40px;
            background: #ffffff;
            border: 1px solid #eee;
            border-top: none;
            border-radius: 0 0 24px 24px;
        }

        .insight-badge {
            background: #fdebf2;
            color: #d83b7d;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 12px;
        }

        .featured-insight-body h4 {
            font-size: 20px;
            font-weight: 800;
            color: #0d0413;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .featured-insight-body p {
            font-size: 14px;
            color: #645a6c;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn-read-insight {
            color: #d83b7d;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s ease;
        }

        .btn-read-insight:hover {
            transform: translateX(4px);
            color: #0d0413;
        }

        .insight-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            justify-content: space-between;
        }

        .insight-item {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 18px;
            border-radius: 18px;
            border: 1px solid #eee;
            background: #faf9fb;
            transition: all 0.25s ease;
        }

        .insight-item:hover {
            transform: translateX(6px);
            background: #ffffff;
            border-color: #fbd5e5;
            box-shadow: 0 10px 24px rgba(224, 67, 133, 0.12);
        }

        .insight-img {
            width: 90px;
            height: 90px;
            border-radius: 14px;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
        }

        .insight-category-tag {
            font-size: 11px;
            font-weight: 700;
            color: #d83b7d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            display: block;
        }

        .insight-content h4 {
            font-size: 16px;
            font-weight: 700;
            color: #0d0413;
            line-height: 1.35;
            margin-bottom: 6px;
        }

        .insight-meta {
            font-size: 12px;
            color: #887d90;
        }

        /* 8. FAQ Section */
        .faq-section {
            padding: 100px 0;
            background: transparent;
            position: relative;
        }

        .faq-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 60px;
        }

        .faq-intro .faq-kicker {
            font-size: 12px;
            font-weight: 700;
            color: var(--accent-pink);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: inline-block;
        }

        .faq-intro .section-title {
            font-size: 38px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 16px;
            color: #fff;
        }

        .faq-intro .section-desc {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .faq-help-link {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .faq-help-link a {
            color: var(--accent-pink);
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: transform 0.2s;
        }

        .faq-help-link a:hover {
            transform: translateX(4px);
        }

        .faq-accordion {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .faq-item {
            background: #140b19;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 20px 24px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: rgba(224, 67, 133, 0.4);
            transform: translateY(-2px);
        }

        .faq-item.active {
            border-color: var(--accent-pink);
            background: #1a0b22;
            box-shadow: 0 0 24px rgba(224, 67, 133, 0.2);
        }

        .faq-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-header h5 {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }

        .faq-icon {
            color: var(--accent-pink);
            transition: transform 0.3s ease;
            font-size: 14px;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.35s ease, opacity 0.3s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 250px;
            opacity: 1;
            margin-top: 14px;
        }

        .faq-answer p {
            font-size: 14px;
            color: #a89bb0;
            line-height: 1.6;
        }

        /* Continuous Ambient Glowing Pulsing Background Mesh */
        .bg-wave-pattern::after {
            content: '';
            position: absolute;
            top: 20%;
            left: 50%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(224, 67, 133, 0.15) 0%, rgba(164, 53, 138, 0.05) 50%, transparent 70%);
            transform: translate(-50%, -50%);
            border-radius: 50%;
            animation: pulseGlow 8s ease-in-out infinite alternate;
            pointer-events: none;
        }

        @keyframes pulseGlow {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0.5;
            }
            100% {
                transform: translate(-45%, -55%) scale(1.3);
                opacity: 0.9;
            }
        }

        /* Rich Scroll Reveal Animations for all cards */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.7s cubic-bezier(0.2, 0.8, 0.2, 1), transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .reveal-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* BLOG PAGE STYLES */
        .blog-hero {
            padding: 60px 0 40px;
        }

        .blog-hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 40px;
            align-items: center;
        }

        .blog-hero-title {
            font-size: 46px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 16px;
        }

        .blog-hero-desc {
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            max-width: 540px;
            line-height: 1.6;
        }

        .blog-search-box {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 6px 6px 6px 16px;
            max-width: 480px;
        }

        .blog-search-box input {
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 14px;
            flex: 1;
        }

        .btn-blog-search {
            background: var(--button-gradient);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-blog-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(224, 67, 133, 0.4);
        }

        .hero-featured-box {
            background: linear-gradient(135deg, #1f0b2a, #13061c);
            border: 1px solid rgba(224, 67, 133, 0.3);
            border-radius: 20px;
            padding: 30px;
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .hero-featured-box:hover {
            transform: translateY(-4px);
            border-color: var(--accent-pink);
        }

        .blog-badge {
            background: var(--button-gradient);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 14px;
        }

        .hero-featured-box h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .hero-featured-box p {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .author-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            border: 2px solid var(--accent-pink);
        }

        .author-row strong {
            display: block;
            font-size: 13px;
            color: #fff;
        }

        .author-row span {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* ARTICLE DETAIL PAGE STYLES */
        .container-narrow {
            max-width: 900px;
            margin: 0 auto;
        }

        .article-hero {
            padding: 40px 0 30px;
        }

        .article-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 24px;
        }

        .article-breadcrumb a {
            color: var(--text-secondary);
            transition: color 0.2s ease;
        }

        .article-breadcrumb a:hover {
            color: var(--accent-pink);
        }

        .article-breadcrumb i {
            font-size: 10px;
            opacity: 0.5;
        }

        .article-badges {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }

        .blog-badge-outline {
            border: 1px solid var(--accent-pink);
            color: var(--accent-pink);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .article-title {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 20px;
            color: #fff;
        }

        .article-subtitle {
            font-size: 18px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .article-meta-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 1px solid var(--border-dark);
        }

        .article-stats {
            display: flex;
            gap: 20px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .article-stats span i {
            margin-right: 6px;
            color: var(--accent-pink);
        }

        .article-cover-img {
            width: 100%;
            height: 440px;
            border-radius: 24px;
            background-size: cover;
            background-position: center;
            margin: 30px 0 50px;
            border: 1px solid var(--border-dark);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }

        /* Layout & Sticky Sidebar */
        .article-body-wrapper {
            margin-bottom: 80px;
        }

        .article-layout {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 50px;
        }

        .sticky-sidebar-inner {
            position: sticky;
            top: 100px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .toc-box h5 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 12px;
        }

        .toc-box ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toc-box a {
            color: var(--text-secondary);
            font-size: 13px;
            line-height: 1.4;
            display: block;
            transition: all 0.2s ease;
        }

        .toc-box a:hover, .toc-box a.active {
            color: var(--accent-pink);
            transform: translateX(4px);
        }

        .share-box span {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            display: block;
            margin-bottom: 10px;
        }

        .share-btns {
            display: flex;
            gap: 10px;
        }

        .share-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.25s ease;
        }

        .share-btn:hover {
            background: var(--button-gradient);
            border-color: transparent;
            transform: translateY(-2px);
        }

        /* Article Typography & Elements */
        .article-content {
            font-size: 16px;
            line-height: 1.8;
            color: #d1d5db;
        }

        .lead-paragraph {
            font-size: 19px;
            font-weight: 500;
            color: #ffffff;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .article-content p {
            margin-bottom: 24px;
        }

        .article-content h2 {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            margin: 40px 0 16px;
            letter-spacing: -0.3px;
        }

        .content-img-card {
            width: 100%;
            height: 320px;
            border-radius: 16px;
            background-size: cover;
            background-position: center;
            margin: 30px 0 10px;
            border: 1px solid var(--border-dark);
        }

        .img-caption {
            display: block;
            font-size: 12px;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 30px;
            font-style: italic;
        }

        .article-list, .article-list-numbered {
            margin: 0 0 30px 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .article-list li strong, .article-list-numbered li strong {
            color: #fff;
        }

        .article-blockquote {
            background: linear-gradient(135deg, #250a30, #13041c);
            border-left: 4px solid var(--accent-pink);
            border-radius: 12px;
            padding: 30px;
            margin: 35px 0;
        }

        .article-blockquote p {
            font-size: 19px;
            font-weight: 600;
            font-style: italic;
            color: #fff;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .article-blockquote cite {
            font-size: 12px;
            color: var(--accent-pink);
            font-style: normal;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Stats & Alert Box */
        .stats-callout-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin: 35px 0;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 28px;
            font-weight: 800;
            color: var(--accent-pink);
            margin-bottom: 4px;
        }

        .stat-card p {
            font-size: 12px;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.3;
        }

        .info-alert-box {
            background: rgba(224, 67, 133, 0.08);
            border: 1px solid rgba(224, 67, 133, 0.3);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
            margin: 30px 0;
        }

        .alert-icon {
            font-size: 22px;
            color: var(--accent-pink);
            margin-top: 2px;
        }

        .info-alert-box strong {
            color: #fff;
            display: block;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .info-alert-box p {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.5;
        }

        /* Tags & Author Bio */
        .article-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 40px 0;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border-dark);
        }

        .tag-pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            color: var(--text-secondary);
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 20px;
            transition: all 0.2s ease;
        }

        .tag-pill:hover {
            border-color: var(--accent-pink);
            color: #fff;
        }

        .author-bio-card {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .author-avatar-lg {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            border: 3px solid var(--accent-pink);
            flex-shrink: 0;
        }

        .author-bio-info h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .author-bio-info p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .author-socials {
            display: flex;
            gap: 12px;
        }

        .author-socials a {
            color: var(--text-secondary);
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .author-socials a:hover {
            color: var(--accent-pink);
        }

        .blog-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 60px;
        }

        /* VENDOR PAGE STYLES */
        .vendor-hero {
            padding: 40px 0 30px;
        }

        .vendor-hero-title {
            font-size: 44px;
            font-weight: 800;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .vendor-hero-desc {
            font-size: 16px;
            color: var(--text-secondary);
            max-width: 680px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .vendor-header-stats {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .header-rating-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            padding: 8px 16px;
            border-radius: 12px;
        }

        .score-num {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
        }

        .stars {
            color: #f59e0b;
            font-size: 13px;
            display: flex;
            gap: 2px;
        }

        .rating-count {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .header-meta {
            display: flex;
            gap: 16px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .header-meta span i {
            color: var(--accent-pink);
            margin-right: 4px;
        }

        .btn-write-review {
            background: transparent;
            border: 1px solid var(--accent-pink);
            color: var(--accent-pink);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-write-review:hover {
            background: var(--accent-pink);
            color: #fff;
        }

        /* Overview Grid */
        .vendor-overview-section {
            margin: 30px 0 60px;
        }

        .vendor-overview-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 40px;
        }

        .overview-left-text h2 {
            font-size: 22px;
            font-weight: 700;
            margin: 20px 0 10px;
            color: #fff;
        }

        .overview-left-text p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .overview-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .overview-list li strong {
            color: #fff;
        }

        .quick-summary-box {
            background: linear-gradient(145deg, #1b0a24, #0e0414);
            border: 1px solid rgba(224, 67, 133, 0.3);
            border-radius: 20px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .quick-summary-box h3 {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quick-summary-box h3 i {
            color: var(--accent-pink);
        }

        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 12px;
            border-bottom: 1px solid var(--border-dark);
            padding-bottom: 10px;
        }

        .summary-item span {
            color: var(--text-secondary);
        }

        .summary-item strong {
            color: #fff;
            font-size: 13px;
        }

        .btn-jump-rankings {
            background: var(--button-gradient);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-jump-rankings:hover {
            box-shadow: 0 4px 15px rgba(224, 67, 133, 0.4);
            transform: translateY(-2px);
        }

        /* Top Picks Cards */
        .top-picks-section {
            margin-bottom: 60px;
        }

        .top-picks-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .pick-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 20px;
            position: relative;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .gold-border { border: 1px solid #f59e0b; }
        .pink-border { border: 1px solid var(--accent-pink); }
        .blue-border { border: 1px solid #3b82f6; }
        .green-border { border: 1px solid #10b981; }

        .gold-border:hover {
            transform: translateY(-8px) scale(1.03);
            border-color: #ffb703;
            box-shadow: 0 14px 35px rgba(245, 158, 11, 0.45), inset 0 0 20px rgba(245, 158, 11, 0.2);
        }

        .pink-border:hover {
            transform: translateY(-8px) scale(1.03);
            border-color: #ff7bb3;
            box-shadow: 0 14px 35px rgba(224, 67, 133, 0.45), inset 0 0 20px rgba(224, 67, 133, 0.2);
        }

        .blue-border:hover {
            transform: translateY(-8px) scale(1.03);
            border-color: #60a5fa;
            box-shadow: 0 14px 35px rgba(59, 130, 246, 0.45), inset 0 0 20px rgba(59, 130, 246, 0.2);
        }

        .green-border:hover {
            transform: translateY(-8px) scale(1.03);
            border-color: #34d399;
            box-shadow: 0 14px 35px rgba(16, 185, 129, 0.45), inset 0 0 20px rgba(16, 185, 129, 0.2);
        }

        .pick-badge {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 4px 8px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 12px;
            transition: transform 0.3s ease;
        }

        .pick-card:hover .pick-badge {
            transform: scale(1.08);
        }

            padding: 4px 8px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .gold { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .pink { background: rgba(224, 67, 133, 0.2); color: var(--accent-pink); }
        .blue { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        .green { background: rgba(16, 185, 129, 0.2); color: #10b981; }

        .pick-card h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .pick-card p {
            font-size: 12px;
            color: var(--text-secondary);
            line-height: 1.4;
            margin-bottom: 14px;
        }

        .pick-score {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .pick-score strong {
            color: #fff;
        }

        /* Detailed Vendor Rankings Cards */
        .rankings-section {
            margin-bottom: 80px;
        }

        .rankings-filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .sort-box {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .sort-select {
            background: #140a1b;
            border: 1px solid var(--border-dark);
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            outline: none;
        }

        .vendor-card-detailed {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .vendor-card-detailed:hover {
            border-color: rgba(224, 67, 133, 0.4);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .vendor-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .vendor-info-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .vendor-rank {
            font-size: 24px;
            font-weight: 800;
            color: var(--accent-pink);
        }

        .vendor-logo-box {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .vendor-title-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4px;
        }

        .vendor-title-row h3 {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
        }

        .verified-badge {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .vendor-rating-row {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .rating-text {
            color: var(--text-secondary);
        }

        .pricing-text {
            color: var(--text-secondary);
        }

        .vendor-action-box {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .techscore-badge {
            text-align: right;
        }

        .score-title {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 0.5px;
        }

        .score-value {
            font-size: 20px;
            font-weight: 800;
            color: var(--accent-pink);
        }

        .btn-visit {
            background: var(--button-gradient);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-visit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(224, 67, 133, 0.4);
        }

        .vendor-card-body {
            border-top: 1px solid var(--border-dark);
            padding-top: 20px;
        }

        .vendor-description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .vendor-features-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .feature-tag {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            color: #fff;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .feature-tag i {
            color: #10b981;
            margin-right: 6px;
        }

        .vendor-review-highlight {
            background: rgba(255, 255, 255, 0.03);
            border-left: 3px solid var(--accent-pink);
            border-radius: 10px;
            padding: 16px;
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .reviewer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
        }

        .review-quote {
            font-size: 13px;
            font-style: italic;
            color: #d1d5db;
            margin-bottom: 4px;
        }

        .reviewer-meta {
            font-size: 11px;
            color: var(--accent-pink);
            font-weight: 600;
        }

        /* Comparison Table */
        .comparison-table-section {
            margin-bottom: 80px;
        }

        .table-responsive-box {
            overflow-x: auto;
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            background: var(--bg-card);
        }

        .crm-compare-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .crm-compare-table th {
            background: rgba(255, 255, 255, 0.04);
            padding: 16px 20px;
            color: #fff;
            font-weight: 700;
            border-bottom: 1px solid var(--border-dark);
        }

        /* VENDOR DETAIL PAGE STYLES */
        .vendor-detail-hero {
            padding: 40px 0 20px;
        }

        .vendor-detail-header-grid {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            flex-wrap: wrap;
        }

        .vendor-brand-info {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            flex: 1;
            min-width: 320px;
        }

        .vendor-logo-lg {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            flex-shrink: 0;
            box-shadow: 0 10px 25px rgba(0, 161, 224, 0.4);
        }

        .vendor-name {
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
        }

        .vendor-tagline {
            font-size: 15px;
            color: var(--text-secondary);
            margin: 10px 0 16px;
            line-height: 1.5;
            max-width: 600px;
        }

        .vendor-detail-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 13px;
        }

        .rating-box {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .review-count {
            color: var(--text-secondary);
        }

        .meta-divider {
            color: var(--border-dark);
        }

        .meta-item {
            color: var(--text-secondary);
        }

        .meta-item i {
            color: var(--accent-pink);
            margin-right: 4px;
        }

        .vendor-hero-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 14px;
        }

        .techscore-card {
            background: linear-gradient(135deg, #1d0928, #110419);
            border: 1px solid var(--accent-pink);
            border-radius: 14px;
            padding: 10px 20px;
            text-align: center;
        }

        .ts-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            display: block;
        }

        .ts-val {
            font-size: 26px;
            font-weight: 800;
            color: var(--accent-pink);
        }

        .ts-val small {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .btn-visit-lg {
            background: var(--button-gradient);
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-visit-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(224, 67, 133, 0.4);
        }

        .sub-actions {
            display: flex;
            gap: 10px;
        }

        .btn-sub-action {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            color: var(--text-secondary);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-sub-action:hover {
            color: #fff;
            border-color: var(--accent-pink);
        }

        /* Sticky Tabs Bar */
        .vendor-tabs-bar {
            position: sticky;
            top: 72px;
            background: #0d0413;
            border-top: 1px solid var(--border-dark);
            border-bottom: 1px solid var(--border-dark);
            z-index: 400;
            margin: 30px 0 40px;
        }

        .tabs-inner {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .tab-link {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 600;
            padding: 16px 0;
            white-space: nowrap;
            border-bottom: 2px solid transparent;
            transition: all 0.25s ease;
        }

        .tab-link:hover, .tab-link.active {
            color: #fff;
            border-bottom-color: var(--accent-pink);
        }

        /* Main Vendor Grid Layout */
        .vendor-detail-main {
            margin-bottom: 80px;
        }

        .vendor-content-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 40px;
        }

        .detail-card {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .detail-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-card h3 i {
            color: var(--accent-pink);
        }

        .body-p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 14px;
        }

        /* Score Mini Cards */
        .scores-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 20px;
        }

        .score-card-mini {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 16px;
            text-align: center;
        }

        .score-ring {
            font-size: 24px;
            font-weight: 800;
            color: var(--accent-pink);
            margin-bottom: 6px;
        }

        .score-card-mini strong {
            display: block;
            font-size: 13px;
            color: #fff;
            margin-bottom: 2px;
        }

        .score-card-mini span {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* Interface Preview */
        .interface-preview-img {
            width: 100%;
            height: 360px;
            border-radius: 16px;
            background-size: cover;
            background-position: center;
            position: relative;
            border: 1px solid var(--border-dark);
        }

        .preview-badge {
            position: absolute;
            bottom: 16px;
            right: 16px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            color: #fff;
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 8px;
        }

        /* Pros Cons Grid */
        .pros-cons-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .pros-column h4, .cons-column h4 {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pc-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .pc-list li {
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.4;
        }

        /* Pricing Cards */
        .pricing-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 24px;
        }

        .p-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 24px;
            position: relative;
        }

        .featured-p-card {
            border-color: var(--accent-pink);
            background: linear-gradient(145deg, #1e0926, #100318);
        }

        .p-badge-popular {
            position: absolute;
            top: -12px;
            right: 20px;
            background: var(--button-gradient);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 10px;
        }

        .p-tier {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            display: block;
            margin-bottom: 8px;
        }

        .p-price {
            font-size: 28px;
            font-weight: 800;
            color: var(--accent-pink);
            margin-bottom: 8px;
        }

        .p-price span {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .p-desc {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 16px;
            line-height: 1.4;
        }

        .p-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .p-features i {
            color: #10b981;
            margin-right: 6px;
        }

        /* Integrations Grid */
        .integrations-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-top: 20px;
        }

        .int-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 16px 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #fff;
        }

        .int-icon {
            font-size: 24px;
        }

        /* Alternatives */
        .alt-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .alt-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 20px;
        }

        .alt-card h4 {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .alt-score {
            font-size: 11px;
            color: var(--accent-pink);
            font-weight: 700;
            display: block;
            margin-bottom: 10px;
        }

        .alt-card p {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 14px;
            line-height: 1.4;
        }

        .btn-alt-compare {
            display: inline-block;
            background: transparent;
            border: 1px solid var(--border-dark);
            color: #fff;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-alt-compare:hover {
            border-color: var(--accent-pink);
            color: var(--accent-pink);
        }

        /* Sidebar Specs */
        .specs-box {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .specs-box h4 {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .specs-box h4 i {
            color: var(--accent-pink);
        }

        .spec-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-dark);
            font-size: 12px;
        }

        .spec-row:last-child {
            border-bottom: none;
        }

        .spec-row span {
            color: var(--text-secondary);
        }

        .spec-row strong {
            color: #fff;
            text-align: right;
        }

        .sidebar-cta-card {
            background: linear-gradient(145deg, #1c0827, #0f0316);
            border: 1px solid rgba(224, 67, 133, 0.3);
            border-radius: 20px;
            padding: 24px;
            text-align: center;
        }

        .cta-icon {
            font-size: 32px;
            color: var(--accent-pink);
            margin-bottom: 12px;
        }

        .sidebar-cta-card h4 {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .sidebar-cta-card p {
            font-size: 12px;
            color: var(--text-secondary);
            line-height: 1.4;
            margin-bottom: 16px;
        }

        .btn-sidebar-trial {
            width: 100%;
            background: var(--button-gradient);
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-sidebar-trial:hover {
            box-shadow: 0 4px 15px rgba(224, 67, 133, 0.4);
            transform: translateY(-2px);
        }


        .crm-compare-table tr:last-child td {
            border-bottom: none;
        }

        .pill-score {
            background: rgba(224, 67, 133, 0.15);
            color: var(--accent-pink);
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .check-green { color: #10b981; }
        .check-orange { color: #f59e0b; }

        /* Filter Section */
        .blog-filter-section {
            border-top: 1px solid var(--border-dark);

            border-bottom: 1px solid var(--border-dark);
            padding: 16px 0;
            margin-bottom: 40px;
        }


        .filter-pills {
            display: flex;
            align-items: center;
            gap: 12px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .blog-pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            color: var(--text-secondary);
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.25s ease;
        }

        .blog-pill:hover, .blog-pill.active {
            background: var(--button-gradient);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(224, 67, 133, 0.3);
        }

        /* Main Blog Grid Layout */
        .blog-main-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 40px;
            margin-bottom: 80px;
        }

        .sidebar-box {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .sidebar-box h4 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 16px;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sidebar-menu a {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
        }

        .sidebar-menu a:hover {
            color: var(--accent-pink);
            transform: translateX(4px);
        }

        .sidebar-newsletter-card {
            background: linear-gradient(145deg, #1b0a26, #0e0414);
            border: 1px solid rgba(224, 67, 133, 0.3);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }

        .newsletter-icon {
            font-size: 32px;
            color: var(--accent-pink);
            margin-bottom: 12px;
        }

        .sidebar-newsletter-card h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .sidebar-newsletter-card p {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 16px;
            line-height: 1.4;
        }

        .newsletter-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            padding: 10px;
            color: #fff;
            font-size: 12px;
            margin-bottom: 12px;
            outline: none;
        }

        .btn-subscribe {
            width: 100%;
            background: var(--button-gradient);
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-subscribe:hover {
            box-shadow: 0 4px 15px rgba(224, 67, 133, 0.4);
            transform: translateY(-2px);
        }

        /* Feed & Cards */
        .section-heading {
            margin-bottom: 24px;
            margin-top: 10px;
        }

        .section-heading h2 {
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
        }

        .section-heading h2 i {
            color: var(--accent-pink);
        }

        .featured-card-hero {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 20px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 50px;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .featured-card-hero:hover {
            transform: translateY(-4px);
            border-color: rgba(224, 67, 133, 0.4);
        }

        .featured-img-box {
            background-size: cover;
            background-position: center;
            padding: 20px;
            position: relative;
            min-height: 280px;
        }

        .blog-tag {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .featured-card-body {
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .tags-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .mini-tag {
            color: var(--accent-pink);
            font-size: 12px;
            font-weight: 700;
        }

        .read-time {
            color: var(--text-secondary);
            font-size: 12px;
        }

        .featured-card-body h2 {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 12px;
        }

        .featured-card-body p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .blog-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 50px;
        }

        .blog-card {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-4px);
            border-color: rgba(224, 67, 133, 0.4);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .card-thumb {
            height: 160px;
            background-size: cover;
            background-position: center;
            padding: 14px;
        }

        .card-content {
            padding: 20px;
        }

        .card-content h3 {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .card-content p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .post-meta {
            font-size: 11px;
            color: var(--accent-pink);
            font-weight: 600;
        }

        .quote-banner {
            background: linear-gradient(135deg, #260d33, #15061c);
            border-left: 4px solid var(--accent-pink);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 50px;
        }

        .quote-text {
            font-size: 18px;
            font-weight: 600;
            font-style: italic;
            color: #fff;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .quote-author {
            font-size: 12px;
            color: var(--accent-pink);
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Guides list */
        .guide-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 50px;
        }

        .guide-item {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .guide-item:hover {
            transform: translateX(6px);
            border-color: var(--accent-pink);
            background: #1a0b24;
        }

        .guide-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(224, 67, 133, 0.15);
            color: var(--accent-pink);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .guide-info {
            flex: 1;
        }

        .guide-info h4 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .guide-info p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .guide-item .arrow {
            color: var(--text-secondary);
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .guide-item:hover .arrow {
            color: var(--accent-pink);
            transform: translateX(4px);
        }

        /* Story card theme */
        .story-card {
            border-radius: 16px;
            padding: 30px;
            transition: transform 0.3s ease;
        }

        .story-card:hover {
            transform: translateY(-4px);
        }

        .purple-theme {
            background: linear-gradient(135deg, #2b0e38, #180621);
            border: 1px solid rgba(164, 53, 138, 0.4);
        }

        .teal-theme {
            background: linear-gradient(135deg, #0d2c33, #06181c);
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .story-badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--accent-pink);
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .story-card h3 {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .story-card p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Trial CTA */
        .trial-cta-box {
            background: linear-gradient(135deg, #1f082b, #11031a);
            border: 1px solid var(--accent-pink);
            border-radius: 24px;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 20px 40px rgba(224, 67, 133, 0.2);
        }

        .trial-cta-box h2 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .trial-cta-box p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            max-width: 460px;
        }

        .cta-btns {
            display: flex;
            gap: 14px;
        }

        .btn-trial-pink {
            background: var(--button-gradient);
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-trial-pink:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(224, 67, 133, 0.4);
        }

        .btn-trial-outline {
            background: transparent;
            color: #fff;
            border: 1px solid var(--border-dark);
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-trial-outline:hover {
            border-color: #fff;
        }

        .cta-dots-graphic {
            display: flex;
            gap: 8px;
        }

        .c-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--accent-pink);
            opacity: 0.6;
        }

        .c-dot:nth-child(2) { background: #a4358a; }
        .c-dot:nth-child(3) { background: #e04385; }
        .c-dot:nth-child(4) { background: #3b82f6; }
        .c-dot:nth-child(5) { background: #10b981; }


        /* Micro-Animations & Glow Effects for Interactive Components */
        .tool-card, .showcase-item, .cat-card, .why-card, .t-card {
            transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .tool-card:hover, .cat-card:hover, .t-card:hover {
            transform: translateY(-6px) scale(1.015);
            box-shadow: 0 16px 36px rgba(224, 67, 133, 0.2);
        }

        .visual-dial i {
            animation: spinRecord 12s linear infinite;
        }

        @keyframes spinRecord {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }


        /* Footer Styling */
        footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 80px 0 40px;
            background: #070309;
            position: relative;
            z-index: 1;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-col h5 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .footer-col ul a:hover {
            color: #fff;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 30px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* 3-Column Article Layout */
        .article-layout-3col {
            display: grid;
            grid-template-columns: 180px 1fr 280px;
            gap: 36px;
            align-items: start;
        }

        .article-toc-sidebar, .article-right-sidebar {
            position: sticky;
            top: 90px;
        }

        /* Abstract Glow Covers & Visual Artwork */
        .abstract-cover-bg {
            height: 380px;
            border-radius: 24px;
            background: radial-gradient(circle at 80% 30%, rgba(240, 72, 141, 0.45) 0%, rgba(164, 53, 138, 0.25) 45%, #0e0513 85%);
            border: 1px solid rgba(224, 67, 133, 0.3);
            position: relative;
            overflow: hidden;
            margin: 30px 0 50px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
        }

        .cover-glowing-shapes {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .g-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(2px);
        }

        .circle-1 {
            width: 180px;
            height: 180px;
            top: 20%;
            left: 25%;
            background: radial-gradient(circle, #e04385 0%, rgba(224, 67, 133, 0.2) 70%, transparent 100%);
            opacity: 0.7;
        }

        .circle-2 {
            width: 260px;
            height: 260px;
            bottom: -40px;
            right: 15%;
            background: radial-gradient(circle, #f97316 0%, rgba(249, 115, 22, 0.3) 60%, transparent 100%);
            opacity: 0.6;
        }

        .g-square {
            position: absolute;
            width: 80px;
            height: 80px;
            bottom: 30%;
            right: 28%;
            background: linear-gradient(135deg, #e04385, #f59e0b);
            border-radius: 20px;
            transform: rotate(15deg);
            box-shadow: 0 10px 30px rgba(224, 67, 133, 0.6);
        }

        .abstract-concept-bg {
            height: 220px;
            border-radius: 18px;
            background: radial-gradient(circle at 60% 50%, rgba(224, 67, 133, 0.3) 0%, #120518 80%);
            border: 1px solid rgba(224, 67, 133, 0.25);
            position: relative;
            overflow: hidden;
            margin: 25px 0 8px;
        }

        .concept-shapes .c-square {
            position: absolute;
            width: 50px;
            height: 50px;
            top: 35%;
            left: 30%;
            background: linear-gradient(135deg, #e04385, #f59e0b);
            border-radius: 14px;
            transform: rotate(12deg);
        }

        .concept-shapes .c-circle {
            position: absolute;
            width: 120px;
            height: 120px;
            bottom: -20px;
            right: 25%;
            background: radial-gradient(circle, rgba(164, 53, 138, 0.6) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Abstract Thumbnail Art Gradients */
        .abstract-featured-bg {
            background: radial-gradient(circle at 70% 30%, rgba(224, 67, 133, 0.5) 0%, #15061c 80%);
            position: relative;
            overflow: hidden;
        }

        .abstract-circles-graphic .glow-orb {
            position: absolute;
            border-radius: 50%;
        }

        .orb-1 { width: 140px; height: 140px; top: 10%; left: 15%; background: radial-gradient(circle, rgba(224, 67, 133, 0.6) 0%, transparent 70%); }
        .orb-2 { width: 180px; height: 180px; bottom: 0; right: 10%; background: radial-gradient(circle, rgba(249, 115, 22, 0.5) 0%, transparent 70%); }
        .orb-3 { width: 45px; height: 45px; bottom: 25%; right: 35%; background: #e04385; border-radius: 12px; transform: rotate(15deg); }

        .abstract-thumb-purple {
            background: radial-gradient(circle at 50% 50%, rgba(164, 53, 138, 0.5) 0%, #15061c 80%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .abstract-thumb-rose {
            background: radial-gradient(circle at 50% 50%, rgba(224, 67, 133, 0.5) 0%, #15061c 80%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .abstract-thumb-teal {
            background: radial-gradient(circle at 50% 50%, rgba(20, 184, 166, 0.45) 0%, #06181c 80%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .abstract-thumb-green {
            background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.45) 0%, #061710 80%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .abstract-graphic-box {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box-shape {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
        }

        .shape-square {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #e04385, #9333ea);
        }

        .shape-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f97316;
            margin-left: -12px;
            margin-top: 15px;
        }

        .shape-window {
            width: 64px;
            height: 48px;
            border-radius: 8px;
            border: 2px solid rgba(224, 67, 133, 0.8);
            background: rgba(224, 67, 133, 0.2);
        }

        .shape-ring {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 4px solid #14b8a6;
            background: transparent;
        }

        .shape-wave {
            width: 60px;
            height: 30px;
            border-radius: 30px 30px 0 0;
            background: linear-gradient(to top, #10b981, #f59e0b);
        }

        /* Checklist & Numbered list */
        .article-checklist {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 20px 0 30px;
        }

        .article-checklist li {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            font-size: 15px;
            color: #d1d5db;
        }

        .article-checklist li i {
            color: var(--accent-pink);
            font-size: 18px;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .article-checklist li strong {
            color: #fff;
        }

        /* Trending Reads Box */
        .trending-reads-box {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 20px;
            margin-top: 20px;
        }

        .trending-reads-box h5 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 14px;
        }

        .trending-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .trending-item:last-child {
            border-bottom: none;
        }

        .trend-num {
            font-size: 16px;
            font-weight: 800;
            color: var(--accent-pink);
        }

        .trending-item h6 {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 2px;
            line-height: 1.35;
        }

        .trending-item span {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* News & PR List */
        .news-list-box {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 10px 24px;
            margin-bottom: 50px;
        }

        .news-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px solid var(--border-dark);
            gap: 20px;
        }

        .news-row:last-child {
            border-bottom: none;
        }

        .news-date {
            font-size: 12px;
            color: var(--text-secondary);
            width: 100px;
            flex-shrink: 0;
        }

        .news-content {
            flex: 1;
        }

        .news-content h4 {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .news-content p {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.4;
        }

        .news-badge {
            background: rgba(224, 67, 133, 0.12);
            color: var(--accent-pink);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        /* Research & Data Section */
        .research-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 24px;
            margin-bottom: 50px;
        }

        .research-highlight-card {
            background: linear-gradient(135deg, #1f0b29, #100416);
            border: 1px solid rgba(224, 67, 133, 0.35);
            border-radius: 20px;
            padding: 30px;
        }

        .research-highlight-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
        }

        .research-highlight-card p {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .research-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            border-top: 1px solid var(--border-dark);
            padding-top: 20px;
        }

        .r-stat strong {
            display: block;
            font-size: 26px;
            font-weight: 800;
            color: var(--accent-pink);
        }

        .r-stat span {
            font-size: 11px;
            color: var(--text-secondary);
        }

        .research-side-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .research-side-item {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 16px 20px;
            transition: all 0.25s ease;
        }

        .research-side-item:hover {
            border-color: var(--accent-pink);
            transform: translateX(4px);
        }

        .r-tag {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--accent-pink);
            display: block;
            margin-bottom: 4px;
        }

        .research-side-item h4 {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
            line-height: 1.35;
        }

        .research-side-item p {
            font-size: 11px;
            color: var(--text-secondary);
            margin: 0;
        }

        /* Color themes for Founder Stories */
        .orange-theme {
            background: linear-gradient(135deg, #331505, #190902);
            border: 1px solid rgba(249, 115, 22, 0.4);
        }

        .blue-theme {
            background: linear-gradient(135deg, #091a38, #040c1c);
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        /* Icons colored backgrounds */
        .icon-cyan-bg { background: rgba(6, 182, 212, 0.15); color: #06b6d4; }
        .icon-purple-bg { background: rgba(168, 85, 247, 0.15); color: #a855f7; }
        .icon-orange-bg { background: rgba(249, 115, 22, 0.15); color: #f97316; }
        .icon-pink-bg { background: rgba(236, 72, 153, 0.15); color: #ec4899; }
        .icon-blue-bg { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }

        /* ROI Calculator Widget */
        .roi-calculator-card {
            background: linear-gradient(145deg, #180821, #0d0312);
            border-color: rgba(224, 67, 133, 0.35);
        }

        .roi-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .roi-badge {
            background: var(--button-gradient);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .roi-widget-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
            align-items: center;
        }

        .roi-slider-group {
            margin-bottom: 18px;
        }

        .roi-slider-group label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .roi-slider-group label strong {
            color: #fff;
        }

        .roi-slider {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.1);
            outline: none;
            -webkit-appearance: none;
        }

        .roi-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--accent-pink);
            cursor: pointer;
            box-shadow: 0 0 10px rgba(224, 67, 133, 0.8);
        }

        .roi-outputs {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }

        .roi-output-box span {
            font-size: 12px;
            color: var(--text-secondary);
            display: block;
            margin-bottom: 4px;
        }

        .roi-output-box h2 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .roi-sub-stats {
            display: flex;
            justify-content: space-around;
            border-top: 1px solid var(--border-dark);
            padding-top: 14px;
        }

        .roi-sub-stats strong {
            display: block;
            font-size: 16px;
            color: #10b981;
        }

        .roi-sub-stats span {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* Capability Checklist */
        .capabilities-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 16px;
        }

        .capability-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 18px;
            display: flex;
            gap: 14px;
        }

        .cap-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(224, 67, 133, 0.15);
            color: var(--accent-pink);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .capability-item h4 {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .capability-item p {
            font-size: 12px;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.4;
        }

        /* Integrations Full Grid */
        .integrations-grid-full {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin-top: 20px;
        }

        .int-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 16px 8px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #fff;
            transition: all 0.2s ease;
        }

        .int-box:hover {
            border-color: var(--accent-pink);
            transform: translateY(-2px);
        }

        .int-box i {
            font-size: 24px;
        }

        /* Benchmarks Grid */
        .benchmarks-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 16px;
        }

        .benchmark-item {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 13px;
        }

        .bm-label {
            width: 180px;
            color: #fff;
            font-weight: 600;
            flex-shrink: 0;
        }

        .bm-bar-wrap {
            flex: 1;
            height: 10px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 5px;
            overflow: hidden;
        }

        .bm-bar {
            height: 100%;
            background: var(--button-gradient);
            border-radius: 5px;
        }

        .bar-green { background: linear-gradient(90deg, #10b981, #34d399); }
        .bar-purple { background: linear-gradient(90deg, #a855f7, #c084fc); }

        .bm-val {
            width: 180px;
            text-align: right;
            color: #fff;
            font-weight: 700;
            flex-shrink: 0;
        }

        .bm-val small {
            font-weight: 400;
            color: var(--text-secondary);
            font-size: 11px;
        }

        /* Reviews Score Breakdown */
        .reviews-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .reviews-breakdown-box {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 30px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            align-items: center;
        }

        .reviews-summary-score {
            text-align: center;
            border-right: 1px solid var(--border-dark);
            padding-right: 20px;
        }

        .reviews-summary-score h1 {
            font-size: 48px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            margin-bottom: 6px;
        }

        .reviews-summary-score span {
            font-size: 11px;
            color: #10b981;
            display: block;
            margin-top: 6px;
            font-weight: 600;
        }

        .rating-bars-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .rating-bar-row {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .bar-track {
            flex: 1;
            height: 8px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 4px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            background: #f59e0b;
            border-radius: 4px;
        }

        .user-review-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-dark);
            border-radius: 14px;
            padding: 20px;
            margin-top: 16px;
        }

        .review-top-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .user-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-row strong {
            display: block;
            font-size: 13px;
            color: #fff;
        }

        .user-row span {
            font-size: 11px;
            color: var(--text-secondary);
        }

        .review-date {
            font-size: 11px;
            color: var(--text-secondary);
        }

        .review-stars {
            margin-bottom: 8px;
        }

        .review-title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .review-text {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .alt-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .alt-logo {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Vendor Hero Pill Badges */
        .vendor-hero-pill-badges {
            display: flex;
            gap: 8px;
            margin-top: 14px;
            flex-wrap: wrap;
        }

        .v-pill {
            background: rgba(224, 67, 133, 0.12);
            border: 1px solid rgba(224, 67, 133, 0.3);
            color: var(--accent-pink);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }

        @media (max-width: 992px) {
            .article-layout-3col, .roi-widget-grid, .research-grid, .vendor-content-grid {
                grid-template-columns: 1fr;
            }
            .integrations-grid-full, .integrations-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .tools-grid, .why-grid, .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .showcase-grid, .cta-grid, .insights-grid, .faq-wrapper, .testimonial-section {
                grid-template-columns: 1fr;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="bg-wave-pattern"></div>

    <!-- Layout Header -->
    @include('frontend.components.header')

    <!-- Main Dynamic Content Page -->
    <main>
        @yield('content')
    </main>

    <!-- Layout Footer -->
    @include('frontend.components.footer')

    <!-- Mobile / Fullscreen Hamburger Overlay Menu -->
    <div class="overlay-menu" id="hamburgerMenu">
        <button class="overlay-close-btn" onclick="toggleMenu()" aria-label="Close Menu">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="overlay-wave-graphic"></div>
        <div class="overlay-menu-content">
            <a href="#" class="overlay-link">About</a>
            <a href="#" class="overlay-link">Write a review</a>
            <a href="#" class="overlay-link">Legal</a>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('hamburgerMenu');
            menu.classList.toggle('active');
        }

        function toggleFaq(element) {
            element.classList.toggle('active');
        }

        // Scroll Reveal Animation Observer

        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('section, .tool-card, .showcase-card-left, .why-card, .cat-card, .cta-card, .t-card, .featured-insight').forEach(el => {
                el.classList.add('reveal-on-scroll');
                observer.observe(el);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>

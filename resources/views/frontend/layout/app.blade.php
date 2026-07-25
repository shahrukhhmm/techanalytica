<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TechAnalytica - Find AI tools Worth Adopting')</title>
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
            font-size: 34px;
            font-weight: 700;
            letter-spacing: -0.8px;
            margin-bottom: 8px;
        }

        .section-desc {
            color: var(--text-secondary);
            font-size: 14px;
        }

        /* AI Tools Grid */
        .tools-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        .tool-card {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 24px;
            position: relative;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .tool-card:hover {
            transform: translateY(-4px);
            border-color: rgba(224, 67, 133, 0.4);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
        }

        .tool-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(224, 67, 133, 0.15);
            color: var(--accent-pink);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .tool-header {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 16px;
        }

        .tool-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #25162b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--accent-pink);
            flex-shrink: 0;
        }

        .tool-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 4px;
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
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 16px;
            font-size: 13px;
        }

        .pricing-tag {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .btn-visit {
            color: var(--accent-pink);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .load-more-container {
            text-align: center;
            margin: 40px 0 100px;
        }

        .btn-view-all {
            background: rgba(224, 67, 133, 0.12);
            color: var(--accent-pink);
            border: 1px solid rgba(224, 67, 133, 0.3);
            padding: 12px 32px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-view-all:hover {
            background: var(--button-pink);
            color: #fff;
        }

        /* New AI Tool Releases Showcase Section */
        .showcase-section {
            padding: 60px 0 100px;
            background: radial-gradient(circle at 30% 50%, rgba(224, 67, 133, 0.08) 0%, transparent 70%);
        }

        .showcase-banner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--accent-pink);
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .showcase-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            margin-top: 40px;
        }

        .showcase-card-left {
            background: linear-gradient(145deg, #180922, #0d0413);
            border: 1px solid rgba(224, 67, 133, 0.3);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6), inset 0 0 20px rgba(224, 67, 133, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .showcase-card-left:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: var(--accent-pink);
            box-shadow: 0 24px 50px rgba(224, 67, 133, 0.4), inset 0 0 35px rgba(224, 67, 133, 0.25);
        }

        .visual-dial {
            width: 180px;
            height: 180px;
            margin: 30px auto;
            border-radius: 50%;
            background: radial-gradient(circle, #2a1138 0%, #15061c 100%);
            border: 2px solid var(--accent-pink);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 30px rgba(224, 67, 133, 0.4);
            position: relative;
            transition: all 0.3s ease;
        }

        .showcase-card-left:hover .visual-dial {
            transform: scale(1.1);
            box-shadow: 0 0 50px rgba(224, 67, 133, 0.8), 0 0 20px rgba(255, 255, 255, 0.4);
            border-color: #ff7bb3;
        }

        .visual-dial i {
            font-size: 64px;
            color: var(--accent-pink);
            transition: color 0.3s ease;
        }

        .showcase-card-left:hover .visual-dial i {
            color: #ffffff;
            animation: spinRecordFast 3s linear infinite;
        }

        @keyframes spinRecordFast {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .showcase-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .showcase-item {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            padding: 20px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .showcase-item:hover {
            transform: translateX(10px) scale(1.02);
            background: linear-gradient(135deg, #1f1028 0%, #15081d 100%);
            border-color: var(--accent-pink);
            box-shadow: 0 10px 30px rgba(224, 67, 133, 0.3);
        }

        .showcase-item-icon {
            width: 44px;
            height: 44px;
            background: rgba(224, 67, 133, 0.15);
            color: var(--accent-pink);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .showcase-item:hover .showcase-item-icon {
            background: var(--button-pink);
            color: #ffffff;
            transform: scale(1.15) rotate(6deg);
            box-shadow: 0 4px 15px rgba(224, 67, 133, 0.5);
        }


        .showcase-item-icon {
            width: 42px;
            height: 42px;
            background: rgba(224, 67, 133, 0.15);
            color: var(--accent-pink);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Light Section: Why TechAnalytica? */
        .why-section {
            background: #ffffff;
            color: #1a1a1a;
            padding: 90px 0;
            text-align: center;
        }

        .why-section .section-title {
            color: #111;
        }

        .why-section .section-desc {
            color: #666;
            margin-bottom: 60px;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .why-card {
            padding: 20px;
        }

        .why-icon {
            width: 60px;
            height: 60px;
            background: #fdebf2;
            color: var(--accent-pink);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 20px;
        }

        .why-card h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .why-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }

        /* Browse Categories Section */
        .categories-section {
            padding: 100px 0;
            background: var(--bg-dark);
        }

        .category-pills {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-secondary);
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pill.active, .pill:hover {
            background: var(--button-pink);
            color: #fff;
            border-color: var(--button-pink);
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .cat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 16px;
            padding: 24px;
            transition: 0.2s;
        }

        .cat-card:hover {
            border-color: var(--accent-pink);
            transform: translateY(-3px);
        }

        .cat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            margin-bottom: 16px;
        }

        .cat-card h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .cat-card p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* Dual CTA Banners Section */
        .cta-section {
            padding: 60px 0 100px;
        }

        .cta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .cta-card {
            background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);
            color: #2c0e21;
            border-radius: 20px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .cta-card h3 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .cta-card p {
            font-size: 14px;
            color: #5c2045;
            margin-bottom: 24px;
            max-width: 80%;
        }

        .cta-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-cta-pink {
            background: var(--button-pink);
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;

            border: none;
            cursor: pointer;
        }

        .btn-cta-outline {
            background: transparent;
            border: 1px solid #5c2045;
            color: #5c2045;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
        }

        /* Community Testimonial Cards Section */
        .testimonial-section {
            padding: 80px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .testimonial-text {
            max-width: 450px;
        }

        .testimonial-text h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .btn-submit-ai {
            background: var(--button-pink);
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-submit-ai:hover {
            background: #c22f6d;
            transform: translateY(-1px);
        }

        .testimonial-cards {
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 460px;
        }

        .t-card {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .t-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #3d2348;
            object-fit: cover;
        }

        .t-info h5 {
            font-size: 14px;
            font-weight: 700;
        }

        .t-info p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .t-stars {
            margin-left: auto;
            color: #ffb400;
            font-size: 12px;
        }

        /* Light Insights Section */
        .insights-section {
            background: #ffffff;
            color: #111;
            padding: 90px 0;
        }

        .insights-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 40px;
        }

        .featured-insight {
            background: #0d0413;
            color: #fff;
            border-radius: 20px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            min-height: 380px;
            position: relative;
            background-image: radial-gradient(circle at 80% 20%, rgba(224, 67, 133, 0.4) 0%, transparent 60%);
        }

        .featured-insight h3 {
            font-size: 28px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .insight-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .insight-item {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .insight-img {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background: #eee;
            object-fit: cover;
            flex-shrink: 0;
        }

        .insight-content h4 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #111;
        }

        .insight-content p {
            font-size: 12px;
            color: #666;
        }

        /* FAQ Section */
        .faq-section {
            padding: 40px 0 80px;
            background: transparent;
        }


        .faq-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 60px;
        }

        .faq-accordion {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* FAQ Section & Smooth Accordion Animation */
        .faq-item {
            background: var(--bg-card);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            padding: 20px 24px;
            cursor: pointer;
            transition: border-color 0.3s ease, background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .faq-item:hover {
            border-color: rgba(224, 67, 133, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .faq-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-item h5 {
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
        }

        .faq-icon {
            color: var(--accent-pink);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, margin-top 0.3s ease;
            opacity: 0;
            margin-top: 0;
        }

        .faq-answer p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .faq-item.active {
            border-color: var(--accent-pink);
            background: #1c1024;
            box-shadow: 0 0 20px rgba(224, 67, 133, 0.25);
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
            opacity: 1;
            margin-top: 14px;
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

        @media (max-width: 992px) {
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

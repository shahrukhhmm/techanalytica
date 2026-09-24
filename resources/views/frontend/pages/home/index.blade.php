@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Find AI tools Worth Adopting')

@push('styles')
    <style>
        /* =============================================
           HOMEPAGE — FIGMA ACCURATE DUAL-THEME LAYOUT
           ============================================= */

        /* 1. HERO SECTION */
        .hero-section {
            padding: 56px 0 40px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: clamp(36px, 5vw, 56px);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -0.03em;
            color: #ffffff;
            margin-bottom: 16px;
        }

        .hero-title .gradient-text {
            background: linear-gradient(90deg, #ff3b7b 0%, #ff735c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline;
        }

        .hero-subtitle {
            font-size: 17px;
            color: var(--text-secondary);
            max-width: 580px;
            margin: 0 auto 32px;
            line-height: 1.6;
        }

        .search-box-wrapper {
            display: flex;
            align-items: center;
            max-width: 580px;
            margin: 0 auto 48px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 9999px;
            padding: 6px 8px 6px 24px;
            transition: all 0.25s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .search-box-wrapper:focus-within {
            border-color: rgba(255, 59, 123, 0.5);
            box-shadow: 0 0 25px rgba(255, 59, 123, 0.25);
        }

        .search-box-wrapper i {
            color: #ff3b7b;
            font-size: 16px;
            margin-right: 12px;
        }

        .search-input {
            flex: 1;
            background: transparent;
            border: none;
            color: #fff;
            font-size: 15px;
            font-family: inherit;
            outline: none;
        }

        .search-input::placeholder {
            color: #7b7086;
        }

        .btn-search {
            background: linear-gradient(90deg, #ff3b7b, #ff735c);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: filter 0.2s, transform 0.2s;
            box-shadow: 0 4px 16px rgba(255, 59, 123, 0.35);
        }

        .btn-search:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        /* Sponsors Ticker */
        .sponsors-bar-wrapper {
            overflow: hidden;
            position: relative;
            padding: 20px 0;
            mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }

        .sponsors-bar-track {
            display: flex;
            align-items: center;
            gap: 48px;
            animation: ticker 28s linear infinite;
            width: max-content;
        }

        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .sponsor-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.45);
            white-space: nowrap;
            transition: color 0.2s;
        }

        .sponsor-item i {
            font-size: 18px;
        }

        .sponsor-item:hover {
            color: rgba(255, 255, 255, 0.85);
        }

        /* Common Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .section-title {
            font-size: clamp(28px, 3.4vw, 42px);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 10px;
        }

        .section-desc {
            font-size: 15px;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* 2. THE AI TOOLS MAKING REAL NOISE (Figma Aligned) */
        .noise-tools-section {
            padding-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .noise-tools-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 24px;
            margin-bottom: 24px;
        }

        .noise-tool-card {
            background: #14161b;
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 14px;
            padding: 26px 24px 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 200px;
            transition: all 0.25s ease;
        }

        .noise-tool-card:hover {
            border-color: rgba(255, 67, 130, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.6);
        }

        .noise-floating-badge {
            position: absolute;
            top: -11px;
            right: 24px;
            background: linear-gradient(90deg, #ff4382, #ff708a);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 9999px;
            box-shadow: 0 4px 12px rgba(255, 67, 130, 0.35);
            letter-spacing: 0.02em;
            z-index: 2;
        }

        .noise-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .noise-card-title {
            font-size: 17.5px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            line-height: 1.3;
        }

        .noise-card-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .noise-card-title a:hover {
            color: #ff4382;
        }

        .noise-card-logo {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .noise-card-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .noise-card-desc {
            font-size: 13.5px;
            color: #9ca3af;
            line-height: 1.55;
            margin: 12px 0 22px;
            min-height: 42px;
        }

        .noise-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .noise-rating {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: #a099a8;
        }

        .noise-rating i {
            color: #ff4382;
            font-size: 12px;
        }

        .noise-pricing {
            font-size: 13px;
            font-weight: 600;
            color: #ff5083;
        }

        .noise-view-all-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .btn-figma-pink {
            background: linear-gradient(90deg, #ff4382, #ff708a);
            color: #ffffff !important;
            border: none;
            padding: 10px 26px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: filter 0.2s, transform 0.2s;
            box-shadow: 0 4px 14px rgba(255, 67, 130, 0.35);
        }

        .btn-figma-pink:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        /* 3. NEW AI TOOL RELEASES (Exact Figma Layout) */
        .new-releases-section {
            padding: 50px 0 80px;
            position: relative;
            z-index: 2;
        }

        .new-releases-header {
            text-align: center;
            margin-bottom: 46px;
        }

        .new-releases-title-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .new-releases-title-row h2 {
            font-size: clamp(30px, 4vw, 44px);
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .new-releases-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .new-releases-visual-card {
            border-radius: 24px;
            overflow: hidden;
            background: #0d1017;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            position: relative;
        }

        .new-releases-visual-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
            display: block;
        }

        .new-releases-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .new-release-item {
            background: transparent;
            border: 1px solid transparent;
            border-radius: 14px;
            padding: 16px 20px;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .new-release-item:hover,
        .new-release-item.active {
            background: rgba(22, 24, 30, 0.9);
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .new-release-item-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .new-release-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .new-release-title-group i {
            color: #ff4382;
            font-size: 18px;
        }

        .new-release-title-group h4 {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }

        .new-badge-outline {
            border: 1px solid #ff4382;
            color: #ff708a;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 9999px;
        }

        .new-release-desc {
            font-size: 13.5px;
            color: #9ca3af;
            line-height: 1.5;
            margin: 8px 0 10px;
        }

        .new-release-meta {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .new-release-tag {
            background: linear-gradient(90deg, #ff4382, #d63384);
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 6px;
        }

        .new-release-date {
            font-size: 12px;
            color: #9ca3af;
        }

        .new-releases-action-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }

        /* 4. LIGHT SECTION: WHY TECHANALYTICA? */
        .why-section {
            background: #ffffff;
            padding: 85px 0 95px;
            position: relative;
            z-index: 10;
            margin-top: 30px;
        }

        .why-section .section-title {
            color: #0e0614;
            font-size: clamp(28px, 3.5vw, 42px);
            font-weight: 800;
            text-align: center;
            margin-bottom: 12px;
        }

        .why-section .section-desc {
            color: #6b7280;
            font-size: 15.5px;
            text-align: center;
            max-width: 600px;
            margin: 0 auto 56px;
            line-height: 1.6;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
        }

        .why-card {
            text-align: center;
        }

        .why-icon {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff3b7b, #ff735c);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 24px;
            margin: 0 auto 20px;
            box-shadow: 0 10px 24px rgba(255, 59, 123, 0.3);
            transition: transform 0.25s ease;
        }

        .why-card:hover .why-icon {
            transform: scale(1.08);
        }

        .why-card h4 {
            font-size: 18px;
            font-weight: 700;
            color: #0e0614;
            margin-bottom: 8px;
        }

        .why-card p {
            font-size: 13.5px;
            color: #6b7280;
            line-height: 1.6;
        }

        /* 5. BROWSE OUR AI CATEGORIES */
        .categories-section {
            padding: 85px 0 60px;
            position: relative;
            z-index: 2;
        }

        .category-pills {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            max-width: 900px;
            margin: 0 auto 44px;
        }

        .category-pill {
            padding: 8px 18px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .category-pill:hover {
            color: #ffffff;
            border-color: rgba(255, 59, 123, 0.4);
            background: rgba(255, 255, 255, 0.08);
        }

        .category-pill.active {
            background: linear-gradient(90deg, #ff3b7b, #ff735c);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 4px 16px rgba(255, 59, 123, 0.35);
        }

        .category-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 36px;
        }

        .cat-card {
            background: rgba(20, 10, 26, 0.88);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 24px;
            text-decoration: none;
            display: block;
            transition: all 0.25s ease;
        }

        .cat-card:hover {
            border-color: rgba(255, 59, 123, 0.35);
            transform: translateY(-3px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5);
        }

        .cat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ffffff;
            margin-bottom: 16px;
        }

        .cat-card h4 {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .cat-card p {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
        }

        /* 6. DUAL CTA BANNERS */
        .cta-section {
            padding: 30px 0 60px;
            position: relative;
            z-index: 2;
        }

        .cta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .cta-banner-card {
            background: linear-gradient(135deg, #fff0f5 0%, #fde2ea 100%);
            border: 1px solid rgba(255, 59, 123, 0.2);
            border-radius: 20px;
            padding: 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 220px;
            transition: all 0.25s ease;
        }

        .cta-banner-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.25);
        }

        .cta-mini-badge {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 59, 123, 0.15);
            color: #ff3b7b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 18px;
        }

        .cta-banner-card h3 {
            font-size: 23px;
            font-weight: 800;
            color: #1a0f24;
            margin-bottom: 10px;
            line-height: 1.25;
        }

        .cta-banner-card p {
            font-size: 14px;
            color: #6b5c72;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .cta-btn-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-cta-pink {
            background: linear-gradient(90deg, #ff3b7b, #ff735c);
            color: #ffffff !important;
            border: none;
            padding: 11px 22px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: filter 0.2s, transform 0.2s;
            box-shadow: 0 4px 14px rgba(255, 59, 123, 0.35);
        }

        .btn-cta-pink:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .btn-cta-dark {
            background: #1a0f24;
            color: #ffffff !important;
            border: none;
            padding: 11px 22px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s, transform 0.2s;
        }

        .btn-cta-dark:hover {
            background: #2b173c;
            transform: translateY(-1px);
        }

        /* 7. COMMUNITY TESTIMONIALS */
        .testimonial-section {
            padding: 60px 0 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 48px;
            position: relative;
            z-index: 2;
        }

        .testimonial-text {
            flex: 1;
            max-width: 480px;
        }

        .testimonial-text h2 {
            font-size: clamp(28px, 3.2vw, 38px);
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .testimonial-cards {
            flex: 1;
            max-width: 520px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .t-card-white {
            background: #ffffff;
            border-radius: 16px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .t-card-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
        }

        .t-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            flex-shrink: 0;
            object-fit: cover;
        }

        .t-info {
            flex: 1;
        }

        .t-info h5 {
            font-size: 15.5px;
            font-weight: 700;
            color: #0e0614;
            margin: 0 0 2px;
        }

        .t-info p {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
        }

        .t-stars {
            color: #ffb703;
            font-size: 14px;
            letter-spacing: 2px;
            flex-shrink: 0;
        }

        /* 8. LIGHT SECTION: AI INSIGHTS WORTH READING */
        .insights-section {
            background: #ffffff;
            padding: 85px 0 95px;
            position: relative;
            z-index: 10;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .insights-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 20px;
            flex-wrap: wrap;
        }

        .insights-header h2 {
            font-size: clamp(28px, 3.4vw, 40px);
            font-weight: 800;
            color: #0e0614;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .insights-search-wrapper {
            display: flex;
            align-items: center;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 9999px;
            padding: 4px 6px 4px 18px;
            width: 320px;
        }

        .insights-search-wrapper input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            font-size: 13.5px;
            color: #1f2937;
            font-family: inherit;
        }

        .insights-search-wrapper button {
            background: linear-gradient(90deg, #ff3b7b, #ff735c);
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 12.5px;
            cursor: pointer;
            transition: filter 0.2s;
        }

        .insights-search-wrapper button:hover {
            filter: brightness(1.1);
        }

        .insights-grid {
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 36px;
        }

        .featured-insight-card {
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }

        .featured-insight-banner {
            background: #0b020e;
            border-radius: 18px;
            padding: 44px 32px;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.25s ease;
        }

        .featured-insight-card:hover .featured-insight-banner {
            transform: translateY(-2px);
        }

        .featured-insight-banner h3 {
            font-size: clamp(22px, 2.5vw, 30px);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.25;
            max-width: 380px;
            position: relative;
            z-index: 1;
        }

        .squiggle-wave {
            position: absolute;
            bottom: 20px;
            right: 24px;
            width: 140px;
            height: 80px;
            opacity: 0.9;
        }

        .featured-insight-tag {
            font-size: 11px;
            font-weight: 800;
            color: #ff3b7b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
            display: block;
        }

        .featured-insight-card h4 {
            font-size: 20px;
            font-weight: 800;
            color: #0e0614;
            line-height: 1.35;
            margin-bottom: 8px;
        }

        .featured-insight-card p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .featured-insight-link {
            color: #ff3b7b;
            font-weight: 700;
            font-size: 13.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .insight-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .insight-item-light {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 12px;
            border-radius: 14px;
            text-decoration: none;
            color: inherit;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .insight-item-light:hover {
            background: #f9fafb;
            transform: translateX(4px);
        }

        .insight-thumb {
            width: 88px;
            height: 88px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .insight-content-light h5 {
            font-size: 15.5px;
            font-weight: 700;
            color: #0e0614;
            line-height: 1.35;
            margin: 4px 0 6px;
        }

        .insight-tag-light {
            font-size: 11px;
            font-weight: 700;
            color: #ff3b7b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .insight-meta-light {
            font-size: 12px;
            color: #9ca3af;
            margin: 0;
        }

        /* 9. FREQUENTLY ASKED QUESTIONS */
        .faq-section {
            padding: 80px 0 100px;
            position: relative;
            z-index: 2;
        }

        .faq-wrapper {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 48px;
        }

        .faq-badge {
            color: #ff3b7b;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: block;
            margin-bottom: 10px;
        }

        .faq-item {
            background: rgba(20, 10, 26, 0.88);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 14px;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }

        .faq-item:hover {
            border-color: rgba(255, 59, 123, 0.35);
        }

        .faq-item.active {
            border-color: rgba(255, 59, 123, 0.4);
            background: rgba(28, 14, 36, 0.95);
        }

        .faq-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .faq-header h5 {
            font-size: 15.5px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }

        .faq-icon {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            transition: transform 0.25s ease, color 0.25s ease;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
            color: #ff3b7b;
        }

        .faq-answer {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.65;
            margin-top: 14px;
            display: none;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding-top: 14px;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .noise-tools-grid { grid-template-columns: repeat(2, 1fr); }
            .new-releases-grid { grid-template-columns: 1fr; }
            .why-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
            .category-cards-grid { grid-template-columns: repeat(2, 1fr); }
            .insights-grid { grid-template-columns: 1fr; }
            .faq-wrapper { grid-template-columns: 1fr; gap: 32px; }
        }

        @media (max-width: 860px) {
            .cta-grid { grid-template-columns: 1fr; }
            .testimonial-section { flex-direction: column; align-items: flex-start; gap: 32px; }
            .testimonial-text, .testimonial-cards { max-width: 100%; width: 100%; }
        }

        @media (max-width: 640px) {
            .noise-tools-grid { grid-template-columns: 1fr; }
            .why-grid { grid-template-columns: 1fr; }
            .category-cards-grid { grid-template-columns: 1fr; }
            .insights-search-wrapper { width: 100%; }
        }
    </style>
@endpush

@section('content')

    <!-- 1. HERO SECTION -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">
                Find AI tools <span class="gradient-text">Worth Adopting</span>
            </h1>
            <p class="hero-subtitle">
                Discover real products, real reviews, & honest AI insights.
            </p>

            <form action="{{ route('frontend.tools.index') }}" method="GET" class="search-box-wrapper"
                onsubmit="if(!this.search.value.trim()){ return false; }">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input"
                    placeholder="Search for AI tools, categories or features..." required>
                <button type="submit" class="btn-search">Search</button>
            </form>

            <!-- Sponsors Ticker -->
            <div class="sponsors-bar-wrapper">
                <div class="sponsors-bar-track">
                    <div class="sponsor-item"><i class="fa-brands fa-figma"></i> Figma</div>
                    <div class="sponsor-item"><i class="fa-brands fa-slack"></i> Slack</div>
                    <div class="sponsor-item"><i class="fa-brands fa-github"></i> GitHub</div>
                    <div class="sponsor-item"><i class="fa-brands fa-intercom"></i> Intercom</div>
                    <div class="sponsor-item"><i class="fa-brands fa-stripe"></i> Stripe</div>
                    <div class="sponsor-item"><i class="fa-brands fa-spotify"></i> Spotify</div>
                    <div class="sponsor-item"><i class="fa-brands fa-aws"></i> AWS</div>
                    <div class="sponsor-item"><i class="fa-brands fa-google"></i> Google Cloud</div>

                    <!-- Duplicated Set for Seamless Loop -->
                    <div class="sponsor-item"><i class="fa-brands fa-figma"></i> Figma</div>
                    <div class="sponsor-item"><i class="fa-brands fa-slack"></i> Slack</div>
                    <div class="sponsor-item"><i class="fa-brands fa-github"></i> GitHub</div>
                    <div class="sponsor-item"><i class="fa-brands fa-intercom"></i> Intercom</div>
                    <div class="sponsor-item"><i class="fa-brands fa-stripe"></i> Stripe</div>
                    <div class="sponsor-item"><i class="fa-brands fa-spotify"></i> Spotify</div>
                    <div class="sponsor-item"><i class="fa-brands fa-aws"></i> AWS</div>
                    <div class="sponsor-item"><i class="fa-brands fa-google"></i> Google Cloud</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. THE AI TOOLS MAKING REAL NOISE (Exact Figma Card Layout) -->
    <section class="container noise-tools-section">
        <div class="section-header">
            <h2 class="section-title">The AI Tools Making Real Noise</h2>
            <p class="section-desc">Verified and trusted AI software for businesses at every stage.</p>
        </div>

        @php
            $cardBadges = [
                0 => 'Most Popular',
                1 => 'Editor Choice',
                2 => 'Enterprise Ready',
            ];
            $brandLogos = [
                0 => ['type' => 'icon', 'class' => 'fa-brands fa-adobe', 'color' => '#fa0f00'],
                1 => ['type' => 'svg', 'html' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M4 14l8-8 8 8-8 4-8-4z" fill="#00c0f3"/></svg>'],
                2 => ['type' => 'icon', 'class' => 'fa-brands fa-gitlab', 'color' => '#fc6d26'],
                3 => ['type' => 'icon', 'class' => 'fa-brands fa-atlassian', 'color' => '#0052cc'],
                4 => ['type' => 'svg', 'html' => '<svg width="26" height="26" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#f97316"/><circle cx="12" cy="12" r="5.5" fill="#10b981"/><circle cx="12" cy="12" r="2.5" fill="#ffffff"/></svg>'],
                5 => ['type' => 'icon', 'class' => 'fa-brands fa-github', 'color' => '#ffffff'],
            ];
        @endphp

        <div class="noise-tools-grid">
            @forelse($tools as $index => $tool)
                @php
                    $badgeText = $cardBadges[$index] ?? ($tool->is_featured ? 'Featured' : ($tool->is_verified ? 'Verified' : null));
                    $logoData = $brandLogos[$index % 6];
                @endphp
                <div class="noise-tool-card">
                    @if ($badgeText)
                        <span class="noise-floating-badge">{{ $badgeText }}</span>
                    @endif

                    <div>
                        <div class="noise-card-header">
                            <h3 class="noise-card-title">
                                <a href="{{ route('frontend.tools.show', $tool->slug) }}">{{ $tool->name }}</a>
                            </h3>
                            <div class="noise-card-logo">
                                @if ($tool->logo_url && file_exists(public_path($tool->logo_url)))
                                    <img src="{{ asset($tool->logo_url) }}" alt="{{ $tool->name }}">
                                @elseif ($logoData['type'] === 'icon')
                                    <i class="{{ $logoData['class'] }}" style="color: {{ $logoData['color'] }}; font-size: 26px;"></i>
                                @else
                                    {!! $logoData['html'] !!}
                                @endif
                            </div>
                        </div>

                        <p class="noise-card-desc">
                            {{ Str::limit($tool->short_description ?? 'Generate high-quality content with advanced AI technology.', 95) }}
                        </p>
                    </div>

                    <div class="noise-card-footer">
                        <span class="noise-rating">
                            <i class="fa-solid fa-star"></i>
                            ({{ $tool->reviews_count > 0 ? $tool->reviews_count : '1240' }} reviews)
                        </span>
                        <span class="noise-pricing">
                            {{ $tool->pricing_text ?? ($tool->tier->name ?? 'From $29/mo') }}
                        </span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary); padding: 40px; background: rgba(20,10,26,0.85); border-radius: 20px;">
                    <h3>No AI tools found matching your criteria.</h3>
                </div>
            @endforelse
        </div>

        <div class="noise-view-all-wrapper">
            <a href="{{ route('frontend.tools.index') }}" class="btn-figma-pink">View All</a>
        </div>
    </section>

    <!-- 3. NEW AI TOOL RELEASES (Exact Figma Layout) -->
    <section class="new-releases-section">
        <div class="container">
            <div class="new-releases-header">
                <div class="new-releases-title-row">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" stroke="#ff4382" stroke-width="2.2" stroke-linejoin="round"/>
                        <path d="M20 2V6M18 4H22" stroke="#ff4382" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <h2>New AI Tool Releases</h2>
                </div>
                <p class="section-desc">The newest additions to the AI landscape, handpicked for genuine potential and real business impact</p>
            </div>

            <div class="new-releases-grid">
                <!-- Left: Neural Network Speech Preview Card -->
                <div class="new-releases-visual-card">
                    <img src="{{ asset('assets/img/releases/voicegen-preview.png') }}" alt="VoiceGen AI Preview">
                </div>

                <!-- Right: Dynamic & Interactive List of New Releases -->
                <div>
                    <div class="new-releases-list">
                        @php
                            $curatedReleases = [
                                [
                                    'name' => 'VoiceGen AI',
                                    'icon' => 'fa-microphone-lines',
                                    'desc' => 'Create natural-sounding voiceovers in 50+ languages',
                                    'tag' => 'Audio & Voice',
                                    'tag_bg' => 'linear-gradient(90deg, #ff4382, #d63384)',
                                    'date' => 'Released Mar 8, 2026',
                                ],
                                [
                                    'name' => 'Design Mind',
                                    'icon' => 'fa-brain',
                                    'desc' => 'AI-powered design assistant for UI/UX professionals',
                                    'tag' => 'Design',
                                    'tag_bg' => 'linear-gradient(90deg, #ff4382, #e05688)',
                                    'date' => 'Released Mar 5, 2026',
                                ],
                                [
                                    'name' => 'SmartScheduler',
                                    'icon' => 'fa-calendar-check',
                                    'desc' => 'Intelligent meeting scheduling with calendar optimization',
                                    'tag' => 'Productivity',
                                    'tag_bg' => 'linear-gradient(90deg, #ff4382, #d63384)',
                                    'date' => 'Released Mar 3, 2026',
                                ],
                                [
                                    'name' => 'TranslateX',
                                    'icon' => 'fa-language',
                                    'desc' => 'Real-time translation with context awareness',
                                    'tag' => 'Language',
                                    'tag_bg' => 'linear-gradient(90deg, #ff4382, #ff708a)',
                                    'date' => 'Released Mar 1, 2026',
                                ],
                            ];
                        @endphp

                        @if(isset($newReleases) && $newReleases->count() >= 4)
                            @foreach($newReleases->take(4) as $idx => $relTool)
                                @php
                                    $cur = $curatedReleases[$idx] ?? $curatedReleases[0];
                                    $categoryName = $relTool->categories->first()->name ?? $cur['tag'];
                                    $desc = $relTool->short_description ? Str::limit($relTool->short_description, 60) : $cur['desc'];
                                    $relDate = $relTool->created_at ? 'Released ' . $relTool->created_at->format('M j, Y') : $cur['date'];
                                @endphp
                                <a href="{{ route('frontend.tools.show', $relTool->slug) }}" class="new-release-item {{ $idx === 0 ? 'active' : '' }}">
                                    <div class="new-release-item-header">
                                        <div class="new-release-title-group">
                                            <i class="fa-solid {{ $cur['icon'] }}"></i>
                                            <h4>{{ $relTool->name }}</h4>
                                        </div>
                                        <span class="new-badge-outline">New</span>
                                    </div>
                                    <p class="new-release-desc">{{ $desc }}</p>
                                    <div class="new-release-meta">
                                        <span class="new-release-tag" style="background: {{ $cur['tag_bg'] }};">{{ $categoryName }}</span>
                                        <span class="new-release-date">{{ $relDate }}</span>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            @foreach($curatedReleases as $idx => $cur)
                                <div class="new-release-item {{ $idx === 0 ? 'active' : '' }}" onclick="activateRelease(this)">
                                    <div class="new-release-item-header">
                                        <div class="new-release-title-group">
                                            <i class="fa-solid {{ $cur['icon'] }}"></i>
                                            <h4>{{ $cur['name'] }}</h4>
                                        </div>
                                        <span class="new-badge-outline">New</span>
                                    </div>
                                    <p class="new-release-desc">{{ $cur['desc'] }}</p>
                                    <div class="new-release-meta">
                                        <span class="new-release-tag" style="background: {{ $cur['tag_bg'] }};">{{ $cur['tag'] }}</span>
                                        <span class="new-release-date">{{ $cur['date'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="new-releases-action-row">
                        <a href="{{ route('frontend.tools.index') }}" class="btn-figma-pink">View All New Releases</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. LIGHT SECTION: WHY TECHANALYTICA? (ABOUT) -->
    <section class="why-section" id="about" style="scroll-margin-top: 80px;">
        <div class="container">
            <h2 class="section-title">Why TechAnalytica?</h2>
            <p class="section-desc">Zero sponsored fluff. Transparent review metrics. Real community insights.</p>

            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-star"></i></div>
                    <h4>Real Reviews</h4>
                    <p>Verified experiences from active engineers and tech practitioners.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h4>Unbiased</h4>
                    <p>No paid rankings, sponsored priority placements, or manipulated ratings.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-code"></i></div>
                    <h4>API Verified</h4>
                    <p>Live integration benchmarks, response latencies, and uptime telemetry.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-bolt"></i></div>
                    <h4>Fast & Modern</h4>
                    <p>Curated software radar updated daily with breaking AI models and dev tools.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. BROWSE OUR AI CATEGORIES -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Browse Our AI Categories</h2>
                <p class="section-desc">Discover leading generative tools grouped by specific operational workflow</p>
            </div>

            <div class="category-pills">
                <a href="{{ route('frontend.tools.index') }}" class="category-pill active">All Categories</a>
                @foreach($categories->take(9) as $cat)
                    <a href="{{ route('frontend.tools.index', ['category_id' => $cat->id]) }}" class="category-pill">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="category-cards-grid">
                @php
                    $cardThemes = [
                        ['bg' => '#10b981', 'icon' => 'fa-code', 'name' => 'Text & Writing', 'count' => '140+ Tools'],
                        ['bg' => '#8b5cf6', 'icon' => 'fa-wand-magic-sparkles', 'name' => 'Audio & Voice', 'count' => '95+ Tools'],
                        ['bg' => '#f59e0b', 'icon' => 'fa-image', 'name' => 'Image & Video', 'count' => '210+ Tools'],
                        ['bg' => '#3b82f6', 'icon' => 'fa-laptop-code', 'name' => 'Code & Dev', 'count' => '115+ Tools'],
                    ];
                @endphp
                @foreach($cardThemes as $index => $theme)
                    @php
                        $realCat = $categories->get($index);
                        $catName = $realCat ? $realCat->name : $theme['name'];
                        $catCount = $realCat ? $realCat->tools_count . ' Tools' : $theme['count'];
                        $catUrl = $realCat ? route('frontend.tools.index', ['category_id' => $realCat->id]) : route('frontend.tools.index');
                    @endphp
                    <a href="{{ $catUrl }}" class="cat-card">
                        <div class="cat-icon-box" style="background: {{ $theme['bg'] }};">
                            <i class="fa-solid {{ $theme['icon'] }}"></i>
                        </div>
                        <h4>{{ $catName }}</h4>
                        <p>{{ $catCount }}</p>
                    </a>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 36px;">
                <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink">
                    <span>Explore All Categories</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 6. DUAL CTA BANNERS -->
    <section class="container cta-section">
        <div class="cta-grid">
            <div class="cta-banner-card">
                <div>
                    <div class="cta-mini-badge"><i class="fa-solid fa-bullhorn"></i></div>
                    <h3>Are you an AI Software Vendor?</h3>
                    <p>List your product to 50,000+ tech leaders & software buyers looking for their next stack.</p>
                </div>
                <div class="cta-btn-group">
                    <a href="javascript:void(0)" onclick="openModal('submitToolModal')" class="btn-cta-pink">Submit Your Software</a>
                    <a href="javascript:void(0)" onclick="openModal('claimToolModal')" class="btn-cta-dark">Claim Profile</a>
                </div>
            </div>

            <div class="cta-banner-card">
                <div>
                    <div class="cta-mini-badge"><i class="fa-solid fa-pen-nib"></i></div>
                    <h3>Used an AI Tool? Share Your Experience</h3>
                    <p>Help the community choose the right tools by leaving honest, verified feedback.</p>
                </div>
                <div class="cta-btn-group">
                    <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink">Write a Review</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. COMMUNITY TESTIMONIALS -->
    <section class="container testimonial-section">
        <div class="testimonial-text">
            <h2>What The Community Says</h2>
            <p style="color: var(--text-secondary); margin-top: 14px; font-size: 15px; line-height: 1.6;">Read real testimonials from developers, designers, and tech leaders who rely on TechAnalytica.</p>
            <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink" style="margin-top: 24px; text-decoration: none;">Join Community</a>
        </div>

        <div class="testimonial-cards">
            <div class="t-card-white">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Sarah Jenkins" class="t-avatar">
                <div class="t-info">
                    <h5>Sarah Jenkins</h5>
                    <p>Lead Developer @ TechCorp</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
            <div class="t-card-white">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Michael Chang" class="t-avatar">
                <div class="t-info">
                    <h5>Michael Chang</h5>
                    <p>Product Designer @ DesignLab</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
            <div class="t-card-white">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80" alt="Elena Rostova" class="t-avatar">
                <div class="t-info">
                    <h5>Elena Rostova</h5>
                    <p>Head of Marketing @ GrowthX</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
        </div>
    </section>

    <!-- 8. LIGHT SECTION: AI INSIGHTS WORTH READING -->
    <section class="insights-section">
        <div class="container">
            <div class="insights-header">
                <h2>AI Insights Worth Reading</h2>
                <form action="{{ route('frontend.blogs') }}" method="GET" class="insights-search-wrapper">
                    <input type="text" name="search" placeholder="Search insights...">
                    <button type="submit">Search</button>
                </form>
            </div>

            @php
                $featuredBlog = $latestBlogs->first();
                $sideBlogs = $latestBlogs->skip(1)->take(3);

                $curatedSide = [
                    [
                        'title' => 'Top 10 Generative AI Tools for Coding in 2026',
                        'tag' => 'Industry Trends',
                        'time' => '5 min read',
                        'img' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=300&q=80'
                    ],
                    [
                        'title' => 'The Ethics of Voice Cloning in Commercial Media',
                        'tag' => 'Deep Analysis',
                        'time' => '8 min read',
                        'img' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=300&q=80'
                    ],
                    [
                        'title' => 'How AI LLMs are Changing Search Engine Optimization',
                        'tag' => 'SEO Guide',
                        'time' => '4 min read',
                        'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=300&q=80'
                    ],
                ];
            @endphp

            <div class="insights-grid">
                <!-- Left: Featured Banner & Article -->
                <a href="{{ $featuredBlog ? route('frontend.blogs.show', $featuredBlog->slug) : route('frontend.blogs') }}" class="featured-insight-card">
                    <div class="featured-insight-banner">
                        <h3>{{ $featuredBlog ? $featuredBlog->title : 'Unlock the Power of "And" with the Hybrid CDP' }}</h3>
                        <svg class="squiggle-wave" viewBox="0 0 140 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 65 Q 35 15, 60 55 T 110 30 T 135 60" stroke="#ff3b7b" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M25 70 Q 45 30, 75 60 T 125 40" stroke="#ff735c" stroke-width="4" stroke-linecap="round" opacity="0.6" />
                        </svg>
                    </div>
                    <div>
                        <span class="featured-insight-tag">ARTICLE</span>
                        <h4>{{ $featuredBlog ? $featuredBlog->title : 'Unlock the Power of "And" with the Hybrid CDP' }}</h4>
                        <p>{{ $featuredBlog ? Str::limit($featuredBlog->meta_description ?? strip_tags($featuredBlog->body), 130) : 'How modern data platforms are combining warehouse power with instant operational workflows for high-growth teams.' }}</p>
                        <span class="featured-insight-link">Read More <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i></span>
                    </div>
                </a>

                <!-- Right: Stacked Insight Articles -->
                <div class="insight-list">
                    @if($sideBlogs->count() >= 3)
                        @foreach($sideBlogs as $idx => $sBlog)
                            @php
                                $cFallback = $curatedSide[$idx] ?? $curatedSide[0];
                                $thumbUrl = ($sBlog->og_image && !str_contains($sBlog->og_image, 'placeholder')) ? asset($sBlog->og_image) : $cFallback['img'];
                            @endphp
                            <a href="{{ route('frontend.blogs.show', $sBlog->slug) }}" class="insight-item-light">
                                <img src="{{ $thumbUrl }}" alt="{{ $sBlog->title }}" class="insight-thumb">
                                <div class="insight-content-light">
                                    <span class="insight-tag-light">{{ $sBlog->category->name ?? $cFallback['tag'] }}</span>
                                    <h5>{{ $sBlog->title }}</h5>
                                    <p class="insight-meta-light">{{ $sBlog->published_at ? $sBlog->published_at->format('M d, Y') : $cFallback['time'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        @foreach($curatedSide as $cItem)
                            <a href="{{ route('frontend.blogs') }}" class="insight-item-light">
                                <img src="{{ $cItem['img'] }}" alt="{{ $cItem['title'] }}" class="insight-thumb">
                                <div class="insight-content-light">
                                    <span class="insight-tag-light">{{ $cItem['tag'] }}</span>
                                    <h5>{{ $cItem['title'] }}</h5>
                                    <p class="insight-meta-light">{{ $cItem['time'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- 9. FREQUENTLY ASKED QUESTIONS -->
    <section class="faq-section">
        <div class="container faq-wrapper">
            <div>
                <span class="faq-badge">FAQ</span>
                <h2 class="section-title" style="text-align: left;">Frequently Asked <br><span class="gradient-text">Questions</span></h2>
                <p class="section-desc" style="margin-left: 0; margin-top: 14px;">Everything you need to know about listing, discovering, and evaluating AI tools on TechAnalytica.</p>
            </div>

            <div>
                <div class="faq-item active" onclick="this.classList.toggle('active')">
                    <div class="faq-header">
                        <h5>What is TechAnalytica?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>TechAnalytica is a premier AI software discovery platform that helps teams evaluate, compare, and adopt verified AI tools based on real user metrics and transparent analytics.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="this.classList.toggle('active')">
                    <div class="faq-header">
                        <h5>How do you rate and rank AI tools?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Our algorithms evaluate software across multiple data points including verified user reviews, API uptime, integration scalability, pricing value, and performance benchmarks.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="this.classList.toggle('active')">
                    <div class="faq-header">
                        <h5>Can I list my own AI software?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! Software vendors can submit their AI products via our "Submit AI Tool" flow or claim an existing profile to manage product updates, analytics, and user reviews.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="this.classList.toggle('active')">
                    <div class="faq-header">
                        <h5>Are the reviews verified?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>All reviews undergo automated anti-spam checks and human moderation before being published to maintain 100% authenticity and prevent sponsored bias.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function activateRelease(element) {
            document.querySelectorAll('.new-release-item').forEach(el => el.classList.remove('active'));
            element.classList.add('active');
        }
    </script>
    @endpush

@endsection

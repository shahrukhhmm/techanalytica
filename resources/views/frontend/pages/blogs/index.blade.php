@extends('frontend.layout.app')

@section('title', 'TechAnalytica Editorial — Sharper Thinking for AI Builders')
@section('meta_description', 'Real-world stories, technical deep-dives, benchmarks, and breakdowns from founders and engineers shipping products with AI.')

@push('styles')
<style>
/* ==========================================================================
   BLOG EDITORIAL — FIGMA PIXEL-PERFECT REPLICA
   ========================================================================== */

/* ── Typography & Global Reset Helpers ── */
.blog-page-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 2;
}

.gradient-text-pink {
    background: linear-gradient(135deg, #ff3b7b 0%, #ff735c 50%, #c0428d 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline;
}

.gradient-word {
    background: linear-gradient(90deg, #ff3b7b, #a554ef);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-style: italic;
    font-weight: 800;
}

/* ── 1. Hero Section ── */
.b-hero {
    padding: 48px 0 36px;
    position: relative;
}

.b-hero-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 48px;
    align-items: center;
}

.b-hero-left {
    max-width: 620px;
}

.b-hero-title {
    font-size: clamp(34px, 4.4vw, 54px);
    font-weight: 800;
    line-height: 1.12;
    letter-spacing: -0.03em;
    color: #ffffff;
    margin-bottom: 18px;
}

.b-hero-sub {
    font-size: 16px;
    color: #a89cad;
    line-height: 1.65;
    margin-bottom: 24px;
    max-width: 520px;
}

.b-hero-btn-row {
    margin-bottom: 26px;
}

.btn-read-latest {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(90deg, #ff3b7b, #ff735c);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    padding: 9px 22px;
    border-radius: 9999px;
    text-decoration: none;
    box-shadow: 0 4px 18px rgba(255, 59, 123, 0.4);
    transition: all 0.25s ease;
}

.btn-read-latest:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(255, 59, 123, 0.55);
}

.b-hero-search {
    display: flex;
    align-items: center;
    max-width: 480px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 9999px;
    padding: 4px 6px 4px 20px;
    transition: all 0.25s ease;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
}

.b-hero-search:focus-within {
    border-color: rgba(255, 59, 123, 0.5);
    box-shadow: 0 0 20px rgba(255, 59, 123, 0.25);
}

.b-hero-search input {
    flex: 1;
    background: transparent;
    border: none;
    color: #fff;
    font-size: 13.5px;
    font-family: inherit;
    outline: none;
}

.b-hero-search input::placeholder {
    color: #7b7086;
}

.btn-hero-search {
    background: linear-gradient(90deg, #ff3b7b, #ff735c);
    color: #fff;
    border: none;
    padding: 9px 20px;
    border-radius: 9999px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: filter 0.2s;
    font-family: inherit;
}

.btn-hero-search:hover {
    filter: brightness(1.1);
}

/* ── Hero Featured Card (Right) ── */
.b-hero-card {
    background: #14091a;
    border: 1px solid rgba(224, 67, 133, 0.35);
    border-radius: 20px;
    padding: 30px;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    display: block;
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.55);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.b-hero-card:hover {
    transform: translateY(-4px);
    border-color: rgba(255, 59, 123, 0.65);
    box-shadow: 0 20px 56px rgba(255, 59, 123, 0.2);
}

.badge-must-read {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 9999px;
    background: linear-gradient(90deg, #ff3b7b, #ff735c);
    color: #ffffff;
    font-size: 10.5px;
    font-weight: 800;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.b-hero-card-title {
    font-size: 20px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.35;
    margin-bottom: 12px;
    letter-spacing: -0.02em;
}

.b-hero-card-desc {
    font-size: 13px;
    color: #a89cad;
    line-height: 1.6;
    margin-bottom: 24px;
    max-width: 360px;
}

.b-hero-card-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
    z-index: 2;
}

.b-avatar-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #a4358a, #ff3b7b);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}

.b-hero-author-name {
    font-size: 12px;
    font-weight: 700;
    color: #ffffff;
}

.b-hero-date {
    font-size: 11px;
    color: #8c7e94;
}

.b-hero-card-crescent {
    position: absolute;
    bottom: -30px;
    right: -30px;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, #ff5e80 0%, #a4358a 70%, transparent 100%);
    opacity: 0.55;
    pointer-events: none;
}

/* ── 2. Category Filter Pills Bar ── */
.b-pills-bar-wrap {
    position: sticky;
    top: 0;
    z-index: 80;
    background: rgba(11, 2, 14, 0.92);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    padding: 12px 0;
    margin-bottom: 40px;
}

.b-pills-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.b-pills-scroll {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
    scrollbar-width: none;
}

.b-pills-scroll::-webkit-scrollbar {
    display: none;
}

.b-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
    color: #a89cad;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.09);
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.b-pill:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 59, 123, 0.35);
}

.b-pill.active {
    background: #ffffff;
    color: #110717;
    border-color: #ffffff;
    font-weight: 700;
    box-shadow: 0 4px 14px rgba(255, 255, 255, 0.2);
}

.b-pills-search-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #a89cad;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s ease;
}

.b-pills-search-btn:hover {
    background: rgba(255, 59, 123, 0.15);
    border-color: rgba(255, 59, 123, 0.4);
    color: #ff3b7b;
}

/* ── 3. Main Two-Column Layout ── */
.b-layout-grid {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 36px;
    align-items: start;
    margin-bottom: 60px;
}

/* ── Sidebar ── */
.b-sidebar {
    position: sticky;
    top: 76px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.b-sidebar-card {
    background: rgba(20, 10, 26, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 16px;
    backdrop-filter: blur(14px);
}

.b-sidebar-nav-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.b-sidebar-nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 600;
    color: #a89cad;
    text-decoration: none;
    transition: all 0.2s ease;
}

.b-sidebar-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.25);
    transition: all 0.2s ease;
}

.b-sidebar-nav-link:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.05);
}

.b-sidebar-nav-link:hover .b-sidebar-dot,
.b-sidebar-nav-link.active .b-sidebar-dot {
    background: #ff3b7b;
    box-shadow: 0 0 8px rgba(255, 59, 123, 0.8);
}

.b-sidebar-nav-link.active {
    color: #fff;
    background: rgba(255, 59, 123, 0.12);
}

/* Newsletter Card */
.b-newsletter-card {
    background: #14091b;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    overflow: hidden;
    position: relative;
}

.b-newsletter-glow {
    height: 60px;
    background: linear-gradient(180deg, rgba(255, 94, 128, 0.3) 0%, transparent 100%);
    pointer-events: none;
}

.b-newsletter-body {
    padding: 0 18px 20px;
    margin-top: -30px;
    position: relative;
    z-index: 2;
}

.b-newsletter-title {
    font-size: 14.5px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.35;
    margin-bottom: 8px;
}

.b-newsletter-desc {
    font-size: 12px;
    color: #9a8c9e;
    line-height: 1.55;
    margin-bottom: 16px;
}

.b-newsletter-input {
    width: 100%;
    padding: 10px 14px;
    border-radius: 10px;
    background: #1c0e25;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 12.5px;
    outline: none;
    margin-bottom: 10px;
    box-sizing: border-box;
    font-family: inherit;
    transition: border-color 0.2s;
}

.b-newsletter-input:focus {
    border-color: rgba(255, 59, 123, 0.5);
}

.btn-newsletter-sub {
    width: 100%;
    padding: 10px 16px;
    border-radius: 10px;
    background: linear-gradient(90deg, #ff3b7b, #ff735c);
    border: none;
    color: #fff;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: filter 0.2s, transform 0.2s;
    font-family: inherit;
}

.btn-newsletter-sub:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

/* ── Content Column ── */
.b-content-col {
    display: flex;
    flex-direction: column;
    gap: 48px;
    min-width: 0;
}

/* Section Header Shared */
.b-sec-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 8px;
}

.b-sec-title-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
}

.b-sec-icon-square {
    width: 9px;
    height: 9px;
    border-radius: 2.5px;
    background: #ff3b7b;
    box-shadow: 0 0 10px rgba(255, 59, 123, 0.8);
}

.b-sec-title {
    font-size: 18px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
    margin: 0;
}

.b-sec-link {
    font-size: 12px;
    font-weight: 700;
    color: #ff3b7b;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap 0.2s ease, opacity 0.2s ease;
}

.b-sec-link:hover {
    gap: 7px;
    opacity: 0.9;
}

/* ── SECTION 1: Featured ── */
.b-section-anchor {
    scroll-margin-top: 85px;
}

.b-featured-card {
    background: #14091a;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    overflow: hidden;
    display: grid;
    grid-template-columns: 1fr 1.08fr;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.b-featured-card:hover {
    border-color: rgba(255, 59, 123, 0.4);
    transform: translateY(-4px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
}

/* 3D Abstract Graphic Canvas */
.b-featured-art-canvas {
    background: linear-gradient(135deg, #ff5e80 0%, #ff8c7a 50%, #b23b82 100%);
    position: relative;
    overflow: hidden;
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.art-shape-orb-top {
    position: absolute;
    top: 24px;
    right: 28px;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: radial-gradient(circle at 35% 35%, #ffffff 0%, #ffcad4 30%, #ff8c7a 70%, #d83b7d 100%);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18);
}

.art-shape-orb-bottom {
    position: absolute;
    bottom: 20px;
    left: 20px;
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: radial-gradient(circle at 35% 35%, #ffffff 0%, #ffcad4 30%, #ff8c7a 75%);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
}

.art-shape-cube {
    position: absolute;
    bottom: 30px;
    right: 36px;
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.65);
    backdrop-filter: blur(8px);
    transform: rotate(-15deg) skewX(8deg);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.b-featured-content {
    padding: 32px 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.b-badge-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
}

.b-badge-pill {
    padding: 3.5px 11px;
    border-radius: 9999px;
    font-size: 10.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.b-badge-pill.pink-solid {
    background: #ff3b7b;
    color: #fff;
}

.b-badge-pill.outline {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #e2d9e6;
}

.b-featured-heading {
    font-size: 21px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.35;
    margin-bottom: 12px;
    letter-spacing: -0.02em;
}

.b-featured-excerpt {
    font-size: 13px;
    color: #a89cad;
    line-height: 1.6;
    margin-bottom: 22px;
}

.b-author-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: auto;
}

.b-author-name {
    font-size: 12px;
    font-weight: 700;
    color: #fff;
}

.b-author-date {
    font-size: 11px;
    color: #8c7e94;
}

/* ── SECTION 2: Trends & Insights (2x2 Grid) ── */
.b-trends-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.b-trend-card {
    background: #14091a;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    transition: all 0.25s ease;
}

.b-trend-card:hover {
    transform: translateY(-4px);
    border-color: rgba(255, 59, 123, 0.4);
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.55);
}

.b-trend-art-box {
    height: 145px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* 4 Distinct Figma Geometric Pastel Art Backgrounds */
.art-bg-peach-1 {
    background: linear-gradient(135deg, #ff9ca7 0%, #ffbaa5 100%);
}

.art-bg-peach-2 {
    background: linear-gradient(135deg, #ff9ca7 0%, #ffbaa5 100%);
}

.art-bg-coral-3 {
    background: linear-gradient(135deg, #ff5e6c 0%, #ff7854 100%);
}

.art-bg-magenta-4 {
    background: linear-gradient(135deg, #ff3b68 0%, #ff527b 100%);
}

/* Geometric elements inside art boxes */
.shape-purple-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #a4358a;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    margin-right: 8px;
}

.shape-pink-square {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    background: #ff5252;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.shape-wireframe-windows {
    display: flex;
    gap: 8px;
}

.shape-wire-win {
    width: 60px;
    height: 48px;
    border-radius: 8px;
    background: #ff6e8a;
    border: 2px solid rgba(255, 255, 255, 0.35);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    position: relative;
}

.shape-wire-win::before {
    content: '';
    position: absolute;
    top: 6px;
    left: 6px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #ffffff;
}

.shape-donut-ring {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #111a2e;
    box-shadow: inset 0 0 0 16px #1e2438, 0 8px 20px rgba(0, 0, 0, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
}

.shape-donut-inner {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #ff7854;
}

.shape-neon-wave-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
}

.shape-neon-wave {
    width: 70px;
    height: 38px;
    background: #c6ff00;
    border-radius: 30px 10px 30px 10px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
}

.shape-neon-orb {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #ff3b68;
    border: 2px solid #ffffff;
}

.b-trend-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.b-trend-tag {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    background: #ff3b7b;
    color: #fff;
    align-self: flex-start;
    margin-bottom: 10px;
}

.b-trend-title {
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.38;
    margin-bottom: 8px;
}

.b-trend-excerpt {
    font-size: 12.5px;
    color: #a89cad;
    line-height: 1.55;
    margin-bottom: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.b-trend-meta {
    font-size: 11px;
    color: #8c7e94;
    margin-top: auto;
}

/* ── Quote / Callout Banner ── */
.b-quote-banner {
    background: linear-gradient(135deg, #d83b7d 0%, #ff5c8a 45%, #a855f7 100%);
    border-radius: 20px;
    padding: 36px 40px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 44px rgba(216, 59, 125, 0.35);
}

.b-quote-text {
    font-size: clamp(17px, 2.2vw, 22px);
    font-weight: 700;
    font-style: italic;
    color: #ffffff;
    line-height: 1.45;
    margin-bottom: 18px;
    letter-spacing: -0.01em;
}

.b-quote-author {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 12.5px;
    font-weight: 600;
}

.b-quote-avatar {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 800;
}

/* ── SECTION 3: Comparisons & How-to Guides (List Rows) ── */
.b-guides-stack {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.b-guide-item {
    background: rgba(20, 10, 26, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 14px;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

.b-guide-item:hover {
    background: rgba(26, 12, 34, 0.85);
    border-color: rgba(255, 59, 123, 0.4);
    transform: translateX(4px);
}

.b-guide-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.b-guide-icon-sq {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

.b-guide-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.35;
    margin-bottom: 2px;
}

.b-guide-sub {
    font-size: 11.5px;
    color: #9a8c9e;
}

.b-guide-arrow {
    color: #8c7e94;
    font-size: 13px;
    transition: color 0.2s, transform 0.2s;
}

.b-guide-item:hover .b-guide-arrow {
    color: #ff3b7b;
    transform: translateX(3px);
}

/* ── SECTION 4: News & PR (Divided List) ── */
.b-news-box {
    background: rgba(20, 10, 26, 0.75);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    overflow: hidden;
}

.b-news-row {
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    text-decoration: none;
    color: inherit;
    transition: background 0.2s ease;
}

.b-news-row:last-child {
    border-bottom: none;
}

.b-news-row:hover {
    background: rgba(255, 59, 123, 0.05);
}

.b-news-date {
    width: 95px;
    flex-shrink: 0;
    font-size: 11px;
    font-weight: 800;
    color: #9a8c9e;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.b-news-info {
    flex: 1;
}

.b-news-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.35;
    margin-bottom: 3px;
}

.b-news-sub {
    font-size: 11.5px;
    color: #9a8c9e;
}

.b-news-cta {
    font-size: 11.5px;
    font-weight: 700;
    color: #ff3b7b;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap 0.2s;
}

.b-news-row:hover .b-news-cta {
    gap: 7px;
}

/* ── SECTION 5: Founder Stories (4 Distinct Atmospheric Cards) ── */
.b-founders-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.b-founder-card {
    border-radius: 18px;
    padding: 24px;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    transition: all 0.25s ease;
    border: 1px solid transparent;
}

.b-founder-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.6);
}

/* The 4 Atmospheric Colors */
.f-card-plum {
    background: #251336;
    border-color: rgba(168, 85, 247, 0.25);
}
.f-card-plum:hover { border-color: rgba(168, 85, 247, 0.5); }

.f-card-teal {
    background: #0f2c30;
    border-color: rgba(20, 184, 166, 0.25);
}
.f-card-teal:hover { border-color: rgba(20, 184, 166, 0.5); }

.f-card-rust {
    background: #3e1c18;
    border-color: rgba(249, 115, 22, 0.25);
}
.f-card-rust:hover { border-color: rgba(249, 115, 22, 0.5); }

.f-card-indigo {
    background: #141f45;
    border-color: rgba(59, 130, 246, 0.25);
}
.f-card-indigo:hover { border-color: rgba(59, 130, 246, 0.5); }

.b-founder-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.b-founder-brand {
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
}

.b-founder-tag {
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    background: #ff3b7b;
    color: #fff;
}

.b-founder-title {
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.38;
    margin-bottom: 8px;
}

.b-founder-excerpt {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.55;
    margin-bottom: 18px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.b-founder-author {
    font-size: 11px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.8);
    margin-top: auto;
}

/* ── SECTION 6: Research & Data (Split Grid) ── */
.b-research-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.b-research-left-card {
    background: #14091a;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 18px;
    padding: 28px;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.b-res-corner-circle {
    position: absolute;
    bottom: -35px;
    right: -35px;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(224, 67, 133, 0.45) 0%, transparent 70%);
    pointer-events: none;
}

.b-res-tag {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    background: #ff3b7b;
    color: #fff;
    align-self: flex-start;
    margin-bottom: 12px;
}

.b-res-title {
    font-size: 18px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 8px;
    line-height: 1.35;
}

.b-res-desc {
    font-size: 12.5px;
    color: #a89cad;
    line-height: 1.55;
    margin-bottom: 22px;
}

.b-res-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 24px;
    position: relative;
    z-index: 2;
}

.b-res-stat-val {
    font-size: 22px;
    font-weight: 800;
    color: #ff3b7b;
    margin-bottom: 2px;
    display: block;
}

.b-res-stat-lbl {
    font-size: 10.5px;
    color: #8c7e94;
    line-height: 1.3;
}

.btn-download-rep {
    background: transparent;
    border: 1px solid rgba(255, 59, 123, 0.5);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 9px 18px;
    border-radius: 8px;
    text-decoration: none;
    align-self: flex-start;
    transition: all 0.2s ease;
    position: relative;
    z-index: 2;
}

.btn-download-rep:hover {
    background: #ff3b7b;
    border-color: #ff3b7b;
}

.b-research-right-stack {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.b-res-pub-card {
    background: rgba(20, 10, 26, 0.75);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 14px;
    padding: 14px 18px;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    gap: 4px;
    transition: all 0.2s ease;
}

.b-res-pub-card:hover {
    background: rgba(26, 12, 34, 0.85);
    border-color: rgba(255, 59, 123, 0.4);
    transform: translateY(-2px);
}

.b-res-pub-tag {
    font-size: 9.5px;
    font-weight: 800;
    text-transform: uppercase;
    color: #ff3b7b;
    letter-spacing: 0.04em;
}

.b-res-pub-title {
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.35;
}

.b-res-pub-date {
    font-size: 11px;
    color: #8c7e94;
}

/* ── SECTION 7: Bottom CTA Banner ── */
.b-cta-banner {
    background: #14091a;
    border: 1px solid rgba(224, 67, 133, 0.35);
    border-radius: 22px;
    padding: 36px 44px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    margin-bottom: 70px;
    box-shadow: 0 16px 44px rgba(0, 0, 0, 0.5);
}

.b-cta-title {
    font-size: clamp(24px, 3vw, 32px);
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
    margin-bottom: 8px;
}

.b-cta-sub {
    font-size: 14px;
    color: #a89cad;
    margin-bottom: 22px;
}

.b-cta-btns {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}

.btn-cta-pink-fill {
    background: linear-gradient(90deg, #ff3b7b, #ff735c);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    padding: 11px 24px;
    border-radius: 9999px;
    text-decoration: none;
    box-shadow: 0 4px 18px rgba(255, 59, 123, 0.4);
    transition: all 0.25s ease;
}

.btn-cta-pink-fill:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(255, 59, 123, 0.55);
}

.btn-cta-outline-glass {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    padding: 11px 24px;
    border-radius: 9999px;
    text-decoration: none;
    transition: all 0.25s ease;
}

.btn-cta-outline-glass:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 59, 123, 0.4);
    color: #ff3b7b;
}

.b-cta-matrix-card {
    width: 170px;
    height: 150px;
    border-radius: 18px;
    background: #0f0514;
    border: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.b-dots-cluster {
    position: relative;
    width: 110px;
    height: 90px;
}

.b-cluster-dot {
    position: absolute;
    border-radius: 50%;
    box-shadow: 0 0 14px currentColor;
}

/* ── Filter / Search Fallback View ── */
.b-search-results-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 40px;
}

/* ── Responsive Media Queries ── */
@media (max-width: 1024px) {
    .b-hero-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    .b-layout-grid {
        grid-template-columns: 1fr;
    }
    .b-sidebar {
        display: none; /* In-page navigation handled by sticky pills bar */
    }
}

@media (max-width: 768px) {
    .b-featured-card {
        grid-template-columns: 1fr;
    }
    .b-trends-grid,
    .b-founders-grid,
    .b-research-grid,
    .b-search-results-grid {
        grid-template-columns: 1fr;
    }
    .b-cta-banner {
        flex-direction: column;
        align-items: flex-start;
        padding: 28px 24px;
    }
    .b-news-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
</style>
@endpush

@section('content')
<div class="blog-page-container">

    {{-- ── 1. HERO SECTION ── --}}
    <section class="b-hero">
        <div class="b-hero-grid">
            <div class="b-hero-left">
                <h1 class="b-hero-title">
                    Sharper thinking for the people <span class="gradient-word">building</span> what's next.
                </h1>
                <p class="b-hero-sub">
                    Real-world stories and breakdowns from the builders, founders, and engineers shipping products with AI.
                </p>
                <div class="b-hero-btn-row">
                    <a href="#featured" class="btn-read-latest">Read Latest</a>
                </div>

                {{-- Search Bar --}}
                <form action="{{ route('frontend.blogs') }}" method="GET" class="b-hero-search">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search stories, guides, and research...">
                    <button type="submit" class="btn-hero-search">Search</button>
                </form>
            </div>

            {{-- Hero Featured Card (Must Read) --}}
            @if(isset($heroBlog) && $heroBlog)
                <a href="{{ route('frontend.blogs.show', $heroBlog->slug) }}" class="b-hero-card">
                    <span class="badge-must-read">Must Read</span>
                    <h3 class="b-hero-card-title">{{ $heroBlog->title }}</h3>
                    <p class="b-hero-card-desc">{{ Str::limit($heroBlog->meta_description ?? strip_tags($heroBlog->body), 130) }}</p>
                    <div class="b-hero-card-meta">
                        <div class="b-avatar-circle">
                            {{ substr($heroBlog->author->name ?? 'Alex Rivera', 0, 1) }}
                        </div>
                        <div>
                            <div class="b-hero-author-name">{{ $heroBlog->author->name ?? 'Alex Rivera' }}</div>
                            <div class="b-hero-date">{{ $heroBlog->published_at ? $heroBlog->published_at->format('M d, Y') : 'Jan 15, 2026' }} · 8 min read</div>
                        </div>
                    </div>
                    <div class="b-hero-card-crescent"></div>
                </a>
            @endif
        </div>
    </section>

</div>

{{-- ── 2. STICKY CATEGORY PILLS BAR ── --}}
<div class="b-pills-bar-wrap">
    <div class="blog-page-container">
        <div class="b-pills-bar">
            <div class="b-pills-scroll">
                <a href="{{ route('frontend.blogs') }}" class="b-pill {{ (!request('category_id') && !request('q')) ? 'active' : '' }}">
                    All Posts
                </a>
                <a href="#featured" class="b-pill">Featured</a>
                <a href="#trends-insights" class="b-pill">Trends & Insights</a>
                <a href="#comparisons-guides" class="b-pill">Comparisons & Guides</a>
                <a href="#news-pr" class="b-pill">News & PR</a>
                <a href="#founder-stories" class="b-pill">Founder Stories</a>
                <a href="#research-data" class="b-pill">Research & Data</a>
            </div>

            <button type="button" class="b-pills-search-btn" onclick="document.querySelector('.b-hero-search input')?.focus();" aria-label="Search blogs">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </div>
</div>

<div class="blog-page-container">

    {{-- ── CONDITIONAL: Search or Specific Category Filter View ── --}}
    @if(request('q') || request('category_id'))
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                <h2 style="font-size: 22px; font-weight: 800; color: #fff;">
                    @if(request('q'))
                        Search results for "<span style="color: #ff3b7b;">{{ request('q') }}</span>"
                    @else
                        Category Filtered Posts
                    @endif
                    <span style="font-size: 14px; font-weight: 400; color: #9a8c9e;">({{ $blogs->total() }} results)</span>
                </h2>
                <a href="{{ route('frontend.blogs') }}" class="b-sec-link">
                    <i class="fa-solid fa-arrow-left"></i> View Full Editorial
                </a>
            </div>

            <div class="b-search-results-grid">
                @forelse($blogs as $b)
                    <a href="{{ route('frontend.blogs.show', $b->slug) }}" class="b-trend-card">
                        <div class="b-trend-art-box art-bg-peach-1">
                            <div class="shape-purple-circle"></div>
                            <div class="shape-pink-square"></div>
                        </div>
                        <div class="b-trend-body">
                            <span class="b-trend-tag">{{ $b->category->name ?? 'Article' }}</span>
                            <h4 class="b-trend-title">{{ $b->title }}</h4>
                            <p class="b-trend-excerpt">{{ Str::limit($b->meta_description ?? strip_tags($b->body), 110) }}</p>
                            <span class="b-trend-meta">{{ $b->published_at ? $b->published_at->format('M d, Y') : 'Jan 2026' }}</span>
                        </div>
                    </a>
                @empty
                    <div style="grid-column: 1 / -1; padding: 60px 20px; text-align: center; color: #9a8c9e; background: rgba(255,255,255,0.03); border-radius: 16px;">
                        <i class="fa-solid fa-newspaper" style="font-size: 32px; color: #ff3b7b; margin-bottom: 12px; display: block;"></i>
                        <h3>No articles found</h3>
                        <p style="font-size: 13px; margin-top: 6px;">Try adjusting your query or browse the categories below.</p>
                    </div>
                @endforelse
            </div>

            <div style="margin-bottom: 40px;">
                {{ $blogs->links() }}
            </div>
        </div>
    @else

        {{-- ── 3. MAIN TWO-COLUMN EDITORIAL VIEW ── --}}
        <div class="b-layout-grid">

            {{-- ── LEFT SIDEBAR ── --}}
            <aside class="b-sidebar">
                {{-- Quick Jump Links --}}
                <div class="b-sidebar-card">
                    <ul class="b-sidebar-nav-list">
                        <li>
                            <a href="#featured" class="b-sidebar-nav-link active">
                                <span class="b-sidebar-dot"></span>
                                Featured
                            </a>
                        </li>
                        <li>
                            <a href="#trends-insights" class="b-sidebar-nav-link">
                                <span class="b-sidebar-dot"></span>
                                Trends & Insights
                            </a>
                        </li>
                        <li>
                            <a href="#comparisons-guides" class="b-sidebar-nav-link">
                                <span class="b-sidebar-dot"></span>
                                Comparisons & Guides
                            </a>
                        </li>
                        <li>
                            <a href="#news-pr" class="b-sidebar-nav-link">
                                <span class="b-sidebar-dot"></span>
                                News & PR
                            </a>
                        </li>
                        <li>
                            <a href="#founder-stories" class="b-sidebar-nav-link">
                                <span class="b-sidebar-dot"></span>
                                Founder Stories
                            </a>
                        </li>
                        <li>
                            <a href="#research-data" class="b-sidebar-nav-link">
                                <span class="b-sidebar-dot"></span>
                                Research & Data
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Newsletter Card --}}
                <div class="b-newsletter-card">
                    <div class="b-newsletter-glow"></div>
                    <div class="b-newsletter-body">
                        <h4 class="b-newsletter-title">The weekly digest for AI builders</h4>
                        <p class="b-newsletter-desc">Get actionable briefs on AI dev, architectures, & benchmarks in your inbox.</p>
                        <form action="javascript:void(0)" onsubmit="alert('Thank you for subscribing to TechAnalytica newsletter!');">
                            <input type="email" required placeholder="your@email.com" class="b-newsletter-input">
                            <button type="submit" class="btn-newsletter-sub">Subscribe &rarr;</button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- ── RIGHT CONTENT COLUMN ── --}}
            <main class="b-content-col">

                {{-- ── SECTION 1: Featured ── --}}
                <section class="b-section-anchor" id="featured">
                    <div class="b-sec-header">
                        <div class="b-sec-title-wrap">
                            <span class="b-sec-icon-square"></span>
                            <h2 class="b-sec-title">Featured</h2>
                        </div>
                        <a href="{{ route('frontend.blogs', ['category_id' => $blogCategories->firstWhere('slug', 'featured')?->id ?? '']) }}" class="b-sec-link">
                            View all featured &rarr;
                        </a>
                    </div>

                    @if(isset($mainFeaturedStory) && $mainFeaturedStory)
                        <a href="{{ route('frontend.blogs.show', $mainFeaturedStory->slug) }}" class="b-featured-card">
                            <div class="b-featured-art-canvas">
                                <div class="art-shape-orb-top"></div>
                                <div class="art-shape-orb-bottom"></div>
                                <div class="art-shape-cube"></div>
                            </div>
                            <div class="b-featured-content">
                                <div class="b-badge-row">
                                    <span class="b-badge-pill pink-solid">Deep Dive</span>
                                    <span class="b-badge-pill outline">AI Engineering</span>
                                </div>
                                <h3 class="b-featured-heading">{{ $mainFeaturedStory->title }}</h3>
                                <p class="b-featured-excerpt">{{ Str::limit($mainFeaturedStory->meta_description ?? strip_tags($mainFeaturedStory->body), 160) }}</p>
                                <div class="b-author-row">
                                    <div class="b-avatar-circle">
                                        {{ substr($mainFeaturedStory->author->name ?? 'Elena Rostova', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="b-author-name">{{ $mainFeaturedStory->author->name ?? 'Elena Rostova' }}</div>
                                        <div class="b-author-date">{{ $mainFeaturedStory->published_at ? $mainFeaturedStory->published_at->format('M d, Y') : 'Jan 14, 2026' }} · 11 min read</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                </section>

                {{-- ── SECTION 2: Trends & Insights ── --}}
                <section class="b-section-anchor" id="trends-insights">
                    <div class="b-sec-header">
                        <div class="b-sec-title-wrap">
                            <span class="b-sec-icon-square"></span>
                            <h2 class="b-sec-title">Trends & Insights</h2>
                        </div>
                        <a href="{{ route('frontend.blogs', ['category_id' => $blogCategories->firstWhere('slug', 'trends-insights')?->id ?? '']) }}" class="b-sec-link">
                            View 12 stories &rarr;
                        </a>
                    </div>

                    <div class="b-trends-grid">
                        @php
                            $artBgs = ['art-bg-peach-1', 'art-bg-peach-2', 'art-bg-coral-3', 'art-bg-magenta-4'];
                            $tags = ['Architecture', 'UI/UX', 'Security', 'Workflow'];
                        @endphp

                        @foreach($trendsBlogs as $idx => $tBlog)
                            <a href="{{ route('frontend.blogs.show', $tBlog->slug) }}" class="b-trend-card">
                                <div class="b-trend-art-box {{ $artBgs[$idx % 4] }}">
                                    @if($idx === 0)
                                        <div class="shape-purple-circle"></div>
                                        <div class="shape-pink-square"></div>
                                    @elseif($idx === 1)
                                        <div class="shape-wireframe-windows">
                                            <div class="shape-wire-win"></div>
                                            <div class="shape-wire-win"></div>
                                        </div>
                                    @elseif($idx === 2)
                                        <div class="shape-donut-ring">
                                            <div class="shape-donut-inner"></div>
                                        </div>
                                    @else
                                        <div class="shape-neon-wave-wrap">
                                            <div class="shape-neon-wave"></div>
                                            <div class="shape-neon-orb"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="b-trend-body">
                                    <span class="b-trend-tag">{{ $tags[$idx % 4] }}</span>
                                    <h4 class="b-trend-title">{{ $tBlog->title }}</h4>
                                    <p class="b-trend-excerpt">{{ Str::limit($tBlog->meta_description ?? strip_tags($tBlog->body), 110) }}</p>
                                    <span class="b-trend-meta">{{ $tBlog->published_at ? $tBlog->published_at->format('M d, Y') : 'Jan 13, 2026' }} · 6 min read</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- ── Quote / Callout Banner ── --}}
                <div class="b-quote-banner">
                    <p class="b-quote-text">
                        "In five years, everyone who won didn't have better algorithms; they had more data, tighter feedback loops, and more bias toward shipping than discussing."
                    </p>
                    <div class="b-quote-author">
                        <div class="b-quote-avatar">TA</div>
                        <span>TechAnalytica Editorial, 2026 &middot; Leadership Survey</span>
                    </div>
                </div>

                {{-- ── SECTION 3: Comparisons & How-to Guides ── --}}
                <section class="b-section-anchor" id="comparisons-guides">
                    <div class="b-sec-header">
                        <div class="b-sec-title-wrap">
                            <span class="b-sec-icon-square"></span>
                            <h2 class="b-sec-title">Comparisons & How-to Guides</h2>
                        </div>
                        <a href="{{ route('frontend.blogs', ['category_id' => $blogCategories->firstWhere('slug', 'comparisons-guides')?->id ?? '']) }}" class="b-sec-link">
                            View 8 guides &rarr;
                        </a>
                    </div>

                    <div class="b-guides-stack">
                        @php
                            $guideIcons = [
                                ['bg' => '#1e293b', 'color' => '#38bdf8', 'icon' => 'fa-solid fa-code-compare'],
                                ['bg' => '#0f172a', 'color' => '#ffffff', 'icon' => 'fa-solid fa-x'],
                                ['bg' => '#14532d', 'color' => '#4ade80', 'icon' => 'fa-solid fa-laptop-code'],
                                ['bg' => '#3b0764', 'color' => '#c084fc', 'icon' => 'fa-solid fa-database'],
                                ['bg' => '#1e1b4b', 'color' => '#818cf8', 'icon' => 'fa-solid fa-shield-halved'],
                            ];
                        @endphp

                        @foreach($comparisonGuides as $idx => $gBlog)
                            @php $ic = $guideIcons[$idx % 5]; @endphp
                            <a href="{{ route('frontend.blogs.show', $gBlog->slug) }}" class="b-guide-item">
                                <div class="b-guide-left">
                                    <div class="b-guide-icon-sq" style="background: {{ $ic['bg'] }}; color: {{ $ic['color'] }};">
                                        <i class="{{ $ic['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="b-guide-title">{{ $gBlog->title }}</div>
                                        <div class="b-guide-sub">{{ Str::limit($gBlog->meta_description ?? 'Benchmark results & latency breakdowns', 80) }}</div>
                                    </div>
                                </div>
                                <div class="b-guide-arrow">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- ── SECTION 4: News & PR ── --}}
                <section class="b-section-anchor" id="news-pr">
                    <div class="b-sec-header">
                        <div class="b-sec-title-wrap">
                            <span class="b-sec-icon-square"></span>
                            <h2 class="b-sec-title">News & PR</h2>
                        </div>
                        <a href="{{ route('frontend.blogs', ['category_id' => $blogCategories->firstWhere('slug', 'news-pr')?->id ?? '']) }}" class="b-sec-link">
                            All news &rarr;
                        </a>
                    </div>

                    <div class="b-news-box">
                        @foreach($newsBlogs as $nBlog)
                            <a href="{{ route('frontend.blogs.show', $nBlog->slug) }}" class="b-news-row">
                                <div class="b-news-date">{{ $nBlog->published_at ? $nBlog->published_at->format('M d, Y') : 'JAN 12, 2026' }}</div>
                                <div class="b-news-info">
                                    <div class="b-news-title">{{ $nBlog->title }}</div>
                                    <div class="b-news-sub">{{ Str::limit($nBlog->meta_description ?? strip_tags($nBlog->body), 110) }}</div>
                                </div>
                                <div class="b-news-cta">
                                    Read Story &rarr;
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- ── SECTION 5: Founder Stories ── --}}
                <section class="b-section-anchor" id="founder-stories">
                    <div class="b-sec-header">
                        <div class="b-sec-title-wrap">
                            <span class="b-sec-icon-square"></span>
                            <h2 class="b-sec-title">Founder Stories</h2>
                        </div>
                        <a href="{{ route('frontend.blogs', ['category_id' => $blogCategories->firstWhere('slug', 'founder-stories')?->id ?? '']) }}" class="b-sec-link">
                            All founders &rarr;
                        </a>
                    </div>

                    <div class="b-founders-grid">
                        @php
                            $fCards = [
                                ['class' => 'f-card-plum', 'brand' => 'Prism AI', 'tag' => 'Founder Story', 'author' => 'Marcus Chen · Founder & CEO'],
                                ['class' => 'f-card-teal', 'brand' => 'Nexus AI', 'tag' => 'Q&A', 'author' => 'Sarah Lin · Co-founder & CTO'],
                                ['class' => 'f-card-rust', 'brand' => 'ComputeStack', 'tag' => 'Case Study', 'author' => 'David Vance · VP Engineering'],
                                ['class' => 'f-card-indigo', 'brand' => 'Synapse', 'tag' => 'Engineering Lead', 'author' => 'Tanya Meyer · Principal Architect'],
                            ];
                        @endphp

                        @foreach($founderStories as $idx => $fBlog)
                            @php $fc = $fCards[$idx % 4]; @endphp
                            <a href="{{ route('frontend.blogs.show', $fBlog->slug) }}" class="b-founder-card {{ $fc['class'] }}">
                                <div class="b-founder-top">
                                    <span class="b-founder-brand">{{ $fc['brand'] }}</span>
                                    <span class="b-founder-tag">{{ $fc['tag'] }}</span>
                                </div>
                                <h4 class="b-founder-title">{{ $fBlog->title }}</h4>
                                <p class="b-founder-excerpt">{{ Str::limit($fBlog->meta_description ?? strip_tags($fBlog->body), 140) }}</p>
                                <div class="b-founder-author">{{ $fc['author'] }}</div>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- ── SECTION 6: Research & Data ── --}}
                <section class="b-section-anchor" id="research-data">
                    <div class="b-sec-header">
                        <div class="b-sec-title-wrap">
                            <span class="b-sec-icon-square"></span>
                            <h2 class="b-sec-title">Research & Data</h2>
                        </div>
                        <a href="{{ route('frontend.blogs', ['category_id' => $blogCategories->firstWhere('slug', 'research-data')?->id ?? '']) }}" class="b-sec-link">
                            View reports &rarr;
                        </a>
                    </div>

                    <div class="b-research-grid">
                        {{-- Left Featured Report --}}
                        <div class="b-research-left-card">
                            <span class="b-res-tag">ANNUAL REPORT</span>
                            <h3 class="b-res-title">Annual AI Operations Report 2026</h3>
                            <p class="b-res-desc">1,200+ engineering leaders surveyed on compute spend, model governance, latency budgets, and tooling consolidation.</p>
                            
                            <div class="b-res-stats-row">
                                <div>
                                    <span class="b-res-stat-val">64%</span>
                                    <span class="b-res-stat-lbl">Enterprise models running open-weight variants</span>
                                </div>
                                <div>
                                    <span class="b-res-stat-val">3.4X</span>
                                    <span class="b-res-stat-lbl">Average increase in AI infrastructure budget</span>
                                </div>
                                <div>
                                    <span class="b-res-stat-val">$94k</span>
                                    <span class="b-res-stat-lbl">Median monthly inference spend per team</span>
                                </div>
                            </div>

                            <a href="javascript:void(0)" onclick="alert('Downloading TechAnalytica 2026 Annual AI Operations Report...');" class="btn-download-rep">
                                Download Free 48-Page Report
                            </a>

                            <div class="b-res-corner-circle"></div>
                        </div>

                        {{-- Right 4 Stacked Publications --}}
                        <div class="b-research-right-stack">
                            @php
                                $rTags = ['BENCHMARK', 'DATASET', 'ARCHITECTURE', 'GOVERNANCE'];
                                $repSlice = $researchReports->slice(1, 4)->values();
                            @endphp

                            @if($repSlice->count() > 0)
                                @foreach($repSlice as $idx => $rBlog)
                                    <a href="{{ route('frontend.blogs.show', $rBlog->slug) }}" class="b-res-pub-card">
                                        <span class="b-res-pub-tag">{{ $rTags[$idx % 4] }}</span>
                                        <div class="b-res-pub-title">{{ $rBlog->title }}</div>
                                        <div class="b-res-pub-date">{{ $rBlog->published_at ? $rBlog->published_at->format('M d, Y') : 'Jan 11, 2026' }} · {{ 14 + ($idx * 6) }} pp</div>
                                    </a>
                                @endforeach
                            @else
                                <a href="#" class="b-res-pub-card">
                                    <span class="b-res-pub-tag">BENCHMARK</span>
                                    <div class="b-res-pub-title">LLM Inference Cost Index: Q1 2026 Pricing Changes and Provider Margins</div>
                                    <div class="b-res-pub-date">Jan 11, 2026 · 14 pp</div>
                                </a>
                                <a href="#" class="b-res-pub-card">
                                    <span class="b-res-pub-tag">DATASET</span>
                                    <div class="b-res-pub-title">The 2026 State of Vector Databases: Latency, Recall, and Cost Benchmarks</div>
                                    <div class="b-res-pub-date">Jan 09, 2026 · 28 pp</div>
                                </a>
                                <a href="#" class="b-res-pub-card">
                                    <span class="b-res-pub-tag">ARCHITECTURE</span>
                                    <div class="b-res-pub-title">Survey: How 400 Engineering Teams Structure Their Production AI Stacks</div>
                                    <div class="b-res-pub-date">Jan 04, 2026 · 18 pp</div>
                                </a>
                                <a href="#" class="b-res-pub-card">
                                    <span class="b-res-pub-tag">GOVERNANCE</span>
                                    <div class="b-res-pub-title">Enterprise AI Governance Playbook: Audit Trails, Evals, and Red Teaming</div>
                                    <div class="b-res-pub-date">Dec 29, 2025 · 32 pp</div>
                                </a>
                            @endif
                        </div>
                    </div>
                </section>

                {{-- ── SECTION 7: Bottom CTA Banner ── --}}
                <div class="b-cta-banner">
                    <div>
                        <h2 class="b-cta-title">
                            Try TechAnalytica <span class="gradient-word">free</span> for 30 days.
                        </h2>
                        <p class="b-cta-sub">
                            Compare AI tools, access benchmarks, and discover software built for your stack.
                        </p>
                        <div class="b-cta-btns">
                            <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink-fill">Start Free Trial</a>
                            <a href="{{ route('frontend.tools.index') }}" class="btn-cta-outline-glass">Browse Directory</a>
                        </div>
                    </div>

                    {{-- Brand Dot Matrix Graphic --}}
                    <div class="b-cta-matrix-card">
                        <div class="b-dots-cluster">
                            <span class="b-cluster-dot" style="top: 10px; left: 18px; width: 14px; height: 14px; background: #ff3b7b; color: #ff3b7b;"></span>
                            <span class="b-cluster-dot" style="top: 8px; left: 48px; width: 16px; height: 16px; background: #ff735c; color: #ff735c;"></span>
                            <span class="b-cluster-dot" style="top: 14px; left: 78px; width: 12px; height: 12px; background: #a4358a; color: #a4358a;"></span>
                            <span class="b-cluster-dot" style="top: 38px; left: 28px; width: 18px; height: 18px; background: #ff735c; color: #ff735c;"></span>
                            <span class="b-cluster-dot" style="top: 40px; left: 62px; width: 15px; height: 15px; background: #ff3b7b; color: #ff3b7b;"></span>
                            <span class="b-cluster-dot" style="top: 64px; left: 42px; width: 13px; height: 13px; background: #a4358a; color: #a4358a;"></span>
                            <span class="b-cluster-dot" style="top: 60px; left: 74px; width: 14px; height: 14px; background: #ff735c; color: #ff735c;"></span>
                        </div>
                    </div>
                </div>

            </main>

        </div>

    @endif

</div>

<script>
    // Smooth scroll and active state sync for sidebar & pills
    document.addEventListener('DOMContentLoaded', function () {
        const sections = document.querySelectorAll('.b-section-anchor');
        const sidebarLinks = document.querySelectorAll('.b-sidebar-nav-link');
        const pillLinks = document.querySelectorAll('.b-pills-scroll .b-pill');

        window.addEventListener('scroll', function () {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 120;
                if (window.pageYOffset >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            if (current) {
                sidebarLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }
        });
    });
</script>
@endsection
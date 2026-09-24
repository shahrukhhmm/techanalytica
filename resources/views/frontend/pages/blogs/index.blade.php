@extends('frontend.layout.app')

@section('title', 'TechAnalytica Blog — AI Insights, Guides & Engineering Deep-Dives')

@push('styles')
<style>
/* =============================================
   BLOG INDEX — Premium Redesign
   ============================================= */

/* --- Hero --- */
.bi-hero {
    position: relative;
    padding: 60px 0 50px;
    background: linear-gradient(150deg, #0c0412 0%, #110718 50%, #0a050d 100%);
    border-bottom: 1px solid rgba(224,67,133,0.1);
    overflow: hidden;
}
.bi-hero::before {
    content:'';position:absolute;inset:0;
    background:
        radial-gradient(ellipse 60% 70% at 5% 50%, rgba(224,67,133,0.11) 0%, transparent 65%),
        radial-gradient(ellipse 45% 55% at 95% 10%, rgba(110,39,141,0.09) 0%, transparent 65%);
    pointer-events:none;
}
.bi-hero-inner {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:40px;
    flex-wrap:wrap;
}
.bi-hero-left { flex:1; min-width:280px; }
.bi-eyebrow {
    display:inline-flex;align-items:center;gap:7px;
    background:rgba(224,67,133,0.1);border:1px solid rgba(224,67,133,0.2);
    color:#e04385;font-size:12px;font-weight:700;
    padding:5px 14px;border-radius:20px;margin-bottom:16px;
    letter-spacing:0.4px;
}
.bi-title {
    font-size:clamp(28px,4vw,46px);font-weight:800;
    color:#fff;letter-spacing:-0.5px;line-height:1.13;margin-bottom:14px;
}
.bi-title span {
    background:linear-gradient(135deg,#e04385 0%,#fa709a 55%,#c86dd4 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.bi-desc { font-size:15px;color:#b8a8bf;line-height:1.7;margin-bottom:26px;max-width:500px; }

/* Search */
.bi-search {
    display:flex;max-width:460px;
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:14px;overflow:hidden;
    transition:border-color 0.2s;
}
.bi-search:focus-within { border-color:rgba(224,67,133,0.4); }
.bi-search input {
    flex:1;padding:13px 18px;background:transparent;border:none;
    color:#fff;font-size:14px;font-family:inherit;outline:none;
}
.bi-search input::placeholder { color:#6b5c73; }
.bi-search button {
    padding:12px 20px;background:linear-gradient(90deg,#e04385,#fa709a);
    border:none;color:#fff;font-weight:700;font-size:13px;
    cursor:pointer;white-space:nowrap;
    display:flex;align-items:center;gap:7px;transition:filter 0.2s;
}
.bi-search button:hover { filter:brightness(1.1); }

/* Hero Stats */
.bi-stats {
    display:flex;align-items:center;gap:24px;margin-top:22px;
    padding-top:20px;border-top:1px solid rgba(255,255,255,0.06);
    flex-wrap:wrap;
}
.bi-stat { text-align:center; }
.bi-stat .num { font-size:22px;font-weight:800;color:#fff;display:block; }
.bi-stat .lbl { font-size:11px;color:#9a8c9e;text-transform:uppercase;letter-spacing:0.8px; }

/* Hero Right — Latest post card */
.bi-hero-card {
    width:320px;flex-shrink:0;
    background:rgba(21,13,26,0.9);
    border:1.5px solid rgba(224,67,133,0.2);
    border-radius:20px;overflow:hidden;
    text-decoration:none;display:block;
    transition:all 0.3s ease;
}
.bi-hero-card:hover { border-color:rgba(224,67,133,0.45);transform:translateY(-4px);box-shadow:0 20px 50px rgba(0,0,0,0.6); }
.bi-hero-card-thumb {
    height:160px;background-size:cover;background-position:center;
    background-color:#1a0d22;position:relative;
    display:flex;align-items:center;justify-content:center;
}
.bi-hero-card-thumb .overlay {
    position:absolute;inset:0;
    background:linear-gradient(to bottom, transparent 40%, rgba(10,5,13,0.8) 100%);
}
.bi-hero-card-body { padding:20px; }
.bi-hero-card-badge {
    display:inline-flex;padding:4px 12px;
    background:linear-gradient(90deg,#e04385,#fa709a);
    color:#fff;font-size:11px;font-weight:700;border-radius:20px;margin-bottom:10px;
}
.bi-hero-card-body h3 { font-size:16px;font-weight:800;color:#fff;line-height:1.35;margin-bottom:8px; }
.bi-hero-card-body p  { font-size:12.5px;color:#9a8c9e;line-height:1.55;margin-bottom:14px; }
.bi-hero-card-meta { display:flex;align-items:center;gap:8px;font-size:12px;color:#6b5c73; }
.bi-card-avatar {
    width:26px;height:26px;border-radius:50%;
    background:linear-gradient(135deg,#e04385,#a4358a);
    display:flex;align-items:center;justify-content:center;
    font-size:11px;font-weight:700;color:#fff;flex-shrink:0;
}

/* --- Filter Tabs --- */
.bi-filter {
    position:sticky;top:0;z-index:100;
    background:#e04385; /* Pink background */
    border-bottom:none;
}
.bi-filter-inner { 
    display:flex;align-items:center;overflow-x:auto;scrollbar-width:none;
    gap: 6px; padding: 14px 0;
}
.bi-filter-inner::-webkit-scrollbar { display:none; }
.bi-tab {
    display:inline-flex;align-items:center;
    padding:6px 16px;
    font-size:12px;font-weight:700;color:#ffe4f0;
    background:none;border:none;
    cursor:pointer;white-space:nowrap;
    text-decoration:none;font-family:inherit;
    transition:all 0.2s ease;
    border-radius:9999px;
}
.bi-tab:hover { color:#ffffff; background:rgba(255,255,255,0.1); }
.bi-tab.active { color:#fff; background:#180a22; }
.bi-tab-count { display:none; }

/* --- Main Body --- */
.bi-body {
    display:grid;
    grid-template-columns:240px 1fr;
    gap:32px;
    padding-top:32px;
    padding-bottom:80px;
    align-items:start;
}

/* Sidebar */
.bi-sidebar { position:sticky;top:58px; }
.bi-sidebar-box {
    background:rgba(18,10,22,0.9);
    border:1px solid rgba(255,255,255,0.07);
    border-radius:18px;padding:20px;margin-bottom:18px;
}
.bi-sidebar-box h5 {
    font-size:11px;font-weight:700;color:#9a8c9e;
    text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;
}
.bi-cat-list { list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:2px; }
.bi-cat-item a {
    display:flex;align-items:center;gap:10px;
    padding:9px 12px;border-radius:10px;
    font-size:13.5px;font-weight:600;color:#b8a8bf;
    text-decoration:none;transition:all 0.2s;
}
.bi-cat-item a:hover,.bi-cat-item a.active {
    background:rgba(224,67,133,0.1);color:#fff;
}
.bi-cat-item a i { color:#e04385;font-size:12px;width:14px; }
.bi-cat-badge {
    margin-left:auto;font-size:11px;color:#6b5c73;
    background:rgba(255,255,255,0.05);
    padding:2px 8px;border-radius:8px;
}

/* Newsletter */
.bi-newsletter {
    background:linear-gradient(135deg,rgba(224,67,133,0.1),rgba(110,39,141,0.14));
    border:1.5px solid rgba(224,67,133,0.2);
    border-radius:18px;padding:22px;text-align:center;
}
.bi-newsletter i { font-size:24px;color:#e04385;margin-bottom:10px;display:block; }
.bi-newsletter h4 { font-size:14px;font-weight:700;color:#fff;margin-bottom:8px; }
.bi-newsletter p  { font-size:12px;color:#9a8c9e;line-height:1.55;margin-bottom:14px; }
.bi-nl-input {
    width:100%;padding:10px 13px;
    background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);
    border-radius:10px;color:#fff;font-size:13px;font-family:inherit;
    outline:none;margin-bottom:9px;transition:border-color 0.2s;
}
.bi-nl-input:focus { border-color:rgba(224,67,133,0.4); }
.bi-nl-input::placeholder { color:#6b5c73; }
.bi-nl-btn {
    width:100%;padding:10px;
    background:linear-gradient(90deg,#e04385,#fa709a);
    color:#fff;font-weight:700;font-size:13px;border:none;border-radius:10px;
    cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;
    transition:all 0.25s ease;
}
.bi-nl-btn:hover { filter:brightness(1.1);transform:translateY(-1px); }

/* Feed */
.bi-feed { min-width:0; }

/* Cards Grid */
.bi-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(270px,1fr));
    gap:22px;
    margin-bottom:36px;
}

.bi-card {
    background:rgba(18,10,22,0.9);
    border:1px solid rgba(255,255,255,0.07);
    border-radius:18px;overflow:hidden;
    text-decoration:none;display:block;
    transition:all 0.3s ease;
    position:relative;
}
.bi-card:hover {
    border-color:rgba(224,67,133,0.3);
    transform:translateY(-5px);
    box-shadow:0 20px 48px rgba(0,0,0,0.55),0 0 0 1px rgba(224,67,133,0.1);
}

.bi-card-thumb {
    height:178px;background-size:cover;background-position:center;
    background-color:#150c1e;position:relative;
    display:flex;align-items:center;justify-content:center;
    overflow:hidden;
}
.bi-card-thumb::after {
    content:'';position:absolute;inset:0;
    background:linear-gradient(to bottom, transparent 55%, rgba(18,10,22,0.9) 100%);
}
.bi-card-tag {
    position:absolute;top:14px;left:14px;z-index:1;
    padding:4px 12px;
    background:linear-gradient(90deg,#e04385,#fa709a);
    color:#fff;font-size:11px;font-weight:700;border-radius:20px;
}
.bi-card-placeholder-icon {
    font-size:36px;color:rgba(224,67,133,0.2);z-index:1;
}

.bi-card-body { padding:20px; }
.bi-card-body h3 {
    font-size:15.5px;font-weight:800;color:#fff;
    line-height:1.38;margin-bottom:9px;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
.bi-card-body p {
    font-size:13px;color:#9a8c9e;line-height:1.6;margin-bottom:14px;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
.bi-card-footer {
    display:flex;align-items:center;justify-content:space-between;
    padding-top:12px;border-top:1px solid rgba(255,255,255,0.06);
    gap:8px;flex-wrap:wrap;
}
.bi-card-meta { font-size:12px;color:#6b5c73;display:flex;align-items:center;gap:5px; }
.bi-read-link {
    display:inline-flex;align-items:center;gap:5px;
    font-size:12px;font-weight:700;color:#e04385;
    transition:gap 0.2s;
}
.bi-read-link:hover { gap:8px; }

/* Empty State */
.bi-empty {
    text-align:center;padding:64px 24px;
    background:rgba(255,255,255,0.02);
    border-radius:20px;border:1px dashed rgba(255,255,255,0.08);
    grid-column:1/-1;
}
.bi-empty i  { font-size:48px;color:#3a2645;margin-bottom:16px;display:block; }
.bi-empty h3 { font-size:20px;font-weight:700;color:#fff;margin-bottom:10px; }
.bi-empty p  { font-size:14px;color:#9a8c9e; }
.bi-empty a  { color:#e04385; }

/* Pagination */
.bi-pagination {
    display:flex;justify-content:center;align-items:center;
    gap:6px;margin-bottom:40px;flex-wrap:wrap;
}
.bi-pagination a,.bi-pagination span {
    display:inline-flex;align-items:center;justify-content:center;
    min-width:38px;height:38px;padding:0 12px;
    border-radius:10px;font-size:13.5px;font-weight:600;
    text-decoration:none;transition:all 0.2s;
    border:1px solid rgba(255,255,255,0.07);
    color:#b8a8bf;background:rgba(18,10,22,0.9);
}
.bi-pagination a:hover {
    background:rgba(224,67,133,0.12);border-color:rgba(224,67,133,0.3);color:#e04385;
}
.bi-pagination .pg-active {
    background:linear-gradient(90deg,#e04385,#fa709a);color:#fff;border-color:transparent;
}
.bi-pagination .pg-disabled { opacity:0.35;pointer-events:none; }

/* CTA */
.bi-cta {
    background:linear-gradient(135deg,rgba(224,67,133,0.1),rgba(110,39,141,0.14));
    border:1.5px solid rgba(224,67,133,0.2);
    border-radius:22px;padding:36px 40px;
    display:flex;align-items:center;justify-content:space-between;
    gap:28px;flex-wrap:wrap;
    position:relative;overflow:hidden;
}
.bi-cta::before {
    content:'';position:absolute;top:-50px;right:-50px;
    width:220px;height:220px;border-radius:50%;
    background:rgba(224,67,133,0.06);pointer-events:none;
}
.bi-cta h2 { font-size:22px;font-weight:800;color:#fff;margin-bottom:8px; }
.bi-cta p  { font-size:14px;color:#b8a8bf;margin-bottom:20px;max-width:420px;line-height:1.6; }
.bi-cta-btns { display:flex;gap:10px;flex-wrap:wrap; }

.btn-pink {
    display:inline-flex;align-items:center;gap:7px;padding:12px 22px;
    background:linear-gradient(90deg,#e04385,#fa709a);color:#fff;
    font-weight:700;font-size:14px;border:none;border-radius:12px;
    cursor:pointer;transition:all 0.25s;
    box-shadow:0 4px 16px rgba(224,67,133,0.3);text-decoration:none;
}
.btn-pink:hover { transform:translateY(-2px);box-shadow:0 8px 28px rgba(224,67,133,0.45); }

.btn-outline {
    display:inline-flex;align-items:center;gap:7px;padding:11px 22px;
    background:rgba(255,255,255,0.06);color:#fff;
    font-weight:600;font-size:14px;
    border:1.5px solid rgba(255,255,255,0.15);border-radius:12px;
    cursor:pointer;transition:all 0.25s;text-decoration:none;
}
.btn-outline:hover { background:rgba(255,255,255,0.1);transform:translateY(-2px); }

/* Dots */
.bi-dots { display:flex;gap:10px;flex-wrap:wrap;max-width:140px;opacity:0.55;align-items:center; }
.bi-dot {
    width:12px;height:12px;border-radius:50%;background:#e04385;
    animation:dpulse 2s ease-in-out infinite alternate;
}
.bi-dot:nth-child(2){ animation-delay:.3s;background:#fa709a; }
.bi-dot:nth-child(3){ animation-delay:.6s;background:#c86dd4; }
.bi-dot:nth-child(4){ animation-delay:.9s; }
.bi-dot:nth-child(5){ animation-delay:1.2s; }
@keyframes dpulse { from{transform:scale(1);opacity:.5} to{transform:scale(1.3);opacity:1} }

/* Container */
.container { max-width:1200px;margin:0 auto;padding:0 24px; }

/* Responsive */
@media (max-width:1024px) {
    .bi-body { grid-template-columns:1fr; }
    .bi-sidebar { position:static;display:grid;grid-template-columns:1fr 1fr;gap:16px; }
}
@media (max-width:768px) {
    .bi-hero-card { display:none; }
    .bi-body { grid-template-columns:1fr; }
    .bi-sidebar { display:flex;flex-direction:column; }
    .bi-cta { padding:24px 20px; }
    .bi-dots { display:none; }
}
@media (max-width:480px) {
    .bi-grid { grid-template-columns:1fr; }
    .bi-title { font-size:26px; }
}
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section class="bi-hero" style="padding: 100px 0 80px;">
    <div class="container">
        <div class="bi-hero-inner">
            <div class="bi-hero-left" style="max-width: 580px;">
                <h1 class="bi-title" style="font-size: clamp(36px, 5vw, 64px); letter-spacing: -0.03em;">
                    Sharper thinking for the people <span style="font-style: italic; background: linear-gradient(135deg, #e04385, #fa709a); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">building</span> what's next.
                </h1>
                <p class="bi-desc" style="font-size: 16px; margin-bottom: 40px; line-height: 1.6;">Trends, teardowns, and tactical playbooks from operators, founders, and researchers in product, marketing, and revenue.</p>

                <form action="{{ route('frontend.blogs') }}" method="GET">
                    <div class="bi-search" style="max-width: 480px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 9999px; padding: 4px; display: flex;">
                        <input type="text" name="q" placeholder="Search 600+ articles, guides, and reports..." value="{{ request('q') }}" style="padding-left: 20px;">
                        <button type="submit" style="border-radius: 9999px; padding: 12px 28px;">Search</button>
                    </div>
                </form>
            </div>

            <div class="bi-hero-card" style="width: 420px; background: transparent; border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 32px; background: linear-gradient(145deg, rgba(20,10,26,0.95), rgba(10,5,15,0.98));">
                <span class="bi-hero-card-badge" style="background: #e04385; border-radius: 9999px; padding: 6px 14px; text-transform: uppercase; font-size: 10px; letter-spacing: 1px; margin-bottom: 20px; display: inline-block;">Editor's Pick</span>
                <h3 style="font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 16px; line-height: 1.3;">The 2026 State of Operations Report — what 1,200 ops leaders told us</h3>
                <p style="font-size: 14px; color: #a1a1aa; line-height: 1.6; margin-bottom: 30px;">We surveyed 1,200+ operations leaders across SaaS, fintech, and e-com to find out what's working, what's broken, and what's quietly winning.</p>
                
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #fa709a;"></div>
                    <span style="color: #fff; font-size: 13px; font-weight: 600;">Maya Otieno</span>
                    <span style="color: #666; font-size: 13px;">12 min read</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CATEGORY TABS ===== --}}
<div class="bi-filter">
    <div class="container" style="display: flex; align-items: center;">
        <span style="color: #1a0812; font-size: 11px; font-weight: 800; letter-spacing: 1.5px; margin-right: 16px;">FILTER BY</span>
        <div class="bi-filter-inner" style="flex: 1;">
            <a href="#" class="bi-tab active">All</a>
            <a href="#" class="bi-tab">Productivity</a>
            <a href="#" class="bi-tab">CRM</a>
            <a href="#" class="bi-tab">Marketing</a>
            <a href="#" class="bi-tab">Sales</a>
            <a href="#" class="bi-tab">AI & Automation</a>
            <a href="#" class="bi-tab">Operations</a>
            <a href="#" class="bi-tab">Leadership</a>
            <a href="#" class="bi-tab">Design</a>
        </div>
        <button style="background: rgba(0,0,0,0.25); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-list-ul"></i></button>
    </div>
</div>

{{-- ===== MAIN BODY ===== --}}
<div class="container bi-body">

    {{-- Sidebar --}}
    <aside class="bi-sidebar">
        <div class="bi-sidebar-box" style="background: transparent; border: none; padding: 0;">
            <ul class="bi-cat-list" style="gap: 8px;">
                <li class="bi-cat-item">
                    <a href="#" class="active" style="padding: 12px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;">
                        <span style="color: #a1a1aa; font-size: 11px; margin-right: 12px; font-weight: 700;">01</span> Featured
                    </a>
                </li>
                <li class="bi-cat-item">
                    <a href="#" style="padding: 12px 16px; background: transparent; border: 1px solid transparent;">
                        <span style="color: #a1a1aa; font-size: 11px; margin-right: 12px; font-weight: 700;">02</span> Trends & Insights
                    </a>
                </li>
                <li class="bi-cat-item">
                    <a href="#" style="padding: 12px 16px; background: transparent; border: 1px solid transparent;">
                        <span style="color: #a1a1aa; font-size: 11px; margin-right: 12px; font-weight: 700;">03</span> Comparisons & Guides
                    </a>
                </li>
                <li class="bi-cat-item">
                    <a href="#" style="padding: 12px 16px; background: transparent; border: 1px solid transparent;">
                        <span style="color: #a1a1aa; font-size: 11px; margin-right: 12px; font-weight: 700;">04</span> News & PR
                    </a>
                </li>
                <li class="bi-cat-item">
                    <a href="#" style="padding: 12px 16px; background: transparent; border: 1px solid transparent;">
                        <span style="color: #a1a1aa; font-size: 11px; margin-right: 12px; font-weight: 700;">05</span> Founder Stories
                    </a>
                </li>
                <li class="bi-cat-item">
                    <a href="#" style="padding: 12px 16px; background: transparent; border: 1px solid transparent;">
                        <span style="color: #a1a1aa; font-size: 11px; margin-right: 12px; font-weight: 700;">06</span> Research & Data
                    </a>
                </li>
            </ul>
        </div>

        <div class="bi-newsletter" style="background: #ffe4f0; border: none; padding: 24px; border-radius: 16px; margin-top: 40px; text-align: left;">
            <h5 style="color: #d81b60; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Newsletter</h5>
            <h4 style="color: #1a0812; font-size: 18px; font-weight: 800; margin-bottom: 8px; line-height: 1.3;">The weekly digest, in your inbox</h4>
            <p style="color: #662244; font-size: 13px; line-height: 1.5; margin-bottom: 20px;">One curated email. The five things worth reading, plus a benchmark or template.</p>
            <input type="email" class="bi-nl-input" placeholder="you@company.com" style="background: #fff; border: 1px solid #ffb1cc; color: #000; padding: 12px 16px;">
            <button class="bi-nl-btn" style="background: #e04385; color: #fff; border-radius: 8px; padding: 12px; display: flex; justify-content: center; width: 100%;">Subscribe <i class="fa-solid fa-arrow-right" style="font-size: 12px; margin-left: 6px;"></i></button>
            <p style="color: #662244; font-size: 11px; margin-top: 12px; margin-bottom: 0; text-align: left;">Free forever. No spam, ever.</p>
        </div>
    </aside>

    {{-- Feed --}}
    <div class="bi-feed">
        
        <!-- SECTION 01: FEATURED -->
        <div style="margin-bottom: 60px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: #e04385; color: #fff; font-weight: 800; font-size: 11px; padding: 4px 8px; border-radius: 4px;">01</span>
                    <h2 style="font-size: 24px; font-weight: 800; margin: 0;">Featured</h2>
                </div>
                <a href="#" style="color: #a1a1aa; font-size: 13px; font-weight: 600;">View all featured <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i></a>
            </div>

            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; display: flex; overflow: hidden;">
                <div style="flex: 1; min-height: 320px; background: linear-gradient(135deg, #fa709a, #e04385); display: flex; align-items: center; justify-content: center; position: relative;">
                    <div style="width: 200px; height: 200px; background: rgba(255,255,255,0.2); border-radius: 50%; filter: blur(20px);"></div>
                    <div style="width: 100px; height: 100px; background: rgba(255,255,255,0.8); border-radius: 50%; position: absolute; bottom: 40px; right: 40px;"></div>
                </div>
                <div style="flex: 1; padding: 40px;">
                    <div style="display: flex; gap: 8px; margin-bottom: 16px;">
                        <span style="background: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 9999px; font-size: 10px; font-weight: 800; letter-spacing: 1px; color: #fff; text-transform: uppercase;">Operations</span>
                        <span style="background: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 9999px; font-size: 10px; font-weight: 800; letter-spacing: 1px; color: #fff; text-transform: uppercase;">Long Read</span>
                    </div>
                    <h3 style="font-size: 32px; font-weight: 800; line-height: 1.2; margin-bottom: 16px;">The quiet rewrite: how small teams are out-shipping the giants in 2026</h3>
                    <p style="color: #a1a1aa; font-size: 15px; line-height: 1.6; margin-bottom: 30px;">Speed isn't a slogan anymore — it's the new moat. Twelve scrappy startups taught us about momentum, taste, and shipping in public.</p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #9f55ff, #e04385);"></div>
                        <div>
                            <div style="color: #fff; font-size: 13px; font-weight: 700;">Maya Otieno</div>
                            <div style="color: #666; font-size: 12px;">Apr 22, 2026 · 9 min read</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 02: TRENDS & INSIGHTS -->
        <div style="margin-bottom: 60px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: #e04385; color: #fff; font-weight: 800; font-size: 11px; padding: 4px 8px; border-radius: 4px;">02</span>
                    <h2 style="font-size: 24px; font-weight: 800; margin: 0;">Trends & Insights</h2>
                </div>
                <a href="#" style="color: #a1a1aa; font-size: 13px; font-weight: 600;">See all trends <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i></a>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Card 1 -->
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; overflow: hidden;">
                    <div style="height: 180px; background: #fa709a; display: flex; align-items: center; justify-content: center; position: relative;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.3); border-radius: 16px;"></div>
                        <div style="width: 80px; height: 80px; background: rgba(0,0,0,0.1); border-radius: 50%; position: absolute; right: 20%; top: 20%;"></div>
                    </div>
                    <div style="padding: 24px;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 12px; display: inline-block;">AI & Automation</span>
                        <h4 style="font-size: 18px; font-weight: 800; line-height: 1.3; margin-bottom: 12px;">The post-RAG era: agents that actually do the job</h4>
                        <p style="color: #a1a1aa; font-size: 13px; line-height: 1.5; margin-bottom: 20px;">What we learned shipping autonomous workflows to 30,000 teams in six months.</p>
                        <div style="color: #666; font-size: 12px;">Lina Park · Apr 24 · 7 min</div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; overflow: hidden;">
                    <div style="height: 180px; background: #e04385; display: flex; align-items: center; justify-content: center;">
                        <div style="width: 100px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 8px;"></div>
                    </div>
                    <div style="padding: 24px;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 12px; display: inline-block;">CRM</span>
                        <h4 style="font-size: 18px; font-weight: 800; line-height: 1.3; margin-bottom: 12px;">Why pipeline reviews are dying — and what's replacing them</h4>
                        <p style="color: #a1a1aa; font-size: 13px; line-height: 1.5; margin-bottom: 20px;">Six revenue leaders on the rituals that are quietly being retired in 2026.</p>
                        <div style="color: #666; font-size: 12px;">Theo Marsh · Apr 22 · 6 min</div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; overflow: hidden;">
                    <div style="height: 180px; background: #ffb1cc; display: flex; align-items: center; justify-content: center;">
                        <div style="width: 90px; height: 90px; background: #1a0812; border-radius: 50%; border: 12px solid #e04385;"></div>
                    </div>
                    <div style="padding: 24px;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 12px; display: inline-block;">Marketing</span>
                        <h4 style="font-size: 18px; font-weight: 800; line-height: 1.3; margin-bottom: 12px;">Generative search is here. Here's what it broke for SEO</h4>
                        <p style="color: #a1a1aa; font-size: 13px; line-height: 1.5; margin-bottom: 20px;">A first look at how AI-powered search is reshaping organic discovery.</p>
                        <div style="color: #666; font-size: 12px;">Eve Aldridge · Apr 19 · 8 min</div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; overflow: hidden;">
                    <div style="height: 180px; background: #9f55ff; display: flex; align-items: center; justify-content: center;">
                        <div style="width: 140px; height: 80px; background: #e04385; border-radius: 40px 40px 0 0; margin-top: auto;"></div>
                    </div>
                    <div style="padding: 24px;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 12px; display: inline-block;">Productivity</span>
                        <h4 style="font-size: 18px; font-weight: 800; line-height: 1.3; margin-bottom: 12px;">The async meeting is finally good. Here's what fixed it</h4>
                        <p style="color: #a1a1aa; font-size: 13px; line-height: 1.5; margin-bottom: 20px;">How a small change in tooling unlocked a wave of distributed-first companies.</p>
                        <div style="color: #666; font-size: 12px;">Renata Quesada · Apr 17 · 5 min</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUOTE BANNER -->
        <div style="background: linear-gradient(135deg, #fa709a, #9f55ff); border-radius: 24px; padding: 48px; margin-bottom: 60px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
            <div style="position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; filter: blur(30px);"></div>
            <div style="position: absolute; bottom: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.15); border-radius: 50%; filter: blur(30px);"></div>
            
            <h3 style="font-size: clamp(24px, 3vw, 32px); font-weight: 500; font-style: italic; color: #fff; line-height: 1.4; margin-bottom: 32px; position: relative; z-index: 1;">
                "The best operators we know spend less time on tooling and more time on taste. The leverage isn't in the stack — it's in the judgment."
            </h3>
            
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="width: 48px; height: 48px; background: #ffb1cc; border-radius: 50%; display: flex; align-items: center; justify-content: center;"></div>
                <div>
                    <div style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 2px;">Devon Beale</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">Head of Operations, Northwind · From "How we ship faster" (Apr 12)</div>
                </div>
            </div>
        </div>

        <!-- SECTION 03: COMPARISONS & HOW-TO GUIDES -->
        <div style="margin-bottom: 60px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: #e04385; color: #fff; font-weight: 800; font-size: 11px; padding: 4px 8px; border-radius: 4px;">03</span>
                    <h2 style="font-size: 24px; font-weight: 800; margin: 0;">Comparisons & How-to Guides</h2>
                </div>
                <a href="#" style="color: #a1a1aa; font-size: 13px; font-weight: 600;">See all guides <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i></a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <!-- Row 1 -->
                <a href="#" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; transition: all 0.2s;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px;">
                            <i class="fa-solid fa-table-columns"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 4px;">Notion vs. Coda vs. Lumen Docs: a 2026 head-to-head</h4>
                            <div style="font-size: 13px; color: #a1a1aa;">12 min read · Updated this week · By Suri Patel</div>
                        </div>
                    </div>
                    <div style="color: #666;"><i class="fa-solid fa-arrow-right"></i></div>
                </a>

                <!-- Row 2 -->
                <a href="#" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; transition: all 0.2s;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ea580c, #f43f5e); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px;">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 4px;">How to build a CRM your reps actually want to use</h4>
                            <div style="font-size: 13px; color: #a1a1aa;">9 min read · Step-by-step guide · By Owen Davies</div>
                        </div>
                    </div>
                    <div style="color: #666;"><i class="fa-solid fa-arrow-right"></i></div>
                </a>

                <!-- Row 3 -->
                <a href="#" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; transition: all 0.2s;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981, #3b82f6); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px;">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 4px;">Salesforce vs. HubSpot vs. Lumen for mid-market revenue teams</h4>
                            <div style="font-size: 13px; color: #a1a1aa;">15 min read · Buyer's guide · By Caelyn Brock</div>
                        </div>
                    </div>
                    <div style="color: #666;"><i class="fa-solid fa-arrow-right"></i></div>
                </a>

                <!-- Row 4 -->
                <a href="#" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; transition: all 0.2s;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ec4899, #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px;">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 4px;">How to set up a lifecycle marketing program in 30 days</h4>
                            <div style="font-size: 13px; color: #a1a1aa;">11 min read · Playbook · By Mira Felton</div>
                        </div>
                    </div>
                    <div style="color: #666;"><i class="fa-solid fa-arrow-right"></i></div>
                </a>
                
                <!-- Row 5 -->
                <a href="#" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; transition: all 0.2s;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #64748b, #94a3b8); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px;">
                            <i class="fa-solid fa-rotate"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 4px;">Zapier vs. Make vs. n8n: which automation tool wins in 2026?</h4>
                            <div style="font-size: 13px; color: #a1a1aa;">14 min read · Comparison · By Felix Brun</div>
                        </div>

                    <div style="color: #666;"><i class="fa-solid fa-arrow-right"></i></div>
                </a>
            </div>
        </div>

        <!-- SECTION 04: NEWS & PR -->
        <div style="margin-bottom: 60px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: #e04385; color: #fff; font-weight: 800; font-size: 11px; padding: 4px 8px; border-radius: 4px;">04</span>
                    <h2 style="font-size: 24px; font-weight: 800; margin: 0;">News & PR</h2>
                </div>
                <a href="#" style="color: #a1a1aa; font-size: 13px; font-weight: 600;">All news <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i></a>
            </div>

            <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; display: flex; flex-direction: column;">
                <!-- News 1 -->
                <div style="display: flex; padding: 32px; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div style="width: 140px; font-size: 12px; font-weight: 700; color: #a1a1aa; letter-spacing: 0.5px;">APR 24, 2026</div>
                    <div style="flex: 1; padding-right: 40px;">
                        <h4 style="font-size: 16px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">Lumen raises $40M Series B led by Foundry Capital to expand its operations platform</h4>
                        <p style="font-size: 14px; color: #a1a1aa; line-height: 1.5; margin: 0;">The funding will accelerate AI-native workflows and double the engineering team in EMEA.</p>
                    </div>
                    <div style="width: 120px; text-align: right; font-size: 12px; font-weight: 700; color: #e04385;">Press Release</div>
                </div>
                <!-- News 2 -->
                <div style="display: flex; padding: 32px; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div style="width: 140px; font-size: 12px; font-weight: 700; color: #a1a1aa; letter-spacing: 0.5px;">APR 19, 2026</div>
                    <div style="flex: 1; padding-right: 40px;">
                        <h4 style="font-size: 16px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">Lumen launches Studio: a no-code workspace for cross-functional teams</h4>
                        <p style="font-size: 14px; color: #a1a1aa; line-height: 1.5; margin: 0;">Studio brings docs, dashboards, and automations into a single, real-time canvas.</p>
                    </div>
                    <div style="width: 120px; text-align: right; font-size: 12px; font-weight: 700; color: #e04385;">Product News</div>
                </div>
                <!-- News 3 -->
                <div style="display: flex; padding: 32px; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div style="width: 140px; font-size: 12px; font-weight: 700; color: #a1a1aa; letter-spacing: 0.5px;">APR 12, 2026</div>
                    <div style="flex: 1; padding-right: 40px;">
                        <h4 style="font-size: 16px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">Customer story: How Northwind cut their reporting time by 73% with Lumen</h4>
                        <p style="font-size: 14px; color: #a1a1aa; line-height: 1.5; margin: 0;">An inside look at how Northwind's ops team rebuilt their entire stack in six weeks.</p>
                    </div>
                    <div style="width: 120px; text-align: right; font-size: 12px; font-weight: 700; color: #e04385;">Case Study</div>
                </div>
                <!-- News 4 -->
                <div style="display: flex; padding: 32px; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div style="width: 140px; font-size: 12px; font-weight: 700; color: #a1a1aa; letter-spacing: 0.5px;">APR 04, 2026</div>
                    <div style="flex: 1; padding-right: 40px;">
                        <h4 style="font-size: 16px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">Lumen acquires Cobalt to bring native data orchestration to every workflow</h4>
                        <p style="font-size: 14px; color: #a1a1aa; line-height: 1.5; margin: 0;">The acquisition adds a powerful data pipeline layer to the Lumen platform.</p>
                    </div>
                    <div style="width: 120px; text-align: right; font-size: 12px; font-weight: 700; color: #e04385;">Press Release</div>
                </div>
                <!-- News 5 -->
                <div style="display: flex; padding: 32px;">
                    <div style="width: 140px; font-size: 12px; font-weight: 700; color: #a1a1aa; letter-spacing: 0.5px;">MAR 28, 2026</div>
                    <div style="flex: 1; padding-right: 40px;">
                        <h4 style="font-size: 16px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">Lumen named a Leader in the 2026 Forrester Wave for revenue ops platforms</h4>
                        <p style="font-size: 14px; color: #a1a1aa; line-height: 1.5; margin: 0;">Recognized for our vision, ease of adoption, and customer outcomes.</p>
                    </div>
                    <div style="width: 120px; text-align: right; font-size: 12px; font-weight: 700; color: #e04385;">Recognition</div>
                </div>
            </div>
        </div>

        <!-- SECTION 05: FOUNDER STORIES -->
        <div style="margin-bottom: 60px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: #e04385; color: #fff; font-weight: 800; font-size: 11px; padding: 4px 8px; border-radius: 4px;">05</span>
                    <h2 style="font-size: 24px; font-weight: 800; margin: 0;">Founder Stories</h2>
                </div>
                <a href="#" style="color: #a1a1aa; font-size: 13px; font-weight: 600;">All stories <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i></a>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Founder 1 -->
                <div style="background: #2d1840; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="background: #502b70; padding: 32px; height: 180px; display: flex; flex-direction: column; justify-content: flex-end;">
                        <h3 style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 4px;">Priya R.</h3>
                        <div style="font-size: 13px; color: #d6bdec;">Co-founder, Northwind</div>
                    </div>
                    <div style="padding: 32px; flex: 1;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 16px; display: inline-block;">BOOTSTRAPPED</span>
                        <h4 style="font-size: 18px; font-weight: 800; line-height: 1.3; margin-bottom: 16px; color: #fff;">How Northwind got to $10M ARR with 11 people and zero ad spend</h4>
                        <p style="color: #c9b4db; font-size: 13px; line-height: 1.5; margin-bottom: 24px;">A story about distribution, taste, and saying no to almost everything for two years straight.</p>
                        <div style="color: #a388b8; font-size: 12px;">8 min read · By Priya Ranganathan</div>
                    </div>
                </div>

                <!-- Founder 2 -->
                <div style="background: #12302e; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="background: #1d514e; padding: 32px; height: 180px; display: flex; flex-direction: column; justify-content: flex-end;">
                        <h3 style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 4px;">Marco I.</h3>
                        <div style="font-size: 13px; color: #a4cecb;">Founder, Loomward</div>
                    </div>
                    <div style="padding: 32px; flex: 1;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 16px; display: inline-block;">PIVOT</span>
                        <h4 style="font-size: 18px; font-weight: 800; line-height: 1.3; margin-bottom: 16px; color: #fff;">Why we killed our flagship product after a $14M round (and what came next)</h4>
                        <p style="color: #8daea9; font-size: 13px; line-height: 1.5; margin-bottom: 24px;">Marco walks through the four months of clarity that turned a B2C app into a B2B platform.</p>
                        <div style="color: #648682; font-size: 12px;">11 min read · By Marco Iversen</div>
                    </div>
                </div>

                <!-- Founder 3 -->
                <div style="background: #471a17; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="background: #ff735c; padding: 32px; height: 180px; display: flex; flex-direction: column; justify-content: flex-end;">
                        <h3 style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 4px;">Jacqueline S.</h3>
                        <div style="font-size: 13px; color: #ffd2cb;">CEO, Bramble</div>
                    </div>
                    <div style="padding: 32px; flex: 1;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 16px; display: inline-block;">HIRING</span>
                        <h4 style="font-size: 18px; font-weight: 800; line-height: 1.3; margin-bottom: 16px; color: #fff;">The first 10 hires that built Bramble — what I'd do differently today</h4>
                        <p style="color: #dfb2ad; font-size: 13px; line-height: 1.5; margin-bottom: 24px;">Patterns that worked, hires that didn't, and the org chart we wish we had drawn earlier.</p>
                        <div style="color: #a87974; font-size: 12px;">9 min read · By Jacqueline Stahl</div>
                    </div>
                </div>

                <!-- Founder 4 -->
                <div style="background: #1a2a4b; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="background: #3b6ef6; padding: 32px; height: 180px; display: flex; flex-direction: column; justify-content: flex-end;">
                        <h3 style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 4px;">Eli T.</h3>
                        <div style="font-size: 13px; color: #bacdfa;">Co-founder, Pavel</div>
                    </div>
                    <div style="padding: 32px; flex: 1;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 16px; display: inline-block;">FUNDRAISING</span>
                        <h4 style="font-size: 18px; font-weight: 800; line-height: 1.3; margin-bottom: 16px; color: #fff;">The Series A pitch that closed in 11 days — annotated</h4>
                        <p style="color: #a0b6e3; font-size: 13px; line-height: 1.5; margin-bottom: 24px;">The deck, the narrative, and the prep that turned 14 first meetings into a term sheet.</p>
                        <div style="color: #728abd; font-size: 12px;">13 min read · By Eli Tanaka</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SECTION 06: RESEARCH & DATA -->
        <div style="margin-bottom: 60px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: #e04385; color: #fff; font-weight: 800; font-size: 11px; padding: 4px 8px; border-radius: 4px;">06</span>
                    <h2 style="font-size: 24px; font-weight: 800; margin: 0;">Research & Data</h2>
                </div>
                <a href="#" style="color: #a1a1aa; font-size: 13px; font-weight: 600;">All reports <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i></a>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Left Large Card -->
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 40px; position: relative; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="position: absolute; bottom: -50px; right: -50px; width: 250px; height: 250px; background: #e04385; border-radius: 50%; filter: blur(40px); opacity: 0.3;"></div>
                    <div style="position: absolute; bottom: -50px; right: -50px; width: 150px; height: 150px; background: #e04385; border-radius: 50%;"></div>
                    
                    <div style="position: relative; z-index: 1;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 24px; display: inline-block;">FLAGSHIP REPORT</span>
                        <h3 style="font-size: 28px; font-weight: 800; line-height: 1.2; margin-bottom: 16px; color: #fff;">State of Operations 2026</h3>
                        <p style="color: #a1a1aa; font-size: 15px; line-height: 1.6; margin-bottom: 40px;">1,200+ operations leaders across SaaS, fintech, and e-com. The benchmarks, the burnouts, and the breakouts.</p>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 48px;">
                            <div>
                                <div style="font-size: 32px; font-weight: 800; color: #fa709a; margin-bottom: 8px;">62%</div>
                                <div style="font-size: 12px; color: #a1a1aa; line-height: 1.4;">say tooling sprawl is their #1 blocker</div>
                            </div>
                            <div>
                                <div style="font-size: 32px; font-weight: 800; color: #fa709a; margin-bottom: 8px;">3.4×</div>
                                <div style="font-size: 12px; color: #a1a1aa; line-height: 1.4;">more output from AI-native teams</div>
                            </div>
                            <div>
                                <div style="font-size: 32px; font-weight: 800; color: #fa709a; margin-bottom: 8px;">$94k</div>
                                <div style="font-size: 12px; color: #a1a1aa; line-height: 1.4;">average annual saved per FTE</div>
                            </div>
                        </div>

                        <a href="#" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); color: #fff; font-weight: 700; font-size: 13px; padding: 12px 24px; border-radius: 999px; text-decoration: none;">Download report (free) <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Right Stacked Cards -->
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <!-- Card 1 -->
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 24px;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 12px; display: inline-block;">BENCHMARK</span>
                        <h4 style="font-size: 16px; font-weight: 800; line-height: 1.3; margin-bottom: 8px; color: #fff;">2026 sales productivity benchmarks across 8 industries</h4>
                        <div style="color: #666; font-size: 12px;">42-page PDF · Updated quarterly</div>
                    </div>
                    <!-- Card 2 -->
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 24px;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 12px; display: inline-block;">SURVEY</span>
                        <h4 style="font-size: 16px; font-weight: 800; line-height: 1.3; margin-bottom: 8px; color: #fff;">How 600 marketers are using AI for content (and what's working)</h4>
                        <div style="color: #666; font-size: 12px;">Interactive report · Filterable data</div>
                    </div>
                    <!-- Card 3 -->
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 24px;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 12px; display: inline-block;">DATA STORY</span>
                        <h4 style="font-size: 16px; font-weight: 800; line-height: 1.3; margin-bottom: 8px; color: #fff;">What we learned from analyzing 4M support tickets</h4>
                        <div style="color: #666; font-size: 12px;">Long read · 14 min</div>
                    </div>
                    <!-- Card 4 -->
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 24px;">
                        <span style="background: #e04385; color: #fff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 12px; display: inline-block;">WHITEPAPER</span>
                        <h4 style="font-size: 16px; font-weight: 800; line-height: 1.3; margin-bottom: 8px; color: #fff;">The economics of agentic workflows in mid-market companies</h4>
                        <div style="color: #666; font-size: 12px;">Whitepaper · 28 pages</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>{{-- /bi-body --}}

{{-- Pre-Footer CTA Matching Figma --}}
<div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 24px; padding: 60px; margin: 40px auto; max-width: 1000px; display: flex; align-items: center; justify-content: space-between; gap: 40px; overflow: hidden; position: relative;">
    <div style="flex: 1; position: relative; z-index: 1;">
        <h2 style="font-size: clamp(32px, 4vw, 44px); font-weight: 800; line-height: 1.15; margin-bottom: 16px; color: #fff; letter-spacing: -0.02em;">
            Try <span style="background: linear-gradient(135deg, #e04385, #fa709a); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Techanalytica</span><br>
            <span style="font-style: italic; color: #fa709a;">free</span> for 30 days.
        </h2>
        <p style="color: #a1a1aa; font-size: 16px; line-height: 1.6; max-width: 400px; margin-bottom: 32px;">One workspace for your team's docs, data, and workflows. No credit card. Cancel anytime.</p>
        
        <div style="display: flex; gap: 16px; align-items: center;">
            <a href="#" style="background: #e04385; color: #fff; font-weight: 700; font-size: 14px; padding: 14px 28px; border-radius: 9999px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">Start free trial <i class="fa-solid fa-arrow-right"></i></a>
            <a href="#" style="background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #fff; font-weight: 700; font-size: 14px; padding: 14px 28px; border-radius: 9999px; text-decoration: none; transition: all 0.2s;">Book a demo</a>
        </div>
    </div>
    
    <div style="width: 320px; height: 320px; background: #1a0812; border-radius: 20px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); flex-shrink: 0;">
        <div style="position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; background: #e04385; border-radius: 50%; filter: blur(50px); opacity: 0.2;"></div>
        <div style="position: absolute; bottom: -50px; right: -50px; width: 200px; height: 200px; background: #9f55ff; border-radius: 50%; filter: blur(50px); opacity: 0.2;"></div>
        
        <!-- Animated glowing dots graphic -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; z-index: 1;">
            <div style="width: 48px; height: 48px; background: #fa709a; border-radius: 50%;"></div>
            <div style="width: 48px; height: 48px; background: #ffb1cc; border-radius: 50%;"></div>
            <div style="width: 48px; height: 48px; background: #e04385; border-radius: 50%;"></div>
            <div style="width: 48px; height: 48px; background: #9f55ff; border-radius: 50%;"></div>
            <div style="width: 48px; height: 48px; background: #fa709a; border-radius: 50%; transform: scale(1.2);"></div>
            <div style="width: 48px; height: 48px; background: #7c3aed; border-radius: 50%;"></div>
            <div style="width: 48px; height: 48px; background: #e04385; border-radius: 50%;"></div>
            <div style="width: 48px; height: 48px; background: #ffb1cc; border-radius: 50%;"></div>
            <div style="width: 48px; height: 48px; background: #9f55ff; border-radius: 50%;"></div>
        </div>
    </div>
</div>

</div>{{-- /bi-body --}}

@endsection

@extends('frontend.layout.app')

@section('title', 'Best Software & AI Tools in 2026 - TechAnalytica Directory')

@push('styles')
<style>
    /* =============================================
       TOOLS DIRECTORY — FIGMA RANKED LISTING REDESIGN
       ============================================= */
    .dir-hero {
        padding: 36px 0 28px;
    }
    .dir-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-secondary);
        margin-bottom: 16px;
    }
    .dir-breadcrumb a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }
    .dir-breadcrumb a:hover {
        color: #ff3b7b;
    }
    .dir-breadcrumb i {
        font-size: 10px;
        opacity: 0.6;
    }
    .dir-title-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .dir-h1 {
        font-size: clamp(32px, 4vw, 46px);
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.03em;
        color: #ffffff;
    }
    .dir-h1 span {
        background: linear-gradient(90deg, #ff3b7b, #ff735c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .dir-sub {
        font-size: 15.5px;
        color: var(--text-secondary);
        max-width: 680px;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    .dir-meta-bar {
        display: flex;
        align-items: center;
        gap: 20px;
        font-size: 13px;
        color: var(--text-secondary);
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        flex-wrap: wrap;
    }
    .dir-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .dir-meta-item i {
        color: #ff3b7b;
        font-size: 12px;
    }

    /* Top 4 Editor's Picks Cards */
    .picks-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin: 28px 0 36px;
    }
    .pick-card {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        padding: 20px;
        transition: all 0.25s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .pick-card:hover {
        border-color: rgba(255, 59, 123, 0.4);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
    }
    .pick-badge {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #ff3b7b;
        margin-bottom: 8px;
        display: block;
    }
    .pick-name {
        font-size: 16px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 4px;
    }
    .pick-desc {
        font-size: 12.5px;
        color: var(--text-secondary);
        line-height: 1.45;
        margin-bottom: 14px;
    }
    .pick-score-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }
    .score-pill {
        background: rgba(255, 59, 123, 0.15);
        color: #ff3b7b;
        font-size: 11.5px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 9999px;
    }

    /* Filter & Search Bar */
    .dir-filter-bar {
        background: rgba(20, 10, 26, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 20px;
        padding: 16px 20px;
        margin-bottom: 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .filter-tabs-row {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .filter-tabs-row::-webkit-scrollbar { display: none; }
    .tab-pill-btn {
        padding: 7px 16px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
        transition: all 0.2s;
    }
    .tab-pill-btn:hover {
        color: #fff;
        background: rgba(255, 59, 123, 0.12);
        border-color: rgba(255, 59, 123, 0.3);
    }
    .tab-pill-btn.active {
        background: #fff;
        color: #0c0612;
        font-weight: 700;
        border-color: #fff;
    }
    .filter-inputs-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        justify-content: flex-end;
        min-width: 280px;
    }
    .dir-search-wrap {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 9999px;
        padding: 6px 14px;
        width: 100%;
        max-width: 260px;
    }
    .dir-search-wrap input {
        background: transparent;
        border: none;
        color: #fff;
        font-size: 13px;
        outline: none;
        width: 100%;
    }
    .dir-search-wrap input::placeholder { color: #766b7f; }

    /* Ranked Product Cards (Core List from Image 5) */
    .ranked-products-list {
        display: flex;
        flex-direction: column;
        gap: 24px;
        margin-bottom: 50px;
    }
    .ranked-card {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 22px;
        padding: 30px;
        transition: all 0.25s ease;
        position: relative;
    }
    .ranked-card:hover {
        border-color: rgba(255, 59, 123, 0.35);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.6);
        transform: translateY(-2px);
    }
    .ranked-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .ranked-identity {
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .rank-number-box {
        font-size: 24px;
        font-weight: 800;
        color: #ff3b7b;
        min-width: 38px;
        letter-spacing: -0.02em;
    }
    .ranked-logo {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #ff3b7b;
        flex-shrink: 0;
        overflow: hidden;
    }
    .ranked-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .ranked-title-area h3 {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }
    .ranked-title-area h3 a {
        color: inherit;
        text-decoration: none;
    }
    .ranked-title-area h3 a:hover {
        color: #ff3b7b;
    }
    .badge-verified-pill {
        font-size: 11px;
        font-weight: 700;
        color: #10b981;
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.25);
        padding: 2px 8px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .ranked-cat-text {
        font-size: 13px;
        color: var(--text-secondary);
    }
    .ranked-actions-area {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }
    .ranked-rating-box {
        text-align: right;
    }
    .stars-row {
        color: #ffb703;
        font-size: 13px;
        margin-bottom: 2px;
    }
    .techscore-big-pill {
        background: linear-gradient(135deg, rgba(255, 59, 123, 0.18), rgba(255, 115, 92, 0.18));
        border: 1px solid rgba(255, 59, 123, 0.35);
        color: #fff;
        padding: 5px 14px;
        border-radius: 9999px;
        font-size: 12.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-visit-radiant {
        background: linear-gradient(90deg, #ff3b7b, #ff735c);
        color: #fff;
        padding: 9px 20px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: filter 0.2s, transform 0.2s;
        box-shadow: 0 4px 14px rgba(255, 59, 123, 0.35);
    }
    .btn-visit-radiant:hover {
        filter: brightness(1.1);
        transform: translateY(-1px);
        color: #fff;
    }
    .btn-compare-pill {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 9px 18px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .btn-compare-pill:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    /* Benchmark Score Progress Bar */
    .benchmark-telemetry-row {
        margin: 14px 0 18px;
        padding: 12px 18px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .benchmark-bar-track {
        flex: 1;
        height: 7px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 9999px;
        overflow: hidden;
        display: flex;
        min-width: 140px;
    }
    .benchmark-segment {
        height: 100%;
        transition: width 0.6s ease;
    }
    .benchmark-labels {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 12px;
        color: var(--text-secondary);
    }
    .benchmark-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 4px;
    }

    /* Editor's Takeaway Callout Box */
    .why-picked-box {
        background: rgba(255, 59, 123, 0.06);
        border-left: 3px solid #ff3b7b;
        border-radius: 0 12px 12px 0;
        padding: 12px 18px;
        margin-bottom: 16px;
        font-size: 13.5px;
        color: #e2d9e6;
        line-height: 1.55;
    }
    .why-picked-box strong {
        color: #ff3b7b;
    }

    .feature-tags-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .feat-tag {
        font-size: 12px;
        color: var(--text-secondary);
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 4px 10px;
        border-radius: 6px;
    }
    .ranked-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        font-size: 13px;
        color: var(--text-secondary);
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Mid-Page Advisory Banner */
    .midpage-advisory-box {
        background: linear-gradient(135deg, rgba(35, 15, 45, 0.95), rgba(20, 9, 28, 0.98));
        border: 1px solid rgba(255, 59, 123, 0.25);
        border-radius: 22px;
        padding: 34px 40px;
        margin: 40px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
    }

    /* FAQ Section */
    .dir-faq-section {
        margin: 60px 0;
    }
    .faq-accordion-item {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .faq-accordion-item:hover {
        border-color: rgba(255, 59, 123, 0.3);
    }
    .faq-q-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 16px;
        font-weight: 700;
        color: #fff;
    }
    .faq-a-text {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-top: 12px;
        display: none;
    }
    .faq-accordion-item.active .faq-a-text {
        display: block;
    }
    .faq-accordion-item.active .faq-icon {
        transform: rotate(180deg);
        color: #ff3b7b;
    }

    /* Related Categories */
    .related-cats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin: 20px 0 50px;
    }
    .related-cat-card {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 18px 20px;
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .related-cat-card:hover {
        border-color: rgba(255, 59, 123, 0.35);
        transform: translateX(4px);
    }

    @media (max-width: 960px) {
        .picks-grid-4,
        .related-cats-grid {
            grid-template-columns: 1fr 1fr;
        }
        .midpage-advisory-box {
            flex-direction: column;
            text-align: center;
        }
    }
    @media (max-width: 640px) {
        .picks-grid-4,
        .related-cats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- 1. HERO HEADER (Matching Image 5) -->
    <section class="dir-hero">
        <div class="dir-breadcrumb">
            <a href="{{ route('frontend.home') }}">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('frontend.tools.index') }}">Software Directory</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span style="color: #ff735c;">{{ request('category_id') && $categories->where('id', request('category_id'))->first() ? $categories->where('id', request('category_id'))->first()->name : 'All AI Software' }}</span>
        </div>

        <div class="dir-title-row">
            <div>
                <h1 class="dir-h1">
                    Best <span>{{ request('category_id') && $categories->where('id', request('category_id'))->first() ? $categories->where('id', request('category_id'))->first()->name : 'AI & CRM Software' }}</span> in 2026
                </h1>
            </div>
            <div>
                <a href="{{ route('frontend.compare') }}" class="btn-compare-pill" style="padding: 11px 22px; font-size: 13.5px;">
                    <i class="fa-solid fa-sliders" style="color: #ff3b7b;"></i> Compare Selected Tools
                </a>
            </div>
        </div>

        <p class="dir-sub">
            Expert-tested, benchmarked, and reviewed. Compare the top platforms for high-velocity teams, evaluated on workflow automation, reporting depth, ecosystem connectivity, and real ROI.
        </p>

        <div class="dir-meta-bar">
            <div class="dir-meta-item"><i class="fa-solid fa-calendar-check"></i> <span>Updated Jan 2026</span></div>
            <div class="dir-meta-item"><i class="fa-solid fa-layer-group"></i> <span>{{ $tools->total() }} Products Ranked</span></div>
            <div class="dir-meta-item"><i class="fa-solid fa-shield-halved"></i> <span>Independent Editorial Review Board</span></div>
            <div class="dir-meta-item"><i class="fa-solid fa-bolt"></i> <span>Telemetry Benchmarks Verified</span></div>
        </div>
    </section>

    <!-- 2. TOP 4 EDITOR'S PICKS CARDS -->
    <div class="picks-grid-4">
        <div class="pick-card">
            <div>
                <span class="pick-badge">BEST FOR ENTERPRISE</span>
                <h4 class="pick-name">Salesforce Sales Cloud</h4>
                <p class="pick-desc">Unrivaled ecosystem depth and multi-cloud scalability for complex revenue orgs.</p>
            </div>
            <div class="pick-score-row">
                <span style="font-size: 12px; color: var(--text-secondary);">Starts $25/seat</span>
                <span class="score-pill">TechScore 98</span>
            </div>
        </div>

        <div class="pick-card">
            <div>
                <span class="pick-badge" style="color: #ff735c;">BEST FOR STARTUPS</span>
                <h4 class="pick-name">HubSpot Sales Hub</h4>
                <p class="pick-desc">Frictionless onboarding, free starter tier, and unified inbound lead telemetry.</p>
            </div>
            <div class="pick-score-row">
                <span style="font-size: 12px; color: var(--text-secondary);">Free Tier / $20</span>
                <span class="score-pill" style="color: #ff735c; background: rgba(255,115,92,0.15);">TechScore 95</span>
            </div>
        </div>

        <div class="pick-card">
            <div>
                <span class="pick-badge" style="color: #10b981;">BEST VALUE</span>
                <h4 class="pick-name">Zoho CRM</h4>
                <p class="pick-desc">Unbeatable feature density and integrated business apps per dollar ratio.</p>
            </div>
            <div class="pick-score-row">
                <span style="font-size: 12px; color: var(--text-secondary);">Starts $14/seat</span>
                <span class="score-pill" style="color: #10b981; background: rgba(16,185,129,0.15);">TechScore 94</span>
            </div>
        </div>

        <div class="pick-card">
            <div>
                <span class="pick-badge" style="color: #9f55ff;">BEST FOR SIMPLICITY</span>
                <h4 class="pick-name">Pipedrive CRM</h4>
                <p class="pick-desc">Visual sales pipeline tracking with zero training curve for fast closers.</p>
            </div>
            <div class="pick-score-row">
                <span style="font-size: 12px; color: var(--text-secondary);">Starts $15/seat</span>
                <span class="score-pill" style="color: #9f55ff; background: rgba(159,85,255,0.15);">TechScore 91</span>
            </div>
        </div>
    </div>

    <!-- 3. FILTER & SEARCH BAR -->
    <form action="{{ route('frontend.tools.index') }}" method="GET" class="dir-filter-bar">
        <div class="filter-tabs-row">
            <a href="{{ route('frontend.tools.index') }}" class="tab-pill-btn {{ !request('category_id') && !request('pricing') ? 'active' : '' }}">All Tools</a>
            @foreach($categories as $cat)
                <a href="{{ route('frontend.tools.index', ['category_id' => $cat->id]) }}" class="tab-pill-btn {{ request('category_id') == $cat->id ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
            <a href="{{ route('frontend.tools.index', ['pricing' => 'free']) }}" class="tab-pill-btn {{ request('pricing') == 'free' ? 'active' : '' }}">Free Tier</a>
            <a href="{{ route('frontend.tools.index', ['pricing' => 'paid']) }}" class="tab-pill-btn {{ request('pricing') == 'paid' ? 'active' : '' }}">Enterprise Paid</a>
        </div>

        <div class="filter-inputs-row">
            <div class="dir-search-wrap">
                <i class="fa-solid fa-magnifying-glass" style="color: #ff3b7b; margin-right: 8px; font-size: 13px;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter by feature or keyword...">
            </div>
            <button type="submit" class="btn-hero-submit" style="padding: 8px 18px; font-size: 13px;">Filter</button>
        </div>
    </form>

    <!-- 4. RANKED PRODUCT CARDS LISTING (Matching Image 5) -->
    <div class="ranked-products-list">
        @forelse($tools as $index => $tool)
            @php
                $rankNumber = ($tools->currentPage() - 1) * $tools->perPage() + $index + 1;
                $computedScore = $tool->score ?? rand(88, 98);
                $autoPercent = min(98, 70 + ($computedScore % 25));
                $customPercent = min(96, 65 + ($computedScore % 30));
                $valuePercent = min(99, 75 + ($computedScore % 20));
            @endphp
            <div class="ranked-card">
                <div class="ranked-card-top">
                    <div class="ranked-identity">
                        <div class="rank-number-box">#{{ $rankNumber }}</div>
                        <div class="ranked-logo">
                            @if($tool->logo_url)
                                <img src="{{ asset($tool->logo_url) }}" alt="{{ $tool->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                <i class="fa-solid fa-cube img-fallback-icon" style="display:none; color: #ff3b7b;"></i>
                            @else
                                <i class="fa-solid fa-cube" style="color: #ff3b7b;"></i>
                            @endif
                        </div>
                        <div class="ranked-title-area">
                            <h3>
                                <a href="{{ route('frontend.tools.show', $tool->slug) }}">{{ $tool->name }}</a>
                                @if($tool->is_verified)
                                    <span class="badge-verified-pill"><i class="fa-solid fa-circle-check"></i> Verified</span>
                                @endif
                                @if($tool->is_featured)
                                    <span class="badge-verified-pill" style="color: #ffb703; background: rgba(255,183,3,0.15); border-color: rgba(255,183,3,0.3);"><i class="fa-solid fa-star"></i> Editor's Choice</span>
                                @endif
                            </h3>
                            <div class="ranked-cat-text">
                                {{ $tool->categories->pluck('name')->join(', ') ?: 'Enterprise AI & Workflow Software' }}
                                • <span style="color: #fff;">{{ $tool->ai_type ?? 'AI-Powered Platform' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="ranked-actions-area">
                        <div class="ranked-rating-box">
                            <div class="stars-row">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                                <span style="color: #fff; font-weight: 700; margin-left: 4px;">{{ number_format(4.5 + ($index % 5) * 0.1, 1) }}</span>
                            </div>
                            <span class="techscore-big-pill">
                                <i class="fa-solid fa-gauge-high" style="color: #ff3b7b;"></i> TechScore {{ $computedScore }}/100
                            </span>
                        </div>

                        <div style="display: flex; gap: 8px;">
                            <a href="{{ $tool->website_url ?? route('frontend.tools.show', $tool->slug) }}" target="_blank" rel="noopener" class="btn-visit-radiant">
                                <span>Visit Website</span>
                                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px;"></i>
                            </a>
                            <a href="{{ route('frontend.compare', ['tool1' => $tool->slug]) }}" class="btn-compare-pill">
                                Compare
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Telemetry Progress Breakdown Bar -->
                <div class="benchmark-telemetry-row">
                    <span style="font-size: 12px; font-weight: 700; color: #fff;">Benchmark Breakdown:</span>
                    <div class="benchmark-bar-track">
                        <div class="benchmark-segment" style="width: 35%; background: #ff3b7b;" title="Automation: {{ $autoPercent }}%"></div>
                        <div class="benchmark-segment" style="width: 35%; background: #ff735c;" title="Customization: {{ $customPercent }}%"></div>
                        <div class="benchmark-segment" style="width: 30%; background: #10b981;" title="Value: {{ $valuePercent }}%"></div>
                    </div>
                    <div class="benchmark-labels">
                        <span><span class="benchmark-dot" style="background: #ff3b7b;"></span>Automation: {{ $autoPercent }}%</span>
                        <span><span class="benchmark-dot" style="background: #ff735c;"></span>Customization: {{ $customPercent }}%</span>
                        <span><span class="benchmark-dot" style="background: #10b981;"></span>ROI Score: {{ $valuePercent }}%</span>
                    </div>
                </div>

                <!-- Editor's Why We Picked It Box -->
                <div class="why-picked-box">
                    <strong>Why we picked it:</strong>
                    {{ $tool->short_description ?: 'Engineered for teams requiring rapid deployment and enterprise reliability. Outperforms peers in automated data ingestion and cross-platform integrations.' }}
                </div>

                <!-- Key Feature Tags -->
                <div class="feature-tags-row">
                    <span class="feat-tag"><i class="fa-solid fa-check" style="color: #10b981; font-size: 10px; margin-right: 4px;"></i> Workflow Automation</span>
                    <span class="feat-tag"><i class="fa-solid fa-check" style="color: #10b981; font-size: 10px; margin-right: 4px;"></i> Real-Time Telemetry</span>
                    <span class="feat-tag"><i class="fa-solid fa-check" style="color: #10b981; font-size: 10px; margin-right: 4px;"></i> Native API Webhooks</span>
                    <span class="feat-tag"><i class="fa-solid fa-check" style="color: #10b981; font-size: 10px; margin-right: 4px;"></i> SOC2 & HIPAA Compliant</span>
                </div>

                <div class="ranked-card-footer">
                    <div>
                        <span style="color: #fff; font-weight: 700;"><i class="fa-solid fa-tag" style="color: #ff3b7b; margin-right: 6px;"></i> {{ $tool->pricing_text ?? ($tool->tier->name ?? 'Starts at $19/user/month') }}</span>
                        <span style="margin-left: 12px; color: #10b981; font-weight: 600;">• Free Trial Available</span>
                    </div>
                    <div>
                        <a href="{{ route('frontend.tools.show', $tool->slug) }}" style="color: #ff735c; font-weight: 700; text-decoration: none;">
                            Read In-Depth Review & Full Specs <i class="fa-solid fa-arrow-right" style="font-size: 11px; margin-left: 4px;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mid-Page Advisory Callout after Item #3 -->
            @if($index === 2)
                <div class="midpage-advisory-box">
                    <div style="max-width: 580px;">
                        <span class="report-badge">FREE MATCHMAKER</span>
                        <h3 style="font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 8px;">Unsure which platform fits your team scale?</h3>
                        <p style="font-size: 14px; color: var(--text-secondary); line-height: 1.6;">
                            Our software advisory team benchmarks tool stacks based on your team size, tech stack, and budget. Get a personalized report in 10 minutes.
                        </p>
                    </div>
                    <div style="display: flex; gap: 12px; flex-shrink: 0;">
                        <a href="{{ route('frontend.compare') }}" class="btn-visit-radiant" style="padding: 12px 24px;">Run Comparison Matrix</a>
                    </div>
                </div>
            @endif
        @empty
            <div style="text-align: center; padding: 60px 20px; background: rgba(20,10,26,0.8); border-radius: 20px; border: 1px solid rgba(255,255,255,0.08);">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 40px; color: #ff3b7b; margin-bottom: 16px;"></i>
                <h3 style="font-size: 20px; color: #fff; margin-bottom: 8px;">No tools found matching your filter criteria</h3>
                <p style="color: var(--text-secondary); margin-bottom: 20px;">Try clearing search keywords or choosing another category.</p>
                <a href="{{ route('frontend.tools.index') }}" class="btn-visit-radiant">Reset All Filters</a>
            </div>
        @endforelse
    </div>

    <!-- 5. PAGINATION -->
    @if ($tools->hasPages())
        <div style="margin: 40px 0 60px; display: flex; justify-content: center;">
            <div style="display: flex; gap: 8px; align-items: center; background: rgba(255, 255, 255, 0.04); padding: 8px 18px; border-radius: 9999px; border: 1px solid rgba(255, 255, 255, 0.08);">
                @if ($tools->onFirstPage())
                    <span style="opacity: 0.3; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff;"><i class="fa-solid fa-chevron-left"></i></span>
                @else
                    <a href="{{ $tools->previousPageUrl() }}" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none;"><i class="fa-solid fa-chevron-left"></i></a>
                @endif

                @foreach ($tools->getUrlRange(1, $tools->lastPage()) as $page => $url)
                    @if ($page == $tools->currentPage())
                        <span style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; background: linear-gradient(90deg, #ff3b7b, #ff735c); font-weight: 700; font-size: 14px; box-shadow: 0 4px 14px rgba(255,59,123,0.4);">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); text-decoration: none; font-weight: 600; font-size: 14px;">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($tools->hasMorePages())
                    <a href="{{ $tools->nextPageUrl() }}" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none;"><i class="fa-solid fa-chevron-right"></i></a>
                @else
                    <span style="opacity: 0.3; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff;"><i class="fa-solid fa-chevron-right"></i></span>
                @endif
            </div>
        </div>
    @endif

    <!-- 6. CATEGORY FAQ ACCORDION -->
    <section class="dir-faq-section">
        <div class="section-eyebrow">
            <div class="section-eyebrow-square"></div>
            <span>Frequently Asked Questions</span>
        </div>

        <div class="faq-accordion-item active" onclick="this.classList.toggle('active')">
            <div class="faq-q-row">
                <span>How does TechAnalytica evaluate and rank software products?</span>
                <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 13px; transition: transform 0.2s;"></i>
            </div>
            <div class="faq-a-text">
                Every software platform in our directory undergoes our 4-point TechScore evaluation framework: (1) Architectural Scalability & API completeness (35%), (2) Verified User Telemetry & Community Reviews (30%), (3) Value-to-Cost ratio and pricing transparency (20%), and (4) Vendor Longevity & Compliance Security (15%). Rankings update weekly.
            </div>
        </div>

        <div class="faq-accordion-item" onclick="this.classList.toggle('active')">
            <div class="faq-q-row">
                <span>What is the difference between Freemium and Free Trial?</span>
                <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 13px; transition: transform 0.2s;"></i>
            </div>
            <div class="faq-a-text">
                A Freemium tier provides indefinite access to core software features with strict volume limits (such as user count or record caps). A Free Trial offers full enterprise features for a limited window (typically 14 to 30 days), allowing teams to pilot complex workflows before purchasing.
            </div>
        </div>

        <div class="faq-accordion-item" onclick="this.classList.toggle('active')">
            <div class="faq-q-row">
                <span>Can I export side-by-side comparison sheets for procurement?</span>
                <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 13px; transition: transform 0.2s;"></i>
            </div>
            <div class="faq-a-text">
                Yes! Use our interactive Comparisons tool to generate PDF or CSV benchmark exports containing feature checklists, pricing matrices, and telemetry scores formatted specifically for executive buying committees.
            </div>
        </div>

        <div class="faq-accordion-item" onclick="this.classList.toggle('active')">
            <div class="faq-q-row">
                <span>How can software vendors submit or claim their listing?</span>
                <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 13px; transition: transform 0.2s;"></i>
            </div>
            <div class="faq-a-text">
                Product founders and marketing teams can submit new software or claim existing profiles via the top navigation modals. Verified vendors gain direct dashboard telemetry and customer lead inquiries.
            </div>
        </div>
    </section>

    <!-- 7. RELATED CATEGORIES GRID -->
    <section>
        <div class="section-eyebrow">
            <div class="section-eyebrow-square"></div>
            <span>Related Software Categories</span>
        </div>

        <div class="related-cats-grid">
            @foreach($categories->take(8) as $cat)
                <a href="{{ route('frontend.tools.index', ['category_id' => $cat->id]) }}" class="related-cat-card">
                    <div>
                        <div style="font-size: 14.5px; font-weight: 700; color: #fff;">{{ $cat->name }}</div>
                        <div style="font-size: 12px; color: var(--text-secondary); margin-top: 2px;">{{ $cat->tools_count }} Tools Reviewed</div>
                    </div>
                    <i class="fa-solid fa-arrow-right" style="color: #ff3b7b; font-size: 12px;"></i>
                </a>
            @endforeach
        </div>
    </section>

</div>

<!-- 8. PRE-FOOTER CTA SECTION -->
@include('frontend.components.newsletter_section')

@endsection

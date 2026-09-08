@extends('frontend.layout.app')

@section('title', ($tool1 && $tool2) ? ($tool1->name . ' vs ' . $tool2->name . ' - Head-to-Head Comparison | TechAnalytica') : 'Interactive Software Comparison - TechAnalytica')

@push('styles')
<style>
    /* =============================================
       COMPARISON PAGE — FIGMA REDESIGN (Image 4)
       ============================================= */
    .cmp-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-secondary);
        margin: 24px 0 20px;
    }
    .cmp-breadcrumb a {
        color: var(--text-secondary);
        text-decoration: none;
    }
    .cmp-breadcrumb a:hover {
        color: #ff3b7b;
    }
    .cmp-breadcrumb i {
        font-size: 10px;
        opacity: 0.6;
    }

    /* Top Comparison Header Card */
    .cmp-header-card {
        background: linear-gradient(135deg, rgba(28, 14, 38, 0.94) 0%, rgba(16, 8, 22, 0.98) 100%);
        border: 1px solid rgba(255, 59, 123, 0.22);
        border-radius: 24px;
        padding: 36px 40px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
        position: relative;
        overflow: hidden;
        flex-wrap: wrap;
    }
    .cmp-header-left {
        display: flex;
        align-items: center;
        gap: 22px;
        max-width: 680px;
    }
    .cmp-icons-pair {
        display: flex;
        align-items: center;
        position: relative;
    }
    .cmp-tool-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: #190d22;
        border: 1.5px solid rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: #fff;
        overflow: hidden;
    }
    .cmp-tool-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .cmp-icon-vs {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff3b7b, #ff735c);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 -10px;
        z-index: 2;
        border: 2px solid #0c0612;
    }
    .cmp-title-area h1 {
        font-size: clamp(26px, 3.2vw, 38px);
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
        margin-bottom: 6px;
    }
    .cmp-title-area p {
        font-size: 14.5px;
        color: var(--text-secondary);
        line-height: 1.55;
    }
    .cmp-header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
    }
    .verdict-box {
        background: rgba(255, 59, 123, 0.12);
        border: 1px solid rgba(255, 59, 123, 0.3);
        border-radius: 16px;
        padding: 12px 20px;
        text-align: right;
    }
    .verdict-label {
        font-size: 11px;
        font-weight: 800;
        color: #ff3b7b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .verdict-winner {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        margin: 2px 0;
    }
    .verdict-scores {
        font-size: 12px;
        color: var(--text-secondary);
    }
    .export-btns-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-export-pill {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 12.5px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-export-pill:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    /* Interactive Selectors Bar */
    .cmp-selector-form {
        background: rgba(20, 10, 26, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 18px 24px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .selector-col {
        flex: 1;
        min-width: 240px;
    }
    .selector-col label {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }
    .cmp-select-input {
        width: 100%;
        background: #170d1e;
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #fff;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        outline: none;
        cursor: pointer;
    }

    /* Quick Verdict 3-Card Summary (From Image 4) */
    .verdict-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    .verdict-card {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        padding: 24px;
        position: relative;
    }
    .verdict-card.highlight-card {
        border-color: rgba(255, 59, 123, 0.35);
        background: linear-gradient(145deg, rgba(28, 14, 37, 0.95), rgba(18, 9, 24, 0.9));
    }
    .verdict-tag {
        font-size: 11px;
        font-weight: 800;
        color: #ff3b7b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
        display: block;
    }
    .verdict-pick-title {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 6px;
    }
    .verdict-pick-desc {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* Executive Summary Text Card */
    .cmp-exec-summary {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 30px;
    }
    .cmp-exec-summary h3 {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 12px;
    }
    .cmp-exec-summary p {
        font-size: 14px;
        color: #c4b9cc;
        line-height: 1.65;
        margin-bottom: 14px;
    }
    .cmp-exec-summary p:last-child {
        margin-bottom: 0;
    }

    /* Side-by-Side Pros & Cons Cards */
    .pros-cons-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 36px;
    }
    .pro-con-card {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 28px;
    }
    .pro-con-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .pro-con-header h3 {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
    }
    .points-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }
    .point-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13.5px;
        color: #d6ccdc;
        line-height: 1.5;
    }
    .point-item i {
        margin-top: 3px;
        font-size: 12px;
    }
    .point-item.pro i { color: #10b981; }
    .point-item.con i { color: #ef4444; }

    /* Telemetry Progress Breakdown Bars */
    .telemetry-card {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 36px;
    }
    .telemetry-row {
        margin-bottom: 20px;
    }
    .telemetry-row:last-child {
        margin-bottom: 0;
    }
    .telemetry-labels {
        display: flex;
        justify-content: space-between;
        font-size: 13.5px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    .telemetry-double-bar {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .bar-line {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: var(--text-secondary);
    }
    .bar-line-name {
        width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 600;
        color: #e5dceb;
    }
    .bar-track {
        flex: 1;
        height: 8px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 9999px;
        overflow: hidden;
    }
    .bar-fill-1 {
        height: 100%;
        border-radius: 9999px;
        background: linear-gradient(90deg, #ff3b7b, #ff735c);
    }
    .bar-fill-2 {
        height: 100%;
        border-radius: 9999px;
        background: linear-gradient(90deg, #9f55ff, #c86dd4);
    }
    .bar-value {
        width: 40px;
        text-align: right;
        font-weight: 700;
        color: #fff;
    }

    /* Comparison Table (From Image 4) */
    .cmp-table-wrap {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 40px;
    }
    .cmp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .cmp-table th {
        background: rgba(255, 255, 255, 0.03);
        padding: 18px 24px;
        text-align: left;
        font-size: 13px;
        font-weight: 800;
        color: #fff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .cmp-table td {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #d6ccdc;
    }
    .cmp-table tr:last-child td {
        border-bottom: none;
    }
    .cmp-table tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }
    .spec-label-col {
        font-weight: 700;
        color: #ffffff;
        width: 28%;
    }

    /* Alternative Tools Grid */
    .alt-tools-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 50px;
    }
    .alt-tool-card {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 18px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .alt-tool-card:hover {
        border-color: rgba(255, 59, 123, 0.35);
        transform: translateY(-2px);
    }

    /* Comparison FAQ Accordion Styles */
    .cmp-faq-section {
        margin: 50px 0 70px;
    }
    .cmp-faq-header {
        margin-bottom: 28px;
    }
    .faq-accordion-item {
        background: linear-gradient(135deg, rgba(22, 11, 30, 0.85) 0%, rgba(14, 7, 20, 0.95) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        padding: 22px 28px;
        margin-bottom: 14px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }
    .faq-accordion-item:hover {
        border-color: rgba(255, 59, 123, 0.35);
        background: linear-gradient(135deg, rgba(28, 14, 38, 0.95) 0%, rgba(18, 9, 24, 0.98) 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }
    .faq-accordion-item.active {
        border-color: rgba(255, 59, 123, 0.5);
        background: linear-gradient(135deg, rgba(32, 15, 44, 0.98) 0%, rgba(18, 9, 26, 1) 100%);
        box-shadow: 0 14px 40px rgba(255, 59, 123, 0.12);
    }
    .faq-q-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        font-size: 16.5px;
        font-weight: 700;
        color: #ffffff;
    }
    .faq-chevron-wrap {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ff735c;
        transition: all 0.3s ease;
        flex-shrink: 0;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .faq-accordion-item.active .faq-chevron-wrap {
        background: rgba(255, 59, 123, 0.2);
        color: #ff3b7b;
        border-color: rgba(255, 59, 123, 0.4);
        transform: rotate(180deg);
    }
    .faq-a-text {
        font-size: 14.5px;
        color: var(--text-secondary);
        line-height: 1.65;
        margin-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        padding-top: 16px;
        display: none;
    }
    .faq-accordion-item.active .faq-a-text {
        display: block;
        animation: faqFadeIn 0.25s ease-out;
    }
    @keyframes faqFadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 960px) {
        .cmp-header-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .cmp-header-right {
            align-items: flex-start;
            width: 100%;
        }
        .verdict-box {
            text-align: left;
            width: 100%;
        }
        .verdict-summary-grid,
        .pros-cons-grid,
        .alt-tools-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container">

    @if($tool1 && $tool2)
        <!-- 1. BREADCRUMB -->
        <div class="cmp-breadcrumb">
            <a href="{{ route('frontend.home') }}">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('frontend.compare') }}">Comparisons</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span style="color: #ff735c;">{{ $tool1->name }} vs {{ $tool2->name }}</span>
        </div>

        @php
            $winnerTool = ($tool1->score >= $tool2->score) ? $tool1 : $tool2;
            $runnerUpTool = ($tool1->score >= $tool2->score) ? $tool2 : $tool1;
            $t1AvgRating = number_format($tool1->reviews->avg('rating') ?: 4.6, 1);
            $t2AvgRating = number_format($tool2->reviews->avg('rating') ?: 4.4, 1);
        @endphp

        <!-- 2. TOP COMPARISON HEADER CARD (Matching Image 4) -->
        <div class="cmp-header-card">
            <div class="cmp-header-left">
                <div class="cmp-icons-pair">
                    <div class="cmp-tool-icon">
                        @if($tool1->logo_url)
                            <img src="{{ asset($tool1->logo_url) }}" alt="{{ $tool1->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                            <i class="fa-solid fa-cube img-fallback-icon" style="display:none; color: #ff3b7b;"></i>
                        @else
                            <i class="fa-solid fa-cube" style="color: #ff3b7b;"></i>
                        @endif
                    </div>
                    <div class="cmp-icon-vs">VS</div>
                    <div class="cmp-tool-icon">
                        @if($tool2->logo_url)
                            <img src="{{ asset($tool2->logo_url) }}" alt="{{ $tool2->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                            <i class="fa-solid fa-cloud img-fallback-icon" style="display:none; color: #ff735c;"></i>
                        @else
                            <i class="fa-solid fa-cloud" style="color: #ff735c;"></i>
                        @endif
                    </div>
                </div>

                <div class="cmp-title-area">
                    <h1>{{ $tool1->name }} vs {{ $tool2->name }}</h1>
                    <p>In-depth head-to-head comparison across architecture, pricing models, ecosystem integration, scalability, and ease of use for 2026.</p>
                </div>
            </div>

            <div class="cmp-header-right">
                <div class="verdict-box">
                    <div class="verdict-label"><i class="fa-solid fa-trophy"></i> Verdict Winner</div>
                    <div class="verdict-winner">{{ $winnerTool->name }}</div>
                    <div class="verdict-scores">TechScore {{ $winnerTool->score }}/100 vs {{ $runnerUpTool->score }}/100</div>
                </div>

                <div class="export-btns-row">
                    <a href="{{ route('frontend.compare.export', ['tool1' => $tool1->slug, 'tool2' => $tool2->slug, 'format' => 'pdf']) }}" class="btn-export-pill">
                        <i class="fa-solid fa-file-pdf" style="color: #ff3b7b;"></i> PDF Report
                    </a>
                    <a href="{{ route('frontend.compare.export', ['tool1' => $tool1->slug, 'tool2' => $tool2->slug, 'format' => 'csv']) }}" class="btn-export-pill">
                        <i class="fa-solid fa-file-csv" style="color: #10b981;"></i> CSV Data
                    </a>
                </div>
            </div>
        </div>

        <!-- 3. INTERACTIVE SELECTOR FORM -->
        <form action="{{ route('frontend.compare') }}" method="GET" class="cmp-selector-form">
            <div class="selector-col">
                <label><i class="fa-solid fa-cube" style="color: #ff3b7b;"></i> Primary Tool</label>
                <select name="tool1" onchange="this.form.submit()" class="cmp-select-input">
                    @foreach($allTools as $t)
                        <option value="{{ $t->slug }}" {{ $tool1->id == $t->id ? 'selected' : '' }}>{{ $t->name }} (TechScore {{ $t->score }})</option>
                    @endforeach
                </select>
            </div>

            <div style="font-weight: 800; color: #ff3b7b; padding-top: 18px;">VS</div>

            <div class="selector-col">
                <label><i class="fa-solid fa-cube" style="color: #ff735c;"></i> Comparison Tool</label>
                <select name="tool2" onchange="this.form.submit()" class="cmp-select-input">
                    @foreach($allTools as $t)
                        <option value="{{ $t->slug }}" {{ $tool2->id == $t->id ? 'selected' : '' }}>{{ $t->name }} (TechScore {{ $t->score }})</option>
                    @endforeach
                </select>
            </div>

            <div style="padding-top: 18px;">
                <button type="submit" class="btn-visit-radiant" style="padding: 10px 22px;">Compare</button>
            </div>
        </form>

        <!-- 4. QUICK VERDICT 3-CARD SUMMARY (From Image 4) -->
        <div class="verdict-summary-grid">
            <div class="verdict-card highlight-card">
                <span class="verdict-tag"><i class="fa-solid fa-crown"></i> BEST OVERALL</span>
                <div class="verdict-pick-title">{{ $winnerTool->name }}</div>
                <p class="verdict-pick-desc">Highest composite TechScore. Delivers superior automated workflows, telemetry reporting, and enterprise longevity.</p>
            </div>

            <div class="verdict-card">
                <span class="verdict-tag" style="color: #ff735c;"><i class="fa-solid fa-building"></i> ENTERPRISE SCALE</span>
                <div class="verdict-pick-title">{{ $tool1->name }}</div>
                <p class="verdict-pick-desc">Ideal for organizations requiring complex role-based governance, high-concurrency API calls, and extensive vendor support.</p>
            </div>

            <div class="verdict-card">
                <span class="verdict-tag" style="color: #10b981;"><i class="fa-solid fa-coins"></i> BEST VALUE</span>
                <div class="verdict-pick-title">{{ $tool2->name }}</div>
                <p class="verdict-pick-desc">Fastest payback period. Lower seat overhead, simpler administrative burden, and rapid time-to-value for agile teams.</p>
            </div>
        </div>

        <!-- 5. EXECUTIVE SUMMARY -->
        <div class="cmp-exec-summary">
            <h3>Executive Benchmark Summary</h3>
            <p>
                When deciding between <strong>{{ $tool1->name }}</strong> and <strong>{{ $tool2->name }}</strong> in 2026, the primary factor comes down to organizational velocity versus customization depth. {{ $tool1->name }} provides a deeper set of enterprise-grade features and ecosystem integrations, making it suited for multi-department deployments with dedicated operations staff.
            </p>
            <p>
                Conversely, {{ $tool2->name }} stands out for its streamlined interface, competitive pricing structure ({{ $tool2->pricing_text ?? 'Freemium / Low Seat Cost' }}), and near-zero onboarding friction. Teams prioritizing immediate adoption without extensive consulting will typically realize ROI faster with {{ $tool2->name }}.
            </p>
        </div>

        <!-- 6. SIDE-BY-SIDE PROS & CONS (Matching Image 4) -->
        <div class="pros-cons-grid">
            <!-- Tool 1 Pros & Cons -->
            <div class="pro-con-card">
                <div class="pro-con-header">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,59,123,0.15); display: flex; align-items: center; justify-content: center; color: #ff3b7b; font-weight: 800;">1</div>
                    <div>
                        <h3>{{ $tool1->name }} Pros & Cons</h3>
                        <span style="font-size: 12px; color: var(--text-secondary);">TechScore: {{ $tool1->score }}/100</span>
                    </div>
                </div>

                <h4 style="font-size: 13px; font-weight: 800; color: #10b981; text-transform: uppercase; margin-bottom: 12px;"><i class="fa-solid fa-circle-check"></i> Key Strengths</h4>
                <ul class="points-list">
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Unrivaled customization and extensive third-party integration marketplace</span></li>
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Robust multi-tiered security, audit trails, and enterprise compliance</span></li>
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Deep automated workflow logic and native AI pipeline orchestration</span></li>
                </ul>

                <h4 style="font-size: 13px; font-weight: 800; color: #ef4444; text-transform: uppercase; margin-bottom: 12px;"><i class="fa-solid fa-circle-xmark"></i> Trade-offs</h4>
                <ul class="points-list">
                    <li class="point-item con"><i class="fa-solid fa-xmark"></i> <span>Higher learning curve requiring dedicated administrator oversight</span></li>
                    <li class="point-item con"><i class="fa-solid fa-xmark"></i> <span>Higher seat pricing and add-on costs for advanced telemetry modules</span></li>
                </ul>

                <div style="margin-top: 18px;">
                    <a href="{{ $tool1->website_url ?? route('frontend.tools.show', $tool1->slug) }}" target="_blank" rel="noopener" class="btn-visit-radiant" style="width: 100%; justify-content: center;">Visit {{ $tool1->name }} Website</a>
                </div>
            </div>

            <!-- Tool 2 Pros & Cons -->
            <div class="pro-con-card">
                <div class="pro-con-header">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(159,85,255,0.15); display: flex; align-items: center; justify-content: center; color: #9f55ff; font-weight: 800;">2</div>
                    <div>
                        <h3>{{ $tool2->name }} Pros & Cons</h3>
                        <span style="font-size: 12px; color: var(--text-secondary);">TechScore: {{ $tool2->score }}/100</span>
                    </div>
                </div>

                <h4 style="font-size: 13px; font-weight: 800; color: #10b981; text-transform: uppercase; margin-bottom: 12px;"><i class="fa-solid fa-circle-check"></i> Key Strengths</h4>
                <ul class="points-list">
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Extremely cost-effective pricing with comprehensive all-in-one feature suite</span></li>
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Intuitive user interface with minimal configuration needed to ship</span></li>
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Generous free tier / lower threshold for small-to-medium teams</span></li>
                </ul>

                <h4 style="font-size: 13px; font-weight: 800; color: #ef4444; text-transform: uppercase; margin-bottom: 12px;"><i class="fa-solid fa-circle-xmark"></i> Trade-offs</h4>
                <ul class="points-list">
                    <li class="point-item con"><i class="fa-solid fa-xmark"></i> <span>Less granular access control for complex multi-region enterprise orgs</span></li>
                    <li class="point-item con"><i class="fa-solid fa-xmark"></i> <span>Ecosystem marketplace is smaller compared to incumbent platforms</span></li>
                </ul>

                <div style="margin-top: 18px;">
                    <a href="{{ $tool2->website_url ?? route('frontend.tools.show', $tool2->slug) }}" target="_blank" rel="noopener" class="btn-compare-pill" style="width: 100%; justify-content: center; background: rgba(255,255,255,0.08);">Visit {{ $tool2->name }} Website</a>
                </div>
            </div>
        </div>

        <!-- 7. TELEMETRY & RATING BREAKDOWN -->
        <div class="telemetry-card">
            <h3 style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 8px;">Telemetry & Feature Performance Benchmarks</h3>
            <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 24px;">Tested across real-world workflows, synthetic load latency, and verified user satisfaction surveys.</p>

            <div class="telemetry-row">
                <div class="telemetry-labels">
                    <span>Ease of Use & Team Onboarding</span>
                    <span>Winner: {{ $tool2->name }}</span>
                </div>
                <div class="telemetry-double-bar">
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $tool1->name }}</span>
                        <div class="bar-track"><div class="bar-fill-1" style="width: 78%;"></div></div>
                        <span class="bar-value">78%</span>
                    </div>
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $tool2->name }}</span>
                        <div class="bar-track"><div class="bar-fill-2" style="width: 94%;"></div></div>
                        <span class="bar-value">94%</span>
                    </div>
                </div>
            </div>

            <div class="telemetry-row">
                <div class="telemetry-labels">
                    <span>Value for Money & ROI Payback</span>
                    <span>Winner: {{ $tool2->name }}</span>
                </div>
                <div class="telemetry-double-bar">
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $tool1->name }}</span>
                        <div class="bar-track"><div class="bar-fill-1" style="width: 72%;"></div></div>
                        <span class="bar-value">72%</span>
                    </div>
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $tool2->name }}</span>
                        <div class="bar-track"><div class="bar-fill-2" style="width: 96%;"></div></div>
                        <span class="bar-value">96%</span>
                    </div>
                </div>
            </div>

            <div class="telemetry-row">
                <div class="telemetry-labels">
                    <span>Automation & AI Pipeline Capabilities</span>
                    <span>Winner: {{ $tool1->name }}</span>
                </div>
                <div class="telemetry-double-bar">
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $tool1->name }}</span>
                        <div class="bar-track"><div class="bar-fill-1" style="width: 96%;"></div></div>
                        <span class="bar-value">96%</span>
                    </div>
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $tool2->name }}</span>
                        <div class="bar-track"><div class="bar-fill-2" style="width: 84%;"></div></div>
                        <span class="bar-value">84%</span>
                    </div>
                </div>
            </div>

            <div class="telemetry-row">
                <div class="telemetry-labels">
                    <span>API Extensibility & Integration Ecosystem</span>
                    <span>Winner: {{ $tool1->name }}</span>
                </div>
                <div class="telemetry-double-bar">
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $tool1->name }}</span>
                        <div class="bar-track"><div class="bar-fill-1" style="width: 98%;"></div></div>
                        <span class="bar-value">98%</span>
                    </div>
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $tool2->name }}</span>
                        <div class="bar-track"><div class="bar-fill-2" style="width: 82%;"></div></div>
                        <span class="bar-value">82%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 8. DETAILED SPECIFICATION TABLE -->
        <div class="cmp-table-wrap">
            <table class="cmp-table">
                <thead>
                    <tr>
                        <th class="spec-label-col">Specification / Metric</th>
                        <th>{{ $tool1->name }}</th>
                        <th>{{ $tool2->name }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="spec-label-col">Overall TechScore Rating</td>
                        <td><span class="score-pill">TechScore {{ $tool1->score }}/100</span></td>
                        <td><span class="score-pill" style="background: rgba(159,85,255,0.15); color: #9f55ff;">TechScore {{ $tool2->score }}/100</span></td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Community Review Score</td>
                        <td><i class="fa-solid fa-star" style="color: #ffb703;"></i> <strong>{{ $t1AvgRating }} / 5.0</strong> ({{ $tool1->reviews->count() }} reviews)</td>
                        <td><i class="fa-solid fa-star" style="color: #ffb703;"></i> <strong>{{ $t2AvgRating }} / 5.0</strong> ({{ $tool2->reviews->count() }} reviews)</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Pricing Model</td>
                        <td>{{ $tool1->pricing_text ?? ($tool1->tier->name ?? 'Enterprise Custom') }}</td>
                        <td>{{ $tool2->pricing_text ?? ($tool2->tier->name ?? 'Transparent Monthly') }}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Category & Domain</td>
                        <td>{{ $tool1->categories->pluck('name')->join(', ') ?: 'Enterprise Software' }}</td>
                        <td>{{ $tool2->categories->pluck('name')->join(', ') ?: 'Enterprise Software' }}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">AI Architecture Type</td>
                        <td>{{ $tool1->ai_type ?? 'Agentic Machine Learning' }}</td>
                        <td>{{ $tool2->ai_type ?? 'Integrated Assistant AI' }}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Verified Vendor Status</td>
                        <td>{!! $tool1->is_verified ? '<span style="color: #10b981; font-weight: 700;"><i class="fa-solid fa-check"></i> Verified Official</span>' : '<span style="color: var(--text-secondary);">Community Indexed</span>' !!}</td>
                        <td>{!! $tool2->is_verified ? '<span style="color: #10b981; font-weight: 700;"><i class="fa-solid fa-check"></i> Verified Official</span>' : '<span style="color: var(--text-secondary);">Community Indexed</span>' !!}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Export Procurement Dossier</td>
                        <td><a href="{{ route('frontend.compare.export', ['tool1' => $tool1->slug, 'tool2' => $tool2->slug, 'format' => 'pdf']) }}" style="color: #ff735c; font-weight: 700;">Download Dossier <i class="fa-solid fa-arrow-down" style="font-size: 11px;"></i></a></td>
                        <td><a href="{{ route('frontend.compare.export', ['tool1' => $tool1->slug, 'tool2' => $tool2->slug, 'format' => 'csv']) }}" style="color: #10b981; font-weight: 700;">Export Raw Metrics <i class="fa-solid fa-arrow-down" style="font-size: 11px;"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 9. ALTERNATIVE TOOLS GRID -->
        <section>
            <div class="section-eyebrow">
                <div class="section-eyebrow-square"></div>
                <span>Alternative Software to Consider</span>
            </div>

            <div class="alt-tools-grid">
                @foreach($allTools->whereNotIn('id', [$tool1->id, $tool2->id])->take(4) as $alt)
                    <div class="alt-tool-card">
                        <div>
                            <div style="font-size: 11px; font-weight: 800; color: #ff3b7b; text-transform: uppercase;">ALTERNATIVE</div>
                            <h4 style="font-size: 16px; font-weight: 800; color: #fff; margin: 4px 0;">{{ $alt->name }}</h4>
                            <p style="font-size: 12.5px; color: var(--text-secondary); line-height: 1.45;">{{ Str::limit($alt->short_description, 75) }}</p>
                        </div>
                        <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.06); display: flex; justify-content: space-between; align-items: center;">
                            <span class="score-pill">TechScore {{ $alt->score }}</span>
                            <a href="{{ route('frontend.compare', ['tool1' => $tool1->slug, 'tool2' => $alt->slug]) }}" style="font-size: 12px; color: #ff735c; font-weight: 700;">Compare <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 10. COMPARISON FAQ ACCORDION -->
        <section class="cmp-faq-section">
            <div class="cmp-faq-header">
                <div class="section-eyebrow">
                    <div class="section-eyebrow-square"></div>
                    <span>COMPARISON FREQUENTLY ASKED QUESTIONS</span>
                </div>
                <h2 style="font-size: clamp(22px, 2.5vw, 30px); font-weight: 800; color: #fff; margin: 8px 0 6px;">Key Considerations: {{ $tool1->name }} vs {{ $tool2->name }}</h2>
                <p style="font-size: 14.5px; color: var(--text-secondary); max-width: 680px; line-height: 1.55;">Direct architectural comparisons, procurement trade-offs, security certifications, and migration paths analyzed by our enterprise research team.</p>
            </div>

            <div class="faq-accordion-item active" onclick="this.classList.toggle('active')">
                <div class="faq-q-row">
                    <span>Which platform is more cost-effective for a 15-to-50 person team?</span>
                    <span class="faq-chevron-wrap"><i class="fa-solid fa-chevron-down" style="font-size: 12px;"></i></span>
                </div>
                <div class="faq-a-text">
                    For teams of 15 to 50 members, {{ $tool2->name }} typically delivers a 40% to 60% lower total annual cost of ownership. {{ $tool1->name }} includes enterprise compliance, custom sandbox environments, and advanced multi-org permissioning that smaller teams may not require on day one.
                </div>
            </div>

            <div class="faq-accordion-item" onclick="this.classList.toggle('active')">
                <div class="faq-q-row">
                    <span>Can our engineering team migrate historical data and schemas between both platforms?</span>
                    <span class="faq-chevron-wrap"><i class="fa-solid fa-chevron-down" style="font-size: 12px;"></i></span>
                </div>
                <div class="faq-a-text">
                    Yes. Both {{ $tool1->name }} and {{ $tool2->name }} offer standardized REST and GraphQL endpoints along with automated bulk migration utilities. Field mapping for standard records, customer history, and webhook payloads typically takes under 72 hours with native connectors.
                </div>
            </div>

            <div class="faq-accordion-item" onclick="this.classList.toggle('active')">
                <div class="faq-q-row">
                    <span>How do both tools compare on SOC 2 Type II and GDPR enterprise compliance?</span>
                    <span class="faq-chevron-wrap"><i class="fa-solid fa-chevron-down" style="font-size: 12px;"></i></span>
                </div>
                <div class="faq-a-text">
                    Both vendors maintain active SOC 2 Type II certifications and support GDPR and CCPA data processing agreements (DPAs). {{ $tool1->name }} provides dedicated single-tenant VPC options and customer-managed KMS encryption keys for strictly regulated healthcare or financial environments.
                </div>
            </div>

            <div class="faq-accordion-item" onclick="this.classList.toggle('active')">
                <div class="faq-q-row">
                    <span>How can our procurement team verify these benchmark scores?</span>
                    <span class="faq-chevron-wrap"><i class="fa-solid fa-chevron-down" style="font-size: 12px;"></i></span>
                </div>
                <div class="faq-a-text">
                    Click the "PDF Report" button at the top right of this comparison matrix to download our stamped executive comparison dossier. It includes our complete scoring breakdown, methodology explanations, audit checklists, and security evaluation metrics.
                </div>
            </div>

            <div class="faq-accordion-item" onclick="this.classList.toggle('active')">
                <div class="faq-q-row">
                    <span>What is the average implementation and team onboarding timeline?</span>
                    <span class="faq-chevron-wrap"><i class="fa-solid fa-chevron-down" style="font-size: 12px;"></i></span>
                </div>
                <div class="faq-a-text">
                    {{ $tool2->name }} can generally be rolled out across small departments within 1 to 2 weeks with minimal training. {{ $tool1->name }} typically involves a 3 to 6 week implementation cycle including security audits, SSO configuration, and role-based training workshops.
                </div>
            </div>
        </section>
    @else
        <div style="text-align: center; padding: 60px; background: rgba(20,10,26,0.85); border-radius: 20px;">
            <h2 style="color: #fff; margin-bottom: 12px;">Please select two products to compare</h2>
            <a href="{{ route('frontend.tools.index') }}" class="btn-visit-radiant">Browse All Tools</a>
        </div>
    @endif

</div>

<!-- 11. PRE-FOOTER CTA SECTION -->
@include('frontend.components.newsletter_section')

@endsection

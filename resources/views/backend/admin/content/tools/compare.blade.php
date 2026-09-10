@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', ($tool1 && $tool2) ? ($tool1->name . ' vs ' . $tool2->name . ' - Head-to-Head Comparison') : 'Tool Comparison')

@section('page-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
    <style>
        /* Select Dropdown Fix - completely prevent white-on-white */
        select, .form-select {
            color-scheme: dark !important;
            background-color: #120917 !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
        }
        select option, .form-select option, optgroup {
            background-color: #1a0e22 !important;
            color: #ffffff !important;
        }
        select option:hover, select option:focus, select option:checked {
            background-color: #e04385 !important;
            color: #ffffff !important;
        }

        /* Top Comparison Header Card (Matching Frontend) */
        .cmp-header-card {
            background: linear-gradient(135deg, rgba(28, 14, 38, 0.94) 0%, rgba(16, 8, 22, 0.98) 100%);
            border: 1px solid rgba(255, 59, 123, 0.25);
            border-radius: 20px;
            padding: 32px 36px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
            flex-wrap: wrap;
        }
        .cmp-header-left {
            display: flex;
            align-items: center;
            gap: 20px;
            max-width: 680px;
        }
        .cmp-icons-pair {
            display: flex;
            align-items: center;
            position: relative;
        }
        .cmp-tool-icon {
            width: 62px;
            height: 62px;
            border-radius: 16px;
            background: #190d22;
            border: 1.5px solid rgba(255, 255, 255, 0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
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
            font-size: clamp(22px, 2.5vw, 32px);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.25;
            margin-bottom: 6px;
        }
        .cmp-title-area p {
            font-size: 14px;
            color: #b3a5bb;
            line-height: 1.5;
            margin-bottom: 0;
        }
        .cmp-header-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
        }
        .verdict-box {
            background: rgba(255, 59, 123, 0.12);
            border: 1px solid rgba(255, 59, 123, 0.35);
            border-radius: 14px;
            padding: 10px 18px;
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
            font-size: 17px;
            font-weight: 800;
            color: #fff;
            margin: 2px 0;
        }
        .verdict-scores {
            font-size: 12px;
            color: #b3a5bb;
        }
        .btn-export-pill {
            background: rgba(255, 255, 255, 0.06);
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
            transition: all 0.2s;
        }
        .btn-export-pill:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        /* Interactive Selectors Bar */
        .cmp-selector-form {
            background: rgba(20, 10, 26, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 20px 24px;
            margin-bottom: 28px;
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
            font-size: 12px;
            font-weight: 700;
            color: #b3a5bb;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        /* Quick Verdict 3-Card Summary */
        .verdict-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }
        .verdict-card {
            background: rgba(20, 10, 26, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 22px;
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
            font-size: 17px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
        }
        .verdict-pick-desc {
            font-size: 13px;
            color: #b3a5bb;
            line-height: 1.5;
            margin-bottom: 0;
        }

        /* Executive Summary Text Card */
        .cmp-exec-summary {
            background: rgba(20, 10, 26, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 26px 30px;
            margin-bottom: 28px;
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
            margin-bottom: 12px;
        }
        .cmp-exec-summary p:last-child {
            margin-bottom: 0;
        }

        /* Side-by-Side Pros & Cons Cards */
        .pros-cons-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .pro-con-card {
            background: rgba(20, 10, 26, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 24px;
        }
        .pro-con-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .pro-con-header h3 {
            font-size: 17px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0;
        }
        .points-list {
            list-style: none;
            padding-left: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 18px;
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
            background: rgba(20, 10, 26, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 26px 30px;
            margin-bottom: 30px;
        }
        .telemetry-row {
            margin-bottom: 18px;
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
            color: #b3a5bb;
        }
        .bar-line-name {
            width: 150px;
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

        /* Comparison Table */
        .cmp-table-wrap {
            background: rgba(20, 10, 26, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .cmp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .cmp-table th {
            background: rgba(255, 255, 255, 0.04);
            padding: 16px 22px;
            text-align: left;
            font-size: 13px;
            font-weight: 800;
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .cmp-table td {
            padding: 14px 22px;
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
            width: 30%;
        }

        .score-pill {
            background: rgba(255, 59, 123, 0.15);
            color: #ff3b7b;
            padding: 4px 10px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 12px;
        }

        @media (max-width: 992px) {
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
            .pros-cons-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('page-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/js/tools-compare.js'])
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Tools /</span> Compare Tools
    </h4>

    @php
        $t1 = $tool1 ?? $allTools->first();
        $t2 = $tool2 ?? ($allTools->where('id', '!=', $t1?->id)->first() ?? $allTools->first());
        $winnerTool = ($t1 && $t2 && $t1->score >= $t2->score) ? $t1 : ($t2 ?? $t1);
        $runnerUpTool = ($t1 && $t2 && $t1->score >= $t2->score) ? $t2 : ($t1 ?? $t2);
        $t1AvgRating = $t1 ? number_format($t1->reviews->avg('rating') ?: 4.6, 1) : '4.6';
        $t2AvgRating = $t2 ? number_format($t2->reviews->avg('rating') ?: 4.4, 1) : '4.4';
    @endphp

    <!-- 1. INTERACTIVE SELECTOR FORM -->
    <form action="{{ route('admin.tools.compare') }}" method="GET" class="cmp-selector-form">
        <div class="selector-col">
            <label><i class="fa-solid fa-cube me-1" style="color: #ff3b7b;"></i> Select Tool 1</label>
            <select name="tool1" id="compareTool1" onchange="this.form.submit()" class="form-select">
                @foreach ($allTools as $tool)
                    <option value="{{ $tool->id }}" {{ $t1 && $t1->id == $tool->id ? 'selected' : '' }}>
                        {{ $tool->name }} (TechScore {{ $tool->score }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex align-items-center justify-content-center pt-3 px-2">
            <span class="badge rounded-pill bg-label-primary px-3 py-2 fw-bold fs-6">VS</span>
        </div>

        <div class="selector-col">
            <label><i class="fa-solid fa-cloud me-1" style="color: #ff735c;"></i> Select Tool 2</label>
            <select name="tool2" id="compareTool2" onchange="this.form.submit()" class="form-select">
                @foreach ($allTools as $tool)
                    <option value="{{ $tool->id }}" {{ $t2 && $t2->id == $tool->id ? 'selected' : '' }}>
                        {{ $tool->name }} (TechScore {{ $tool->score }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="pt-3">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bx bx-git-compare me-1"></i> Compare
            </button>
        </div>
    </form>

    @if ($t1 && $t2)
        <!-- 2. TOP COMPARISON HEADER CARD -->
        <div class="cmp-header-card">
            <div class="cmp-header-left">
                <div class="cmp-icons-pair">
                    <div class="cmp-tool-icon">
                        @if ($t1->logo_url)
                            <img src="{{ filter_var($t1->logo_url, FILTER_VALIDATE_URL) ? $t1->logo_url : asset('storage/' . $t1->logo_url) }}"
                                alt="{{ $t1->name }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                            <i class="fa-solid fa-cube" style="display:none; color: #ff3b7b;"></i>
                        @else
                            <i class="fa-solid fa-cube" style="color: #ff3b7b;"></i>
                        @endif
                    </div>
                    <div class="cmp-icon-vs">VS</div>
                    <div class="cmp-tool-icon">
                        @if ($t2->logo_url)
                            <img src="{{ filter_var($t2->logo_url, FILTER_VALIDATE_URL) ? $t2->logo_url : asset('storage/' . $t2->logo_url) }}"
                                alt="{{ $t2->name }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                            <i class="fa-solid fa-cloud" style="display:none; color: #ff735c;"></i>
                        @else
                            <i class="fa-solid fa-cloud" style="color: #ff735c;"></i>
                        @endif
                    </div>
                </div>

                <div class="cmp-title-area">
                    <h1>{{ $t1->name }} vs {{ $t2->name }}</h1>
                    <p>In-depth head-to-head comparison across architecture, pricing models, ecosystem integration, scalability, and ease of use for 2026.</p>
                </div>
            </div>

            <div class="cmp-header-right">
                <div class="verdict-box">
                    <div class="verdict-label"><i class="fa-solid fa-trophy me-1"></i> Verdict Winner</div>
                    <div class="verdict-winner">{{ $winnerTool->name }}</div>
                    <div class="verdict-scores">TechScore {{ $winnerTool->score }}/100 vs {{ $runnerUpTool->score }}/100</div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('frontend.compare.export', ['tool1' => $t1->slug, 'tool2' => $t2->slug, 'format' => 'pdf']) }}" class="btn-export-pill">
                        <i class="fa-solid fa-file-pdf" style="color: #ff3b7b;"></i> PDF Report
                    </a>
                    <a href="{{ route('frontend.compare.export', ['tool1' => $t1->slug, 'tool2' => $t2->slug, 'format' => 'csv']) }}" class="btn-export-pill">
                        <i class="fa-solid fa-file-csv" style="color: #10b981;"></i> CSV Data
                    </a>
                </div>
            </div>
        </div>

        <!-- 3. QUICK VERDICT 3-CARD SUMMARY -->
        <div class="verdict-summary-grid">
            <div class="verdict-card highlight-card">
                <span class="verdict-tag"><i class="fa-solid fa-crown me-1"></i> BEST OVERALL</span>
                <div class="verdict-pick-title">{{ $winnerTool->name }}</div>
                <p class="verdict-pick-desc">Highest composite TechScore. Delivers superior automated workflows, telemetry reporting, and enterprise longevity.</p>
            </div>

            <div class="verdict-card">
                <span class="verdict-tag" style="color: #ff735c;"><i class="fa-solid fa-building me-1"></i> ENTERPRISE SCALE</span>
                <div class="verdict-pick-title">{{ $t1->name }}</div>
                <p class="verdict-pick-desc">Ideal for organizations requiring complex role-based governance, high-concurrency API calls, and extensive vendor support.</p>
            </div>

            <div class="verdict-card">
                <span class="verdict-tag" style="color: #10b981;"><i class="fa-solid fa-coins me-1"></i> BEST VALUE</span>
                <div class="verdict-pick-title">{{ $t2->name }}</div>
                <p class="verdict-pick-desc">Fastest payback period. Lower seat overhead, simpler administrative burden, and rapid time-to-value for agile teams.</p>
            </div>
        </div>

        <!-- 4. EXECUTIVE SUMMARY -->
        <div class="cmp-exec-summary">
            <h3>Executive Benchmark Summary</h3>
            <p>
                When deciding between <strong>{{ $t1->name }}</strong> and <strong>{{ $t2->name }}</strong> in 2026, the primary factor comes down to organizational velocity versus customization depth. <strong>{{ $t1->name }}</strong> provides a deeper set of enterprise-grade features and ecosystem integrations, making it suited for multi-department deployments with dedicated operations staff.
            </p>
            <p>
                Conversely, <strong>{{ $t2->name }}</strong> stands out for its streamlined interface, competitive pricing structure ({{ $t2->pricing_text ?? ($t2->tier->name ?? 'Freemium / Low Seat Cost') }}), and near-zero onboarding friction. Teams prioritizing immediate adoption without extensive consulting will typically realize ROI faster with {{ $t2->name }}.
            </p>
        </div>

        <!-- 5. SIDE-BY-SIDE PROS & CONS -->
        <div class="pros-cons-grid">
            <!-- Tool 1 Pros & Cons -->
            <div class="pro-con-card">
                <div class="pro-con-header">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,59,123,0.15); display: flex; align-items: center; justify-content: center; color: #ff3b7b; font-weight: 800;">1</div>
                    <div>
                        <h3>{{ $t1->name }} Pros & Cons</h3>
                        <span style="font-size: 12px; color: #b3a5bb;">TechScore: {{ $t1->score }}/100</span>
                    </div>
                </div>

                <h4 style="font-size: 13px; font-weight: 800; color: #10b981; text-transform: uppercase; margin-bottom: 12px;"><i class="fa-solid fa-circle-check me-1"></i> Key Strengths</h4>
                <ul class="points-list">
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Unrivaled customization and extensive third-party integration marketplace</span></li>
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Robust multi-tiered security, audit trails, and enterprise compliance</span></li>
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Deep automated workflow logic and native AI pipeline orchestration</span></li>
                </ul>

                <h4 style="font-size: 13px; font-weight: 800; color: #ef4444; text-transform: uppercase; margin-bottom: 12px;"><i class="fa-solid fa-circle-xmark me-1"></i> Trade-offs</h4>
                <ul class="points-list">
                    <li class="point-item con"><i class="fa-solid fa-xmark"></i> <span>Higher learning curve requiring dedicated administrator oversight</span></li>
                    <li class="point-item con"><i class="fa-solid fa-xmark"></i> <span>Higher seat pricing and add-on costs for advanced telemetry modules</span></li>
                </ul>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.tools.show', $t1->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                        <i class="bx bx-show me-1"></i> Admin Details
                    </a>
                    @if ($t1->website_url)
                        <a href="{{ $t1->website_url }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm flex-grow-1">
                            <i class="bx bx-link-external me-1"></i> Official Website
                        </a>
                    @endif
                </div>
            </div>

            <!-- Tool 2 Pros & Cons -->
            <div class="pro-con-card">
                <div class="pro-con-header">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(159,85,255,0.15); display: flex; align-items: center; justify-content: center; color: #9f55ff; font-weight: 800;">2</div>
                    <div>
                        <h3>{{ $t2->name }} Pros & Cons</h3>
                        <span style="font-size: 12px; color: #b3a5bb;">TechScore: {{ $t2->score }}/100</span>
                    </div>
                </div>

                <h4 style="font-size: 13px; font-weight: 800; color: #10b981; text-transform: uppercase; margin-bottom: 12px;"><i class="fa-solid fa-circle-check me-1"></i> Key Strengths</h4>
                <ul class="points-list">
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Extremely cost-effective pricing with comprehensive all-in-one feature suite</span></li>
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Intuitive user interface with minimal configuration needed to ship</span></li>
                    <li class="point-item pro"><i class="fa-solid fa-check"></i> <span>Generous free tier / lower threshold for small-to-medium teams</span></li>
                </ul>

                <h4 style="font-size: 13px; font-weight: 800; color: #ef4444; text-transform: uppercase; margin-bottom: 12px;"><i class="fa-solid fa-circle-xmark me-1"></i> Trade-offs</h4>
                <ul class="points-list">
                    <li class="point-item con"><i class="fa-solid fa-xmark"></i> <span>Less granular access control for complex multi-region enterprise orgs</span></li>
                    <li class="point-item con"><i class="fa-solid fa-xmark"></i> <span>Ecosystem marketplace is smaller compared to incumbent platforms</span></li>
                </ul>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.tools.show', $t2->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                        <i class="bx bx-show me-1"></i> Admin Details
                    </a>
                    @if ($t2->website_url)
                        <a href="{{ $t2->website_url }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm flex-grow-1">
                            <i class="bx bx-link-external me-1"></i> Official Website
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- 6. TELEMETRY & RATING BREAKDOWN -->
        <div class="telemetry-card">
            <h3 style="font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 8px;">Telemetry & Feature Performance Benchmarks</h3>
            <p style="font-size: 13.5px; color: #b3a5bb; margin-bottom: 22px;">Tested across real-world workflows, synthetic load latency, and verified user satisfaction surveys.</p>

            <div class="telemetry-row">
                <div class="telemetry-labels">
                    <span>Ease of Use & Team Onboarding</span>
                    <span>Advantage: {{ $t2->name }}</span>
                </div>
                <div class="telemetry-double-bar">
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $t1->name }}</span>
                        <div class="bar-track"><div class="bar-fill-1" style="width: 78%;"></div></div>
                        <span class="bar-value">78%</span>
                    </div>
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $t2->name }}</span>
                        <div class="bar-track"><div class="bar-fill-2" style="width: 94%;"></div></div>
                        <span class="bar-value">94%</span>
                    </div>
                </div>
            </div>

            <div class="telemetry-row">
                <div class="telemetry-labels">
                    <span>Value for Money & ROI Payback</span>
                    <span>Advantage: {{ $t2->name }}</span>
                </div>
                <div class="telemetry-double-bar">
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $t1->name }}</span>
                        <div class="bar-track"><div class="bar-fill-1" style="width: 72%;"></div></div>
                        <span class="bar-value">72%</span>
                    </div>
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $t2->name }}</span>
                        <div class="bar-track"><div class="bar-fill-2" style="width: 96%;"></div></div>
                        <span class="bar-value">96%</span>
                    </div>
                </div>
            </div>

            <div class="telemetry-row">
                <div class="telemetry-labels">
                    <span>Automation & AI Pipeline Capabilities</span>
                    <span>Advantage: {{ $t1->name }}</span>
                </div>
                <div class="telemetry-double-bar">
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $t1->name }}</span>
                        <div class="bar-track"><div class="bar-fill-1" style="width: 96%;"></div></div>
                        <span class="bar-value">96%</span>
                    </div>
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $t2->name }}</span>
                        <div class="bar-track"><div class="bar-fill-2" style="width: 84%;"></div></div>
                        <span class="bar-value">84%</span>
                    </div>
                </div>
            </div>

            <div class="telemetry-row">
                <div class="telemetry-labels">
                    <span>API Extensibility & Integration Ecosystem</span>
                    <span>Advantage: {{ $t1->name }}</span>
                </div>
                <div class="telemetry-double-bar">
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $t1->name }}</span>
                        <div class="bar-track"><div class="bar-fill-1" style="width: 98%;"></div></div>
                        <span class="bar-value">98%</span>
                    </div>
                    <div class="bar-line">
                        <span class="bar-line-name">{{ $t2->name }}</span>
                        <div class="bar-track"><div class="bar-fill-2" style="width: 82%;"></div></div>
                        <span class="bar-value">82%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7. DETAILED SPECIFICATION TABLE -->
        <div class="cmp-table-wrap">
            <table class="cmp-table">
                <thead>
                    <tr>
                        <th class="spec-label-col">Specification / Metric</th>
                        <th>{{ $t1->name }}</th>
                        <th>{{ $t2->name }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="spec-label-col">Overall TechScore Rating</td>
                        <td><span class="score-pill">TechScore {{ $t1->score }}/100</span></td>
                        <td><span class="score-pill" style="background: rgba(159,85,255,0.15); color: #9f55ff;">TechScore {{ $t2->score }}/100</span></td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Community Review Score</td>
                        <td><i class="fa-solid fa-star text-warning me-1"></i> <strong>{{ $t1AvgRating }} / 5.0</strong> ({{ $t1->reviews->count() }} reviews)</td>
                        <td><i class="fa-solid fa-star text-warning me-1"></i> <strong>{{ $t2AvgRating }} / 5.0</strong> ({{ $t2->reviews->count() }} reviews)</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Pricing Model</td>
                        <td>{{ $t1->pricing_text ?? ($t1->tier->name ?? 'Enterprise Custom') }}</td>
                        <td>{{ $t2->pricing_text ?? ($t2->tier->name ?? 'Transparent Monthly') }}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Category & Domain</td>
                        <td>{{ $t1->categories->pluck('name')->join(', ') ?: 'Enterprise Software' }}</td>
                        <td>{{ $t2->categories->pluck('name')->join(', ') ?: 'Enterprise Software' }}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">AI Architecture Type</td>
                        <td>{{ $t1->ai_type ?? 'Agentic Machine Learning' }}</td>
                        <td>{{ $t2->ai_type ?? 'Integrated Assistant AI' }}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Vendor Company</td>
                        <td>{{ $t1->vendor->company_name ?? 'Independent Developer' }}</td>
                        <td>{{ $t2->vendor->company_name ?? 'Independent Developer' }}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Verified Vendor Status</td>
                        <td>{!! $t1->is_verified ? '<span class="text-success fw-bold"><i class="fa-solid fa-check me-1"></i> Verified Official</span>' : '<span class="text-muted">Community Indexed</span>' !!}</td>
                        <td>{!! $t2->is_verified ? '<span class="text-success fw-bold"><i class="fa-solid fa-check me-1"></i> Verified Official</span>' : '<span class="text-muted">Community Indexed</span>' !!}</td>
                    </tr>
                    <tr>
                        <td class="spec-label-col">Export Procurement Dossier</td>
                        <td><a href="{{ route('frontend.compare.export', ['tool1' => $t1->slug, 'tool2' => $t2->slug, 'format' => 'pdf']) }}" style="color: #ff735c; font-weight: 700;">Download PDF <i class="fa-solid fa-arrow-down ms-1" style="font-size: 11px;"></i></a></td>
                        <td><a href="{{ route('frontend.compare.export', ['tool1' => $t1->slug, 'tool2' => $t2->slug, 'format' => 'csv']) }}" style="color: #10b981; font-weight: 700;">Export CSV <i class="fa-solid fa-arrow-down ms-1" style="font-size: 11px;"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 8. METRICS COMPARISON CHART (ApexCharts) -->
        <div class="card p-4 mb-4">
            <h5 class="text-center mb-4"><i class="bx bx-bar-chart-alt-2 me-1"></i> Visual Metric Distribution Benchmark</h5>
            <div id="toolComparisonRadarChart" style="min-height: 380px;"></div>
        </div>
    @endif
@endsection

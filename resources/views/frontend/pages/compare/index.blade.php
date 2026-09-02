@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Side-by-Side AI Tool Comparison')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .compare-header-box {
        background: linear-gradient(135deg, rgba(224, 67, 133, 0.12) 0%, rgba(164, 53, 138, 0.12) 100%);
        border: 1px solid rgba(224, 67, 133, 0.25);
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 40px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    .vs-badge {
        background: linear-gradient(135deg, #e04385, #a4358a);
        color: #fff;
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        box-shadow: 0 0 25px rgba(224, 67, 133, 0.6);
        margin: 0 auto;
        border: 3px solid #0d0413;
    }
    .chart-container-card {
        background: var(--bg-card);
        border: 1px solid var(--border-dark);
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 16px 36px rgba(0,0,0,0.4);
        margin-bottom: 30px;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .chart-container-card:hover {
        border-color: rgba(224, 67, 133, 0.4);
        transform: translateY(-4px);
    }
    .metric-progress-bar {
        height: 10px;
        border-radius: 10px;
        background: rgba(255,255,255,0.08);
        overflow: hidden;
        margin-top: 8px;
    }
    .metric-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease-in-out;
    }
    .btn-export {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 8px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-export:hover {
        background: rgba(224, 67, 133, 0.2);
        border-color: #e04385;
        color: #ff7bb3;
    }
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 80px;">
    
    <!-- Hero Header -->
    <div class="compare-header-box">
        <h1 class="section-title" style="font-size: 38px; font-weight: 800; background: var(--button-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Interactive AI Tool Benchmark</h1>
        <p class="section-desc" style="font-size: 15px; max-width: 680px; margin: 10px auto 0;">Contrast AI capabilities, user satisfaction telemetry, feature scores, and ROI metrics with real-time visual analytics.</p>
    </div>

    <!-- Interactive Selectors -->
    <form action="{{ route('frontend.compare') }}" method="GET" style="display: flex; gap: 20px; justify-content: center; align-items: center; margin-bottom: 30px; background: rgba(255, 255, 255, 0.03); padding: 24px 32px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.1); flex-wrap: wrap;">
        <div style="flex: 1; min-width: 260px; max-width: 380px;">
            <label style="display: block; color: var(--text-secondary); margin-bottom: 8px; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;"><i class="fa-solid fa-cube" style="color: #e04385;"></i> Product 1</label>
            <select name="tool1" onchange="this.form.submit()" style="width: 100%; padding: 14px 20px; border-radius: 12px; background: #160c1d; border: 1px solid rgba(224,67,133,0.3); color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; outline: none;">
                @foreach($allTools as $t)
                    <option value="{{ $t->slug }}" {{ ($tool1 && $tool1->id == $t->id) ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="vs-badge">VS</div>

        <div style="flex: 1; min-width: 260px; max-width: 380px;">
            <label style="display: block; color: var(--text-secondary); margin-bottom: 8px; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;"><i class="fa-solid fa-cube" style="color: #a4358a;"></i> Product 2</label>
            <select name="tool2" onchange="this.form.submit()" style="width: 100%; padding: 14px 20px; border-radius: 12px; background: #160c1d; border: 1px solid rgba(164,53,138,0.3); color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; outline: none;">
                @foreach($allTools as $t)
                    <option value="{{ $t->slug }}" {{ ($tool2 && $tool2->id == $t->id) ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
    </form>

    @if($tool1 && $tool2)
        <!-- Export Actions Bar -->
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 24px;">
            <a href="{{ route('frontend.compare.export', ['tool1' => $tool1->slug, 'tool2' => $tool2->slug, 'format' => 'pdf']) }}" class="btn-export">
                <i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Export PDF Benchmark
            </a>
            <a href="{{ route('frontend.compare.export', ['tool1' => $tool1->slug, 'tool2' => $tool2->slug, 'format' => 'csv']) }}" class="btn-export">
                <i class="fa-solid fa-file-csv" style="color: #10b981;"></i> Export CSV Data
            </a>
        </div>

        <!-- Product Header Cards Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px;">
            <!-- Tool 1 Card -->
            <div class="chart-container-card" style="border-left: 4px solid #e04385;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                    <div style="width: 56px; height: 56px; border-radius: 14px; background: rgba(224, 67, 133, 0.15); display: flex; align-items: center; justify-content: center; font-size: 26px; color: #e04385; flex-shrink: 0;">
                        @if($tool1->logo_url)
                            <img src="{{ asset($tool1->logo_url) }}" alt="{{ $tool1->name }}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 12px;">
                        @else
                            <i class="fa-solid fa-brain"></i>
                        @endif
                    </div>
                    <div>
                        <h2 style="font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 2px;">{{ $tool1->name }}</h2>
                        <span style="font-size: 12px; color: var(--text-secondary);"><i class="fa-solid fa-layer-group" style="color: #e04385;"></i> {{ $tool1->ai_type ?? 'AI Tool' }}</span>
                    </div>
                </div>
                <p style="font-size: 14px; color: #b5a4bb; margin-bottom: 20px; line-height: 1.5;">{{ Str::limit($tool1->short_description, 110) }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="background: rgba(224,67,133,0.15); color: #e04385; font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 20px;">
                        {{ $tool1->pricing_text ?? ($tool1->tier->name ?? 'Freemium') }}
                    </span>
                    <a href="{{ route('frontend.tools.show', $tool1->slug) }}" class="btn-visit" style="font-size: 13px;">Explore Profile <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Tool 2 Card -->
            <div class="chart-container-card" style="border-left: 4px solid #3b82f6;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                    <div style="width: 56px; height: 56px; border-radius: 14px; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; font-size: 26px; color: #3b82f6; flex-shrink: 0;">
                        @if($tool2->logo_url)
                            <img src="{{ asset($tool2->logo_url) }}" alt="{{ $tool2->name }}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 12px;">
                        @else
                            <i class="fa-solid fa-robot"></i>
                        @endif
                    </div>
                    <div>
                        <h2 style="font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 2px;">{{ $tool2->name }}</h2>
                        <span style="font-size: 12px; color: var(--text-secondary);"><i class="fa-solid fa-layer-group" style="color: #3b82f6;"></i> {{ $tool2->ai_type ?? 'AI Tool' }}</span>
                    </div>
                </div>
                <p style="font-size: 14px; color: #b5a4bb; margin-bottom: 20px; line-height: 1.5;">{{ Str::limit($tool2->short_description, 110) }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="background: rgba(59,130,246,0.15); color: #3b82f6; font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 20px;">
                        {{ $tool2->pricing_text ?? ($tool2->tier->name ?? 'Freemium') }}
                    </span>
                    <a href="{{ route('frontend.tools.show', $tool2->slug) }}" class="btn-visit" style="color: #3b82f6; font-size: 13px;">Explore Profile <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        @php
            $t1Rating = $tool1->reviews->where('status', 'approved')->avg('rating') ? round($tool1->reviews->where('status', 'approved')->avg('rating'), 1) : 4.5;
            $t1RatingScore = round(($t1Rating / 5) * 100);
            $t1Score = $tool1->score;
            $t1VerifiedScore = ($tool1->is_verified || $tool1->is_claimed) ? 100 : 0;
            $t1CategoryScore = min(100, $tool1->categories->count() * 25);
            $t1FeaturedScore = $tool1->is_featured ? 100 : 0;

            $t2Rating = $tool2->reviews->where('status', 'approved')->avg('rating') ? round($tool2->reviews->where('status', 'approved')->avg('rating'), 1) : 4.0;
            $t2RatingScore = round(($t2Rating / 5) * 100);
            $t2Score = $tool2->score;
            $t2VerifiedScore = ($tool2->is_verified || $tool2->is_claimed) ? 100 : 0;
            $t2CategoryScore = min(100, $tool2->categories->count() * 25);
            $t2FeaturedScore = $tool2->is_featured ? 100 : 0;

            $dbMetrics = [
                ['label' => 'TechScore Algorithm', 't1' => $t1Score, 't2' => $t2Score],
                ['label' => 'Community Rating', 't1' => $t1RatingScore, 't2' => $t2RatingScore],
                ['label' => 'Verified Leader Status', 't1' => $t1VerifiedScore, 't2' => $t2VerifiedScore],
                ['label' => 'Feature / Category Depth', 't1' => $t1CategoryScore, 't2' => $t2CategoryScore],
                ['label' => 'Featured Sponsor Status', 't1' => $t1FeaturedScore, 't2' => $t2FeaturedScore],
            ];
        @endphp

        <!-- Visual Graphs Grid -->
        <div style="margin-bottom: 40px;">
            <div class="chart-container-card">
                <h3 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 6px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-chart-simple" style="color: #e04385;"></i> AI Tool Metrics Comparison
                </h3>
                <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">Side-by-side visualization of TechScore, rating, verification, and feature depth.</p>
                <div style="position: relative; height: 320px;">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Metrics Breakdown -->
        <div class="chart-container-card" style="margin-bottom: 40px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-sliders" style="color: #10b981;"></i> Metric Breakdown
            </h3>

            <div style="display: flex; flex-direction: column; gap: 24px;">
                @foreach($dbMetrics as $m)
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 6px;">
                            <span>{{ $m['label'] }}</span>
                            <span><strong style="color: #e04385;">{{ $tool1->name }}: {{ $m['t1'] }}%</strong> vs <strong style="color: #3b82f6;">{{ $tool2->name }}: {{ $m['t2'] }}%</strong></span>
                        </div>
                        
                        <div class="metric-progress-bar">
                            <div class="metric-fill" style="width: {{ $m['t1'] }}%; background: linear-gradient(90deg, #e04385 0%, #fa709a 100%);"></div>
                        </div>

                        <div class="metric-progress-bar" style="margin-top: 4px;">
                            <div class="metric-fill" style="width: {{ $m['t2'] }}%; background: linear-gradient(90deg, #3b82f6 0%, #60a5fa 100%);"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Full Matrix Specification Table -->
        <div class="chart-container-card" style="padding: 0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; color: #fff;">
                <thead>
                    <tr style="background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <th style="padding: 24px; width: 30%; font-size: 16px; font-weight: 700;">Attribute</th>
                        <th style="padding: 24px; width: 35%; text-align: center; border-right: 1px solid rgba(255,255,255,0.08); color: #e04385; font-size: 16px; font-weight: 700;">{{ $tool1->name }}</th>
                        <th style="padding: 24px; width: 35%; text-align: center; color: #3b82f6; font-size: 16px; font-weight: 700;">{{ $tool2->name }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 18px 24px; font-weight: 600; color: var(--text-secondary);">AI Classification Type</td>
                        <td style="padding: 18px 24px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08);">{{ $tool1->ai_type ?? 'General AI' }}</td>
                        <td style="padding: 18px 24px; text-align: center;">{{ $tool2->ai_type ?? 'General AI' }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.01);">
                        <td style="padding: 18px 24px; font-weight: 600; color: var(--text-secondary);">TechScore</td>
                        <td style="padding: 18px 24px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08); font-weight: 800; color: #e04385; font-size: 18px;">{{ $tool1->score }} / 100</td>
                        <td style="padding: 18px 24px; text-align: center; font-weight: 800; color: #3b82f6; font-size: 18px;">{{ $tool2->score }} / 100</td>
                    </tr>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 18px 24px; font-weight: 600; color: var(--text-secondary);">Rating</td>
                        <td style="padding: 18px 24px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08);">
                            <span style="color: #ffc107; font-weight: 700;"><i class="fa-solid fa-star"></i> {{ $t1Rating }} / 5.0</span>
                            <div style="font-size: 12px; color: var(--text-secondary);">({{ $tool1->reviews->where('status', 'approved')->count() }} reviews)</div>
                        </td>
                        <td style="padding: 18px 24px; text-align: center;">
                            <span style="color: #ffc107; font-weight: 700;"><i class="fa-solid fa-star"></i> {{ $t2Rating }} / 5.0</span>
                            <div style="font-size: 12px; color: var(--text-secondary);">({{ $tool2->reviews->where('status', 'approved')->count() }} reviews)</div>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.01);">
                        <td style="padding: 18px 24px; font-weight: 600; color: var(--text-secondary);">Pricing</td>
                        <td style="padding: 18px 24px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08);">{{ $tool1->pricing_text ?? ($tool1->tier->name ?? 'Free') }}</td>
                        <td style="padding: 18px 24px; text-align: center;">{{ $tool2->pricing_text ?? ($tool2->tier->name ?? 'Free') }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 18px 24px; font-weight: 600; color: var(--text-secondary);">Verified Status</td>
                        <td style="padding: 18px 24px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08);">
                            @if($tool1->is_verified || $tool1->is_claimed)
                                <span style="color: #10b981; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> Verified</span>
                            @else
                                <span style="color: #f59e0b; font-weight: 700;"><i class="fa-solid fa-shield"></i> Unverified</span>
                            @endif
                        </td>
                        <td style="padding: 18px 24px; text-align: center;">
                            @if($tool2->is_verified || $tool2->is_claimed)
                                <span style="color: #10b981; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> Verified</span>
                            @else
                                <span style="color: #f59e0b; font-weight: 700;"><i class="fa-solid fa-shield"></i> Unverified</span>
                            @endif
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.01);">
                        <td style="padding: 18px 24px; font-weight: 600; color: var(--text-secondary);">Key Advantages</td>
                        <td style="padding: 18px 24px; text-align: left; border-right: 1px solid rgba(255,255,255,0.08);">
                            @if(!empty($tool1->pros))
                                <ul style="padding-left: 18px; margin: 0; font-size: 13px;">
                                    @foreach($tool1->pros as $p)
                                        <li style="margin-bottom: 4px;">{{ $p }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span style="color: var(--text-secondary); font-size: 13px;">Enterprise AI Workflow</span>
                            @endif
                        </td>
                        <td style="padding: 18px 24px; text-align: left;">
                            @if(!empty($tool2->pros))
                                <ul style="padding-left: 18px; margin: 0; font-size: 13px;">
                                    @foreach($tool2->pros as $p)
                                        <li style="margin-bottom: 4px;">{{ $p }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span style="color: var(--text-secondary); font-size: 13px;">Enterprise AI Workflow</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px;"></td>
                        <td style="padding: 24px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08);">
                            <a href="{{ route('frontend.tools.show', $tool1->slug) }}" class="btn-cta-pink" style="text-decoration: none; display: inline-block;">View {{ $tool1->name }} Profile</a>
                        </td>
                        <td style="padding: 24px; text-align: center;">
                            <a href="{{ route('frontend.tools.show', $tool2->slug) }}" class="btn-cta-pink" style="background: linear-gradient(90deg, #3b82f6 0%, #60a5fa 100%); text-decoration: none; display: inline-block;">View {{ $tool2->name }} Profile</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@push('scripts')
@if($tool1 && $tool2)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['TechScore', 'Rating', 'Verified', 'Categories', 'Featured'],
                datasets: [
                    {
                        label: "{{ $tool1->name }}",
                        data: [{{ $t1Score }}, {{ $t1RatingScore }}, {{ $t1VerifiedScore }}, {{ $t1CategoryScore }}, {{ $t1FeaturedScore }}],
                        backgroundColor: '#e04385',
                        borderRadius: 8
                    },
                    {
                        label: "{{ $tool2->name }}",
                        data: [{{ $t2Score }}, {{ $t2RatingScore }}, {{ $t2VerifiedScore }}, {{ $t2CategoryScore }}, {{ $t2FeaturedScore }}],
                        backgroundColor: '#3b82f6',
                        borderRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9a8c9e', font: { family: 'Plus Jakarta Sans', weight: '600' } }
                    },
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.08)' },
                        ticks: { color: '#9a8c9e', font: { family: 'Plus Jakarta Sans' } },
                        min: 0,
                        max: 100
                    }
                },
                plugins: {
                    legend: { labels: { color: '#ffffff', font: { family: 'Plus Jakarta Sans', weight: '700' } } }
                }
            }
        });
    });
</script>
@endif
@endpush

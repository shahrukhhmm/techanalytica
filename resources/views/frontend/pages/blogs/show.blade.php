@extends('frontend.layout.app')

@section('title', ($blog->meta_title ?: $blog->title) . ' | TechAnalytica Editorial')
@section('meta_description', $blog->meta_description ?? Str::limit(strip_tags($blog->body), 160))

@push('styles')
<style>
    /* =============================================
       BLOG DETAIL — FIGMA ARTICLE REDESIGN (Image 3)
       ============================================= */
    .art-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-secondary);
        margin: 28px 0 20px;
    }
    .art-breadcrumb a {
        color: var(--text-secondary);
        text-decoration: none;
    }
    .art-breadcrumb a:hover {
        color: #ff3b7b;
    }
    .art-breadcrumb i {
        font-size: 10px;
        opacity: 0.6;
    }

    /* Article Hero Header */
    .art-header {
        max-width: 900px;
        margin-bottom: 30px;
    }
    .art-badges-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }
    .art-badge-pill {
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        background: rgba(255, 59, 123, 0.15);
        color: #ff3b7b;
        border: 1px solid rgba(255, 59, 123, 0.28);
    }
    .art-title {
        font-size: clamp(32px, 4.2vw, 48px);
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.03em;
        color: #ffffff;
        margin-bottom: 16px;
    }
    .art-title .highlight-text {
        background: linear-gradient(90deg, #ff3b7b, #ff735c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .art-sub {
        font-size: 17px;
        color: var(--text-secondary);
        line-height: 1.65;
        margin-bottom: 24px;
    }
    .art-author-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        flex-wrap: wrap;
        gap: 16px;
    }
    .art-author-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .author-circle-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff3b7b, #ff735c);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
    }
    .author-details-box div:first-child {
        font-size: 14.5px;
        font-weight: 700;
        color: #fff;
    }
    .author-details-box div:last-child {
        font-size: 12.5px;
        color: var(--text-secondary);
    }
    .art-share-icons {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .art-share-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .art-share-btn:hover {
        background: rgba(255, 59, 123, 0.18);
        color: #fff;
        border-color: #ff3b7b;
    }

    /* Hero Article Graphic (From Image 3) */
    .art-hero-banner-card {
        background: linear-gradient(135deg, #3d152a 0%, #1f0b20 50%, #110515 100%);
        border: 1px solid rgba(255, 59, 123, 0.25);
        border-radius: 26px;
        height: 360px;
        position: relative;
        overflow: hidden;
        margin-bottom: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
    }
    .hero-bubble-1 {
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, #ff735c 0%, #ff3b7b 60%, transparent 100%);
        top: 20px;
        left: 80px;
        opacity: 0.65;
        filter: blur(20px);
    }
    .hero-bubble-2 {
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, #ffa07a 0%, #ff3b7b 50%, #9f55ff 85%, transparent 100%);
        bottom: 20px;
        right: 120px;
        opacity: 0.75;
        filter: blur(25px);
    }
    .hero-cube-visual {
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 24px;
        background: linear-gradient(135deg, #ff8359, #ff3b7b);
        box-shadow: 0 20px 40px rgba(255, 59, 123, 0.4);
        right: 160px;
        top: 130px;
        transform: rotate(12deg);
    }

    /* 3-Column Layout */
    .art-body-layout {
        display: grid;
        grid-template-columns: 220px 1fr 280px;
        gap: 40px;
        align-items: start;
        margin-bottom: 70px;
    }

    /* Left Sticky Sidebar (TOC) */
    .art-sticky-left {
        position: sticky;
        top: 90px;
    }
    .toc-title {
        font-size: 11px;
        font-weight: 800;
        color: #ff3b7b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 14px;
    }
    .toc-links {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 30px;
        padding-left: 0;
    }
    .toc-link-item a {
        font-size: 13px;
        color: var(--text-secondary);
        text-decoration: none;
        line-height: 1.45;
        transition: color 0.2s;
        display: block;
    }
    .toc-link-item a:hover {
        color: #fff;
    }

    /* Center Content Column */
    .art-main-content {
        color: #d6ccdc;
        font-size: 16px;
        line-height: 1.8;
    }
    .art-main-content h2 {
        font-size: 24px;
        font-weight: 800;
        color: #ffffff;
        margin: 36px 0 16px;
        line-height: 1.3;
        letter-spacing: -0.02em;
    }
    .art-main-content p {
        margin-bottom: 20px;
    }

    /* Inline Graphic Card (From Image 3) */
    .art-inline-graphic {
        background: linear-gradient(135deg, #230b19, #130615);
        border: 1px solid rgba(255, 59, 123, 0.2);
        border-radius: 20px;
        height: 240px;
        position: relative;
        overflow: hidden;
        margin: 30px 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .inline-cube {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        background: linear-gradient(135deg, #ffa07a, #ff3b7b);
        box-shadow: 0 10px 25px rgba(255, 59, 123, 0.35);
        transform: rotate(-10deg);
        position: absolute;
        left: 120px;
    }
    .inline-circle {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: radial-gradient(circle, #ff735c 0%, #8b28a0 70%, transparent 100%);
        position: absolute;
        right: 120px;
        opacity: 0.6;
        filter: blur(12px);
    }

    /* Stat Highlight Cards (From Image 3) */
    .art-stats-card {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 59, 123, 0.25);
        border-radius: 18px;
        padding: 24px 28px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin: 32px 0;
        text-align: center;
    }
    .art-stat-num {
        font-size: 34px;
        font-weight: 800;
        color: #ff3b7b;
        line-height: 1;
        margin-bottom: 6px;
    }
    .art-stat-lbl {
        font-size: 12px;
        color: var(--text-secondary);
        line-height: 1.35;
    }

    /* Quote Callout inside article */
    .art-quote-block {
        background: rgba(255, 59, 123, 0.08);
        border-left: 3px solid #ff3b7b;
        border-radius: 0 16px 16px 0;
        padding: 24px 28px;
        margin: 32px 0;
        font-size: 18px;
        font-style: italic;
        color: #ffffff;
        line-height: 1.6;
    }

    /* Insight Alert Box */
    .art-insight-box {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 20px 24px;
        margin: 28px 0;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    .art-insight-box i {
        color: #ff3b7b;
        font-size: 20px;
        margin-top: 2px;
    }

    /* Actionable Playbook Steps */
    .playbook-steps-list {
        list-style: none;
        padding-left: 0;
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin: 24px 0;
    }
    .playbook-step-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        font-size: 15px;
        color: #d6ccdc;
    }
    .step-number-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(255, 59, 123, 0.15);
        color: #ff3b7b;
        font-weight: 800;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* Tags Row */
    .art-tags-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin: 36px 0 28px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    .art-tag-pill {
        font-size: 12.5px;
        color: var(--text-secondary);
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 4px 12px;
        border-radius: 9999px;
        text-decoration: none;
    }
    .art-tag-pill:hover {
        color: #fff;
        border-color: rgba(255, 59, 123, 0.35);
    }

    /* Author Bio Card */
    .art-author-card {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 30px;
    }
    .author-card-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff3b7b, #9f55ff);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .author-card-content h4 {
        font-size: 16.5px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 4px;
    }
    .author-card-content p {
        font-size: 13.5px;
        color: var(--text-secondary);
        line-height: 1.5;
        margin-bottom: 0;
    }

    /* Right Sticky Sidebar */
    .art-sticky-right {
        position: sticky;
        top: 90px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    .right-newsletter-card {
        background: linear-gradient(145deg, rgba(30, 14, 38, 0.92), rgba(18, 8, 24, 0.96));
        border: 1px solid rgba(255, 59, 123, 0.25);
        border-radius: 20px;
        padding: 24px;
    }
    .right-trending-card {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 24px;
    }
    .trending-item {
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        text-decoration: none;
        display: block;
    }
    .trending-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .trending-item h5 {
        font-size: 13.5px;
        font-weight: 700;
        color: #fff;
        line-height: 1.4;
        margin-bottom: 4px;
        transition: color 0.2s;
    }
    .trending-item:hover h5 {
        color: #ff3b7b;
    }
    .trending-item span {
        font-size: 11.5px;
        color: var(--text-secondary);
    }

    /* Related Reads (3-Grid From Image 3) */
    .related-reads-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin: 24px 0 60px;
    }
    .related-read-card {
        background: rgba(20, 10, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
    }
    .related-read-card:hover {
        border-color: rgba(255, 59, 123, 0.35);
        transform: translateY(-3px);
    }
    .related-banner-art {
        height: 120px;
    }

    @media (max-width: 1040px) {
        .art-body-layout {
            grid-template-columns: 1fr 280px;
        }
        .art-sticky-left {
            display: none;
        }
    }
    @media (max-width: 820px) {
        .art-body-layout {
            grid-template-columns: 1fr;
        }
        .art-hero-banner-card {
            height: 240px;
        }
        .related-reads-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- 1. BREADCRUMBS -->
    <div class="art-breadcrumb">
        <a href="{{ route('frontend.home') }}">Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('frontend.blogs') }}">Editorial Hub</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span style="color: #ff735c;">{{ $blog->category ? $blog->category->name : 'Deep Dives' }}</span>
    </div>

    <!-- 2. ARTICLE HEADER -->
    <div class="art-header">
        <div class="art-badges-row">
            <span class="art-badge-pill"><i class="fa-solid fa-book-open"></i> CASE STUDY</span>
            <span class="art-badge-pill" style="color: #ff735c; background: rgba(255,115,92,0.15); border-color: rgba(255,115,92,0.28);">{{ $blog->category ? $blog->category->name : 'AI & ML' }}</span>
        </div>

        <h1 class="art-title">
            {{ $blog->title }}
        </h1>

        <p class="art-sub">
            {{ $blog->meta_description ?? 'How an eight-person team rewrote a multi-million line legacy codebase in six weeks, cut infrastructure costs by 70%, and out-shipped public SaaS incumbents.' }}
        </p>

        <div class="art-author-meta">
            <div class="art-author-info">
                <div class="author-circle-avatar">
                    {{ $blog->author ? strtoupper(substr($blog->author->name, 0, 2)) : 'AR' }}
                </div>
                <div class="author-details-box">
                    <div>{{ $blog->author ? $blog->author->name : 'Alex Rivera' }}</div>
                    <div>Published {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'Jan 14, 2026' }} • 8 min read</div>
                </div>
            </div>

            <div class="art-share-icons">
                <span style="font-size: 12px; color: var(--text-secondary); margin-right: 4px;">Share:</span>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="art-share-btn" aria-label="Twitter"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="art-share-btn" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="javascript:void(0)" onclick="navigator.clipboard.writeText(window.location.href); alert('Article link copied to clipboard!');" class="art-share-btn" aria-label="Copy Link"><i class="fa-solid fa-link"></i></a>
            </div>
        </div>
    </div>

    <!-- 3. HERO ARTICLE GRAPHIC (Matching Image 3) -->
    <div class="art-hero-banner-card">
        @if($blog->image)
            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" style="width:100%; height:100%; object-fit:cover;">
            <div style="display:none; width:100%; height:100%; position:relative;">
                <div class="hero-bubble-1"></div>
                <div class="hero-bubble-2"></div>
                <div class="hero-cube-visual"></div>
            </div>
        @else
            <div class="hero-bubble-1"></div>
            <div class="hero-bubble-2"></div>
            <div class="hero-cube-visual"></div>
        @endif
    </div>

    <!-- 4. 3-COLUMN ARTICLE BODY -->
    <div class="art-body-layout">
        <!-- Left Column: Sticky Table of Contents -->
        <div class="art-sticky-left">
            <div class="toc-title">IN THIS ARTICLE</div>
            <ul class="toc-links">
                <li class="toc-link-item"><a href="#conditions-changed">Why now: conditions changed</a></li>
                <li class="toc-link-item"><a href="#fast-patterns">17 fast patterns we kept seeing</a></li>
                <li class="toc-link-item"><a href="#data-says">What the telemetry data says</a></li>
                <li class="toc-link-item"><a href="#playbook">The playbook for your team</a></li>
                <li class="toc-link-item"><a href="#takeaways">Final takeaways</a></li>
            </ul>

            <div style="padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.08);">
                <span style="font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Saved Reading</span>
                <p style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Press <kbd style="background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px;">Ctrl+D</kbd> to bookmark for your engineering team.</p>
            </div>
        </div>

        <!-- Center Column: Main Article Content -->
        <div class="art-main-content">
            {!! $blog->body !!}

            <h2 id="conditions-changed">Why now: the conditions changed</h2>
            <p>
                In legacy SaaS organizations, architectural inertia is the silent productivity tax. Multi-tiered microservices, cross-team sprint syncs, and manual code review gates turned simple feature additions into multi-month initiatives. But in early 2026, autonomous context-aware developer tooling made a complete structural rethink not just viable, but necessary.
            </p>

            <div class="art-inline-graphic">
                <div class="inline-cube"></div>
                <div class="inline-circle"></div>
            </div>

            <h2 id="fast-patterns">17 fast patterns we kept seeing</h2>
            <p>
                Across 45 high-velocity engineering organizations surveyed by TechAnalytica, the top 10% highest-shipping teams consistently eliminated ceremonial gates in favor of automated invariant verification:
            </p>

            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 10px;">Consolidated distributed RPC interfaces into single high-concurrency monoliths.</li>
                <li style="margin-bottom: 10px;">Replaced manual staging cluster validation with synthetic canary test suites.</li>
                <li style="margin-bottom: 10px;">Adopted multi-file LLM agentic refactoring tools for rapid architectural migration.</li>
                <li style="margin-bottom: 10px;">Standardized on SQL databases with vector extensions rather than fragmented polyglot persistence.</li>
            </ul>

            <div class="art-quote-block">
                "The fastest team wins not because they work more hours, but because their latency between idea and production is measured in minutes, not quarters."
            </div>

            <h2 id="data-says">What the telemetry data says</h2>
            <p>
                Benchmarking 1,200 developer repositories showed clear performance divergence between traditional enterprise teams and lean, AI-orchestrated engineering units:
            </p>

            <div class="art-stats-card">
                <div>
                    <div class="art-stat-num">3.4X</div>
                    <div class="art-stat-lbl">Shipping Speed Increase</div>
                </div>
                <div>
                    <div class="art-stat-num" style="color: #ff735c;">68%</div>
                    <div class="art-stat-lbl">Lower Cloud Compute Spend</div>
                </div>
                <div>
                    <div class="art-stat-num" style="color: #9f55ff;">$54k</div>
                    <div class="art-stat-lbl">Annual Savings per Dev Seat</div>
                </div>
            </div>

            <div class="art-insight-box">
                <i class="fa-solid fa-lightbulb"></i>
                <div>
                    <strong style="color: #fff; display: block; margin-bottom: 4px;">Key Telemetry Insight:</strong>
                    Autonomous review agents that generate test coverage and verify lint invariance reduced pull request lifecycle latency from 4.2 days down to 48 minutes.
                </div>
            </div>

            <h2 id="playbook">The playbook for your team</h2>
            <p>
                If you are looking to out-ship competitors without adding headcount, execute these four tactical steps this quarter:
            </p>

            <ul class="playbook-steps-list">
                <li class="playbook-step-item">
                    <div class="step-number-circle">1</div>
                    <div><strong>Consolidate microservices:</strong> Collapse distributed API boundaries into unified monorepos with strict module boundaries.</div>
                </li>
                <li class="playbook-step-item">
                    <div class="step-number-circle">2</div>
                    <div><strong>Mandate agentic test creation:</strong> Let AI generate regression tests alongside every pull request.</div>
                </li>
                <li class="playbook-step-item">
                    <div class="step-number-circle">3</div>
                    <div><strong>Eliminate manual staging environments:</strong> Shift to ephemeral preview branches with sanitized production snapshots.</div>
                </li>
                <li class="playbook-step-item">
                    <div class="step-number-circle">4</div>
                    <div><strong>Automate telemetry monitoring:</strong> Deploy automated canary rollback based on real-time APM error metrics.</div>
                </li>
            </ul>

            <h2 id="takeaways">Final takeaways</h2>
            <p>
                The competitive landscape of software in 2026 has irrevocably shifted. The advantage no longer belongs to the company with the largest headcount, but to the team with the lowest friction between insight and deployment.
            </p>

            <div class="art-tags-row">
                <a href="{{ route('frontend.blogs') }}" class="art-tag-pill">#ai-tools</a>
                <a href="{{ route('frontend.blogs') }}" class="art-tag-pill">#engineering</a>
                <a href="{{ route('frontend.blogs') }}" class="art-tag-pill">#saas</a>
                <a href="{{ route('frontend.blogs') }}" class="art-tag-pill">#startups</a>
                <a href="{{ route('frontend.blogs') }}" class="art-tag-pill">#devops</a>
            </div>

            <!-- Author Bio Card -->
            <div class="art-author-card">
                <div class="author-card-avatar">AR</div>
                <div class="author-card-content">
                    <h4>Written by {{ $blog->author ? $blog->author->name : 'Alex Rivera' }}</h4>
                    <p>Contributing Editor at TechAnalytica. Former Principal Architect at CloudScale. Writes on software architecture, AI infrastructure, and engineering velocity.</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Sticky Newsletter & Trending Stories -->
        <div class="art-sticky-right">
            <div class="right-newsletter-card">
                <h4 style="font-size: 16px; font-weight: 800; color: #fff; margin-bottom: 6px;">Get our weekly digest</h4>
                <p style="font-size: 12.5px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 14px;">The top 1% of software benchmarks, delivered every Tuesday.</p>
                <form action="javascript:void(0)" onsubmit="alert('Thank you for subscribing!')" style="display: flex; flex-direction: column; gap: 8px;">
                    <input type="email" placeholder="Your work email" required style="padding: 10px 14px; border-radius: 10px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: #fff; font-size: 13px; outline: none;">
                    <button type="submit" style="background: linear-gradient(90deg, #ff3b7b, #ff735c); color: #fff; border: none; padding: 10px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer;">Subscribe</button>
                </form>
            </div>

            <div class="right-trending-card">
                <div style="font-size: 11px; font-weight: 800; color: #ff3b7b; text-transform: uppercase; margin-bottom: 12px;">TRENDING STORIES</div>
                @foreach($recentBlogs->take(4) as $rb)
                    <a href="{{ route('frontend.blogs.show', $rb->slug) }}" class="trending-item">
                        <h5>{{ Str::limit($rb->title, 65) }}</h5>
                        <span>{{ $rb->created_at ? $rb->created_at->format('M d, Y') : 'Jan 2026' }} • 5 min read</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 5. RELATED READS SECTION (Matching Image 3) -->
    <section style="margin-bottom: 50px;">
        <div class="section-eyebrow">
            <div class="section-eyebrow-square"></div>
            <span>Related Reads</span>
        </div>

        <div class="related-reads-grid">
            <a href="{{ route('frontend.blogs') }}" class="related-read-card">
                <div class="related-banner-art" style="background: linear-gradient(135deg, #4d592b, #2b3515);"></div>
                <div style="padding: 20px;">
                    <span class="art-badge-pill" style="font-size: 10px; padding: 3px 8px;">TECH ANALYSIS</span>
                    <h4 style="font-size: 15px; font-weight: 700; color: #fff; margin: 8px 0;">Why database layer retrieval is replacing vector search hype</h4>
                    <span style="font-size: 12px; color: var(--text-secondary);">6 min read</span>
                </div>
            </a>

            <a href="{{ route('frontend.blogs') }}" class="related-read-card">
                <div class="related-banner-art" style="background: linear-gradient(135deg, #1b3548, #0f1c29);"></div>
                <div style="padding: 20px;">
                    <span class="art-badge-pill" style="font-size: 10px; padding: 3px 8px; color: #10b981; background: rgba(16,185,129,0.15); border-color: rgba(16,185,129,0.25);">ENGINEERING</span>
                    <h4 style="font-size: 15px; font-weight: 700; color: #fff; margin: 8px 0;">Microservices retreat: monolith revival in high-scale SaaS</h4>
                    <span style="font-size: 12px; color: var(--text-secondary);">7 min read</span>
                </div>
            </a>

            <a href="{{ route('frontend.blogs') }}" class="related-read-card">
                <div class="related-banner-art" style="background: linear-gradient(135deg, #ff735c, #ff3b7b);"></div>
                <div style="padding: 20px;">
                    <span class="art-badge-pill" style="font-size: 10px; padding: 3px 8px; color: #ff735c; background: rgba(255,115,92,0.15); border-color: rgba(255,115,92,0.25);">GROWTH</span>
                    <h4 style="font-size: 15px; font-weight: 700; color: #fff; margin: 8px 0;">Zero-CAC distribution playbooks for technical SaaS founders</h4>
                    <span style="font-size: 12px; color: var(--text-secondary);">9 min read</span>
                </div>
            </a>
        </div>
    </section>

</div>

<!-- 6. PRE-FOOTER CTA SECTION -->
@include('frontend.components.newsletter_section')

@endsection

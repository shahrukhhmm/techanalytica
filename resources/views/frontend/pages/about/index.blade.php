@extends('frontend.layout.app')

@section('title', 'About TechAnalytica - The AI Software Intelligence Platform')

@push('styles')
<style>
    /* ── About Page Styles ─────────────────────────────────────── */
    .about-hero {
        padding: 80px 0 60px;
        text-align: center;
        position: relative;
    }

    .about-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 59, 123, 0.12);
        border: 1px solid rgba(255, 59, 123, 0.3);
        border-radius: 9999px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #ff7bb3;
        margin-bottom: 28px;
        letter-spacing: 0.02em;
    }

    .about-hero-title {
        font-size: clamp(36px, 5.5vw, 68px);
        font-weight: 800;
        color: #ffffff;
        line-height: 1.1;
        letter-spacing: -0.03em;
        margin-bottom: 22px;
        max-width: 820px;
        margin-left: auto;
        margin-right: auto;
    }

    .about-hero-subtitle {
        font-size: clamp(16px, 2vw, 19px);
        color: var(--text-secondary);
        line-height: 1.7;
        max-width: 640px;
        margin: 0 auto 44px;
    }

    .about-hero-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* ── Stats Bar ─────────────────────────────────────────────── */
    .stats-bar {
        padding: 48px 0 60px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 20px;
        overflow: hidden;
    }

    .stat-item {
        padding: 36px 28px;
        background: rgba(14, 7, 20, 0.7);
        text-align: center;
        position: relative;
        transition: background 0.2s ease;
    }

    .stat-item:hover {
        background: rgba(255, 59, 123, 0.06);
    }

    .stat-item + .stat-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        bottom: 20%;
        width: 1px;
        background: rgba(255, 255, 255, 0.07);
    }

    .stat-number {
        font-size: clamp(36px, 4vw, 52px);
        font-weight: 800;
        background: var(--button-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.03em;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-secondary);
        font-weight: 500;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    /* ── Mission Section ───────────────────────────────────────── */
    .mission-section {
        padding: 60px 0 80px;
    }

    .mission-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .mission-label {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #ff7bb3;
        margin-bottom: 16px;
    }

    .mission-title {
        font-size: clamp(28px, 3.5vw, 42px);
        font-weight: 800;
        color: #fff;
        line-height: 1.18;
        letter-spacing: -0.025em;
        margin-bottom: 20px;
    }

    .mission-desc {
        font-size: 16px;
        color: var(--text-secondary);
        line-height: 1.75;
        margin-bottom: 20px;
    }

    .mission-bullets {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .mission-bullets li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 15px;
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .bullet-icon {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: rgba(255, 59, 123, 0.15);
        color: #ff3b7b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ── Visual Panel ──────────────────────────────────────────── */
    .mission-visual-card {
        background: linear-gradient(135deg, rgba(26, 13, 34, 0.9) 0%, rgba(16, 7, 22, 0.95) 100%);
        border: 1px solid rgba(255, 59, 123, 0.2);
        border-radius: 24px;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .mission-visual-card::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255, 59, 123, 0.18) 0%, transparent 70%);
        pointer-events: none;
    }

    .visual-metric-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .visual-metric-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .visual-metric-label {
        font-size: 14px;
        color: var(--text-secondary);
        font-weight: 500;
        min-width: 160px;
    }

    .visual-metric-bar-wrap {
        flex: 1;
        height: 6px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 3px;
        overflow: hidden;
    }

    .visual-metric-bar {
        height: 100%;
        border-radius: 3px;
        background: var(--button-gradient);
    }

    .visual-metric-value {
        font-size: 13px;
        font-weight: 700;
        color: #ff7bb3;
        min-width: 36px;
        text-align: right;
    }

    /* ── How It Works ──────────────────────────────────────────── */
    .how-section {
        padding: 80px 0;
    }

    .section-tag-about {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #ff7bb3;
        margin-bottom: 12px;
    }

    .section-title-about {
        font-size: clamp(26px, 3.5vw, 40px);
        font-weight: 800;
        color: #fff;
        line-height: 1.18;
        letter-spacing: -0.025em;
        margin-bottom: 14px;
    }

    .section-desc-about {
        font-size: 16px;
        color: var(--text-secondary);
        line-height: 1.7;
        max-width: 580px;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 52px;
    }

    .step-card {
        background: rgba(20, 9, 26, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 20px;
        padding: 36px 30px;
        transition: border-color 0.25s ease, transform 0.25s ease;
    }

    .step-card:hover {
        border-color: rgba(255, 59, 123, 0.3);
        transform: translateY(-4px);
    }

    .step-number {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.1em;
        color: rgba(255, 59, 123, 0.6);
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .step-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: rgba(255, 59, 123, 0.12);
        border: 1px solid rgba(255, 59, 123, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ff7bb3;
        margin-bottom: 20px;
    }

    .step-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 10px;
    }

    .step-desc {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.7;
    }

    /* ── Values Section ────────────────────────────────────────── */
    .values-section {
        padding: 80px 0;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-top: 52px;
    }

    .value-card {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        background: rgba(20, 9, 26, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 18px;
        padding: 28px;
        transition: border-color 0.25s ease;
    }

    .value-card:hover {
        border-color: rgba(255, 59, 123, 0.25);
    }

    .value-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255, 59, 123, 0.12);
        color: #ff7bb3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .value-title {
        font-size: 17px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }

    .value-desc {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.7;
    }

    /* ── Team Section ──────────────────────────────────────────── */
    .team-section {
        padding: 80px 0;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-top: 52px;
    }

    .team-card {
        background: rgba(20, 9, 26, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 20px;
        padding: 32px 24px;
        text-align: center;
        transition: border-color 0.25s ease, transform 0.25s ease;
    }

    .team-card:hover {
        border-color: rgba(255, 59, 123, 0.3);
        transform: translateY(-4px);
    }

    .team-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--button-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 800;
        color: #fff;
        margin: 0 auto 16px;
        border: 2px solid rgba(255, 59, 123, 0.3);
    }

    .team-name {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }

    .team-role {
        font-size: 13px;
        color: #ff7bb3;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .team-bio {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.65;
    }

    .team-social {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 16px;
    }

    .team-social a {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .team-social a:hover {
        background: rgba(255, 59, 123, 0.15);
        border-color: var(--accent-pink);
        color: #fff;
    }

    /* ── Trusted By ─────────────────────────────────────────────── */
    .trusted-section {
        padding: 60px 0 80px;
        text-align: center;
    }

    .trusted-label {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 32px;
    }

    .trusted-logos {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .trusted-logo-item {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 12px;
        padding: 14px 24px;
        font-size: 14px;
        font-weight: 700;
        color: var(--text-secondary);
        letter-spacing: 0.02em;
        transition: all 0.2s ease;
    }

    .trusted-logo-item:hover {
        border-color: rgba(255, 59, 123, 0.25);
        color: #fff;
        background: rgba(255, 59, 123, 0.06);
    }

    /* ── CTA ────────────────────────────────────────────────────── */
    .about-cta-section {
        padding: 80px 0 100px;
    }

    .about-cta-card {
        background: linear-gradient(135deg, rgba(255, 59, 123, 0.12) 0%, rgba(26, 13, 34, 0.95) 60%);
        border: 1px solid rgba(255, 59, 123, 0.3);
        border-radius: 28px;
        padding: 64px 56px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .about-cta-card::before {
        content: '';
        position: absolute;
        top: -60px;
        left: 50%;
        transform: translateX(-50%);
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(255, 59, 123, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .about-cta-title {
        font-size: clamp(28px, 4vw, 46px);
        font-weight: 800;
        color: #fff;
        line-height: 1.15;
        letter-spacing: -0.025em;
        margin-bottom: 16px;
    }

    .about-cta-desc {
        font-size: 17px;
        color: var(--text-secondary);
        line-height: 1.7;
        max-width: 540px;
        margin: 0 auto 36px;
    }

    /* ── Responsive ─────────────────────────────────────────────── */
    @media (max-width: 992px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .mission-grid { grid-template-columns: 1fr; gap: 40px; }
        .steps-grid { grid-template-columns: repeat(2, 1fr); }
        .team-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .steps-grid, .values-grid, .team-grid { grid-template-columns: 1fr; }
        .about-cta-card { padding: 40px 24px; }
        .about-hero-cta { flex-direction: column; align-items: center; }
        .visual-metric-label { min-width: 120px; }
    }
</style>
@endpush

@section('content')

    {{-- About Hero --}}
    <section class="about-hero">
        <div class="container">
            <span class="about-badge"><i class="fa-solid fa-building-columns"></i> Our Story</span>
            <h1 class="about-hero-title">
                The Intelligence Layer for <span class="gradient-text">AI Software Discovery</span>
            </h1>
            <p class="about-hero-subtitle">
                TechAnalytica is the trusted platform where technology buyers, analysts, and innovators
                discover, evaluate, and compare AI-powered software — backed by verified user reviews and
                deep data-driven insights.
            </p>
            <div class="about-hero-cta">
                <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink">
                    <i class="fa-solid fa-layer-group"></i> Explore AI Tools
                </a>
                <a href="{{ route('frontend.vendors.index') }}" class="btn-cta-outline">
                    <i class="fa-solid fa-briefcase"></i> For Vendors
                </a>
            </div>
        </div>
    </section>

    {{-- Stats Bar --}}
    <section class="stats-bar">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $totalTools > 0 ? number_format($totalTools) . '+' : '500+' }}</div>
                    <div class="stat-label">AI Tools Listed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $totalReviews > 0 ? number_format($totalReviews) . '+' : '14K+' }}</div>
                    <div class="stat-label">Verified Reviews</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $totalCategories > 0 ? $totalCategories . '+' : '40+' }}</div>
                    <div class="stat-label">Software Categories</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">2M+</div>
                    <div class="stat-label">Monthly Readers</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission Section --}}
    <section class="mission-section">
        <div class="container">
            <div class="mission-grid">
                <div>
                    <span class="mission-label">Our Mission</span>
                    <h2 class="mission-title">Empowering smarter technology decisions through honest intelligence</h2>
                    <p class="mission-desc">
                        In a world where AI tools are launched daily, choosing the right software stack is harder than ever.
                        TechAnalytica cuts through the noise — providing structured, independent, and continuously updated
                        analysis that helps teams make confident technology investments.
                    </p>
                    <ul class="mission-bullets">
                        <li>
                            <span class="bullet-icon"><i class="fa-solid fa-check"></i></span>
                            <span>Independent editorial reviews based on real-world testing, not sponsored rankings.</span>
                        </li>
                        <li>
                            <span class="bullet-icon"><i class="fa-solid fa-check"></i></span>
                            <span>Verified user reviews from actual enterprise and SMB software buyers.</span>
                        </li>
                        <li>
                            <span class="bullet-icon"><i class="fa-solid fa-check"></i></span>
                            <span>Live pricing data, AI capability scoring, and feature comparison matrices.</span>
                        </li>
                        <li>
                            <span class="bullet-icon"><i class="fa-solid fa-check"></i></span>
                            <span>Deep category guides written by subject-matter experts and practitioners.</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="mission-visual-card">
                        <div style="font-size: 13px; font-weight: 700; color: #ff7bb3; margin-bottom: 24px; letter-spacing: 0.06em; text-transform: uppercase;">
                            <i class="fa-solid fa-chart-bar"></i>&nbsp; Platform Trust Metrics
                        </div>
                        <div class="visual-metric-list">
                            <div class="visual-metric-item">
                                <span class="visual-metric-label">Review Verification</span>
                                <div class="visual-metric-bar-wrap">
                                    <div class="visual-metric-bar" style="width: 98%;"></div>
                                </div>
                                <span class="visual-metric-value">98%</span>
                            </div>
                            <div class="visual-metric-item">
                                <span class="visual-metric-label">AI Accuracy Score</span>
                                <div class="visual-metric-bar-wrap">
                                    <div class="visual-metric-bar" style="width: 94%;"></div>
                                </div>
                                <span class="visual-metric-value">94%</span>
                            </div>
                            <div class="visual-metric-item">
                                <span class="visual-metric-label">Data Freshness</span>
                                <div class="visual-metric-bar-wrap">
                                    <div class="visual-metric-bar" style="width: 100%;"></div>
                                </div>
                                <span class="visual-metric-value">Live</span>
                            </div>
                            <div class="visual-metric-item">
                                <span class="visual-metric-label">Editorial Independence</span>
                                <div class="visual-metric-bar-wrap">
                                    <div class="visual-metric-bar" style="width: 100%;"></div>
                                </div>
                                <span class="visual-metric-value">100%</span>
                            </div>
                            <div class="visual-metric-item">
                                <span class="visual-metric-label">Buyer Satisfaction</span>
                                <div class="visual-metric-bar-wrap">
                                    <div class="visual-metric-bar" style="width: 92%;"></div>
                                </div>
                                <span class="visual-metric-value">92%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="how-section">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag-about">How It Works</span>
                <h2 class="section-title-about">From discovery to decision, in minutes</h2>
                <p class="section-desc-about" style="margin: 0 auto;">
                    TechAnalytica's intelligence engine simplifies the entire software evaluation lifecycle for buyers and vendors alike.
                </p>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">Step 01</div>
                    <div class="step-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <div class="step-title">Discover</div>
                    <p class="step-desc">
                        Search across {{ $totalTools > 0 ? number_format($totalTools) . '+' : '500+' }} AI tools by category, pricing model, or AI capability. Filter by integrations, team size, and verified ratings.
                    </p>
                </div>
                <div class="step-card">
                    <div class="step-number">Step 02</div>
                    <div class="step-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                    <div class="step-title">Compare</div>
                    <p class="step-desc">
                        Side-by-side comparison of features, pricing, and TechScore ratings. Our AI comparison calculator generates custom software shortlists for your exact use case.
                    </p>
                </div>
                <div class="step-card">
                    <div class="step-number">Step 03</div>
                    <div class="step-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="step-title">Decide</div>
                    <p class="step-desc">
                        Read verified user reviews and expert editorial assessments. Book direct vendor demos and access exclusive pricing guides — all from one platform.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Values Section --}}
    <section class="values-section">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag-about">Our Values</span>
                <h2 class="section-title-about">What guides every decision we make</h2>
                <p class="section-desc-about" style="margin: 0 auto 52px;">
                    We built TechAnalytica on a set of non-negotiable principles that define how we collect, present, and protect information.
                </p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <div>
                        <div class="value-title">Editorial Independence</div>
                        <p class="value-desc">Our editorial ratings and reviews are never influenced by vendor relationships, advertising budgets, or sponsorships. What you read is what our analysts genuinely found.</p>
                    </div>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-user-check"></i></div>
                    <div>
                        <div class="value-title">Review Authenticity</div>
                        <p class="value-desc">Every user review goes through a multi-step verification process to confirm the reviewer is a genuine software user — not a bot or incentivized reviewer.</p>
                    </div>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-arrows-rotate"></i></div>
                    <div>
                        <div class="value-title">Continuous Updates</div>
                        <p class="value-desc">AI software evolves rapidly. We continuously re-evaluate tools, update pricing data, and revisit ratings as products ship new capabilities and change pricing.</p>
                    </div>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-lock"></i></div>
                    <div>
                        <div class="value-title">Data Privacy First</div>
                        <p class="value-desc">We never sell user data, and we anonymize reviewer identities when requested. Your browsing behavior is used only to improve recommendation relevance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team Section --}}
    <section class="team-section">
        <div class="container">
            <div style="text-align: center;">
                <span class="section-tag-about">The Team</span>
                <h2 class="section-title-about">Analysts, engineers &amp; practitioners</h2>
                <p class="section-desc-about" style="margin: 0 auto 52px;">
                    Our team combines deep enterprise software expertise with AI research and editorial journalism.
                </p>
            </div>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">AK</div>
                    <div class="team-name">Aryan Kapoor</div>
                    <div class="team-role">Founder &amp; CEO</div>
                    <p class="team-bio">Former VP of Product at a Tier-1 SaaS firm. Built enterprise analytics software for 12 years before launching TechAnalytica.</p>
                    <div class="team-social">
                        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">SR</div>
                    <div class="team-name">Sofia Reyes</div>
                    <div class="team-role">Head of Research</div>
                    <p class="team-bio">Data scientist and former tech analyst at Gartner. Leads the TechScore methodology and our AI capability assessment framework.</p>
                    <div class="team-social">
                        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">MN</div>
                    <div class="team-name">Marcus Nguyen</div>
                    <div class="team-role">Lead Engineer</div>
                    <p class="team-bio">Full-stack architect with a background in ML infrastructure. Designed the recommendation engine and the comparison calculator.</p>
                    <div class="team-social">
                        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">PL</div>
                    <div class="team-name">Priya Lal</div>
                    <div class="team-role">Editorial Director</div>
                    <p class="team-bio">B2B tech journalist and author of 200+ software category guides. Manages editorial quality across all TechAnalytica content.</p>
                    <div class="team-social">
                        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Trusted By --}}
    <section class="trusted-section">
        <div class="container">
            <div class="trusted-label">Trusted by teams at leading organizations</div>
            <div class="trusted-logos">
                <div class="trusted-logo-item">Salesforce</div>
                <div class="trusted-logo-item">HubSpot</div>
                <div class="trusted-logo-item">Notion</div>
                <div class="trusted-logo-item">Atlassian</div>
                <div class="trusted-logo-item">Monday.com</div>
                <div class="trusted-logo-item">Slack</div>
                <div class="trusted-logo-item">Zendesk</div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="about-cta-section">
        <div class="container">
            <div class="about-cta-card">
                <h2 class="about-cta-title">Ready to find the right AI tools for your team?</h2>
                <p class="about-cta-desc">
                    Join 2 million+ technology buyers who use TechAnalytica to make smarter, faster software decisions.
                </p>
                <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; position: relative; z-index: 2;">
                    <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink" style="font-size: 16px; padding: 15px 32px;">
                        <i class="fa-solid fa-rocket"></i> Explore All Tools
                    </a>
                    <a href="javascript:void(0)" onclick="openModal('submitToolModal')" class="btn-cta-outline" style="font-size: 16px; padding: 15px 32px;">
                        <i class="fa-solid fa-plus"></i> List Your Product
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection


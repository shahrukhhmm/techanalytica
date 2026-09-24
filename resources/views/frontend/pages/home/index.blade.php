@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Find AI tools Worth Adopting')

@push('styles')
<style>
    /* =============================================
       HOMEPAGE — ELEVATED FIGMA DARK THEME
       ============================================= */
    .hero-section {
        padding: 56px 0 40px;
        text-align: center;
        position: relative;
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

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 36px;
    }
    .section-title {
        font-size: clamp(28px, 3.4vw, 40px);
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

    /* Tools Grid */
    .tools-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 30px;
    }
    .tool-card {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 26px;
        transition: all 0.25s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .tool-card:hover {
        border-color: rgba(255, 59, 123, 0.35);
        transform: translateY(-3px);
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.6);
    }
    .tool-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 800;
        background: rgba(255, 59, 123, 0.15);
        color: #ff3b7b;
        border: 1px solid rgba(255, 59, 123, 0.28);
    }
    .tool-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }
    .tool-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: rgba(26, 14, 34, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ff3b7b;
        flex-shrink: 0;
        overflow: hidden;
        position: relative;
    }
    .tool-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
    .tool-icon .img-fallback-icon {
        display: none;
        width: 100%;
        height: 100%;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ff3b7b;
    }
    .tool-title {
        font-size: 17px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 2px;
    }
    .tool-category {
        font-size: 12px;
        color: var(--text-secondary);
    }
    .tool-desc {
        font-size: 13.5px;
        color: #cbbecf;
        line-height: 1.55;
        margin-bottom: 20px;
        min-height: 44px;
    }
    .tool-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }
    .pricing-tag {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-secondary);
        background: rgba(255, 255, 255, 0.04);
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Why TechAnalytica Section */
    .why-section {
        background: #ffffff;
        padding: 70px 0;
        color: #0c0612;
    }
    .why-section .section-title {
        color: #0c0612;
    }
    .why-section .section-desc {
        color: #666;
    }
    .why-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-top: 50px;
        text-align: center;
    }
    .why-card h4 {
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 12px;
        color: #0c0612;
    }
    .why-card p {
        font-size: 13.5px;
        color: #555;
        line-height: 1.6;
    }
    .why-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: #fff;
        margin: 0 auto 24px;
    }

    /* Browse Categories Section */
    .category-section {
        padding: 70px 0;
        background: var(--bg-dark);
    }
    .category-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        margin-bottom: 40px;
    }
    .cat-pill {
        padding: 8px 20px;
        border-radius: 9999px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
    }
    .cat-pill.active, .cat-pill:hover {
        background: #ff3b7b;
        border-color: #ff3b7b;
    }
    .platforms-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    .platform-card {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 24px;
        text-align: left;
    }
    .platform-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
        color: #fff;
    }
    .platform-card h4 {
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .platform-card p {
        color: var(--text-secondary);
        font-size: 12px;
    }

    /* Dual CTA Cards */
    .cta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin: 60px 0;
    }
    .cta-card {
        border-radius: 20px;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 250px;
        transition: all 0.25s ease;
        position: relative;
    }
    .cta-card h3 {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 16px;
        color: #0c0612;
        line-height: 1.3;
    }
    .cta-card p {
        color: #444;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    .cta-buttons {
        display: flex;
        gap: 12px;
    }
    .cta-buttons a {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
    }
    .cta-card-left {
        background: #ffd6e4;
    }
    .cta-card-right {
        background: #ffe8f0;
    }

    /* Community Testimonials */
    .testimonial-section {
        padding: 70px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 48px;
    }
    .testimonial-text {
        flex: 1;
        max-width: 480px;
    }
    .testimonial-text h2 {
        font-size: clamp(26px, 3.2vw, 36px);
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
    .t-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        transition: all 0.2s ease;
        position: relative;
    }
    .t-card:hover {
        border-color: rgba(255, 59, 123, 0.35);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .t-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        flex-shrink: 0;
        object-fit: cover;
    }
    .t-info {
        flex: 1;
    }
    .t-info h5 {
        font-size: 16px;
        font-weight: 800;
        color: #0c0612;
        margin: 0 0 4px;
    }
    .t-info p {
        font-size: 13px;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }
    .t-stars {
        color: #ffb703;
        font-size: 13px;
        letter-spacing: 2px;
        margin-bottom: 6px;
    }
    .t-quote-icon {
        position: absolute;
        top: 24px;
        right: 24px;
        color: #e2e8f0;
        font-size: 28px;
    }

    /* Insights Section */
    .insights-section {
        padding: 70px 0;
        background: #ffffff;
        color: #0c0612;
    }
    .insights-section .section-title {
        color: #0c0612;
    }
    .insights-section .section-desc {
        color: #666;
    }
    .insights-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
    .featured-insight {
        background: #000000;
        border-radius: 20px;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
        min-height: 400px;
    }
    .featured-insight h3 {
        font-size: 36px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
        margin-bottom: 16px;
    }
    .featured-insight p {
        color: #a1a1aa;
        font-size: 15px;
    }
    .insight-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .insight-item {
        background: #ffffff;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 20px;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
    }
    .insight-item:hover {
        transform: translateX(4px);
    }
    .insight-img-box {
        width: 140px;
        height: 100px;
        border-radius: 12px;
        background: #f1f5f9;
        overflow: hidden;
        flex-shrink: 0;
    }
    .insight-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .insight-item h4 {
        font-size: 16px;
        font-weight: 800;
        color: #0c0612;
        margin-bottom: 6px;
        line-height: 1.3;
    }
    .insight-item p {
        font-size: 13px;
        color: #666;
        margin: 0;
    }
    .insight-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
        flex-shrink: 0;
    }

    /* FAQ */
    .faq-section {
        padding: 50px 0 70px;
    }
    .faq-wrapper {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 40px;
    }
    .faq-item {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .faq-item:hover {
        border-color: rgba(255, 59, 123, 0.3);
    }
    .faq-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .faq-header h5 {
        font-size: 15.5px;
        font-weight: 700;
        color: #fff;
    }
    .faq-answer {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-top: 12px;
        display: none;
    }
    .faq-item.active .faq-answer {
        display: block;
    }
    .faq-item.active .faq-icon {
        transform: rotate(180deg);
        color: #ff3b7b;
    }

    @media (max-width: 960px) {
        .tools-grid { grid-template-columns: 1fr 1fr; }
        .showcase-grid,
        .cta-grid,
        .insights-grid,
        .faq-wrapper {
            grid-template-columns: 1fr;
        }
        .testimonial-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 32px;
        }
        .testimonial-text,
        .testimonial-cards {
            max-width: 100%;
            width: 100%;
        }
    }
    @media (max-width: 640px) {
        .tools-grid { grid-template-columns: 1fr; }
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
                Discover. Evaluate. Build a Smarter AI Stack
            </p>

            <form action="{{ route('frontend.tools.index') }}" method="GET" class="search-box-wrapper" onsubmit="if(!this.search.value.trim()){ return false; }">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--text-secondary);"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Search Anything" required>
                <button type="submit" class="btn-search" style="padding: 10px 24px; border-radius: 9999px;"><i class="fa-solid fa-arrow-right"></i></button>
            </form>

            <!-- Sponsors Ticker -->
            <div class="sponsors-bar-wrapper">
                <div class="sponsors-bar-track">
                    <div class="sponsor-item">ActiveCampaign<i class="fa-solid fa-chevron-right" style="font-size: 14px; margin-left: 4px;"></i></div>
                    <div class="sponsor-item"><i class="fa-solid fa-cube"></i> Podium</div>
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

    <!-- 2. AI TOOLS MAKING REAL NOISE SECTION -->
    <section class="container" style="padding-bottom: 50px;">
        <div class="section-header">
            <h2 class="section-title">The AI Tools Making Real Noise</h2>
            <p class="section-desc">Verified and trusted AI software for businesses at every stage.</p>
        </div>

        <div class="tools-grid">
            @forelse($tools as $tool)
                <div class="tool-card">
                    @if($loop->iteration % 3 == 1)
                        <span class="tool-badge" style="background: #ff3b7b; color: #fff; border: none; padding: 6px 12px; font-weight: 600;">Most Popular</span>
                    @elseif($loop->iteration % 3 == 2)
                        <span class="tool-badge" style="background: #ff735c; color: #fff; border: none; padding: 6px 12px; font-weight: 600;">Editor Choice</span>
                    @else
                        <span class="tool-badge" style="background: #ff4757; color: #fff; border: none; padding: 6px 12px; font-weight: 600;">Enterprise Ready</span>
                    @endif

                    <div>
                        <div class="tool-header">
                            <div class="tool-icon">
                                @if($tool->logo_url)
                                    <img src="{{ asset($tool->logo_url) }}" alt="" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <span class="img-fallback-icon"><i class="fa-solid fa-cube"></i></span>
                                @else
                                    <span class="img-fallback-icon" style="display:flex;"><i class="fa-solid fa-brain"></i></span>
                                @endif
                            </div>
                            <div>
                                <h3 class="tool-title">
                                    <a href="{{ route('frontend.tools.show', $tool->slug) }}" style="color: inherit; text-decoration: none;">{{ $tool->name }}</a>
                                </h3>
                                <p class="tool-category">{{ $tool->categories->pluck('name')->join(', ') ?: 'AI Software' }}</p>
                            </div>
                        </div>
                        <p class="tool-desc">{{ Str::limit($tool->short_description, 90) }}</p>
                    </div>

                    <div class="tool-footer" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 16px; margin-top: 16px;">
                        <span style="font-size: 13px; color: var(--text-secondary);"><i class="fa-solid fa-star" style="color: #ff3b7b; margin-right: 4px;"></i> (1240 reviews)</span>
                        <span style="font-size: 13px; font-weight: 700; color: #ff3b7b;">From $29/mo</span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary); padding: 40px; background: rgba(20,10,26,0.85); border-radius: 20px;">
                    <h3>No AI tools found matching your criteria.</h3>
                </div>
            @endforelse
        </div>

        <div style="text-align: right; margin-top: 24px;">
            <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink" style="text-decoration: none; border-radius: 8px; padding: 10px 24px;">
                <span>View All</span>
            </a>
        </div>
    </section>



    <!-- 3. WHY TECH ANALYTICA -->
    <section class="why-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Why TechAnalytica?</h2>
                <p class="section-desc">We make finding and comparing AI tools simple, transparent, and trustworthy.</p>
            </div>
            
            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon" style="background: #ff735c;"><i class="fa-solid fa-rocket"></i></div>
                    <h4>Ahead of The Curve</h4>
                    <p>The AI tool market moves fast. TechAnalytica spotlights the most promising new launches the moment they matter, keeping your AI stack one step ahead.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon" style="background: #ffa07a;"><i class="fa-solid fa-brain"></i></div>
                    <h4>Built for AI</h4>
                    <p>AI tools organised for how businesses actually work: by function, use case, and impact. Helping teams adopt AI with confidence and direction.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon" style="background: #ff4757;"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                    <h4>Structured Research and Analysis</h4>
                    <p>In-depth analysis, comparison frameworks, and research-backed insights, built to help you evaluate tools with clarity.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon" style="background: #ff3b7b;"><i class="fa-solid fa-arrow-trend-up"></i></div>
                    <h4>Faster, Clearer Decisions</h4>
                    <p>Side-by-side comparisons, clear takeaways, and prioritised tools, everything you need to go from research to decision without getting stuck in the process.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. BROWSE OUR AI CATEGORIES -->
    <section class="category-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Browse Our AI Categories</h2>
                <p class="section-desc">Browse by use case, industry, or function, and find the tools built for exactly what your business does.</p>
            </div>

            <div class="category-pills">
                <a href="#" class="cat-pill">Project Management</a>
                <a href="#" class="cat-pill">Video Conferencing</a>
                <a href="#" class="cat-pill active">E-Commerce Platforms</a>
                <a href="#" class="cat-pill">Marketing Automation</a>
                <a href="#" class="cat-pill">Accounting</a>
                <a href="#" class="cat-pill">CRM</a>
                <a href="#" class="cat-pill">Expense Management</a>
                <a href="#" class="cat-pill">ERP Systems</a>
                <a href="#" class="cat-pill">Online Backup</a>
                <a href="#" class="cat-pill">AI Chatbots</a>
            </div>

            <div class="platforms-grid">
                <div class="platform-card">
                    <div class="platform-icon" style="background: #10b981;"><i class="fa-brands fa-shopify"></i></div>
                    <h4>Shopify</h4>
                    <p><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-regular fa-star" style="color: #ff3b7b;"></i><br>(28,934)</p>
                </div>
                <div class="platform-card">
                    <div class="platform-icon" style="background: #9f55ff;"><i class="fa-brands fa-wordpress"></i></div>
                    <h4>WooCommerce</h4>
                    <p><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-regular fa-star" style="color: #ff3b7b;"></i><br>(22,567)</p>
                </div>
                <div class="platform-card">
                    <div class="platform-icon" style="background: #ff735c;"><i class="fa-brands fa-magento"></i></div>
                    <h4>Magento</h4>
                    <p><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-regular fa-star" style="color: #ff3b7b;"></i><br>(14,321)</p>
                </div>
                <div class="platform-card">
                    <div class="platform-icon" style="background: #3b82f6;"><i class="fa-brands fa-aws"></i></div>
                    <h4>BigCommerce</h4>
                    <p><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-solid fa-star" style="color: #ff3b7b;"></i><i class="fa-regular fa-star" style="color: #ff3b7b;"></i><br>(16,789)</p>
                </div>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="#" class="btn-cta-pink" style="border-radius: 9999px; padding: 12px 30px; text-decoration: none;">View All New Releases <i class="fa-solid fa-chevron-right" style="font-size: 12px; margin-left: 6px;"></i></a>
            </div>
        </div>
    </section>

    <!-- 5. DUAL CTA CARDS -->
    <section class="container" style="padding-bottom: 70px;">
        <div class="cta-grid">
            <div class="cta-card cta-card-left">
                <div>
                    <i class="fa-regular fa-file-lines" style="font-size: 24px; color: #ff3b7b; margin-bottom: 16px;"></i>
                    <h3>Are you an AI Software Vendor?</h3>
                    <p>Get your tool in front of businesses actively searching for AI software. Claim your listing and take control of how you're found.</p>
                </div>
                <div class="cta-buttons">
                    <a href="javascript:void(0)" onclick="openModal('claimToolModal')" style="background: #9f55ff; color: #fff;">Claim Your AI Software</a>
                    <a href="#" style="background: #14091a; color: #fff;">View Vendor Plans</a>
                </div>
            </div>

            <div class="cta-card cta-card-right">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <i class="fa-regular fa-comment-dots" style="font-size: 24px; color: #ff3b7b;"></i>
                        <span style="font-size: 11px; font-weight: 700; color: #ff3b7b; background: rgba(255,59,123,0.1); padding: 4px 8px; border-radius: 4px;">• 12,450+ Reviews &nbsp; • 100% Verified &nbsp; • Trusted by 50K+ Users</span>
                    </div>
                    <h3>Used an AI tool?<br>Share Your Experience</h3>
                    <p>Tell the community what worked and what didn't.<br>Help businesses make smarter AI decisions.</p>
                </div>
                <div class="cta-buttons">
                    <a href="{{ route('frontend.tools.index') }}" style="background: #ff3b7b; color: #fff;"><i class="fa-regular fa-star"></i> Submit a review</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. COMMUNITY TESTIMONIALS -->
    <section class="container testimonial-section">
        <div class="testimonial-text">
            <h2 style="font-size: clamp(28px, 3.4vw, 40px); font-weight: 800; color: #fff; line-height: 1.2; letter-spacing: -0.02em; margin-bottom: 10px;">What Our Community Says</h2>
            <p style="color: var(--text-secondary); font-size: 15px; line-height: 1.6; max-width: 400px;">Real feedback from businesses and founders using TechAnalytica to build smarter AI stacks.</p>
            <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink" style="margin-top: 24px; text-decoration: none; display: inline-block; padding: 10px 24px; border-radius: 8px;">View More</a>
        </div>

        <div class="testimonial-cards">
            <div class="t-card">
                <img src="/assets/img/avatars/1.png" alt="Mehwish" class="t-avatar" style="background: #e2e8f0;">
                <div class="t-info">
                    <h5>Mehwish</h5>
                    <div class="t-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p>Compliment interested discretion estimating on stimulated apartments oh.</p>
                </div>
                <i class="fa-solid fa-quote-right t-quote-icon"></i>
            </div>
            <div class="t-card">
                <img src="/assets/img/avatars/2.png" alt="Elizabeth Jeff" class="t-avatar" style="background: #e2e8f0;">
                <div class="t-info">
                    <h5>Elizabeth Jeff</h5>
                    <div class="t-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p>Dear so sing when in find read of call. As distrusts behaviour abilities defective is.</p>
                </div>
                <i class="fa-solid fa-quote-right t-quote-icon"></i>
            </div>
            <div class="t-card">
                <img src="/assets/img/avatars/3.png" alt="Emily Thomas" class="t-avatar" style="background: #e2e8f0;">
                <div class="t-info">
                    <h5>Emily Thomas</h5>
                    <div class="t-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></div>
                    <p>Never at water me might. On formed merits hunted unable merely by my whence or.</p>
                </div>
                <i class="fa-solid fa-quote-right t-quote-icon"></i>
            </div>
        </div>
    </section>

    <!-- 7. AI INSIGHTS WORTH READING -->
    <section class="insights-section">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
                <h2 class="section-title" style="margin: 0; font-size: 40px; font-weight: 800; max-width: 400px; line-height: 1.1;">AI Insights Worth Reading</h2>
                <div style="max-width: 400px;">
                    <p style="font-size: 14px; color: #666; margin-bottom: 12px;">Stay ahead of the AI curve. Get the latest tool releases, in-depth reviews, and industry insights, straight to your inbox.</p>
                    <form style="display: flex; gap: 8px;">
                        <input type="email" placeholder="Email Address" required style="flex: 1; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                        <button type="submit" style="background: #ff3b7b; color: #fff; border: none; padding: 0 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="insights-grid">
                <a href="{{ route('frontend.blogs') }}" class="featured-insight" style="text-decoration: none;">
                    <div style="margin-bottom: auto;"></div>
                    <h3 style="font-size: 42px; font-weight: 800; color: #ffffff; line-height: 1.15; margin-bottom: 16px;">Unlock the Power of "And" with the Hybrid CDP</h3>
                    <p style="font-size: 15px; color: #a1a1aa; max-width: 90%;">Available across Snowflake, Databricks, BigQuery, and Redshift, mParticle's Hybrid CDP brings the power of "and" to enterprise data strategy...</p>
                    <div style="margin-top: 24px;">
                        <span style="display: inline-block; padding: 8px 16px; border: 1px solid rgba(255,255,255,0.2); border-radius: 9999px; color: #fff; font-size: 13px;">Read the full article</span>
                    </div>
                </a>

                <div class="insight-list">
                    <a href="{{ route('frontend.blogs') }}" class="insight-item">
                        <div class="insight-img-box"><img src="/assets/img/blog/1.jpg" alt="Blog 1"></div>
                        <div>
                            <span style="color: #ff3b7b; font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; display: block;">PRODUCT</span>
                            <h4>How Hybrid Activation Improves Real-Time Relevancy</h4>
                        </div>
                    </a>

                    <a href="{{ route('frontend.blogs') }}" class="insight-item">
                        <div class="insight-img-box"><img src="/assets/img/blog/2.jpg" alt="Blog 2"></div>
                        <div>
                            <span style="color: #ff3b7b; font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; display: block;">PRODUCT</span>
                            <h4>mParticle Innovations: Building for What's Next</h4>
                        </div>
                    </a>

                    <a href="{{ route('frontend.blogs') }}" class="insight-item">
                        <div class="insight-img-box"><img src="/assets/img/blog/3.jpg" alt="Blog 3"></div>
                        <div>
                            <span style="color: #ff3b7b; font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; display: block;">PRODUCT</span>
                            <h4>It's Time to Close the Match Rate Gap</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS -->
    <section class="faq-section">
        <div class="container faq-wrapper">
            <div>
                <h2 class="section-title" style="text-align: left;">Frequently Asked Questions</h2>
                <p class="section-desc" style="margin-left: 0; margin-top: 12px;">Everything you need to know about listing, discovering, and evaluating AI tools on TechAnalytica.</p>
            </div>

            <div>
                <div class="faq-item active" onclick="this.classList.toggle('active')">
                    <div class="faq-header">
                        <h5>What is TechAnalytica?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; transition: transform 0.2s;"></i>
                    </div>
                    <div class="faq-answer">
                        <p>TechAnalytica is a premier AI software discovery platform that helps teams evaluate, compare, and adopt verified AI tools based on real user metrics and transparent analytics.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="this.classList.toggle('active')">
                    <div class="faq-header">
                        <h5>How do you rate and rank AI tools?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; transition: transform 0.2s;"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Our algorithms evaluate software across multiple data points including verified user reviews, API uptime, integration scalability, pricing value, and performance benchmarks.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="this.classList.toggle('active')">
                    <div class="faq-header">
                        <h5>Can I list my own AI software?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; transition: transform 0.2s;"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! Software vendors can submit their AI products via our "Submit AI Tool" flow or claim an existing profile to manage product updates, analytics, and user reviews.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="this.classList.toggle('active')">
                    <div class="faq-header">
                        <h5>Are the reviews verified?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; transition: transform 0.2s;"></i>
                    </div>
                    <div class="faq-answer">
                        <p>All reviews undergo automated anti-spam checks and human moderation before being published to maintain 100% authenticity and prevent sponsored bias.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. PRE-FOOTER CTA SECTION (Matching Figma) -->
    @include('frontend.components.newsletter_section')

@endsection

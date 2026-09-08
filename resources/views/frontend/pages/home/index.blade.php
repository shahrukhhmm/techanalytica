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

    /* Showcase Section */
    .showcase-section {
        padding: 50px 0;
    }
    .showcase-banner {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 800;
        color: #ff735c;
        background: rgba(255, 115, 92, 0.15);
        border: 1px solid rgba(255, 115, 92, 0.3);
        margin-bottom: 14px;
    }
    .showcase-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 24px;
        align-items: center;
    }
    .showcase-card-left {
        background: linear-gradient(145deg, rgba(28, 14, 38, 0.95), rgba(16, 8, 22, 0.98));
        border: 1px solid rgba(255, 59, 123, 0.25);
        border-radius: 22px;
        padding: 36px;
        text-align: center;
    }
    .visual-dial {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff3b7b, #ff735c);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: #fff;
        margin: 0 auto 20px;
        box-shadow: 0 10px 30px rgba(255, 59, 123, 0.4);
    }
    .showcase-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .showcase-item {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: border-color 0.2s, transform 0.2s;
    }
    .showcase-item:hover {
        border-color: rgba(255, 59, 123, 0.35);
        transform: translateX(4px);
    }
    .showcase-item-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(255, 59, 123, 0.15);
        color: #ff3b7b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .showcase-item h4 {
        font-size: 15.5px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 3px;
    }

    /* Dual CTA Cards */
    .cta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin: 60px 0;
    }
    .cta-card {
        background: linear-gradient(135deg, rgba(28, 14, 38, 0.95) 0%, rgba(16, 7, 22, 0.98) 100%);
        border: 1px solid rgba(255, 59, 123, 0.25);
        border-radius: 20px;
        padding: 36px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 220px;
        transition: all 0.25s ease;
    }
    .cta-card:hover {
        border-color: rgba(255, 59, 123, 0.45);
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5);
    }
    .cta-card h3 {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 10px;
        line-height: 1.3;
    }
    .cta-card p {
        font-size: 14.5px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 24px;
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
        background: linear-gradient(135deg, rgba(24, 12, 32, 0.85) 0%, rgba(14, 7, 20, 0.95) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s ease;
    }
    .t-card:hover {
        border-color: rgba(255, 59, 123, 0.35);
        transform: translateY(-2px);
    }
    .t-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .t-info {
        flex: 1;
    }
    .t-info h5 {
        font-size: 15.5px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 2px;
    }
    .t-info p {
        font-size: 12px;
        color: var(--text-secondary);
        margin: 0;
    }
    .t-stars {
        color: #ffb703;
        font-size: 13px;
        letter-spacing: 2px;
        flex-shrink: 0;
    }

    /* Insights Section */
    .insights-section {
        padding: 50px 0;
    }
    .insights-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 24px;
    }
    .featured-insight {
        background: linear-gradient(135deg, rgba(32, 14, 40, 0.95), rgba(18, 9, 24, 0.98));
        border: 1px solid rgba(255, 59, 123, 0.25);
        border-radius: 22px;
        padding: 36px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        position: relative;
        overflow: hidden;
        min-height: 280px;
    }
    .insight-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .insight-item {
        background: rgba(20, 10, 26, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
    }
    .insight-item:hover {
        border-color: rgba(255, 59, 123, 0.35);
        transform: translateX(4px);
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
                Discover real products, real reviews, & honest AI insights.
            </p>

            <form action="{{ route('frontend.tools.index') }}" method="GET" class="search-box-wrapper" onsubmit="if(!this.search.value.trim()){ return false; }">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Search for AI tools, categories or features..." required>
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

    <!-- 2. AI TOOLS MAKING REAL NOISE SECTION -->
    <section class="container" style="padding-bottom: 50px;">
        <div class="section-header">
            <h2 class="section-title">The AI Tools Making Real Noise</h2>
            <p class="section-desc">Hand-curated software tools that generate proven ROI for teams worldwide.</p>
        </div>

        <div class="tools-grid">
            @forelse($tools as $tool)
                <div class="tool-card">
                    @if($tool->is_featured)
                        <span class="tool-badge"><i class="fa-solid fa-crown" style="font-size: 10px;"></i> Featured</span>
                    @elseif($tool->is_verified)
                        <span class="tool-badge" style="background: rgba(16,185,129,0.15); color: #10b981; border-color: rgba(16,185,129,0.3);"><i class="fa-solid fa-check"></i> Verified</span>
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

                    <div class="tool-footer">
                        <span class="pricing-tag">{{ $tool->pricing_text ?? ($tool->tier->name ?? 'Free / Freemium') }}</span>
                        <a href="{{ route('frontend.tools.show', $tool->slug) }}" class="btn-visit" style="font-size: 13px;">View Details <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary); padding: 40px; background: rgba(20,10,26,0.85); border-radius: 20px;">
                    <h3>No AI tools found matching your criteria.</h3>
                </div>
            @endforelse
        </div>

        <div style="text-align: right; margin-top: 24px;">
            <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink" style="text-decoration: none;">
                <span>View All Tools</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- 3. NEW AI TOOL RELEASES SHOWCASE SECTION -->
    <section class="showcase-section">
        <div class="container">
            <div style="text-align: center; margin-bottom: 24px;">
                <div class="showcase-banner">
                    <i class="fa-solid fa-fire"></i> New AI Tool Releases
                </div>
                <h2 class="section-title">Fresh releases, updated features, and cutting-edge products</h2>
            </div>

            <div class="showcase-grid">
                <div class="showcase-card-left">
                    <div class="visual-dial">
                        <i class="fa-solid fa-compact-disc"></i>
                    </div>
                    <h3 style="font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 8px;">Voice Engine Pro 2.0</h3>
                    <p style="color: var(--text-secondary); font-size: 14.5px; line-height: 1.6;">Ultra-realistic real-time voice synthesis and conversion for modern audio and media creators.</p>
                </div>

                <div class="showcase-list">
                    <div class="showcase-item">
                        <div class="showcase-item-icon"><i class="fa-solid fa-video"></i></div>
                        <div>
                            <h4>VideoGen Studio</h4>
                            <p style="font-size: 13px; color: var(--text-secondary);">Generative video engine with full scene consistency control.</p>
                        </div>
                    </div>

                    <div class="showcase-item">
                        <div class="showcase-item-icon"><i class="fa-solid fa-code"></i></div>
                        <div>
                            <h4>DevAgent Refactor</h4>
                            <p style="font-size: 13px; color: var(--text-secondary);">Autonomous codebase refactoring with full regression test synthesis.</p>
                        </div>
                    </div>

                    <div class="showcase-item">
                        <div class="showcase-item-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <div>
                            <h4>DesignMatrix Studio</h4>
                            <p style="font-size: 13px; color: var(--text-secondary);">Automated vector design system generator for cross-platform products.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. WHY TECH ANALYTICA / DUAL CTA CARDS -->
    <section class="container">
        <div class="cta-grid">
            <div class="cta-card">
                <div class="cta-content">
                    <h3>Own an AI Product? Claim your Profile</h3>
                    <p>Get verified, collect authentic reviews, and reach thousands of potential customers looking for AI tools.</p>
                    <div class="cta-buttons">
                        <a href="javascript:void(0)" onclick="openModal('claimToolModal')" class="btn-cta-pink" style="text-decoration: none; display: inline-block;">Claim AI Tool</a>
                    </div>
                </div>
            </div>

            <div class="cta-card">
                <div class="cta-content">
                    <h3>Used an AI Tool? Share Your Experience</h3>
                    <p>Help millions of professionals make informed decisions by writing honest reviews.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink" style="text-decoration: none; display: inline-block;">Write a Review</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. COMMUNITY TESTIMONIALS -->
    <section class="container testimonial-section">
        <div class="testimonial-text">
            <h2>What The Community Says</h2>
            <p style="color: var(--text-secondary); margin-top: 12px; font-size: 15px; line-height: 1.6;">Read real testimonials from developers, designers, and tech leaders who rely on TechAnalytica.</p>
            <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink" style="margin-top: 24px; text-decoration: none; display: inline-block;">Join Community</a>
        </div>

        <div class="testimonial-cards">
            <div class="t-card">
                <div class="t-avatar" style="background: linear-gradient(135deg, #ff3b7b, #ff735c); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; color: #fff;">SJ</div>
                <div class="t-info">
                    <h5>Sarah Jenkins</h5>
                    <p>Lead Developer @ TechCorp</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
            <div class="t-card">
                <div class="t-avatar" style="background: linear-gradient(135deg, #ff735c, #ffa07a); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; color: #fff;">MC</div>
                <div class="t-info">
                    <h5>Michael Chang</h5>
                    <p>Product Designer @ DesignLab</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
            <div class="t-card">
                <div class="t-avatar" style="background: linear-gradient(135deg, #9f55ff, #ff3b7b); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; color: #fff;">ER</div>
                <div class="t-info">
                    <h5>Elena Rostova</h5>
                    <p>Head of Marketing @ GrowthX</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
        </div>
    </section>

    <!-- 6. AI INSIGHTS WORTH READING -->
    <section class="insights-section">
        <div class="container">
            <div class="section-header" style="text-align: left;">
                <h2 class="section-title">AI Insights Worth Reading</h2>
                <p class="section-desc" style="margin-left: 0;">Stay updated with breaking AI trends, research, and analysis.</p>
            </div>

            <div class="insights-grid">
                <a href="{{ route('frontend.blogs') }}" class="featured-insight" style="text-decoration: none; color: inherit;">
                    <div style="position: absolute; width: 140px; height: 140px; border-radius: 50%; background: #ff3b7b; top: -30px; right: -30px; opacity: 0.25; filter: blur(25px);"></div>
                    <span style="font-size: 11px; font-weight: 800; color: #ff3b7b; text-transform: uppercase; margin-bottom: 8px;"><i class="fa-solid fa-sparkles"></i> EDITORIAL REPORT</span>
                    <h3 style="font-size: 22px; font-weight: 800; color: #fff; line-height: 1.35; margin-bottom: 10px;">Unlock the Power of "And" with the Hybrid CDP</h3>
                    <p style="font-size: 14px; color: var(--text-secondary); line-height: 1.6;">How modern data platforms are combining warehouse power with instant operational workflows for high-growth teams.</p>
                </a>

                <div class="insight-list">
                    <a href="{{ route('frontend.blogs') }}" class="insight-item">
                        <div class="insight-icon-box" style="background: linear-gradient(135deg, #ff3b7b, #ff735c);"><i class="fa-solid fa-code"></i></div>
                        <div>
                            <h4 style="font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 2px;">Top 10 Generative AI Tools for Coding in 2026</h4>
                            <p style="font-size: 12px; color: var(--text-secondary); margin: 0;">5 min read • Industry Trends</p>
                        </div>
                    </a>

                    <a href="{{ route('frontend.blogs') }}" class="insight-item">
                        <div class="insight-icon-box" style="background: linear-gradient(135deg, #9f55ff, #ff3b7b);"><i class="fa-solid fa-microphone"></i></div>
                        <div>
                            <h4 style="font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 2px;">The Ethics of Voice Cloning in Commercial Media</h4>
                            <p style="font-size: 12px; color: var(--text-secondary); margin: 0;">8 min read • Deep Analysis</p>
                        </div>
                    </a>

                    <a href="{{ route('frontend.blogs') }}" class="insight-item">
                        <div class="insight-icon-box" style="background: linear-gradient(135deg, #ff735c, #ffa07a);"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                        <div>
                            <h4 style="font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 2px;">How AI LLMs are Changing Search Engine Optimization</h4>
                            <p style="font-size: 12px; color: var(--text-secondary); margin: 0;">4 min read • SEO Guide</p>
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

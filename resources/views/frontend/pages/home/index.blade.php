@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Find AI tools Worth Adopting')

@section('content')
    <!-- Main Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Find AI tools Worth Adopting</h1>
            <p class="hero-subtitle">Discover real products, real reviews, & honest AI insights.</p>

            <form action="{{ route('frontend.tools.index') }}" method="GET" class="search-box-wrapper" onsubmit="if(!this.search.value.trim()){ return false; }">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Search for AI tools, categories or features..." required>
                <button type="submit" class="btn-search">Search</button>
            </form>

            <!-- Sponsor Logos Infinite Horizontal Scroll Ticker -->
            <div class="sponsors-bar-wrapper">
                <div class="sponsors-bar-track">
                    <!-- First Set -->
                    <div class="sponsor-item"><i class="fa-brands fa-figma"></i> Figma</div>
                    <div class="sponsor-item"><i class="fa-brands fa-slack"></i> Slack</div>
                    <div class="sponsor-item"><i class="fa-brands fa-github"></i> GitHub</div>
                    <div class="sponsor-item"><i class="fa-brands fa-intercom"></i> Intercom</div>
                    <div class="sponsor-item"><i class="fa-brands fa-stripe"></i> Stripe</div>
                    <div class="sponsor-item"><i class="fa-brands fa-spotify"></i> Spotify</div>
                    <div class="sponsor-item"><i class="fa-brands fa-aws"></i> AWS</div>
                    <div class="sponsor-item"><i class="fa-brands fa-google"></i> Google Cloud</div>

                    <!-- Duplicated Set for Seamless Continuous Loop -->
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

    <!-- AI Tools Making Real Noise Section -->
    <section class="container" style="padding-bottom: 60px;">
        <div class="section-header">
            <h2 class="section-title">The AI Tools Making Real Noise</h2>
            <p class="section-desc">Hand-curated software tools that generate proven ROI for teams worldwide.</p>
        </div>

        <div class="tools-grid">
            @forelse($tools as $tool)
                <div class="tool-card">
                    @if($tool->is_featured)
                        <span class="tool-badge">Featured</span>
                    @elseif($tool->is_verified)
                        <span class="tool-badge" style="background: rgba(40,167,69,0.2); color: #28a745;">Verified</span>
                    @endif
                    <div class="tool-header">
                        <div class="tool-icon" style="background: rgba(224,67,133,0.15);">
                            @if($tool->logo_url)
                                <img src="{{ asset($tool->logo_url) }}" alt="{{ $tool->name }}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                            @else
                                <i class="fa-solid fa-brain"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="tool-title">
                                <a href="{{ route('frontend.tools.show', $tool->slug) }}" style="color: inherit; text-decoration: none;">{{ $tool->name }}</a>
                            </h3>
                            <p class="tool-category">{{ $tool->categories->pluck('name')->join(', ') ?: 'AI Tool' }}</p>
                        </div>
                    </div>
                    <p class="tool-desc">{{ Str::limit($tool->short_description, 90) }}</p>
                    <div class="tool-footer">
                        <span class="pricing-tag">{{ $tool->pricing_text ?? ($tool->tier->name ?? 'Free / Freemium') }}</span>
                        <a href="{{ route('frontend.tools.show', $tool->slug) }}" class="btn-visit">View Details <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #a0aec0; padding: 40px;">
                    <h3>No AI tools found matching your criteria.</h3>
                </div>
            @endforelse
        </div>

        <div class="load-more-container" style="text-align: right; margin-top: 30px;">
            <a href="{{ route('frontend.tools.index') }}" class="btn-view-all" style="background: linear-gradient(135deg, #e04385, #a4358a); color: #fff; padding: 12px 32px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-block;">View All</a>
        </div>
    </section>

    <!-- New AI Tool Releases Showcase Section -->
    <section class="showcase-section">
        <div class="container">
            <div class="showcase-banner">
                <i class="fa-solid fa-fire"></i> New AI Tool Releases
            </div>
            <div class="section-header">
                <h2 class="section-title">Fresh releases, updated features, and cutting-edge products</h2>
            </div>

            <div class="showcase-grid">
                <div class="showcase-card-left">
                    <div class="visual-dial">
                        <i class="fa-solid fa-compact-disc"></i>
                    </div>
                    <h3>Voice Engine Pro 2.0</h3>
                    <p style="color: var(--text-secondary); font-size: 14px; margin-top: 10px;">Ultra-realistic real-time voice synthesis and conversion for creators.</p>
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
                        <div class="showcase-item-icon"><i class="fa-solid fa-layer-group"></i></div>
                        <div>
                            <h4>PromptForge 3D</h4>
                            <p style="font-size: 13px; color: var(--text-secondary);">Text-to-3D mesh model generator for game developers.</p>
                        </div>
                    </div>
                    <div class="showcase-item">
                        <div class="showcase-item-icon"><i class="fa-solid fa-robot"></i></div>
                        <div>
                            <h4>AutoAgent CLI</h4>
                            <p style="font-size: 13px; color: var(--text-secondary);">Autonomous agent framework for terminal command execution.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Light Section: Why TechAnalytica? -->
    <section class="why-section">
        <div class="container">
            <h2 class="section-title">Why TechAnalytica?</h2>
            <p class="section-desc">We simplify the noise so you can adopt software with confidence.</p>

            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-check-double"></i></div>
                    <h4>Verified Reviews</h4>
                    <p>Every review is authenticated through genuine user feedback and usage logs.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h4>Unbiased Data</h4>
                    <p>Our ranking algorithms are strictly metric-based without paid rank inflation.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-bolt"></i></div>
                    <h4>Fast Discovery</h4>
                    <p>Filter by industry, pricing, rating, or precise feature requirements.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-users"></i></div>
                    <h4>Active Community</h4>
                    <p>Connect with software vendors and power users sharing best practices.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Browse Categories -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
                <div style="text-align: left;">
                    <h2 class="section-title">Browse Our AI Categories</h2>
                    <p class="section-desc">Explore tools organized by specialized enterprise use cases.</p>
                </div>
                @if(isset($categories) && count($categories) > 4)
                    <div class="carousel-controls" style="display: flex; gap: 10px;">
                        <button onclick="scrollCategories(-300)" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--accent-pink)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button onclick="scrollCategories(300)" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--accent-pink)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                @endif
            </div>

            <div class="category-grid" id="categoryGridCarousel" style="display: flex; gap: 20px; overflow-x: auto; scroll-behavior: smooth; scrollbar-width: none; padding: 10px 0;">

                @php
                    $colors = ['#10b981', '#8b5cf6', '#f59e0b', '#3b82f6', '#e04385', '#00a1e0', '#ec4899', '#6366f1'];
                    $icons = ['fa-code', 'fa-palette', 'fa-bullhorn', 'fa-file-pen', 'fa-brain', 'fa-robot', 'fa-chart-pie', 'fa-wand-magic-sparkles'];
                @endphp
                @forelse($categories as $index => $cat)
                    <a href="{{ route('frontend.tools.index', ['category_id' => $cat->id]) }}" class="cat-card" style="min-width: 260px; max-width: 280px; flex-shrink: 0; text-decoration: none; color: inherit;">
                        <div class="cat-icon" style="background: {{ $colors[$index % count($colors)] }};"><i class="fa-solid {{ $icons[$index % count($icons)] }}"></i></div>
                        <h4>{{ $cat->name }}</h4>
                        <p>{{ $cat->tools_count }} AI tools available</p>
                    </a>
                @empty
                    <p style="color: var(--text-secondary);">No categories available at the moment.</p>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        function scrollCategories(amount) {
            const container = document.getElementById('categoryGridCarousel');
            if (container) {
                container.scrollBy({ left: amount, behavior: 'smooth' });
            }
        }
    </script>

    <!-- Dual CTA Banners Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-grid">
                <div class="cta-card">
                    <h3>Are you an AI Software Vendor?</h3>
                    <p>Get featured in front of thousands of tech decision-makers looking for AI tools.</p>
                    <div class="cta-buttons">
                        <button class="btn-cta-pink" onclick="openModal('submitToolModal')">Submit Your Tool</button>
                        <button class="btn-cta-outline" onclick="openModal('claimToolModal')">Claim AI Tool</button>
                    </div>
                </div>

                <div class="cta-card" style="background: linear-gradient(135deg, #fce4ec 0%, #f48fb1 100%);">
                    <h3>Used an AI Tool? Share Your Experience</h3>
                    <p>Help millions of professionals make informed decisions by writing honest reviews.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('frontend.tools.index') }}" class="btn-cta-pink" style="text-decoration: none; display: inline-block;">Write a Review</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Community Testimonials -->
    <section class="container testimonial-section">
        <div class="testimonial-text">
            <h2>What The Community Says</h2>
            <p style="color: var(--text-secondary); margin-top: 12px;">Read real testimonials from developers, designers, and tech leaders who rely on TechAnalytica.</p>
            <button class="btn-submit-ai" style="margin-top: 24px;">Join Community</button>
        </div>

        <div class="testimonial-cards">
            <div class="t-card">
                <div class="t-avatar" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80'); background-size: cover;"></div>
                <div class="t-info">
                    <h5>Sarah Jenkins</h5>
                    <p>Lead Developer @ TechCorp</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
            <div class="t-card">
                <div class="t-avatar" style="background-image: url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80'); background-size: cover;"></div>
                <div class="t-info">
                    <h5>Michael Chang</h5>
                    <p>Product Designer @ DesignLab</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
            <div class="t-card">
                <div class="t-avatar" style="background-image: url('https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80'); background-size: cover;"></div>
                <div class="t-info">
                    <h5>Elena Rostova</h5>
                    <p>Head of Marketing @ GrowthX</p>
                </div>
                <div class="t-stars">★★★★★</div>
            </div>
        </div>
    </section>

    <!-- Light Insights Section -->
    <section class="insights-section">
        <div class="container">
            <div class="section-header" style="text-align: left;">
                <h2 class="section-title">AI Insights Worth Reading</h2>
                <p class="section-desc">Stay updated with breaking AI trends, research, and analysis.</p>
            </div>

            <div class="insights-grid">
                <div class="featured-insight">
                    <h3>Unlock the Power of "And" with the Hybrid CDP</h3>
                    <p style="font-size: 14px; opacity: 0.8; margin-top: 10px;">How modern data platforms are combining warehouse power with instant operational workflows.</p>
                </div>

                <div class="insight-list">
                    <div class="insight-item">
                        <div class="insight-img" style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=200&q=80'); background-size: cover;"></div>
                        <div class="insight-content">
                            <h4>Top 10 Generative AI Tools for Coding in 2026</h4>
                            <p>5 min read • Industry Trends</p>
                        </div>
                    </div>

                    <div class="insight-item">
                        <div class="insight-img" style="background-image: url('https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=200&q=80'); background-size: cover;"></div>
                        <div class="insight-content">
                            <h4>The Ethics of Voice Cloning in Commercial Media</h4>
                            <p>8 min read • Deep Analysis</p>
                        </div>
                    </div>

                    <div class="insight-item">
                        <div class="insight-img" style="background-image: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=200&q=80'); background-size: cover;"></div>
                        <div class="insight-content">
                            <h4>How AI LLMs are Changing Search Engine Optimization</h4>
                            <p>4 min read • SEO Guide</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section reveal-on-scroll">
        <div class="container faq-wrapper">
            <div>
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-desc" style="margin-top: 12px;">Everything you need to know about listing, discovering, and evaluating AI tools on TechAnalytica.</p>
            </div>

            <div class="faq-accordion">
                <div class="faq-item" onclick="toggleFaq(this)">
                    <div class="faq-header">
                        <h5>What is TechAnalytica?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>TechAnalytica is a premier AI software discovery platform that helps teams evaluate, compare, and adopt verified AI tools based on real user metrics and transparent analytics.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="toggleFaq(this)">
                    <div class="faq-header">
                        <h5>How do you rate and rank AI tools?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Our algorithms evaluate software across multiple data points including verified user reviews, API uptime, integration scalability, pricing value, and performance benchmarks.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="toggleFaq(this)">
                    <div class="faq-header">
                        <h5>Can I list my own AI software?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! Software vendors can submit their AI products via our "Submit AI Tool" flow or claim an existing profile to manage product updates, analytics, and user reviews.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="toggleFaq(this)">
                    <div class="faq-header">
                        <h5>Are the reviews verified?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>All reviews undergo automated anti-spam checks and human moderation before being published to maintain 100% authenticity and prevent sponsored bias.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function toggleFaq(element) {
            const allItems = document.querySelectorAll('.faq-item');
            allItems.forEach(item => {
                if (item !== element) {
                    item.classList.remove('active');
                }
            });
            element.classList.toggle('active');
        }
    </script>
    @endpush

@endsection

@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Find AI Tools Worth Adopting')

@section('content')
    @if (session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #a7f3d0; border-radius: 12px;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- 1. Hero Section -->
    <section class="hero-section">
        <div class="mesh-wave-hero"></div>
        <div class="container">
            <h1 class="hero-title">Find AI tools Worth Adopting</h1>
            <p class="hero-subtitle">Discover {{ $stats['total_tools'] ?? 200 }}+ real products, {{ $stats['total_reviews'] ?? 1500 }}+ real reviews, & honest AI benchmarks.</p>

            <form action="{{ route('frontend.vendors.crm') }}" method="GET" class="search-box-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" class="search-input" placeholder="Search for AI tools, categories or features...">
                <button type="submit" class="btn-search">Search</button>
            </form>

            <!-- Sponsor Logos Infinite Horizontal Scroll Ticker -->
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
                    <div class="sponsor-item"><i class="fa-solid fa-cube"></i> Notion</div>
                    <div class="sponsor-item"><i class="fa-solid fa-sparkles"></i> OpenAI</div>

                    <!-- Duplicated Set for Seamless Continuous Loop -->
                    <div class="sponsor-item"><i class="fa-brands fa-figma"></i> Figma</div>
                    <div class="sponsor-item"><i class="fa-brands fa-slack"></i> Slack</div>
                    <div class="sponsor-item"><i class="fa-brands fa-github"></i> GitHub</div>
                    <div class="sponsor-item"><i class="fa-brands fa-intercom"></i> Intercom</div>
                    <div class="sponsor-item"><i class="fa-brands fa-stripe"></i> Stripe</div>
                    <div class="sponsor-item"><i class="fa-brands fa-spotify"></i> Spotify</div>
                    <div class="sponsor-item"><i class="fa-brands fa-aws"></i> AWS</div>
                    <div class="sponsor-item"><i class="fa-brands fa-google"></i> Google Cloud</div>
                    <div class="sponsor-item"><i class="fa-solid fa-cube"></i> Notion</div>
                    <div class="sponsor-item"><i class="fa-solid fa-sparkles"></i> OpenAI</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. AI Tools Making Real Noise Section (Dynamic DB) -->
    <section class="tools-showcase-section">
        <div class="mesh-wave-tools"></div>
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">The AI Tools Making Real Noise</h2>
                <p class="section-desc">Hand-curated software tools that generate proven ROI for teams worldwide.</p>
            </div>

            <div class="tools-grid">
                @php
                    $iconThemes = ['icon-red', 'icon-purple', 'icon-orange', 'icon-blue', 'icon-yellow', 'icon-cyan'];
                    $iconList = ['fa-fire', 'fa-code', 'fa-wand-magic-sparkles', 'fa-chart-line', 'fa-comment-dots', 'fa-pen-nib'];
                @endphp

                @forelse($featuredTools as $index => $tool)
                    @php
                        $themeClass = $iconThemes[$index % count($iconThemes)];
                        $iconClass = $iconList[$index % count($iconList)];
                        $mainCat = $tool->categories->first()->name ?? 'Productivity';
                        $badgeText = $tool->is_verified ? 'Verified' : ($tool->is_featured ? 'Featured' : 'Popular');
                    @endphp
                    <div class="tool-card">
                        <span class="tool-badge badge-featured">{{ $badgeText }}</span>
                        <div class="tool-header">
                            <div class="tool-icon {{ $themeClass }}"><i class="fa-solid {{ $iconClass }}"></i></div>
                            <div>
                                <h3 class="tool-title">{{ $tool->name }}</h3>
                                <p class="tool-category">{{ $mainCat }}</p>
                            </div>
                        </div>
                        <p class="tool-desc">{{ Str::limit($tool->short_description, 115) }}</p>
                        <div class="tool-footer">
                            <span class="pricing-tag">{{ $tool->pricing_text ?? 'From $19/mo' }}</span>
                            <a href="{{ route('frontend.vendors.show', $tool->slug) }}" class="btn-visit">View Tool <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <p>No featured tools found in database.</p>
                    </div>
                @endforelse
            </div>

            <div class="load-more-container">
                <a href="{{ route('frontend.vendors.crm') }}" class="btn-view-all">View All Tools ({{ $stats['total_tools'] ?? 20 }}+)</a>
            </div>
        </div>
    </section>

    <!-- 3. Why TechAnalytica? (Contrasting Clean White Section) -->
    <section class="why-section">
        <div class="container">
            <h2 class="section-title">Why TechAnalytica?</h2>
            <p class="section-desc">We simplify the noise so you can adopt software with confidence.</p>

            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-check-double"></i></div>
                    <h4>Verified Reviews</h4>
                    <p>Every review is authenticated through genuine user feedback and verified usage logs.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h4>Unbiased Data</h4>
                    <p>Our ranking algorithms are strictly metric-based without paid rank inflation or bias.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-bolt"></i></div>
                    <h4>Fast Discovery</h4>
                    <p>Filter by industry, pricing, rating, or precise feature requirements in seconds.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-users"></i></div>
                    <h4>Active Community</h4>
                    <p>Connect with 50,000+ software power users and CTOs sharing real-world benchmarks.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Browse Our AI Categories (Dark Section with Mesh Wireframe - Dynamic DB) -->
    <section class="categories-section">
        <div class="mesh-wave-categories"></div>
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Browse Our AI Categories</h2>
                <p class="section-desc">Explore tools organized by specialized enterprise use cases.</p>
            </div>

            <div class="category-pills">
                <a href="{{ route('frontend.vendors.crm') }}" class="pill active">All Categories</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('frontend.category.show', $cat->slug) }}" class="pill">{{ $cat->name }}</a>
                @endforeach
            </div>

            <div class="category-grid">
                @php
                    $catColors = ['icon-cat-green', 'icon-cat-purple', 'icon-cat-orange', 'icon-cat-blue'];
                    $catIcons = ['fa-code', 'fa-palette', 'fa-bullhorn', 'fa-file-pen'];
                @endphp
                @foreach ($categories as $cIndex => $category)
                    @php
                        $colorClass = $catColors[$cIndex % count($catColors)];
                        $iconClass = $catIcons[$cIndex % count($catIcons)];
                    @endphp
                    <a href="{{ route('frontend.category.show', $category->slug) }}" class="cat-card" style="text-decoration: none; color: inherit;">
                        <div class="cat-icon {{ $colorClass }}"><i class="fa-solid {{ $iconClass }}"></i></div>
                        <h4>{{ $category->name }}</h4>
                        <p>{{ $category->tools_count ?? 10 }}+ AI tools available</p>
                    </a>
                @endforeach
            </div>

            <div class="cat-btn-wrapper">
                <a href="{{ route('frontend.vendors.crm') }}" class="btn-explore-cats">Explore All Categories</a>
            </div>
        </div>
    </section>

    <!-- 5. Dual CTA Banners Section (Soft Rose / Pink Glossy Banners) -->
    <section class="cta-section">
        <div class="mesh-wave-cta"></div>
        <div class="container">
            <div class="cta-grid">
                <!-- Left Banner Card: For Vendors -->
                <div class="cta-banner-card banner-vendor">
                    <div class="cta-banner-icon"><i class="fa-solid fa-cubes"></i></div>
                    <h3>Are you an AI Software Vendor?</h3>
                    <p>Get featured in front of thousands of tech decision-makers looking for verified AI solutions.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('register-vendor') }}" class="btn-cta-pink">Submit Your Tool</a>
                        <a href="{{ route('frontend.vendors.crm') }}" class="btn-cta-outline">Claim Vendor Profile</a>
                    </div>
                </div>

                <!-- Right Banner Card: For Reviewers -->
                <div class="cta-banner-card banner-reviewer">
                    <div class="cta-banner-icon"><i class="fa-solid fa-star"></i></div>
                    <h3>Used an AI Tool? Share Your Experience</h3>
                    <p>Help millions of professionals make informed decisions by writing honest, verified reviews.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('frontend.vendors.crm') }}" class="btn-cta-pink">Write a Review</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. What The Community Says (Dark Testimonials Section - Dynamic DB) -->
    <section class="testimonial-section">
        <div class="container testimonial-wrapper">
            <div class="testimonial-text">
                <h2>What The Community Says</h2>
                <p>Read real testimonials from developers, designers, and tech leaders who rely on TechAnalytica.</p>
                <a href="{{ route('frontend.vendors.crm') }}" class="btn-join-community" style="text-decoration: none; display: inline-block;">Join Community</a>
            </div>

            <div class="testimonial-cards">
                @php
                    $avatars = [
                        'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
                        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
                        'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80',
                    ];
                @endphp
                @forelse($communityReviews as $rIndex => $review)
                    <div class="t-card">
                        <div class="t-avatar" style="background-image: url('{{ $avatars[$rIndex % count($avatars)] }}');"></div>
                        <div class="t-info">
                            <h5>{{ $review->user_name }}</h5>
                            <p>Verified User on {{ $review->tool->name ?? 'TechAnalytica' }}</p>
                            <div class="t-quote">"{{ Str::limit($review->comment, 120) }}"</div>
                        </div>
                        <div class="t-stars">
                            @for ($s = 0; $s < ($review->rating ?? 5); $s++)
                                ★
                            @endfor
                        </div>
                    </div>
                @empty
                    <div class="t-card">
                        <div class="t-avatar" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80');"></div>
                        <div class="t-info">
                            <h5>Sarah Jenkins</h5>
                            <p>Lead Developer @ TechCorp</p>
                            <div class="t-quote">"TechAnalytica saved our engineering team weeks of trial and error evaluating LLM copilots."</div>
                        </div>
                        <div class="t-stars">★★★★★</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 7. AI Insights Worth Reading (Clean Editorial Blog - Dynamic DB) -->
    <section class="insights-section">
        <div class="container">
            <div class="insights-header-row">
                <div>
                    <h2 class="section-title">AI Insights Worth Reading</h2>
                    <p class="section-desc">Stay updated with breaking AI trends, research, and deep-dive technical benchmarks.</p>
                </div>
                <form action="{{ route('frontend.newsletter.subscribe') }}" method="POST" class="newsletter-quick-box">
                    @csrf
                    <input type="email" name="email" required placeholder="Enter your email...">
                    <button type="submit" class="btn-quick-sub">Subscribe</button>
                </form>
            </div>

            <div class="insights-grid">
                @if ($featuredInsight)
                    <!-- Large Featured Insight Card -->
                    <div class="featured-insight-card">
                        <div class="featured-insight-visual">
                            <div class="neon-wave-graphic">
                                <svg viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 160 Q 100 40, 200 120 T 390 60" stroke="#e04385" stroke-width="8" stroke-linecap="round" fill="none" />
                                    <path d="M30 180 Q 120 70, 220 140 T 380 90" stroke="#ff7bb3" stroke-width="5" stroke-linecap="round" fill="none" opacity="0.7" />
                                    <path d="M50 190 Q 140 100, 240 160 T 370 120" stroke="#a4358a" stroke-width="4" stroke-linecap="round" fill="none" opacity="0.4" />
                                </svg>
                            </div>
                            <h3 class="hero-visual-title">{{ $featuredInsight->title }}</h3>
                        </div>
                        <div class="featured-insight-body">
                            <span class="insight-badge">Research & Guide</span>
                            <h4>{{ $featuredInsight->title }}</h4>
                            <p>{{ Str::limit(strip_tags($featuredInsight->body), 140) }}</p>
                            <a href="{{ route('frontend.blogs.show', $featuredInsight->slug) }}" class="btn-read-insight">Read Article <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endif

                <!-- Right Side List of Articles -->
                <div class="insight-list">
                    @php
                        $blogImgs = [
                            'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=300&q=80',
                            'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=300&q=80',
                            'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=300&q=80',
                        ];
                    @endphp
                    @forelse($latestBlogs as $bIndex => $blog)
                        <a href="{{ route('frontend.blogs.show', $blog->slug) }}" class="insight-item">
                            <div class="insight-img" style="background-image: url('{{ $blogImgs[$bIndex % count($blogImgs)] }}');"></div>
                            <div class="insight-content">
                                <span class="insight-category-tag">Research Insight</span>
                                <h4>{{ $blog->title }}</h4>
                                <p class="insight-meta">{{ $blog->published_at ? $blog->published_at->format('M Y') : 'Aug 2026' }} • {{ ceil(str_word_count(strip_tags($blog->body)) / 200) }} min read</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted">No additional blogs found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Frequently Asked Questions (FAQ Section) -->
    <section class="faq-section">
        <div class="mesh-wave-faq"></div>
        <div class="container faq-wrapper">
            <div class="faq-intro">
                <span class="faq-kicker">FAQ</span>
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-desc">Have questions about listing, discovering, or evaluating AI software on TechAnalytica?</p>
                <div class="faq-help-link">
                    <span>Need personal assistance?</span>
                    <a href="{{ route('frontend.blogs') }}">Contact our research team <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="faq-accordion">
                <div class="faq-item active" onclick="toggleFaq(this)">
                    <div class="faq-header">
                        <h5>What is TechAnalytica?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>TechAnalytica is the premier AI software discovery and benchmarking platform that helps teams evaluate, compare, and adopt verified AI tools based on real user metrics and transparent analytics.</p>
                    </div>
                </div>

                <div class="faq-item" onclick="toggleFaq(this)">
                    <div class="faq-header">
                        <h5>How do you rate and rank AI tools?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Our algorithms evaluate software across multiple data points including verified user reviews, API uptime, integration scalability, pricing value, and performance benchmarks without paid bias.</p>
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

                <div class="faq-item" onclick="toggleFaq(this)">
                    <div class="faq-header">
                        <h5>How often are pricing tiers and metrics updated?</h5>
                        <i class="fa-solid fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Our database synchronizes tool pricing, API changes, and feature updates on a continuous 24-hour cycle to ensure you always view accurate data.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

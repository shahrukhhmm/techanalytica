@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Sharper Thinking for the People Building What\'s Next')

@section('content')
    @if (session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #a7f3d0; border-radius: 12px;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- 1. Blog Hero Header -->
    <section class="blog-hero">
        <div class="mesh-wave-hero"></div>
        <div class="container blog-hero-grid">
            <div>
                <h1 class="blog-hero-title">Sharper thinking for the people <span class="gradient-text">building what's next.</span></h1>
                <p class="blog-hero-desc">Deep-dive research, expert software analysis, and engineering guides to help you build better products.</p>
                <form action="{{ route('frontend.blogs') }}" method="GET" class="blog-search-box">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search articles, guides, topics...">
                    <button type="submit" class="btn-blog-search">Search</button>
                </form>
            </div>

            <!-- Hero Featured Highlight Box -->
            @if ($mustReadBlog)
                <a href="{{ route('frontend.blogs.show', $mustReadBlog->slug) }}" class="hero-featured-box" style="text-decoration: none; color: inherit; display: block;">
                    <span class="blog-badge">Must Read</span>
                    <h3>{{ $mustReadBlog->title }}</h3>
                    <p>{{ Str::limit(strip_tags($mustReadBlog->body), 120) }}</p>
                    <div class="author-row">
                        <div class="author-avatar" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80');"></div>
                        <div>
                            <strong>{{ $mustReadBlog->author->name ?? 'Alex Rivera' }}</strong>
                            <span>{{ ceil(str_word_count(strip_tags($mustReadBlog->body)) / 200) }} min read • Research Report</span>
                        </div>
                    </div>
                </a>
            @endif
        </div>
    </section>

    <!-- 2. Category Filter Bar -->
    <section class="blog-filter-section">
        <div class="container blog-filter-bar">
            <div class="filter-pills">
                <a href="{{ route('frontend.blogs') }}" class="blog-pill {{ empty($selectedCategory) ? 'active' : '' }}">All Categories</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('frontend.blogs', ['category' => $cat->slug]) }}" class="blog-pill {{ ($selectedCategory ?? '') === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 3. Main Content Area with Left Sidebar & Articles Feed -->
    <section class="container blog-main-grid">
        <!-- Sidebar Navigation & Newsletter -->
        <aside class="blog-sidebar">
            <div class="sidebar-box">
                <h4>Categories Menu</h4>
                <ul class="sidebar-menu">
                    <li><a href="#featured" class="active"><i class="fa-solid fa-star"></i> Featured Post</a></li>
                    <li><a href="#trends"><i class="fa-solid fa-chart-line"></i> Trends & Insights</a></li>
                    <li><a href="#guides"><i class="fa-solid fa-book-open"></i> How-To Guides</a></li>
                    <li><a href="#news"><i class="fa-solid fa-newspaper"></i> News & PR</a></li>
                    <li><a href="#founders"><i class="fa-solid fa-user-astronaut"></i> Founder Stories</a></li>
                    <li><a href="#research"><i class="fa-solid fa-microscope"></i> Research & Data</a></li>
                </ul>
            </div>

            <!-- Newsletter Subscription Sidebar Card -->
            <form action="{{ route('frontend.newsletter.subscribe') }}" method="POST" class="sidebar-newsletter-card">
                @csrf
                <i class="fa-solid fa-envelope-open-text newsletter-icon"></i>
                <h3>Get weekly insights delivered.</h3>
                <p>No spam. Join 50,000+ tech leaders and developers receiving our weekly curated brief.</p>
                <input type="email" name="email" required class="newsletter-input" placeholder="Enter your work email...">
                <button type="submit" class="btn-subscribe">Subscribe <i class="fa-solid fa-arrow-right"></i></button>
            </form>
        </aside>

        <!-- Right Main Articles Feed -->
        <div class="blog-feed">
            @if ($featuredBlog)
                <!-- 1. Featured Article Spotlight (Dynamic) -->
                <div id="featured" class="section-heading">
                    <h2><i class="fa-solid fa-square-poll-vertical"></i> Featured</h2>
                </div>

                <a href="{{ route('frontend.blogs.show', $featuredBlog->slug) }}" class="featured-card-hero">
                    <div class="featured-img-box abstract-featured-bg">
                        <div class="abstract-circles-graphic">
                            <div class="glow-orb orb-1"></div>
                            <div class="glow-orb orb-2"></div>
                            <div class="glow-orb orb-3"></div>
                        </div>
                        <span class="blog-tag">Deep Dive</span>
                    </div>
                    <div class="featured-card-body">
                        <div class="tags-row">
                            <span class="mini-tag">Case Study</span>
                            <span class="read-time">{{ ceil(str_word_count(strip_tags($featuredBlog->body)) / 200) }} min read</span>
                        </div>
                        <h2>{{ $featuredBlog->title }}</h2>
                        <p>{{ Str::limit(strip_tags($featuredBlog->body), 160) }}</p>
                        <div class="author-row">
                            <div class="author-avatar" style="background-image: url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80');"></div>
                            <div>
                                <strong>{{ $featuredBlog->author->name ?? 'Marcus Vance' }}</strong>
                                <span>{{ $featuredBlog->published_at ? $featuredBlog->published_at->format('M d, Y') : 'Apr 14, 2026' }} • {{ ceil(str_word_count(strip_tags($featuredBlog->body)) / 200) }} min read</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endif

            <!-- 2. Trends & Insights Grid (Dynamic) -->
            <div id="trends" class="section-heading">
                <h2><i class="fa-solid fa-fire"></i> Trends & Insights</h2>
            </div>

            <div class="blog-grid-2">
                @php
                    $thumbThemes = ['abstract-thumb-purple', 'abstract-thumb-rose', 'abstract-thumb-teal', 'abstract-thumb-green'];
                    $shapeThemes = ['shape-square', 'shape-window', 'shape-ring', 'shape-wave'];
                    $tags = ['LLM Architecture', 'Security & AI', 'Vector DB', 'Enterprise Governance'];
                @endphp
                @forelse($trendsBlogs as $tIndex => $trend)
                    @php
                        $tClass = $thumbThemes[$tIndex % count($thumbThemes)];
                        $sClass = $shapeThemes[$tIndex % count($shapeThemes)];
                        $tag = $tags[$tIndex % count($tags)];
                    @endphp
                    <a href="{{ route('frontend.blogs.show', $trend->slug) }}" class="blog-card">
                        <div class="card-thumb {{ $tClass }}">
                            <div class="abstract-graphic-box">
                                <div class="box-shape {{ $sClass }}"></div>
                            </div>
                            <span class="blog-tag">{{ $tag }}</span>
                        </div>
                        <div class="card-content">
                            <h3>{{ $trend->title }}</h3>
                            <p>{{ Str::limit(strip_tags($trend->body), 110) }}</p>
                            <span class="post-meta">{{ ceil(str_word_count(strip_tags($trend->body)) / 200) }} min read • Research</span>
                        </div>
                    </a>
                @empty
                    <div class="col-12 text-muted py-3">No trend blogs available.</div>
                @endforelse
            </div>

            <!-- 3. Full-width Quote Banner -->
            <div class="quote-banner">
                <p class="quote-text">"AI is fast symmetry between concept and execution — making swift execution the primary moat in this cycle."</p>
                <div class="quote-author">— TechAnalytica Research Group</div>
            </div>

            <!-- 4. Comparisons & How-To Guides -->
            <div id="guides" class="section-heading">
                <h2><i class="fa-solid fa-list-check"></i> Comparisons & How-To Guides</h2>
            </div>

            <div class="guide-list">
                @foreach ($allBlogs->take(5) as $gIndex => $guide)
                    @php
                        $gIcons = ['fa-code-compare', 'fa-layer-group', 'fa-wand-magic-sparkles', 'fa-terminal', 'fa-database'];
                        $gBg = ['icon-cyan-bg', 'icon-purple-bg', 'icon-orange-bg', 'icon-pink-bg', 'icon-blue-bg'];
                    @endphp
                    <a href="{{ route('frontend.blogs.show', $guide->slug) }}" class="guide-item">
                        <div class="guide-icon {{ $gBg[$gIndex % count($gBg)] }}"><i class="fa-solid {{ $gIcons[$gIndex % count($gIcons)] }}"></i></div>
                        <div class="guide-info">
                            <h4>{{ $guide->title }}</h4>
                            <p>{{ Str::limit(strip_tags($guide->body), 100) }}</p>
                        </div>
                        <i class="fa-solid fa-chevron-right arrow"></i>
                    </a>
                @endforeach
            </div>

            <!-- 5. News & PR Section -->
            <div id="news" class="section-heading">
                <h2><i class="fa-solid fa-newspaper"></i> News & PR</h2>
            </div>

            <div class="news-list-box">
                <div class="news-row">
                    <span class="news-date">Aug 20, 2026</span>
                    <div class="news-content">
                        <h4>TechAnalytica releases Q3 2026 Enterprise AI Adoption Index</h4>
                        <p>Surveying 1,200 CTOs on model fine-tuning spend, inference optimization, and tooling budgets.</p>
                    </div>
                    <span class="news-badge">Press Release</span>
                </div>
                <div class="news-row">
                    <span class="news-date">Aug 14, 2026</span>
                    <div class="news-content">
                        <h4>OpenAI announces GPT-5 developer preview and realtime multimodal APIs</h4>
                        <p>New speech-to-speech latency drops below 200ms with native tool invocation.</p>
                    </div>
                    <span class="news-badge">Industry News</span>
                </div>
                <div class="news-row">
                    <span class="news-date">Aug 08, 2026</span>
                    <div class="news-content">
                        <h4>Cursor AI raises $60M Series A to expand autonomous codebase migrations</h4>
                        <p>Accelerating automated repository-wide refactoring and dependency upgrades.</p>
                    </div>
                    <span class="news-badge">Funding</span>
                </div>
            </div>

            <!-- 6. Founder Stories Section -->
            <div id="founders" class="section-heading">
                <h2><i class="fa-solid fa-user-astronaut"></i> Founder Stories</h2>
            </div>

            <div class="blog-grid-2">
                <a href="{{ route('frontend.blogs.show', 'how-prism-scaled-to-10m-active-developer-requests-in-6-months') }}" class="story-card purple-theme">
                    <span class="story-badge">Founder Story • Prism AI</span>
                    <h3>How Prism scaled to 10M active developer requests in 6 months</h3>
                    <p>Zeno Rocha discusses API design simplicity, developer ergonomics, and modern infra scaling without VC fluff.</p>
                </a>

                <a href="{{ route('frontend.blogs.show', 'why-we-pivoted-our-startup-into-vertical-legal-ai-tooling') }}" class="story-card teal-theme">
                    <span class="story-badge">Founder Story • Vanta AI</span>
                    <h3>Why we pivoted our startup into vertical legal AI tooling</h3>
                    <p>Lessons learned transitioning from a generic wrapper into an indispensable compliance assistant.</p>
                </a>
            </div>

            <!-- 7. Research & Data Section -->
            <div id="research" class="section-heading">
                <h2><i class="fa-solid fa-microscope"></i> Research & Data</h2>
            </div>

            <div class="research-grid">
                <div class="research-highlight-card">
                    <span class="blog-badge">Benchmark Report</span>
                    <h3>Annual AI ROI & Developer Velocity Report 2026</h3>
                    <p>Aggregated telemetry and surveyed productivity metrics across 850+ global engineering teams.</p>
                    <div class="research-stats-row">
                        <div class="r-stat">
                            <strong>68%</strong>
                            <span>Faster Cycle Time</span>
                        </div>
                        <div class="r-stat">
                            <strong>3.4x</strong>
                            <span>Deploy Velocity</span>
                        </div>
                        <div class="r-stat">
                            <strong>$94k</strong>
                            <span>Avg Annual Savings</span>
                        </div>
                    </div>
                </div>

                <div class="research-side-list">
                    <div class="research-side-item">
                        <span class="r-tag">Data Report</span>
                        <h4>Model Inference Costs: Cloud vs On-Prem vs Hybrid</h4>
                        <p>5 min read • Aug 2026</p>
                    </div>
                    <div class="research-side-item">
                        <span class="r-tag">Survey</span>
                        <h4>The State of Synthetic Data Generation for Training</h4>
                        <p>8 min read • Aug 2026</p>
                    </div>
                </div>
            </div>

            <!-- 8. Bottom CTA Banner -->
            <div class="trial-cta-box">
                <div>
                    <h2>Try TechAnalytica free for 30 days.</h2>
                    <p>Unlock premium AI software analytics, ROI calculators, and competitive intel dashboards.</p>
                    <div class="cta-btns">
                        <a href="{{ route('register-vendor') }}" class="btn-trial-pink" style="text-decoration: none; display: inline-block;">Start Free Trial</a>
                        <a href="{{ route('frontend.vendors.crm') }}" class="btn-trial-outline" style="text-decoration: none; display: inline-block;">Book a Demo</a>
                    </div>
                </div>
                <div class="cta-dots-graphic">
                    <div class="c-dot"></div>
                    <div class="c-dot"></div>
                    <div class="c-dot"></div>
                    <div class="c-dot"></div>
                    <div class="c-dot"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Sharper Thinking for the People Building What\'s Next')

@section('content')
    <!-- Blog Hero Header -->
    <section class="blog-hero">
        <div class="container blog-hero-grid">
            <div>
                <h1 class="blog-hero-title">Sharper thinking for the people <span class="gradient-text">building what's next.</span></h1>
                <p class="blog-hero-desc">Deep-dive research, expert software analysis, and engineering guides to help you build better products.</p>
                <div class="blog-search-box">
                    <input type="text" placeholder="Search articles, guides, topics...">
                    <button class="btn-blog-search">Search</button>
                </div>
            </div>

            <!-- Hero Featured Highlight Box -->
            <div class="hero-featured-box">
                <span class="blog-badge">Must Read</span>
                <h3>The 2026 State of Generative AI & SaaS Benchmarks</h3>
                <p>An in-depth report analyzing adoption rates, ROI metrics, and infrastructure spending across top tech teams.</p>
                <div class="author-row">
                    <div class="author-avatar" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80');"></div>
                    <div>
                        <strong>Alex Rivera</strong>
                        <span>12 min read</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Filter Bar -->
    <section class="blog-filter-section">
        <div class="container blog-filter-bar">
            <div class="filter-pills">
                <button class="blog-pill active">All</button>
                <button class="blog-pill">Trends & Insights</button>
                <button class="blog-pill">Guides</button>
                <button class="blog-pill">Case Studies</button>
                <button class="blog-pill">News & PR</button>
                <button class="blog-pill">Founder Stories</button>
                <button class="blog-pill">Research & Data</button>
            </div>
        </div>
    </section>

    <!-- Main Content Area with Left Sidebar & Featured Content -->
    <section class="container blog-main-grid">
        <!-- Sidebar Navigation & Newsletter -->
        <aside class="blog-sidebar">
            <div class="sidebar-box">
                <h4>Table of Contents</h4>
                <ul class="sidebar-menu">
                    <li><a href="#featured"><i class="fa-solid fa-star"></i> Featured</a></li>
                    <li><a href="#trends"><i class="fa-solid fa-chart-line"></i> Trends & Insights</a></li>
                    <li><a href="#guides"><i class="fa-solid fa-book-open"></i> How-To Guides</a></li>
                    <li><a href="#news"><i class="fa-solid fa-newspaper"></i> News & PR</a></li>
                    <li><a href="#founders"><i class="fa-solid fa-user-astronaut"></i> Founder Stories</a></li>
                    <li><a href="#research"><i class="fa-solid fa-microscope"></i> Research & Data</a></li>
                </ul>
            </div>

            <!-- Newsletter Subscription Sidebar Card -->
            <div class="sidebar-newsletter-card">
                <i class="fa-solid fa-envelope-open-text newsletter-icon"></i>
                <h3>Get weekly insights delivered.</h3>
                <p>No spam. Join 45,000+ tech leaders receiving our weekly roundup.</p>
                <input type="email" class="newsletter-input" placeholder="Enter your work email...">
                <button class="btn-subscribe">Subscribe <i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </aside>

        <!-- Right Main Articles Feed -->
        <div class="blog-feed">
            <!-- Featured Article Spotlight -->
            <div id="featured" class="section-heading">
                <h2><i class="fa-solid fa-square-poll-vertical"></i> Featured</h2>
            </div>
            
            <a href="{{ route('frontend.blogs.show') }}" class="featured-card-hero">
                <div class="featured-img-box" style="background-image: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80');">
                    <span class="blog-tag">Trends</span>
                </div>
                <div class="featured-card-body">
                    <div class="tags-row">
                        <span class="mini-tag">Case Study</span>
                        <span class="read-time">10 min read</span>
                    </div>
                    <h2>The quiet rewrite: how small teams are out-shipping the giants in 2026</h2>
                    <p>Modern AI workflows, decoupled microservices, and leaner developer stacks are allowing 5-person startups to outpace enterprise incumbents.</p>
                    <div class="author-row">
                        <div class="author-avatar" style="background-image: url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80');"></div>
                        <div>
                            <strong>Marcus Vance</strong>
                            <span>Apr 14, 2026 • 10 min read</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Trends & Insights Grid -->
            <div id="trends" class="section-heading">
                <h2><i class="fa-solid fa-fire"></i> Trends & Insights</h2>
            </div>

            <div class="blog-grid-2">
                <a href="{{ route('frontend.blogs.show') }}" class="blog-card">
                    <div class="card-thumb" style="background-image: url('https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=600&q=80');">
                        <span class="blog-tag">Research</span>
                    </div>
                    <div class="card-content">
                        <h3>The new LLM cost matrix: context windows vs fine-tuning</h3>
                        <p>A cost analysis breakdown comparing high-context API calls against custom hosted model checkpoints.</p>
                        <span class="post-meta">14 min read • Research</span>
                    </div>
                </a>

                <a href="{{ route('frontend.blogs.show') }}" class="blog-card">
                    <div class="card-thumb" style="background-image: url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=600&q=80');">
                        <span class="blog-tag">Security</span>
                    </div>
                    <div class="card-content">
                        <h3>Why autonomous AI agents demand new security paradigms</h3>
                        <p>How security architects are auditing non-deterministic execution loops and prompt injection attacks.</p>
                        <span class="post-meta">8 min read • Security</span>
                    </div>
                </a>

                <a href="{{ route('frontend.blogs.show') }}" class="blog-card">
                    <div class="card-thumb" style="background-image: url('https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80');">
                        <span class="blog-tag">Engineering</span>
                    </div>
                    <div class="card-content">
                        <h3>Vector databases in production: what benchmark tests won't tell you</h3>
                        <p>Real-world latency, index reconstruction overhead, and memory footprints under heavy concurrent loads.</p>
                        <span class="post-meta">11 min read • Infrastructure</span>
                    </div>
                </a>

                <a href="{{ route('frontend.blogs.show') }}" class="blog-card">
                    <div class="card-thumb" style="background-image: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=600&q=80');">
                        <span class="blog-tag">AI Ethics</span>
                    </div>
                    <div class="card-content">
                        <h3>Navigating AI governance in multi-tenant SaaS applications</h3>
                        <p>Implementing data isolation guarantees and compliance filters for enterprise customers.</p>
                        <span class="post-meta">9 min read • Compliance</span>
                    </div>
                </a>
            </div>

            <!-- Quote Banner -->
            <div class="quote-banner">
                <p class="quote-text">"If a software tool doesn't save your team at least 5 hours a week or scaling cost, it's not a tool — it's technical debt."</p>
                <div class="quote-author">— TechAnalytica Research Group</div>
            </div>

            <!-- Comparisons & How-To Guides -->
            <div id="guides" class="section-heading">
                <h2><i class="fa-solid fa-list-check"></i> Comparisons & How-To Guides</h2>
            </div>

            <div class="guide-list">
                <a href="{{ route('frontend.blogs.show') }}" class="guide-item">
                    <div class="guide-icon"><i class="fa-solid fa-scale-unbalanced-flip"></i></div>
                    <div class="guide-info">
                        <h4>Anthropic Claude 3.5 Sonnet vs OpenAI GPT-4o for Coding</h4>
                        <p>Deep benchmark comparison evaluating accuracy, speed, and context handling.</p>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow"></i>
                </a>

                <a href="{{ route('frontend.blogs.show') }}" class="guide-item">
                    <div class="guide-icon"><i class="fa-solid fa-terminal"></i></div>
                    <div class="guide-info">
                        <h4>How to build an autonomous terminal agent using Python & LangChain</h4>
                        <p>Step-by-step tutorial with sample code and security sandboxing setups.</p>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow"></i>
                </a>

                <a href="{{ route('frontend.blogs.show') }}" class="guide-item">
                    <div class="guide-icon"><i class="fa-solid fa-database"></i></div>
                    <div class="guide-info">
                        <h4>Pinecone vs Qdrant vs Milvus: 2026 Vector DB Comparison</h4>
                        <p>Evaluating throughput, pricing structures, and self-hosted deployment complexity.</p>
                    </div>
                    <i class="fa-solid fa-chevron-right arrow"></i>
                </a>
            </div>

            <!-- Founder Stories Section -->
            <div id="founders" class="section-heading">
                <h2><i class="fa-solid fa-user-astronaut"></i> Founder Stories</h2>
            </div>

            <div class="blog-grid-2">
                <a href="{{ route('frontend.blogs.show') }}" class="story-card purple-theme">
                    <span class="story-badge">Founder Story</span>
                    <h3>How Resend scaled to millions of emails without breaking dev UX</h3>
                    <p>Zeno Rocha discusses API design simplicity, developer ergonomics, and modern email delivery infrastructure.</p>
                </a>

                <a href="{{ route('frontend.blogs.show') }}" class="story-card teal-theme">
                    <span class="story-badge">Founder Story</span>
                    <h3>Why we pivoted our AI startup to focused vertical tooling</h3>
                    <p>Lessons learned transitioning from a generic wrapper product into an indispensable legal AI assistant.</p>
                </a>
            </div>


            <!-- Bottom CTA Banner -->
            <div class="trial-cta-box">
                <div>
                    <h2>Try TechAnalytica free for 30 days.</h2>
                    <p>Unlock premium AI software analytics, ROI calculators, and competitive intel dashboards.</p>
                    <div class="cta-btns">
                        <button class="btn-trial-pink">Start Free Trial</button>
                        <button class="btn-trial-outline">Book a Demo</button>
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

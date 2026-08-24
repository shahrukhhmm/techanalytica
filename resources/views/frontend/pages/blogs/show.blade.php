@extends('frontend.layout.app')

@section('meta_title', $blog->meta_title ?? ($blog->title ?? 'Blog Article') . ' - TechAnalytica')
@section('meta_description', $blog->meta_description ?? Str::limit(strip_tags($blog->body), 150))
@section('canonical_url', $blog->canonical_url ?? request()->url())

@section('content')
    @if (session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #a7f3d0; border-radius: 12px;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- 1. Article Header Hero Section -->
    <header class="article-hero">
        <div class="mesh-wave-hero"></div>
        <div class="container container-narrow">
            <nav class="article-breadcrumb">
                <a href="{{ route('frontend.home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('frontend.blogs') }}">Blogs</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ Str::limit($blog->title, 35) }}</span>
            </nav>

            <div class="article-badges">
                <span class="blog-badge">DEEP DIVE</span>
                <span class="blog-badge-outline">RESEARCH</span>
            </div>

            <h1 class="article-title">
                {{ $blog->title }}
            </h1>

            <p class="article-subtitle">
                {{ $blog->meta_description ?? 'Inside the lean startups using autonomous agents, local models, and serverless edge compute to run rings around 500-person incumbents.' }}
            </p>

            <div class="article-meta-bar">
                <div class="author-row">
                    <div class="author-avatar" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80');"></div>
                    <div>
                        <strong>{{ $blog->author->name ?? 'Alex Rivera' }}</strong>
                        <span>Head of Research • {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Aug 14, 2026' }}</span>
                    </div>
                </div>

                <div class="article-stats">
                    <span><i class="fa-regular fa-clock"></i> {{ $readingTime ?? 8 }} min read</span>
                    <span><i class="fa-regular fa-eye"></i> 4.2k views</span>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. Main Featured Glowing Graphic Cover -->
    <div class="container container-narrow">
        <div class="article-cover-graphic abstract-cover-bg">
            <div class="cover-glowing-shapes">
                <div class="g-circle circle-1"></div>
                <div class="g-circle circle-2"></div>
                <div class="g-square square-1"></div>
            </div>
        </div>
    </div>

    <!-- 3. Article Content Body with 3-Column Layout -->
    <section class="article-body-wrapper">
        <div class="container article-layout-3col">
            <!-- Left Sticky Share & TOC Bar -->
            <aside class="article-toc-sidebar">
                <div class="sticky-sidebar-inner">
                    <div class="toc-box">
                        <h5>TABLE OF CONTENTS</h5>
                        <ul>
                            <li><a href="#section-1" class="active">Why conditions changed</a></li>
                            <li><a href="#section-2">No-bloat tech stack</a></li>
                            <li><a href="#section-3">What the data says</a></li>
                            <li><a href="#section-4">Execution playbook</a></li>
                            <li><a href="#section-5">Final takeaway</a></li>
                        </ul>
                    </div>

                    <div class="share-box">
                        <span>SHARE THIS REPORT</span>
                        <div class="share-btns">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied to clipboard!');" class="share-btn"><i class="fa-regular fa-copy"></i></button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Center Main Article Body -->
            <main class="article-content">
                <div class="article-dynamic-body">
                    {!! nl2br(e($blog->body)) !!}
                </div>

                <!-- Highlight Abstract Concept Box -->
                <div class="article-concept-card abstract-concept-bg my-4">
                    <div class="concept-shapes">
                        <div class="c-square"></div>
                        <div class="c-circle"></div>
                    </div>
                </div>
                <span class="img-caption">Figure 1: Neural network routing and automated dev agent execution pipeline.</span>

                <!-- Highlights Stats Box -->
                <div class="stats-callout-grid my-4">
                    <div class="stat-card">
                        <h3>3.4x</h3>
                        <p>Faster feature deployment cycle</p>
                    </div>
                    <div class="stat-card">
                        <h3>68%</h3>
                        <p>Reduction in infrastructure overhead</p>
                    </div>
                    <div class="stat-card">
                        <h3>$94k</h3>
                        <p>Average annual cost savings per developer</p>
                    </div>
                </div>

                <blockquote class="article-blockquote my-4">
                    <p>"If a software tool doesn't save your engineering team at least 10 hours a week or 40% infra cost, it's not a tool—it's legacy debt in disguise."</p>
                    <cite>— {{ $blog->author->name ?? 'Alex Rivera' }}, Research Lead</cite>
                </blockquote>

                <div class="info-alert-box my-4">
                    <i class="fa-solid fa-shield-halved alert-icon"></i>
                    <div>
                        <strong>Security & Compliance Notice:</strong>
                        <p>Always enforce deterministic output filters and strict sandbox execution boundaries when allowing autonomous LLMs to touch customer-facing database mutation endpoints.</p>
                    </div>
                </div>

                <!-- Tags Section -->
                <div class="article-tags">
                    <span class="tag-pill">AI Tools</span>
                    <span class="tag-pill">Engineering</span>
                    <span class="tag-pill">Startup</span>
                    <span class="tag-pill">Productivity</span>
                    <span class="tag-pill">DevOps</span>
                    <span class="tag-pill">Architecture</span>
                </div>

                <!-- Author Bio Card -->
                <div class="author-bio-card">
                    <div class="author-avatar-lg" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80');"></div>
                    <div class="author-bio-info">
                        <h4>{{ $blog->author->name ?? 'Alex Rivera' }}</h4>
                        <p>Head of Software Research at TechAnalytica. Former Principal Architect covering LLM orchestration, serverless stacks, and developer productivity tools.</p>
                        <div class="author-socials">
                            <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#"><i class="fa-solid fa-globe"></i></a>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Sticky Newsletter & Top Reads -->
            <aside class="article-right-sidebar">
                <div class="sticky-sidebar-inner">
                    <!-- Newsletter Card -->
                    <form action="{{ route('frontend.newsletter.subscribe') }}" method="POST" class="sidebar-newsletter-card">
                        @csrf
                        <i class="fa-solid fa-bolt newsletter-icon"></i>
                        <h3>Stay Ahead of the Curve</h3>
                        <p>Get exclusive engineering benchmarks and AI software breakdowns straight to your inbox.</p>
                        <input type="email" name="email" required class="newsletter-input" placeholder="Enter your work email...">
                        <button type="submit" class="btn-subscribe">Get Weekly Brief <i class="fa-solid fa-arrow-right"></i></button>
                    </form>

                    <!-- Top Trending Articles Box -->
                    <div class="trending-reads-box">
                        <h5>TRENDING READS</h5>
                        @foreach ($trendingReads as $index => $tRead)
                            <a href="{{ route('frontend.blogs.show', $tRead->slug) }}" class="trending-item" style="text-decoration: none; color: inherit;">
                                <span class="trend-num">0{{ $index + 1 }}</span>
                                <div>
                                    <h6>{{ $tRead->title }}</h6>
                                    <span>{{ ceil(str_word_count(strip_tags($tRead->body)) / 200) }} min read</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <!-- 4. Related Articles Section (Dynamic) -->
    <section class="related-posts-section">
        <div class="container">
            <div class="section-heading">
                <h2><i class="fa-solid fa-layer-group"></i> Related Articles</h2>
            </div>

            <div class="blog-grid-3">
                @php
                    $relatedColors = ['abstract-thumb-rose', 'abstract-thumb-teal', 'abstract-thumb-purple'];
                    $relatedTags = ['Security', 'Infrastructure', 'AI Ethics'];
                @endphp
                @foreach ($relatedBlogs as $rIndex => $relBlog)
                    <a href="{{ route('frontend.blogs.show', $relBlog->slug) }}" class="blog-card">
                        <div class="card-thumb {{ $relatedColors[$rIndex % count($relatedColors)] }}">
                            <span class="blog-tag">{{ $relatedTags[$rIndex % count($relatedTags)] }}</span>
                        </div>
                        <div class="card-content">
                            <h3>{{ $relBlog->title }}</h3>
                            <p>{{ Str::limit(strip_tags($relBlog->body), 110) }}</p>
                            <span class="post-meta">{{ ceil(str_word_count(strip_tags($relBlog->body)) / 200) }} min read • {{ $relBlog->published_at ? $relBlog->published_at->format('M Y') : '2026' }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. Trial CTA Box -->
    <div class="container" style="margin-bottom: 80px;">
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
@endsection

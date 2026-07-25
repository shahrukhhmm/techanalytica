@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Find AI tools Worth Adopting')

@section('content')
    <!-- Main Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Find AI tools Worth Adopting</h1>
            <p class="hero-subtitle">Discover real products, real reviews, & honest AI insights.</p>

            <div class="search-box-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="search-input" placeholder="Search for AI tools, categories or features...">
                <button class="btn-search">Search</button>
            </div>

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
            <!-- Tool 1 -->
            <div class="tool-card">
                <span class="tool-badge">Featured</span>
                <div class="tool-header">
                    <div class="tool-icon" style="background: rgba(224,67,133,0.15);"><i class="fa-solid fa-brain"></i></div>
                    <div>
                        <h3 class="tool-title">AI Tool Hub</h3>
                        <p class="tool-category">Productivity & Automation</p>
                    </div>
                </div>
                <p class="tool-desc">Automate your complex daily workflows with intelligent deep-learning agents.</p>
                <div class="tool-footer">
                    <span class="pricing-tag">Freemium</span>
                    <a href="#" class="btn-visit">Visit Site <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>
            </div>

            <!-- Tool 2 -->
            <div class="tool-card">
                <span class="tool-badge">Popular</span>
                <div class="tool-header">
                    <div class="tool-icon" style="background: rgba(164,53,138,0.15);"><i class="fa-solid fa-code"></i></div>
                    <div>
                        <h3 class="tool-title">CodePulse AI</h3>
                        <p class="tool-category">Developer Tools</p>
                    </div>
                </div>
                <p class="tool-desc">Write cleaner code faster with real-time context-aware code generation.</p>
                <div class="tool-footer">
                    <span class="pricing-tag">Free Trial</span>
                    <a href="#" class="btn-visit">Visit Site <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>
            </div>

            <!-- Tool 3 -->
            <div class="tool-card">
                <span class="tool-badge">Trending</span>
                <div class="tool-header">
                    <div class="tool-icon" style="background: rgba(224,67,133,0.15);"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <div>
                        <h3 class="tool-title">Synthetix Art</h3>
                        <p class="tool-category">Design & Media</p>
                    </div>
                </div>
                <p class="tool-desc">Generate production-ready vector graphics and designs from prompts.</p>
                <div class="tool-footer">
                    <span class="pricing-tag">Paid</span>
                    <a href="#" class="btn-visit">Visit Site <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>
            </div>

            <!-- Tool 4 -->
            <div class="tool-card">
                <div class="tool-header">
                    <div class="tool-icon"><i class="fa-solid fa-chart-line"></i></div>
                    <div>
                        <h3 class="tool-title">MetricMind</h3>
                        <p class="tool-category">Data & Analytics</p>
                    </div>
                </div>
                <p class="tool-desc">Transform raw tabular data into intuitive executive dashboards instantly.</p>
                <div class="tool-footer">
                    <span class="pricing-tag">Freemium</span>
                    <a href="#" class="btn-visit">Visit Site <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>
            </div>

            <!-- Tool 5 -->
            <div class="tool-card">
                <div class="tool-header">
                    <div class="tool-icon"><i class="fa-solid fa-comment-dots"></i></div>
                    <div>
                        <h3 class="tool-title">ChatFlow Pro</h3>
                        <p class="tool-category">Customer Support</p>
                    </div>
                </div>
                <p class="tool-desc">Deploy custom trained AI support bots directly into your existing CRM platform.</p>
                <div class="tool-footer">
                    <span class="pricing-tag">Free</span>
                    <a href="#" class="btn-visit">Visit Site <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>
            </div>

            <!-- Tool 6 -->
            <div class="tool-card">
                <div class="tool-header">
                    <div class="tool-icon"><i class="fa-solid fa-pen-nib"></i></div>
                    <div>
                        <h3 class="tool-title">WriterGenie</h3>
                        <p class="tool-category">Copywriting</p>
                    </div>
                </div>
                <p class="tool-desc">Generate SEO-optimized articles, social copy, and newsletters seamlessly.</p>
                <div class="tool-footer">
                    <span class="pricing-tag">Freemium</span>
                    <a href="#" class="btn-visit">Visit Site <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>
            </div>
        </div>

        <div class="load-more-container">
            <button class="btn-view-all">View All Tools</button>
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
            <div class="section-header">
                <h2 class="section-title">Browse Our AI Categories</h2>
                <p class="section-desc">Explore tools organized by specialized enterprise use cases.</p>
            </div>

            <div class="category-pills">
                <div class="pill active">All Categories</div>
                <div class="pill">Code & Tech</div>
                <div class="pill">Marketing</div>
                <div class="pill">Design & Art</div>
                <div class="pill">Writing</div>
                <div class="pill">Video</div>
                <div class="pill">Audio</div>
                <div class="pill">Productivity</div>
            </div>

            <div class="category-grid">
                <div class="cat-card">
                    <div class="cat-icon" style="background: #10b981;"><i class="fa-solid fa-code"></i></div>
                    <h4>Development</h4>
                    <p>140+ AI tools available</p>
                </div>
                <div class="cat-card">
                    <div class="cat-icon" style="background: #8b5cf6;"><i class="fa-solid fa-palette"></i></div>
                    <h4>Design & Graphics</h4>
                    <p>95+ AI tools available</p>
                </div>
                <div class="cat-card">
                    <div class="cat-icon" style="background: #f59e0b;"><i class="fa-solid fa-bullhorn"></i></div>
                    <h4>Marketing</h4>
                    <p>210+ AI tools available</p>
                </div>
                <div class="cat-card">
                    <div class="cat-icon" style="background: #3b82f6;"><i class="fa-solid fa-file-pen"></i></div>
                    <h4>Copywriting</h4>
                    <p>115+ AI tools available</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dual CTA Banners Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-grid">
                <div class="cta-card">
                    <h3>Are you an AI Software Vendor?</h3>
                    <p>Get featured in front of thousands of tech decision-makers looking for AI tools.</p>
                    <div class="cta-buttons">
                        <button class="btn-cta-pink">Submit Your Tool</button>
                        <button class="btn-cta-outline">Claim Vendor Profile</button>
                    </div>
                </div>

                <div class="cta-card" style="background: linear-gradient(135deg, #fce4ec 0%, #f48fb1 100%);">
                    <h3>Used an AI Tool? Share Your Experience</h3>
                    <p>Help millions of professionals make informed decisions by writing honest reviews.</p>
                    <div class="cta-buttons">
                        <button class="btn-cta-pink">Write a Review</button>
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

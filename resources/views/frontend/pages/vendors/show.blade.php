@extends('frontend.layout.app')

@section('meta_title', $tool->meta_title ?? ($tool->name ?? 'Software Tool') . ' Review 2026 - Pricing, Features & Ratings - TechAnalytica')
@section('meta_description', $tool->meta_description ?? $tool->short_description ?? 'Discover and review the best AI tools and software on TechAnalytica.')
@section('canonical_url', $tool->canonical_url ?? request()->url())

@section('content')
    @if (session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #a7f3d0; border-radius: 12px;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- 1. Vendor Detail Hero Header -->
    <section class="vendor-detail-hero">
        <div class="mesh-wave-hero"></div>
        <div class="container">
            <nav class="article-breadcrumb">
                <a href="{{ route('frontend.home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('frontend.vendors.crm') }}">Software Directory</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ $tool->name }}</span>
            </nav>

            <div class="vendor-detail-header-grid">
                <div class="vendor-brand-info">
                    <div class="vendor-logo-lg" style="background-color: #00a1e0; color: #fff;">
                        <i class="fa-solid fa-cloud"></i>
                    </div>
                    <div>
                        <div class="vendor-title-row">
                            <h1 class="vendor-name">{{ $tool->name }}</h1>
                            @if ($tool->is_verified)
                                <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified Leader</span>
                            @endif
                        </div>
                        <p class="vendor-tagline">{{ $tool->short_description }}</p>

                        <div class="vendor-detail-meta">
                            <div class="rating-box">
                                <span class="score-num">{{ $avgRating }}</span>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                </div>
                                <span class="review-count">({{ $totalReviews }} verified reviews)</span>
                            </div>
                            <span class="meta-divider">•</span>
                            <span class="meta-item"><i class="fa-solid fa-building"></i> {{ $tool->vendor->company_name ?? 'Verified Vendor' }}</span>
                            <span class="meta-divider">•</span>
                            <span class="meta-item"><i class="fa-solid fa-shield-halved"></i> SOC2 Type II Certified</span>
                        </div>

                        <div class="vendor-hero-pill-badges">
                            <span class="v-pill">Enterprise Leader</span>
                            <span class="v-pill">AI Automated</span>
                            <span class="v-pill">Cloud SaaS</span>
                            <span class="v-pill">Multi-Currency</span>
                        </div>
                    </div>
                </div>

                <div class="vendor-hero-actions">
                    <div class="techscore-card">
                        <span class="ts-label">TechScore</span>
                        <span class="ts-val">{{ $tool->rank ?? 98 }}<small>/100</small></span>
                    </div>
                    <a href="{{ $tool->website_url ?? '#' }}" target="_blank" class="btn-visit-lg" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Visit Website <i class="fa-solid fa-up-right-from-square"></i>
                    </a>
                    <div class="sub-actions">
                        <button class="btn-sub-action" data-bs-toggle="modal" data-bs-target="#reviewModal"><i class="fa-solid fa-pen-to-square"></i> Write Review</button>
                        <a href="{{ route('register-vendor') }}" class="btn-sub-action" style="text-decoration: none; display: inline-flex; align-items: center; gap: 4px;"><i class="fa-solid fa-bookmark"></i> Claim Tool</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Sticky Navigation Tabs -->
    <div class="vendor-tabs-bar">
        <div class="container tabs-inner">
            <a href="#overview" class="tab-link active">Overview</a>
            <a href="#calculator" class="tab-link">ROI Calculator</a>
            <a href="#features" class="tab-link">Features</a>
            <a href="#integrations" class="tab-link">Integrations</a>
            <a href="#proscons" class="tab-link">Pros & Cons</a>
            <a href="#benchmarks" class="tab-link">Benchmarks</a>
            <a href="#pricing" class="tab-link">Pricing</a>
            <a href="#reviews" class="tab-link">Reviews ({{ $totalReviews }})</a>
            <a href="#alternatives" class="tab-link">Alternatives</a>
            <a href="#faqs" class="tab-link">FAQs</a>
        </div>
    </div>

    <!-- 3. Main Vendor Body Grid -->
    <section class="container vendor-detail-main">
        <div class="vendor-content-grid">
            <!-- Left Main Content Column -->
            <div class="vendor-left-body">
                <!-- Scores Summary Grid -->
                <div class="detail-card">
                    <h3><i class="fa-solid fa-chart-pie"></i> Performance & Satisfaction Scores</h3>
                    <div class="scores-grid">
                        <div class="score-card-mini">
                            <div class="score-ring ring-98">98%</div>
                            <strong>Feature Depth</strong>
                            <span>Enterprise capability</span>
                        </div>
                        <div class="score-card-mini">
                            <div class="score-ring ring-86">86%</div>
                            <strong>Ease of Use</strong>
                            <span>Admin & User UI</span>
                        </div>
                        <div class="score-card-mini">
                            <div class="score-ring ring-96">96%</div>
                            <strong>AI Copilot</strong>
                            <span>Model accuracy</span>
                        </div>
                        <div class="score-card-mini">
                            <div class="score-ring ring-88">88%</div>
                            <strong>Value for Money</strong>
                            <span>ROI vs licensing fee</span>
                        </div>
                    </div>
                </div>

                <!-- Executive Overview & Technical Architecture -->
                <div id="overview" class="detail-card">
                    <h3>Overview & Technical Architecture</h3>
                    <p class="body-p">
                        {{ $tool->long_description ?? $tool->short_description }}
                    </p>
                </div>

                <!-- Interactive ROI Calculator Widget -->
                <div id="calculator" class="detail-card roi-calculator-card">
                    <div class="roi-header">
                        <div>
                            <h3><i class="fa-solid fa-calculator gradient-text"></i> Interactive ROI & Value Calculator</h3>
                            <p class="body-p">Estimate annual team savings and productivity gains from adopting {{ $tool->name }}.</p>
                        </div>
                        <span class="roi-badge">Interactive Tool</span>
                    </div>

                    <div class="roi-widget-grid">
                        <div class="roi-inputs">
                            <div class="roi-slider-group">
                                <label>Team Size: <strong id="repCount">25 users</strong></label>
                                <input type="range" min="5" max="250" value="25" class="roi-slider" id="repSlider" oninput="document.getElementById('repCount').innerText = this.value + ' users'; updateROI();">
                            </div>

                            <div class="roi-slider-group">
                                <label>Average Deal / Contract Size ($): <strong id="dealSize">$15,000</strong></label>
                                <input type="range" min="1000" max="100000" step="1000" value="15000" class="roi-slider" id="dealSlider" oninput="document.getElementById('dealSize').innerText = '$' + Number(this.value).toLocaleString(); updateROI();">
                            </div>

                            <div class="roi-slider-group">
                                <label>Hours Saved per User / Week: <strong id="hoursSaved">6 hours</strong></label>
                                <input type="range" min="1" max="20" value="6" class="roi-slider" id="hourSlider" oninput="document.getElementById('hoursSaved').innerText = this.value + ' hours'; updateROI();">
                            </div>
                        </div>

                        <div class="roi-outputs">
                            <div class="roi-output-box">
                                <span>Estimated Annual Value Generated</span>
                                <h2 id="annualRoi" class="gradient-text">$187,500</h2>
                            </div>
                            <div class="roi-sub-stats">
                                <div>
                                    <strong id="repEfficiency">+15%</strong>
                                    <span>Team Velocity</span>
                                </div>
                                <div>
                                    <strong id="paybackTime">2.4 mos</strong>
                                    <span>Payback Period</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature Matrix & Capabilities Breakdown -->
                <div id="features" class="detail-card">
                    <h3>Core Capabilities & Feature Checklist</h3>
                    <div class="capabilities-grid">
                        <div class="capability-item">
                            <div class="cap-icon"><i class="fa-solid fa-chart-line"></i></div>
                            <div>
                                <h4>Pipeline & Task Management</h4>
                                <p>Automated stage progression rules, Kanban boards, and multi-currency pipelines.</p>
                            </div>
                        </div>
                        <div class="capability-item">
                            <div class="cap-icon"><i class="fa-solid fa-robot"></i></div>
                            <div>
                                <h4>AI Intelligence & Copilot</h4>
                                <p>Generative text drafting, automated predictive summarization, and deal risk scoring.</p>
                            </div>
                        </div>
                        <div class="capability-item">
                            <div class="cap-icon"><i class="fa-solid fa-network-wired"></i></div>
                            <div>
                                <h4>Visual Workflow Automation</h4>
                                <p>No-code visual automation pipelines for conditional routing and approval flows.</p>
                            </div>
                        </div>
                        <div class="capability-item">
                            <div class="cap-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <div>
                                <h4>Enterprise Security & Governance</h4>
                                <p>Role-based access control (RBAC), field-level encryption, SOC2 Type II compliance.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Key Integrations Ecosystem Grid -->
                <div id="integrations" class="detail-card">
                    <h3>Enterprise Integration Ecosystem</h3>
                    <p class="body-p">{{ $tool->name }} connects natively with popular cloud productivity platforms.</p>

                    <div class="integrations-grid-full">
                        <div class="int-box"><i class="fa-brands fa-slack" style="color: #e01e5a;"></i><span>Slack</span></div>
                        <div class="int-box"><i class="fa-brands fa-google" style="color: #4285f4;"></i><span>Google Workspace</span></div>
                        <div class="int-box"><i class="fa-brands fa-microsoft" style="color: #00a4ef;"></i><span>Microsoft 365</span></div>
                        <div class="int-box"><i class="fa-solid fa-bolt" style="color: #ff4a00;"></i><span>Zapier</span></div>
                        <div class="int-box"><i class="fa-brands fa-stripe" style="color: #635bff;"></i><span>Stripe</span></div>
                        <div class="int-box"><i class="fa-solid fa-snowflake" style="color: #29b5e8;"></i><span>Snowflake</span></div>
                        <div class="int-box"><i class="fa-brands fa-jira" style="color: #0052cc;"></i><span>Jira</span></div>
                        <div class="int-box"><i class="fa-brands fa-aws" style="color: #ff9900;"></i><span>AWS</span></div>
                        <div class="int-box"><i class="fa-brands fa-hubspot" style="color: #ff7a59;"></i><span>HubSpot</span></div>
                        <div class="int-box"><i class="fa-solid fa-chart-pie" style="color: #e97627;"></i><span>Tableau</span></div>
                        <div class="int-box"><i class="fa-solid fa-file-signature" style="color: #ff0000;"></i><span>DocuSign</span></div>
                        <div class="int-box"><i class="fa-solid fa-video" style="color: #2d8cff;"></i><span>Zoom</span></div>
                    </div>
                </div>

                <!-- Pros & Cons Section -->
                <div id="proscons" class="detail-card">
                    <h3>Pros & Cons Breakdown</h3>
                    <div class="pros-cons-grid">
                        <div class="pros-column">
                            <h4><i class="fa-solid fa-thumbs-up check-green"></i> Key Advantages</h4>
                            <ul class="pc-list">
                                <li><i class="fa-solid fa-check check-green"></i> Unrivaled customization via Custom Objects and Flow Builder.</li>
                                <li><i class="fa-solid fa-check check-green"></i> Native AI predictive lead and opportunity scoring.</li>
                                <li><i class="fa-solid fa-check check-green"></i> Extensive marketplace with hundreds of third-party integrations.</li>
                                <li><i class="fa-solid fa-check check-green"></i> Enterprise-grade security, role hierarchies, and audit logs.</li>
                            </ul>
                        </div>

                        <div class="cons-column">
                            <h4><i class="fa-solid fa-thumbs-down check-orange"></i> Potential Drawbacks</h4>
                            <ul class="pc-list">
                                <li><i class="fa-solid fa-xmark check-orange"></i> Learning curve for non-technical team members during initial setup.</li>
                                <li><i class="fa-solid fa-xmark check-orange"></i> Advanced tiers require higher annual licensing investments.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Performance & Latency Benchmarks -->
                <div id="benchmarks" class="detail-card">
                    <h3>Technical Performance Benchmarks</h3>
                    <div class="benchmarks-grid">
                        <div class="benchmark-item">
                            <span class="bm-label">API Response Latency (p95)</span>
                            <div class="bm-bar-wrap">
                                <div class="bm-bar" style="width: 88%;"></div>
                            </div>
                            <span class="bm-val">142ms <small>(Industry avg: 220ms)</small></span>
                        </div>
                        <div class="benchmark-item">
                            <span class="bm-label">Platform Uptime SLA</span>
                            <div class="bm-bar-wrap">
                                <div class="bm-bar bar-green" style="width: 99.9%;"></div>
                            </div>
                            <span class="bm-val">99.99% <small>Guaranteed</small></span>
                        </div>
                        <div class="benchmark-item">
                            <span class="bm-label">Realtime Webhook Delivery</span>
                            <div class="bm-bar-wrap">
                                <div class="bm-bar bar-purple" style="width: 95%;"></div>
                            </div>
                            <span class="bm-val">99.4% <small>Within 500ms</small></span>
                        </div>
                    </div>
                </div>

                <!-- Pricing Plans Section (Dynamic from structured pricing) -->
                <div id="pricing" class="detail-card">
                    <h3>Pricing & Subscription Tiers</h3>
                    <p class="body-p">{{ $tool->name }} pricing starts from {{ $tool->pricing_text ?? '$25 / user / mo' }}.</p>

                    <div class="pricing-cards-grid">
                        @if (!empty($tool->pricing_structured) && is_array($tool->pricing_structured))
                            @foreach ($tool->pricing_structured as $tierKey => $tier)
                                <div class="p-card {{ $tierKey === 'pro' || $tierKey === 'professional' ? 'featured-p-card' : '' }}">
                                    @if ($tierKey === 'pro' || $tierKey === 'professional')
                                        <span class="p-badge-popular">Most Popular</span>
                                    @endif
                                    <span class="p-tier">{{ $tier['name'] ?? ucfirst($tierKey) }}</span>
                                    <div class="p-price">{{ $tier['price'] ?? '$25' }} <span>/ user / mo</span></div>
                                    <p class="p-desc">{{ $tier['desc'] ?? 'Complete features for scaling teams.' }}</p>
                                    @if (!empty($tier['features']))
                                        <ul class="p-features">
                                            @foreach ($tier['features'] as $feat)
                                                <li><i class="fa-solid fa-check"></i> {{ $feat }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="p-card">
                                <span class="p-tier">Starter</span>
                                <div class="p-price">$25 <span>/ user / mo</span></div>
                                <p class="p-desc">Simplified setup for small teams.</p>
                                <ul class="p-features">
                                    <li><i class="fa-solid fa-check"></i> Basic Lead & Task Tracking</li>
                                    <li><i class="fa-solid fa-check"></i> Email Integration</li>
                                </ul>
                            </div>
                            <div class="p-card featured-p-card">
                                <span class="p-badge-popular">Most Popular</span>
                                <span class="p-tier">Professional</span>
                                <div class="p-price">$80 <span>/ user / mo</span></div>
                                <p class="p-desc">Complete features for growing teams.</p>
                                <ul class="p-features">
                                    <li><i class="fa-solid fa-check"></i> Automated Workflows</li>
                                    <li><i class="fa-solid fa-check"></i> AI Analytics Copilot</li>
                                </ul>
                            </div>
                            <div class="p-card">
                                <span class="p-tier">Enterprise</span>
                                <div class="p-price">$165 <span>/ user / mo</span></div>
                                <p class="p-desc">Custom enterprise integrations.</p>
                                <ul class="p-features">
                                    <li><i class="fa-solid fa-check"></i> Dedicated Account Manager</li>
                                    <li><i class="fa-solid fa-check"></i> 24/7 SLA Support</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Verified User Reviews (Dynamic) -->
                <div id="reviews" class="detail-card">
                    <div class="reviews-header-row">
                        <div>
                            <h3>Verified User Reviews</h3>
                            <p class="body-p">Based on {{ $totalReviews }} authenticated practitioner reviews.</p>
                        </div>
                        <button class="btn-write-review" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            <i class="fa-solid fa-pen-to-square"></i> Leave a Review
                        </button>
                    </div>

                    <div class="reviews-breakdown-box">
                        <div class="reviews-summary-score">
                            <h1>{{ $avgRating }}</h1>
                            <div class="stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                            </div>
                            <span>{{ $starBreakdown[5]['percentage'] ?? 82 }}% recommend this tool</span>
                        </div>

                        <div class="rating-bars-list">
                            @for ($s = 5; $s >= 1; $s--)
                                <div class="rating-bar-row">
                                    <span>{{ $s }} ★</span>
                                    <div class="bar-track">
                                        <div class="bar-fill" style="width: {{ $starBreakdown[$s]['percentage'] ?? 0 }}%;"></div>
                                    </div>
                                    <span>{{ $starBreakdown[$s]['percentage'] ?? 0 }}%</span>
                                </div>
                            @endfor
                        </div>
                    </div>

                    @forelse($tool->reviews as $rev)
                        <div class="user-review-card">
                            <div class="review-top-meta">
                                <div class="user-row">
                                    <div class="user-avatar" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80');"></div>
                                    <div>
                                        <strong>{{ $rev->user_name }}</strong>
                                        <span>Verified Reviewer • {{ $rev->created_at ? $rev->created_at->format('M d, Y') : 'Aug 2026' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="stars review-stars">
                                @for ($st = 0; $st < $rev->rating; $st++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <p class="review-text">"{{ $rev->comment }}"</p>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <p>No verified reviews written yet. Be the first to leave a review!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Alternatives & Competitors (Dynamic) -->
                <div id="alternatives" class="detail-card">
                    <h3>Top {{ $tool->name }} Alternatives</h3>
                    <div class="alt-grid">
                        @foreach ($alternatives as $alt)
                            <div class="alt-card">
                                <div class="alt-header">
                                    <div class="alt-logo" style="background: #ff7a59; color: #fff;"><i class="fa-solid fa-bolt"></i></div>
                                    <div>
                                        <h4>{{ $alt->name }}</h4>
                                        <span class="alt-score">TechScore: {{ $alt->rank ?? 95 }}/100</span>
                                    </div>
                                </div>
                                <p>{{ Str::limit($alt->short_description, 90) }}</p>
                                <a href="{{ route('frontend.vendors.show', $alt->slug) }}" class="btn-alt-compare">Compare vs {{ $tool->name }} <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tool FAQs Accordion -->
                <div id="faqs" class="detail-card">
                    <h3>Frequently Asked Questions</h3>
                    <div class="faq-accordion">
                        <div class="faq-item active" onclick="this.classList.toggle('active')">
                            <div class="faq-header">
                                <h5>What makes {{ $tool->name }} different from competitors?</h5>
                                <i class="fa-solid fa-chevron-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <p>{{ $tool->short_description }}</p>
                            </div>
                        </div>

                        <div class="faq-item" onclick="this.classList.toggle('active')">
                            <div class="faq-header">
                                <h5>Is there a free trial available for {{ $tool->name }}?</h5>
                                <i class="fa-solid fa-chevron-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Yes, most plans offer a 14 to 30-day trial without requiring a credit card upfront.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Specifications Sidebar -->
            <aside class="vendor-right-sidebar">
                <div class="specs-box">
                    <h4><i class="fa-solid fa-sliders"></i> Quick Specifications</h4>
                    <div class="spec-row">
                        <span>Tool Name:</span>
                        <strong>{{ $tool->name }}</strong>
                    </div>
                    <div class="spec-row">
                        <span>Vendor:</span>
                        <strong>{{ $tool->vendor->company_name ?? 'Verified Vendor' }}</strong>
                    </div>
                    <div class="spec-row">
                        <span>Deployment:</span>
                        <strong>Cloud SaaS, Web, API</strong>
                    </div>
                    <div class="spec-row">
                        <span>Starting Price:</span>
                        <strong>{{ $tool->pricing_text ?? '$25 / user / mo' }}</strong>
                    </div>
                    <div class="spec-row">
                        <span>Verified:</span>
                        <strong>{{ $tool->is_verified ? 'Yes' : 'Pending' }}</strong>
                    </div>
                </div>

                <div class="sidebar-cta-card">
                    <i class="fa-solid fa-wand-magic-sparkles cta-icon"></i>
                    <h4>Need custom software recommendations?</h4>
                    <p>Use our AI analysis engine to calculate exact team pricing and feature fit.</p>
                    <a href="{{ route('frontend.vendors.crm') }}" class="btn-sidebar-trial" style="text-decoration: none; display: block; text-align: center;">Run Comparison AI</a>
                </div>
            </aside>
        </div>
    </section>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #14091a; border: 1px solid rgba(224, 67, 133, 0.3); color: #fff; border-radius: 16px;">
                <div class="modal-header" style="border-bottom: 1px solid rgba(224, 67, 133, 0.2);">
                    <h5 class="modal-title" id="reviewModalLabel">Review {{ $tool->name }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('frontend.reviews.store', $tool->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-white">Your Name</label>
                            <input type="text" name="user_name" required class="form-control" style="background: #0b0410; border: 1px solid rgba(224, 67, 133, 0.3); color: #fff;" placeholder="e.g. Sarah Jenkins">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Your Email</label>
                            <input type="email" name="user_email" required class="form-control" style="background: #0b0410; border: 1px solid rgba(224, 67, 133, 0.3); color: #fff;" placeholder="e.g. sarah@company.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Rating (1 to 5 Stars)</label>
                            <select name="rating" required class="form-select" style="background: #0b0410; border: 1px solid rgba(224, 67, 133, 0.3); color: #fff;">
                                <option value="5">★★★★★ (5 Stars - Excellent)</option>
                                <option value="4">★★★★☆ (4 Stars - Very Good)</option>
                                <option value="3">★★★☆☆ (3 Stars - Average)</option>
                                <option value="2">★★☆☆☆ (2 Stars - Needs Improvement)</option>
                                <option value="1">★☆☆☆☆ (1 Star - Poor)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Your Review & Experience</label>
                            <textarea name="comment" rows="4" required class="form-control" style="background: #0b0410; border: 1px solid rgba(224, 67, 133, 0.3); color: #fff;" placeholder="How did this tool improve your workflow?"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid rgba(224, 67, 133, 0.2);">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #e04385 0%, #a4358a 100%); border: none;">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 4. Trial CTA Box -->
    <div class="container" style="margin-bottom: 80px;">
        <div class="trial-cta-box">
            <div>
                <h2>Ready to evaluate {{ $tool->name }}?</h2>
                <p>Start your trial or compare against similar software in its category.</p>
                <div class="cta-btns">
                    <a href="{{ $tool->website_url ?? '#' }}" target="_blank" class="btn-trial-pink" style="text-decoration: none; display: inline-block;">Visit Official Site</a>
                    <a href="{{ route('frontend.vendors.crm') }}" class="btn-trial-outline" style="text-decoration: none; display: inline-block;">Compare Alternatives</a>
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

    <script>
        function updateROI() {
            var reps = parseInt(document.getElementById('repSlider').value);
            var deal = parseInt(document.getElementById('dealSlider').value);
            var hours = parseInt(document.getElementById('hourSlider').value);

            var savings = (reps * hours * 52 * 50) + (reps * (deal * 0.15));
            document.getElementById('annualRoi').innerText = '$' + Math.round(savings).toLocaleString();
        }
    </script>
@endsection

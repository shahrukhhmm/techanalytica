@extends('frontend.layout.app')

@section('title', 'Salesforce Sales Cloud Review 2026 - Pricing, Features & Ratings - TechAnalytica')

@section('content')
    <!-- Vendor Detail Hero Header -->
    <section class="vendor-detail-hero">
        <div class="container">
            <nav class="article-breadcrumb">
                <a href="{{ route('frontend.home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('frontend.vendors.crm') }}">CRM Software</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Salesforce Sales Cloud</span>
            </nav>

            <div class="vendor-detail-header-grid">
                <div class="vendor-brand-info">
                    <div class="vendor-logo-lg" style="background-color: #00a1e0; color: #fff;">
                        <i class="fa-solid fa-cloud"></i>
                    </div>
                    <div>
                        <div class="vendor-title-row">
                            <h1 class="vendor-name">Salesforce Sales Cloud</h1>
                            <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified Leader</span>
                        </div>
                        <p class="vendor-tagline">The enterprise CRM platform engineered for AI-driven pipeline automation, revenue forecasting, and global sales operations.</p>
                        
                        <div class="vendor-detail-meta">
                            <div class="rating-box">
                                <span class="score-num">4.8</span>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                </div>
                                <span class="review-count">(4,120 verified reviews)</span>
                            </div>
                            <span class="meta-divider">•</span>
                            <span class="meta-item"><i class="fa-solid fa-building"></i> Salesforce, Inc.</span>
                            <span class="meta-divider">•</span>
                            <span class="meta-item"><i class="fa-solid fa-shield-halved"></i> SOC2 Type II Certified</span>
                        </div>
                    </div>
                </div>

                <div class="vendor-hero-actions">
                    <div class="techscore-card">
                        <span class="ts-label">TechScore</span>
                        <span class="ts-val">98<small>/100</small></span>
                    </div>
                    <button class="btn-visit-lg">Visit Official Website <i class="fa-solid fa-up-right-from-square"></i></button>
                    <div class="sub-actions">
                        <button class="btn-sub-action"><i class="fa-solid fa-pen-to-square"></i> Write Review</button>
                        <button class="btn-sub-action"><i class="fa-solid fa-code-compare"></i> Compare</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sticky Navigation Tabs -->
    <div class="vendor-tabs-bar">
        <div class="container tabs-inner">
            <a href="#overview" class="tab-link active">Overview</a>
            <a href="#scores" class="tab-link">Scores</a>
            <a href="#features" class="tab-link">Features</a>
            <a href="#pricing" class="tab-link">Pricing</a>
            <a href="#proscons" class="tab-link">Pros & Cons</a>
            <a href="#reviews" class="tab-link">Reviews (4.1k)</a>
            <a href="#integrations" class="tab-link">Integrations</a>
            <a href="#alternatives" class="tab-link">Alternatives</a>
        </div>
    </div>

    <!-- Main Vendor Body Grid -->
    <section class="container vendor-detail-main">
        <div class="vendor-content-grid">
            <!-- Left Main Content Column -->
            <div class="vendor-left-body">
                <!-- Ratings Scores Grid -->
                <div id="scores" class="detail-card">
                    <h3><i class="fa-solid fa-chart-pie"></i> Performance & Satisfaction Scores</h3>
                    <div class="scores-grid">
                        <div class="score-card-mini">
                            <div class="score-ring">96%</div>
                            <strong>User Satisfaction</strong>
                            <span>Based on 4,100+ surveys</span>
                        </div>
                        <div class="score-card-mini">
                            <div class="score-ring">94%</div>
                            <strong>Ease of Use</strong>
                            <span>UI & navigation clarity</span>
                        </div>
                        <div class="score-card-mini">
                            <div class="score-ring">98%</div>
                            <strong>AI Capabilities</strong>
                            <span>Einstein Copilot rating</span>
                        </div>
                        <div class="score-card-mini">
                            <div class="score-ring">92%</div>
                            <strong>Value for Money</strong>
                            <span>ROI vs licensing fee</span>
                        </div>
                    </div>
                </div>

                <!-- Executive Summary Section -->
                <div id="overview" class="detail-card">
                    <h3>Executive Summary</h3>
                    <p class="body-p">
                        Salesforce Sales Cloud is the undisputed market leader in enterprise customer relationship management. Designed to unify sales, marketing, and customer service data into a single source of truth, it provides unmatched workflow automation, predictive opportunity scoring, and deeply customizable reporting dashboards.
                    </p>
                    <p class="body-p">
                        With the rollout of Einstein 1 AI, revenue teams can generate automated email sequences, summarize deal history, and predict win probabilities with real-time telemetry. While its feature set is unrivaled, small teams should factor in setup complexity and administrator certification requirements.
                    </p>
                </div>

                <!-- Interface Showcase Mockup -->
                <div class="detail-card">
                    <h3>Interface & Pipeline Dashboard Preview</h3>
                    <div class="interface-preview-img" style="background-image: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80');">
                        <div class="preview-badge"><i class="fa-solid fa-expand"></i> Interactive Pipeline Board</div>
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
                                <li><i class="fa-solid fa-check check-green"></i> Native Einstein AI predictive lead and opportunity scoring.</li>
                                <li><i class="fa-solid fa-check check-green"></i> AppExchange marketplace with over 3,500 third-party integrations.</li>
                                <li><i class="fa-solid fa-check check-green"></i> Enterprise-grade security, role hierarchies, and audit logs.</li>
                            </ul>
                        </div>

                        <div class="cons-column">
                            <h4><i class="fa-solid fa-thumbs-down check-orange"></i> Potential Drawbacks</h4>
                            <ul class="pc-list">
                                <li><i class="fa-solid fa-xmark check-orange"></i> Steep learning curve for non-technical sales representatives.</li>
                                <li><i class="fa-solid fa-xmark check-orange"></i> High total cost of ownership (TCO) for add-on licenses.</li>
                                <li><i class="fa-solid fa-xmark check-orange"></i> Requires dedicated certified Salesforce Admin for setup.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Pricing Plans Section -->
                <div id="pricing" class="detail-card">
                    <h3>Pricing & Subscription Tiers</h3>
                    <p class="body-p">Salesforce Sales Cloud is billed annually per user per month. Free 30-day trial available without credit card.</p>
                    
                    <div class="pricing-cards-grid">
                        <div class="p-card">
                            <span class="p-tier">Starter</span>
                            <div class="p-price">$25 <span>/ user / mo</span></div>
                            <p class="p-desc">Simplified CRM for small teams up to 10 users.</p>
                            <ul class="p-features">
                                <li><i class="fa-solid fa-check"></i> Basic Lead & Deal Tracking</li>
                                <li><i class="fa-solid fa-check"></i> Email Integration</li>
                            </ul>
                        </div>

                        <div class="p-card featured-p-card">
                            <span class="p-badge-popular">Most Popular</span>
                            <span class="p-tier">Professional</span>
                            <div class="p-price">$80 <span>/ user / mo</span></div>
                            <p class="p-desc">Complete CRM features for teams of any size.</p>
                            <ul class="p-features">
                                <li><i class="fa-solid fa-check"></i> Pipeline & Forecast Mgmt</li>
                                <li><i class="fa-solid fa-check"></i> Rule-Based Lead Assignment</li>
                                <li><i class="fa-solid fa-check"></i> Quote & Contract Creation</li>
                            </ul>
                        </div>

                        <div class="p-card">
                            <span class="p-tier">Enterprise</span>
                            <div class="p-price">$165 <span>/ user / mo</span></div>
                            <p class="p-desc">Deep customization & AI for complex organizations.</p>
                            <ul class="p-features">
                                <li><i class="fa-solid fa-check"></i> Einstein 1 AI Copilot</li>
                                <li><i class="fa-solid fa-check"></i> Workflow Automation</li>
                                <li><i class="fa-solid fa-check"></i> Unlimited Custom Roles</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Integrations Grid -->
                <div id="integrations" class="detail-card">
                    <h3>Popular Software Integrations</h3>
                    <p class="body-p">Salesforce connects natively with over 3,500 enterprise applications.</p>
                    
                    <div class="integrations-grid">
                        <div class="int-item"><i class="fa-brands fa-slack int-icon" style="color: #4a154b;"></i> <span>Slack</span></div>
                        <div class="int-item"><i class="fa-brands fa-google int-icon" style="color: #ea4335;"></i> <span>Gmail</span></div>
                        <div class="int-item"><i class="fa-brands fa-microsoft int-icon" style="color: #00a4ef;"></i> <span>Outlook</span></div>
                        <div class="int-item"><i class="fa-solid fa-bolt int-icon" style="color: #ff4a00;"></i> <span>Zapier</span></div>
                        <div class="int-item"><i class="fa-solid fa-file-signature int-icon" style="color: #ff0000;"></i> <span>DocuSign</span></div>
                        <div class="int-item"><i class="fa-brands fa-stripe int-icon" style="color: #635bff;"></i> <span>Stripe</span></div>
                    </div>
                </div>

                <!-- Alternatives & Competitors -->
                <div id="alternatives" class="detail-card">
                    <h3>Top Salesforce Alternatives</h3>
                    <div class="alt-grid">
                        <div class="alt-card">
                            <h4>HubSpot Sales Hub</h4>
                            <span class="alt-score">TechScore: 96/100</span>
                            <p>Easier user onboarding and generous free plan tier for startups.</p>
                            <a href="{{ route('frontend.vendors.crm') }}" class="btn-alt-compare">Compare vs Salesforce</a>
                        </div>
                        <div class="alt-card">
                            <h4>Zoho CRM</h4>
                            <span class="alt-score">TechScore: 94/100</span>
                            <p>Higher value for money at $14/mo with Zia AI automation.</p>
                            <a href="{{ route('frontend.vendors.crm') }}" class="btn-alt-compare">Compare vs Salesforce</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Specifications Sidebar -->
            <aside class="vendor-right-sidebar">
                <div class="specs-box">
                    <h4><i class="fa-solid fa-sliders"></i> Vendor Specifications</h4>
                    <div class="spec-row">
                        <span>Vendor Name:</span>
                        <strong>Salesforce, Inc.</strong>
                    </div>
                    <div class="spec-row">
                        <span>Headquarters:</span>
                        <strong>San Francisco, CA</strong>
                    </div>
                    <div class="spec-row">
                        <span>Founded Year:</span>
                        <strong>1999</strong>
                    </div>
                    <div class="spec-row">
                        <span>Deployment:</span>
                        <strong>Cloud, Mobile (iOS/Android)</strong>
                    </div>
                    <div class="spec-row">
                        <span>Support Channels:</span>
                        <strong>24/7 Phone, Chat, Knowledge Base</strong>
                    </div>
                    <div class="spec-row">
                        <span>Target Business Size:</span>
                        <strong>Mid-Market, Enterprise</strong>
                    </div>
                    <div class="spec-row">
                        <span>API Access:</span>
                        <strong>REST & SOAP APIs</strong>
                    </div>
                </div>

                <div class="sidebar-cta-card">
                    <i class="fa-solid fa-wand-magic-sparkles cta-icon"></i>
                    <h4>Want a custom CRM comparison report?</h4>
                    <p>Tell our AI analyst your team size and budget for an instant breakdown.</p>
                    <button class="btn-sidebar-trial">Generate AI Report</button>
                </div>
            </aside>
        </div>
    </section>

    <!-- Trial CTA Box -->
    <div class="container" style="margin-bottom: 80px;">
        <div class="trial-cta-box">
            <div>
                <h2>Ready to evaluate Salesforce Sales Cloud?</h2>
                <p>Start your 30-day unlimited trial or request a custom architectural demo.</p>
                <div class="cta-btns">
                    <button class="btn-trial-pink">Start Free 30-Day Trial</button>
                    <button class="btn-trial-outline">Book Custom Demo</button>
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

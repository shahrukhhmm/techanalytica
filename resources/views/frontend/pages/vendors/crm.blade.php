@extends('frontend.layout.app')

@section('meta_title', $category->meta_title ?? 'Best ' . ($category->name ?? 'CRM Software') . ' in 2026 - Reviews, Pricing & Comparison - TechAnalytica')
@section('meta_description', $category->meta_description ?? $category->description ?? 'Compare top ' . ($category->name ?? 'software') . ' platforms based on verified user reviews.')
@section('canonical_url', $category->canonical_url ?? request()->url())

@section('content')
    <!-- Vendor Hero Header -->
    <section class="vendor-hero">
        <div class="container">
            <nav class="article-breadcrumb">
                <a href="{{ route('frontend.home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('frontend.vendors.crm') }}">Software Categories</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ $category->name ?? 'CRM Software' }}</span>
            </nav>

            <div class="vendor-hero-content">
                <div class="vendor-hero-text">
                    <span class="blog-badge"><i class="fa-solid fa-fire"></i> Updated for 2026</span>
                    <h1 class="vendor-hero-title">Best <span class="gradient-text">{{ $category->name ?? 'CRM Software' }}</span> in 2026</h1>
                    <p class="vendor-hero-desc">
                        {{ $category->description ?? 'Compare top Customer Relationship Management platforms based on verified user reviews, AI capabilities, pipeline automation, and enterprise pricing.' }}
                    </p>

                    <div class="vendor-header-stats">
                        <div class="header-rating-badge">
                            <span class="score-num">4.8</span>
                            <div class="stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                            </div>
                            <span class="rating-count">({{ number_format($categoryReviewsCount ?? 14280) }} verified reviews)</span>
                        </div>
                        <div class="header-meta">
                            <span><i class="fa-solid fa-arrows-rotate"></i> Updated Aug 2026</span>
                            <span><i class="fa-solid fa-circle-check"></i> TechScore Tested</span>
                        </div>
                        <a href="{{ route('register-vendor') }}" class="btn-write-review" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-plus"></i> Submit a Tool
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Overview & Key Takeaways Grid -->
    <section class="vendor-overview-section">
        <div class="container vendor-overview-grid">
            <div class="overview-left-text">
                <h2>What is {{ $category->name ?? 'CRM Software' }}?</h2>
                <p>
                    {{ $category->description ?? 'Software that tracks interactions between businesses and prospects across sales pipelines, marketing touchpoints, and support channels.' }} Modern platforms leverage predictive AI lead scoring, automated email sequencing, and deep analytics to accelerate revenue growth.
                </p>

                <h2>Key Selection Factors for 2026</h2>
                <ul class="overview-list">
                    <li><strong>AI Copilot Integration:</strong> Automated call transcription, email drafting, and win-probability forecasts.</li>
                    <li><strong>Pipeline Customization:</strong> Multi-currency support, custom deal stages, and automated lead routing rules.</li>
                    <li><strong>Ecosystem Integrations:</strong> Native sync with Slack, Gmail, Microsoft 365, Zapier, and ERP platforms.</li>
                </ul>
            </div>

            <!-- Quick Summary Widget Box -->
            <aside class="quick-summary-box">
                <h3><i class="fa-solid fa-bolt"></i> Quick {{ $category->name ?? 'CRM' }} Summary</h3>
                <div class="summary-item">
                    <span>Top Pick Overall:</span>
                    <strong>{{ $topPicks->first()->name ?? 'Salesforce Sales Cloud' }}</strong>
                </div>
                <div class="summary-item">
                    <span>Total Tools Listed:</span>
                    <strong>{{ $tools->total() ?? 12 }} Verified Solutions</strong>
                </div>
                <div class="summary-item">
                    <span>Average Price Range:</span>
                    <strong>$14 - $165 / user / mo</strong>
                </div>
                <button class="btn-jump-rankings" onclick="document.getElementById('rankings').scrollIntoView({behavior: 'smooth'})">
                    Jump to Rankings <i class="fa-solid fa-arrow-down"></i>
                </button>
            </aside>
        </div>
    </section>

    <!-- Top Pick Badges Banner (Dynamic) -->
    <section class="container top-picks-section">
        <div class="section-heading">
            <h2><i class="fa-solid fa-trophy"></i> 2026 Top Recommended {{ $category->name ?? 'CRM' }} Picks</h2>
        </div>

        <div class="top-picks-grid">
            @php
                $pickBorders = ['gold-border', 'pink-border', 'blue-border', 'green-border'];
                $badgeClasses = ['gold', 'pink', 'blue', 'green'];
                $badgeTitles = ['Best Overall', 'Best for SMBs', 'Best Value', 'Best Pipeline UI'];
                $badgeIcons = ['fa-crown', 'fa-rocket', 'fa-piggy-bank', 'fa-bullseye'];
            @endphp
            @foreach ($topPicks as $pIndex => $pick)
                @php
                    $bClass = $pickBorders[$pIndex % count($pickBorders)];
                    $badgeCls = $badgeClasses[$pIndex % count($badgeClasses)];
                    $bTitle = $badgeTitles[$pIndex % count($badgeTitles)];
                    $bIcon = $badgeIcons[$pIndex % count($badgeIcons)];
                @endphp
                <a href="{{ route('frontend.vendors.show', $pick->slug) }}" class="pick-card {{ $bClass }}" style="text-decoration: none; color: inherit;">
                    <span class="pick-badge {{ $badgeCls }}"><i class="fa-solid {{ $bIcon }}"></i> {{ $bTitle }}</span>
                    <h4>{{ $pick->name }}</h4>
                    <p>{{ Str::limit($pick->short_description, 75) }}</p>
                    <div class="pick-score">TechScore: <strong>{{ $pick->rank ?? 95 }}/100</strong></div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Main Vendor Rankings Section (Dynamic) -->
    <section id="rankings" class="container rankings-section">
        <form action="{{ route('frontend.category.show', $category->slug) }}" method="GET" class="rankings-filter-bar">
            <div class="filter-pills">
                <a href="{{ route('frontend.category.show', $category->slug) }}" class="blog-pill active">All {{ $category->name }} ({{ $tools->total() }})</a>
                @foreach ($relatedCategories as $rCat)
                    <a href="{{ route('frontend.category.show', $rCat->slug) }}" class="blog-pill">{{ $rCat->name }}</a>
                @endforeach
            </div>
            <div class="sort-box d-flex align-items-center gap-2">
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Filter tools..." class="form-control form-control-sm" style="background: #14091a; border: 1px solid rgba(224, 67, 133, 0.3); color: #fff; border-radius: 8px; max-width: 180px;">
                <select name="sort" onchange="this.form.submit()" class="sort-select">
                    <option value="rank" {{ ($sortBy ?? '') === 'rank' ? 'selected' : '' }}>Highest TechScore</option>
                    <option value="rating" {{ ($sortBy ?? '') === 'rating' ? 'selected' : '' }}>Highest Rating</option>
                    <option value="reviews" {{ ($sortBy ?? '') === 'reviews' ? 'selected' : '' }}>Most Reviews</option>
                </select>
            </div>
        </form>

        <!-- Dynamic Tools Cards -->
        @php
            $bgColors = ['#00a1e0', '#ff7a59', '#e42527', '#222222', '#6366f1', '#10b981'];
            $logoIcons = ['fa-cloud', 'fa-bolt', 'fa-boxes-stacked', 'fa-chart-line', 'fa-cube', 'fa-wand-magic-sparkles'];
        @endphp
        @forelse($tools as $index => $tool)
            @php
                $bgColor = $bgColors[$index % count($bgColors)];
                $lIcon = $logoIcons[$index % count($logoIcons)];
                $avgRate = $tool->reviews_avg_rating ? number_format($tool->reviews_avg_rating, 1) : '4.8';
                $revCount = $tool->reviews_count ?? ($tool->reviews ? $tool->reviews->count() : 12);
            @endphp
            <div class="vendor-card-detailed">
                <div class="vendor-card-header">
                    <div class="vendor-info-group">
                        <div class="vendor-rank">#{{ $tools->firstItem() + $index }}</div>
                        <div class="vendor-logo-box" style="background-color: {{ $bgColor }}; color: #fff;">
                            <i class="fa-solid {{ $lIcon }}" style="font-size: 26px;"></i>
                        </div>
                        <div>
                            <div class="vendor-title-row">
                                <a href="{{ route('frontend.vendors.show', $tool->slug) }}" style="text-decoration: none; color: inherit;">
                                    <h3 style="cursor: pointer;">{{ $tool->name }}</h3>
                                </a>
                                @if ($tool->is_verified)
                                    <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified Leader</span>
                                @endif
                            </div>

                            <div class="vendor-rating-row">
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                </div>
                                <span class="rating-text"><strong>{{ $avgRate }}</strong> ({{ $revCount }} reviews)</span>
                                <span class="pricing-text">• Starting from <strong>{{ $tool->pricing_text ?? '$19 / user / mo' }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="vendor-action-box">
                        <div class="techscore-badge">
                            <span class="score-title">TechScore</span>
                            <span class="score-value">{{ $tool->rank ?? 95 }}/100</span>
                        </div>
                        <a href="{{ route('frontend.vendors.show', $tool->slug) }}" class="btn-visit">View Profile <i class="fa-solid fa-up-right-from-square"></i></a>
                    </div>
                </div>

                <div class="vendor-card-body">
                    <p class="vendor-description">
                        {{ $tool->short_description }}
                    </p>

                    <div class="vendor-features-row">
                        <span class="feature-tag"><i class="fa-solid fa-check"></i> AI Automated Intelligence</span>
                        <span class="feature-tag"><i class="fa-solid fa-check"></i> Custom Workflow Rules</span>
                        <span class="feature-tag"><i class="fa-solid fa-check"></i> 50+ Connected Ecosystem Apps</span>
                        <span class="feature-tag"><i class="fa-solid fa-check"></i> Real-time Telemetry Sync</span>
                    </div>

                    <!-- Verified Review Highlight -->
                    @if ($tool->reviews->isNotEmpty())
                        @php $firstRev = $tool->reviews->first(); @endphp
                        <div class="vendor-review-highlight">
                            <div class="reviewer-avatar" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80');"></div>
                            <div>
                                <p class="review-quote">"{{ Str::limit($firstRev->comment, 140) }}"</p>
                                <span class="reviewer-meta">— {{ $firstRev->user_name }}, Verified Practitioner</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <h4>No tools found matching criteria.</h4>
                <p>Try adjusting your search query or sorting options.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="d-flex justify-content-center my-4">
            {{ $tools->links() }}
        </div>
    </section>

    <!-- Comparison Matrix Table -->
    <section class="container comparison-table-section">
        <div class="section-heading">
            <h2><i class="fa-solid fa-table-cells"></i> {{ $category->name }} Feature Comparison Matrix</h2>
        </div>

        <div class="table-responsive-box">
            <table class="crm-compare-table">
                <thead>
                    <tr>
                        <th>Platform</th>
                        <th>TechScore</th>
                        <th>Starting Price</th>
                        <th>Free Trial</th>
                        <th>AI Copilot</th>
                        <th>Custom Workflows</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tools->take(5) as $cTool)
                        <tr>
                            <td><strong>{{ $cTool->name }}</strong></td>
                            <td><span class="pill-score">{{ $cTool->rank ?? 95 }}/100</span></td>
                            <td>{{ $cTool->pricing_text ?? '$25 / mo' }}</td>
                            <td>14–30 Days</td>
                            <td><i class="fa-solid fa-circle-check check-green"></i> Native AI</td>
                            <td><i class="fa-solid fa-circle-check check-green"></i> Advanced</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="container faq-section" style="margin-bottom: 80px;">
        <div class="section-heading">
            <h2><i class="fa-solid fa-circle-question"></i> Frequently Asked Questions about {{ $category->name }}</h2>
        </div>

        <div class="faq-list">
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-header">
                    <h5>How much does a {{ $category->name }} typically cost?</h5>
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Pricing ranges from free plans up to $165+ per user per month for enterprise solutions. Most small to mid-sized businesses spend around $25–$50 per user monthly.</p>
                </div>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-header">
                    <h5>How do I choose the best software for my business?</h5>
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Evaluate your team size, key integrations with existing software, ease of onboarding, and whether advanced AI analytics are required.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trial CTA Box -->
    <div class="container" style="margin-bottom: 80px;">
        <div class="trial-cta-box">
            <div>
                <h2>Need help picking the right {{ $category->name }}?</h2>
                <p>Use our free AI comparison generator to receive custom software recommendations tailored to your team size and budget.</p>
                <div class="cta-btns">
                    <a href="{{ route('frontend.blogs') }}" class="btn-trial-pink" style="text-decoration: none; display: inline-block;">Run AI Comparison</a>
                    <a href="{{ route('register-vendor') }}" class="btn-trial-outline" style="text-decoration: none; display: inline-block;">List Your Tool</a>
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

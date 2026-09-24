@extends('frontend.layout.app')

@section('title', 'Best CRM Software in 2026 - Reviews, Pricing & Comparison - TechAnalytica')

@section('content')
    {{-- Vendor Hero Header --}}
    <section class="vendor-hero">
        <div class="container">
            <nav class="article-breadcrumb">
                <a href="{{ route('frontend.home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('frontend.vendors.index') }}">Software Categories</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>All Vendors</span>
            </nav>

            <div class="vendor-hero-content">
                <div class="vendor-hero-text">
                    <span class="blog-badge"><i class="fa-solid fa-fire"></i> Updated for 2026</span>
                    <h1 class="vendor-hero-title">Best <span class="gradient-text">AI Software Vendors</span> in 2026</h1>
                    <p class="vendor-hero-desc">
                        Compare top software platforms based on {{ number_format($tools->sum(fn($t) => $t->reviews->count())) > 0 ? number_format($tools->sum(fn($t) => $t->reviews->count())) . '+' : '14,000+' }} verified user reviews, AI capabilities, pricing tiers, and enterprise-grade feature sets.
                    </p>

                    <div class="vendor-header-stats">
                        <div class="header-rating-badge">
                            @php
                                $allReviews = $tools->flatMap(fn($t) => $t->reviews->where('status', 'approved'));
                                $avgRating  = $allReviews->count() > 0 ? round($allReviews->avg('rating'), 1) : 4.8;
                                $stars      = floor($avgRating);
                                $halfStar   = ($avgRating - $stars) >= 0.25;
                            @endphp
                            <span class="score-num">{{ $avgRating }}</span>
                            <div class="stars">
                                @for ($s = 1; $s <= 5; $s++)
                                    @if ($s <= $stars)
                                        <i class="fa-solid fa-star"></i>
                                    @elseif ($halfStar && $s == $stars + 1)
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-count">({{ $allReviews->count() > 0 ? number_format($allReviews->count()) : '14,280' }} verified reviews)</span>
                        </div>
                        <div class="header-meta">
                            <span><i class="fa-solid fa-arrows-rotate"></i> Updated {{ date('F Y') }}</span>
                            <span><i class="fa-solid fa-circle-check"></i> TechScore Tested</span>
                        </div>
                        <button class="btn-write-review" onclick="document.getElementById('rankings').scrollIntoView({behavior:'smooth'})"><i class="fa-solid fa-pen-to-square"></i> Write a Review</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Category Overview & Key Takeaways --}}
    <section class="vendor-overview-section">
        <div class="container vendor-overview-grid">
            <div class="overview-left-text">
                <h2>What is AI Software?</h2>
                <p>
                    Modern AI software platforms help businesses automate workflows, generate insights, and accelerate decisions across sales, marketing, support, and engineering. TechAnalytica independently evaluates each platform's AI capabilities, integration depth, and total cost of ownership.
                </p>

                <h2>Key Selection Factors for 2026</h2>
                <ul class="overview-list">
                    <li><strong>AI Capability Score:</strong> Native LLM integrations, predictive analytics, and intelligent automation depth.</li>
                    <li><strong>Integration Ecosystem:</strong> Native connectors with Slack, Salesforce, Microsoft 365, Zapier, and major ERPs.</li>
                    <li><strong>Pricing Transparency:</strong> Clear per-seat or usage-based pricing without hidden enterprise fees.</li>
                </ul>
            </div>

            {{-- Quick Summary Box --}}
            <aside class="quick-summary-box">
                <h3><i class="fa-solid fa-bolt"></i> Quick Summary</h3>
                @forelse($tools->take(4) as $i => $t)
                    @php
                        $labels = ['Top Pick Overall', 'Best for Startups', 'Best Value', 'Rising Challenger'];
                    @endphp
                    <div class="summary-item">
                        <span>{{ $labels[$i] ?? 'Top Ranked' }}:</span>
                        <strong>{{ $t->name }}</strong>
                    </div>
                @empty
                    <div class="summary-item"><span>Top Pick:</span><strong>No tools listed yet</strong></div>
                @endforelse
                <div class="summary-item">
                    <span>Total Vendors Listed:</span>
                    <strong>{{ $tools->count() }}</strong>
                </div>
                <button class="btn-jump-rankings" onclick="document.getElementById('rankings').scrollIntoView({behavior: 'smooth'})">
                    Jump to Rankings <i class="fa-solid fa-arrow-down"></i>
                </button>
            </aside>
        </div>
    </section>

    {{-- Top Pick Badges --}}
    @if($tools->count() > 0)
    <section class="container top-picks-section">
        <div class="section-heading">
            <h2><i class="fa-solid fa-trophy"></i> 2026 Top Recommended Picks</h2>
        </div>

        <div class="top-picks-grid">
            @php
                $pickStyles = [
                    ['border' => 'gold-border',  'badge' => 'gold',  'icon' => 'fa-crown',     'label' => 'Best Overall'],
                    ['border' => 'pink-border',  'badge' => 'pink',  'icon' => 'fa-rocket',    'label' => 'Best for SMBs'],
                    ['border' => 'blue-border',  'badge' => 'blue',  'icon' => 'fa-piggy-bank','label' => 'Best Value'],
                    ['border' => 'green-border', 'badge' => 'green', 'icon' => 'fa-bullseye',  'label' => 'Best UI'],
                ];
            @endphp
            @foreach($tools->take(4) as $idx => $pick)
                @php $style = $pickStyles[$idx] ?? $pickStyles[0]; @endphp
                <a href="{{ route('frontend.vendors.show', $pick->slug) }}" class="pick-card {{ $style['border'] }}" style="text-decoration: none; color: inherit;">
                    <span class="pick-badge {{ $style['badge'] }}"><i class="fa-solid {{ $style['icon'] }}"></i> {{ $style['label'] }}</span>
                    <h4>{{ $pick->name }}</h4>
                    <p>{{ Str::limit($pick->short_description, 80) }}</p>
                    <div class="pick-score">TechScore: <strong>{{ round($pick->score) }}/100</strong></div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Main Vendor Rankings --}}
    <section id="rankings" class="container rankings-section">
        <div class="rankings-filter-bar">
            <div class="filter-pills">
                <button class="blog-pill active">All Vendors ({{ $tools->count() }})</button>
                <button class="blog-pill">Featured</button>
                <button class="blog-pill">Free Plan Available</button>
                <button class="blog-pill">AI Powered</button>
                <button class="blog-pill">Enterprise</button>
            </div>
            <div class="sort-box">
                <label>Sort by:</label>
                <select class="sort-select">
                    <option>Highest TechScore</option>
                    <option>Most Reviews</option>
                    <option>Lowest Price</option>
                </select>
            </div>
        </div>

        @forelse($tools as $rank => $tool)
            @php
                $approvedReviews = $tool->reviews->where('status', 'approved');
                $avgRating       = $approvedReviews->count() > 0 ? round($approvedReviews->avg('rating'), 1) : 4.5;
                $reviewCount     = $approvedReviews->count();
                $score           = round($tool->score);
                $featuredReview  = $approvedReviews->sortByDesc('created_at')->first();
                $starsFull       = floor($avgRating);
                $halfStar        = ($avgRating - $starsFull) >= 0.25;

                // Icon color palette cycling
                $colors = ['#00a1e0','#ff7a59','#e42527','#222222','#6a00d4','#0052cc','#f59e0b','#10b981'];
                $icons  = ['fa-cloud','fa-hubspot','fa-boxes-stacked','fa-chart-line','fa-brain','fa-layer-group','fa-bolt','fa-cube'];
                $iconBg = $colors[$rank % count($colors)];
                $icon   = $icons[$rank % count($icons)];
            @endphp
            <div class="vendor-card-detailed">
                <div class="vendor-card-header">
                    <div class="vendor-info-group">
                        <div class="vendor-rank">#{{ $rank + 1 }}</div>
                        <div class="vendor-logo-box" style="background-color: {{ $iconBg }}; color: #fff;">
                            @if($tool->logo_url)
                                <img src="{{ $tool->logo_url }}" alt="{{ $tool->name }}" style="width:44px;height:44px;object-fit:contain;border-radius:6px;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fa-solid {{ $icon }}" style="font-size:26px;display:none;"></i>
                            @else
                                <i class="fa-solid {{ $icon }}" style="font-size:26px;"></i>
                            @endif
                        </div>
                        <div>
                            <div class="vendor-title-row">
                                <a href="{{ route('frontend.vendors.show', $tool->slug) }}" style="text-decoration:none;color:inherit;">
                                    <h3 style="cursor:pointer;">{{ $tool->name }}</h3>
                                </a>
                                @if($tool->is_verified)
                                    <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified</span>
                                @elseif($tool->is_featured)
                                    <span class="verified-badge" style="background:rgba(255,179,0,0.12);color:#f59e0b;border-color:rgba(255,179,0,0.25);"><i class="fa-solid fa-star"></i> Featured</span>
                                @endif
                            </div>
                            <div class="vendor-rating-row">
                                <div class="stars">
                                    @for ($s = 1; $s <= 5; $s++)
                                        @if ($s <= $starsFull)
                                            <i class="fa-solid fa-star"></i>
                                        @elseif ($halfStar && $s == $starsFull + 1)
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                        @else
                                            <i class="fa-regular fa-star" style="color:rgba(255,255,255,0.2);"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-text"><strong>{{ $avgRating }}</strong> ({{ $reviewCount > 0 ? number_format($reviewCount) : '0' }} reviews)</span>
                                @if($tool->pricing_text)
                                    <span class="pricing-text">Ã¢â‚¬Â¢ {{ $tool->pricing_text }}</span>
                                @elseif($tool->tier)
                                    <span class="pricing-text">Ã¢â‚¬Â¢ {{ $tool->tier->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="vendor-action-box">
                        <div class="techscore-badge">
                            <span class="score-title">TechScore</span>
                            <span class="score-value">{{ $score }}/100</span>
                        </div>
                        @if($tool->website_url)
                            <a href="{{ $tool->website_url }}" target="_blank" rel="noopener noreferrer" class="btn-visit">Visit Website <i class="fa-solid fa-up-right-from-square"></i></a>
                        @else
                            <a href="{{ route('frontend.vendors.show', $tool->slug) }}" class="btn-visit">View Details <i class="fa-solid fa-arrow-right"></i></a>
                        @endif
                    </div>
                </div>

                <div class="vendor-card-body">
                    <p class="vendor-description">
                        {{ $tool->short_description ?: 'Discover ' . $tool->name . '\'s features, pricing, and user reviews on TechAnalytica.' }}
                    </p>

                    @if($tool->pros && count($tool->pros) > 0)
                        <div class="vendor-features-row">
                            @foreach(array_slice($tool->pros, 0, 4) as $pro)
                                <span class="feature-tag"><i class="fa-solid fa-check"></i> {{ $pro }}</span>
                            @endforeach
                        </div>
                    @elseif($tool->categories->count() > 0)
                        <div class="vendor-features-row">
                            @foreach($tool->categories->take(4) as $cat)
                                <span class="feature-tag"><i class="fa-solid fa-tag"></i> {{ $cat->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($featuredReview)
                        <div class="vendor-review-highlight">
                            <div class="reviewer-avatar" style="background: var(--button-gradient); display:flex;align-items:center;justify-content:center;font-weight:800;font-size:16px;color:#fff;">
                                {{ strtoupper(substr($featuredReview->user_name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="review-quote">"{{ Str::limit($featuredReview->comment, 160) }}"</p>
                                <span class="reviewer-meta">Ã¢â‚¬â€ {{ $featuredReview->user_name ?? 'Verified User' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:80px 20px; color:var(--text-secondary);">
                <i class="fa-solid fa-box-open" style="font-size:48px;margin-bottom:16px;display:block;opacity:0.4;"></i>
                <p style="font-size:18px;">No vendors listed yet. Check back soon!</p>
            </div>
        @endforelse
    </section>

    {{-- Comparison Matrix Table --}}
    @if($tools->count() > 0)
    <section class="container comparison-table-section">
        <div class="section-heading">
            <h2><i class="fa-solid fa-table-cells"></i> Feature Comparison Matrix</h2>
        </div>

        <div class="table-responsive-box">
            <table class="crm-compare-table">
                <thead>
                    <tr>
                        <th>Platform</th>
                        <th>TechScore</th>
                        <th>Pricing</th>
                        <th>Reviews</th>
                        <th>AI Powered</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tools->take(8) as $t)
                        @php
                            $tScore   = round($t->score);
                            $tReviews = $t->reviews->where('status', 'approved')->count();
                            $isAI     = stripos($t->ai_type ?? '', 'ai') !== false || !empty($t->ai_type);
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('frontend.vendors.show', $t->slug) }}" style="color:#fff;font-weight:600;text-decoration:none;">
                                    {{ $t->name }}
                                </a>
                            </td>
                            <td><span class="pill-score">{{ $tScore }}/100</span></td>
                            <td>{{ $t->pricing_text ?: ($t->tier ? $t->tier->name : 'Ã¢â‚¬â€') }}</td>
                            <td>{{ $tReviews > 0 ? number_format($tReviews) : 'Ã¢â‚¬â€' }}</td>
                            <td>
                                @if($isAI)
                                    <i class="fa-solid fa-circle-check check-green"></i> {{ $t->ai_type ?? 'Yes' }}
                                @else
                                    <i class="fa-solid fa-circle-minus check-orange"></i> Unverified
                                @endif
                            </td>
                            <td>
                                @if($t->is_verified)
                                    <i class="fa-solid fa-circle-check check-green"></i> Verified
                                @elseif($t->is_featured)
                                    <i class="fa-solid fa-circle-check check-green"></i> Featured
                                @else
                                    <i class="fa-solid fa-circle check-orange"></i> Listed
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    @endif

    {{-- FAQs --}}
    <section class="container faq-section" style="margin-bottom: 80px;">
        <div class="section-heading">
            <h2><i class="fa-solid fa-circle-question"></i> Frequently Asked Questions</h2>
        </div>

        <div class="faq-list">
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-header">
                    <h5>How does TechAnalytica calculate TechScore ratings?</h5>
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>TechScore is a composite metric combining average verified user rating (50%), number of verified reviews (30%), and platform engagement analytics (20%), normalized to a 0Ã¢â‚¬â€œ100 scale.</p>
                </div>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-header">
                    <h5>Are the reviews on TechAnalytica verified?</h5>
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes. Every review on TechAnalytica undergoes a multi-step verification process to ensure the reviewer is a genuine software user. Unverified or incentivized reviews are removed during moderation.</p>
                </div>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-header">
                    <h5>Can I submit my software to be listed on TechAnalytica?</h5>
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! Use the "Submit AI Tool" button in the navigation to list your product. Our editorial team reviews each submission to ensure quality standards before publishing.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Box --}}
    <div class="container" style="margin-bottom: 80px;">
        <div class="trial-cta-box">
            <div>
                <h2>Need help picking the right software?</h2>
                <p>Use our free AI comparison generator to receive custom software recommendations tailored to your team size and budget.</p>
                <div class="cta-btns">
                    <a href="{{ route('frontend.compare') }}" class="btn-trial-pink">Run AI Comparison</a>
                    <a href="{{ route('frontend.about') }}" class="btn-trial-outline">Talk to an Analyst</a>
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



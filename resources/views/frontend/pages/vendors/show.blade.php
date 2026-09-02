@extends('frontend.layout.app')

@section('title', $tool->name . ' - Reviews, Pricing & AI Specifications | TechAnalytica')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor-details.css') }}">
@endpush

@section('content')

{{-- ========== HERO SECTION ========== --}}
<section class="vendor-hero">
    <div class="container hero-container">

        {{-- Left: Logo + Meta --}}
        <div class="vendor-header-left">
            <div class="vendor-logo-box">
                @if ($tool->logo_url)
                    <img src="{{ asset($tool->logo_url) }}" alt="{{ $tool->name }} Logo">
                @else
                    <i class="fa-solid fa-brain" style="font-size: 36px; color: #e04385;"></i>
                @endif
            </div>

            <div class="vendor-meta">
                <div class="title-row">
                    <h1>{{ $tool->name }}</h1>
                    @if ($tool->is_verified || $tool->is_claimed)
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(16,185,129,0.12);color:#10b981;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;border:1px solid rgba(16,185,129,0.3);">
                            <i class="fa-solid fa-circle-check"></i> Verified Leader
                        </span>
                    @endif
                </div>

                <p class="tagline">{{ $tool->short_description }}</p>

                @php
                    $approvedReviews = $tool->reviews->where('status', 'approved');
                    $avgRating = $approvedReviews->avg('rating') ?: 0;
                @endphp

                <div class="stats-row">
                    <div class="stat-item">
                        <span class="stars">
                            <i class="fa-solid fa-star"></i>
                            <strong>{{ $avgRating > 0 ? number_format($avgRating, 1) : 'New' }}</strong>
                        </span>
                        <span class="stat-label">({{ $approvedReviews->count() }} Reviews)</span>
                    </div>
                    <div class="divider"></div>
                    <div class="stat-item">
                        <i class="fa-solid fa-microchip" style="color:#e04385;font-size:13px;"></i>
                        <strong style="color:#fff;">{{ $tool->ai_type ?? 'AI Tool' }}</strong>
                    </div>
                    <div class="divider"></div>
                    <div class="stat-item">
                        <i class="fa-solid fa-trophy" style="color:#ffc107;font-size:12px;"></i>
                        <span class="stat-label">TechScore:</span>
                        <strong style="color:#e04385;font-size:15px;">{{ $tool->score }}<span style="color:#9a8c9e;font-size:11px;font-weight:500;">/100</span></strong>
                    </div>
                    @if($tool->categories->count())
                    <div class="divider"></div>
                    <div class="stat-item">
                        <i class="fa-solid fa-tag" style="color:#9a8c9e;font-size:12px;"></i>
                        <span class="stat-label">{{ $tool->categories->first()->name }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: CTA Actions --}}
        <div class="vendor-header-actions">
            <button onclick="openLeadModal('demo')" class="btn-trial-pink">
                <i class="fa-solid fa-paper-plane"></i> Request Demo / Quote
            </button>
            <a href="{{ route('frontend.compare', ['tool1' => $tool->slug]) }}" class="btn-trial-outline">
                <i class="fa-solid fa-code-compare"></i> Compare This Tool
            </a>
            @if ($tool->website_url)
                <a href="{{ $tool->website_url }}" target="_blank" rel="noopener noreferrer" class="btn-trial-outline" style="font-size:13px;padding:10px 20px;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Visit Official Site
                </a>
            @endif
            @if (!$tool->is_claimed)
                <div class="claim-prompt">
                    <i class="fa-regular fa-building"></i>
                    <span>Are you an employee?</span>
                    <a href="javascript:void(0)" onclick="openClaimModal({{ $tool->id }}, '{{ addslashes($tool->name) }}')">Claim this Product</a>
                </div>
            @endif
        </div>

    </div>
</section>

{{-- ========== SESSION ALERTS ========== --}}
@if(session('success'))
    <div class="container" style="padding-top:24px;">
        <div class="alert-success-custom">
            <i class="fa-solid fa-circle-check" style="font-size:18px;"></i>
            {{ session('success') }}
        </div>
    </div>
@endif
@if(session('error'))
    <div class="container" style="padding-top:24px;">
        <div style="display:flex;align-items:center;gap:12px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;padding:16px 20px;border-radius:14px;font-size:14px;font-weight:600;">
            <i class="fa-solid fa-circle-exclamation" style="font-size:18px;"></i> {{ session('error') }}
        </div>
    </div>
@endif

{{-- ========== STICKY TABS ========== --}}
<div class="vendor-tabs-wrapper">
    <div class="container tabs-container">
        <ul class="nav-tabs-list">
            <li class="active"><a href="#overview"><i class="fa-solid fa-circle-info"></i> Overview</a></li>
            <li><a href="#proscons"><i class="fa-solid fa-scale-balanced"></i> Pros & Cons</a></li>
            <li><a href="#reviews"><i class="fa-solid fa-star"></i> Reviews ({{ $approvedReviews->count() }})</a></li>
            <li><a href="#alternatives"><i class="fa-solid fa-code-compare"></i> Competitors</a></li>
        </ul>
    </div>
</div>

{{-- ========== MAIN BODY ========== --}}
<section class="vendor-main-body">
    <div class="container layout-grid">

        {{-- ===== LEFT COLUMN ===== --}}
        <div class="content-left">

            {{-- Overview Card --}}
            <div id="overview" class="detail-card">
                <h3><i class="fa-solid fa-circle-info" style="color:#e04385;font-size:16px;"></i> Product Overview & Capabilities</h3>
                <p class="body-p">{{ $tool->long_description ?: $tool->short_description }}</p>

                <div class="feature-highlights-grid">
                    <div class="f-item">
                        <div class="f-item-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div>
                            <h5>Enterprise Compliance</h5>
                            <p>SOC2, GDPR, and enterprise access hierarchies ready.</p>
                        </div>
                    </div>
                    <div class="f-item">
                        <div class="f-item-icon"><i class="fa-solid fa-bolt"></i></div>
                        <div>
                            <h5>Automated Pipelines</h5>
                            <p>Native webhooks, REST API endpoints, and low latency compute.</p>
                        </div>
                    </div>
                    <div class="f-item">
                        <div class="f-item-icon"><i class="fa-solid fa-chart-line"></i></div>
                        <div>
                            <h5>Real-Time Telemetry</h5>
                            <p>Algorithmic tracking, automated analytics, and usage insights.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Screenshots --}}
            @if($tool->media && $tool->media->count() > 0)
                <div class="detail-card">
                    <h3><i class="fa-solid fa-images" style="color:#e04385;font-size:16px;"></i> Interface & Product Screenshots</h3>
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;margin-top:4px;">
                        @foreach($tool->media as $mediaItem)
                            <div style="border-radius:14px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);">
                                <img src="{{ $mediaItem->url }}" alt="{{ $tool->name }} Screenshot" style="width:100%;height:190px;object-fit:cover;display:block;">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Pros & Cons --}}
            <div id="proscons" class="detail-card">
                <h3><i class="fa-solid fa-scale-balanced" style="color:#e04385;font-size:16px;"></i> Pros & Cons Breakdown</h3>
                <div class="pros-cons-grid">
                    <div class="pros-column">
                        <h4><i class="fa-solid fa-thumbs-up check-green"></i> Key Advantages</h4>
                        <ul class="pc-list">
                            @if(!empty($tool->pros) && is_array($tool->pros))
                                @foreach($tool->pros as $pro)
                                    <li><i class="fa-solid fa-check check-green"></i> {{ $pro }}</li>
                                @endforeach
                            @else
                                <li><i class="fa-solid fa-check check-green"></i> High-performance generative AI processing.</li>
                                <li><i class="fa-solid fa-check check-green"></i> Enterprise-grade security and role hierarchies.</li>
                                <li><i class="fa-solid fa-check check-green"></i> Intuitive UI and comprehensive developer API.</li>
                            @endif
                        </ul>
                    </div>
                    <div class="cons-column">
                        <h4><i class="fa-solid fa-thumbs-down check-orange"></i> Potential Drawbacks</h4>
                        <ul class="pc-list">
                            @if(!empty($tool->cons) && is_array($tool->cons))
                                @foreach($tool->cons as $con)
                                    <li><i class="fa-solid fa-xmark check-orange"></i> {{ $con }}</li>
                                @endforeach
                            @else
                                <li><i class="fa-solid fa-xmark check-orange"></i> Requires team onboarding for advanced features.</li>
                                <li><i class="fa-solid fa-xmark check-orange"></i> Custom enterprise plans require direct vendor contact.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Reviews --}}
            <div id="reviews" class="detail-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
                    <h3 style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                        <i class="fa-solid fa-star" style="color:#ffc107;font-size:16px;"></i>
                        Verified User Reviews
                        <span style="font-size:14px;color:#9a8c9e;font-weight:500;">({{ $approvedReviews->count() }})</span>
                    </h3>
                    <button onclick="openReviewModal()" class="btn-cta-pink">
                        <i class="fa-solid fa-pen-to-square"></i> Write Review
                    </button>
                </div>

                @if($approvedReviews->count() > 0)
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        @foreach($approvedReviews as $review)
                            <div class="review-item-card">
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:12px;">
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <div class="reviewer-avatar">
                                            {{ strtoupper(substr($review->user_name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 style="font-size:15px;font-weight:700;color:#fff;margin-bottom:3px;">{{ $review->user_name }}</h4>
                                            <span style="font-size:11px;color:#9a8c9e;display:flex;align-items:center;gap:5px;">
                                                @if($review->is_verified)
                                                    <i class="fa-solid fa-circle-check" style="color:#10b981;"></i> Verified Reviewer &bull;
                                                @endif
                                                {{ $review->created_at ? $review->created_at->diffForHumans() : 'Recently' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                        @endfor
                                        <span style="color:#fff;font-weight:700;margin-left:5px;font-size:12px;">{{ $review->rating }}.0</span>
                                    </div>
                                </div>

                                <p style="font-size:14px;color:#c4b8c9;line-height:1.7;margin:0;">"{{ $review->comment }}"</p>

                                @if($review->vendor_reply)
                                    <div style="background:rgba(224,67,133,0.06);border-left:3px solid #e04385;padding:14px 18px;border-radius:0 12px 12px 0;margin-top:14px;">
                                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                                            <span style="background:#e04385;color:#fff;font-size:11px;font-weight:700;padding:3px 10px;border-radius:6px;">Official Vendor Response</span>
                                            @if($review->vendor_replied_at)
                                                <span style="font-size:11px;color:#9a8c9e;">{{ $review->vendor_replied_at->diffForHumans() }}</span>
                                            @endif
                                        </div>
                                        <p style="font-size:13px;color:#f1e4f3;margin:0;font-style:italic;line-height:1.6;">"{{ $review->vendor_reply }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-regular fa-comment-dots" style="font-size:36px;color:#4a3a52;margin-bottom:14px;display:block;"></i>
                        <p>No community reviews yet. Be the first to review {{ $tool->name }}!</p>
                        <button onclick="openReviewModal()" class="btn-cta-pink">
                            <i class="fa-solid fa-pen-to-square"></i> Submit First Review
                        </button>
                    </div>
                @endif
            </div>

            {{-- Competitors --}}
            @if(isset($relatedTools) && $relatedTools->count() > 0)
                <div id="alternatives" class="detail-card">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;flex-wrap:wrap;gap:12px;">
                        <h3 style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                            <i class="fa-solid fa-code-compare" style="color:#e04385;font-size:16px;"></i>
                            Alternative & Competitor AI Tools
                        </h3>
                        <a href="{{ route('frontend.compare', ['tool1' => $tool->slug]) }}" style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(224,67,133,0.12);color:#e04385;font-size:13px;font-weight:700;border-radius:10px;border:1px solid rgba(224,67,133,0.25);text-decoration:none;transition:all 0.2s ease;" onmouseover="this.style.background='#e04385';this.style.color='#fff';" onmouseout="this.style.background='rgba(224,67,133,0.12)';this.style.color='#e04385';">
                            <i class="fa-solid fa-code-compare"></i> Open Full Comparison
                        </a>
                    </div>
                    <p style="font-size:13px;color:#9a8c9e;margin-bottom:20px;margin-top:8px;">Compare {{ $tool->name }} side-by-side against similar AI tools.</p>

                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
                        @foreach($relatedTools as $rel)
                            <div class="competitor-card">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                                    <div style="width:38px;height:38px;border-radius:10px;background:rgba(224,67,133,0.1);border:1px solid rgba(224,67,133,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        @if($rel->logo_url)
                                            <img src="{{ asset($rel->logo_url) }}" alt="{{ $rel->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                                        @else
                                            <i class="fa-solid fa-brain" style="color:#e04385;font-size:14px;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 style="font-size:14px;color:#fff;font-weight:700;margin-bottom:2px;">{{ $rel->name }}</h4>
                                        <span style="font-size:11px;color:#9a8c9e;">{{ $rel->ai_type ?? 'AI Tool' }}</span>
                                    </div>
                                </div>

                                <p style="font-size:12.5px;color:#9a8c9e;margin-bottom:14px;line-height:1.5;">{{ Str::limit($rel->short_description, 75) }}</p>

                                <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
                                    <span style="font-size:12.5px;color:#ffc107;font-weight:700;display:flex;align-items:center;gap:4px;">
                                        <i class="fa-solid fa-star"></i>
                                        {{ number_format($rel->reviews->avg('rating') ?: 4.5, 1) }}
                                    </span>
                                    <a href="{{ route('frontend.compare', ['tool1' => $tool->slug, 'tool2' => $rel->slug]) }}" class="btn-visit">
                                        <i class="fa-solid fa-code-compare" style="font-size:11px;"></i> Compare
                                    </a>
                                </div>

                                {{-- View detail link --}}
                                <a href="{{ route('frontend.tools.show', $rel->slug) }}" style="display:block;margin-top:10px;font-size:12px;color:#9a8c9e;text-align:center;border-top:1px solid rgba(255,255,255,0.06);padding-top:10px;transition:color 0.2s;" onmouseover="this.style.color='#e04385'" onmouseout="this.style.color='#9a8c9e'">
                                    View {{ $rel->name }} details <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Always show the compare CTA even with no related tools --}}
                <div id="alternatives" class="detail-card">
                    <h3><i class="fa-solid fa-code-compare" style="color:#e04385;font-size:16px;"></i> Compare AI Tools</h3>
                    <div class="empty-state">
                        <i class="fa-solid fa-code-compare" style="font-size:36px;color:#4a3a52;margin-bottom:14px;display:block;"></i>
                        <p>No similar tools found in this category yet. Use the comparison engine to benchmark {{ $tool->name }} against any other tool.</p>
                        <a href="{{ route('frontend.compare', ['tool1' => $tool->slug]) }}" style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;background:linear-gradient(90deg,#e04385,#fa709a);color:#fff;font-weight:700;font-size:14px;border-radius:10px;text-decoration:none;box-shadow:0 4px 16px rgba(224,67,133,0.3);transition:all 0.25s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fa-solid fa-code-compare"></i> Open Comparison Engine
                        </a>
                    </div>
                </div>
            @endif

        </div>{{-- /content-left --}}

        {{-- ===== RIGHT SIDEBAR ===== --}}
        <aside class="sidebar-right">

            {{-- Product Intelligence Card --}}
            <div class="sidebar-meta-card">
                <h4><i class="fa-solid fa-chart-bar" style="color:#e04385;margin-right:8px;"></i> Product Intelligence</h4>
                <div class="meta-list">
                    <div class="meta-row">
                        <span class="label">Vendor</span>
                        <span class="val">{{ $tool->vendor->company_name ?? ($tool->name . ' Inc.') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="label">Pricing</span>
                        <span class="val">{{ $tool->pricing_text ?? ($tool->tier->name ?? 'Freemium') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="label">AI Type</span>
                        <span class="val">{{ $tool->ai_type ?? 'Generative AI' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="label">Categories</span>
                        <span class="val">{{ $tool->categories->pluck('name')->join(', ') ?: 'AI Tool' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="label">Status</span>
                        <span class="val" style="color:#10b981;display:flex;align-items:center;gap:5px;justify-content:flex-end;">
                            <i class="fa-solid fa-circle" style="font-size:7px;"></i> Active & Listed
                        </span>
                    </div>
                </div>

                {{-- TechScore Badge --}}
                <div class="techscore-badge">
                    <div class="techscore-number">{{ $tool->score }}</div>
                    <div class="techscore-label">TechAnalytica Score / 100</div>
                    <div class="techscore-bar-wrap">
                        <div class="techscore-bar-fill" style="width:{{ $tool->score }}%;"></div>
                    </div>
                </div>
            </div>

            {{-- Share / Favorite --}}
            <div class="sidebar-actions-row">
                <button class="btn-action-icon" onclick="navigator.clipboard.writeText(window.location.href).then(()=>alert('Link copied!'))">
                    <i class="fa-solid fa-share-nodes"></i> Share
                </button>
                <form action="{{ route('frontend.tools.lead', $tool->slug) }}" method="POST" style="flex:1;display:flex;">
                    @csrf
                    <button type="button" class="btn-action-icon" style="width:100%;" onclick="openLeadModal('contact')">
                        <i class="fa-regular fa-heart"></i> Inquire
                    </button>
                </form>
            </div>

            {{-- Enterprise CTA --}}
            <div class="sidebar-cta-card">
                <i class="fa-solid fa-envelope-open-text cta-icon" style="color:#e04385;"></i>
                <h4>Need Custom Enterprise Pricing?</h4>
                <p>Connect directly with the product team for volume licensing and architectural inquiries.</p>
                <button onclick="openLeadModal('pricing')" class="btn-sidebar-trial">
                    Request Custom Quote
                </button>
            </div>

        </aside>

    </div>
</section>

{{-- ========== LEAD CAPTURE MODAL ========== --}}
<div id="leadModal" class="modal-lead">
    <div class="modal-lead-content">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div>
                <h3 style="font-size:20px;font-weight:800;color:#fff;margin:0 0 4px;">Connect with {{ $tool->name }}</h3>
                <p style="font-size:13px;color:#9a8c9e;margin:0;">Request a personalized demo or custom pricing proposal.</p>
            </div>
            <button type="button" onclick="closeLeadModal()" class="modal-close-btn">&times;</button>
        </div>

        <form action="{{ route('frontend.tools.lead', $tool->slug) }}" method="POST">
            @csrf
            <input type="hidden" name="intent_type" id="lead_intent_type" value="demo">

            <div class="modal-field">
                <label class="modal-label">Your Name *</label>
                <input type="text" name="name" required class="form-control" placeholder="Jane Doe">
            </div>

            <div class="modal-field">
                <label class="modal-label">Work Email *</label>
                <input type="email" name="email" required class="form-control" placeholder="jane@company.com">
            </div>

            <div class="modal-row-2">
                <div>
                    <label class="modal-label">Company Name</label>
                    <input type="text" name="company_name" class="form-control" placeholder="Acme Inc.">
                </div>
                <div>
                    <label class="modal-label">Team Size</label>
                    <select name="company_size" class="form-control">
                        <option value="1-10">1–10 members</option>
                        <option value="11-50">11–50 members</option>
                        <option value="51-200">51–200 members</option>
                        <option value="201-1000">201–1000 members</option>
                        <option value="1000+">1000+ Enterprise</option>
                    </select>
                </div>
            </div>

            <div class="modal-field">
                <label class="modal-label">Message / Questions</label>
                <textarea name="message" rows="3" class="form-control" placeholder="Tell the vendor team about your use case..."></textarea>
            </div>

            <button type="submit" class="btn-trial-pink" style="width:100%;justify-content:center;">
                <i class="fa-solid fa-paper-plane"></i> Send Request to Vendor
            </button>
        </form>
    </div>
</div>

{{-- ========== REVIEW SUBMISSION MODAL ========== --}}
<div id="reviewModal" class="modal-lead">
    <div class="modal-lead-content">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div>
                <h3 style="font-size:20px;font-weight:800;color:#fff;margin:0 0 4px;">Review {{ $tool->name }}</h3>
                <p style="font-size:13px;color:#9a8c9e;margin:0;">Share your honest experience with the community.</p>
            </div>
            <button type="button" onclick="closeReviewModal()" class="modal-close-btn">&times;</button>
        </div>

        <form action="{{ route('frontend.tools.review', $tool->slug) }}" method="POST">
            @csrf
            <div class="modal-row-2">
                <div>
                    <label class="modal-label">Your Name *</label>
                    <input type="text" name="reviewer_name" value="{{ auth()->user()->name ?? '' }}" required class="form-control" placeholder="John Doe">
                </div>
                <div>
                    <label class="modal-label">Email *</label>
                    <input type="email" name="reviewer_email" value="{{ auth()->user()->email ?? '' }}" required class="form-control" placeholder="john@example.com">
                </div>
            </div>

            <div class="modal-field">
                <label class="modal-label">Rating *</label>
                <select name="rating" required class="form-control">
                    <option value="5">★★★★★  5 — Excellent</option>
                    <option value="4">★★★★☆  4 — Very Good</option>
                    <option value="3">★★★☆☆  3 — Average</option>
                    <option value="2">★★☆☆☆  2 — Needs Improvement</option>
                    <option value="1">★☆☆☆☆  1 — Poor</option>
                </select>
            </div>

            <div class="modal-field">
                <label class="modal-label">Your Review *</label>
                <textarea name="comment" rows="4" required minlength="10" class="form-control" placeholder="Describe your experience, what you loved, what could be better..."></textarea>
            </div>

            <button type="submit" class="btn-trial-pink" style="width:100%;justify-content:center;">
                <i class="fa-solid fa-check-circle"></i> Submit Verified Review
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    /* --- Modal Controls --- */
    function openLeadModal(intent) {
        document.getElementById('lead_intent_type').value = intent;
        document.getElementById('leadModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLeadModal() {
        document.getElementById('leadModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    function openReviewModal() {
        document.getElementById('reviewModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    window.addEventListener('click', function(e) {
        if (e.target.id === 'leadModal')   closeLeadModal();
        if (e.target.id === 'reviewModal') closeReviewModal();
    });

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeLeadModal(); closeReviewModal(); }
    });

    /* --- Active Tab Highlight on Scroll --- */
    (function() {
        const sections = ['overview','proscons','reviews','alternatives'].map(id => document.getElementById(id)).filter(Boolean);
        const links = document.querySelectorAll('.nav-tabs-list li');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    links.forEach(li => li.classList.remove('active'));
                    const active = document.querySelector(`.nav-tabs-list a[href="#${entry.target.id}"]`);
                    if (active) active.parentElement.classList.add('active');
                }
            });
        }, { rootMargin: '-30% 0px -60% 0px' });

        sections.forEach(s => observer.observe(s));

        /* Smooth scroll on tab click */
        document.querySelectorAll('.nav-tabs-list a').forEach(a => {
            a.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    })();

    /* --- Animate TechScore bar on load --- */
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.querySelector('.techscore-bar-fill');
        if (bar) {
            const w = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => bar.style.width = w, 300);
        }
    });
</script>
@endpush

@extends('frontend.layout.app')

@section('title', 'TechAnalytica Blog — AI Insights, Guides & Engineering Deep-Dives')

@push('styles')
<style>
/* =============================================
   BLOG INDEX — Premium Redesign
   ============================================= */

/* --- Hero --- */
.bi-hero {
    position: relative;
    padding: 60px 0 50px;
    background: linear-gradient(150deg, #0c0412 0%, #110718 50%, #0a050d 100%);
    border-bottom: 1px solid rgba(224,67,133,0.1);
    overflow: hidden;
}
.bi-hero::before {
    content:'';position:absolute;inset:0;
    background:
        radial-gradient(ellipse 60% 70% at 5% 50%, rgba(224,67,133,0.11) 0%, transparent 65%),
        radial-gradient(ellipse 45% 55% at 95% 10%, rgba(110,39,141,0.09) 0%, transparent 65%);
    pointer-events:none;
}
.bi-hero-inner {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:40px;
    flex-wrap:wrap;
}
.bi-hero-left { flex:1; min-width:280px; }
.bi-eyebrow {
    display:inline-flex;align-items:center;gap:7px;
    background:rgba(224,67,133,0.1);border:1px solid rgba(224,67,133,0.2);
    color:#e04385;font-size:12px;font-weight:700;
    padding:5px 14px;border-radius:20px;margin-bottom:16px;
    letter-spacing:0.4px;
}
.bi-title {
    font-size:clamp(28px,4vw,46px);font-weight:800;
    color:#fff;letter-spacing:-0.5px;line-height:1.13;margin-bottom:14px;
}
.bi-title span {
    background:linear-gradient(135deg,#e04385 0%,#fa709a 55%,#c86dd4 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.bi-desc { font-size:15px;color:#b8a8bf;line-height:1.7;margin-bottom:26px;max-width:500px; }

/* Search */
.bi-search {
    display:flex;max-width:460px;
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:14px;overflow:hidden;
    transition:border-color 0.2s;
}
.bi-search:focus-within { border-color:rgba(224,67,133,0.4); }
.bi-search input {
    flex:1;padding:13px 18px;background:transparent;border:none;
    color:#fff;font-size:14px;font-family:inherit;outline:none;
}
.bi-search input::placeholder { color:#6b5c73; }
.bi-search button {
    padding:12px 20px;background:linear-gradient(90deg,#e04385,#fa709a);
    border:none;color:#fff;font-weight:700;font-size:13px;
    cursor:pointer;white-space:nowrap;
    display:flex;align-items:center;gap:7px;transition:filter 0.2s;
}
.bi-search button:hover { filter:brightness(1.1); }

/* Hero Stats */
.bi-stats {
    display:flex;align-items:center;gap:24px;margin-top:22px;
    padding-top:20px;border-top:1px solid rgba(255,255,255,0.06);
    flex-wrap:wrap;
}
.bi-stat { text-align:center; }
.bi-stat .num { font-size:22px;font-weight:800;color:#fff;display:block; }
.bi-stat .lbl { font-size:11px;color:#9a8c9e;text-transform:uppercase;letter-spacing:0.8px; }

/* Hero Right — Latest post card */
.bi-hero-card {
    width:320px;flex-shrink:0;
    background:rgba(21,13,26,0.9);
    border:1.5px solid rgba(224,67,133,0.2);
    border-radius:20px;overflow:hidden;
    text-decoration:none;display:block;
    transition:all 0.3s ease;
}
.bi-hero-card:hover { border-color:rgba(224,67,133,0.45);transform:translateY(-4px);box-shadow:0 20px 50px rgba(0,0,0,0.6); }
.bi-hero-card-thumb {
    height:160px;background-size:cover;background-position:center;
    background-color:#1a0d22;position:relative;
    display:flex;align-items:center;justify-content:center;
}
.bi-hero-card-thumb .overlay {
    position:absolute;inset:0;
    background:linear-gradient(to bottom, transparent 40%, rgba(10,5,13,0.8) 100%);
}
.bi-hero-card-body { padding:20px; }
.bi-hero-card-badge {
    display:inline-flex;padding:4px 12px;
    background:linear-gradient(90deg,#e04385,#fa709a);
    color:#fff;font-size:11px;font-weight:700;border-radius:20px;margin-bottom:10px;
}
.bi-hero-card-body h3 { font-size:16px;font-weight:800;color:#fff;line-height:1.35;margin-bottom:8px; }
.bi-hero-card-body p  { font-size:12.5px;color:#9a8c9e;line-height:1.55;margin-bottom:14px; }
.bi-hero-card-meta { display:flex;align-items:center;gap:8px;font-size:12px;color:#6b5c73; }
.bi-card-avatar {
    width:26px;height:26px;border-radius:50%;
    background:linear-gradient(135deg,#e04385,#a4358a);
    display:flex;align-items:center;justify-content:center;
    font-size:11px;font-weight:700;color:#fff;flex-shrink:0;
}

/* --- Filter Tabs --- */
.bi-filter {
    position:sticky;top:0;z-index:100;
    background:rgba(8,4,12,0.94);
    backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);
    border-bottom:1px solid rgba(255,255,255,0.06);
}
.bi-filter-inner { display:flex;align-items:center;overflow-x:auto;scrollbar-width:none; }
.bi-filter-inner::-webkit-scrollbar { display:none; }
.bi-tab {
    display:inline-flex;align-items:center;gap:6px;
    padding:15px 20px;
    font-size:13.5px;font-weight:600;color:#9a8c9e;
    background:none;border:none;border-bottom:2px solid transparent;
    cursor:pointer;white-space:nowrap;
    text-decoration:none;font-family:inherit;
    transition:all 0.2s ease;
}
.bi-tab:hover,.bi-tab.active { color:#fff;border-bottom-color:#e04385; }
.bi-tab-count {
    font-size:10.5px;opacity:0.55;
    background:rgba(255,255,255,0.07);
    padding:2px 7px;border-radius:8px;
}

/* --- Main Body --- */
.bi-body {
    display:grid;
    grid-template-columns:240px 1fr;
    gap:32px;
    padding-top:32px;
    padding-bottom:80px;
    align-items:start;
}

/* Sidebar */
.bi-sidebar { position:sticky;top:58px; }
.bi-sidebar-box {
    background:rgba(18,10,22,0.9);
    border:1px solid rgba(255,255,255,0.07);
    border-radius:18px;padding:20px;margin-bottom:18px;
}
.bi-sidebar-box h5 {
    font-size:11px;font-weight:700;color:#9a8c9e;
    text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;
}
.bi-cat-list { list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:2px; }
.bi-cat-item a {
    display:flex;align-items:center;gap:10px;
    padding:9px 12px;border-radius:10px;
    font-size:13.5px;font-weight:600;color:#b8a8bf;
    text-decoration:none;transition:all 0.2s;
}
.bi-cat-item a:hover,.bi-cat-item a.active {
    background:rgba(224,67,133,0.1);color:#fff;
}
.bi-cat-item a i { color:#e04385;font-size:12px;width:14px; }
.bi-cat-badge {
    margin-left:auto;font-size:11px;color:#6b5c73;
    background:rgba(255,255,255,0.05);
    padding:2px 8px;border-radius:8px;
}

/* Newsletter */
.bi-newsletter {
    background:linear-gradient(135deg,rgba(224,67,133,0.1),rgba(110,39,141,0.14));
    border:1.5px solid rgba(224,67,133,0.2);
    border-radius:18px;padding:22px;text-align:center;
}
.bi-newsletter i { font-size:24px;color:#e04385;margin-bottom:10px;display:block; }
.bi-newsletter h4 { font-size:14px;font-weight:700;color:#fff;margin-bottom:8px; }
.bi-newsletter p  { font-size:12px;color:#9a8c9e;line-height:1.55;margin-bottom:14px; }
.bi-nl-input {
    width:100%;padding:10px 13px;
    background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);
    border-radius:10px;color:#fff;font-size:13px;font-family:inherit;
    outline:none;margin-bottom:9px;transition:border-color 0.2s;
}
.bi-nl-input:focus { border-color:rgba(224,67,133,0.4); }
.bi-nl-input::placeholder { color:#6b5c73; }
.bi-nl-btn {
    width:100%;padding:10px;
    background:linear-gradient(90deg,#e04385,#fa709a);
    color:#fff;font-weight:700;font-size:13px;border:none;border-radius:10px;
    cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;
    transition:all 0.25s ease;
}
.bi-nl-btn:hover { filter:brightness(1.1);transform:translateY(-1px); }

/* Feed */
.bi-feed { min-width:0; }

/* Cards Grid */
.bi-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(270px,1fr));
    gap:22px;
    margin-bottom:36px;
}

.bi-card {
    background:rgba(18,10,22,0.9);
    border:1px solid rgba(255,255,255,0.07);
    border-radius:18px;overflow:hidden;
    text-decoration:none;display:block;
    transition:all 0.3s ease;
    position:relative;
}
.bi-card:hover {
    border-color:rgba(224,67,133,0.3);
    transform:translateY(-5px);
    box-shadow:0 20px 48px rgba(0,0,0,0.55),0 0 0 1px rgba(224,67,133,0.1);
}

.bi-card-thumb {
    height:178px;background-size:cover;background-position:center;
    background-color:#150c1e;position:relative;
    display:flex;align-items:center;justify-content:center;
    overflow:hidden;
}
.bi-card-thumb::after {
    content:'';position:absolute;inset:0;
    background:linear-gradient(to bottom, transparent 55%, rgba(18,10,22,0.9) 100%);
}
.bi-card-tag {
    position:absolute;top:14px;left:14px;z-index:1;
    padding:4px 12px;
    background:linear-gradient(90deg,#e04385,#fa709a);
    color:#fff;font-size:11px;font-weight:700;border-radius:20px;
}
.bi-card-placeholder-icon {
    font-size:36px;color:rgba(224,67,133,0.2);z-index:1;
}

.bi-card-body { padding:20px; }
.bi-card-body h3 {
    font-size:15.5px;font-weight:800;color:#fff;
    line-height:1.38;margin-bottom:9px;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
.bi-card-body p {
    font-size:13px;color:#9a8c9e;line-height:1.6;margin-bottom:14px;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
.bi-card-footer {
    display:flex;align-items:center;justify-content:space-between;
    padding-top:12px;border-top:1px solid rgba(255,255,255,0.06);
    gap:8px;flex-wrap:wrap;
}
.bi-card-meta { font-size:12px;color:#6b5c73;display:flex;align-items:center;gap:5px; }
.bi-read-link {
    display:inline-flex;align-items:center;gap:5px;
    font-size:12px;font-weight:700;color:#e04385;
    transition:gap 0.2s;
}
.bi-read-link:hover { gap:8px; }

/* Empty State */
.bi-empty {
    text-align:center;padding:64px 24px;
    background:rgba(255,255,255,0.02);
    border-radius:20px;border:1px dashed rgba(255,255,255,0.08);
    grid-column:1/-1;
}
.bi-empty i  { font-size:48px;color:#3a2645;margin-bottom:16px;display:block; }
.bi-empty h3 { font-size:20px;font-weight:700;color:#fff;margin-bottom:10px; }
.bi-empty p  { font-size:14px;color:#9a8c9e; }
.bi-empty a  { color:#e04385; }

/* Pagination */
.bi-pagination {
    display:flex;justify-content:center;align-items:center;
    gap:6px;margin-bottom:40px;flex-wrap:wrap;
}
.bi-pagination a,.bi-pagination span {
    display:inline-flex;align-items:center;justify-content:center;
    min-width:38px;height:38px;padding:0 12px;
    border-radius:10px;font-size:13.5px;font-weight:600;
    text-decoration:none;transition:all 0.2s;
    border:1px solid rgba(255,255,255,0.07);
    color:#b8a8bf;background:rgba(18,10,22,0.9);
}
.bi-pagination a:hover {
    background:rgba(224,67,133,0.12);border-color:rgba(224,67,133,0.3);color:#e04385;
}
.bi-pagination .pg-active {
    background:linear-gradient(90deg,#e04385,#fa709a);color:#fff;border-color:transparent;
}
.bi-pagination .pg-disabled { opacity:0.35;pointer-events:none; }

/* CTA */
.bi-cta {
    background:linear-gradient(135deg,rgba(224,67,133,0.1),rgba(110,39,141,0.14));
    border:1.5px solid rgba(224,67,133,0.2);
    border-radius:22px;padding:36px 40px;
    display:flex;align-items:center;justify-content:space-between;
    gap:28px;flex-wrap:wrap;
    position:relative;overflow:hidden;
}
.bi-cta::before {
    content:'';position:absolute;top:-50px;right:-50px;
    width:220px;height:220px;border-radius:50%;
    background:rgba(224,67,133,0.06);pointer-events:none;
}
.bi-cta h2 { font-size:22px;font-weight:800;color:#fff;margin-bottom:8px; }
.bi-cta p  { font-size:14px;color:#b8a8bf;margin-bottom:20px;max-width:420px;line-height:1.6; }
.bi-cta-btns { display:flex;gap:10px;flex-wrap:wrap; }

.btn-pink {
    display:inline-flex;align-items:center;gap:7px;padding:12px 22px;
    background:linear-gradient(90deg,#e04385,#fa709a);color:#fff;
    font-weight:700;font-size:14px;border:none;border-radius:12px;
    cursor:pointer;transition:all 0.25s;
    box-shadow:0 4px 16px rgba(224,67,133,0.3);text-decoration:none;
}
.btn-pink:hover { transform:translateY(-2px);box-shadow:0 8px 28px rgba(224,67,133,0.45); }

.btn-outline {
    display:inline-flex;align-items:center;gap:7px;padding:11px 22px;
    background:rgba(255,255,255,0.06);color:#fff;
    font-weight:600;font-size:14px;
    border:1.5px solid rgba(255,255,255,0.15);border-radius:12px;
    cursor:pointer;transition:all 0.25s;text-decoration:none;
}
.btn-outline:hover { background:rgba(255,255,255,0.1);transform:translateY(-2px); }

/* Dots */
.bi-dots { display:flex;gap:10px;flex-wrap:wrap;max-width:140px;opacity:0.55;align-items:center; }
.bi-dot {
    width:12px;height:12px;border-radius:50%;background:#e04385;
    animation:dpulse 2s ease-in-out infinite alternate;
}
.bi-dot:nth-child(2){ animation-delay:.3s;background:#fa709a; }
.bi-dot:nth-child(3){ animation-delay:.6s;background:#c86dd4; }
.bi-dot:nth-child(4){ animation-delay:.9s; }
.bi-dot:nth-child(5){ animation-delay:1.2s; }
@keyframes dpulse { from{transform:scale(1);opacity:.5} to{transform:scale(1.3);opacity:1} }

/* Container */
.container { max-width:1200px;margin:0 auto;padding:0 24px; }

/* Responsive */
@media (max-width:1024px) {
    .bi-body { grid-template-columns:1fr; }
    .bi-sidebar { position:static;display:grid;grid-template-columns:1fr 1fr;gap:16px; }
}
@media (max-width:768px) {
    .bi-hero-card { display:none; }
    .bi-body { grid-template-columns:1fr; }
    .bi-sidebar { display:flex;flex-direction:column; }
    .bi-cta { padding:24px 20px; }
    .bi-dots { display:none; }
}
@media (max-width:480px) {
    .bi-grid { grid-template-columns:1fr; }
    .bi-title { font-size:26px; }
}
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section class="bi-hero">
    <div class="container">
        <div class="bi-hero-inner">
            <div class="bi-hero-left">
                <div class="bi-eyebrow">
                    <i class="fa-solid fa-newspaper" style="font-size:11px;"></i>
                    TechAnalytica Blog
                </div>
                <h1 class="bi-title">
                    Sharper thinking for people<br>
                    <span>building what's next.</span>
                </h1>
                <p class="bi-desc">Deep-dive research, expert software analysis, and engineering guides for technology leaders.</p>

                <form action="{{ route('frontend.blogs') }}" method="GET">
                    @if($categoryId)<input type="hidden" name="category_id" value="{{ $categoryId }}">@endif
                    <div class="bi-search">
                        <input type="text" name="q" placeholder="Search articles, guides, topics..." value="{{ request('q') }}">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </div>
                </form>

                <div class="bi-stats">
                    <div class="bi-stat">
                        <span class="num">{{ \App\Models\Blog::where('status','published')->count() }}</span>
                        <span class="lbl">Published</span>
                    </div>
                    <div class="bi-stat">
                        <span class="num">{{ $blogCategories->count() }}</span>
                        <span class="lbl">Categories</span>
                    </div>
                    <div class="bi-stat">
                        <span class="num">Weekly</span>
                        <span class="lbl">Updates</span>
                    </div>
                </div>
            </div>

            {{-- Latest post card --}}
            @if($featuredBlog)
            <a href="{{ route('frontend.blogs.show', $featuredBlog->slug) }}" class="bi-hero-card">
                <div class="bi-hero-card-thumb"
                     style="{{ $featuredBlog->og_image ? 'background-image:url('.asset($featuredBlog->og_image).');' : 'background:linear-gradient(135deg,rgba(224,67,133,0.18),rgba(110,39,141,0.22));' }}">
                    <div class="overlay"></div>
                    @if(!$featuredBlog->og_image)
                        <i class="fa-solid fa-newspaper" style="font-size:38px;color:rgba(224,67,133,0.25);z-index:1;"></i>
                    @endif
                </div>
                <div class="bi-hero-card-body">
                    <span class="bi-hero-card-badge">{{ $featuredBlog->category->name ?? 'Latest' }}</span>
                    <h3>{{ Str::limit($featuredBlog->title, 72) }}</h3>
                    <p>{{ Str::limit($featuredBlog->meta_description ?: strip_tags($featuredBlog->body), 85) }}</p>
                    <div class="bi-hero-card-meta">
                        <div class="bi-card-avatar">{{ strtoupper(substr($featuredBlog->author->name ?? 'T',0,1)) }}</div>
                        <span>{{ $featuredBlog->author->name ?? 'TechAnalytica' }}</span>
                        <span>·</span>
                        <span>{{ max(1,(int)(str_word_count(strip_tags($featuredBlog->body))/200)) }} min</span>
                    </div>
                </div>
            </a>
            @endif
        </div>
    </div>
</section>

{{-- ===== CATEGORY TABS ===== --}}
<div class="bi-filter">
    <div class="container">
        <div class="bi-filter-inner">
            <a href="{{ route('frontend.blogs') }}" class="bi-tab {{ !$categoryId ? 'active' : '' }}">
                <i class="fa-solid fa-border-all" style="font-size:11px;"></i> All
                <span class="bi-tab-count">{{ \App\Models\Blog::where('status','published')->count() }}</span>
            </a>
            @foreach($blogCategories as $cat)
                <a href="{{ route('frontend.blogs', ['category_id'=>$cat->id]) }}"
                   class="bi-tab {{ $categoryId==$cat->id ? 'active' : '' }}">
                    {{ $cat->name }}
                    @if($cat->blogs_count > 0)<span class="bi-tab-count">{{ $cat->blogs_count }}</span>@endif
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ===== MAIN BODY ===== --}}
<div class="container bi-body">

    {{-- Sidebar --}}
    <aside class="bi-sidebar">
        <div class="bi-sidebar-box">
            <h5>Categories</h5>
            <ul class="bi-cat-list">
                <li class="bi-cat-item">
                    <a href="{{ route('frontend.blogs') }}" class="{{ !$categoryId ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i> All Posts
                        <span class="bi-cat-badge">{{ \App\Models\Blog::where('status','published')->count() }}</span>
                    </a>
                </li>
                @forelse($blogCategories as $cat)
                    <li class="bi-cat-item">
                        <a href="{{ route('frontend.blogs', ['category_id'=>$cat->id]) }}"
                           class="{{ $categoryId==$cat->id ? 'active' : '' }}">
                            <i class="fa-solid fa-folder"></i>
                            {{ $cat->name }}
                            <span class="bi-cat-badge">{{ $cat->blogs_count }}</span>
                        </a>
                    </li>
                @empty
                    <li class="bi-cat-item"><a href="#"><i class="fa-solid fa-chart-line"></i> Trends</a></li>
                    <li class="bi-cat-item"><a href="#"><i class="fa-solid fa-book-open"></i> Guides</a></li>
                    <li class="bi-cat-item"><a href="#"><i class="fa-solid fa-newspaper"></i> News</a></li>
                @endforelse
            </ul>
        </div>

        <div class="bi-newsletter">
            <i class="fa-solid fa-envelope-open-text"></i>
            <h4>Weekly Digest</h4>
            <p>Join 45,000+ tech leaders. No spam, just signal.</p>
            <input type="email" class="bi-nl-input" placeholder="your@email.com">
            <button class="bi-nl-btn"><i class="fa-solid fa-paper-plane"></i> Subscribe</button>
        </div>
    </aside>

    {{-- Feed --}}
    <div class="bi-feed">
        <div class="bi-grid">
            @forelse($blogs as $blog)
                <a href="{{ route('frontend.blogs.show', $blog->slug) }}" class="bi-card">
                    <div class="bi-card-thumb"
                         style="{{ $blog->og_image ? 'background-image:url('.asset($blog->og_image).');' : 'background:linear-gradient(135deg,rgba(224,67,133,0.12),rgba(110,39,141,0.18));' }}">
                        <span class="bi-card-tag">{{ $blog->category->name ?? 'Article' }}</span>
                        @if(!$blog->og_image)
                            <i class="fa-solid fa-newspaper bi-card-placeholder-icon"></i>
                        @endif
                    </div>
                    <div class="bi-card-body">
                        <h3>{{ $blog->title }}</h3>
                        <p>{{ Str::limit($blog->meta_description ?: strip_tags($blog->body), 95) }}</p>
                        <div class="bi-card-footer">
                            <span class="bi-card-meta">
                                <i class="fa-regular fa-clock"></i>
                                {{ max(1,(int)(str_word_count(strip_tags($blog->body))/200)) }} min read
                            </span>
                            <span class="bi-card-meta">
                                {{ $blog->published_at ? $blog->published_at->diffForHumans() : $blog->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div style="margin-top:10px;">
                            <span class="bi-read-link">
                                Read article <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bi-empty">
                    <i class="fa-solid fa-newspaper"></i>
                    <h3>{{ $categoryId ? 'No posts in this category.' : 'No blog posts yet.' }}</h3>
                    <p>
                        @if($categoryId)
                            <a href="{{ route('frontend.blogs') }}">Browse all posts</a> or check back soon.
                        @else
                            Articles are published regularly. Check back soon.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($blogs->hasPages())
            <div class="bi-pagination">
                @if($blogs->onFirstPage())
                    <span class="pg-disabled">&larr; Prev</span>
                @else
                    <a href="{{ $blogs->previousPageUrl() }}">&larr; Prev</a>
                @endif

                @foreach($blogs->getUrlRange(max(1,$blogs->currentPage()-2), min($blogs->lastPage(),$blogs->currentPage()+2)) as $page => $url)
                    @if($page == $blogs->currentPage())
                        <span class="pg-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($blogs->hasMorePages())
                    <a href="{{ $blogs->nextPageUrl() }}">Next &rarr;</a>
                @else
                    <span class="pg-disabled">Next &rarr;</span>
                @endif
            </div>
        @endif

        {{-- CTA --}}
        <div class="bi-cta">
            <div>
                <h2>Discover the best AI tools for your stack.</h2>
                <p>Browse TechAnalytica's curated AI software database with verified reviews, pricing, and live benchmarks.</p>
                <div class="bi-cta-btns">
                    <a href="{{ route('frontend.tools') }}" class="btn-pink">
                        <i class="fa-solid fa-magnifying-glass"></i> Browse AI Tools
                    </a>
                    <a href="{{ route('frontend.compare') }}" class="btn-outline">
                        <i class="fa-solid fa-code-compare"></i> Compare Tools
                    </a>
                </div>
            </div>
            <div class="bi-dots">
                <div class="bi-dot"></div><div class="bi-dot"></div><div class="bi-dot"></div>
                <div class="bi-dot"></div><div class="bi-dot"></div>
            </div>
        </div>
    </div>

</div>{{-- /bi-body --}}

@endsection

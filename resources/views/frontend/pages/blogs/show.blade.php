@extends('frontend.layout.app')

@section('title', ($blog->meta_title ?: $blog->title) . ' | TechAnalytica')
@section('meta_description', $blog->meta_description ?? Str::limit(strip_tags($blog->body), 160))

@push('styles')
<style>
/* =============================================
   BLOG DETAIL — Premium Article Layout
   ============================================= */
.container { max-width:1200px;margin:0 auto;padding:0 24px; }
.container-read { max-width:800px;margin:0 auto;padding:0 24px; }

/* ---- Hero ---- */
.bd-hero {
    position:relative;padding:64px 0 52px;
    background:linear-gradient(150deg,#0c0412 0%,#110718 50%,#0a050d 100%);
    border-bottom:1px solid rgba(224,67,133,0.1);overflow:hidden;
}
.bd-hero::before {
    content:'';position:absolute;inset:0;
    background:
        radial-gradient(ellipse 70% 60% at 5% 50%, rgba(224,67,133,0.1) 0%, transparent 65%),
        radial-gradient(ellipse 50% 50% at 95% 10%, rgba(110,39,141,0.08) 0%, transparent 65%);
    pointer-events:none;
}

/* Breadcrumb */
.bd-breadcrumb {
    display:flex;align-items:center;gap:8px;
    font-size:12.5px;color:#9a8c9e;margin-bottom:22px;flex-wrap:wrap;
}
.bd-breadcrumb a { color:#9a8c9e;text-decoration:none;transition:color 0.2s; }
.bd-breadcrumb a:hover { color:#e04385; }
.bd-breadcrumb i { font-size:9px; }

/* Badges */
.bd-badges { display:flex;align-items:center;gap:8px;margin-bottom:18px;flex-wrap:wrap; }
.bd-badge-cat {
    display:inline-flex;align-items:center;gap:5px;
    padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;
    background:linear-gradient(90deg,#e04385,#fa709a);color:#fff;
}
.bd-badge-tag {
    display:inline-flex;padding:5px 13px;border-radius:20px;
    font-size:12px;font-weight:700;
    background:rgba(224,67,133,0.1);border:1px solid rgba(224,67,133,0.22);color:#e04385;
}

/* Title */
.bd-title {
    font-size:clamp(26px,5vw,48px);font-weight:800;color:#fff;
    letter-spacing:-0.5px;line-height:1.12;margin-bottom:18px;
}
.bd-title span {
    background:linear-gradient(135deg,#e04385,#fa709a,#c86dd4);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.bd-subtitle { font-size:17px;color:#b8a8bf;line-height:1.7;margin-bottom:26px;max-width:680px; }

/* Meta bar */
.bd-meta {
    display:flex;align-items:center;justify-content:space-between;
    gap:16px;flex-wrap:wrap;
    padding-top:20px;border-top:1px solid rgba(255,255,255,0.07);
}
.bd-author { display:flex;align-items:center;gap:12px; }
.bd-avatar {
    width:44px;height:44px;border-radius:50%;flex-shrink:0;
    background:linear-gradient(135deg,#e04385,#a4358a);
    display:flex;align-items:center;justify-content:center;
    font-size:17px;font-weight:800;color:#fff;
    border:2px solid rgba(224,67,133,0.3);
}
.bd-author-name { font-size:14px;font-weight:700;color:#fff;display:block;margin-bottom:2px; }
.bd-author-date { font-size:12px;color:#9a8c9e;display:block; }

.bd-meta-right {
    display:flex;align-items:center;gap:14px;
    font-size:13px;color:#9a8c9e;flex-wrap:wrap;
}
.bd-meta-right span { display:flex;align-items:center;gap:5px; }

/* ---- Cover ---- */
.bd-cover-wrap { padding:36px 0 0; }
.bd-cover {
    width:100%;height:440px;border-radius:22px;
    background-size:cover;background-position:center;background-color:#150c1e;
    border:1px solid rgba(255,255,255,0.07);overflow:hidden;position:relative;
}
.bd-cover::after {
    content:'';position:absolute;inset:0;
    background:linear-gradient(to bottom,transparent 60%,rgba(8,4,12,0.55) 100%);
}
.bd-cover-placeholder {
    width:100%;height:440px;border-radius:22px;
    background:linear-gradient(135deg,rgba(224,67,133,0.08),rgba(110,39,141,0.14));
    border:1.5px dashed rgba(224,67,133,0.2);
    display:flex;flex-direction:column;align-items:center;justify-content:center;gap:14px;
    color:#3a2645;
}
.bd-cover-placeholder i { font-size:52px; }
.bd-cover-placeholder span { font-size:14px;font-style:italic;color:#6b5c73;max-width:400px;text-align:center; }

/* ---- Article Layout ---- */
.bd-layout {
    display:grid;grid-template-columns:64px 1fr;gap:44px;
    padding:48px 0 80px;align-items:start;
    max-width:1000px;margin:0 auto;
}

/* Left share sidebar */
.bd-share-col { }
.bd-share-sticky { position:sticky;top:90px;display:flex;flex-direction:column;gap:14px;align-items:center; }
.bd-share-label { font-size:10px;color:#6b5c73;text-transform:uppercase;letter-spacing:1px;writing-mode:vertical-rl;transform:rotate(180deg); }
.bd-share-btn {
    width:40px;height:40px;border-radius:11px;
    background:rgba(18,10,22,0.9);border:1px solid rgba(255,255,255,0.09);
    color:#b8a8bf;display:flex;align-items:center;justify-content:center;
    font-size:14px;text-decoration:none;cursor:pointer;
    transition:all 0.2s ease;
}
.bd-share-btn:hover {
    background:rgba(224,67,133,0.15);border-color:rgba(224,67,133,0.3);
    color:#e04385;transform:scale(1.1);
}
.bd-share-divider { width:1px;height:24px;background:rgba(255,255,255,0.08); }

/* ---- Article Body ---- */
.bd-article { min-width:0; }

/* Lead paragraph */
.bd-lead {
    font-size:19px;font-weight:500;color:#d4c8da;line-height:1.8;
    padding-left:20px;border-left:4px solid #e04385;
    margin-bottom:28px;border-radius:0 8px 8px 0;
}

/* Prose styles */
.bd-prose p { font-size:16px;color:#c0b2c8;line-height:1.88;margin-bottom:22px; }
.bd-prose h2 {
    font-size:26px;font-weight:800;color:#fff;
    margin:48px 0 18px;scroll-margin-top:90px;letter-spacing:-0.3px;
    padding-bottom:12px;border-bottom:1px solid rgba(255,255,255,0.07);
}
.bd-prose h3 { font-size:20px;font-weight:700;color:#e8dcef;margin:36px 0 14px; }
.bd-prose h4 { font-size:17px;font-weight:700;color:#e8dcef;margin:28px 0 10px; }
.bd-prose strong { color:#fff;font-weight:700; }
.bd-prose a { color:#e04385;text-decoration:underline;text-underline-offset:3px; }
.bd-prose a:hover { color:#fa709a; }
.bd-prose ul,.bd-prose ol { padding-left:22px;margin-bottom:22px; }
.bd-prose li { font-size:16px;color:#c0b2c8;line-height:1.8;margin-bottom:8px; }
.bd-prose blockquote {
    background:rgba(224,67,133,0.06);
    border-left:4px solid #e04385;
    padding:20px 24px;border-radius:0 14px 14px 0;margin:28px 0;
}
.bd-prose blockquote p { font-size:17px;font-style:italic;color:#e2d8e8;margin:0 0 8px; }
.bd-prose blockquote cite { font-size:13px;color:#9a8c9e;font-style:normal; }
.bd-prose code {
    background:rgba(224,67,133,0.1);border:1px solid rgba(224,67,133,0.2);
    color:#fa709a;padding:2px 8px;border-radius:6px;
    font-size:14px;font-family:'Fira Code',monospace;
}
.bd-prose pre {
    background:#0d0815;border:1px solid rgba(255,255,255,0.07);
    border-radius:14px;padding:24px;overflow-x:auto;margin-bottom:24px;
}
.bd-prose pre code { background:none;border:none;color:#c0b2c8;padding:0;font-size:14px; }
.bd-prose img { max-width:100%;border-radius:14px;border:1px solid rgba(255,255,255,0.08);margin:8px 0; }
.bd-prose hr { border:none;border-top:1px solid rgba(255,255,255,0.07);margin:36px 0; }

/* Tags strip */
.bd-tags {
    display:flex;flex-wrap:wrap;gap:8px;
    margin:36px 0;padding:24px 0;
    border-top:1px solid rgba(255,255,255,0.07);
    border-bottom:1px solid rgba(255,255,255,0.07);
}
.bd-tag {
    display:inline-flex;align-items:center;gap:5px;
    padding:6px 16px;border-radius:20px;font-size:13px;font-weight:600;
    background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);
    color:#b8a8bf;transition:all 0.2s;cursor:default;
}
.bd-tag:hover { background:rgba(224,67,133,0.1);border-color:rgba(224,67,133,0.25);color:#e04385; }

/* Author bio */
.bd-author-bio {
    display:flex;align-items:flex-start;gap:20px;
    background:rgba(18,10,22,0.9);
    border:1px solid rgba(255,255,255,0.07);
    border-radius:20px;padding:28px;margin-top:36px;
}
.bd-bio-avatar {
    width:64px;height:64px;border-radius:50%;flex-shrink:0;
    background:linear-gradient(135deg,#e04385,#a4358a);
    display:flex;align-items:center;justify-content:center;
    font-size:24px;font-weight:800;color:#fff;
    border:2.5px solid rgba(224,67,133,0.3);
}
.bd-bio-info h4 { font-size:17px;font-weight:800;color:#fff;margin-bottom:8px; }
.bd-bio-info p  { font-size:13.5px;color:#b8a8bf;line-height:1.65;margin-bottom:14px; }
.bd-bio-socials { display:flex;gap:9px; }
.bd-bio-social {
    width:34px;height:34px;border-radius:8px;
    background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);
    color:#b8a8bf;display:flex;align-items:center;justify-content:center;
    font-size:13px;text-decoration:none;transition:all 0.2s;
}
.bd-bio-social:hover { background:rgba(224,67,133,0.12);border-color:rgba(224,67,133,0.25);color:#e04385; }

/* ---- Related Posts ---- */
.bd-related { padding:60px 0;border-top:1px solid rgba(255,255,255,0.07); }
.bd-related-head {
    display:flex;align-items:center;justify-content:space-between;
    margin-bottom:28px;flex-wrap:wrap;gap:10px;
}
.bd-related-head h2 { font-size:20px;font-weight:800;color:#fff;display:flex;align-items:center;gap:8px; }
.bd-related-head h2 i { color:#e04385;font-size:16px; }
.bd-view-all {
    font-size:13px;font-weight:700;color:#e04385;text-decoration:none;
    display:flex;align-items:center;gap:5px;transition:gap 0.2s;
}
.bd-view-all:hover { gap:8px; }

.bd-related-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:20px; }

.bd-rel-card {
    background:rgba(18,10,22,0.9);border:1px solid rgba(255,255,255,0.07);
    border-radius:16px;overflow:hidden;text-decoration:none;display:block;
    transition:all 0.3s ease;
}
.bd-rel-card:hover { border-color:rgba(224,67,133,0.28);transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,0.5); }
.bd-rel-thumb {
    height:150px;background-size:cover;background-position:center;
    background-color:#150c1e;position:relative;
    display:flex;align-items:center;justify-content:center;
}
.bd-rel-tag {
    position:absolute;top:12px;left:12px;
    padding:3px 11px;background:linear-gradient(90deg,#e04385,#fa709a);
    color:#fff;font-size:10.5px;font-weight:700;border-radius:20px;
}
.bd-rel-body { padding:16px; }
.bd-rel-body h3 { font-size:14.5px;font-weight:700;color:#fff;line-height:1.38;margin-bottom:8px; }
.bd-rel-body p  { font-size:12.5px;color:#9a8c9e;line-height:1.55;margin-bottom:10px;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
.bd-rel-meta { font-size:11.5px;color:#6b5c73;display:flex;align-items:center;gap:5px; }

/* ---- CTA ---- */
.bd-cta {
    margin:0 0 80px;
    background:linear-gradient(135deg,rgba(224,67,133,0.1),rgba(110,39,141,0.14));
    border:1.5px solid rgba(224,67,133,0.2);border-radius:22px;
    padding:40px 44px;
    display:flex;align-items:center;justify-content:space-between;
    gap:28px;flex-wrap:wrap;position:relative;overflow:hidden;
}
.bd-cta::before { content:'';position:absolute;top:-50px;right:-50px;width:220px;height:220px;border-radius:50%;background:rgba(224,67,133,0.05); }
.bd-cta h2 { font-size:22px;font-weight:800;color:#fff;margin-bottom:8px; }
.bd-cta p  { font-size:14px;color:#b8a8bf;margin-bottom:20px;max-width:420px;line-height:1.6; }
.bd-cta-btns { display:flex;gap:10px;flex-wrap:wrap; }

.btn-pink {
    display:inline-flex;align-items:center;gap:7px;padding:12px 22px;
    background:linear-gradient(90deg,#e04385,#fa709a);color:#fff;
    font-weight:700;font-size:14px;border:none;border-radius:12px;
    cursor:pointer;transition:all 0.25s;box-shadow:0 4px 16px rgba(224,67,133,0.3);text-decoration:none;
}
.btn-pink:hover { transform:translateY(-2px);box-shadow:0 8px 28px rgba(224,67,133,0.45); }
.btn-outline {
    display:inline-flex;align-items:center;gap:7px;padding:11px 22px;
    background:rgba(255,255,255,0.06);color:#fff;
    font-weight:600;font-size:14px;border:1.5px solid rgba(255,255,255,0.14);
    border-radius:12px;cursor:pointer;transition:all 0.25s;text-decoration:none;
}
.btn-outline:hover { background:rgba(255,255,255,0.1);transform:translateY(-2px); }

/* Dots */
.bd-dots { display:flex;gap:10px;flex-wrap:wrap;max-width:140px;opacity:0.55;align-items:center; }
.bd-dot { width:12px;height:12px;border-radius:50%;background:#e04385;animation:dpulse 2s ease-in-out infinite alternate; }
.bd-dot:nth-child(2){ animation-delay:.3s;background:#fa709a; }
.bd-dot:nth-child(3){ animation-delay:.6s;background:#c86dd4; }
.bd-dot:nth-child(4){ animation-delay:.9s; }
.bd-dot:nth-child(5){ animation-delay:1.2s; }
@keyframes dpulse { from{transform:scale(1);opacity:.5} to{transform:scale(1.3);opacity:1} }

/* Responsive */
@media (max-width:900px) {
    .bd-layout { grid-template-columns:1fr; }
    .bd-share-col { display:none; }
}
@media (max-width:640px) {
    .bd-cover,.bd-cover-placeholder { height:220px; }
    .bd-title { font-size:26px; }
    .bd-subtitle { font-size:15px; }
    .bd-lead { font-size:16px; }
    .bd-cta { padding:28px 20px; }
    .bd-dots { display:none; }
    .bd-author-bio { flex-direction:column; }
}
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<header class="bd-hero">
    <div class="container-read">

        <nav class="bd-breadcrumb">
            <a href="{{ route('frontend.home') }}"><i class="fa-solid fa-house"></i> Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('frontend.blogs') }}">Blog</a>
            @if($blog->category)
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('frontend.blogs', ['category_id' => $blog->category->id]) }}">{{ $blog->category->name }}</a>
            @endif
            <i class="fa-solid fa-chevron-right"></i>
            <span style="color:#e04385;">{{ Str::limit($blog->title, 36) }}</span>
        </nav>

        <div class="bd-badges">
            @if($blog->category)
                <span class="bd-badge-cat">
                    <i class="fa-solid fa-folder" style="font-size:10px;"></i>
                    {{ $blog->category->name }}
                </span>
            @endif
            @foreach($blog->tags->take(3) as $tag)
                <span class="bd-badge-tag">{{ $tag->name }}</span>
            @endforeach
            @if(!$blog->category && $blog->tags->isEmpty())
                <span class="bd-badge-cat"><i class="fa-solid fa-newspaper" style="font-size:10px;"></i> Article</span>
            @endif
        </div>

        <h1 class="bd-title">{{ $blog->title }}</h1>

        @if($blog->meta_description)
            <p class="bd-subtitle">{{ $blog->meta_description }}</p>
        @endif

        <div class="bd-meta">
            <div class="bd-author">
                <div class="bd-avatar">{{ strtoupper(substr($blog->author->name ?? 'T', 0, 1)) }}</div>
                <div>
                    <span class="bd-author-name">{{ $blog->author->name ?? 'TechAnalytica Staff' }}</span>
                    <span class="bd-author-date">
                        {{ $blog->published_at ? $blog->published_at->format('F j, Y') : $blog->created_at->format('F j, Y') }}
                    </span>
                </div>
            </div>
            <div class="bd-meta-right">
                <span><i class="fa-regular fa-clock"></i> {{ max(1,(int)(str_word_count(strip_tags($blog->body))/200)) }} min read</span>
                <span><i class="fa-regular fa-calendar"></i> {{ $blog->published_at ? $blog->published_at->diffForHumans() : $blog->created_at->diffForHumans() }}</span>
            </div>
        </div>

    </div>
</header>

{{-- ===== COVER IMAGE ===== --}}
<div class="container-read bd-cover-wrap">
    @if($blog->og_image)
        <div class="bd-cover" style="background-image:url('{{ asset($blog->og_image) }}');"></div>
    @else
        <div class="bd-cover-placeholder">
            <i class="fa-solid fa-newspaper"></i>
            <span>{{ $blog->title }}</span>
        </div>
    @endif
</div>

{{-- ===== ARTICLE BODY ===== --}}
<div class="container">
    <div class="bd-layout">

        {{-- Share sidebar --}}
        <aside class="bd-share-col">
            <div class="bd-share-sticky">
                <span class="bd-share-label">Share</span>
                <div class="bd-share-divider"></div>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}"
                   target="_blank" rel="noopener" class="bd-share-btn" title="Share on X">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                   target="_blank" rel="noopener" class="bd-share-btn" title="Share on LinkedIn">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
                <button onclick="navigator.clipboard.writeText(window.location.href).then(()=>{this.innerHTML='<i class=\'fa-solid fa-check\'></i>';setTimeout(()=>this.innerHTML='<i class=\'fa-regular fa-copy\'></i>',1500)})"
                        class="bd-share-btn" title="Copy link">
                    <i class="fa-regular fa-copy"></i>
                </button>
                <div class="bd-share-divider"></div>
                <a href="{{ route('frontend.blogs') }}" class="bd-share-btn" title="All posts">
                    <i class="fa-solid fa-grid-2" style="font-size:12px;"></i>
                </a>
            </div>
        </aside>

        {{-- Main content --}}
        <article class="bd-article">

            {{-- Lead paragraph from first 200 chars of body --}}
            @php
                $plainBody = strip_tags($blog->body);
                $firstSentences = implode('. ', array_slice(explode('. ', $plainBody), 0, 2));
            @endphp
            @if(strlen($plainBody) > 60)
                <p class="bd-lead">{{ Str::limit($firstSentences, 220) }}</p>
            @endif

            {{-- Full body --}}
            <div class="bd-prose">
                {!! $blog->body !!}
            </div>

            {{-- Tags --}}
            @if($blog->tags->count() > 0 || $blog->category)
                <div class="bd-tags">
                    @if($blog->category)
                        <span class="bd-tag">
                            <i class="fa-solid fa-folder" style="font-size:10px;color:#e04385;"></i>
                            {{ $blog->category->name }}
                        </span>
                    @endif
                    @foreach($blog->tags as $tag)
                        <span class="bd-tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif

            {{-- Author bio --}}
            <div class="bd-author-bio">
                <div class="bd-bio-avatar">{{ strtoupper(substr($blog->author->name ?? 'T', 0, 1)) }}</div>
                <div class="bd-bio-info">
                    <h4>{{ $blog->author->name ?? 'TechAnalytica Staff' }}</h4>
                    <p>{{ $blog->author->bio ?? 'Expert contributor at TechAnalytica covering AI software, developer productivity tools, and enterprise technology trends.' }}</p>
                    <div class="bd-bio-socials">
                        <a href="#" class="bd-bio-social" title="X / Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="bd-bio-social" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="bd-bio-social" title="Website"><i class="fa-solid fa-globe"></i></a>
                    </div>
                </div>
            </div>

        </article>
    </div>
</div>

{{-- ===== RELATED POSTS ===== --}}
@if($recentBlogs->count() > 0)
<section class="bd-related">
    <div class="container">
        <div class="bd-related-head">
            <h2><i class="fa-solid fa-layer-group"></i> More Articles</h2>
            <a href="{{ route('frontend.blogs') }}" class="bd-view-all">
                View all <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i>
            </a>
        </div>

        <div class="bd-related-grid">
            @foreach($recentBlogs as $rel)
                <a href="{{ route('frontend.blogs.show', $rel->slug) }}" class="bd-rel-card">
                    <div class="bd-rel-thumb"
                         style="{{ $rel->og_image ? 'background-image:url('.asset($rel->og_image).');' : 'background:linear-gradient(135deg,rgba(224,67,133,0.1),rgba(110,39,141,0.16));' }}">
                        <span class="bd-rel-tag">{{ $rel->category->name ?? 'Article' }}</span>
                        @if(!$rel->og_image)
                            <i class="fa-solid fa-newspaper" style="font-size:30px;color:rgba(224,67,133,0.2);"></i>
                        @endif
                    </div>
                    <div class="bd-rel-body">
                        <h3>{{ Str::limit($rel->title, 70) }}</h3>
                        <p>{{ Str::limit($rel->meta_description ?: strip_tags($rel->body), 85) }}</p>
                        <div class="bd-rel-meta">
                            <i class="fa-regular fa-clock"></i>
                            {{ max(1,(int)(str_word_count(strip_tags($rel->body))/200)) }} min read
                            &bull;
                            {{ $rel->published_at ? $rel->published_at->diffForHumans() : $rel->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== CTA ===== --}}
<div class="container">
    <div class="bd-cta">
        <div>
            <h2>Discover the best AI tools for your stack.</h2>
            <p>Browse TechAnalytica's curated AI software database with verified reviews, pricing comparisons, and live benchmarks.</p>
            <div class="bd-cta-btns">
                <a href="{{ route('frontend.tools') }}" class="btn-pink">
                    <i class="fa-solid fa-magnifying-glass"></i> Browse AI Tools
                </a>
                <a href="{{ route('frontend.compare') }}" class="btn-outline">
                    <i class="fa-solid fa-code-compare"></i> Compare Tools
                </a>
            </div>
        </div>
        <div class="bd-dots">
            <div class="bd-dot"></div><div class="bd-dot"></div><div class="bd-dot"></div>
            <div class="bd-dot"></div><div class="bd-dot"></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function(){
    /* Auto TOC + active scroll highlight */
    const prose = document.querySelector('.bd-prose');
    if (!prose) return;
    const headings = prose.querySelectorAll('h2, h3');
    if (!headings.length) return;

    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                document.querySelectorAll('.bd-toc-link').forEach(l => l.classList.remove('active'));
                const m = document.querySelector(`.bd-toc-link[href="#${e.target.id}"]`);
                if (m) m.classList.add('active');
            }
        });
    }, { rootMargin: '-20% 0px -70% 0px' });

    headings.forEach((h, i) => {
        if (!h.id) h.id = 'h-' + i;
        obs.observe(h);
    });
})();
</script>
@endpush

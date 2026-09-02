@extends('frontend.layout.app')

@section('title', 'TechAnalytica - Explore All AI Tools')

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="section-header" style="text-align: center; margin-bottom: 30px;">
        <h1 class="section-title" style="font-size: 38px; font-weight: 800; background: var(--button-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">All AI Software Tools</h1>
        <p class="section-desc" style="font-size: 15px;">Explore, filter, and compare top-rated artificial intelligence products engineered for enterprise workflow efficiency.</p>
    </div>

    <!-- Filter & Search Bar -->
    <form action="{{ route('frontend.tools.index') }}" method="GET" style="display: flex; gap: 16px; justify-content: center; align-items: center; margin-bottom: 40px; flex-wrap: wrap;">
        <div class="search-box-wrapper" style="flex: 1; min-width: 280px; max-width: 540px; margin: 0;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Search for AI tools, features or keywords...">
            <button type="submit" class="btn-search">Search</button>
        </div>

        <select name="category_id" onchange="this.form.submit()" style="padding: 12px 24px; border-radius: 40px; background-color: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); color: #fff; font-size: 14px; cursor: pointer; outline: none; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
            <option value="" style="background: #140a1b;">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }} style="background: #140a1b;">
                    {{ $cat->name }} ({{ $cat->tools_count }})
                </option>
            @endforeach
        </select>
    </form>

    <!-- Tools Grid (9 Items Per Page) -->
    <div class="tools-grid">
        @forelse($tools as $tool)
            <div class="tool-card" style="border: 1px solid rgba(224,67,133,0.2); background: linear-gradient(145deg, #180d1f 0%, #110717 100%); position: relative;">
                @if($tool->is_featured)
                    <span class="tool-badge"><i class="fa-solid fa-crown" style="font-size: 10px;"></i> Featured</span>
                @elseif($tool->is_verified)
                    <span class="tool-badge" style="background: rgba(40,167,69,0.2); color: #28a745;"><i class="fa-solid fa-circle-check" style="font-size: 10px;"></i> Verified</span>
                @endif

                <div class="tool-header">
                    <div class="tool-icon" style="background: linear-gradient(135deg, rgba(224,67,133,0.2), rgba(164,53,138,0.2)); border: 1px solid rgba(224,67,133,0.3);">
                        @if($tool->logo_url)
                            <img src="{{ asset($tool->logo_url) }}" alt="{{ $tool->name }}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                        @else
                            <i class="fa-solid fa-brain" style="color: #e04385;"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="tool-title">
                            <a href="{{ route('frontend.tools.show', $tool->slug) }}" style="color: #fff; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--accent-pink)'" onmouseout="this.style.color='#fff'">{{ $tool->name }}</a>
                        </h3>
                        <p class="tool-category"><i class="fa-solid fa-folder" style="font-size: 10px; margin-right: 4px; color: var(--accent-pink);"></i> {{ $tool->categories->pluck('name')->join(', ') ?: 'AI Tool' }}</p>
                    </div>
                </div>

                <p class="tool-desc" style="min-height: 58px;">{{ Str::limit($tool->short_description, 95) }}</p>

                <div class="tool-footer" style="padding-top: 14px; border-top: 1px solid rgba(255,255,255,0.06);">
                    <span class="pricing-tag" style="background: rgba(255,255,255,0.05); padding: 4px 10px; border-radius: 6px; font-size: 12px; color: #d1c4d6;">
                        <i class="fa-solid fa-tag" style="font-size: 10px; margin-right: 4px; color: var(--accent-pink);"></i> {{ $tool->pricing_text ?? ($tool->tier->name ?? 'Freemium') }}
                    </span>
                    <a href="{{ route('frontend.tools.show', $tool->slug) }}" class="btn-visit">View Details <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #a0aec0; padding: 60px; background: var(--bg-card); border-radius: 20px; border: 1px solid var(--border-dark);">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 40px; color: var(--accent-pink); margin-bottom: 16px;"></i>
                <h3>No AI tools found matching your criteria.</h3>
                <p style="color: var(--text-secondary); margin-top: 8px;">Try searching for a different keyword or select another category.</p>
            </div>
        @endforelse
    </div>

    <!-- Beautiful Custom Pagination -->
    @if ($tools->hasPages())
        <div style="margin-top: 60px; display: flex; justify-content: center; align-items: center;">
            <div style="display: flex; gap: 8px; align-items: center; background: rgba(255, 255, 255, 0.03); padding: 8px 16px; border-radius: 40px; border: 1px solid rgba(255, 255, 255, 0.08);">
                {{-- Previous Page Link --}}
                @if ($tools->onFirstPage())
                    <span style="opacity: 0.3; cursor: not-allowed; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; background: rgba(255,255,255,0.05);"><i class="fa-solid fa-chevron-left" style="font-size: 12px;"></i></span>
                @else
                    <a href="{{ $tools->previousPageUrl() }}" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; background: rgba(255,255,255,0.08); text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='var(--button-pink)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'"><i class="fa-solid fa-chevron-left" style="font-size: 12px;"></i></a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($tools->getUrlRange(1, $tools->lastPage()) as $page => $url)
                    @if ($page == $tools->currentPage())
                        <span style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; background: var(--button-pink); font-weight: 700; font-size: 14px; box-shadow: 0 4px 14px rgba(216,59,125,0.4);">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); background: transparent; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#fff'; this.style.background='rgba(255,255,255,0.08)'" onmouseout="this.style.color='var(--text-secondary)'; this.style.background='transparent'">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($tools->hasMorePages())
                    <a href="{{ $tools->nextPageUrl() }}" style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; background: rgba(255,255,255,0.08); text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='var(--button-pink)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'"><i class="fa-solid fa-chevron-right" style="font-size: 12px;"></i></a>
                @else
                    <span style="opacity: 0.3; cursor: not-allowed; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; background: rgba(255,255,255,0.05);"><i class="fa-solid fa-chevron-right" style="font-size: 12px;"></i></span>
                @endif
            </div>
        </div>
    @endif
</div>

@endsection


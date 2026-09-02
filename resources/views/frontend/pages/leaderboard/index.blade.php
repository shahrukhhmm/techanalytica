@extends('frontend.layout.app')

@section('title', 'AI Software Leaderboard & Grid Rankings - TechAnalytica')

@push('styles')
<style>
    .leaderboard-hero {
        background: linear-gradient(135deg, rgba(224, 67, 133, 0.12) 0%, rgba(164, 53, 138, 0.12) 100%);
        border: 1px solid rgba(224, 67, 133, 0.25);
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 40px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    .rank-num-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
    }
    .rank-1 { background: linear-gradient(135deg, #ffd700, #ffa500); color: #000; box-shadow: 0 0 15px rgba(255, 215, 0, 0.6); }
    .rank-2 { background: linear-gradient(135deg, #e0e0e0, #bdbdbd); color: #000; }
    .rank-3 { background: linear-gradient(135deg, #cd7f32, #8b4513); color: #fff; }
    .rank-other { background: rgba(255, 255, 255, 0.08); color: #fff; }
    .score-circle {
        background: var(--button-gradient);
        color: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 14px;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <!-- Hero Box -->
    <div class="leaderboard-hero">
        <h1 class="section-title" style="font-size: 38px; font-weight: 800; background: var(--button-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            🏆 2026 AI Product Leaderboard
        </h1>
        <p class="section-desc" style="font-size: 15px; max-width: 720px; margin: 10px auto 0;">
            Objective algorithmic ranking based on verified user reviews, telemetry volume, and technical performance score: <code>Score = (Avg Rating × 0.5) + (Reviews × 0.3) + (Traffic × 0.2)</code>.
        </p>
    </div>

    <!-- Filters -->
    <form action="{{ route('frontend.leaderboard') }}" method="GET" style="display: flex; gap: 16px; justify-content: center; align-items: center; margin-bottom: 40px; flex-wrap: wrap;">
        <select name="category_id" onchange="this.form.submit()" style="padding: 12px 24px; border-radius: 40px; background-color: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); color: #fff; font-size: 14px; cursor: pointer; outline: none;">
            <option value="" style="background: #140a1b;">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }} style="background: #140a1b;">{{ $cat->name }}</option>
            @endforeach
        </select>

        <select name="ai_type" onchange="this.form.submit()" style="padding: 12px 24px; border-radius: 40px; background-color: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); color: #fff; font-size: 14px; cursor: pointer; outline: none;">
            <option value="" style="background: #140a1b;">All AI Types</option>
            <option value="LLM & Conversational AI" {{ request('ai_type') == 'LLM & Conversational AI' ? 'selected' : '' }} style="background: #140a1b;">LLM & Conversational AI</option>
            <option value="Computer Vision & Image" {{ request('ai_type') == 'Computer Vision & Image' ? 'selected' : '' }} style="background: #140a1b;">Computer Vision & Image</option>
            <option value="Voice, Audio & Speech" {{ request('ai_type') == 'Voice, Audio & Speech' ? 'selected' : '' }} style="background: #140a1b;">Voice, Audio & Speech</option>
            <option value="Code Assistant & Dev AI" {{ request('ai_type') == 'Code Assistant & Dev AI' ? 'selected' : '' }} style="background: #140a1b;">Code Assistant & Dev AI</option>
            <option value="Video Generation & Studio" {{ request('ai_type') == 'Video Generation & Studio' ? 'selected' : '' }} style="background: #140a1b;">Video Generation & Studio</option>
            <option value="Autonomous Agent & CLI" {{ request('ai_type') == 'Autonomous Agent & CLI' ? 'selected' : '' }} style="background: #140a1b;">Autonomous Agent & CLI</option>
            <option value="Data Analytics & Predictive" {{ request('ai_type') == 'Data Analytics & Predictive' ? 'selected' : '' }} style="background: #140a1b;">Data Analytics & Predictive</option>
        </select>
    </form>

    <!-- Leaderboard Table -->
    <div style="background: var(--bg-card); border: 1px solid var(--border-dark); border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: #fff;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <th style="padding: 20px 24px; width: 8%;">Rank</th>
                    <th style="padding: 20px 24px; width: 35%;">AI Software Product</th>
                    <th style="padding: 20px 24px; width: 18%;">AI Classification</th>
                    <th style="padding: 20px 24px; width: 15%;">Community Rating</th>
                    <th style="padding: 20px 24px; width: 12%; text-align: center;">TechScore</th>
                    <th style="padding: 20px 24px; width: 12%; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rankedTools as $index => $t)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.03)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 20px 24px;">
                            <div class="rank-num-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }}">
                                {{ $index + 1 }}
                            </div>
                        </td>
                        <td style="padding: 20px 24px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(224, 67, 133, 0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @if($t->logo_url)
                                        <img src="{{ asset($t->logo_url) }}" alt="{{ $t->name }}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 10px;">
                                    @else
                                        <i class="fa-solid fa-brain" style="color: #e04385;"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 style="font-size: 16px; font-weight: 700; margin: 0;">
                                        <a href="{{ route('frontend.tools.show', $t->slug) }}" style="color: #fff; text-decoration: none;">{{ $t->name }}</a>
                                        @if($t->is_verified)
                                            <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 13px; margin-left: 4px;" title="Verified Leader"></i>
                                        @endif
                                    </h3>
                                    <span style="font-size: 12px; color: var(--text-secondary);">{{ $t->categories->pluck('name')->join(', ') ?: 'AI Tool' }}</span>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 20px 24px;">
                            <span style="background: rgba(255,255,255,0.06); padding: 4px 10px; border-radius: 6px; font-size: 12px; color: #d1c4d6;">
                                {{ $t->ai_type ?? 'General AI' }}
                            </span>
                        </td>
                        <td style="padding: 20px 24px;">
                            <span style="color: #ffc107; font-weight: 700;"><i class="fa-solid fa-star"></i> {{ number_format($t->reviews->avg('rating') ?: 4.5, 1) }}</span>
                            <div style="font-size: 11px; color: var(--text-secondary);">({{ $t->reviews->count() }} reviews)</div>
                        </td>
                        <td style="padding: 20px 24px; text-align: center;">
                            <span class="score-circle">{{ $t->score }}</span>
                        </td>
                        <td style="padding: 20px 24px; text-align: right;">
                            <a href="{{ route('frontend.compare', ['tool1' => $t->slug]) }}" class="btn-visit" style="font-size: 12px; padding: 6px 14px;">Compare <i class="fa-solid fa-code-compare"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-secondary);">No ranked products found for the selected criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

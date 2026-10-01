<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'tier_id',
        'name',
        'slug',
        'logo_url',
        'short_description',
        'long_description',
        'ai_type',
        'pros',
        'cons',
        'website_url',
        'pricing_structured',
        'pricing_text',
        'cta_type',
        'cta_url',
        'status',
        'is_featured',
        'rank',
        'is_verified',
        'is_locked',
        'pending_data',
        'has_pending_update',
        'is_claimed',
        'published_at',
        'last_edited_at',
    ];

    protected $casts = [
        'pricing_structured' => 'array',
        'pros' => 'array',
        'cons' => 'array',
        'pending_data' => 'array',
        'has_pending_update' => 'boolean',
        'is_claimed' => 'boolean',
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'is_locked' => 'boolean',
        'published_at' => 'datetime',
        'last_edited_at' => 'datetime',
        'rank' => 'integer',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function tier()
    {
        return $this->belongsTo(PricingTier::class, 'tier_id');
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'tool_industry');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'tool_category');
    }

    public function media()
    {
        return $this->hasMany(ToolMedia::class);
    }

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function billingTransactions()
    {
        return $this->hasMany(BillingTransaction::class);
    }

    public function analyticsEvents()
    {
        return $this->hasMany(AnalyticsEvent::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // -------------------------------------------------------------------------
    // TA Scoring Engine relationships
    // -------------------------------------------------------------------------

    public function scoreRuns()
    {
        return $this->hasMany(ScoreRun::class);
    }

    public function productFacts()
    {
        return $this->hasMany(ProductFact::class);
    }

    public function evidenceSources()
    {
        return $this->hasMany(EvidenceSource::class);
    }

    public function reviewAggregates()
    {
        return $this->hasMany(ReviewAggregate::class);
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Only published tools.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * Get the latest published TA Score for this tool's primary category,
     * falling back to the legacy engagement-based score if no TA Score exists.
     */
    public function getScoreAttribute(): float
    {
        // Prefer TA Score from most recent published score run
        $latestRun = $this->scoreRuns()
            ->where('is_published', true)
            ->latest('run_at')
            ->first();

        if ($latestRun) {
            return $latestRun->public_score;
        }

        // Legacy fallback (engagement-based)
        $avgRating  = $this->reviews->where('status', 'approved')->avg('rating') ?: 4.0;
        $ratingPart = ($avgRating / 5.0) * 50.0;

        $reviewCount = $this->reviews->where('status', 'approved')->count();
        $reviewPart  = min(30.0, ($reviewCount / 20.0) * 30.0);

        $trafficCount = $this->analyticsEvents()->count();
        $trafficPart  = min(20.0, ($trafficCount / 100.0) * 20.0);

        return round($ratingPart + $reviewPart + $trafficPart, 1);
    }

    /**
     * Get the current TA Score confidence label (High/Moderate/Low) or null.
     */
    public function getTaConfidenceLabelAttribute(): ?string
    {
        return $this->scoreRuns()
            ->where('is_published', true)
            ->latest('run_at')
            ->value('confidence_label');
    }

    /**
     * Get ranking status: ranked / provisional / unranked or null.
     */
    public function getTaStatusAttribute(): ?string
    {
        return $this->scoreRuns()
            ->where('is_published', true)
            ->latest('run_at')
            ->value('status');
    }
}

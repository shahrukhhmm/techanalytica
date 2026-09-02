<?php

namespace App\Models;

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

    /**
     * Product Score = (Avg Rating * 0.5) + (No. of Reviews * 0.3) + (Clicks/Traffic * 0.2)
     * Normalized to a scale of 0 to 100 for display and leaderboard ranking.
     */
    public function getScoreAttribute()
    {
        $avgRating = $this->reviews->where('status', 'approved')->avg('rating') ?: 4.0;
        $ratingPart = ($avgRating / 5.0) * 50.0;

        $reviewCount = $this->reviews->where('status', 'approved')->count();
        $reviewPart = min(30.0, ($reviewCount / 20.0) * 30.0);

        $trafficCount = $this->analyticsEvents()->count();
        $trafficPart = min(20.0, ($trafficCount / 100.0) * 20.0);

        return round($ratingPart + $reviewPart + $trafficPart, 1);
    }
}

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
        'website_url',
        'pricing_structured',
        'pricing_text',
        'cta_type',
        'cta_url',
        'status',
        'pending_data',
        'has_pending_update',
        'is_claimed',
        'published_at',
        'last_edited_at',
    ];

    protected $casts = [
        'pricing_structured' => 'array',
        'pending_data' => 'array',
        'has_pending_update' => 'boolean',
        'is_claimed' => 'boolean',
        'published_at' => 'datetime',
        'last_edited_at' => 'datetime',
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
}

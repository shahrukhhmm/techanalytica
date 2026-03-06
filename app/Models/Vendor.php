<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_name',
        'company_website',
        'company_size',
        'designation',
        'department',
        'phone',
        'billing_email',
        'billing_address',
        'pricing_tier_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tier()
    {
        return $this->belongsTo(PricingTier::class, 'pricing_tier_id');
    }

    public function tools()
    {
        return $this->hasMany(Tool::class);
    }

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function billingTransactions()
    {
        return $this->hasMany(BillingTransaction::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}

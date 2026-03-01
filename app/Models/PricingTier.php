<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingTier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'monthly_price',
        'annual_price',
        'features',
        'permissions',
    ];

    protected $casts = [
        'features' => 'array',
        'permissions' => 'array',
        'monthly_price' => 'decimal:2',
        'annual_price' => 'decimal:2',
    ];

    public function tools()
    {
        return $this->hasMany(Tool::class, 'tier_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MethodologyVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_name',
        'weights',
        'global_parameters',
        'effective_date',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'weights'           => 'array',
        'global_parameters' => 'array',
        'effective_date'    => 'datetime',
        'published_at'      => 'datetime',
        'is_active'         => 'boolean',
    ];

    public function scoreRuns()
    {
        return $this->hasMany(ScoreRun::class);
    }

    /**
     * Return the currently active methodology version.
     */
    public static function current(): ?self
    {
        return static::where('is_active', true)->latest('effective_date')->first();
    }

    /**
     * v1.0 default weight map:
     *   use_case_fit => 0.25, ai_utility => 0.15, usability => 0.15,
     *   workflow_fit => 0.10, value_pricing => 0.10, trust_readiness => 0.10,
     *   customer_evidence => 0.10, product_health => 0.05
     */
    public function getDimensionWeight(string $dimensionKey): float
    {
        return $this->weights[$dimensionKey] ?? 0.0;
    }

    public function getGlobalParam(string $key, $default = null)
    {
        return $this->global_parameters[$key] ?? $default;
    }
}

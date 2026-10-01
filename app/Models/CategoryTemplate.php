<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'template_version',
        'effective_date',
        'core_requirements',
        'advanced_capabilities',
        'important_integrations',
        'target_segments',
        'trust_requirements',
        'ai_depth_definition',
        'pricing_comparison_basis',
        'minimum_evidence_requirements',
        'manual_review_triggers',
        'is_active',
    ];

    protected $casts = [
        'effective_date'               => 'datetime',
        'core_requirements'            => 'array',
        'advanced_capabilities'        => 'array',
        'important_integrations'       => 'array',
        'target_segments'              => 'array',
        'trust_requirements'           => 'array',
        'pricing_comparison_basis'     => 'array',
        'minimum_evidence_requirements'=> 'array',
        'manual_review_triggers'       => 'array',
        'is_active'                    => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the active template for a category.
     */
    public static function activeForCategory(int $categoryId): ?self
    {
        return static::where('category_id', $categoryId)
            ->where('is_active', true)
            ->latest('effective_date')
            ->first();
    }
}

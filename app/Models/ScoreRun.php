<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'category_id',
        'methodology_version_id',
        'template_version',
        'run_at',
        'internal_score',
        'public_score',
        'confidence_score',
        'confidence_label',
        'status',
        'is_published',
        'flagged_for_review',
        'notes',
    ];

    protected $casts = [
        'run_at'              => 'datetime',
        'internal_score'      => 'float',
        'public_score'        => 'float',
        'confidence_score'    => 'float',
        'is_published'        => 'boolean',
        'flagged_for_review'  => 'boolean',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function methodologyVersion()
    {
        return $this->belongsTo(MethodologyVersion::class);
    }

    public function breakdowns()
    {
        return $this->hasMany(ScoreBreakdown::class);
    }

    public function exceptions()
    {
        return $this->hasMany(ReviewException::class);
    }

    public function rankSnapshots()
    {
        return $this->hasMany(RankSnapshot::class);
    }

    /**
     * Get dimension-level summary: dimension_key => [points, max, pct].
     */
    public function getDimensionSummary(): array
    {
        $summary = [];
        foreach ($this->breakdowns as $bd) {
            $key = $bd->dimension_key;
            if (!isset($summary[$key])) {
                $summary[$key] = ['points' => 0.0, 'max' => 0.0];
            }
            $summary[$key]['points'] += $bd->points_awarded;
            $summary[$key]['max']    += $bd->max_points;
        }
        foreach ($summary as $key => &$data) {
            $data['pct'] = $data['max'] > 0 ? round(($data['points'] / $data['max']) * 100, 1) : 0;
        }
        return $summary;
    }

    /**
     * Latest published run for a product+category.
     */
    public static function latestPublished(int $toolId, int $categoryId): ?self
    {
        return static::where('tool_id', $toolId)
            ->where('category_id', $categoryId)
            ->where('is_published', true)
            ->latest('run_at')
            ->first();
    }
}

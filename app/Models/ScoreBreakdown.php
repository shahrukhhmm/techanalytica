<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreBreakdown extends Model
{
    use HasFactory;

    protected $fillable = [
        'score_run_id',
        'dimension_key',
        'subcriterion_key',
        'raw_value',
        'points_awarded',
        'max_points',
        'rule_version',
        'evidence_item_ids',
        'reasoning',
    ];

    protected $casts = [
        'evidence_item_ids' => 'array',
        'raw_value'         => 'float',
        'points_awarded'    => 'float',
        'max_points'        => 'float',
    ];

    public function scoreRun()
    {
        return $this->belongsTo(ScoreRun::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'score_run_id',
        'tool_id',
        'snapshot_date',
        'rank',
        'eligible_count',
    ];

    protected $casts = [
        'snapshot_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scoreRun()
    {
        return $this->belongsTo(ScoreRun::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}

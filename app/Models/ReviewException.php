<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewException extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'score_run_id',
        'trigger_type',
        'severity',
        'status',
        'owner',
        'description',
        'resolution',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function scoreRun()
    {
        return $this->belongsTo(ScoreRun::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
}

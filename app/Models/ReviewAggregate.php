<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewAggregate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'source_family',
        'rating_raw',
        'rating_norm',
        'review_count',
        'recency_data',
        'retrieved_at',
    ];

    protected $casts = [
        'recency_data' => 'array',
        'retrieved_at' => 'datetime',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}

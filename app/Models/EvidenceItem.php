<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'tool_id',
        'field_key',
        'extracted_value',
        'raw_excerpt',
        'retrieved_at',
        'expires_at',
        'extractor_confidence',
        'verified_status',
    ];

    protected $casts = [
        'retrieved_at'         => 'datetime',
        'expires_at'           => 'datetime',
        'extractor_confidence' => 'float',
    ];

    public function source()
    {
        return $this->belongsTo(EvidenceSource::class, 'source_id');
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function isStale(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Return age in months.
     */
    public function ageInMonths(): float
    {
        return $this->retrieved_at->diffInMonths(now());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenceSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'source_type',
        'source_family',
        'url',
        'authority_level',
        'allowed_usage_mode',
        'is_active',
        'refresh_ttl_days',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function evidenceItems()
    {
        return $this->hasMany(EvidenceItem::class, 'source_id');
    }
}

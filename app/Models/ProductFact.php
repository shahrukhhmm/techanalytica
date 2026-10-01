<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFact extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'field_key',
        'value',
        'evidence_item_ids',
        'status',
        'last_verified_at',
    ];

    protected $casts = [
        'evidence_item_ids' => 'array',
        'last_verified_at'  => 'datetime',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    /**
     * Retrieve a fact value for a tool, returning null if not found.
     */
    public static function getFor(int $toolId, string $fieldKey): ?string
    {
        return static::where('tool_id', $toolId)
            ->where('field_key', $fieldKey)
            ->value('value');
    }

    /**
     * Upsert a fact value (used by admin/extraction layer).
     */
    public static function setFor(int $toolId, string $fieldKey, $value, array $evidenceIds = [], string $status = 'unverified'): self
    {
        return static::updateOrCreate(
            ['tool_id' => $toolId, 'field_key' => $fieldKey],
            [
                'value'             => $value,
                'evidence_item_ids' => $evidenceIds,
                'status'            => $status,
                'last_verified_at'  => now(),
            ]
        );
    }
}

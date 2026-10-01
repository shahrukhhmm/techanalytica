<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoringAuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'actor_id',
        'entity_type',
        'entity_id',
        'action',
        'before',
        'after',
        'reason',
        'timestamp',
    ];

    protected $casts = [
        'before'    => 'array',
        'after'     => 'array',
        'timestamp' => 'datetime',
    ];

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Create an audit record conveniently.
     */
    public static function record(
        string $entityType,
        int $entityId,
        string $action,
        ?array $before = null,
        ?array $after = null,
        ?string $reason = null,
        ?int $actorId = null
    ): self {
        return static::create([
            'actor_id'    => $actorId ?? auth()->id(),
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'action'      => $action,
            'before'      => $before,
            'after'       => $after,
            'reason'      => $reason,
            'timestamp'   => now(),
        ]);
    }
}

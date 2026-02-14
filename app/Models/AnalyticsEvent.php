<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $fillable = [
        'tool_id',
        'vendor_id',
        'event_type',
        'timestamp',
        'referrer',
        'session_id',
        'device',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [
        'tool_id',
        'vendor_id',
        'status',
        'reason',
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

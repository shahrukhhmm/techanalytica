<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingTransaction extends Model
{
    protected $fillable = [
        'vendor_id',
        'tool_id',
        'amount',
        'currency',
        'type',
        'status',
        'external_tx_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}

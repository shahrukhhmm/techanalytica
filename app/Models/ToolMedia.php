<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolMedia extends Model
{
    protected $fillable = [
        'tool_id',
        'type',
        'url',
        'sort_order',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}

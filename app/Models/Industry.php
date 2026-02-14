<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'suggested_by_vendor_id',
        'approved',
    ];

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'tool_industry');
    }
}

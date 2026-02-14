<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageBlock extends Model
{
    protected $fillable = [
        'block_type',
        'content',
        'sort_order',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolCategory extends Model
{
    protected $table = 'tool_category';
    public $timestamps = false;

    protected $fillable = [
        'tool_id',
        'category_id',
    ];
}

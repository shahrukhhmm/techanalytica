<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolIndustry extends Model
{
    protected $table = 'tool_industry';
    public $timestamps = false;
    
    protected $fillable = [
        'tool_id',
        'industry_id',
    ];
}

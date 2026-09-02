<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'vendor_id',
        'user_id',
        'name',
        'email',
        'company_name',
        'company_size',
        'phone',
        'intent_type',
        'message',
        'status',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

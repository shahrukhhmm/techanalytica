<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'user_id',
        'user_name',
        'user_email',
        'rating',
        'comment',
        'status',
        'is_verified',
        'verification_type',
        'vendor_reply',
        'vendor_replied_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'vendor_replied_at' => 'datetime',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

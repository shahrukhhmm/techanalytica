<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'body',
        'author_id',
        'vendor_id',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

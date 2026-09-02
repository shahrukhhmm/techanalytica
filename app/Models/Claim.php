<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'vendor_id',
        'full_name',
        'work_email',
        'company_name',
        'company_website',
        'verification_info',
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

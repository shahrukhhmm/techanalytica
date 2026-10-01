<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorCorrection extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'submitter_id',
        'correction_type',
        'claim',
        'evidence_url',
        'evidence_file',
        'status',
        'reviewer_id',
        'resolution',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitter_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}

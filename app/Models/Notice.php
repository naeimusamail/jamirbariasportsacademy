<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport_id',
        'title',
        'content',
        'notice_date',
        'is_pinned',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}


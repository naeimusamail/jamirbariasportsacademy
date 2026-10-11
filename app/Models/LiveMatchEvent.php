<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveMatchEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_match_id',
        'time_marker',
        'event_type',
        'title',
        'description',
    ];

    public function liveMatch()
    {
        return $this->belongsTo(LiveMatch::class);
    }
}


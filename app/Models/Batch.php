<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport_id',
        'coach_id',
        'name',
        'days',
        'time_slot',
        'ground',
        'capacity',
        'status',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function trainees()
    {
        return $this->hasMany(Trainee::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}


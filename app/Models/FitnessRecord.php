<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_id',
        'test_date',
        'height_cm',
        'weight_kg',
        'bmi',
        'sprint_100m_sec',
        'yoyo_score',
        'stamina_level',
        'matches_played',
        'goals_or_runs',
        'wickets_or_assists',
        'coach_rating',
        'coach_remarks',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}


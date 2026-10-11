<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'user_id',
        'trainee_id',
        'team_id',
        'player_name',
        'player_phone',
        'position',
        'jersey_no',
        'status',
        'notes',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function isAssigned(): bool
    {
        return !is_null($this->team_id);
    }

    public function isFreeAgent(): bool
    {
        return is_null($this->team_id);
    }
}


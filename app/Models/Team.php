<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'slug',
        'sport_id',
        'sport_type',
        'category',
        'logo',
        'coach_name',
        'captain_name',
        'description',
        'matches_played',
        'matches_won',
        'matches_lost',
        'matches_drawn',
        'points',
        'status',
    ];

    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'like', "{$slug}%")->count();
        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function players()
    {
        return $this->hasMany(TeamPlayer::class);
    }

    public function activePlayers()
    {
        return $this->hasMany(TeamPlayer::class)->where('status', 'active');
    }

    public function captain()
    {
        return $this->hasOne(TeamPlayer::class)->where('is_captain', true);
    }

    public function homeMatches()
    {
        return $this->hasMany(LiveMatch::class, 'team_a_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(LiveMatch::class, 'team_b_id');
    }

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'tournament_teams')
            ->withPivot(['id', 'group_name', 'points', 'matches_played', 'won', 'lost', 'drawn'])
            ->withTimestamps();
    }
}


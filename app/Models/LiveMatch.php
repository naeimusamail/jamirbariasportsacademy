<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LiveMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'sport_type',
        'tournament_id',
        'tournament_type',
        'is_official',
        'tournament_name',
        'team_a',
        'team_a_id',
        'team_a_score',
        'team_b',
        'team_b_id',
        'team_b_score',
        'status',
        'current_summary',
        'venue',
        'toss_winner',
        'toss_decision',
        'match_result',
        'player_of_match',
        'match_datetime',
        'stream_url',
        'stream_platform',
        'is_streaming',
        'scorer_code',
        'scorer_id',
        'scorer_name',
        'creator_name',
        'user_id',
    ];

    public function scorer()
    {
        return $this->belongsTo(User::class, 'scorer_id');
    }

    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }

    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }

    public function playerStats()
    {
        return $this->hasMany(MatchPlayerStat::class)->with('player');
    }

    public function events()
    {
        return $this->hasMany(LiveMatchEvent::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title) . '-' . Str::lower(Str::random(5));
        return $slug;
    }

    public function getEmbedUrlAttribute()
    {
        if (!$this->stream_url) {
            return null;
        }

        // YouTube URL converter
        if (str_contains($this->stream_url, 'youtube.com') || str_contains($this->stream_url, 'youtu.be')) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->stream_url, $match);
            if (isset($match[1])) {
                return 'https://www.youtube.com/embed/' . $match[1] . '?autoplay=1&mute=0';
            }
        }

        // Facebook Video embed
        if (str_contains($this->stream_url, 'facebook.com')) {
            return 'https://www.facebook.com/plugins/video.php?href=' . urlencode($this->stream_url) . '&show_text=0';
        }

        return $this->stream_url;
    }
}


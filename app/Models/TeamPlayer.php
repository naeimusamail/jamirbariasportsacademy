<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'trainee_id',
        'name',
        'jersey_no',
        'role',
        'position',
        'batting_style',
        'bowling_style',
        'is_captain',
        'is_vice_captain',
        'photo',
        'status',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function matchStats()
    {
        return $this->hasMany(MatchPlayerStat::class);
    }

    public function galleries()
    {
        return $this->hasMany(PlayerGallery::class);
    }

    // Career Performance Aggregates
    public function getCareerStatsAttribute()
    {
        $stats = $this->matchStats;
        $matches = $stats->pluck('live_match_id')->unique()->count();
        $inns = $stats->where('balls_faced', '>', 0)->count();
        $notOuts = $stats->where('dismissal_type', 'not out')->count();
        $runs = $stats->sum('runs_scored');
        $balls = $stats->sum('balls_faced');
        $fours = $stats->sum('fours');
        $sixes = $stats->sum('sixes');
        $highestScore = $stats->max('runs_scored') ?? 0;
        
        $dismissals = max(1, $inns - $notOuts);
        $battingAvg = $inns > 0 ? round($runs / $dismissals, 2) : 0;
        $strikeRate = $balls > 0 ? round(($runs / $balls) * 100, 2) : 0;
        $fifties = $stats->where('runs_scored', '>=', 50)->where('runs_scored', '<', 100)->count();
        $hundreds = $stats->where('runs_scored', '>=', 100)->count();

        // Bowling
        $wickets = $stats->sum('wickets_taken');
        $runsConceded = $stats->sum('runs_conceded');
        $overs = $stats->sum('overs_bowled');
        $maidens = $stats->sum('maidens');
        $economy = $overs > 0 ? round($runsConceded / $overs, 2) : 0.00;
        
        // Best bowling
        $bestMatch = $stats->sortByDesc('wickets_taken')->sortBy('runs_conceded')->first();
        $bestBowling = ($bestMatch && $bestMatch->wickets_taken > 0) ? "{$bestMatch->wickets_taken}/{$bestMatch->runs_conceded}" : '-';

        // Football / General
        $goals = $stats->sum('goals');
        $assists = $stats->sum('assists');
        $yellowCards = $stats->sum('yellow_cards');
        $redCards = $stats->sum('red_cards');
        $minutesPlayed = $stats->sum('minutes_played');
        $cleanSheets = $stats->where('clean_sheet', true)->count();

        // Badminton / Racquet Sports
        $setsWon = $stats->sum('sets_won');
        $pointsScored = $stats->sum('points_scored');

        // Athletics / Racing / Track & Field
        $bestTiming = $stats->whereNotNull('timing_record')->pluck('timing_record')->first() ?? '-';
        $topRank = $stats->whereNotNull('position_rank')->pluck('position_rank')->first() ?? '-';

        return (object)[
            'matches' => $matches,
            'innings' => $inns,
            'not_outs' => $notOuts,
            'runs' => $runs,
            'balls' => $balls,
            'fours' => $fours,
            'sixes' => $sixes,
            'highest_score' => $highestScore,
            'batting_avg' => $battingAvg,
            'strike_rate' => $strikeRate,
            'fifties' => $fifties,
            'hundreds' => $hundreds,
            'wickets' => $wickets,
            'runs_conceded' => $runsConceded,
            'overs' => $overs,
            'maidens' => $maidens,
            'economy' => $economy,
            'best_bowling' => $bestBowling,
            // Football
            'goals' => $goals,
            'assists' => $assists,
            'yellow_cards' => $yellowCards,
            'red_cards' => $redCards,
            'minutes_played' => $minutesPlayed,
            'clean_sheets' => $cleanSheets,
            // Badminton
            'sets_won' => $setsWon,
            'points_scored' => $pointsScored,
            // Athletics
            'best_timing' => $bestTiming,
            'top_rank' => $topRank,
        ];
    }
}


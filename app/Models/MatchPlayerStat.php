<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchPlayerStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_match_id',
        'team_id',
        'team_player_id',
        'inning',
        'batting_order',
        'dismissal_type',
        'runs_scored',
        'balls_faced',
        'fours',
        'sixes',
        'strike_rate',
        'overs_bowled',
        'maidens',
        'runs_conceded',
        'wickets_taken',
        'economy_rate',
        'dots',
        'catches',
        'run_outs',
        'stumpings',
        'goals',
        'assists',
        'yellow_cards',
        'red_cards',
        'minutes_played',
        'clean_sheet',
        'sets_won',
        'points_scored',
        'timing_record',
        'position_rank',
        'is_player_of_match',
    ];

    public function liveMatch()
    {
        return $this->belongsTo(LiveMatch::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function player()
    {
        return $this->belongsTo(TeamPlayer::class, 'team_player_id');
    }
}


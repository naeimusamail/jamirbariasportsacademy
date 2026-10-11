<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'tournament_type', // academic, local
        'sport_id',
        'sport_type',
        'banner',
        'venue',
        'registration_start_date',
        'start_date',
        'end_date',
        'registration_deadline',
        'entry_fee',
        'prize_pool',
        'total_teams',
        'status', // upcoming, ongoing, completed
        'rules',
        'description',
    ];

    protected $casts = [
        'registration_start_date' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_deadline' => 'datetime',
        'entry_fee' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($tournament) {
            if (empty($tournament->slug)) {
                $tournament->slug = Str::slug($tournament->name) . '-' . rand(100, 999);
            }
        });

        static::created(function ($tournament) {
            $tournament->syncRegistrationCircular();
        });

        static::updated(function ($tournament) {
            $tournament->syncRegistrationCircular();
        });

        static::deleted(function ($tournament) {
            RegistrationCircular::where('tournament_id', $tournament->id)
                ->orWhere('type', 'tournament_' . $tournament->id)
                ->delete();
        });
    }

    public function circular()
    {
        return $this->hasOne(RegistrationCircular::class, 'tournament_id');
    }

    /**
     * Automatically create or sync registration circular for this tournament / event
     */
    public function syncRegistrationCircular(): RegistrationCircular
    {
        return RegistrationCircular::updateOrCreate(
            [
                'tournament_id' => $this->id,
            ],
            [
                'type' => 'tournament_' . $this->id,
                'title' => $this->name . ' - প্লেয়ার নিবন্ধন সার্কুলার',
                'description' => $this->description ?: ($this->name . ' টুর্নামেন্টে অংশগ্রহণের জন্য খেলোয়াড় ও দল নিবন্ধন সার্কুলার। ভেন্যু: ' . $this->venue),
                'is_active' => ($this->status !== 'completed'),
                'start_date' => $this->registration_start_date,
                'end_date' => $this->registration_deadline,
                'upcoming_message' => $this->name . ' টুর্নামেন্টের নিবন্ধন খুব শীঘ্রই শুরু হবে।',
                'closed_message' => $this->name . ' টুর্নামেন্টের নিবন্ধন সময়সীমা সমাপ্ত হয়েছে।',
            ]
        );
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function tournamentTeams()
    {
        return $this->hasMany(TournamentTeam::class)->orderByDesc('points');
    }

    public function tournamentPlayers()
    {
        return $this->hasMany(TournamentPlayer::class)->latest();
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'tournament_teams')
            ->withPivot(['id', 'group_name', 'points', 'matches_played', 'won', 'lost', 'drawn'])
            ->withTimestamps();
    }

    public function matches()
    {
        return $this->hasMany(LiveMatch::class)->orderBy('match_datetime', 'asc');
    }

    public function scopeAcademic($query)
    {
        return $query->where('tournament_type', 'academic');
    }

    public function scopeLocal($query)
    {
        return $query->where('tournament_type', 'local');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    public function getTypeNameAttribute(): string
    {
        return $this->tournament_type === 'academic' ? 'একাডেমিক টুর্নামেন্ট' : 'উন্মুক্ত / লোকাল টুর্নামেন্ট';
    }

    public function isRegistrationOpen(): bool
    {
        if ($this->status === 'completed') {
            return false;
        }

        if ($this->registration_start_date && now()->lt($this->registration_start_date)) {
            return false;
        }

        if ($this->registration_deadline) {
            return now()->lte($this->registration_deadline);
        }

        if ($this->start_date) {
            return now()->lte($this->start_date->endOfDay());
        }

        return true;
    }

    public function isRegistrationUpcoming(): bool
    {
        if ($this->status === 'completed') {
            return false;
        }

        return (bool) ($this->registration_start_date && now()->lt($this->registration_start_date));
    }

    public function isRegistrationClosed(): bool
    {
        return !$this->isRegistrationOpen() && !$this->isRegistrationUpcoming();
    }

    public function isUpcoming(): bool
    {
        if ($this->status === 'upcoming') {
            return true;
        }
        if ($this->start_date && $this->start_date->isFuture()) {
            return true;
        }
        return false;
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'ongoing' => ['label' => 'চলমান (Live)', 'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30'],
            'completed' => ['label' => 'সমাপ্ত', 'class' => 'bg-gray-500/10 text-gray-400 border-gray-500/30'],
            default => ['label' => 'আসন্ন (Upcoming)', 'class' => 'bg-amber-500/10 text-amber-400 border-amber-500/30'],
        };
    }

    /**
     * Recalculate Points Table based on finished matches
     */
    public function recalculatePointsTable()
    {
        $teams = TournamentTeam::where('tournament_id', $this->id)->get();
        foreach ($teams as $tt) {
            $tt->update([
                'matches_played' => 0,
                'won' => 0,
                'lost' => 0,
                'drawn' => 0,
                'points' => 0,
            ]);
        }

        $finishedMatches = $this->matches()->where('status', 'finished')->get();

        foreach ($finishedMatches as $match) {
            if (!$match->team_a_id || !$match->team_b_id) {
                continue;
            }

            $ttA = TournamentTeam::where('tournament_id', $this->id)->where('team_id', $match->team_a_id)->first();
            $ttB = TournamentTeam::where('tournament_id', $this->id)->where('team_id', $match->team_b_id)->first();

            if (!$ttA || !$ttB) {
                continue;
            }

            $ttA->matches_played += 1;
            $ttB->matches_played += 1;

            $winner = null;
            if ($match->match_result) {
                if (str_contains($match->match_result, $match->team_a) || str_contains($match->match_result, 'টিম ক')) {
                    $winner = 'A';
                } elseif (str_contains($match->match_result, $match->team_b) || str_contains($match->match_result, 'টিম খ')) {
                    $winner = 'B';
                } elseif (str_contains($match->match_result, 'ড্র') || str_contains($match->match_result, 'টাই') || str_contains($match->match_result, 'Draw') || str_contains($match->match_result, 'Tie')) {
                    $winner = 'draw';
                }
            }

            if (!$winner && is_numeric($match->team_a_score) && is_numeric($match->team_b_score)) {
                $scoreA = (float) $match->team_a_score;
                $scoreB = (float) $match->team_b_score;
                if ($scoreA > $scoreB) $winner = 'A';
                elseif ($scoreB > $scoreA) $winner = 'B';
                else $winner = 'draw';
            }

            $winPoints = ($this->sport_type === 'football' ? 3 : 2);

            if ($winner === 'A') {
                $ttA->won += 1;
                $ttA->points += $winPoints;
                $ttB->lost += 1;
            } elseif ($winner === 'B') {
                $ttB->won += 1;
                $ttB->points += $winPoints;
                $ttA->lost += 1;
            } else {
                $ttA->drawn += 1;
                $ttB->drawn += 1;
                $ttA->points += 1;
                $ttB->points += 1;
            }

            $ttA->save();
            $ttB->save();
        }
    }

    public function getTopBatsmenAttribute()
    {
        return MatchPlayerStat::whereHas('liveMatch', function ($q) {
                $q->where('tournament_id', $this->id);
            })
            ->selectRaw('team_player_id, team_id, sum(runs_scored) as total_runs, sum(fours) as total_fours, sum(sixes) as total_sixes, count(*) as matches_played')
            ->whereNotNull('team_player_id')
            ->groupBy('team_player_id', 'team_id')
            ->having('total_runs', '>', 0)
            ->orderByDesc('total_runs')
            ->with(['player', 'team'])
            ->take(5)
            ->get();
    }

    public function getTopBowlersAttribute()
    {
        return MatchPlayerStat::whereHas('liveMatch', function ($q) {
                $q->where('tournament_id', $this->id);
            })
            ->selectRaw('team_player_id, team_id, sum(wickets_taken) as total_wickets, sum(runs_conceded) as total_runs_conceded, count(*) as matches_played')
            ->whereNotNull('team_player_id')
            ->groupBy('team_player_id', 'team_id')
            ->having('total_wickets', '>', 0)
            ->orderByDesc('total_wickets')
            ->with(['player', 'team'])
            ->take(5)
            ->get();
    }

    public function getTopGoalScorersAttribute()
    {
        return MatchPlayerStat::whereHas('liveMatch', function ($q) {
                $q->where('tournament_id', $this->id);
            })
            ->selectRaw('team_player_id, team_id, sum(goals) as total_goals, sum(assists) as total_assists, count(*) as matches_played')
            ->whereNotNull('team_player_id')
            ->groupBy('team_player_id', 'team_id')
            ->having('total_goals', '>', 0)
            ->orderByDesc('total_goals')
            ->with(['player', 'team'])
            ->take(5)
            ->get();
    }

    /**
     * Financial Ledger Relations and Calculations
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class)->latest('expense_date');
    }

    public function getTotalExpensesAttribute(): float
    {
        return (float) $this->expenses()->sum('amount');
    }

    public function getVolunteerExpensesAttribute(): float
    {
        return (float) $this->expenses()->where('category', 'volunteer_allowance')->sum('amount');
    }

    public function getGearExpensesAttribute(): float
    {
        return (float) $this->expenses()->whereIn('category', ['cricket_balls', 'sports_gear'])->sum('amount');
    }

    public function getTotalIncomeAttribute(): float
    {
        $teamsCount = $this->tournamentTeams()->count();
        return (float) ($this->entry_fee * $teamsCount);
    }

    public function getNetBalanceAttribute(): float
    {
        return $this->total_income - $this->total_expenses;
    }
}

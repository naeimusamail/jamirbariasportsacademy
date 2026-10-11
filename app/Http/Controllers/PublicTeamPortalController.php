<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamPlayer;
use App\Models\LiveMatch;

class PublicTeamPortalController extends Controller
{
    /**
     * Public Teams Directory (সকল টিমের তালিকা)
     */
    public function teamsIndex(Request $request)
    {
        $query = Team::with(['sport', 'players'])->withCount('players');

        if ($request->filled('sport')) {
            $query->where('sport_type', $request->sport);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $teams = $query->where('status', 'active')->orderBy('name')->get();

        return view('teams.index', compact('teams'));
    }

    /**
     * Public Team Profile & Squad (টিমের প্রোফাইল ও স্কোয়াড)
     */
    public function teamShow($slug)
    {
        $team = Team::with(['sport', 'players' => function($q) {
            $q->where('status', 'active')
              ->orderByDesc('is_captain')
              ->orderByDesc('is_vice_captain')
              ->orderBy('jersey_no');
        }])->where('slug', $slug)->firstOrFail();

        // Recent & upcoming matches for this team
        $matches = LiveMatch::where('team_a_id', $team->id)
            ->orWhere('team_b_id', $team->id)
            ->orWhere('team_a', $team->name)
            ->orWhere('team_b', $team->name)
            ->latest('match_datetime')
            ->take(6)
            ->get();

        return view('teams.show', compact('team', 'matches'));
    }

    /**
     * Public Cricinfo-style Player Profile & Performance (প্লেয়ার পারফরম্যান্স পোর্টাল)
     */
    public function playerShow($id)
    {
        $player = TeamPlayer::with(['team.sport', 'trainee.galleries', 'matchStats.liveMatch', 'galleries'])->findOrFail($id);
        
        $careerStats = $player->career_stats;
        $matchLogs = $player->matchStats()->with('liveMatch')->latest()->paginate(10);

        $galleries = $player->galleries->merge($player->trainee ? $player->trainee->galleries : collect())->unique('id')->sortByDesc('created_at');

        return view('players.show', compact('player', 'careerStats', 'matchLogs', 'galleries'));
    }
}


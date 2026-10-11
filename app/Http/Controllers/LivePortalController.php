<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveMatch;

class LivePortalController extends Controller
{
    /**
     * Public Live Match Center (পাবলিক লাইভ পোর্টাল)
     */
    public function index(Request $request)
    {
        $query = LiveMatch::query();

        if ($request->filled('sport')) {
            $query->where('sport_type', $request->sport);
        }

        $liveMatches = (clone $query)->where('status', 'live')->latest('match_datetime')->get();
        $upcomingMatches = (clone $query)->where('status', 'upcoming')->orderBy('match_datetime')->take(6)->get();
        $finishedMatches = (clone $query)->where('status', 'finished')->latest('match_datetime')->take(6)->get();

        return view('live.index', compact('liveMatches', 'upcomingMatches', 'finishedMatches'));
    }

    /**
     * Public Live Match View Screen (ক্রিকইনফো স্টাইল স্কোরকার্ড ও লাইভ সম্প্রচার পেজ)
     */
    public function show($slug)
    {
        $match = LiveMatch::with([
            'teamA.players' => function($q) { $q->orderBy('jersey_no'); },
            'teamB.players' => function($q) { $q->orderBy('jersey_no'); },
            'playerStats.player.team',
        ])->where('slug', $slug)->firstOrFail();

        $events = $match->events()->get();

        // Organize Cricinfo Scorecard by Innings
        $inning1Stats = $match->playerStats->where('inning', 1);
        $inning2Stats = $match->playerStats->where('inning', 2);

        return view('live.show', compact('match', 'events', 'inning1Stats', 'inning2Stats'));
    }

    /**
     * JSON Endpoint for Real-time Auto-Polling
     */
    public function apiScore($slug)
    {
        $match = LiveMatch::where('slug', $slug)->firstOrFail();
        $events = $match->events()->take(25)->get();

        return response()->json([
            'status' => $match->status,
            'team_a' => $match->team_a,
            'team_a_score' => $match->team_a_score,
            'team_b' => $match->team_b,
            'team_b_score' => $match->team_b_score,
            'current_summary' => $match->current_summary,
            'is_streaming' => (bool)$match->is_streaming,
            'embed_url' => $match->embed_url,
            'events' => $events->map(function ($ev) {
                return [
                    'id' => $ev->id,
                    'time_marker' => $ev->time_marker,
                    'event_type' => $ev->event_type,
                    'title' => $ev->title,
                    'description' => $ev->description,
                    'created_at' => $ev->created_at->diffForHumans(),
                ];
            }),
        ]);
    }
}

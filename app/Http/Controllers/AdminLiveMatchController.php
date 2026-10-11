<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveMatch;
use App\Models\LiveMatchEvent;
use App\Models\Team;
use App\Models\MatchPlayerStat;
use App\Models\User;
use App\Models\Tournament;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminLiveMatchController extends Controller
{
    /**
     * Check if current user or session has scorer authority for this match
     */
    protected function authorizeScoring(LiveMatch $match)
    {
        // 1. If match is finished, scorer PIN is expired and ONLY Admin can score or edit
        if ($match->status === 'finished') {
            session()->forget("scorer_authenticated_match_{$match->id}");
            if (!auth()->check() || !auth()->user()->isAdmin()) {
                abort(403, 'ম্যাচ সমাপ্ত হয়েছে এবং স্কোরার পিনের মেয়াদ উত্তীর্ণ (PIN Expired) হয়ে গেছে। শুধুমাত্র একাডেমি এডমিন সমাপ্ত ম্যাচের স্কোর পরিচালনা করতে পারবেন।');
            }
            return;
        }

        // 2. For active or upcoming matches
        $hasPinAccess = session("scorer_authenticated_match_{$match->id}") === true;
        $isAuthorizedUser = auth()->check() && (
            auth()->user()->isAdmin() || 
            auth()->user()->isScorer() || 
            auth()->user()->isCoach() || 
            auth()->id() === $match->scorer_id
        );

        if (!$isAuthorizedUser && !$hasPinAccess) {
            abort(403, 'অননুমোদিত অ্যাক্সেস। শুধুমাত্র অনুমোদিত স্কোরার বা এডমিন স্কোর পরিচালনা করতে পারবেন।');
        }
    }

    /**
     * Admin & Scorer Match List
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = LiveMatch::with(['scorer', 'tournament'])->latest('match_datetime');

        if ($user && $user->isScorer()) {
            // For scorer, show their assigned matches at top or all matches
            $matches = $query->paginate(12);
        } else {
            $matches = $query->paginate(12);
        }

        $scorers = User::where('role', 'scorer')->get();

        return view('admin.matches.index', compact('matches', 'scorers'));
    }

    /**
     * Admin Create Match Form
     */
    public function create()
    {
        $teams = Team::where('status', 'active')->orderBy('name')->get();
        $scorers = User::where('role', 'scorer')->orWhere('role', 'admin')->get();
        $tournaments = Tournament::latest()->get();
        $suggestedCode = strtoupper(Str::random(6));

        return view('admin.matches.create', compact('teams', 'scorers', 'tournaments', 'suggestedCode'));
    }

    /**
     * Admin Store Match
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sport_type' => 'required|in:football,cricket,badminton,other',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'tournament_name' => 'nullable|string|max:255',
            'team_a_id' => 'nullable|exists:teams,id',
            'team_b_id' => 'nullable|exists:teams,id',
            'team_a' => 'required_without:team_a_id|nullable|string|max:255',
            'team_b' => 'required_without:team_b_id|nullable|string|max:255',
            'venue' => 'required|string|max:255',
            'match_datetime' => 'nullable|date',
            'toss_winner' => 'nullable|string|max:255',
            'toss_decision' => 'nullable|in:bat,field',
            'stream_url' => 'nullable|url|max:500',
            'scorer_id' => 'nullable|exists:users,id',
            'scorer_code' => 'nullable|string|max:50',
        ]);

        $teamA = $validated['team_a'] ?? null;
        if (!empty($validated['team_a_id'])) {
            $tA = Team::find($validated['team_a_id']);
            if ($tA) $teamA = $tA->name;
        }

        $teamB = $validated['team_b'] ?? null;
        if (!empty($validated['team_b_id'])) {
            $tB = Team::find($validated['team_b_id']);
            if ($tB) $teamB = $tB->name;
        }

        $scorerUser = null;
        if (!empty($validated['scorer_id'])) {
            $scorerUser = User::find($validated['scorer_id']);
        }

        $slug = LiveMatch::generateUniqueSlug($validated['title']);
        $scorerCode = !empty($validated['scorer_code']) 
            ? trim($validated['scorer_code']) 
            : strtoupper(Str::random(6));

        $match = LiveMatch::create([
            'slug' => $slug,
            'title' => $validated['title'],
            'sport_type' => $validated['sport_type'],
            'tournament_id' => $validated['tournament_id'] ?? null,
            'is_official' => true,
            'tournament_name' => $validated['tournament_name'] ?? 'জামিরবাড়িয়া স্পোর্টস একাডেমি টুর্নামেন্ট',
            'team_a' => $teamA,
            'team_a_id' => $validated['team_a_id'] ?? null,
            'team_a_score' => $validated['sport_type'] == 'cricket' ? '0/0 (0.0)' : '0',
            'team_b' => $teamB,
            'team_b_id' => $validated['team_b_id'] ?? null,
            'team_b_score' => $validated['sport_type'] == 'cricket' ? '0/0 (0.0)' : '0',
            'status' => 'upcoming',
            'current_summary' => 'ম্যাচ শীঘ্রই শুরু হবে',
            'venue' => $validated['venue'],
            'toss_winner' => $validated['toss_winner'] ?? null,
            'toss_decision' => $validated['toss_decision'] ?? null,
            'match_datetime' => $validated['match_datetime'] ?? now(),
            'stream_url' => $validated['stream_url'] ?? null,
            'is_streaming' => !empty($validated['stream_url']),
            'scorer_code' => $scorerCode,
            'scorer_id' => $scorerUser ? $scorerUser->id : null,
            'scorer_name' => $scorerUser ? $scorerUser->name : null,
            'creator_name' => auth()->user()->name,
            'user_id' => auth()->id(),
        ]);

        LiveMatchEvent::create([
            'live_match_id' => $match->id,
            'time_marker' => '00',
            'event_type' => 'commentary',
            'title' => 'ম্যাচ সূচি তৈরি সম্পন্ন',
            'description' => "জামিরবাড়িয়া একাডেমি এডমিন প্যানেল থেকে {$match->team_a} বনাম {$match->team_b} ম্যাচের সূচি নির্ধারণ করা হয়েছে। স্কোরার হিসেবে নিযুক্ত: " . ($scorerUser ? $scorerUser->name : 'অফিশিয়াল একাডেমি স্কোরার'),
        ]);

        return redirect()->route('matches.scorer', $match->slug)
            ->with('success', "লাইভ ম্যাচ তৈরি সম্পন্ন হয়েছে! স্কোরার এক্সেস পিন: {$scorerCode}");
    }

    /**
     * Edit Match Configuration
     */
    public function edit(LiveMatch $match)
    {
        $teams = Team::where('status', 'active')->orderBy('name')->get();
        $scorers = User::where('role', 'scorer')->orWhere('role', 'admin')->get();
        $tournaments = Tournament::latest()->get();

        return view('admin.matches.edit', compact('match', 'teams', 'scorers', 'tournaments'));
    }

    /**
     * Update Match Configuration
     */
    public function update(Request $request, LiveMatch $match)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sport_type' => 'required|in:football,cricket,badminton,other',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'tournament_name' => 'nullable|string|max:255',
            'team_a_id' => 'nullable|exists:teams,id',
            'team_b_id' => 'nullable|exists:teams,id',
            'team_a' => 'required_without:team_a_id|nullable|string|max:255',
            'team_b' => 'required_without:team_b_id|nullable|string|max:255',
            'venue' => 'required|string|max:255',
            'match_datetime' => 'nullable|date',
            'status' => 'required|in:upcoming,live,finished',
            'stream_url' => 'nullable|url|max:500',
            'scorer_id' => 'nullable|exists:users,id',
            'scorer_code' => 'required|string|max:50',
        ]);

        $teamA = $validated['team_a'] ?? $match->team_a;
        if (!empty($validated['team_a_id'])) {
            $tA = Team::find($validated['team_a_id']);
            if ($tA) $teamA = $tA->name;
        }

        $teamB = $validated['team_b'] ?? $match->team_b;
        if (!empty($validated['team_b_id'])) {
            $tB = Team::find($validated['team_b_id']);
            if ($tB) $teamB = $tB->name;
        }

        $scorerUser = !empty($validated['scorer_id']) ? User::find($validated['scorer_id']) : null;

        $match->update([
            'title' => $validated['title'],
            'sport_type' => $validated['sport_type'],
            'tournament_id' => $validated['tournament_id'] ?? null,
            'tournament_name' => $validated['tournament_name'] ?? $match->tournament_name,
            'team_a' => $teamA,
            'team_a_id' => $validated['team_a_id'] ?? null,
            'team_b' => $teamB,
            'team_b_id' => $validated['team_b_id'] ?? null,
            'venue' => $validated['venue'],
            'match_datetime' => $validated['match_datetime'] ?? $match->match_datetime,
            'status' => $validated['status'],
            'stream_url' => $validated['stream_url'] ?? null,
            'is_streaming' => !empty($validated['stream_url']),
            'scorer_code' => trim($validated['scorer_code']),
            'scorer_id' => $scorerUser ? $scorerUser->id : null,
            'scorer_name' => $scorerUser ? $scorerUser->name : $match->scorer_name,
        ]);

        return redirect()->route('matches.index')->with('success', 'ম্যাচের তথ্য ও নির্ধারিত স্কোরার সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Admin Quick Create Scorer User
     */
    public function storeScorer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $scorer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'scorer',
        ]);

        return back()->with('success', "নতুন স্কোরার একাউন্ট সফলভাবে তৈরি হয়েছে! ইমেইল: {$scorer->email}");
    }

    /**
     * Quick Access Scorer Console with PIN / Code
     */
    public function quickAccess(Request $request, $slug)
    {
        $match = LiveMatch::where('slug', $slug)->firstOrFail();
        $code = $request->query('code');

        // If match is finished, scorer PIN is expired and only admin can access
        if ($match->status === 'finished') {
            session()->forget("scorer_authenticated_match_{$match->id}");
            if (auth()->check() && auth()->user()->isAdmin()) {
                return redirect()->route('matches.scorer', $match->slug);
            }
            return redirect()->route('live.show', $match->slug)
                ->with('error', 'ম্যাচ সমাপ্ত হয়েছে এবং স্কোরার পিনের মেয়াদ উত্তীর্ণ (PIN Expired) হয়ে গেছে। শুধুমাত্র একাডেমি এডমিন স্কোর পরিচালনা করতে পারবেন।');
        }

        if ($code && trim($code) === $match->scorer_code) {
            session(["scorer_authenticated_match_{$match->id}" => true]);
            return redirect()->route('matches.scorer', $match->slug)
                ->with('success', 'স্কোরার কোড সফলভাবে যাচাই করা হয়েছে! এখন স্কোর আপডেট করতে পারবেন।');
        }

        // If user is already authenticated with appropriate role
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isScorer() || auth()->user()->isCoach() || auth()->id() === $match->scorer_id)) {
            return redirect()->route('matches.scorer', $match->slug);
        }

        return view('scorer.enter-pin', compact('match'));
    }

    /**
     * Verify PIN form submission
     */
    public function verifyPin(Request $request, $slug)
    {
        $match = LiveMatch::where('slug', $slug)->firstOrFail();

        // If match is finished, reject immediately with expired message
        if ($match->status === 'finished') {
            session()->forget("scorer_authenticated_match_{$match->id}");
            return back()->withErrors(['scorer_code' => 'ম্যাচ সমাপ্ত হওয়ায় স্কোরার পিনের মেয়াদ উত্তীর্ণ (PIN Expired) হয়ে গেছে! শুধুমাত্র একাডেমি এডমিন এটি পরিচালনা করতে পারবেন।']);
        }

        $request->validate(['scorer_code' => 'required|string']);

        if (trim($request->scorer_code) === $match->scorer_code) {
            session(["scorer_authenticated_match_{$match->id}" => true]);
            return redirect()->route('matches.scorer', $match->slug)
                ->with('success', 'স্কোরার পিন কোড সফলভাবে যাচাই হয়েছে!');
        }

        return back()->withErrors(['scorer_code' => 'প্রদত্ত স্কোরার পিন কোডটি সঠিক নয়! অনুগ্রহ করে সঠিক কোড দিন।']);
    }

    /**
     * Admin & Scorer Console
     */
    public function scorer(Request $request, $slug)
    {
        $match = LiveMatch::with(['teamA.players', 'teamB.players', 'playerStats.player', 'scorer'])
            ->where('slug', $slug)
            ->firstOrFail();

        $this->authorizeScoring($match);

        $events = $match->events()->get();

        return view('admin.matches.scorer', compact('match', 'events'));
    }

    /**
     * Update Score via Ajax
     */
    public function updateScore(Request $request, $slug)
    {
        $match = LiveMatch::where('slug', $slug)->firstOrFail();
        $this->authorizeScoring($match);

        $validated = $request->validate([
            'team_a_score' => 'required|string',
            'team_b_score' => 'required|string',
            'current_summary' => 'nullable|string',
            'status' => 'required|in:upcoming,live,finished',
            'stream_url' => 'nullable|string',
            'is_streaming' => 'nullable|boolean',
        ]);

        $match->team_a_score = $validated['team_a_score'];
        $match->team_b_score = $validated['team_b_score'];
        $match->status = $validated['status'];
        
        if ($request->has('current_summary')) {
            $match->current_summary = $validated['current_summary'];
        }

        if ($request->has('stream_url')) {
            $match->stream_url = $validated['stream_url'];
            $match->is_streaming = !empty($validated['stream_url']);
        }

        if ($request->has('is_streaming')) {
            $match->is_streaming = (bool)$request->is_streaming;
        }

        $match->save();

        if ($match->status === 'finished') {
            session()->forget("scorer_authenticated_match_{$match->id}");
        }

        if ($match->tournament_id && $match->tournament) {
            $match->tournament->recalculatePointsTable();
        }

        return response()->json(['success' => true, 'match' => $match]);
    }

    /**
     * Add Commentary / Event via Ajax
     */
    public function addEvent(Request $request, $slug)
    {
        $match = LiveMatch::where('slug', $slug)->firstOrFail();
        $this->authorizeScoring($match);

        $validated = $request->validate([
            'time_marker' => 'nullable|string|max:50',
            'event_type' => 'required|in:goal,wicket,four,six,card,foul,substitution,commentary,break',
            'title' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $event = LiveMatchEvent::create([
            'live_match_id' => $match->id,
            'time_marker' => $validated['time_marker'] ?? '',
            'event_type' => $validated['event_type'],
            'title' => $validated['title'] ?? '',
            'description' => $validated['description'],
        ]);

        return response()->json(['success' => true, 'event' => $event]);
    }

    /**
     * Delete Match (Admin Only)
     */
    public function destroy(LiveMatch $match)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'শুধুমাত্র একাডেমি এডমিন ম্যাচ মুছে ফেলতে পারবেন।');
        }
        $match->delete();
        return back()->with('success', 'ম্যাচ মুছে ফেলা হয়েছে!');
    }

    /**
     * Cricinfo Scorecard: Add or Update Player Match Performance
     */
    public function addPlayerStat(Request $request, $slug)
    {
        $match = LiveMatch::where('slug', $slug)->firstOrFail();
        $this->authorizeScoring($match);

        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'team_player_id' => 'required|exists:team_players,id',
            'inning' => 'required|integer|in:1,2',
            'runs_scored' => 'nullable|integer|min:0',
            'balls_faced' => 'nullable|integer|min:0',
            'fours' => 'nullable|integer|min:0',
            'sixes' => 'nullable|integer|min:0',
            'dismissal_type' => 'nullable|string|max:100',
            'overs_bowled' => 'nullable|numeric|min:0',
            'maidens' => 'nullable|integer|min:0',
            'runs_conceded' => 'nullable|integer|min:0',
            'wickets_taken' => 'nullable|integer|min:0',
            'goals' => 'nullable|integer|min:0',
            'assists' => 'nullable|integer|min:0',
            'yellow_cards' => 'nullable|integer|min:0',
            'red_cards' => 'nullable|integer|min:0',
            'minutes_played' => 'nullable|integer|min:0',
            'clean_sheet' => 'nullable|boolean',
            'sets_won' => 'nullable|integer|min:0',
            'points_scored' => 'nullable|integer|min:0',
            'timing_record' => 'nullable|string|max:50',
            'position_rank' => 'nullable|string|max:100',
            'is_player_of_match' => 'nullable|boolean',
        ]);

        $balls = $validated['balls_faced'] ?? 0;
        $runs = $validated['runs_scored'] ?? 0;
        $strikeRate = $balls > 0 ? round(($runs / $balls) * 100, 2) : 0.00;

        $overs = (float)($validated['overs_bowled'] ?? 0.0);
        $runsConceded = (int)($validated['runs_conceded'] ?? 0);
        $economy = $overs > 0 ? round($runsConceded / $overs, 2) : 0.00;

        $stat = MatchPlayerStat::updateOrCreate(
            [
                'live_match_id' => $match->id,
                'team_id' => $validated['team_id'],
                'team_player_id' => $validated['team_player_id'],
                'inning' => $validated['inning'],
            ],
            [
                'runs_scored' => $runs,
                'balls_faced' => $balls,
                'fours' => $validated['fours'] ?? 0,
                'sixes' => $validated['sixes'] ?? 0,
                'strike_rate' => $strikeRate,
                'dismissal_type' => $validated['dismissal_type'] ?? 'not out',
                'overs_bowled' => $overs,
                'maidens' => $validated['maidens'] ?? 0,
                'runs_conceded' => $runsConceded,
                'wickets_taken' => $validated['wickets_taken'] ?? 0,
                'economy_rate' => $economy,
                // Football
                'goals' => $validated['goals'] ?? 0,
                'assists' => $validated['assists'] ?? 0,
                'yellow_cards' => $validated['yellow_cards'] ?? 0,
                'red_cards' => $validated['red_cards'] ?? 0,
                'minutes_played' => $validated['minutes_played'] ?? 0,
                'clean_sheet' => $request->boolean('clean_sheet'),
                // Badminton
                'sets_won' => $validated['sets_won'] ?? 0,
                'points_scored' => $validated['points_scored'] ?? 0,
                // Athletics & other
                'timing_record' => $validated['timing_record'] ?? null,
                'position_rank' => $validated['position_rank'] ?? null,
                'is_player_of_match' => $request->boolean('is_player_of_match'),
            ]
        );

        if ($request->boolean('is_player_of_match')) {
            $player = TeamPlayer::find($validated['team_player_id']);
            $match->update(['player_of_match' => $player ? $player->name : null]);
        }

        return back()->with('success', 'স্কোরকার্ডে প্লেয়ারের পারফরম্যান্স রেকর্ড সংরক্ষিত হয়েছে!');
    }

    /**
     * Cricinfo Scorecard: Delete Player Stat
     */
    public function deletePlayerStat($slug, MatchPlayerStat $stat)
    {
        $match = LiveMatch::where('slug', $slug)->firstOrFail();
        $this->authorizeScoring($match);

        $stat->delete();
        return back()->with('info', 'প্লেয়ার স্কোর রেকর্ড ডিলিট করা হয়েছে!');
    }

    /**
     * Update Match Metadata (Toss, Result, Player of Match)
     */
    public function updateMatchMeta(Request $request, $slug)
    {
        $match = LiveMatch::where('slug', $slug)->firstOrFail();
        $this->authorizeScoring($match);

        $validated = $request->validate([
            'toss_winner' => 'nullable|string|max:255',
            'toss_decision' => 'nullable|string|max:50',
            'match_result' => 'nullable|string|max:255',
            'player_of_match' => 'nullable|string|max:255',
        ]);

        $match->update($validated);

        return back()->with('success', 'ম্যাচের টস ও ফলাফল তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }
}

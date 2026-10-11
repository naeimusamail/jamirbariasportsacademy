<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Models\Team;
use App\Models\Sport;
use App\Models\LiveMatch;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\TournamentPlayer;
use App\Models\TeamPlayer;
use App\Models\User;
use App\Models\Trainee;
use App\Models\LiveMatchEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TournamentController extends Controller
{
    /**
     * 🌐 PUBLIC TOURNAMENT HUB
     * Dedicated sector featuring Left-side Category / Sport filters
     */
    public function publicIndex(Request $request)
    {
        $query = Tournament::with(['sport', 'teams'])->withCount('matches');

        // Type filter: all, academic, local
        if ($request->filled('type') && in_array($request->type, ['academic', 'local'])) {
            $query->where('tournament_type', $request->type);
        }

        // Sport filter
        if ($request->filled('sport')) {
            $query->where('sport_type', $request->sport);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%")
                  ->orWhere('prize_pool', 'like', "%{$search}%");
            });
        }

        $tournaments = $query->latest('start_date')->paginate(9)->withQueryString();
        $sports = Sport::all();

        // Counts for left sidebar categories
        $academicCount = Tournament::where('tournament_type', 'academic')->count();
        $localCount = Tournament::where('tournament_type', 'local')->count();
        $ongoingCount = Tournament::where('status', 'ongoing')->count();
        $upcomingCount = Tournament::where('status', 'upcoming')->count();
        $totalCount = Tournament::count();

        // Featured ongoing tournaments for hero
        $featuredTournaments = Tournament::where('status', 'ongoing')
            ->with(['teams', 'matches'])
            ->take(2)
            ->get();

        return view('tournaments.index', compact(
            'tournaments',
            'sports',
            'academicCount',
            'localCount',
            'ongoingCount',
            'upcomingCount',
            'totalCount',
            'featuredTournaments'
        ));
    }

    /**
     * 🌐 PUBLIC TOURNAMENT DETAILS
     * Match fixtures, points table, participating teams
     */
    public function publicShow($slug)
    {
        $tournament = Tournament::where('slug', $slug)
            ->with([
                'sport',
                'tournamentTeams.team',
                'matches.teamA',
                'matches.teamB',
                'tournamentPlayers.team',
            ])
            ->firstOrFail();

        $allTeams = Team::all();

        return view('tournaments.show', compact('tournament', 'allTeams'));
    }

    /**
     * 🌐 PUBLIC: Show Tournament Player Registration Page
     */
    public function showPlayerRegistration($slug)
    {
        $tournament = Tournament::where('slug', $slug)
            ->with('tournamentTeams.team')
            ->firstOrFail();

        if ($tournament->isRegistrationUpcoming()) {
            $startText = $tournament->registration_start_date ? $tournament->registration_start_date->format('d M Y, h:i A') : 'শীঘ্রই';
            return redirect()->route('public.tournaments.show', $tournament->slug)
                ->with('error', "এই টুর্নামেন্টের রেজিস্ট্রেশন আগামী {$startText} থেকে শুরু হবে!");
        }

        if (!$tournament->isRegistrationOpen()) {
            return redirect()->route('public.tournaments.show', $tournament->slug)
                ->with('error', 'এই টুর্নামেন্টের রেজিস্ট্রেশন সময়সীমা সমাপ্ত হয়েছে!');
        }

        $teams = $tournament->teams;

        return view('tournaments.register', compact('tournament', 'teams'));
    }

    /**
     * 🌐 PUBLIC: Store Tournament Player Registration
     * Requires Player account (logs in if existing user, creates User with role=player if new)
     * Players without team can register without team (team_id=null)
     */
    public function storePlayerRegistration(Request $request, $slug)
    {
        $tournament = Tournament::where('slug', $slug)->firstOrFail();

        if ($tournament->isRegistrationUpcoming()) {
            $startText = $tournament->registration_start_date ? $tournament->registration_start_date->format('d M Y, h:i A') : 'শীঘ্রই';
            return back()->with('error', "এই টুর্নামেন্টের রেজিস্ট্রেশন এখনও শুরু হয়নি! শুরুর সময়: {$startText}");
        }

        if (!$tournament->isRegistrationOpen()) {
            return back()->with('error', 'এই টুর্নামেন্টের রেজিস্ট্রেশনের সময়সীমা শেষ হয়ে গেছে!');
        }

        // Validate player info
        $rules = [
            'player_name' => 'required|string|max:255',
            'player_phone' => 'required|string|max:20',
            'position' => 'nullable|string|max:100',
            'jersey_no' => 'nullable|string|max:10',
            'team_id' => 'nullable|exists:teams,id',
            'notes' => 'nullable|string|max:500',
        ];

        // If not logged in, require account creation or login credentials
        if (!Auth::check()) {
            $rules['account_action'] = 'required|in:register,login';

            if ($request->account_action === 'login') {
                $rules['login_email'] = 'required|string';
                $rules['login_password'] = 'required|string';
            } else {
                $rules['email'] = 'required|string|email|max:255|unique:users,email';
                $rules['password'] = 'required|string|min:6|confirmed';
                $rules['username'] = 'nullable|string|max:50|alpha_dash|unique:users,username';
            }
        }

        $validated = $request->validate($rules);

        // Handle authentication if guest
        $user = Auth::user();
        if (!$user) {
            if ($request->account_action === 'login') {
                $loginField = filter_var($request->login_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
                if (!Auth::attempt([$loginField => $request->login_email, 'password' => $request->login_password])) {
                    return back()->withErrors(['login_email' => 'লগইন তথ্য সঠিক নয়। সঠিক ইমেইল/ইউজারনেম ও পাসওয়ার্ড দিন।'])->withInput();
                }
                $user = Auth::user();
            } else {
                $baseUsername = $request->username ?: Str::slug(explode('@', $request->email)[0]);
                $username = $baseUsername;
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }

                $user = User::create([
                    'name' => $validated['player_name'],
                    'username' => $username,
                    'email' => $validated['email'],
                    'password' => Hash::make($request->password),
                    'role' => 'player',
                ]);

                Auth::login($user);
            }
        }

        // Prevent duplicate registration in the same tournament
        $existing = TournamentPlayer::where('tournament_id', $tournament->id)
            ->where(function ($q) use ($user, $validated) {
                $q->where('user_id', $user->id)
                  ->orWhere('player_phone', $validated['player_phone']);
            })
            ->first();

        if ($existing) {
            return redirect()->route('public.tournaments.show', $tournament->slug)
                ->with('error', 'আপনি ইতোমধ্যেই এই টুর্নামেন্টে নিবন্ধিত হয়েছেন!');
        }

        // Find linked Trainee if exists
        $traineeId = $user->trainee_id ?? null;
        if (!$traineeId) {
            $matchedTrainee = Trainee::where('phone', $validated['player_phone'])->first();
            if ($matchedTrainee) {
                $traineeId = $matchedTrainee->id;
            }
        }

        // Create Tournament Player
        $teamId = !empty($validated['team_id']) ? $validated['team_id'] : null;

        $tournPlayer = TournamentPlayer::create([
            'tournament_id' => $tournament->id,
            'user_id' => $user->id,
            'trainee_id' => $traineeId,
            'team_id' => $teamId,
            'player_name' => $validated['player_name'],
            'player_phone' => $validated['player_phone'],
            'position' => $validated['position'] ?? null,
            'jersey_no' => $validated['jersey_no'] ?? null,
            'status' => $teamId ? 'assigned' : 'registered',
            'notes' => $validated['notes'] ?? null,
        ]);

        // If player has a team, register into team_players table if not exists
        if ($teamId) {
            TeamPlayer::firstOrCreate([
                'team_id' => $teamId,
                'name' => $validated['player_name'],
            ], [
                'trainee_id' => $traineeId,
                'jersey_no' => $validated['jersey_no'] ?? null,
                'position' => $validated['position'] ?? 'Player',
                'role' => $validated['position'] ?? 'All-Rounder',
                'status' => 'active',
            ]);
        }

        $msg = $teamId 
            ? 'অভিনন্দন! টুর্নামেন্টে দলসহ আপনার খেলোয়াড় নিবন্ধন সফল হয়েছে।' 
            : 'অভিনন্দন! আপনার টুর্নামেন্ট খেলোয়াড় নিবন্ধন সম্পন্ন হয়েছে। ড্রাফট/টিম সিলেকশনের সময় অ্যাডমিন আপনাকে উপযুক্ত দলে যুক্ত করবেন।';

        return redirect()->route('public.tournaments.show', $tournament->slug)->with('success', $msg);
    }

    /**
     * 🛡️ ADMIN: Tournament Management Index
     */
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $query = Tournament::with(['sport', 'teams'])->withCount('matches');

        if ($request->filled('type')) {
            $query->where('tournament_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tournaments = $query->latest()->paginate(12)->withQueryString();

        return view('admin.tournaments.index', compact('tournaments'));
    }

    /**
     * 🛡️ ADMIN: Create Tournament Form
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $sports = Sport::all();
        return view('admin.tournaments.create', compact('sports'));
    }

    /**
     * 🛡️ ADMIN: Store Tournament
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tournament_type' => 'required|in:academic,local',
            'sport_id' => 'nullable|exists:sports,id',
            'sport_type' => 'required|string|max:50',
            'venue' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'registration_start_date' => 'nullable|date',
            'registration_deadline' => 'nullable|date',
            'entry_fee' => 'nullable|numeric|min:0',
            'prize_pool' => 'nullable|string|max:255',
            'total_teams' => 'required|integer|min:2|max:64',
            'status' => 'required|in:upcoming,ongoing,completed',
            'rules' => 'nullable|string',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('tournaments', 'public');
        }

        $tournament = Tournament::create($validated);

        return redirect()->route('admin.tournaments.show', $tournament)
            ->with('success', 'নতুন টুর্নামেন্ট সফলভাবে যুক্ত করা হয়েছে!');
    }

    /**
     * 🛡️ ADMIN: Show & Manage Tournament
     */
    public function show(Tournament $tournament)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $tournament->load([
            'sport',
            'tournamentTeams.team',
            'matches.teamA',
            'matches.teamB',
            'tournamentPlayers.team',
            'tournamentPlayers.user',
        ]);

        $availableTeams = Team::where('sport_type', $tournament->sport_type)
            ->whereNotIn('id', $tournament->tournamentTeams->pluck('team_id'))
            ->get();

        return view('admin.tournaments.show', compact('tournament', 'availableTeams'));
    }

    /**
     * 🛡️ ADMIN: Edit Tournament Form
     */
    public function edit(Tournament $tournament)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $sports = Sport::all();
        return view('admin.tournaments.edit', compact('tournament', 'sports'));
    }

    /**
     * 🛡️ ADMIN: Update Tournament
     */
    public function update(Request $request, Tournament $tournament)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tournament_type' => 'required|in:academic,local',
            'sport_id' => 'nullable|exists:sports,id',
            'sport_type' => 'required|string|max:50',
            'venue' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'registration_start_date' => 'nullable|date',
            'registration_deadline' => 'nullable|date',
            'entry_fee' => 'nullable|numeric|min:0',
            'prize_pool' => 'nullable|string|max:255',
            'total_teams' => 'required|integer|min:2|max:64',
            'status' => 'required|in:upcoming,ongoing,completed',
            'rules' => 'nullable|string',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('tournaments', 'public');
        }

        $tournament->update($validated);

        return redirect()->route('admin.tournaments.index')
            ->with('success', 'টুর্নামেন্টের তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * 🛡️ ADMIN: Delete Tournament
     */
    public function destroy(Tournament $tournament)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $tournament->delete();

        return redirect()->route('admin.tournaments.index')
            ->with('success', 'টুর্নামেন্ট মুছে ফেলা হয়েছে!');
    }

    /**
     * 🛡️ ADMIN: Add Team to Tournament
     */
    public function addTeam(Request $request, Tournament $tournament)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'group_name' => 'nullable|string|max:20',
        ]);

        TournamentTeam::firstOrCreate([
            'tournament_id' => $tournament->id,
            'team_id' => $request->team_id,
        ], [
            'group_name' => $request->group_name ?: 'গ্রুপ ক',
        ]);

        return back()->with('success', 'দলটি টুর্নামেন্টে সফলভাবে যুক্ত করা হয়েছে!');
    }

    /**
     * 🛡️ ADMIN: Remove Team from Tournament
     */
    public function removeTeam(Tournament $tournament, Team $team)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        TournamentTeam::where('tournament_id', $tournament->id)
            ->where('team_id', $team->id)
            ->delete();

        return back()->with('success', 'দলটি টুর্নামেন্ট থেকে অপসারণ করা হয়েছে!');
    }

    /**
     * 🛡️ ADMIN: Generate Basic Fixture Schedule between Start and End dates
     */
    public function generateSchedule(Request $request, Tournament $tournament)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $teams = $tournament->teams;

        if ($teams->count() < 2) {
            return back()->with('error', 'শিডিউল তৈরির জন্য অন্তত ২টি দল টুর্নামেন্টে অন্তর্ভুক্ত থাকতে হবে!');
        }

        // Collect unique pairings (Round Robin style or single matchups)
        $pairings = [];
        $teamList = $teams->values();
        $count = $teamList->count();

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $pairings[] = [
                    'team_a' => $teamList[$i],
                    'team_b' => $teamList[$j],
                ];
            }
        }

        $totalMatches = count($pairings);
        if ($totalMatches === 0) {
            return back()->with('error', 'কোনো ম্যাচ পেয়ারিং তৈরি করা সম্ভব হয়নি।');
        }

        // Calculate date distribution
        $startDate = $tournament->start_date ? Carbon::parse($tournament->start_date) : now()->addDay();
        $endDate = $tournament->end_date ? Carbon::parse($tournament->end_date) : $startDate->copy()->addDays(max(1, $totalMatches));

        $totalDays = max(1, $startDate->diffInDays($endDate));
        $intervalDays = $totalMatches > 1 ? ($totalDays / ($totalMatches - 1)) : 0;

        $createdCount = 0;

        foreach ($pairings as $idx => $pair) {
            $matchDay = $startDate->copy()->addDays((int) round($idx * $intervalDays));
            // Default match time: 15:30 (3:30 PM)
            $matchDateTime = $matchDay->setTime(15, 30);

            // Check if fixture already exists
            $exists = LiveMatch::where('tournament_id', $tournament->id)
                ->where(function ($q) use ($pair) {
                    $q->where(function ($sq) use ($pair) {
                        $sq->where('team_a_id', $pair['team_a']->id)->where('team_b_id', $pair['team_b']->id);
                    })->orWhere(function ($sq) use ($pair) {
                        $sq->where('team_a_id', $pair['team_b']->id)->where('team_b_id', $pair['team_a']->id);
                    });
                })->exists();

            if ($exists) {
                continue;
            }

            $title = "{$pair['team_a']->name} বনাম {$pair['team_b']->name}";
            $slug = LiveMatch::generateUniqueSlug($title);
            $scorerCode = strtoupper(Str::random(6));

            $match = LiveMatch::create([
                'slug' => $slug,
                'title' => $title,
                'sport_type' => in_array($tournament->sport_type, ['football', 'cricket', 'badminton']) ? $tournament->sport_type : 'football',
                'tournament_id' => $tournament->id,
                'tournament_type' => $tournament->tournament_type,
                'is_official' => true,
                'tournament_name' => $tournament->name,
                'team_a' => $pair['team_a']->name,
                'team_a_id' => $pair['team_a']->id,
                'team_a_score' => $tournament->sport_type === 'cricket' ? '0/0 (0.0)' : '0',
                'team_b' => $pair['team_b']->name,
                'team_b_id' => $pair['team_b']->id,
                'team_b_score' => $tournament->sport_type === 'cricket' ? '0/0 (0.0)' : '0',
                'status' => 'upcoming',
                'current_summary' => 'আপকামিং ম্যাচ - সময়সূচি নির্ধারিত',
                'venue' => $tournament->venue,
                'match_datetime' => $matchDateTime,
                'scorer_code' => $scorerCode,
                'creator_name' => auth()->user()->name,
                'user_id' => auth()->id(),
            ]);

            LiveMatchEvent::create([
                'live_match_id' => $match->id,
                'time_marker' => '00',
                'event_type' => 'commentary',
                'title' => 'ফিক্সচার তৈরি',
                'description' => 'টুর্নামেন্ট সিডিউল অনুযায়ী ম্যাচটি অন্তর্ভুক্ত করা হয়েছে।',
            ]);

            $createdCount++;
        }

        return back()->with('success', "মোট {$createdCount}টি আপকামিং ম্যাচ শিডিউলে সফলভাবে তৈরি করা হয়েছে!");
    }

    /**
     * 🛡️ ADMIN: Update Match Schedule (Date, Time, Venue, Status)
     */
    public function updateMatchSchedule(Request $request, Tournament $tournament, LiveMatch $match)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'match_datetime' => 'required|date',
            'venue' => 'required|string|max:255',
            'status' => 'required|in:upcoming,live,finished',
        ]);

        $match->update($validated);

        return back()->with('success', 'ম্যাচের সময়সূচি ও ভেন্যু সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * 🛡️ ADMIN: Assign Team to Registered Free Agent / Player without Team
     */
    public function assignPlayerTeam(Request $request, Tournament $tournament, TournamentPlayer $player)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
        ]);

        $team = Team::findOrFail($validated['team_id']);

        $player->update([
            'team_id' => $team->id,
            'status' => 'assigned',
        ]);

        // Sync into TeamPlayer roster if not exists
        TeamPlayer::firstOrCreate([
            'team_id' => $team->id,
            'name' => $player->player_name,
        ], [
            'trainee_id' => $player->trainee_id,
            'jersey_no' => $player->jersey_no,
            'position' => $player->position ?: 'Player',
            'role' => $player->position ?: 'All-Rounder',
            'status' => 'active',
        ]);

        return back()->with('success', "প্লেয়ার {$player->player_name}-কে '{$team->name}' দলে সফলভাবে নির্বাচন ও যুক্ত করা হয়েছে!");
    }
}

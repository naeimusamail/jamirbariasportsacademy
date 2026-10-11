<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamPlayer;
use App\Models\Sport;
use App\Models\Trainee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    /**
     * Admin: Team List
     */
    public function index(Request $request)
    {
        $query = Team::with(['sport', 'players'])->withCount('players');

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_name', 'like', "%{$search}%")
                  ->orWhere('coach_name', 'like', "%{$search}%");
            });
        }

        $teams = $query->latest()->paginate(12)->withQueryString();
        $sports = Sport::all();

        return view('admin.teams.index', compact('teams', 'sports'));
    }

    /**
     * Admin: Create Team Form
     */
    public function create()
    {
        $sports = Sport::all()->unique('name');
        return view('admin.teams.create', compact('sports'));
    }

    /**
     * Admin: Store Team
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:10',
            'sport_id' => 'required|exists:sports,id',
            'category' => 'required|in:U-12,U-14,U-16,U-19,Senior',
            'coach_name' => 'nullable|string|max:255',
            'captain_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'cropped_logo' => 'nullable|string',
        ]);

        $sport = Sport::findOrFail($validated['sport_id']);
        $slug = Team::generateUniqueSlug($validated['name']);

        $logoPath = null;
        if ($request->filled('cropped_logo') && str_starts_with($request->cropped_logo, 'data:image')) {
            $image_parts = explode(";base64,", $request->cropped_logo);
            if (isset($image_parts[1])) {
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'teams/' . Str::random(40) . '.png';
                Storage::disk('public')->put($filename, $image_base64);
                $logoPath = $filename;
            }
        } elseif ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('teams', 'public');
        }

        $team = Team::create([
            'name' => $validated['name'],
            'short_name' => $validated['short_name'] ?? strtoupper(substr($validated['name'], 0, 3)),
            'slug' => $slug,
            'sport_id' => $validated['sport_id'],
            'sport_type' => strtolower($sport->name) == 'cricket' || str_contains(strtolower($sport->name), 'ক্রিকেট') ? 'cricket' : 'football',
            'category' => $validated['category'],
            'coach_name' => $validated['coach_name'] ?? null,
            'captain_name' => $validated['captain_name'] ?? null,
            'description' => $validated['description'] ?? null,
            'logo' => $logoPath,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.teams.show', $team)
            ->with('success', 'নতুন টিম সফলভাবে তৈরি হয়েছে! এখন টিমে প্লেয়ার যোগ করুন।');
    }

    /**
     * Admin: Team Details & Squad Management
     */
    public function show(Team $team)
    {
        $team->load(['sport', 'players' => function($q) {
            $q->orderByDesc('is_captain')->orderByDesc('is_vice_captain')->orderBy('name');
        }]);

        // Available trainees (Academic + Local Tournament Players) to add to squad
        $traineesQuery = Trainee::with(['sports', 'sport'])->where('status', 'active');
        if ($team->sport_id) {
            $sportId = $team->sport_id;
            $traineesQuery->where(function ($q) use ($sportId) {
                $q->where('sport_id', $sportId)
                  ->orWhereHas('sports', function ($sq) use ($sportId) {
                      $sq->where('sports.id', $sportId);
                  });
            });
        }
        $trainees = $traineesQuery->orderBy('name')->get();

        return view('admin.teams.show', compact('team', 'trainees'));
    }

    /**
     * Admin: Edit Team Form
     */
    public function edit(Team $team)
    {
        $sports = Sport::all();
        return view('admin.teams.edit', compact('team', 'sports'));
    }

    /**
     * Admin: Update Team
     */
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:10',
            'sport_id' => 'required|exists:sports,id',
            'category' => 'required|in:U-12,U-14,U-16,U-19,Senior',
            'coach_name' => 'nullable|string|max:255',
            'captain_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'matches_played' => 'nullable|integer|min:0',
            'matches_won' => 'nullable|integer|min:0',
            'matches_lost' => 'nullable|integer|min:0',
            'matches_drawn' => 'nullable|integer|min:0',
            'points' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'cropped_logo' => 'nullable|string',
        ]);

        $sport = Sport::findOrFail($validated['sport_id']);

        if ($request->filled('cropped_logo') && str_starts_with($request->cropped_logo, 'data:image')) {
            if ($team->logo && Storage::disk('public')->exists($team->logo)) {
                Storage::disk('public')->delete($team->logo);
            }
            $image_parts = explode(";base64,", $request->cropped_logo);
            if (isset($image_parts[1])) {
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'teams/' . Str::random(40) . '.png';
                Storage::disk('public')->put($filename, $image_base64);
                $validated['logo'] = $filename;
            }
        } elseif ($request->hasFile('logo')) {
            if ($team->logo && Storage::disk('public')->exists($team->logo)) {
                Storage::disk('public')->delete($team->logo);
            }
            $validated['logo'] = $request->file('logo')->store('teams', 'public');
        }

        unset($validated['cropped_logo']);

        $validated['sport_type'] = strtolower($sport->name) == 'cricket' || str_contains(strtolower($sport->name), 'ক্রিকেট') ? 'cricket' : 'football';

        $team->update($validated);

        return redirect()->route('admin.teams.show', $team)
            ->with('success', 'টিমের তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Admin: Delete Team
     */
    public function destroy(Team $team)
    {
        if ($team->logo && Storage::disk('public')->exists($team->logo)) {
            Storage::disk('public')->delete($team->logo);
        }

        $team->delete();

        return redirect()->route('admin.teams.index')
            ->with('success', 'টিম সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Admin: Add Player to Squad
     */
    public function addPlayer(Request $request, Team $team)
    {
        $validated = $request->validate([
            'trainee_id' => 'nullable|exists:trainees,id',
            'name' => 'required_without:trainee_id|nullable|string|max:255',
            'jersey_no' => 'nullable|string|max:10',
            'role' => 'required|string|max:100',
            'position' => 'nullable|string|max:100',
            'batting_style' => 'nullable|string|max:100',
            'bowling_style' => 'nullable|string|max:100',
            'is_captain' => 'nullable|boolean',
            'is_vice_captain' => 'nullable|boolean',
        ]);

        $name = $validated['name'] ?? null;
        $photo = null;
        $traineeId = $validated['trainee_id'] ?? null;

        if ($traineeId) {
            $trainee = Trainee::find($traineeId);
            if ($trainee) {
                $name = $trainee->name;
                $photo = $trainee->photo;
                if (empty($validated['jersey_no'])) {
                    $validated['jersey_no'] = $trainee->jersey_no;
                }
            }
        }

        if ($request->boolean('is_captain')) {
            // Remove previous captain
            $team->players()->update(['is_captain' => false]);
            $team->update(['captain_name' => $name]);
        }

        if ($request->boolean('is_vice_captain')) {
            $team->players()->update(['is_vice_captain' => false]);
        }

        $team->players()->create([
            'trainee_id' => $traineeId,
            'name' => $name,
            'jersey_no' => $validated['jersey_no'] ?? null,
            'role' => $validated['role'],
            'position' => $validated['position'] ?? null,
            'batting_style' => $validated['batting_style'] ?? null,
            'bowling_style' => $validated['bowling_style'] ?? null,
            'is_captain' => $request->boolean('is_captain'),
            'is_vice_captain' => $request->boolean('is_vice_captain'),
            'photo' => $photo,
            'status' => 'active',
        ]);

        return back()->with('success', "{$name} কে সফলভাবে টিমের স্কোয়াডে যুক্ত করা হয়েছে!");
    }

    /**
     * Admin: Remove Player from Squad
     */
    public function removePlayer(Team $team, TeamPlayer $player)
    {
        $playerName = $player->name;
        $player->delete();

        return back()->with('info', "{$playerName} কে স্কোয়াড থেকে বাদ দেওয়া হয়েছে।");
    }
}


<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Coach;
use App\Models\Trainee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form / role settings.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // If player, redirect/provide player profile link
        $trainee = $user->trainee ?: Trainee::first();
        $coach = $user->coach ?: Coach::first();

        return view('profile.edit', compact('user', 'trainee', 'coach'));
    }

    /**
     * Dedicated Player / Athlete Profile View
     */
    public function playerProfile($id = null): View
    {
        $user = auth()->user();
        if ($id) {
            $trainee = Trainee::findOrFail($id);
        } else {
            $trainee = $user->trainee ?: Trainee::first();
        }

        if (!$trainee) {
            abort(404, 'প্লেয়ার রেকর্ড পাওয়া যায়নি।');
        }

        $trainee->load([
            'sport',
            'sports',
            'teamPlayers.team',
            'batch.coach',
            'certificates',
            'latestFitness',
            'fitnessRecords' => function($q) { $q->latest('test_date')->take(6); },
            'attendances' => function($q) { $q->latest('date')->take(10); },
            'trainingTasks' => function($q) { $q->latest('due_date')->take(6); },
            'payments' => function($q) { $q->latest('payment_date')->take(6); },
            'galleries' => function($q) { $q->latest(); }
        ]);

        $totalAttendance = $trainee->attendances()->count();
        $presentAttendance = $trainee->attendances()->where('status', 'present')->count();
        $attendanceRate = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 1) : 100;

        return view('profile.player', compact('trainee', 'attendanceRate', 'totalAttendance', 'presentAttendance'));
    }

    /**
     * Dedicated Coach Profile View
     */
    public function coachProfile($id = null): View
    {
        $user = auth()->user();
        if ($id) {
            $coach = Coach::findOrFail($id);
        } else {
            $coach = $user->coach ?: Coach::first();
        }

        if (!$coach) {
            abort(404, 'কোচ রেকর্ড পাওয়া যায়নি।');
        }

        $coach->load([
            'sport',
            'batches.trainees',
            'batches.sport',
            'trainingTasks' => function($q) { $q->latest('due_date')->take(8); }
        ]);

        $totalPlayers = Trainee::whereIn('batch_id', $coach->batches->pluck('id'))->count();

        return view('profile.coach', compact('coach', 'totalPlayers'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

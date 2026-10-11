<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrationCircular;
use App\Models\Tournament;

class AdminRegistrationCircularController extends Controller
{
    /**
     * Display all registration circulars and tournament schedules
     */
    public function index()
    {
        // Ensure default circulars exist
        $types = ['admission', 'volunteer', 'local_player'];
        foreach ($types as $type) {
            RegistrationCircular::ofType($type);
        }

        // Auto-ensure all created events / tournaments have a circular
        $allTournaments = Tournament::all();
        foreach ($allTournaments as $t) {
            if (!$t->circular()->exists()) {
                $t->syncRegistrationCircular();
            }
        }

        $circulars = RegistrationCircular::with('tournament')
            ->withCount('admissionApplications')
            ->orderBy('id', 'desc')
            ->get();
        $tournaments = Tournament::latest()->take(10)->get();

        return view('admin.circulars.index', compact('circulars', 'tournaments'));
    }

    /**
     * Store a new custom circular (e.g. new admission batch or campaign)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:admission,volunteer,local_player',
            'description' => 'nullable|string',
            'fee' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'upcoming_message' => 'nullable|string|max:1000',
            'closed_message' => 'nullable|string|max:1000',
        ]);

        $validated['type'] = $request->input('type', 'admission');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['start_date'] = $request->filled('start_date') ? $request->start_date : null;
        $validated['end_date'] = $request->filled('end_date') ? $request->end_date : null;

        $circular = RegistrationCircular::create($validated);

        return back()->with('success', "নতুন সার্কুলার '{$circular->title}' সফলভাবে তৈরি ও প্রকাশ করা হয়েছে!");
    }

    /**
     * Update circular start, deadline date/times, status and notices
     */
    public function update(Request $request, $id)
    {
        $circular = RegistrationCircular::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fee' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'upcoming_message' => 'nullable|string|max:1000',
            'closed_message' => 'nullable|string|max:1000',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Clean null dates if empty string passed
        $validated['start_date'] = $request->filled('start_date') ? $request->start_date : null;
        $validated['end_date'] = $request->filled('end_date') ? $request->end_date : null;

        $circular->update($validated);

        // If this circular is tied to an event/tournament, sync the tournament dates too
        if ($circular->tournament_id && $circular->tournament) {
            $circular->tournament->withoutEvents(function () use ($circular, $validated) {
                $circular->tournament->update([
                    'registration_start_date' => $validated['start_date'],
                    'registration_deadline' => $validated['end_date'],
                ]);
            });
        }

        return back()->with('success', "{$circular->type_name}-এর সার্কুলার সময়সূচি ও স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে!");
    }

    /**
     * Fast toggle active / paused status
     */
    public function toggleActive($id)
    {
        $circular = RegistrationCircular::findOrFail($id);
        $circular->is_active = !$circular->is_active;
        $circular->save();

        $statusText = $circular->is_active ? 'সক্রিয় (Active)' : 'সাময়িক স্থগিত (Paused)';
        return back()->with('success', "{$circular->type_name}-এর স্ট্যাটাস {$statusText} করা হয়েছে!");
    }

    /**
     * Delete circular
     */
    public function destroy($id)
    {
        $circular = RegistrationCircular::findOrFail($id);

        if ($circular->tournament_id) {
            return back()->with('error', 'টুর্নামেন্ট সার্কুলার সরাসরি ডিলিট করা যাবে না। টুর্নামেন্ট ডিলিট করলে এটি স্বয়ংক্রিয়ভাবে মুছে যাবে।');
        }

        $circular->delete();

        return back()->with('success', 'সার্কুলারটি সফলভাবে মুছে ফেলা হয়েছে!');
    }
}


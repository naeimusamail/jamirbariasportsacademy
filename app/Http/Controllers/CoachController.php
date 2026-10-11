<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\Sport;

class CoachController extends Controller
{
    public function index()
    {
        $coaches = Coach::with(['sport', 'batches'])->latest()->paginate(10);
        return view('coaches.index', compact('coaches'));
    }

    public function create()
    {
        $sports = Sport::all()->unique('name');
        return view('coaches.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'designation' => 'required|string|max:255',
            'experience' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Coach::create($validated);

        return redirect()->route('coaches.index')
            ->with('success', 'নতুন কোচ সফলভাবে যুক্ত করা হয়েছে!');
    }

    public function edit(Coach $coach)
    {
        $sports = Sport::all()->unique('name');
        return view('coaches.edit', compact('coach', 'sports'));
    }

    public function update(Request $request, Coach $coach)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'designation' => 'required|string|max:255',
            'experience' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $coach->update($validated);

        return redirect()->route('coaches.index')
            ->with('success', 'কোচের তথ্য আপডেট করা হয়েছে!');
    }

    public function destroy(Coach $coach)
    {
        $coach->delete();

        return redirect()->route('coaches.index')
            ->with('success', 'কোচ তালিকা থেকে মুছে ফেলা হয়েছে!');
    }
}


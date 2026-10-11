<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Sport;
use App\Models\Coach;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with(['sport', 'coach'])
            ->withCount('trainees')
            ->latest()
            ->paginate(12);

        return view('batches.index', compact('batches'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'ট্রেনিং ব্যাচ তৈরি ও শিডিউল নির্ধারণ শুধুমাত্র একাডেমি অ্যাডমিনের এখতিয়ার।');
        }

        $sports = Sport::all()->unique('name');
        $coaches = Coach::where('status', 'active')->get();

        return view('batches.create', compact('sports', 'coaches'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'অননুমোদিত অ্যাক্সেস। শুধুমাত্র অ্যাডমিন নতুন ব্যাচ তৈরি করতে পারেন।');
        }

        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'coach_id' => 'nullable|exists:coaches,id',
            'name' => 'required|string|max:255',
            'days' => 'required|string|max:255',
            'time_slot' => 'required|string|max:255',
            'ground' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        Batch::create($validated);

        return redirect()->route('batches.index')
            ->with('success', 'নতুন ট্রেনিং ব্যাচ সফলভাবে যুক্ত করা হয়েছে এবং কোচ নির্ধারণ করা হয়েছে!');
    }

    public function show(Batch $batch)
    {
        $batch->load(['sport', 'coach', 'trainees']);
        return view('batches.show', compact('batch'));
    }

    public function edit(Batch $batch)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'শুধুমাত্র একাডেমি অ্যাডমিন ব্যাচের তথ্য ও দায়িত্বপ্রাপ্ত কোচ পরিবর্তন করতে পারেন।');
        }

        $sports = Sport::all();
        $coaches = Coach::where('status', 'active')->get();

        return view('batches.edit', compact('batch', 'sports', 'coaches'));
    }

    public function update(Request $request, Batch $batch)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'অননুমোদিত অ্যাক্সেস।');
        }

        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'coach_id' => 'nullable|exists:coaches,id',
            'name' => 'required|string|max:255',
            'days' => 'required|string|max:255',
            'time_slot' => 'required|string|max:255',
            'ground' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $batch->update($validated);

        return redirect()->route('batches.index')
            ->with('success', 'ব্যাচের তথ্য ও দায়িত্বপ্রাপ্ত কোচ সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy(Batch $batch)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'অননুমোদিত অ্যাক্সেস।');
        }

        $batch->delete();

        return redirect()->route('batches.index')
            ->with('success', 'ব্যাচ মুছে ফেলা হয়েছে!');
    }
}


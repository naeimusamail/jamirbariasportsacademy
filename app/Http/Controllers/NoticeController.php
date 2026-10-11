<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\Sport;

class NoticeController extends Controller
{
    /**
     * 📢 Public Notice Board & Registration Circulars Hub (আলাদা ডেডিকেটেড পেজ)
     */
    public function publicHub(Request $request)
    {
        $allCirculars = \App\Models\RegistrationCircular::with('tournament.sport')
            ->orderByRaw("CASE 
                WHEN is_active = 1 AND (start_date IS NULL OR start_date <= NOW()) AND (end_date IS NULL OR end_date >= NOW()) THEN 1
                WHEN is_active = 1 AND start_date > NOW() THEN 2
                ELSE 3
            END ASC")
            ->latest('updated_at')
            ->get();

        $noticesQuery = Notice::with('sport')
            ->orderByDesc('is_pinned')
            ->latest('notice_date')
            ->latest('id');

        if ($request->filled('sport_id')) {
            $noticesQuery->where('sport_id', $request->sport_id);
        }

        $notices = $noticesQuery->paginate(12)->withQueryString();
        $sports = Sport::all();

        return view('notices.public-hub', compact('allCirculars', 'notices', 'sports'));
    }

    public function index()
    {
        $notices = Notice::with('sport')
            ->orderBy('is_pinned', 'desc')
            ->latest('notice_date')
            ->paginate(10);

        return view('notices.index', compact('notices'));
    }

    public function create()
    {
        $sports = Sport::all();
        return view('notices.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'nullable|exists:sports,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'notice_date' => 'required|date',
            'is_pinned' => 'nullable|boolean',
        ]);

        $validated['is_pinned'] = $request->has('is_pinned');

        Notice::create($validated);

        return redirect()->route('notices.index')
            ->with('success', 'নতুন নোটিশ সফলভাবে প্রকাশ করা হয়েছে!');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return redirect()->route('notices.index')
            ->with('success', 'নোটিশ মুছে ফেলা হয়েছে!');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\Tournament;
use Illuminate\Support\Facades\Storage;

class AdminVolunteerController extends Controller
{
    /**
     * Admin Volunteers Hub & Duty Roster
     */
    public function index(Request $request)
    {
        $query = Volunteer::with('tournament')->latest();

        // Search
        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('name_en', 'like', "%{$s}%")
                  ->orWhere('volunteer_no', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Department
        if ($request->filled('department') && $request->department !== 'all') {
            $query->where('department', $request->department);
        }

        // Filter by Tournament
        if ($request->filled('tournament_id') && $request->tournament_id !== 'all') {
            $query->where('tournament_id', $request->tournament_id);
        }

        // Filter by T-shirt size
        if ($request->filled('tshirt_size') && $request->tshirt_size !== 'all') {
            $query->where('tshirt_size', $request->tshirt_size);
        }

        $volunteers = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => Volunteer::count(),
            'pending' => Volunteer::where('status', 'pending')->count(),
            'approved' => Volunteer::where('status', 'approved')->count(),
            'active' => Volunteer::where('status', 'active')->count(),
            'rejected' => Volunteer::where('status', 'rejected')->count(),
            'duty_assigned' => Volunteer::whereNotNull('assigned_duties')->where('assigned_duties', '!=', '')->count(),
        ];

        $tournaments = Tournament::latest()->get();
        $departments = Volunteer::departments();
        $tshirtSizes = Volunteer::tshirtSizes();

        return view('admin.volunteers.index', compact('volunteers', 'stats', 'tournaments', 'departments', 'tshirtSizes'));
    }

    /**
     * View Volunteer Details
     */
    public function show($id)
    {
        $volunteer = Volunteer::with('tournament')->findOrFail($id);
        $tournaments = Tournament::latest()->get();
        $departments = Volunteer::departments();

        return view('admin.volunteers.show', compact('volunteer', 'tournaments', 'departments'));
    }

    /**
     * Update Approval Status (Approve / Reject)
     */
    public function updateStatus(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,active',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $volunteer->status = $validated['status'];
        if ($validated['status'] === 'approved' && !$volunteer->approved_at) {
            $volunteer->approved_at = now();
        }
        if ($request->has('admin_notes')) {
            $volunteer->admin_notes = $validated['admin_notes'];
        }
        $volunteer->save();

        $statusBangla = [
            'approved' => 'অনুমোদিত',
            'rejected' => 'বাতিল',
            'pending' => 'অপেক্ষমাণ',
            'active' => 'সক্রিয় ডিউটিতে',
        ][$volunteer->status] ?? $volunteer->status;

        return back()->with('success', "ভলান্টিয়ার {$volunteer->name}-এর স্ট্যাটাস '{$statusBangla}' করা হয়েছে!");
    }

    /**
     * Assign Duty / Tournament / Venue
     */
    public function assignDuty(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $validated = $request->validate([
            'assigned_duties' => 'required|string|max:1000',
            'assigned_venue' => 'nullable|string|max:255',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'department' => 'nullable|string|max:100',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $volunteer->update([
            'assigned_duties' => $validated['assigned_duties'],
            'assigned_venue' => $validated['assigned_venue'] ?? $volunteer->assigned_venue,
            'tournament_id' => $validated['tournament_id'] ?? $volunteer->tournament_id,
            'department' => $validated['department'] ?? $volunteer->department,
            'admin_notes' => $validated['admin_notes'] ?? $volunteer->admin_notes,
            'status' => $volunteer->status === 'pending' ? 'approved' : $volunteer->status,
            'approved_at' => $volunteer->approved_at ?: now(),
        ]);

        return back()->with('success', "ভলান্টিয়ার {$volunteer->name}-কে দায়িত্ব ও ভেন্যু সফলভাবে বণ্টন করা হয়েছে!");
    }

    /**
     * Delete Volunteer Record
     */
    public function destroy($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        if ($volunteer->photo && Storage::disk('public')->exists($volunteer->photo)) {
            Storage::disk('public')->delete($volunteer->photo);
        }
        $volunteer->delete();

        return redirect()->route('admin.volunteers.index')
            ->with('success', 'ভলান্টিয়ার রেকর্ডটি সফলভাবে মুছে ফেলা হয়েছে!');
    }
}


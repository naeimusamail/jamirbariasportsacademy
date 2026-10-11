<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\Sport;
use App\Models\Batch;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TraineeController extends Controller
{
    public function index(Request $request)
    {
        $query = Trainee::with(['sport', 'sports', 'batch']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sport_id')) {
            $sportId = $request->sport_id;
            $query->where(function ($q) use ($sportId) {
                $q->where('sport_id', $sportId)
                  ->orWhereHas('sports', function ($sq) use ($sportId) {
                      $sq->where('sports.id', $sportId);
                  });
            });
        }

        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('player_type')) {
            $query->where('player_type', $request->player_type);
        }

        $trainees = $query->latest()->paginate(10)->withQueryString();
        $sports = Sport::all()->unique('name');
        $batches = Batch::all();

        return view('trainees.index', compact('trainees', 'sports', 'batches'));
    }

    public function create()
    {
        $sports = Sport::all()->unique('name');
        $batches = Batch::all();
        
        // Auto generate next admission number
        $lastTrainee = Trainee::latest('id')->first();
        $nextId = $lastTrainee ? $lastTrainee->id + 1 : 1;
        $defaultAdmissionNo = 'JSA-2026-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        return view('trainees.create', compact('sports', 'batches', 'defaultAdmissionNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_no' => 'required|unique:trainees,admission_no',
            'sport_id' => 'nullable|exists:sports,id',
            'sports' => 'nullable|array|min:1',
            'sports.*' => 'exists:sports,id',
            'batch_id' => 'nullable|exists:batches,id',
            'name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'emergency_phone' => 'nullable|string|max:30',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'nid_or_birth_cert' => 'nullable|string|max:50',
            'category' => 'required|in:U-12,U-14,U-16,U-19,Senior',
            'position' => 'nullable|string|max:100',
            'jersey_no' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'monthly_fee' => 'required|numeric|min:0',
            'admission_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cropped_photo' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $verificationService = app(\App\Services\PlayerDocumentVerificationService::class);
        $dupReport = $verificationService->checkDuplicate([
            'nid_or_birth_cert' => $request->input('nid_or_birth_cert'),
            'phone' => $validated['phone'],
            'name' => $validated['name'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
        ]);

        if ($dupReport['is_strict_duplicate']) {
            $firstMatch = $dupReport['matches'][0];
            $errField = ($firstMatch['field'] === 'phone') ? 'phone' : 'nid_or_birth_cert';
            return back()->withInput()->withErrors([
                $errField => $firstMatch['message']
            ]);
        }

        $selectedSports = $request->input('sports', []);
        if (empty($selectedSports) && $request->filled('sport_id')) {
            $selectedSports = [$request->sport_id];
        }

        if (empty($selectedSports)) {
            return back()->withInput()->withErrors(['sports' => 'অন্তত একটি খেলা নির্বাচন করুন।']);
        }

        $primarySportId = $request->sport_id ?: $selectedSports[0];
        $validated['sport_id'] = $primarySportId;

        if ($request->filled('cropped_photo') && str_starts_with($request->cropped_photo, 'data:image')) {
            $image_parts = explode(";base64,", $request->cropped_photo);
            if (isset($image_parts[1])) {
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'trainees/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($filename, $image_base64);
                $validated['photo'] = $filename;
            }
        } elseif ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('trainees', 'public');
        }

        unset($validated['cropped_photo'], $validated['sports']);

        $trainee = Trainee::create($validated);

        // Sync multi-sports pivot table
        $syncData = [];
        foreach ($selectedSports as $spId) {
            $syncData[$spId] = [
                'position' => $request->position,
                'jersey_no' => $request->jersey_no,
                'is_primary' => ($spId == $primarySportId),
            ];
        }
        $trainee->sports()->sync($syncData);

        return redirect()->route('trainees.show', $trainee)
            ->with('success', 'নতুন ট্রেইনি সফলভাবে ভর্তি করা হয়েছে!');
    }

    public function show(Trainee $trainee)
    {
        $trainee->load([
            'sport',
            'sports',
            'teamPlayers.team',
            'batch.coach',
            'certificates',
            'attendances' => function($q) {
                $q->latest('date')->take(10);
            },
            'payments' => function($q) {
                $q->latest('payment_date')->take(10);
            },
            'fitnessRecords' => function($q) {
                $q->latest('test_date')->take(5);
            }
        ]);

        return view('trainees.show', compact('trainee'));
    }

    public function edit(Trainee $trainee)
    {
        $trainee->load('sports');
        $sports = Sport::all();
        $batches = Batch::all();

        return view('trainees.edit', compact('trainee', 'sports', 'batches'));
    }

    public function update(Request $request, Trainee $trainee)
    {
        $validated = $request->validate([
            'admission_no' => 'required|unique:trainees,admission_no,' . $trainee->id,
            'sport_id' => 'nullable|exists:sports,id',
            'sports' => 'nullable|array|min:1',
            'sports.*' => 'exists:sports,id',
            'batch_id' => 'nullable|exists:batches,id',
            'name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'emergency_phone' => 'nullable|string|max:30',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'nid_or_birth_cert' => 'nullable|string|max:50',
            'category' => 'required|in:U-12,U-14,U-16,U-19,Senior',
            'position' => 'nullable|string|max:100',
            'jersey_no' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'monthly_fee' => 'required|numeric|min:0',
            'admission_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cropped_photo' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $verificationService = app(\App\Services\PlayerDocumentVerificationService::class);
        $dupReport = $verificationService->checkDuplicate([
            'nid_or_birth_cert' => $request->input('nid_or_birth_cert'),
            'phone' => $validated['phone'],
            'name' => $validated['name'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
        ], $trainee->id);

        if ($dupReport['is_strict_duplicate']) {
            $firstMatch = $dupReport['matches'][0];
            $errField = ($firstMatch['field'] === 'phone') ? 'phone' : 'nid_or_birth_cert';
            return back()->withInput()->withErrors([
                $errField => $firstMatch['message']
            ]);
        }

        $selectedSports = $request->input('sports', []);
        if (empty($selectedSports) && $request->filled('sport_id')) {
            $selectedSports = [$request->sport_id];
        }

        if (!empty($selectedSports)) {
            $primarySportId = $request->sport_id ?: $selectedSports[0];
            $validated['sport_id'] = $primarySportId;
        }

        if ($request->filled('cropped_photo') && str_starts_with($request->cropped_photo, 'data:image')) {
            if ($trainee->photo && Storage::disk('public')->exists($trainee->photo)) {
                Storage::disk('public')->delete($trainee->photo);
            }
            $image_parts = explode(";base64,", $request->cropped_photo);
            if (isset($image_parts[1])) {
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'trainees/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($filename, $image_base64);
                $validated['photo'] = $filename;
            }
        } elseif ($request->hasFile('photo')) {
            if ($trainee->photo && Storage::disk('public')->exists($trainee->photo)) {
                Storage::disk('public')->delete($trainee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('trainees', 'public');
        }

        unset($validated['cropped_photo'], $validated['sports']);

        $trainee->update($validated);

        if (!empty($selectedSports)) {
            $syncData = [];
            foreach ($selectedSports as $spId) {
                $syncData[$spId] = [
                    'position' => $request->position,
                    'jersey_no' => $request->jersey_no,
                    'is_primary' => ($spId == $primarySportId),
                ];
            }
            $trainee->sports()->sync($syncData);
        }

        return redirect()->route('trainees.show', $trainee)
            ->with('success', 'ট্রেইনির তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy(Trainee $trainee)
    {
        if ($trainee->photo && Storage::disk('public')->exists($trainee->photo)) {
            Storage::disk('public')->delete($trainee->photo);
        }

        $trainee->delete();

        return redirect()->route('trainees.index')
            ->with('success', 'ট্রেইনি রেকর্ড ডিলিট করা হয়েছে!');
    }

    /**
     * Display Player Annual Academic & Fitness Progress Report Card
     */
    public function reportCard(Trainee $trainee)
    {
        $trainee->load(['sport', 'sports', 'batch', 'attendances', 'fitnessRecords', 'trainingTasks', 'certificates']);

        $totalAttendances = $trainee->attendances->count();
        $presentCount = $trainee->attendances->where('status', 'present')->count();
        $lateCount = $trainee->attendances->where('status', 'late')->count();
        $absentCount = $trainee->attendances->where('status', 'absent')->count();
        $attendanceRate = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100) : 100;

        $tasksTotal = $trainee->trainingTasks->count();
        $tasksCompleted = $trainee->trainingTasks->where('status', 'completed')->count();

        $latestFitness = $trainee->latestFitness;

        return view('trainees.report-card', compact(
            'trainee',
            'totalAttendances',
            'presentCount',
            'lateCount',
            'absentCount',
            'attendanceRate',
            'tasksTotal',
            'tasksCompleted',
            'latestFitness'
        ));
    }

    /**
     * Export Trainees List to CSV
     */
    public function export(Request $request)
    {
        $query = Trainee::with(['sport', 'batch']);

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('player_type')) {
            $query->where('player_type', $request->player_type);
        }

        $trainees = $query->latest()->get();
        $filename = 'trainees_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($trainees) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel
            fputcsv($out, ['ভর্তি নং', 'নাম', 'মোবাইল', 'জরুরী মোবাইল', 'অভিভাবক', 'খেলা', 'ব্যাচ', 'ক্যাটাগরি', 'পজিশন', 'জার্সি নং', 'মাসিক ফি', 'ভর্তির তারিখ', 'স্ট্যাটাস']);
            foreach ($trainees as $t) {
                fputcsv($out, [
                    $t->admission_no,
                    $t->name,
                    $t->phone,
                    $t->emergency_phone ?? '',
                    $t->guardian_name ?? '',
                    $t->sport->name ?? '',
                    $t->batch->name ?? '',
                    $t->category ?? '',
                    $t->position ?? '',
                    $t->jersey_no ?? '',
                    $t->monthly_fee ?? 0,
                    $t->admission_date ?? '',
                    $t->status == 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়',
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }
}


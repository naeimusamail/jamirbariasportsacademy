<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FitnessRecord;
use App\Models\Trainee;
use App\Models\Sport;
use App\Models\Batch;

class PerformanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Trainee::with(['sport', 'batch', 'latestFitness'])
            ->where('status', 'active');

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%");
            });
        }

        $trainees = $query->paginate(15)->withQueryString();
        $sports = Sport::all();
        $batches = Batch::all();

        // Academy Fitness Metrics
        $totalAssessed = FitnessRecord::distinct('trainee_id')->count('trainee_id');
        $averageBmi = round(FitnessRecord::avg('bmi') ?? 0, 1);
        $fastestSprint = FitnessRecord::whereNotNull('sprint_100m_sec')->min('sprint_100m_sec');
        $topYoYo = FitnessRecord::whereNotNull('yoyo_score')->max('yoyo_score');

        return view('performances.index', compact(
            'trainees',
            'sports',
            'batches',
            'totalAssessed',
            'averageBmi',
            'fastestSprint',
            'topYoYo'
        ));
    }

    public function create(Request $request)
    {
        $trainees = Trainee::with(['sport', 'batch'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $selectedTraineeId = $request->input('trainee_id');

        return view('performances.create', compact('trainees', 'selectedTraineeId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
            'test_date' => 'required|date',
            'height_cm' => 'nullable|numeric|min:50|max:250',
            'weight_kg' => 'nullable|numeric|min:15|max:200',
            'sprint_100m_sec' => 'nullable|numeric|min:8|max:30',
            'yoyo_score' => 'nullable|string|max:50',
            'stamina_level' => 'required|in:Excellent,Good,Average,Needs Improvement',
            'matches_played' => 'nullable|integer|min:0',
            'goals_or_runs' => 'nullable|integer|min:0',
            'wickets_or_assists' => 'nullable|integer|min:0',
            'coach_rating' => 'required|integer|min:1|max:5',
            'coach_remarks' => 'nullable|string|max:1000',
        ]);

        // Auto calculate BMI if height and weight are provided
        $bmi = null;
        if (!empty($validated['height_cm']) && !empty($validated['weight_kg'])) {
            $heightMeters = $validated['height_cm'] / 100;
            $bmi = round($validated['weight_kg'] / ($heightMeters * $heightMeters), 1);
        }

        FitnessRecord::create([
            'trainee_id' => $validated['trainee_id'],
            'test_date' => $validated['test_date'],
            'height_cm' => $validated['height_cm'] ?? null,
            'weight_kg' => $validated['weight_kg'] ?? null,
            'bmi' => $bmi,
            'sprint_100m_sec' => $validated['sprint_100m_sec'] ?? null,
            'yoyo_score' => $validated['yoyo_score'] ?? null,
            'stamina_level' => $validated['stamina_level'],
            'matches_played' => $validated['matches_played'] ?? 0,
            'goals_or_runs' => $validated['goals_or_runs'] ?? 0,
            'wickets_or_assists' => $validated['wickets_or_assists'] ?? 0,
            'coach_rating' => $validated['coach_rating'],
            'coach_remarks' => $validated['coach_remarks'] ?? null,
        ]);

        return redirect()->route('performances.show', $validated['trainee_id'])
            ->with('success', 'নতুন পারফরম্যান্স ও ফিটনেস রেকর্ড সংরক্ষিত হয়েছে!');
    }

    public function show($id)
    {
        $trainee = Trainee::with(['sport', 'batch.coach', 'fitnessRecords'])
            ->findOrFail($id);

        $records = $trainee->fitnessRecords;
        $latestRecord = $records->first();

        // Calculate progress summary
        $totalTests = $records->count();
        $bestSprint = $records->whereNotNull('sprint_100m_sec')->min('sprint_100m_sec');
        $averageRating = round($records->avg('coach_rating') ?? 5, 1);
        $totalGoalsOrRuns = $records->sum('goals_or_runs');
        $totalWicketsOrAssists = $records->sum('wickets_or_assists');

        return view('performances.show', compact(
            'trainee',
            'records',
            'latestRecord',
            'totalTests',
            'bestSprint',
            'averageRating',
            'totalGoalsOrRuns',
            'totalWicketsOrAssists'
        ));
    }

    public function destroy(FitnessRecord $performance)
    {
        $traineeId = $performance->trainee_id;
        $performance->delete();

        return redirect()->route('performances.show', $traineeId)
            ->with('success', 'ফিটনেস রেকর্ডটি মুছে ফেলা হয়েছে!');
    }
}


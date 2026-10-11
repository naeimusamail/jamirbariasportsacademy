<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\Batch;
use App\Models\Coach;
use App\Models\Payment;
use App\Models\Attendance;
use App\Models\Notice;
use App\Models\AdmissionApplication;
use App\Models\Expense;
use App\Models\FitnessRecord;
use App\Models\LiveMatch;
use App\Models\TeamPlayer;
use App\Models\TrainingTask;
use App\Services\QrCodeService;

class DashboardController extends Controller
{
    /**
     * Role-based dispatch for user dashboard.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isPlayer()) {
            return $this->playerDashboard($user);
        }

        if ($user->isCoach()) {
            return $this->coachDashboard($user);
        }

        if ($user->isScorer()) {
            return $this->scorerDashboard($user);
        }

        return $this->adminDashboard();
    }

    /**
     * Dedicated Player / Student Dashboard
     */
    public function playerDashboard($user = null)
    {
        $user = $user ?: auth()->user();
        $trainee = $user->trainee ?: Trainee::with(['sport', 'batch.coach'])->first();

        if (!$trainee) {
            $trainee = Trainee::first();
        }

        if ($trainee) {
            $trainee->load(['sport', 'sports', 'batch.coach', 'certificates', 'latestFitness', 'attendances' => function($q) {
                $q->latest('date')->take(10);
            }, 'payments' => function($q) {
                $q->latest('payment_date')->take(10);
            }, 'galleries' => function($q) {
                $q->latest();
            }]);

            $totalAttendance = $trainee->attendances()->count();
            $presentAttendance = $trainee->attendances()->where('status', 'present')->count();
            $attendanceRate = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 1) : 100;

            $totalPaid = $trainee->payments()->where('status', 'paid')->sum('amount');
            $duePayments = $trainee->payments()->where('status', 'due')->get();

            $teamPlayers = TeamPlayer::with('team')->where('trainee_id', $trainee->id)->orWhere('name', $trainee->name)->get();
            $teamPlayer = $teamPlayers->first();
            $team = $teamPlayer ? $teamPlayer->team : null;
            $enrolledTeams = $teamPlayers->pluck('team')->filter();

            $verifyUrl = route('public.verify.player', $trainee->admission_no);
            $qrCodeSvg = QrCodeService::svg($verifyUrl, 4);

            $trainingTasks = TrainingTask::with('coach')
                ->where(function($q) use ($trainee) {
                    $q->where('trainee_id', $trainee->id);
                    if ($trainee->batch_id) {
                        $q->orWhere('batch_id', $trainee->batch_id);
                    }
                })->latest('due_date')->take(10)->get();
        } else {
            $attendanceRate = 100;
            $totalAttendance = 0;
            $presentAttendance = 0;
            $totalPaid = 0;
            $duePayments = collect();
            $teamPlayer = null;
            $team = null;
            $enrolledTeams = collect();
            $verifyUrl = url('/');
            $qrCodeSvg = '';
            $trainingTasks = collect();
        }

        $notices = Notice::latest('notice_date')->take(4)->get();
        $upcomingMatches = LiveMatch::whereIn('status', ['upcoming', 'live'])->latest('match_datetime')->take(3)->get();

        return view('dashboards.player', compact(
            'trainee',
            'attendanceRate',
            'totalAttendance',
            'presentAttendance',
            'totalPaid',
            'duePayments',
            'teamPlayer',
            'team',
            'enrolledTeams',
            'notices',
            'upcomingMatches',
            'qrCodeSvg',
            'verifyUrl',
            'trainingTasks'
        ));
    }

    /**
     * Dedicated Coach Dashboard
     */
    public function coachDashboard($user = null)
    {
        $user = $user ?: auth()->user();
        $coach = $user->coach ?: Coach::with('sport')->first();

        $batches = Batch::with(['sport'])
            ->withCount('trainees')
            ->where('status', 'active')
            ->when($coach, function($q) use ($coach) {
                $q->where('coach_id', $coach->id);
            })
            ->get();

        if ($batches->isEmpty()) {
            $batches = Batch::with(['sport', 'coach'])->withCount('trainees')->where('status', 'active')->get();
        }

        $batchIds = $batches->pluck('id');
        $trainees = Trainee::with(['sport', 'batch'])
            ->whereIn('batch_id', $batchIds)
            ->latest()
            ->get();

        if ($trainees->isEmpty()) {
            $trainees = Trainee::with(['sport', 'batch'])->latest()->take(15)->get();
        }

        $totalPlayers = $trainees->count();

        $todayAttendanceCount = Attendance::where('date', date('Y-m-d'))
            ->whereIn('trainee_id', $trainees->pluck('id'))
            ->count();

        $todayPresentCount = Attendance::where('date', date('Y-m-d'))
            ->whereIn('trainee_id', $trainees->pluck('id'))
            ->where('status', 'present')
            ->count();

        $recentFitness = FitnessRecord::with('trainee')
            ->whereIn('trainee_id', $trainees->pluck('id'))
            ->latest('test_date')
            ->take(6)
            ->get();

        $trainingTasks = TrainingTask::with(['trainee', 'batch'])
            ->when($coach, function($q) use ($coach) {
                $q->where('coach_id', $coach->id);
            })
            ->latest()
            ->take(6)
            ->get();

        $matches = LiveMatch::latest('match_datetime')->take(4)->get();
        $notices = Notice::latest('notice_date')->take(4)->get();

        return view('dashboards.coach', compact(
            'coach',
            'batches',
            'trainees',
            'totalPlayers',
            'todayAttendanceCount',
            'todayPresentCount',
            'recentFitness',
            'trainingTasks',
            'matches',
            'notices'
        ));
    }

    /**
     * Main Academy Admin Dashboard
     */
    public function adminDashboard()
    {
        $totalTrainees = Trainee::where('status', 'active')->count();
        $totalBatches = Batch::where('status', 'active')->count();
        $totalCoaches = Coach::where('status', 'active')->count();
        
        $totalAttendanceToday = Attendance::where('date', date('Y-m-d'))->count();
        $presentToday = Attendance::where('date', date('Y-m-d'))->where('status', 'present')->count();
        $attendanceRate = $totalAttendanceToday > 0 ? round(($presentToday / $totalAttendanceToday) * 100, 1) : 100;

        $totalFeeCollectedMonth = Payment::where('status', 'paid')
            ->where('month', 'অক্টোবর')
            ->where('year', '2026')
            ->sum('amount');

        $duePaymentsCount = Payment::where('status', 'due')->count();

        $pendingAdmissionsCount = AdmissionApplication::where('status', 'pending')->count();
        $totalExpenses = Expense::sum('amount');
        $totalIncome = Payment::where('status', 'paid')->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        $totalFitnessAssessed = FitnessRecord::distinct('trainee_id')->count('trainee_id');

        $coachesList = Coach::with(['sport', 'batches.trainees'])
            ->withCount(['batches', 'trainingTasks'])
            ->get();

        $recentTrainingTasks = TrainingTask::with(['coach', 'trainee', 'batch'])
            ->latest()
            ->take(6)
            ->get();

        $batches = Batch::with(['sport', 'coach'])
            ->withCount('trainees')
            ->where('status', 'active')
            ->take(5)
            ->get();

        $recentTrainees = Trainee::with(['sport', 'batch'])
            ->latest()
            ->take(5)
            ->get();

        $recentAdmissions = AdmissionApplication::with('sport')
            ->where('status', 'pending')
            ->latest()
            ->take(4)
            ->get();

        $recentExpenses = Expense::latest('expense_date')
            ->take(4)
            ->get();

        $notices = Notice::with('sport')
            ->latest('notice_date')
            ->take(4)
            ->get();

        return view('dashboard', compact(
            'totalTrainees',
            'totalBatches',
            'totalCoaches',
            'attendanceRate',
            'totalFeeCollectedMonth',
            'duePaymentsCount',
            'pendingAdmissionsCount',
            'totalExpenses',
            'totalIncome',
            'netBalance',
            'totalFitnessAssessed',
            'coachesList',
            'recentTrainingTasks',
            'batches',
            'recentTrainees',
            'recentAdmissions',
            'recentExpenses',
            'notices'
        ));
    }

    /**
     * Dedicated Match Scorer Dashboard
     */
    public function scorerDashboard($user = null)
    {
        $user = $user ?: auth()->user();

        // Retrieve assigned matches or fallback to all matches
        $assignedMatches = LiveMatch::where('scorer_id', $user->id)
            ->latest('match_datetime')
            ->get();

        if ($assignedMatches->isEmpty()) {
            $assignedMatches = LiveMatch::latest('match_datetime')->take(10)->get();
        }

        $allMatches = LiveMatch::latest('match_datetime')->take(15)->get();

        $liveMatches = LiveMatch::where('status', 'live')->latest('match_datetime')->get();
        $upcomingMatches = LiveMatch::where('status', 'upcoming')->latest('match_datetime')->get();
        $finishedMatches = LiveMatch::where('status', 'finished')->latest('match_datetime')->take(5)->get();

        $totalAssigned = $assignedMatches->count();
        $totalLive = LiveMatch::where('status', 'live')->count();
        $totalUpcoming = LiveMatch::where('status', 'upcoming')->count();
        $totalFinished = LiveMatch::where('status', 'finished')->count();

        $notices = Notice::latest('notice_date')->take(4)->get();

        return view('dashboards.scorer', compact(
            'user',
            'assignedMatches',
            'allMatches',
            'liveMatches',
            'upcomingMatches',
            'finishedMatches',
            'totalAssigned',
            'totalLive',
            'totalUpcoming',
            'totalFinished',
            'notices'
        ));
    }
}

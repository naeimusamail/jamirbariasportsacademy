<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\LivePortalController;
use App\Http\Controllers\AdminLiveMatchController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PublicTeamPortalController;
use App\Http\Controllers\IdCardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PublicVerificationController;
use App\Http\Controllers\TrainingTaskController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\LocalPlayerRegistrationController;
use App\Http\Controllers\PlayerGalleryController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\SmsNotificationController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\PlayerSearchAndVerificationController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\AdminVolunteerController;
use App\Http\Controllers\AdminRegistrationCircularController;
use App\Http\Controllers\AdminTournamentExpenseController;
use App\Http\Controllers\ApplicationHubController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $admissionCircular = \App\Models\RegistrationCircular::where('type', 'admission')->first();
    $volunteerCircular = \App\Models\RegistrationCircular::where('type', 'volunteer')->first();
    $localPlayerCircular = \App\Models\RegistrationCircular::where('type', 'local_player')->first();

    // All registration circulars including tournaments (open & upcoming prioritized, recent 6 for home page)
    $allCirculars = \App\Models\RegistrationCircular::with('tournament.sport')
        ->orderByRaw("CASE 
            WHEN is_active = 1 AND (start_date IS NULL OR start_date <= NOW()) AND (end_date IS NULL OR end_date >= NOW()) THEN 1
            WHEN is_active = 1 AND start_date > NOW() THEN 2
            ELSE 3
        END ASC")
        ->latest('updated_at')
        ->take(8)
        ->get();

    // Academy Recent Notices & Announcements (latest 6 for home page)
    $notices = \App\Models\Notice::with('sport')
        ->orderByDesc('is_pinned')
        ->latest('notice_date')
        ->latest('id')
        ->take(8)
        ->get();

    $pinnedNotices = $notices->where('is_pinned', true);

    // Recent Live & Scheduled Matches for Home Page Showcase
    $recentMatches = \App\Models\LiveMatch::orderByRaw("CASE 
            WHEN status = 'live' THEN 1 
            WHEN status = 'upcoming' THEN 2 
            ELSE 3 
        END ASC")
        ->latest('match_datetime')
        ->take(4)
        ->get();

    return view('welcome', compact(
        'admissionCircular',
        'volunteerCircular',
        'localPlayerCircular',
        'allCirculars',
        'notices',
        'pinnedNotices',
        'recentMatches'
    ));
});

// ==============================================================
// 📢 PUBLIC OFFICIAL NOTICE BOARD & REGISTRATION CIRCULARS HUB (আলাদা পেজ)
// ==============================================================
Route::get('/notice-board', [NoticeController::class, 'publicHub'])->name('public.notice-board');

// 📜 ACADEMY RULES & TERMS (একাডেমির নিয়মাবলী ও শর্তাবলী)
Route::get('/rules', function () {
    return view('rules');
})->name('rules');

Route::get('/terms', function () {
    return view('rules');
})->name('terms');

// ==============================================================
// 🚀 CENTRAL PUBLIC APPLICATION PORTAL (সমন্বিত আবেদন ও নিবন্ধন পোর্টাল)
// ==============================================================
Route::get('/apply', [ApplicationHubController::class, 'index'])->name('public.apply');
Route::get('/registration-portal', [ApplicationHubController::class, 'index']);

// ==============================================================
// 📝 PUBLIC ONLINE ADMISSION (পাবলিক শিক্ষার্থী ভর্তি ফরম)
// ==============================================================
Route::get('/admission', [AdmissionController::class, 'create'])->name('admission.create');
Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');
Route::get('/admission/success/{application_no}', [AdmissionController::class, 'success'])->name('admission.success');
Route::get('/admission/track', [AdmissionController::class, 'track'])->name('admission.track');

// ==============================================================
// 🤝 PUBLIC VOLUNTEER PORTAL (স্বেচ্ছাসেবক আবেদন, ট্র্যাকিং ও আইডি কার্ড)
// ==============================================================
Route::get('/volunteer/apply', [VolunteerController::class, 'create'])->name('volunteer.create');
Route::post('/volunteer/apply', [VolunteerController::class, 'store'])->name('volunteer.store');
Route::get('/volunteer/tracking/{volunteer_no}', [VolunteerController::class, 'tracking'])->name('volunteer.tracking');
Route::post('/volunteer/track-search', [VolunteerController::class, 'trackSearch'])->name('volunteer.track.search');
Route::get('/volunteer/id-card/{volunteer_no}', [VolunteerController::class, 'idCard'])->name('volunteer.id-card');

// ==============================================================
// 🔴 PUBLIC LIVE MATCH SPECTATOR PORTAL (পাবলিক শুধু দেখবে)
// ==============================================================
Route::get('/live', [LivePortalController::class, 'index'])->name('live.index');
Route::get('/live/{slug}', [LivePortalController::class, 'show'])->name('live.show');
Route::get('/api/live/{slug}/score', [LivePortalController::class, 'apiScore'])->name('live.api.score');

// ==============================================================
// 🏆 PUBLIC TOURNAMENTS HUB (একাডেমিক ও লোকাল টুর্নামেন্ট সেক্টর)
// ==============================================================
Route::get('/tournaments', [TournamentController::class, 'publicIndex'])->name('public.tournaments.index');
Route::get('/tournaments/{slug}', [TournamentController::class, 'publicShow'])->name('public.tournaments.show');
Route::get('/tournaments/{slug}/register', [TournamentController::class, 'showPlayerRegistration'])->name('public.tournaments.register');
Route::post('/tournaments/{slug}/register', [TournamentController::class, 'storePlayerRegistration'])->name('public.tournaments.register.store');

// ==============================================================
// 🌟 PUBLIC LOCAL PLAYER REGISTRATION (উন্মুক্ত টুর্নামেন্ট প্লেয়ার নিবন্ধন)
// ==============================================================
Route::get('/local-players/register', [LocalPlayerRegistrationController::class, 'create'])->name('public.local-players.create');
Route::post('/local-players/register', [LocalPlayerRegistrationController::class, 'store'])->name('public.local-players.store');
Route::get('/local-players/pass/{admission_no}', [LocalPlayerRegistrationController::class, 'showPass'])->name('public.local-players.pass');

// ==============================================================
// 🏏 PUBLIC TEAMS & CRICINFO PLAYER PERFORMANCE PORTAL
// ==============================================================
Route::get('/teams', [PublicTeamPortalController::class, 'teamsIndex'])->name('public.teams.index');
Route::get('/teams/{slug}', [PublicTeamPortalController::class, 'teamShow'])->name('public.teams.show');
Route::get('/players/{id}', [PublicTeamPortalController::class, 'playerShow'])->name('public.players.show');

// ==============================================================
// 🪪 PUBLIC QR VERIFICATION PORTAL (আইডি কার্ড ও সার্টিফিকেট যাচাই)
// ==============================================================
Route::get('/verify/player/{admission_no}', [PublicVerificationController::class, 'verifyPlayer'])->name('public.verify.player');
Route::get('/verify/certificate/{certificate_no}', [PublicVerificationController::class, 'verifyCertificate'])->name('public.verify.certificate');

// ==============================================================
// 🎯 SCORER QUICK ACCESS & PIN VERIFICATION (অন-ফিল্ড দ্রুত স্কোরার অ্যাক্সেস)
// ==============================================================
Route::get('/scorer/match/{slug}', [AdminLiveMatchController::class, 'quickAccess'])->name('scorer.quick-access');
Route::post('/scorer/match/{slug}/verify-pin', [AdminLiveMatchController::class, 'verifyPin'])->name('scorer.verify-pin');

// ==============================================================
// ⚡ REAL-TIME DUPLICATE DOCUMENT VERIFICATION API
// ==============================================================
Route::match(['get', 'post'], '/api/verify-player-document', [PlayerSearchAndVerificationController::class, 'verifyApi'])->name('api.verify-player-document');

// ==============================================================
// 🛡️ ACADEMY ADMIN PANEL (শুধুমাত্র এডমিন সেট ও পরিচালনা করবে)
// ==============================================================
Route::middleware(['auth', 'verified'])->group(function () {
    // Universal Player Search Hub & Duplicate Audit
    Route::get('/admin/players/search', [PlayerSearchAndVerificationController::class, 'search'])->name('admin.players.search');
    Route::get('/admin/duplicate-audit', [PlayerSearchAndVerificationController::class, 'duplicateAudit'])->name('admin.duplicate-audit.index');

    // Dynamic Academy Dashboard with Role Dispatch
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/player', [DashboardController::class, 'playerDashboard'])->name('dashboard.player');
    Route::get('/dashboard/coach', [DashboardController::class, 'coachDashboard'])->name('dashboard.coach');
    Route::get('/dashboard/scorer', [DashboardController::class, 'scorerDashboard'])->name('dashboard.scorer');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');

    // Digital Player ID Cards System (Print & Bulk)
    Route::get('/admin/id-cards', [IdCardController::class, 'index'])->name('admin.id-cards.index');
    Route::get('/admin/id-cards/trainee/{trainee}', [IdCardController::class, 'show'])->name('admin.id-cards.show');
    Route::get('/admin/id-cards/bulk', [IdCardController::class, 'bulk'])->name('admin.id-cards.bulk');

    // Academy Certificates Generator (CRUD & Print)
    Route::resource('admin/certificates', CertificateController::class, ['as' => 'admin']);

    // Tournaments Sector Management (Admin Only)
    Route::resource('admin/tournaments', TournamentController::class, ['as' => 'admin']);
    Route::post('admin/tournaments/{tournament}/teams', [TournamentController::class, 'addTeam'])->name('admin.tournaments.add-team');
    Route::delete('admin/tournaments/{tournament}/teams/{team}', [TournamentController::class, 'removeTeam'])->name('admin.tournaments.remove-team');
    Route::post('admin/tournaments/{tournament}/generate-schedule', [TournamentController::class, 'generateSchedule'])->name('admin.tournaments.generate-schedule');
    Route::patch('admin/tournaments/{tournament}/matches/{match}/schedule', [TournamentController::class, 'updateMatchSchedule'])->name('admin.tournaments.update-match-schedule');
    Route::post('admin/tournaments/{tournament}/assign-player/{player}', [TournamentController::class, 'assignPlayerTeam'])->name('admin.tournaments.assign-player');

    // 💰 Tournament Financial Ledger, Volunteer & Equipment Expenses Hub
    Route::get('admin/tournaments/{tournament}/finances', [AdminTournamentExpenseController::class, 'index'])->name('admin.tournaments.finances');
    Route::post('admin/tournaments/{tournament}/finances', [AdminTournamentExpenseController::class, 'store'])->name('admin.tournaments.finances.store');
    Route::delete('admin/tournaments/{tournament}/finances/{expense}', [AdminTournamentExpenseController::class, 'destroy'])->name('admin.tournaments.finances.destroy');
    Route::get('admin/tournaments/{tournament}/finances/print', [AdminTournamentExpenseController::class, 'print'])->name('admin.tournaments.finances.print');
    Route::get('admin/tournaments/{tournament}/finances/export', [AdminTournamentExpenseController::class, 'export'])->name('admin.tournaments.finances.export');

    // Teams & Squads Management / Club Registration (Admin Only)
    Route::resource('admin/teams', TeamController::class, ['as' => 'admin']);
    Route::get('/admin/clubs', function () {
        return redirect()->route('admin.teams.index');
    })->name('admin.clubs.index');
    Route::post('admin/teams/{team}/players', [TeamController::class, 'addPlayer'])->name('admin.teams.add-player');
    Route::delete('admin/teams/{team}/players/{player}', [TeamController::class, 'removePlayer'])->name('admin.teams.remove-player');

    // Trainee Management (CRUD, Report Card, Export)
    Route::get('/trainees/export', [TraineeController::class, 'export'])->name('trainees.export');
    Route::get('/trainees/{trainee}/report-card', [TraineeController::class, 'reportCard'])->name('trainees.report-card');
    Route::resource('trainees', TraineeController::class);

    // Batches & Schedules (CRUD)
    Route::resource('batches', BatchController::class);

    // Coaches (CRUD)
    Route::resource('coaches', CoachController::class);

    // Attendance System
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');

    // Payments, Defaulters & Financial Cashbook
    Route::get('/payments/defaulters', [PaymentController::class, 'defaulters'])->name('payments.defaulters');
    Route::get('/payments/export', [PaymentController::class, 'export'])->name('payments.export');
    Route::resource('payments', PaymentController::class);
    Route::patch('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.mark-paid');
    Route::get('/reports/financial', [FinancialReportController::class, 'index'])->name('reports.financial');

    // Official Live Match Management & Scoring Console (Admin & Scorer)
    Route::get('/matches', [AdminLiveMatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/create', [AdminLiveMatchController::class, 'create'])->name('matches.create');
    Route::post('/matches', [AdminLiveMatchController::class, 'store'])->name('matches.store');
    Route::get('/matches/{match}/edit', [AdminLiveMatchController::class, 'edit'])->name('matches.edit');
    Route::put('/matches/{match}', [AdminLiveMatchController::class, 'update'])->name('matches.update');
    Route::delete('/matches/{match}', [AdminLiveMatchController::class, 'destroy'])->name('matches.destroy');
    Route::post('/admin/scorers', [AdminLiveMatchController::class, 'storeScorer'])->name('admin.scorers.store');
    Route::get('/matches/{slug}/scorer', [AdminLiveMatchController::class, 'scorer'])->name('matches.scorer');
    Route::post('/matches/{slug}/update-score', [AdminLiveMatchController::class, 'updateScore'])->name('matches.update-score');
    Route::post('/matches/{slug}/add-event', [AdminLiveMatchController::class, 'addEvent'])->name('matches.add-event');
    Route::post('/matches/{slug}/player-stat', [AdminLiveMatchController::class, 'addPlayerStat'])->name('matches.add-player-stat');
    Route::delete('/matches/{slug}/player-stat/{stat}', [AdminLiveMatchController::class, 'deletePlayerStat'])->name('matches.delete-player-stat');
    Route::post('/matches/{slug}/update-meta', [AdminLiveMatchController::class, 'updateMatchMeta'])->name('matches.update-meta');

    // Online Admission Review & Approval Workflow (Admin Only)
    Route::get('/admin/admissions', [AdmissionController::class, 'index'])->name('admin.admissions.index');
    Route::get('/admin/admissions/{admission}', [AdmissionController::class, 'show'])->name('admin.admissions.show');
    Route::post('/admin/admissions/{admission}/approve', [AdmissionController::class, 'approve'])->name('admin.admissions.approve');
    Route::post('/admin/admissions/{admission}/reject', [AdmissionController::class, 'reject'])->name('admin.admissions.reject');

    // 🤝 Academy & Tournament Volunteers Management (Admin Only)
    Route::get('/admin/volunteers', [AdminVolunteerController::class, 'index'])->name('admin.volunteers.index');
    Route::get('/admin/volunteers/{id}', [AdminVolunteerController::class, 'show'])->name('admin.volunteers.show');
    Route::post('/admin/volunteers/{id}/status', [AdminVolunteerController::class, 'updateStatus'])->name('admin.volunteers.update-status');
    Route::post('/admin/volunteers/{id}/assign-duty', [AdminVolunteerController::class, 'assignDuty'])->name('admin.volunteers.assign-duty');
    Route::delete('/admin/volunteers/{id}', [AdminVolunteerController::class, 'destroy'])->name('admin.volunteers.destroy');

    // 📅 Registration Circulars & Start/Stop Scheduling (সার্কুলার সময়সূচী ও ডেডলাইন হাব)
    Route::get('/admin/circulars', [AdminRegistrationCircularController::class, 'index'])->name('admin.circulars.index');
    Route::post('/admin/circulars', [AdminRegistrationCircularController::class, 'store'])->name('admin.circulars.store');
    Route::put('/admin/circulars/{id}', [AdminRegistrationCircularController::class, 'update'])->name('admin.circulars.update');
    Route::delete('/admin/circulars/{id}', [AdminRegistrationCircularController::class, 'destroy'])->name('admin.circulars.destroy');
    Route::patch('/admin/circulars/{id}/toggle', [AdminRegistrationCircularController::class, 'toggleActive'])->name('admin.circulars.toggle');

    // Player Performance & Fitness Analytics
    Route::resource('performances', PerformanceController::class);

    // Training Tasks & Drills (Coaches assign to Players, Players complete, Coaches review)
    Route::get('/tasks', [TrainingTaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TrainingTaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/complete', [TrainingTaskController::class, 'complete'])->name('tasks.complete');
    Route::patch('/tasks/{task}/quick-complete', [TrainingTaskController::class, 'quickComplete'])->name('tasks.quick-complete');
    Route::patch('/tasks/{task}/review', [TrainingTaskController::class, 'review'])->name('tasks.review');
    Route::delete('/tasks/{task}', [TrainingTaskController::class, 'destroy'])->name('tasks.destroy');

    // Academy Expense & Financial Accounting
    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::resource('expenses', ExpenseController::class)->except(['edit', 'update', 'show']);

    // Bulk SMS Broadcast Hub (Admin Only)
    Route::get('/admin/sms', [SmsNotificationController::class, 'index'])->name('admin.sms.index');
    Route::post('/admin/sms/send', [SmsNotificationController::class, 'send'])->name('admin.sms.send');

    // Database Backup & System Health (Admin Only)
    Route::get('/admin/backup', [BackupController::class, 'index'])->name('admin.backup.index');
    Route::get('/admin/backup/download', [BackupController::class, 'download'])->name('admin.backup.download');

    // Notices & Announcements
    Route::resource('notices', NoticeController::class)->only(['index', 'create', 'store', 'destroy']);

    // Player Photo & Promo Gallery System (খেলার মুহূর্ত ও প্রোমো গ্যালারি)
    Route::post('/trainees/{trainee}/gallery', [PlayerGalleryController::class, 'store'])->name('trainees.gallery.store');
    Route::delete('/gallery/{gallery}', [PlayerGalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::patch('/gallery/{gallery}/toggle-featured', [PlayerGalleryController::class, 'toggleFeatured'])->name('gallery.toggle-featured');

    // Multi-Role Profile Systems
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/player/{id?}', [ProfileController::class, 'playerProfile'])->name('profile.player');
    Route::get('/profile/coach/{id?}', [ProfileController::class, 'coachProfile'])->name('profile.coach');
});

require __DIR__.'/auth.php';

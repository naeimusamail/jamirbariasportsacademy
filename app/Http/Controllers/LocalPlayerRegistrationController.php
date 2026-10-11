<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\Sport;
use App\Models\Team;
use App\Models\TeamPlayer;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalPlayerRegistrationController extends Controller
{
    /**
     * Show the Local / Tournament Player Registration form
     */
    public function create()
    {
        $data = \App\Http\Controllers\ApplicationHubController::getData(request(), 'local_player');
        return view('apply.index', $data);
    }

    /**
     * Store new Local / Tournament Player
     */
    public function store(Request $request)
    {
        // Enforce circular start / deadline gate
        $circular = \App\Models\RegistrationCircular::ofType('local_player');
        if (!$circular->isOpen()) {
            $msg = $circular->isUpcoming()
                ? ($circular->upcoming_message ?: 'লোকাল প্লেয়ার ড্রাফট নিবন্ধন এখনও শুরু হয়নি। শুরুর সময়: ' . ($circular->start_date ? $circular->start_date->format('d M Y, h:i A') : 'শীঘ্রই'))
                : ($circular->closed_message ?: 'লোকাল প্লেয়ার ড্রাফট নিবন্ধনের সময়সীমা সমাপ্ত হয়েছে।');
            return back()->withInput()->with('error', $msg);
        }

        $validated = $request->validate([
            'sports' => 'required|array|min:1',
            'sports.*' => 'exists:sports,id',
            'name' => 'required|string|max:255',
            'team_id' => 'nullable|exists:teams,id',
            'organization_or_area' => 'nullable|string|max:255',
            'phone' => 'required|string|max:30',
            'emergency_phone' => 'nullable|string|max:30',
            'guardian_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'blood_group' => 'nullable|string|max:10',
            'nid_or_birth_cert' => 'nullable|string|max:50',
            'category' => 'required|in:U-12,U-14,U-16,U-19,Senior',
            'position' => 'nullable|string|max:100',
            'jersey_no' => 'nullable|string|max:10',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cropped_photo' => 'nullable|string',
        ], [
            'sports.required' => 'অন্তত একটি খেলা নির্বাচন করুন।',
            'name.required' => 'খেলোয়াড়ের পুরো নাম প্রদান করুন।',
            'phone.required' => 'মোবাইল নম্বর প্রদান করুন।',
            'date_of_birth.required' => 'জন্ম তারিখ প্রদান করুন।',
            'category.required' => 'বয়সভিত্তিক ক্যাটাগরি নির্বাচন করুন।',
        ]);

        // Check for duplicate documents / phone in database
        $verificationService = app(\App\Services\PlayerDocumentVerificationService::class);
        $dupReport = $verificationService->checkDuplicate([
            'nid_or_birth_cert' => $validated['nid_or_birth_cert'] ?? null,
            'phone' => $validated['phone'],
            'name' => $validated['name'],
            'date_of_birth' => $validated['date_of_birth'],
        ]);

        if ($dupReport['is_strict_duplicate']) {
            $firstMatch = $dupReport['matches'][0];
            $errField = ($firstMatch['field'] === 'phone') ? 'phone' : 'nid_or_birth_cert';
            return back()->withInput()->withErrors([
                $errField => $firstMatch['message']
            ]);
        }

        $team = null;
        if (!empty($validated['team_id'])) {
            $team = Team::find($validated['team_id']);
        } elseif (!empty($validated['organization_or_area'])) {
            $team = Team::where('name', $validated['organization_or_area'])->first();
        }
        $teamName = $team ? $team->name : ($validated['organization_or_area'] ?? 'উন্মুক্ত প্লেয়ার ড্রাফট (Open Draft)');

        // Generate unique Local Player Registration ID (e.g. JSA-LOC-2026-001)
        $latestLocal = Trainee::where('player_type', 'local')->latest('id')->first();
        $nextNum = $latestLocal ? $latestLocal->id + 1 : (Trainee::count() + 1);
        $admissionNo = 'JSA-LOC-2026-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        $selectedSports = $request->input('sports', []);
        $primarySportId = $selectedSports[0];

        $photoPath = null;
        if ($request->filled('cropped_photo') && str_starts_with($request->cropped_photo, 'data:image')) {
            $image_parts = explode(";base64,", $request->cropped_photo);
            if (isset($image_parts[1])) {
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'trainees/local_' . Str::random(35) . '.jpg';
                Storage::disk('public')->put($filename, $image_base64);
                $photoPath = $filename;
            }
        } elseif ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('trainees', 'public');
        }

        $player = Trainee::create([
            'admission_no' => $admissionNo,
            'player_type' => 'local', // 🏆 Local Player
            'sport_id' => $primarySportId,
            'batch_id' => null, // No mandatory batch for local players
            'name' => $validated['name'],
            'organization_or_area' => $teamName,
            'phone' => $validated['phone'],
            'emergency_phone' => $validated['emergency_phone'] ?? $validated['phone'],
            'guardian_name' => $validated['guardian_name'] ?? 'অভিভাবক',
            'date_of_birth' => $validated['date_of_birth'],
            'blood_group' => $validated['blood_group'] ?? null,
            'nid_or_birth_cert' => $validated['nid_or_birth_cert'] ?? null,
            'category' => $validated['category'],
            'position' => $validated['position'] ?? 'প্লেয়ার',
            'jersey_no' => $validated['jersey_no'] ?? null,
            'address' => $validated['address'],
            'monthly_fee' => 0, // No monthly academy fee for open players
            'admission_date' => now()->toDateString(),
            'photo' => $photoPath,
            'status' => 'active',
        ]);

        // Sync sports with positions
        $syncData = [];
        foreach ($selectedSports as $idx => $sId) {
            $syncData[$sId] = [
                'position' => $validated['position'] ?? 'প্লেয়ার',
                'jersey_no' => $validated['jersey_no'] ?? null,
                'is_primary' => ($idx === 0),
            ];
        }
        $player->sports()->sync($syncData);

        // Link with selected club/team squad
        if ($team) {
            TeamPlayer::firstOrCreate([
                'team_id' => $team->id,
                'trainee_id' => $player->id,
            ], [
                'name' => $player->name,
                'jersey_no' => $player->jersey_no,
                'role' => $player->position ?? 'All-Rounder',
                'status' => 'active',
            ]);
        }

        return redirect()->route('public.local-players.pass', $player->admission_no)
            ->with('success', 'লোকাল টুর্নামেন্ট প্লেয়ার হিসেবে আপনার রেজিস্ট্রেশন সফল হয়েছে!');
    }

    /**
     * Show official Local Player Pass / Digital ID Card with QR code
     */
    public function showPass($admission_no)
    {
        $player = Trainee::where('admission_no', $admission_no)
            ->with(['sports', 'sport'])
            ->firstOrFail();

        $verifyUrl = route('public.verify.player', $player->admission_no);
        $qrCodeSvg = QrCodeService::svg($verifyUrl, 4);

        return view('local_players.pass', compact('player', 'verifyUrl', 'qrCodeSvg'));
    }
}

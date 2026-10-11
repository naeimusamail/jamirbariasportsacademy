<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\User;
use App\Models\AdmissionApplication;
use App\Services\PlayerDocumentVerificationService;

class PlayerSearchAndVerificationController extends Controller
{
    protected PlayerDocumentVerificationService $verificationService;

    public function __construct(PlayerDocumentVerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    /**
     * 🔍 Universal Player Search Hub
     * Search by ID, Username, Email, Name, Phone, NID / Birth Cert, Jersey No, Category
     */
    public function search(Request $request)
    {
        $term = trim($request->input('q', $request->input('search', '')));

        $query = Trainee::with(['sport', 'sports', 'batch', 'user', 'teamPlayers.team']);

        if (!empty($term)) {
            $normDoc = PlayerDocumentVerificationService::normalizeDoc($term);
            $normPhone = PlayerDocumentVerificationService::normalizePhone($term);

            $query->where(function ($q) use ($term, $normDoc, $normPhone) {
                // 1. By ID / Admission No
                $q->where('admission_no', 'like', "%{$term}%")
                  // 2. By Name
                  ->orWhere('name', 'like', "%{$term}%")
                  // 3. By Phone or Emergency Phone
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('emergency_phone', 'like', "%{$term}%")
                  // 4. By NID / Birth Cert
                  ->orWhere('nid_or_birth_cert', 'like', "%{$term}%")
                  // 5. By Category or Jersey No or Position
                  ->orWhere('category', 'like', "%{$term}%")
                  ->orWhere('jersey_no', 'like', "%{$term}%")
                  ->orWhere('position', 'like', "%{$term}%")
                  // 6. By Linked User Account (Email or Username)
                  ->orWhereHas('user', function ($uq) use ($term) {
                      $uq->where('email', 'like', "%{$term}%")
                         ->orWhere('username', 'like', "%{$term}%");
                  });

                // Also check normalized document / phone if valid
                if (!empty($normDoc)) {
                    $q->orWhere('nid_or_birth_cert', 'like', "%{$normDoc}%");
                }
                if (!empty($normPhone)) {
                    $q->orWhere('phone', 'like', "%{$normPhone}%");
                }
            });
        }

        $players = !empty($term)
            ? $query->latest()->paginate(15)->withQueryString()
            : $query->latest()->paginate(10)->withQueryString();

        // If AJAX request, return json for instant live autocomplete / search modal
        if ($request->ajax() || $request->wantsJson()) {
            $results = $players->map(function ($player) {
                return [
                    'id' => $player->id,
                    'name' => $player->name,
                    'admission_no' => $player->admission_no,
                    'player_type' => $player->player_type,
                    'player_type_label' => $player->player_type === 'local' ? 'উন্মুক্ত লোকাল প্লেয়ার' : 'একাডেমিক ট্রেইনি',
                    'phone' => $player->phone,
                    'nid_or_birth_cert' => $player->nid_or_birth_cert ?? 'N/A',
                    'category' => $player->category,
                    'sport_name' => $player->sport ? $player->sport->name : 'N/A',
                    'username' => $player->user ? '@' . $player->user->username : null,
                    'email' => $player->user ? $player->user->email : null,
                    'photo_url' => $player->photo ? asset('storage/' . $player->photo) : null,
                    'url' => route('trainees.show', $player->id),
                    'id_card_url' => route('admin.id-cards.show', $player->id),
                ];
            });

            return response()->json([
                'success' => true,
                'count' => $players->total(),
                'data' => $results,
            ]);
        }

        return view('admin.player_search.index', compact('players', 'term'));
    }

    /**
     * ⚡ Real-Time API to Verify Player Document / Check Duplicates
     * Called by AJAX when typing NID, Phone, or Name+DOB in registration forms
     */
    public function verifyApi(Request $request)
    {
        $data = [
            'nid_or_birth_cert' => $request->input('nid_or_birth_cert'),
            'phone' => $request->input('phone'),
            'name' => $request->input('name'),
            'date_of_birth' => $request->input('date_of_birth'),
        ];

        $excludeTraineeId = $request->input('exclude_trainee_id') ? (int) $request->input('exclude_trainee_id') : null;
        $excludeAppId = $request->input('exclude_app_id') ? (int) $request->input('exclude_app_id') : null;

        $report = $this->verificationService->checkDuplicate($data, $excludeTraineeId, $excludeAppId);

        return response()->json([
            'success' => true,
            'report' => $report,
        ]);
    }

    /**
     * 🛡️ Admin Duplicate Document Audit Hub
     * Scans and lists all system duplicates across database
     */
    public function duplicateAudit(Request $request)
    {
        $audit = $this->verificationService->scanAllSystemDuplicates();

        return view('admin.duplicate_audit.index', compact('audit'));
    }
}


<?php

namespace App\Services;

use App\Models\Trainee;
use App\Models\AdmissionApplication;
use App\Models\User;
use Illuminate\Support\Collection;

class PlayerDocumentVerificationService
{
    /**
     * Normalize NID / Birth Certificate numbers for robust comparison
     */
    public static function normalizeDoc(?string $doc): string
    {
        if (empty($doc)) {
            return '';
        }
        // Remove spaces, hyphens, slashes, dots
        return preg_replace('/[^a-zA-Z0-9]/', '', trim($doc));
    }

    /**
     * Normalize Bangladeshi & international phone numbers for comparison
     */
    public static function normalizePhone(?string $phone): string
    {
        if (empty($phone)) {
            return '';
        }
        // Remove spaces, dashes, parentheses
        $clean = preg_replace('/[^0-9]/', '', trim($phone));
        // Strip 88 prefix if present and starts with 8801
        if (str_starts_with($clean, '8801') && strlen($clean) === 13) {
            $clean = substr($clean, 2);
        }
        return $clean;
    }

    /**
     * Check single payload for duplicate documents / identity
     */
    public function checkDuplicate(array $data, ?int $excludeTraineeId = null, ?int $excludeApplicationId = null): array
    {
        $matches = [];
        $isStrictDuplicate = false;

        $inputDoc = !empty($data['nid_or_birth_cert']) ? trim($data['nid_or_birth_cert']) : null;
        $normDoc = self::normalizeDoc($inputDoc);

        $inputPhone = !empty($data['phone']) ? trim($data['phone']) : null;
        $normPhone = self::normalizePhone($inputPhone);

        $inputName = !empty($data['name']) ? trim(mb_strtolower($data['name'])) : null;
        $inputDob = !empty($data['date_of_birth']) ? date('Y-m-d', strtotime($data['date_of_birth'])) : null;

        // 1. Check NID / Birth Certificate in Trainees
        if (!empty($normDoc)) {
            $traineesWithDoc = Trainee::whereNotNull('nid_or_birth_cert')
                ->where('nid_or_birth_cert', '!=', '')
                ->when($excludeTraineeId, fn($q) => $q->where('id', '!=', $excludeTraineeId))
                ->get();

            foreach ($traineesWithDoc as $tr) {
                if (self::normalizeDoc($tr->nid_or_birth_cert) === $normDoc) {
                    $isStrictDuplicate = true;
                    $matches[] = [
                        'type' => 'nid',
                        'field' => 'nid_or_birth_cert',
                        'severity' => 'danger',
                        'title' => 'NID / জন্ম নিবন্ধন সনদ নম্বর হুবহু মিলে গেছে',
                        'message' => "এই NID / জন্মসনদ নম্বর ({$tr->nid_or_birth_cert}) দিয়ে ইতিমধ্যে খেলোয়াড় '{$tr->name}' (আইডি: {$tr->admission_no}) ডাটাবেজে নিবন্ধিত আছেন।",
                        'record_type' => 'trainee',
                        'record_id' => $tr->id,
                        'name' => $tr->name,
                        'admission_no' => $tr->admission_no,
                        'phone' => $tr->phone,
                        'player_type' => $tr->player_type,
                        'photo' => $tr->photo,
                        'created_at' => $tr->created_at->format('d M, Y'),
                    ];
                    break;
                }
            }

            // Also check AdmissionApplication
            $appsWithDoc = AdmissionApplication::whereNotNull('nid_or_birth_cert')
                ->where('nid_or_birth_cert', '!=', '')
                ->where('status', '!=', 'rejected')
                ->when($excludeApplicationId, fn($q) => $q->where('id', '!=', $excludeApplicationId))
                ->get();

            foreach ($appsWithDoc as $ap) {
                if (self::normalizeDoc($ap->nid_or_birth_cert) === $normDoc) {
                    $isStrictDuplicate = true;
                    $matches[] = [
                        'type' => 'nid',
                        'field' => 'nid_or_birth_cert',
                        'severity' => 'danger',
                        'title' => 'ভর্তি আবেদনে একই NID / জন্মসনদ বিদ্যমান',
                        'message' => "এই NID / জন্মসনদ নম্বর দিয়ে একটি ভর্তি আবেদন চলমান আছে (আবেদন নং: {$ap->application_no}, নাম: {$ap->name})।",
                        'record_type' => 'admission_application',
                        'record_id' => $ap->id,
                        'name' => $ap->name,
                        'admission_no' => $ap->application_no,
                        'phone' => $ap->phone,
                        'player_type' => 'applicant',
                        'photo' => $ap->photo,
                        'created_at' => $ap->created_at->format('d M, Y'),
                    ];
                    break;
                }
            }
        }

        // 2. Check Phone in Trainees
        if (!empty($normPhone)) {
            $traineesWithPhone = Trainee::whereNotNull('phone')
                ->when($excludeTraineeId, fn($q) => $q->where('id', '!=', $excludeTraineeId))
                ->get();

            foreach ($traineesWithPhone as $tr) {
                if (self::normalizePhone($tr->phone) === $normPhone) {
                    // Check if not already added by NID
                    $alreadyAdded = collect($matches)->contains(fn($m) => $m['record_id'] === $tr->id && $m['record_type'] === 'trainee');
                    if (!$alreadyAdded) {
                        $isStrictDuplicate = true;
                        $matches[] = [
                            'type' => 'phone',
                            'field' => 'phone',
                            'severity' => 'danger',
                            'title' => 'মোবাইল নম্বর হুবহু মিলে গেছে',
                            'message' => "এই মোবাইল নম্বর ({$tr->phone}) দিয়ে ইতিমধ্যে খেলোয়াড় '{$tr->name}' (আইডি: {$tr->admission_no}) নিবন্ধিত আছেন।",
                            'record_type' => 'trainee',
                            'record_id' => $tr->id,
                            'name' => $tr->name,
                            'admission_no' => $tr->admission_no,
                            'phone' => $tr->phone,
                            'player_type' => $tr->player_type,
                            'photo' => $tr->photo,
                            'created_at' => $tr->created_at->format('d M, Y'),
                        ];
                        break;
                    }
                }
            }
        }

        // 3. Suspected Duplicate (Name + Date of Birth matching)
        if (!empty($inputName) && !empty($inputDob)) {
            $suspectedTrainees = Trainee::whereNotNull('date_of_birth')
                ->whereDate('date_of_birth', $inputDob)
                ->when($excludeTraineeId, fn($q) => $q->where('id', '!=', $excludeTraineeId))
                ->get();

            foreach ($suspectedTrainees as $tr) {
                if (mb_strtolower(trim($tr->name)) === $inputName) {
                    $alreadyAdded = collect($matches)->contains(fn($m) => $m['record_id'] === $tr->id && $m['record_type'] === 'trainee');
                    if (!$alreadyAdded) {
                        $matches[] = [
                            'type' => 'name_dob',
                            'field' => 'name_dob',
                            'severity' => 'warning',
                            'title' => 'সন্দেহভাজন প্লেয়ার (একই নাম ও জন্মতারিখ)',
                            'message' => "হুবহু একই নাম ({$tr->name}) এবং একই জন্মতারিখ ({$tr->date_of_birth}) দিয়ে ইতিমধ্যে একজন খেলোয়াড় নিবন্ধিত আছেন।",
                            'record_type' => 'trainee',
                            'record_id' => $tr->id,
                            'name' => $tr->name,
                            'admission_no' => $tr->admission_no,
                            'phone' => $tr->phone,
                            'player_type' => $tr->player_type,
                            'photo' => $tr->photo,
                            'created_at' => $tr->created_at->format('d M, Y'),
                        ];
                    }
                }
            }
        }

        $hasDuplicate = count($matches) > 0;
        $highestSeverity = $isStrictDuplicate ? 'danger' : ($hasDuplicate ? 'warning' : 'clean');

        return [
            'has_duplicate' => $hasDuplicate,
            'is_strict_duplicate' => $isStrictDuplicate,
            'severity' => $highestSeverity,
            'matches_count' => count($matches),
            'message' => $hasDuplicate
                ? ($isStrictDuplicate
                    ? '⚠️ ডুপ্লিকেট প্লেয়ার শনাক্ত হয়েছে! এই তথ্য দিয়ে ইতিমধ্যে একজন খেলোয়াড় ডাটাবেজে বিদ্যমান।'
                    : '⚠️ একই নাম ও জন্মতারিখের একজন খেলোয়াড় বিদ্যমান রয়েছে (সম্ভাব্য ডুপ্লিকেট)।')
                : 'সব তথ্য ইউনিক ও সঠিক রয়েছে।',
            'matches' => $matches,
        ];
    }

    /**
     * Comprehensive scan across database to group all duplicate documents
     */
    public function scanAllSystemDuplicates(): array
    {
        $allTrainees = Trainee::with(['sport', 'user'])->get();

        // 1. Group by NID / Birth cert
        $nidGroups = [];
        foreach ($allTrainees as $t) {
            $norm = self::normalizeDoc($t->nid_or_birth_cert);
            if (!empty($norm)) {
                $nidGroups[$norm][] = $t;
            }
        }
        $duplicateNids = array_filter($nidGroups, fn($grp) => count($grp) > 1);

        // 2. Group by Phone
        $phoneGroups = [];
        foreach ($allTrainees as $t) {
            $norm = self::normalizePhone($t->phone);
            if (!empty($norm)) {
                $phoneGroups[$norm][] = $t;
            }
        }
        $duplicatePhones = array_filter($phoneGroups, fn($grp) => count($grp) > 1);

        // 3. Group by Name + Date of Birth
        $identityGroups = [];
        foreach ($allTrainees as $t) {
            if (!empty($t->name) && !empty($t->date_of_birth)) {
                $key = mb_strtolower(trim($t->name)) . '|' . date('Y-m-d', strtotime($t->date_of_birth));
                $identityGroups[$key][] = $t;
            }
        }
        $duplicateIdentities = array_filter($identityGroups, fn($grp) => count($grp) > 1);

        $totalDuplicateRecords = 0;
        foreach ($duplicateNids as $grp) $totalDuplicateRecords += count($grp);
        foreach ($duplicatePhones as $grp) $totalDuplicateRecords += count($grp);
        foreach ($duplicateIdentities as $grp) $totalDuplicateRecords += count($grp);

        return [
            'total_duplicates_found' => count($duplicateNids) + count($duplicatePhones) + count($duplicateIdentities),
            'total_affected_players' => $totalDuplicateRecords,
            'duplicate_nids' => $duplicateNids,
            'duplicate_phones' => $duplicatePhones,
            'duplicate_identities' => $duplicateIdentities,
        ];
    }
}


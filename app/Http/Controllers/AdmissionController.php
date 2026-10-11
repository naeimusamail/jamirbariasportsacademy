<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdmissionApplication;
use App\Models\Sport;
use App\Models\Batch;
use App\Models\Trainee;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdmissionController extends Controller
{
    // ==============================================================
    // 🌐 PUBLIC ADMISSION PORTAL (সাধারণ মানুষ / অভিভাবক আবেদন করবেন)
    // ==============================================================

    public function create(Request $request)
    {
        $data = \App\Http\Controllers\ApplicationHubController::getData($request, 'admission');
        return view('apply.index', $data);
    }

    public function store(Request $request)
    {
        // Enforce circular start / deadline gate
        $circular = null;
        if ($request->filled('circular_id')) {
            $circular = \App\Models\RegistrationCircular::find($request->circular_id);
        }

        if (!$circular) {
            $circular = \App\Models\RegistrationCircular::ofType('admission');
        }

        if (!$circular->isOpen()) {
            $msg = $circular->isUpcoming()
                ? ($circular->upcoming_message ?: 'ভর্তি আবেদন প্রক্রিয়া এখনও শুরু হয়নি। শুরুর সময়: ' . ($circular->start_date ? $circular->start_date->format('d M Y, h:i A') : 'শীঘ্রই'))
                : ($circular->closed_message ?: 'ভর্তি আবেদন প্রক্রিয়া বর্তমানে বন্ধ রয়েছে বা সময়সীমা সমাপ্ত হয়েছে।');
            return back()->withInput()->with('error', $msg);
        }

        $bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        $enDigits = ['0','1','2','3','4','5','6','7','8','9'];
        if ($request->filled('phone')) {
            $request->merge(['phone' => str_replace($bnDigits, $enDigits, $request->phone)]);
        }
        if ($request->filled('emergency_phone')) {
            $request->merge(['emergency_phone' => str_replace($bnDigits, $enDigits, $request->emergency_phone)]);
        }
        if ($request->filled('sender_number')) {
            $request->merge(['sender_number' => str_replace($bnDigits, $enDigits, $request->sender_number)]);
        }

        $validated = $request->validate([
            'sport_id' => 'nullable|exists:sports,id',
            'sports' => 'nullable|array|min:1',
            'sports.*' => 'exists:sports,id',
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+ -]+$/'],
            'emergency_phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+ -]+$/'],
            'date_of_birth' => 'required|date',
            'blood_group' => 'nullable|string|max:10',
            'nid_or_birth_cert' => 'nullable|string|max:50',
            'category' => 'required|in:U-12,U-14,U-16,U-19,Senior',
            'position' => 'nullable|string|max:100',
            'jersey_no' => 'nullable|string|max:20',
            'organization_or_area' => 'nullable|string|max:255',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cropped_photo' => 'nullable|string',
            'payment_method' => 'required|in:cash,bkash,nagad,rocket,bank',
            'payment_amount' => 'required|numeric|min:0',
            'transaction_id' => 'nullable|string|max:100',
            'sender_number' => 'nullable|string|max:50',
        ]);

        // Duplicate verification check
        $verificationService = app(\App\Services\PlayerDocumentVerificationService::class);
        $dupReport = $verificationService->checkDuplicate([
            'nid_or_birth_cert' => $request->input('nid_or_birth_cert'),
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

        $selectedSports = $request->input('sports', []);
        if (empty($selectedSports) && $request->filled('sport_id')) {
            $selectedSports = [$request->sport_id];
        }

        if (empty($selectedSports)) {
            return back()->withInput()->withErrors(['sports' => 'অন্তত একটি খেলা বাছাই করুন।']);
        }

        $primarySportId = $request->sport_id ?: $selectedSports[0];

        // Auto generate application number e.g. APP-2026-001
        $count = AdmissionApplication::count() + 1;
        $applicationNo = 'APP-' . date('Y') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $photoPath = null;
        if ($request->filled('cropped_photo') && str_starts_with($request->cropped_photo, 'data:image')) {
            $image_parts = explode(";base64,", $request->cropped_photo);
            if (isset($image_parts[1])) {
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'admissions/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($filename, $image_base64);
                $photoPath = $filename;
            }
        } elseif ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('admissions', 'public');
        }

        $paymentStatus = ($validated['payment_method'] === 'cash') ? 'cash_on_arrival' : 'verified_pending';

        $application = AdmissionApplication::create([
            'application_no' => $applicationNo,
            'registration_circular_id' => $circular->id,
            'sport_id' => $primarySportId,
            'sports_applied' => $selectedSports,
            'name' => $validated['name'],
            'name_en' => $validated['name_en'] ?? null,
            'guardian_name' => $validated['guardian_name'],
            'phone' => $validated['phone'],
            'emergency_phone' => $validated['emergency_phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'],
            'blood_group' => $validated['blood_group'] ?? null,
            'nid_or_birth_cert' => $validated['nid_or_birth_cert'] ?? null,
            'category' => $validated['category'],
            'position' => $validated['position'] ?? null,
            'jersey_no' => $validated['jersey_no'] ?? null,
            'organization_or_area' => $validated['organization_or_area'] ?? null,
            'address' => $validated['address'],
            'photo' => $photoPath,
            'payment_method' => $validated['payment_method'],
            'payment_amount' => $validated['payment_amount'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'sender_number' => $validated['sender_number'] ?? null,
            'payment_status' => $paymentStatus,
            'status' => 'pending',
        ]);

        return redirect()->route('admission.success', $application->application_no)
            ->with('success', 'আপনার ভর্তি আবেদনটি সফলভাবে গৃহীত হয়েছে!');
    }

    public function success($application_no)
    {
        $application = AdmissionApplication::with('sport')
            ->where('application_no', $application_no)
            ->firstOrFail();

        return view('admission.success', compact('application'));
    }

    public function track(Request $request)
    {
        $application = null;
        if ($request->filled('query')) {
            $search = trim($request->input('query'));
            $application = AdmissionApplication::with(['sport', 'trainee.batch'])
                ->where('application_no', $search)
                ->orWhere('phone', $search)
                ->latest()
                ->first();
        }

        return view('admission.track', compact('application'));
    }

    // ==============================================================
    // 🛡️ ADMIN MANAGEMENT & APPROVAL WORKFLOW (শুধুমাত্র একাডেমি এডমিন)
    // ==============================================================

    public function index(Request $request)
    {
        $query = AdmissionApplication::with(['sport', 'circular']);

        if ($request->filled('circular_id')) {
            $query->where('registration_circular_id', $request->circular_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('application_no', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $applications = $query->latest()->paginate(15)->withQueryString();
        $sports = Sport::all();
        $circulars = \App\Models\RegistrationCircular::where('type', 'admission')->latest('id')->get();
        $pendingCount = AdmissionApplication::where('status', 'pending')->count();

        return view('admin.admissions.index', compact('applications', 'sports', 'circulars', 'pendingCount'));
    }

    public function show(AdmissionApplication $admission)
    {
        $admission->load(['sport', 'circular']);
        // Available batches for this sport
        $batches = Batch::where('sport_id', $admission->sport_id)
            ->where('status', 'active')
            ->get();

        return view('admin.admissions.show', compact('admission', 'batches'));
    }

    public function approve(Request $request, AdmissionApplication $admission)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'monthly_fee' => 'required|numeric|min:0',
            'admission_date' => 'required|date',
            'admin_notes' => 'nullable|string',
        ]);

        if ($admission->status === 'approved') {
            return back()->with('error', 'এই আবেদনটি ইতিমধ্যে অনুমোদিত হয়েছে!');
        }

        // Generate student Admission No: JSA-2026-XXX
        $lastTrainee = Trainee::latest('id')->first();
        $nextId = $lastTrainee ? $lastTrainee->id + 1 : 1;
        $admissionNo = 'JSA-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Copy photo to trainees folder if exists
        $traineePhoto = null;
        if ($admission->photo && Storage::disk('public')->exists($admission->photo)) {
            $extension = pathinfo($admission->photo, PATHINFO_EXTENSION);
            $newPath = 'trainees/' . Str::random(40) . '.' . $extension;
            Storage::disk('public')->copy($admission->photo, $newPath);
            $traineePhoto = $newPath;
        }

        // Create official Trainee record
        $trainee = Trainee::create([
            'admission_no' => $admissionNo,
            'sport_id' => $admission->sport_id,
            'batch_id' => $request->batch_id,
            'name' => $admission->name,
            'name_en' => $admission->name_en,
            'guardian_name' => $admission->guardian_name,
            'phone' => $admission->phone,
            'emergency_phone' => $admission->emergency_phone,
            'date_of_birth' => $admission->date_of_birth,
            'blood_group' => $admission->blood_group,
            'nid_or_birth_cert' => $admission->nid_or_birth_cert,
            'category' => $admission->category,
            'position' => $admission->position,
            'jersey_no' => $admission->jersey_no,
            'address' => $admission->address,
            'organization_or_area' => $admission->organization_or_area,
            'monthly_fee' => $request->monthly_fee,
            'admission_date' => $request->admission_date,
            'photo' => $traineePhoto,
            'status' => 'active',
        ]);

        // Sync all applied sports into sport_trainee pivot table
        $sportsApplied = $admission->sports_applied ?: [$admission->sport_id];
        $syncData = [];
        foreach ($sportsApplied as $sId) {
            $syncData[$sId] = [
                'position' => $admission->position,
                'jersey_no' => null,
                'is_primary' => ($sId == $admission->sport_id),
            ];
        }
        $trainee->sports()->sync($syncData);

        // Create initial admission payment record in financial ledger if payment amount exists
        if ($admission->payment_amount > 0) {
            $lastPayment = Payment::latest('id')->first();
            $nextPayId = $lastPayment ? $lastPayment->id + 1 : 1;
            $invoiceNo = 'INV-' . date('Y') . '-' . str_pad($nextPayId, 4, '0', STR_PAD_LEFT);

            Payment::create([
                'invoice_no' => $invoiceNo,
                'trainee_id' => $trainee->id,
                'title' => 'নতুন ভর্তি ফি (অনলাইন আবেদন)',
                'fee_type' => 'admission',
                'amount' => $admission->payment_amount,
                'month' => date('F'),
                'year' => date('Y'),
                'payment_method' => $admission->payment_method ?? 'cash',
                'transaction_id' => $admission->transaction_id,
                'sender_number' => $admission->sender_number,
                'received_by' => auth()->user()->name ?? 'একাডেমি এডমিন',
                'status' => 'paid',
                'payment_date' => $request->admission_date ?? date('Y-m-d'),
                'note' => 'অনলাইন ভর্তি আবেদন নং: ' . $admission->application_no,
            ]);
        }

        // Update application status
        $admission->update([
            'status' => 'approved',
            'payment_status' => 'paid',
            'trainee_id' => $trainee->id,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.admissions.show', $admission)
            ->with('success', "আবেদনটি অনুমোদিত হয়েছে এবং নতুন ট্রেইনি তৈরি করা হয়েছে! রোল নং: {$trainee->admission_no}");
    }

    public function reject(Request $request, AdmissionApplication $admission)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $admission->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.admissions.show', $admission)
            ->with('info', 'আবেদনটি বাতিল হিসেবে চিহ্নিত করা হয়েছে।');
    }
}


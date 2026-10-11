<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Trainee;
use App\Models\Sport;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Display a listing of issued certificates.
     */
    public function index(Request $request)
    {
        $query = Certificate::with(['trainee.sport', 'sport']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('certificate_no', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('event_or_course', 'like', "%{$search}%")
                  ->orWhereHas('trainee', function ($t) use ($search) {
                      $t->where('name', 'like', "%{$search}%")
                        ->orWhere('admission_no', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('certificate_type')) {
            $query->where('certificate_type', $request->certificate_type);
        }

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        $certificates = $query->latest('issue_date')->paginate(12)->withQueryString();
        $sports = Sport::all();

        return view('admin.certificates.index', compact('certificates', 'sports'));
    }

    /**
     * Show form for creating a new certificate.
     */
    public function create(Request $request)
    {
        $trainees = Trainee::with('sport')->orderBy('name')->get();
        $sports = Sport::all();
        $selectedTraineeId = $request->query('trainee_id');

        // Auto-generate next certificate number
        $year = date('Y');
        $lastCert = Certificate::latest('id')->first();
        $nextNum = $lastCert ? $lastCert->id + 1 : 1;
        $defaultCertificateNo = 'JSA-CERT-' . $year . '-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        return view('admin.certificates.create', compact('trainees', 'sports', 'selectedTraineeId', 'defaultCertificateNo'));
    }

    /**
     * Store a newly created certificate.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'certificate_no' => 'required|string|unique:certificates,certificate_no|max:50',
            'trainee_id' => 'required|exists:trainees,id',
            'sport_id' => 'nullable|exists:sports,id',
            'title' => 'required|string|max:255',
            'certificate_type' => 'required|in:completion,achievement,participation,appreciation',
            'event_or_course' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'description' => 'required|string',
            'grade_or_rank' => 'nullable|string|max:100',
            'instructor_name' => 'required|string|max:255',
        ]);

        $validated['status'] = 'issued';

        $certificate = Certificate::create($validated);

        return redirect()->route('admin.certificates.show', $certificate)
            ->with('success', 'সনদপত্র সফলভাবে তৈরি হয়েছে!');
    }

    /**
     * Display the specified certificate with print layout and vector QR code.
     */
    public function show(Certificate $certificate)
    {
        $certificate->load(['trainee.sport', 'sport']);

        $verifyUrl = route('public.verify.certificate', $certificate->certificate_no);
        $qrCodeSvg = QrCodeService::svg($verifyUrl, 4);

        return view('admin.certificates.show', compact('certificate', 'qrCodeSvg', 'verifyUrl'));
    }

    /**
     * Remove the specified certificate.
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'সনদপত্র সফলভাবে মুছে ফেলা হয়েছে!');
    }
}


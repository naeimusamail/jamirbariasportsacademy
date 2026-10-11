<?php

namespace App\Http\Controllers;

use App\Models\Trainee;
use App\Models\Certificate;
use Illuminate\Http\Request;

class PublicVerificationController extends Controller
{
    /**
     * Public QR verification endpoint for Player ID Cards
     */
    public function verifyPlayer(string $admission_no)
    {
        $trainee = Trainee::with(['sport', 'batch'])->where('admission_no', $admission_no)->firstOrFail();

        return view('public.verify.player', compact('trainee'));
    }

    /**
     * Public QR verification endpoint for Academy Certificates
     */
    public function verifyCertificate(string $certificate_no)
    {
        $certificate = Certificate::with(['trainee.sport', 'sport'])->where('certificate_no', $certificate_no)->firstOrFail();

        return view('public.verify.certificate', compact('certificate'));
    }
}


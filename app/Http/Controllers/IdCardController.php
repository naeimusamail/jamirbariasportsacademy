<?php

namespace App\Http\Controllers;

use App\Models\Trainee;
use App\Models\Sport;
use App\Models\Batch;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    /**
     * Display ID card center with filters and player selector.
     */
    public function index(Request $request)
    {
        $query = Trainee::with(['sport', 'batch']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $trainees = $query->latest()->paginate(15)->withQueryString();
        $sports = Sport::all();
        $batches = Batch::all();

        return view('admin.id-cards.index', compact('trainees', 'sports', 'batches'));
    }

    /**
     * Show single player digital ID card (Front & Back) with print template.
     */
    public function show(Trainee $trainee)
    {
        $trainee->load(['sport', 'batch']);

        $verifyUrl = route('public.verify.player', $trainee->admission_no);
        $qrCodeSvg = QrCodeService::svg($verifyUrl, 4);

        return view('admin.id-cards.show', compact('trainee', 'qrCodeSvg', 'verifyUrl'));
    }

    /**
     * Bulk print ID cards for selected players or filtered criteria.
     */
    public function bulk(Request $request)
    {
        $traineeIds = $request->input('trainee_ids', []);

        if (!empty($traineeIds)) {
            $trainees = Trainee::with(['sport', 'batch'])->whereIn('id', $traineeIds)->get();
        } else {
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
            $trainees = $query->latest()->take(30)->get();
        }

        $cardsData = $trainees->map(function ($trainee) {
            $verifyUrl = route('public.verify.player', $trainee->admission_no);
            return [
                'trainee' => $trainee,
                'qrSvg' => QrCodeService::svg($verifyUrl, 3),
                'verifyUrl' => $verifyUrl,
            ];
        });

        return view('admin.id-cards.bulk', compact('cardsData'));
    }
}


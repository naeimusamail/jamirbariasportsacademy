<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $batches = Batch::where('status', 'active')->get();
        $selectedBatchId = $request->get('batch_id', $batches->first()?->id);
        $selectedDate = $request->get('date', date('Y-m-d'));

        $selectedBatch = null;
        $trainees = collect();
        $attendances = collect();

        if ($selectedBatchId) {
            $selectedBatch = Batch::with(['trainees' => function($q) {
                $q->where('status', 'active');
            }])->find($selectedBatchId);

            if ($selectedBatch) {
                $trainees = $selectedBatch->trainees;
                $attendances = Attendance::where('batch_id', $selectedBatchId)
                    ->where('date', $selectedDate)
                    ->get()
                    ->keyBy('trainee_id');
            }
        }

        return view('attendances.index', compact(
            'batches',
            'selectedBatchId',
            'selectedDate',
            'selectedBatch',
            'trainees',
            'attendances'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        $batchId = $request->batch_id;
        $date = $request->date;
        $notes = $request->input('notes', []);

        foreach ($request->attendance as $traineeId => $status) {
            Attendance::updateOrCreate(
                [
                    'trainee_id' => $traineeId,
                    'batch_id' => $batchId,
                    'date' => $date,
                ],
                [
                    'status' => in_array($status, ['present', 'absent', 'late']) ? $status : 'present',
                    'note' => $notes[$traineeId] ?? null,
                ]
            );
        }

        return redirect()->route('attendances.index', [
            'batch_id' => $batchId,
            'date' => $date
        ])->with('success', 'হাজিরা সফলভাবে সংরক্ষিত হয়েছে!');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Trainee;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('trainee');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('fee_type')) {
            $query->where('fee_type', $request->fee_type);
        }

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhereHas('trainee', function ($t) use ($search) {
                      $t->where('name', 'like', "%{$search}%")
                        ->orWhere('admission_no', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->latest('payment_date')->paginate(12)->withQueryString();
        $totalCollected = Payment::where('status', 'paid')->sum('amount');
        $totalDue = Payment::where('status', 'due')->sum('amount');

        return view('payments.index', compact('payments', 'totalCollected', 'totalDue'));
    }

    public function create(Request $request)
    {
        $trainees = Trainee::where('status', 'active')->orderBy('name')->get();
        $selectedTraineeId = $request->get('trainee_id');

        $lastPayment = Payment::latest('id')->first();
        $nextId = $lastPayment ? $lastPayment->id + 1 : 1;
        $defaultInvoiceNo = 'INV-2026-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('payments.create', compact('trainees', 'selectedTraineeId', 'defaultInvoiceNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_no' => 'required|unique:payments,invoice_no',
            'trainee_id' => 'required|exists:trainees,id',
            'title' => 'required|string|max:255',
            'fee_type' => 'required|in:monthly,admission,jersey,tournament,other',
            'amount' => 'required|numeric|min:1',
            'month' => 'nullable|string|max:50',
            'year' => 'required|string|size:4',
            'payment_method' => 'required|in:cash,bkash,nagad,rocket,bank',
            'transaction_id' => 'nullable|string|max:100',
            'sender_number' => 'nullable|string|max:50',
            'received_by' => 'nullable|string|max:100',
            'status' => 'required|in:paid,due',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $payment = Payment::create($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'পেমেন্ট রসিদ সফলভাবে তৈরি করা হয়েছে!');
    }

    public function show(Payment $payment)
    {
        $payment->load('trainee.sport', 'trainee.batch');
        return view('payments.show', compact('payment'));
    }

    public function markPaid(Payment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'payment_date' => date('Y-m-d')
        ]);

        return back()->with('success', 'বকেয়া পরিশোধ হিসেবে চিহ্নিত করা হয়েছে!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'পেমেন্ট রেকর্ড মুছে ফেলা হয়েছে!');
    }

    /**
     * Trainees with unpaid monthly fees for specified month/year
     */
    public function defaulters(Request $request)
    {
        $months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        $currentMonth = $request->input('month', 'অক্টোবর');
        $currentYear = $request->input('year', date('Y'));

        $paidTraineeIds = Payment::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('status', 'paid')
            ->where('fee_type', 'monthly')
            ->pluck('trainee_id');

        $query = Trainee::where('status', 'active')
            ->whereNotIn('id', $paidTraineeIds)
            ->with(['sport', 'batch']);

        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $defaulters = $query->paginate(20)->withQueryString();
        $totalDueAmount = Trainee::where('status', 'active')
            ->whereNotIn('id', $paidTraineeIds)
            ->sum('monthly_fee');

        $sports = \App\Models\Sport::all();
        $batches = \App\Models\Batch::all();

        return view('payments.defaulters', compact(
            'defaulters',
            'totalDueAmount',
            'currentMonth',
            'currentYear',
            'months',
            'sports',
            'batches'
        ));
    }

    /**
     * Export Payments List to CSV
     */
    public function export(Request $request)
    {
        $query = Payment::with('trainee');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('fee_type')) {
            $query->where('fee_type', $request->fee_type);
        }
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $payments = $query->latest('payment_date')->get();
        $filename = 'payments_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($payments) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($out, ['ইনভয়েস নং', 'শিক্ষার্থীর নাম', 'ভর্তি নং', 'ফির ধরন', 'বিবরণ', 'পরিমাণ (টাকা)', 'মাস', 'বছর', 'পেমেন্ট মেথড', 'ট্রানজেকশন আইডি', 'স্ট্যাটাস', 'তারিখ']);
            foreach ($payments as $p) {
                fputcsv($out, [
                    $p->invoice_no,
                    $p->trainee->name ?? 'অজানা',
                    $p->trainee->admission_no ?? '',
                    $p->fee_type,
                    $p->title,
                    $p->amount,
                    $p->month ?? '',
                    $p->year,
                    $p->payment_method,
                    $p->transaction_id ?? '',
                    $p->status == 'paid' ? 'পরিশোধিত' : 'বকেয়া',
                    $p->payment_date,
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Tournament;
use App\Models\Volunteer;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['tournament', 'volunteer']);

        if ($request->filled('tournament_id')) {
            $query->where('tournament_id', $request->tournament_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('expense_date', [$request->from_date, $request->to_date]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('item_name', 'like', "%{$search}%")
                  ->orWhere('voucher_no', 'like', "%{$search}%")
                  ->orWhere('paid_to', 'like', "%{$search}%");
            });
        }

        $expenses = $query->latest('expense_date')->paginate(15)->withQueryString();

        // Academy Financial Ledger Overview
        $totalCollectedFees = Payment::where('status', 'paid')->sum('amount');
        $totalExpenses = Expense::sum('amount');
        $netBalance = $totalCollectedFees - $totalExpenses;

        // Current Month's Performance
        $currentMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateString();
        
        $thisMonthFees = Payment::where('status', 'paid')
            ->whereBetween('payment_date', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');

        $thisMonthExpenses = Expense::whereBetween('expense_date', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');

        $thisMonthBalance = $thisMonthFees - $thisMonthExpenses;

        $categories = Expense::categoryNames();
        $tournaments = Tournament::latest()->get();

        return view('expenses.index', compact(
            'expenses',
            'totalCollectedFees',
            'totalExpenses',
            'netBalance',
            'thisMonthFees',
            'thisMonthExpenses',
            'thisMonthBalance',
            'categories',
            'tournaments'
        ));
    }

    public function create()
    {
        // Auto generate next voucher number
        $lastExpense = Expense::latest('id')->first();
        $nextId = $lastExpense ? $lastExpense->id + 1 : 1;
        $defaultVoucherNo = 'EXP-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $categories = Expense::categoryNames();
        $tournaments = Tournament::latest()->get();
        $volunteers = Volunteer::where('status', 'approved')->orderBy('name')->get();

        return view('expenses.create', compact('defaultVoucherNo', 'categories', 'tournaments', 'volunteers'));
    }

    public function store(Request $request)
    {
        if ($request->filled('unit_price') && $request->filled('quantity') && (!$request->filled('amount') || (float)$request->input('amount') <= 0 || $request->input('calc_auto') == '1')) {
            $request->merge([
                'amount' => round((float) $request->unit_price * (float) $request->quantity, 2)
            ]);
        }

        $validated = $request->validate([
            'voucher_no' => 'required|unique:expenses,voucher_no',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'volunteer_id' => 'nullable|exists:volunteers,id',
            'title' => 'required|string|max:255',
            'item_name' => 'nullable|string|max:255',
            'category' => 'required|string',
            'unit_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|numeric|min:0.1',
            'amount' => 'required|numeric|min:0.1',
            'expense_date' => 'required|date',
            'payment_method' => 'required|in:cash,bkash,nagad,bank',
            'paid_to' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:1000',
        ]);

        if ($request->filled('unit_price') && $request->filled('quantity') && (!$request->filled('amount') || $request->input('calc_auto') == '1')) {
            $validated['amount'] = round((float) $request->unit_price * (float) $request->quantity, 2);
        }

        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', "ভাউচার {$validated['voucher_no']} সফলভাবে যুক্ত করা হয়েছে!");
    }

    public function destroy(Expense $expense)
    {
        $voucher = $expense->voucher_no;
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', "ভাউচার {$voucher} মুছে ফেলা হয়েছে!");
    }

    /**
     * Export Expenses to CSV
     */
    public function export(Request $request)
    {
        $query = Expense::query();
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('expense_date', [$request->from_date, $request->to_date]);
        }

        $expenses = $query->latest('expense_date')->get();
        $filename = 'expenses_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($expenses) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($out, ['ভাউচার নং', 'শিরোনাম', 'খাত / ক্যাটাগরি', 'পরিমাণ (টাকা)', 'পেমেন্ট মেথড', 'প্রাপক', 'অনুমোদনকারী', 'তারিখ', 'বিবরণ']);
            foreach ($expenses as $e) {
                fputcsv($out, [
                    $e->voucher_no,
                    $e->title,
                    $e->category,
                    $e->amount,
                    $e->payment_method,
                    $e->paid_to ?? '',
                    $e->approved_by ?? '',
                    $e->expense_date,
                    $e->note ?? '',
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }
}


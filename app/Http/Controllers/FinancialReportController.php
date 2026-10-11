<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    /**
     * Display comprehensive Monthly/Custom Financial Cashbook & P&L Report
     */
    public function index(Request $request)
    {
        $months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        $selectedMonth = $request->input('month', 'অক্টোবর');
        $selectedYear = $request->input('year', date('Y'));
        
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Query Payments
        $paymentQuery = Payment::where('status', 'paid');
        $expenseQuery = Expense::query();

        if ($fromDate && $toDate) {
            $paymentQuery->whereBetween('payment_date', [$fromDate, $toDate]);
            $expenseQuery->whereBetween('expense_date', [$fromDate, $toDate]);
            $filterLabel = "তারিখ: {$fromDate} থেকে {$toDate}";
        } else {
            $paymentQuery->where(function($q) use ($selectedMonth, $selectedYear) {
                $q->where('month', $selectedMonth)->where('year', $selectedYear);
            });
            // Match expenses in same month/year
            $expenseQuery->whereYear('expense_date', $selectedYear);
            $filterLabel = "মাস: {$selectedMonth} {$selectedYear}";
        }

        $totalIncome = (float) $paymentQuery->sum('amount');
        $totalExpense = (float) $expenseQuery->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // Breakdown by Fee Type
        $incomeByType = (clone $paymentQuery)
            ->select('fee_type', DB::raw('sum(amount) as total'), DB::raw('count(*) as count'))
            ->groupBy('fee_type')
            ->get();

        // Breakdown by Payment Method
        $incomeByMethod = (clone $paymentQuery)
            ->select('payment_method', DB::raw('sum(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        // Expense by Category
        $expenseByCategory = (clone $expenseQuery)
            ->select('category', DB::raw('sum(amount) as total'), DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();

        // Chronological combined transactions
        $recentPayments = (clone $paymentQuery)
            ->with('trainee')
            ->latest('payment_date')
            ->take(15)
            ->get();

        $recentExpenses = (clone $expenseQuery)
            ->latest('expense_date')
            ->take(15)
            ->get();

        return view('reports.financial', compact(
            'totalIncome',
            'totalExpense',
            'netBalance',
            'incomeByType',
            'incomeByMethod',
            'expenseByCategory',
            'recentPayments',
            'recentExpenses',
            'selectedMonth',
            'selectedYear',
            'months',
            'fromDate',
            'toDate',
            'filterLabel'
        ));
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Expense;
use App\Models\Volunteer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminTournamentExpenseController extends Controller
{
    /**
     * Display Tournament Financial Hub & Budget Ledger
     */
    public function index(Tournament $tournament, Request $request)
    {
        $query = $tournament->expenses()->with('volunteer');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('item_name', 'like', "%{$s}%")
                  ->orWhere('voucher_no', 'like', "%{$s}%")
                  ->orWhere('paid_to', 'like', "%{$s}%");
            });
        }

        $expenses = $query->paginate(20)->withQueryString();

        // Financial Metrics
        $totalExpenses = (float) $tournament->expenses()->sum('amount');
        $totalIncome = (float) $tournament->total_income;
        $netBalance = $totalIncome - $totalExpenses;

        $volunteerExpenses = (float) $tournament->expenses()->where('category', 'volunteer_allowance')->sum('amount');
        $ballsExpenses = (float) $tournament->expenses()->where('category', 'cricket_balls')->sum('amount');
        $gearExpenses = (float) $tournament->expenses()->where('category', 'sports_gear')->sum('amount');
        $umpireExpenses = (float) $tournament->expenses()->where('category', 'umpire_fees')->sum('amount');
        $groundExpenses = (float) $tournament->expenses()->where('category', 'ground_maintenance')->sum('amount');
        $prizesExpenses = (float) $tournament->expenses()->where('category', 'prizes_trophies')->sum('amount');
        $refreshmentExpenses = (float) $tournament->expenses()->where('category', 'refreshment')->sum('amount');
        $otherExpenses = $totalExpenses - ($volunteerExpenses + $ballsExpenses + $gearExpenses + $umpireExpenses + $groundExpenses + $prizesExpenses + $refreshmentExpenses);

        // Next default voucher
        $nextNum = Expense::where('tournament_id', $tournament->id)->count() + 1;
        $cleanSlug = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $tournament->slug ?? 'TRN'), 0, 4));
        $defaultVoucherNo = 'EXP-' . ($cleanSlug ?: 'TRN') . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        // Associated volunteers
        $volunteers = Volunteer::where(function ($q) use ($tournament) {
            $q->where('tournament_id', $tournament->id)
              ->orWhere('status', 'approved');
        })->orderBy('name')->get();

        $categories = Expense::categoryNames();

        return view('admin.tournaments.finances.index', compact(
            'tournament',
            'expenses',
            'totalExpenses',
            'totalIncome',
            'netBalance',
            'volunteerExpenses',
            'ballsExpenses',
            'gearExpenses',
            'umpireExpenses',
            'groundExpenses',
            'prizesExpenses',
            'refreshmentExpenses',
            'otherExpenses',
            'defaultVoucherNo',
            'volunteers',
            'categories'
        ));
    }

    /**
     * Store new expense voucher for this tournament
     */
    public function store(Tournament $tournament, Request $request)
    {
        if ($request->filled('unit_price') && $request->filled('quantity') && (!$request->filled('amount') || (float)$request->input('amount') <= 0 || $request->input('calc_auto') == '1')) {
            $request->merge([
                'amount' => round((float) $request->unit_price * (float) $request->quantity, 2)
            ]);
        }

        $validated = $request->validate([
            'voucher_no' => 'required|string|max:100|unique:expenses,voucher_no',
            'title' => 'required|string|max:255',
            'item_name' => 'nullable|string|max:255',
            'category' => 'required|string',
            'unit_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|numeric|min:0.1',
            'amount' => 'required|numeric|min:0.1',
            'expense_date' => 'required|date',
            'payment_method' => 'required|in:cash,bkash,nagad,bank',
            'paid_to' => 'nullable|string|max:255',
            'volunteer_id' => 'nullable|exists:volunteers,id',
            'note' => 'nullable|string|max:1000',
            'receipt' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $validated['tournament_id'] = $tournament->id;

        // If unit price & quantity passed and user wants calculation
        if ($request->filled('unit_price') && $request->filled('quantity') && (!$request->filled('amount') || $request->input('calc_auto') == '1')) {
            $validated['amount'] = round((float) $request->unit_price * (float) $request->quantity, 2);
        }

        // Receipt Upload
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_photo'] = $path;
        }

        Expense::create($validated);

        return back()->with('success', "ভাউচার {$validated['voucher_no']} সফলভাবে টুর্নামেন্ট খরচে যুক্ত হয়েছে!");
    }

    /**
     * Remove an expense voucher from tournament
     */
    public function destroy(Tournament $tournament, Expense $expense)
    {
        if ($expense->tournament_id !== $tournament->id) {
            abort(403);
        }

        $voucher = $expense->voucher_no;

        if ($expense->receipt_photo && Storage::disk('public')->exists($expense->receipt_photo)) {
            Storage::disk('public')->delete($expense->receipt_photo);
        }

        $expense->delete();

        return back()->with('success', "ভাউচার {$voucher} সফলভাবে মুছে ফেলা হয়েছে!");
    }

    /**
     * Printable Official Financial Ledger Statement
     */
    public function print(Tournament $tournament)
    {
        $expenses = $tournament->expenses()->with('volunteer')->get();
        $totalExpenses = (float) $expenses->sum('amount');
        $totalIncome = (float) $tournament->total_income;
        $netBalance = $totalIncome - $totalExpenses;
        $categories = Expense::categoryNames();

        return view('admin.tournaments.finances.print', compact(
            'tournament',
            'expenses',
            'totalExpenses',
            'totalIncome',
            'netBalance',
            'categories'
        ));
    }

    /**
     * Export Tournament Expenses to CSV
     */
    public function export(Tournament $tournament)
    {
        $expenses = $tournament->expenses()->with('volunteer')->get();
        $filename = 'tournament_expenses_' . $tournament->slug . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($expenses, $tournament) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($out, [
                'টুর্নামেন্ট',
                'ভাউচার নং',
                'তারিখ',
                'শিরোনাম',
                'সরঞ্জাম / আইটেম বিবরণ',
                'খাত / ক্যাটাগরি',
                'একক দর (৳)',
                'পরিমাণ / সংখ্যা',
                'মোট টাকা (৳)',
                'পেমেন্ট মেথড',
                'প্রাপক ব্যক্তি / প্রতিষ্ঠান',
                'যুক্ত ভলান্টিয়ার',
                'মন্তব্য'
            ]);

            $cats = Expense::categoryNames();

            foreach ($expenses as $exp) {
                fputcsv($out, [
                    $tournament->name,
                    $exp->voucher_no,
                    $exp->expense_date->format('d/m/Y'),
                    $exp->title,
                    $exp->item_name ?? '-',
                    $cats[$exp->category] ?? $exp->category,
                    $exp->unit_price ? number_format($exp->unit_price, 2) : '-',
                    $exp->quantity ?? 1,
                    number_format($exp->amount, 2),
                    strtoupper($exp->payment_method),
                    $exp->paid_to ?? '-',
                    $exp->volunteer ? ($exp->volunteer->name . ' (' . $exp->volunteer->volunteer_no . ')') : '-',
                    $exp->note ?? '-',
                ]);
            }

            fclose($out);
        }, 200, $headers);
    }
}

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>💳</span> {{ __('একাডেমি হিসাব ও খরচ ব্যবস্থাপনা') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    মাঠ রক্ষণাবেক্ষণ, সরঞ্জাম, কোচের বেতন ও আয়-ব্যয়ের সার্বিক হিসাব
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('reports.financial') }}" class="px-3.5 py-2 bg-teal-500/10 hover:bg-teal-500/20 text-teal-600 dark:text-teal-400 border border-teal-500/30 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <span>📊 P&L ক্যাশ বুক</span>
                </a>
                <a href="{{ route('expenses.export', request()->query()) }}" class="px-3.5 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <span>📥 CSV এক্সপোর্ট</span>
                </a>
                <button onclick="window.print()" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow transition flex items-center gap-1.5">
                    <span>🖨️ স্টেটমেন্ট প্রিন্ট</span>
                </button>
                <a href="{{ route('expenses.create') }}" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center gap-1.5">
                    <span>+ নতুন খরচ ভাউচার</span>
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            body * { visibility: hidden; }
            #printable-ledger, #printable-ledger * { visibility: visible; }
            #printable-ledger {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                background: white !important;
                color: black !important;
            }
            .no-print { display: none !important; }
        }
    </style>

    <div class="py-8">
        <div id="printable-ledger" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="no-print p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Overall Financial Ledger Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Total Income (Collected Fees) -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-emerald-500/30 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-emerald-600 dark:text-emerald-400 tracking-wider">মোট আদায়কৃত ফি (Income)</span>
                        <span class="text-2xl">💰</span>
                    </div>
                    <div class="text-3xl font-black text-gray-900 dark:text-white mt-2">
                        ৳{{ number_format($totalCollectedFees) }}
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">চলতি মাসে ফি আদায়: <strong>৳{{ number_format($thisMonthFees) }}</strong></p>
                </div>

                <!-- Total Expenses -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-rose-500/30 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-rose-600 dark:text-rose-400 tracking-wider">মোট একাডেমি ব্যয় (Expenses)</span>
                        <span class="text-2xl">💸</span>
                    </div>
                    <div class="text-3xl font-black text-rose-600 dark:text-rose-400 mt-2">
                        ৳{{ number_format($totalExpenses) }}
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">চলতি মাসে মোট খরচ: <strong>৳{{ number_format($thisMonthExpenses) }}</strong></p>
                </div>

                <!-- Net Surplus / Balance -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-indigo-500/30 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-wider">নেট উদ্বৃত্ত / ব্যালেন্স (Net Fund)</span>
                        <span class="text-2xl">⚖️</span>
                    </div>
                    <div class="text-3xl font-black {{ $netBalance >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600' }} mt-2">
                        ৳{{ number_format($netBalance) }}
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">
                        চলতি মাসের উদ্বৃত্ত: <strong class="{{ $thisMonthBalance >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">৳{{ number_format($thisMonthBalance) }}</strong>
                    </p>
                </div>
            </div>

            <!-- Filter & Search Toolbar (Hidden on Print) -->
            <div class="no-print bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('expenses.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-6 gap-3">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ভাউচার, সরঞ্জাম বা প্রাপক..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                    </div>

                    <div>
                        <select name="tournament_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                            <option value="">সকল টুর্নামেন্ট ও একাডেমি</option>
                            @foreach($tournaments as $t)
                                <option value="{{ $t->id }}" {{ request('tournament_id') == $t->id ? 'selected' : '' }}>🏆 {{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="category" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                            <option value="">সকল খরচের খাত</option>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="payment_method" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                            <option value="">সকল পেমেন্ট মাধ্যম</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>নগদ (Cash)</option>
                            <option value="bkash" {{ request('payment_method') == 'bkash' ? 'selected' : '' }}>বিকাশ (bKash)</option>
                            <option value="nagad" {{ request('payment_method') == 'nagad' ? 'selected' : '' }}>নগদ (Nagad)</option>
                            <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>ব্যাংক ট্রান্সফার</option>
                        </select>
                    </div>

                    <div>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500" title="হতে">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-2 px-3 bg-gray-900 dark:bg-gray-700 hover:bg-gray-800 text-white rounded-xl text-xs font-semibold transition">
                            ফিল্টার
                        </button>
                        <a href="{{ route('expenses.index') }}" class="py-2 px-3 bg-gray-100 dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-semibold transition">
                            রিসেট
                        </a>
                    </div>
                </form>
            </div>

            <!-- Expense Vouchers Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/60 border-b border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">
                                <th class="p-4">ভাউচার নং</th>
                                <th class="p-4">তারিখ</th>
                                <th class="p-4">খরচের শিরোনাম ও বিবরণ</th>
                                <th class="p-4">খাত (Category)</th>
                                <th class="p-4">প্রাপক (Paid To)</th>
                                <th class="p-4">মাধ্যম</th>
                                <th class="p-4">পরিমাণ (টাকা)</th>
                                <th class="p-4 text-right no-print">পদক্ষেপ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($expenses as $exp)
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition">
                                    <td class="p-4 font-mono font-bold text-rose-600 dark:text-rose-400">
                                        {{ $exp->voucher_no }}
                                    </td>
                                    <td class="p-4 text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($exp->expense_date)->format('d M, Y') }}
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $exp->title }}</div>
                                        @if($exp->tournament)
                                            <div class="mt-1">
                                                <a href="{{ route('admin.tournaments.finances', $exp->tournament) }}" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 hover:underline">
                                                    🏆 {{ $exp->tournament->name }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($exp->item_name)
                                            <div class="text-[11px] text-indigo-600 dark:text-indigo-400 font-medium mt-0.5">
                                                📦 {{ $exp->item_name }}
                                                @if($exp->quantity || $exp->unit_price)
                                                    <span class="text-gray-500">({{ $exp->quantity ?? 1 }} পিস × ৳{{ number_format($exp->unit_price ?? 0) }})</span>
                                                @endif
                                            </div>
                                        @endif
                                        @if($exp->volunteer)
                                            <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium mt-0.5">
                                                🤝 ভলান্টিয়ার: {{ $exp->volunteer->name }} ({{ $exp->volunteer->volunteer_no }})
                                            </div>
                                        @endif
                                        @if($exp->note)
                                            <div class="text-[11px] text-gray-400 mt-0.5">{{ $exp->note }}</div>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $categories[$exp->category] ?? $exp->category }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-700 dark:text-gray-300">
                                        {{ $exp->paid_to ?? '-' }}
                                    </td>
                                    <td class="p-4 uppercase font-mono text-[11px] text-gray-500 dark:text-gray-400">
                                        {{ $exp->payment_method }}
                                    </td>
                                    <td class="p-4 font-mono font-black text-rose-600 dark:text-rose-400 text-sm">
                                        ৳{{ number_format($exp->amount) }}
                                    </td>
                                    <td class="p-4 text-right no-print">
                                        <form action="{{ route('expenses.destroy', $exp) }}" method="POST" onsubmit="return confirm('ভাউচারটি মুছে ফেলতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold text-xs">
                                                মুছুন ✕
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-gray-400">
                                        কোনো খরচের ভাউচার রেকর্ড পাওয়া যায়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($expenses->hasPages())
                    <div class="no-print p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $expenses->links() }}
                    </div>
                @endif
            </div>

            <!-- Printable Footer -->
            <div class="p-6 bg-gray-50 dark:bg-gray-900/40 rounded-2xl border border-gray-100 dark:border-gray-700 flex justify-between items-center text-xs text-gray-500">
                <div>
                    জামিরবাড়িয়া স্পোর্টস একাডেমি • অভ্যন্তরীণ ব্যয় ও আর্থিক লেজার
                </div>
                <div class="text-right">
                    প্রিন্ট তারিখ: {{ date('d M, Y') }} | অনুমোদিত অ্যাকাউন্টস সাক্ষর
                </div>
            </div>

        </div>
    </div>
</x-app-layout>


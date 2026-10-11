<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>📊</span> {{ __('আর্থিক ক্যাশ বুক ও লাভ-ক্ষতির বিবরণী (P&L Statement)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    জামিরবাড়িয়া স্পোর্টস একাডেমির সমন্বিত আয়, ব্যয় ও আর্থিক হিসাব বিবরণী
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('payments.defaulters') }}" class="px-3.5 py-2 bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <span>⚠️ বকেয়া ফি তালিকা</span>
                </a>
                <button onclick="window.print()" class="px-3.5 py-2 bg-slate-900 dark:bg-slate-700 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow transition flex items-center gap-1.5">
                    <span>🖨️ ক্যাশ বুক প্রিন্ট</span>
                </button>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            body * { visibility: hidden; }
            #printable-financial, #printable-financial * { visibility: visible; }
            #printable-financial {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                background: white !important;
                color: black !important;
                padding: 10px;
            }
            .no-print { display: none !important; }
            .print-black { color: #000 !important; }
        }
    </style>

    <div class="py-8">
        <div id="printable-financial" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Filter Controls (Hidden on Print) -->
            <div class="no-print bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('reports.financial') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">মাস নির্বাচন করুন</label>
                        <select name="month" class="w-full text-xs font-medium rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                            @foreach($months as $m)
                                <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">সাল নির্বাচন</label>
                        <select name="year" class="w-full text-xs font-medium rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                            @for($y = date('Y') + 1; $y >= 2023; $y--)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 dark:text-gray-400 mb-1">তারিখ থেকে</label>
                            <input type="date" name="from_date" value="{{ $fromDate ?? '' }}" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 dark:text-gray-400 mb-1">তারিখ পর্যন্ত</label>
                            <input type="date" name="to_date" value="{{ $toDate ?? '' }}" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow transition text-center">
                            🔍 ফিল্টার প্রয়োগ করুন
                        </button>
                        <a href="{{ route('reports.financial') }}" class="px-3 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold transition flex items-center justify-center">
                            রিসেট
                        </a>
                    </div>
                </form>
            </div>

            <!-- Print Header Banner (Shown on print or screen) -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white p-6 rounded-3xl shadow-lg flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl font-black">
                        ⚽
                    </div>
                    <div>
                        <h1 class="text-2xl font-black tracking-tight">জামিরবাড়িয়া স্পোর্টস একাডেমি</h1>
                        <p class="text-xs text-emerald-100 mt-0.5">আর্থিক বিবরণী ও সমন্বিত ক্যাশ বুক • {{ $filterLabel }}</p>
                        <p class="text-[11px] text-emerald-200">রিপোর্ট তৈরি তারিখ: {{ date('d F, Y h:i A') }}</p>
                    </div>
                </div>
                <div class="text-right bg-white/10 px-5 py-3 rounded-2xl border border-white/20">
                    <span class="text-xs font-bold text-emerald-100 uppercase tracking-widest block">নিট ব্যালেন্স / স্থিতি</span>
                    <span class="text-3xl font-black {{ $netBalance >= 0 ? 'text-white' : 'text-rose-200' }}">
                        {{ $netBalance >= 0 ? '+' : '' }}৳{{ number_format($netBalance) }}
                    </span>
                </div>
            </div>

            <!-- 3 Core Financial KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- Total Inflows (Payments) -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-emerald-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-emerald-600 dark:text-emerald-400 tracking-wider">মোট আদায়কৃত আয় (Income)</span>
                        <span class="text-2xl">💰</span>
                    </div>
                    <div class="text-3xl font-black text-gray-900 dark:text-white mt-2">
                        ৳{{ number_format($totalIncome) }}
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">শিক্ষার্থীদের ফি ও অনুদান থেকে সংগৃহীত</p>
                </div>

                <!-- Total Outflows (Expenses) -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-rose-500/30">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-rose-600 dark:text-rose-400 tracking-wider">মোট খরচ / ব্যয় (Expenses)</span>
                        <span class="text-2xl">💸</span>
                    </div>
                    <div class="text-3xl font-black text-rose-600 dark:text-rose-400 mt-2">
                        ৳{{ number_format($totalExpense) }}
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">কোচ বেতন, সরঞ্জাম ও আনুষঙ্গিক খরচ</p>
                </div>

                <!-- Operating Balance / Net Profit -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border {{ $netBalance >= 0 ? 'border-teal-500/30' : 'border-rose-500/30' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase {{ $netBalance >= 0 ? 'text-teal-600 dark:text-teal-400' : 'text-rose-600 dark:text-rose-400' }} tracking-wider">চলতি আর্থিক স্থিতি (Net Balance)</span>
                        <span class="text-2xl">{{ $netBalance >= 0 ? '📈' : '📉' }}</span>
                    </div>
                    <div class="text-3xl font-black {{ $netBalance >= 0 ? 'text-teal-600 dark:text-teal-400' : 'text-rose-600 dark:text-rose-400' }} mt-2">
                        ৳{{ number_format($netBalance) }}
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ $netBalance >= 0 ? 'সারপ্লাস / উদ্বৃত্ত ফান্ড' : 'ঘাটতি তহবিল (Deficit)' }}
                    </p>
                </div>
            </div>

            <!-- Two-Column Breakdown: Incomes vs Expenses by Category -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Income Breakdown Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                        <span>📥</span> ফি ও আয়ের বিবরণ (Income by Type)
                    </h3>
                    @if($incomeByType->count() > 0)
                        <div class="space-y-3">
                            @foreach($incomeByType as $item)
                                @php
                                    $pct = $totalIncome > 0 ? round(($item->total / $totalIncome) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-xs font-semibold mb-1">
                                        <span class="text-gray-700 dark:text-gray-300">{{ $item->fee_type }} ({{ $item->count }} টি লেনদেন)</span>
                                        <span class="text-emerald-600 dark:text-emerald-400">৳{{ number_format($item->total) }} ({{ $pct }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-400 py-6 text-center">এই সময়ের মধ্যে কোনো ফি সংগ্রহের রেকর্ড পাওয়া যায়নি।</p>
                    @endif

                    <!-- Payment Methods Distribution -->
                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 block mb-2">পেমেন্ট মেথড অনুযায়ী সংগৃহীত:</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($incomeByMethod as $method)
                                <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs font-bold text-gray-700 dark:text-gray-300">
                                    {{ $method->payment_method }}: ৳{{ number_format($method->total) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Expense Breakdown Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                        <span>📤</span> ব্যয়ের খাতওয়ারি বিবরণ (Expenses by Category)
                    </h3>
                    @if($expenseByCategory->count() > 0)
                        <div class="space-y-3">
                            @foreach($expenseByCategory as $cat)
                                @php
                                    $pct = $totalExpense > 0 ? round(($cat->total / $totalExpense) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-xs font-semibold mb-1">
                                        <span class="text-gray-700 dark:text-gray-300">{{ $cat->category }} ({{ $cat->count }} টি ভাউচার)</span>
                                        <span class="text-rose-600 dark:text-rose-400">৳{{ number_format($cat->total) }} ({{ $pct }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                        <div class="bg-rose-500 h-full rounded-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-400 py-6 text-center">এই সময়ের মধ্যে কোনো খরচের ভাউচার রেকর্ড করা হয়নি।</p>
                    @endif
                </div>
            </div>

            <!-- Detailed Transactions Ledger -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>📋</span> ক্যাশ বুক সাম্প্রতিক লেনদেন রেজিস্টার
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">আয় ও ব্যয়ের সর্বশেষ সমন্বিত লেনদেন তালিকা</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-gray-100 dark:divide-gray-700">
                    <!-- Inflows Column -->
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">📥 ফি আদায়ের রেকর্ড</span>
                            <span class="text-xs text-gray-400">{{ $recentPayments->count() }} টি রেকর্ড</span>
                        </div>
                        <div class="space-y-2">
                            @forelse($recentPayments as $pay)
                                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl flex items-center justify-between text-xs">
                                    <div>
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $pay->trainee->name ?? 'অজানা' }}</div>
                                        <div class="text-[11px] text-gray-500 dark:text-gray-400">{{ $pay->fee_type }} • {{ $pay->month ?? '' }} • {{ $pay->payment_method }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $pay->payment_date ? \Carbon\Carbon::parse($pay->payment_date)->format('d M, Y') : '' }}</div>
                                    </div>
                                    <div class="font-black text-emerald-600 dark:text-emerald-400 text-sm">
                                        +৳{{ number_format($pay->amount) }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 py-4 text-center">কোনো রেকর্ড নেই</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Outflows Column -->
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-rose-600 uppercase tracking-wider">📤 খরচের রেকর্ড</span>
                            <span class="text-xs text-gray-400">{{ $recentExpenses->count() }} টি ভাউচার</span>
                        </div>
                        <div class="space-y-2">
                            @forelse($recentExpenses as $exp)
                                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl flex items-center justify-between text-xs">
                                    <div>
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $exp->title }}</div>
                                        <div class="text-[11px] text-gray-500 dark:text-gray-400">{{ $exp->category }} • {{ $exp->payment_method }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $exp->expense_date ? \Carbon\Carbon::parse($exp->expense_date)->format('d M, Y') : '' }}</div>
                                    </div>
                                    <div class="font-black text-rose-600 dark:text-rose-400 text-sm">
                                        -৳{{ number_format($exp->amount) }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 py-4 text-center">কোনো রেকর্ড নেই</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Official Signatures Footer (Visible on Print) -->
            <div class="pt-12 grid grid-cols-3 gap-6 text-center text-xs text-gray-600 dark:text-gray-400">
                <div class="border-t border-gray-300 dark:border-gray-700 pt-2">
                    <p class="font-bold text-gray-900 dark:text-white">হিসাবরক্ষক</p>
                    <p class="text-[11px] text-gray-500">জামিরবাড়িয়া স্পোর্টস একাডেমি</p>
                </div>
                <div class="border-t border-gray-300 dark:border-gray-700 pt-2">
                    <p class="font-bold text-gray-900 dark:text-white">সাধারণ সম্পাদক</p>
                    <p class="text-[11px] text-gray-500">জামিরবাড়িয়া স্পোর্টস একাডেমি</p>
                </div>
                <div class="border-t border-gray-300 dark:border-gray-700 pt-2">
                    <p class="font-bold text-gray-900 dark:text-white">সভাপতি / পরিচালক</p>
                    <p class="text-[11px] text-gray-500">জামিরবাড়িয়া স্পোর্টস একাডেমি</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>


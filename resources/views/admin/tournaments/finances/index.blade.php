<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                    <a href="{{ route('admin.tournaments.index') }}" class="hover:text-emerald-400 transition">টুর্নামেন্ট তালিকা</a>
                    <span>/</span>
                    <a href="{{ route('admin.tournaments.show', $tournament) }}" class="hover:text-emerald-400 transition">{{ $tournament->name }}</a>
                    <span>/</span>
                    <span class="text-emerald-400 font-bold">আয়-ব্যয় ও অডিট হিসাব</span>
                </div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
                    <span>💰</span> {{ $tournament->name }} - আর্থিক হিসাব ও বাজেট লেজার
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    ভলান্টিয়ার খরচ, ব্যাট-বল ও সামগ্রী, আম্পায়ার ফি, গ্রাউন্ড ও পুরস্কারের যাবতীয় আয়-ব্যয় ব্যবস্থাপনা
                </p>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.tournaments.finances.print', $tournament) }}" target="_blank"
                   class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow">
                    <span>🖨️</span> মুদ্রণযোগ্য অডিট রিপোর্ট
                </a>
                <a href="{{ route('admin.tournaments.finances.export', $tournament) }}"
                   class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow">
                    <span>📥</span> CSV এক্সপোর্ট
                </a>
                <a href="{{ route('admin.tournaments.show', $tournament) }}"
                   class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow">
                    <span>🏆</span> টুর্নামেন্ট কনসোল
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Feedback Alerts -->
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-2xl text-xs font-bold">
                <span class="text-lg">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-300 rounded-2xl text-xs space-y-1">
                <strong class="font-bold flex items-center gap-1.5">⚠️ নিচের ত্রুটিগুলো সংশোধন করুন:</strong>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 1. Tournament Financial KPI Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total Income -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-slate-400 mb-1">
                    <span>টিম এন্ট্রি ফি আয়</span>
                    <span class="text-base">💳</span>
                </div>
                <div class="text-2xl font-black text-emerald-400 font-mono">
                    ৳{{ number_format($totalIncome, 2) }}
                </div>
                <div class="text-[11px] text-slate-500 mt-1">
                    {{ $tournament->tournamentTeams->count() }}টি দল × ৳{{ number_format($tournament->entry_fee, 2) }}
                </div>
            </div>

            <!-- Total Expenses -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-slate-400 mb-1">
                    <span>টুর্নামেন্টের মোট ব্যয়</span>
                    <span class="text-base">💸</span>
                </div>
                <div class="text-2xl font-black text-rose-400 font-mono">
                    ৳{{ number_format($totalExpenses, 2) }}
                </div>
                <div class="text-[11px] text-slate-500 mt-1">
                    মোট {{ $expenses->total() }}টি ভাউচার এন্ট্রি
                </div>
            </div>

            <!-- Net Balance -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-slate-400 mb-1">
                    <span>নেট ব্যালেন্স / তহবিল</span>
                    <span class="text-base">📊</span>
                </div>
                <div class="text-2xl font-black font-mono {{ $netBalance >= 0 ? 'text-teal-400' : 'text-amber-400' }}">
                    ৳{{ number_format($netBalance, 2) }}
                </div>
                <div class="text-[11px] mt-1 font-bold {{ $netBalance >= 0 ? 'text-teal-500' : 'text-amber-500' }}">
                    {{ $netBalance >= 0 ? 'উদ্বৃত্ত তহবিল' : 'ঘাটতি বাজেট' }}
                </div>
            </div>

            <!-- Volunteer Total -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-slate-400 mb-1">
                    <span>ভলান্টিয়ার বাবদ ব্যয়</span>
                    <span class="text-base">🤝</span>
                </div>
                <div class="text-2xl font-black text-amber-400 font-mono">
                    ৳{{ number_format($volunteerExpenses, 2) }}
                </div>
                <div class="text-[11px] text-slate-500 mt-1">
                    টি-শার্ট, খাবার ও এলাউন্স
                </div>
            </div>

            <!-- Bats, Balls & Gear Total -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-slate-400 mb-1">
                    <span>ব্যাট, বল ও সামগ্রী</span>
                    <span class="text-base">🏏</span>
                </div>
                <div class="text-2xl font-black text-blue-400 font-mono">
                    ৳{{ number_format($gearExpenses + $ballsExpenses, 2) }}
                </div>
                <div class="text-[11px] text-slate-500 mt-1">
                    বল: ৳{{ number_format($ballsExpenses) }} | ব্যাট: ৳{{ number_format($gearExpenses) }}
                </div>
            </div>
        </div>

        <!-- 2. Add New Expense Voucher Form -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-amber-600 flex items-center justify-center text-white text-lg shadow-lg">
                        ➕
                    </div>
                    <div>
                        <h3 class="text-base font-black text-white">নতুন টুর্নামেন্ট খরচ এন্ট্রি (ভাউচার প্রস্তুত)</h3>
                        <p class="text-xs text-slate-400">ভলান্টিয়ারদের খাবার/ভাতা, ব্যাট, বল, আম্পায়ার ফি বা গ্রাউন্ড খরচের ভাউচার যোগ করুন</p>
                    </div>
                </div>
                <span class="text-xs font-mono text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3 py-1 rounded-lg">
                    অটো ভাউচার: {{ $defaultVoucherNo }}
                </span>
            </div>

            <form action="{{ route('admin.tournaments.finances.store', $tournament) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="expenseForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Voucher No -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">ভাউচার নম্বর *</label>
                        <input type="text" name="voucher_no" value="{{ old('voucher_no', $defaultVoucherNo) }}" required
                               class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs font-mono text-white focus:outline-none focus:border-emerald-500">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">খরচের খাত / ক্যাটাগরি *</label>
                        <select name="category" id="expense_category" required
                                class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500">
                            <option value="">খাত নির্বাচন করুন...</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">খরচের তারিখ *</label>
                        <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required
                               class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>

                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-300 mb-1">খরচের শিরোনাম / বিবরণ *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="উদা: টুর্নামেন্টের জন্য ৩ ডজন লাল ক্রিকেট বল ক্রয়"
                               class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>

                    <!-- Item Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">সরঞ্জাম / আইটেম নাম</label>
                        <input type="text" name="item_name" value="{{ old('item_name') }}" placeholder="উদা: কোকাভুরা বল / এসএস ব্যাট / লাঞ্চ প্যাকেট"
                               class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>

                    <!-- Volunteer Selector (Conditional / Always Available) -->
                    <div id="volunteer_select_wrapper" class="md:col-span-2">
                        <label class="block text-xs font-bold text-amber-400 mb-1 flex items-center justify-between">
                            <span>🤝 সংশ্লিষ্ট ভলান্টিয়ার (প্রযোজ্য হলে নির্বাচন করুন)</span>
                            <span class="text-[10px] text-slate-400 font-normal">ভলান্টিয়ারের নামে ভাউচার তৈরি হবে</span>
                        </label>
                        <select name="volunteer_id" id="volunteer_id"
                                class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-amber-500">
                            <option value="">কোনো নির্দিষ্ট ভলান্টিয়ার নয় (সাধারণ টিম খরচ)</option>
                            @foreach($volunteers as $v)
                                <option value="{{ $v->id }}" {{ old('volunteer_id') == $v->id ? 'selected' : '' }}>
                                    {{ $v->name }} ({{ $v->volunteer_no }}) - {{ $v->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Paid To -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">প্রাপক ব্যক্তি / দোকান / বিক্রেতা</label>
                        <input type="text" name="paid_to" id="paid_to" value="{{ old('paid_to') }}" placeholder="দোকান বা ব্যক্তির নাম"
                               class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>

                    <!-- Realtime Auto Calculator: Unit Price, Quantity, Total Amount -->
                    <div class="bg-slate-950/80 p-4 rounded-2xl border border-slate-800 md:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 mb-1">একক মূল্য (Unit Price ৳)</label>
                            <input type="number" step="0.01" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" placeholder="উদা: ৭৫০"
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-mono text-white focus:outline-none focus:border-emerald-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 mb-1">সংখ্যা / পরিমাণ (Quantity)</label>
                            <input type="number" step="0.1" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" placeholder="উদা: ১২"
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-mono text-white focus:outline-none focus:border-emerald-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-emerald-400 mb-1 flex items-center justify-between">
                                <span>মোট টাকার পরিমাণ (Total Amount ৳) *</span>
                                <span class="text-[10px] text-slate-400 font-normal">স্বয়ংক্রিয় গুণ</span>
                            </label>
                            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="উদা: ৯০০০"
                                   class="w-full px-3 py-2 bg-slate-900 border border-emerald-500/50 rounded-lg text-sm font-black font-mono text-emerald-300 focus:outline-none focus:border-emerald-400 shadow-inner">
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">পেমেন্ট মেথড *</label>
                        <select name="payment_method" required
                                class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500">
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>💵 ক্যাশ (নগদ)</option>
                            <option value="bkash" {{ old('payment_method') == 'bkash' ? 'selected' : '' }}>📱 বিকাশ (bKash)</option>
                            <option value="nagad" {{ old('payment_method') == 'nagad' ? 'selected' : '' }}>🟧 নগদ (Nagad)</option>
                            <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>🏦 ব্যাংক ট্রান্সফার</option>
                        </select>
                    </div>

                    <!-- Receipt Photo Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">রসিদ / মেমো / ক্যাশমেমো ছবি</label>
                        <input type="file" name="receipt" accept="image/*"
                               class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700 cursor-pointer">
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">অতিরিক্ত নোট / বিবরণ</label>
                        <input type="text" name="note" value="{{ old('note') }}" placeholder="উদা: ফাইনাল ম্যাচের আম্পায়ার ফি"
                               class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800 flex justify-end">
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black rounded-xl text-xs shadow-lg shadow-emerald-900/30 transition flex items-center gap-2">
                        <span>💾</span>
                        <span>ভাউচার সংরক্ষণ করুন</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- 3. Expenses Breakdown Ledger Table -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden">
            <!-- Table Filter Toolbar -->
            <div class="p-5 md:p-6 bg-slate-850/60 border-b border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-xl">📋</span>
                    <div>
                        <h3 class="text-base font-black text-white">টুর্নামেন্ট খরচের পূর্ণাঙ্গ লেজার খতিয়ান</h3>
                        <p class="text-xs text-slate-400">প্রতিটি ভাউচারের আইটেম, দর, পরিমাণ ও গ্রহীতার বিবরণ</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.tournaments.finances', $tournament) }}" class="flex items-center gap-2 flex-wrap">
                    <select name="category" onchange="this.form.submit()"
                            class="text-xs px-3 py-1.5 rounded-lg bg-slate-950 border border-slate-700 text-white focus:outline-none focus:border-emerald-500">
                        <option value="">সকল খাত (All Categories)</option>
                        @foreach($categories as $key => $lbl)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ভাউচার বা আইটেম খুঁজুন..."
                           class="text-xs px-3 py-1.5 rounded-lg bg-slate-950 border border-slate-700 text-white focus:outline-none focus:border-emerald-500">

                    <button type="submit" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold rounded-lg border border-slate-700">
                        ফিল্টার
                    </button>

                    @if(request('category') || request('search'))
                        <a href="{{ route('admin.tournaments.finances', $tournament) }}" class="text-xs text-slate-400 hover:text-white px-2">
                            রিসেট
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-950/80 text-[10px] uppercase font-bold text-slate-400 border-b border-slate-800">
                        <tr>
                            <th class="px-4 py-3">ভাউচার নং ও তারিখ</th>
                            <th class="px-4 py-3">শিরোনাম ও আইটেম বিবরণ</th>
                            <th class="px-4 py-3">খাত / ক্যাটাগরি</th>
                            <th class="px-4 py-3 text-right">একক দর × সংখ্যা</th>
                            <th class="px-4 py-3 text-right">মোট টাকা (৳)</th>
                            <th class="px-4 py-3">প্রাপক / ভলান্টিয়ার</th>
                            <th class="px-4 py-3 text-center">মেমো</th>
                            <th class="px-4 py-3 text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 font-medium">
                        @forelse($expenses as $exp)
                            @php
                                $badge = $exp->category_badge;
                            @endphp
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-4 py-3.5">
                                    <div class="font-mono font-bold text-white">{{ $exp->voucher_no }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">{{ $exp->expense_date->format('d M Y') }}</div>
                                </td>

                                <td class="px-4 py-3.5">
                                    <div class="font-bold text-white">{{ $exp->title }}</div>
                                    @if($exp->item_name)
                                        <div class="text-[11px] text-amber-300 font-semibold flex items-center gap-1 mt-0.5">
                                            <span>📦 আইটেম:</span>
                                            <span>{{ $exp->item_name }}</span>
                                        </div>
                                    @endif
                                    @if($exp->note)
                                        <div class="text-[10px] text-slate-400 mt-0.5 truncate max-w-xs">{{ $exp->note }}</div>
                                    @endif
                                </td>

                                <td class="px-4 py-3.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge['bg'] }}">
                                        <span>{{ $badge['icon'] }}</span>
                                        <span>{{ $exp->category_label }}</span>
                                    </span>
                                </td>

                                <td class="px-4 py-3.5 text-right font-mono">
                                    @if($exp->unit_price)
                                        <div class="text-slate-300">৳{{ number_format($exp->unit_price, 2) }}</div>
                                        <div class="text-[10px] text-slate-400">× {{ $exp->quantity }}</div>
                                    @else
                                        <span class="text-slate-500">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3.5 text-right font-mono">
                                    <div class="text-sm font-black text-rose-400">
                                        ৳{{ number_format($exp->amount, 2) }}
                                    </div>
                                    <span class="text-[9px] uppercase px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">
                                        {{ $exp->payment_method }}
                                    </span>
                                </td>

                                <td class="px-4 py-3.5">
                                    @if($exp->volunteer)
                                        <div class="font-bold text-amber-400 flex items-center gap-1">
                                            <span>🤝</span>
                                            <span>{{ $exp->volunteer->name }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $exp->volunteer->volunteer_no }}</div>
                                    @elseif($exp->paid_to)
                                        <div class="text-slate-200">{{ $exp->paid_to }}</div>
                                    @else
                                        <span class="text-slate-500">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3.5 text-center">
                                    @if($exp->receipt_photo)
                                        <a href="{{ asset('storage/' . $exp->receipt_photo) }}" target="_blank"
                                           class="inline-block px-2 py-1 rounded bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-slate-700 text-[10px] font-bold">
                                            📄 দেখুন
                                        </a>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3.5 text-right">
                                    <form action="{{ route('admin.tournaments.finances.destroy', [$tournament, $exp]) }}" method="POST"
                                          onsubmit="return confirm('এই খরচের ভাউচারটি কি নিশ্চিত মুছে ফেলতে চান?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-rose-300 font-bold text-xs p-1">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                                    এই টুর্নামেন্টের কোনো খরচের ভাউচার এখনও এন্ট্রি করা হয়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($expenses->hasPages())
                <div class="p-4 bg-slate-950/80 border-t border-slate-800">
                    {{ $expenses->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Live Auto Multiplication Script for Unit Price * Quantity -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const unitPriceInput = document.getElementById('unit_price');
            const qtyInput = document.getElementById('quantity');
            const amountInput = document.getElementById('amount');
            const categorySelect = document.getElementById('expense_category');
            const volunteerSelect = document.getElementById('volunteer_id');
            const paidToInput = document.getElementById('paid_to');

            function calcTotal() {
                const up = parseFloat(unitPriceInput.value) || 0;
                const qty = parseFloat(qtyInput.value) || 0;
                if (up > 0 && qty > 0) {
                    amountInput.value = (up * qty).toFixed(2);
                }
            }

            unitPriceInput.addEventListener('input', calcTotal);
            qtyInput.addEventListener('input', calcTotal);

            // Auto-fill Paid To when volunteer selected
            volunteerSelect.addEventListener('change', () => {
                const selectedOption = volunteerSelect.options[volunteerSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    paidToInput.value = selectedOption.text.split('(')[0].trim();
                }
            });
        });
    </script>
</x-app-layout>


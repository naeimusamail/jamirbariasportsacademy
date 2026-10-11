<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>⚠️</span> {{ __('বকেয়া ফি অ্যালার্ট ও তালিকা (Fee Defaulters List)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    চলতি মাসের নির্ধারিত মাসিক ফি অপরিশোধিত থাকা সকল নিয়মিত ট্রেইনিদের তালিকা ও দ্রুত নোটিফিকেশন
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 font-bold rounded-xl text-xs transition">
                    &larr; পেমেন্ট তালিকা
                </a>
                <a href="{{ route('payments.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition shadow">
                    + নতুন ফি এন্ট্রি
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Summary KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-rose-500/10 border border-rose-500/30 rounded-2xl p-5 shadow-sm">
                    <span class="text-xs font-bold text-rose-400 uppercase tracking-wider block">মোট বকেয়া টাকার পরিমাণ</span>
                    <div class="text-2xl font-black text-rose-500 mt-1 font-mono">
                        ৳{{ number_format($totalDueAmount, 2) }}
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1 block">মাস: {{ $currentMonth }} {{ $currentYear }}</span>
                </div>

                <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-5 shadow-sm">
                    <span class="text-xs font-bold text-amber-400 uppercase tracking-wider block">বকেয়া ট্রেইনির সংখ্যা</span>
                    <div class="text-2xl font-black text-amber-400 mt-1 font-mono">
                        {{ $defaulters->total() }} জন
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1 block">সক্রিয় নিয়মিত শিক্ষার্থীদের মধ্যে</span>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">এক ক্লিকে এসএমএস তাগিদ</span>
                    <p class="text-[11px] text-slate-400 mt-1">সব বকেয়া অভিভাবকের মোবাইলে এক ক্লিকে রিমাইন্ডার মেসেজ পাঠান</p>
                    <a href="{{ route('admin.sms.index') }}" class="mt-2 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition">
                        <span>📱</span> বাল্ক এসএমএস প্যানেল &rarr;
                    </a>
                </div>
            </div>

            <!-- Filter Toolbar -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('payments.defaulters') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1">মাস (Month)</label>
                        <select name="month" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-slate-200">
                            @foreach($months as $m)
                                <option value="{{ $m }}" {{ $currentMonth == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1">সাল (Year)</label>
                        <input type="text" name="year" value="{{ $currentYear }}" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-slate-200">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1">খেলা (Sport)</label>
                        <select name="sport_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-slate-200">
                            <option value="">সকল খেলা</option>
                            @foreach($sports as $sp)
                                <option value="{{ $sp->id }}" {{ request('sport_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1">খুঁজুন (Search)</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম / ফোন / ভর্তি নং..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-slate-200">
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs transition">
                            ফিল্টার করুন
                        </button>
                        <a href="{{ route('payments.defaulters') }}" class="px-3 py-2 bg-slate-700 text-slate-300 rounded-xl text-xs font-bold">
                            রিসেট
                        </a>
                    </div>
                </form>
            </div>

            <!-- Defaulters Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="px-5 py-3.5">ভর্তি নং</th>
                                <th class="px-5 py-3.5">প্লেয়ার ও অভিভাবকের নাম</th>
                                <th class="px-5 py-3.5">খেলা ও ব্যাচ</th>
                                <th class="px-5 py-3.5">অভিভাবকের ফোন</th>
                                <th class="px-5 py-3.5 text-right">মাসিক ফি (টাকা)</th>
                                <th class="px-5 py-3.5 text-center">স্ট্যাটাস</th>
                                <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($defaulters as $t)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-750 transition">
                                    <td class="px-5 py-4 font-mono font-bold text-rose-500">
                                        {{ $t->admission_no }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $t->name }}</div>
                                        <div class="text-[10px] text-gray-400">অভিভাবক: {{ $t->guardian_name ?? '—' }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div>{{ $t->sport->name ?? '—' }} ({{ $t->category ?? 'Senior' }})</div>
                                        <div class="text-[10px] text-emerald-400 font-semibold">{{ $t->batch->name ?? 'ব্যাচ নির্ধারিত নয়' }}</div>
                                    </td>
                                    <td class="px-5 py-4 font-mono font-bold text-slate-300">
                                        <a href="tel:{{ $t->phone }}" class="hover:text-emerald-400 flex items-center gap-1">
                                            <span>📞</span> {{ $t->phone }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-4 text-right font-mono font-black text-rose-400 text-sm">
                                        ৳{{ number_format($t->monthly_fee, 2) }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-400 border border-rose-500/30">
                                            অনাদায়ী (Due)
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('payments.create', ['trainee_id' => $t->id]) }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-[11px] shadow transition">
                                                ➕ ফি জমা নিন
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-400">
                                        🎉 কোনো বকেয়া ফি নেই! নির্বাচিত মাসের সকল শিক্ষার্থীর ফি পরিশোধিত রয়েছে।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($defaulters->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $defaulters->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>


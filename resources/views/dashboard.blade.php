<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
                    <span>⚽</span> {{ __('একাডেমি ড্যাশবোর্ড (Academy Dashboard)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">জামিরবাড়িয়া স্পোর্টস একাডেমি সমন্বিত ম্যানেজমেন্ট প্ল্যাটফর্ম</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @if($pendingAdmissionsCount > 0)
                    <a href="{{ route('admin.admissions.index') }}" class="inline-flex items-center px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold rounded-xl shadow-sm transition gap-1.5 animate-pulse">
                        <span>📋 নতুন আবেদন:</span>
                        <span class="px-1.5 py-0.5 bg-black text-amber-300 rounded-full text-[10px]">{{ $pendingAdmissionsCount }} টি</span>
                    </a>
                @endif
                <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                    + খরচ ভাউচার
                </a>
                <a href="{{ route('performances.create') }}" class="inline-flex items-center px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                    + ফিটনেস টেস্ট
                </a>
                <a href="{{ route('admin.teams.create') }}" class="inline-flex items-center px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                    + নতুন ক্লাব রেজিস্ট্রেশন
                </a>
                <a href="{{ route('trainees.create') }}" class="inline-flex items-center px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                    + নতুন ট্রেইনি ভর্তি
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-emerald-700 via-teal-800 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden border border-emerald-600/30">
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 text-emerald-300 text-xs font-bold rounded-full mb-3 backdrop-blur">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        সেশন: ২০২৬ • জামিরবাড়িয়া স্পোর্টস একাডেমি
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black">স্বাগতম, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-emerald-100 text-xs sm:text-sm mt-1 max-w-xl leading-relaxed">
                        অনলাইন ভর্তি আবেদন, খেলোয়াড়দের ডিজিটাল আইডি কার্ড, ফিটনেস অ্যানালিটিক্স এবং আয়-ব্যয়ের সার্বিক তথ্য এক নজরে পর্যবেক্ষণ করুন।
                    </p>
                </div>
                <div class="flex flex-wrap gap-2.5 shrink-0 relative z-10">
                    <a href="{{ route('reports.financial') }}" class="px-3.5 py-2.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold rounded-xl text-xs shadow transition">
                        📊 ক্যাশ বুক / P&L
                    </a>
                    <a href="{{ route('payments.defaulters') }}" class="px-3.5 py-2.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold rounded-xl text-xs shadow transition">
                        ⚠️ বকেয়া ফি তালিকা
                    </a>
                    <a href="{{ route('admin.sms.index') }}" class="px-3.5 py-2.5 bg-white/20 hover:bg-white/30 text-white font-bold rounded-xl text-xs shadow backdrop-blur transition">
                        📲 বাল্ক SMS
                    </a>
                    <a href="{{ route('matches.index') }}" class="px-3.5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-xs shadow transition">
                        ⚡ লাইভ স্কোর
                    </a>
                    <a href="{{ url('/') }}" target="_blank" class="px-3.5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl text-xs backdrop-blur transition">
                        ওয়েবসাইট ↗
                    </a>
                </div>
            </div>

            <!-- Primary 6 Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- 1. Trainees -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">সক্রিয় ট্রেইনি</span>
                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $totalTrainees }} জন</div>
                    <a href="{{ route('trainees.index') }}" class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 hover:underline mt-1 inline-block">তালিকা &rarr;</a>
                </div>

                <!-- 2. Batches -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">চলতি ব্যাচ</span>
                    <div class="text-2xl font-black text-teal-600 dark:text-teal-400 mt-1">{{ $totalBatches }} টি</div>
                    <a href="{{ route('batches.index') }}" class="text-[11px] font-semibold text-teal-600 dark:text-teal-400 hover:underline mt-1 inline-block">শিডিউল &rarr;</a>
                </div>

                <!-- 3. Pending Admissions -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-amber-500/30">
                    <span class="text-[11px] font-bold text-amber-500 uppercase tracking-wider block">অপেক্ষমান ভর্তি</span>
                    <div class="text-2xl font-black text-amber-500 mt-1">{{ $pendingAdmissionsCount }} টি</div>
                    <a href="{{ route('admin.admissions.index') }}" class="text-[11px] font-semibold text-amber-600 dark:text-amber-400 hover:underline mt-1 inline-block">অনুমোদন &rarr;</a>
                </div>

                <!-- 4. Monthly Collection -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">মাসের ফি আদায়</span>
                    <div class="text-2xl font-black text-cyan-600 dark:text-cyan-400 mt-1">৳{{ number_format($totalFeeCollectedMonth) }}</div>
                    <a href="{{ route('payments.index') }}" class="text-[11px] font-semibold text-cyan-600 dark:text-cyan-400 hover:underline mt-1 inline-block">ফি রেজিস্টার &rarr;</a>
                </div>

                <!-- 5. Net Academy Balance -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-indigo-500/30">
                    <span class="text-[11px] font-bold text-indigo-500 uppercase tracking-wider block">নেট ফান্ড ব্যালেন্স</span>
                    <div class="text-2xl font-black {{ $netBalance >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-500' }} mt-1">৳{{ number_format($netBalance) }}</div>
                    <a href="{{ route('expenses.index') }}" class="text-[11px] font-semibold text-indigo-600 dark:text-indigo-400 hover:underline mt-1 inline-block">লেজার &rarr;</a>
                </div>

                <!-- 6. Attendance Rate -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">আজকের উপস্থিতি</span>
                    <div class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1">{{ $attendanceRate }}%</div>
                    <a href="{{ route('attendances.index') }}" class="text-[11px] font-semibold text-purple-600 dark:text-purple-400 hover:underline mt-1 inline-block">রিপোর্ট &rarr;</a>
                </div>
            </div>

            <!-- Coach Supervision & Monitoring Hub (এডমিন কর্তৃক কোচদের মনিটরিং ও কার্যক্রম) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-indigo-500/20">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-wider">
                                🛡️ কোচ মনিটরিং ও একাডেমি সুপারভিশন হাব
                            </span>
                            <span class="text-xs text-gray-400 font-medium">কোচ: {{ $coachesList->count() }} জন</span>
                        </div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white mt-1">
                            প্রশিক্ষকবৃন্দের দায়িত্ব, প্লেয়ার তদারকি ও প্রশিক্ষণ টাস্ক অগ্রগতি
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            কোচগণ প্লেয়ারদের প্রশিক্ষণ ও ড্রিল প্রদান করছেন এবং এডমিন হিসেবে আপনি সামগ্রিক পারফরম্যান্স তত্ত্বাবধান করছেন।
                        </p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('tasks.index') }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition flex items-center gap-1.5">
                            <span>🎯 সকল ড্রিল ও টাস্ক</span>
                        </a>
                        <a href="{{ route('coaches.index') }}" class="px-3.5 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold transition">
                            কোচ তালিকা &rarr;
                        </a>
                    </div>
                </div>

                <!-- Coaches Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    @forelse($coachesList as $c)
                        @php
                            $playerCount = $c->batches->sum(fn($b) => $b->trainees->count());
                        @endphp
                        <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 hover:border-indigo-500/40 transition space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-900 border border-indigo-500/30 overflow-hidden shrink-0 flex items-center justify-center font-bold text-base text-indigo-400">
                                        @if($c->photo)
                                            <img src="{{ asset('storage/' . $c->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ mb_substr($c->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white text-sm hover:text-indigo-600">
                                            {{ $c->name }}
                                        </h4>
                                        <div class="text-[11px] text-gray-500">{{ $c->designation ?? 'প্রশিক্ষক' }}</div>
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                                            {{ $c->sport->name ?? 'অল-স্পোর্টস' }}
                                        </span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c->status == 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $c->status == 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                </span>
                            </div>

                            <div class="grid grid-cols-3 gap-2 py-2 border-y border-gray-100 dark:border-gray-700/60 text-center text-xs">
                                <div>
                                    <span class="text-[10px] text-gray-400 block">প্লেয়ার</span>
                                    <strong class="font-bold text-emerald-600 dark:text-emerald-400">{{ $playerCount }} জন</strong>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block">ব্যাচ</span>
                                    <strong class="font-bold text-indigo-600 dark:text-indigo-400">{{ $c->batches_count }} টি</strong>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block">টাস্ক প্রদান</span>
                                    <strong class="font-bold text-amber-600 dark:text-amber-400">{{ $c->training_tasks_count }} টি</strong>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs pt-1">
                                <a href="{{ route('profile.coach', $c->id) }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline flex items-center gap-1">
                                    <span>👤 কোচ প্রোফাইল &rarr;</span>
                                </a>
                                <a href="{{ route('coaches.edit', $c) }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    ম্যানেজ
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-6 text-gray-400 text-xs">কোনো কোচ তথ্য পাওয়া যায়নি।</div>
                    @endforelse
                </div>

                <!-- Recent Drills / Tasks Assigned by Coaches to Players -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                            <span>🎯</span> কোচদের সাম্প্রতিক এসাইন করা ড্রিল ও ট্রেনিং টাস্ক
                        </h4>
                        <a href="{{ route('tasks.index') }}" class="text-xs text-indigo-600 font-bold hover:underline">
                            টাস্ক ম্যানেজমেন্ট সেন্টার &rarr;
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                            <thead class="text-[11px] uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500">
                                <tr>
                                    <th class="px-3 py-2">টাস্ক শিরোনাম</th>
                                    <th class="px-3 py-2">দায়িত্বশীল কোচ</th>
                                    <th class="px-3 py-2">অ্যাসাইনড প্লেয়ার / ব্যাচ</th>
                                    <th class="px-3 py-2">ক্যাটাগরি</th>
                                    <th class="px-3 py-2">শেষ তারিখ</th>
                                    <th class="px-3 py-2">অগ্রগতি / স্কোর</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($recentTrainingTasks as $tTask)
                                    <tr>
                                        <td class="px-3 py-2 font-bold text-gray-900 dark:text-white">{{ $tTask->title }}</td>
                                        <td class="px-3 py-2 text-indigo-600 font-semibold">{{ $tTask->coach->name ?? 'কোচ' }}</td>
                                        <td class="px-3 py-2">
                                            @if($tTask->trainee)
                                                <span class="font-bold text-emerald-600">{{ $tTask->trainee->name }}</span>
                                            @elseif($tTask->batch)
                                                <span class="text-gray-700 dark:text-gray-300">{{ $tTask->batch->name }} (ব্যাচ)</span>
                                            @else
                                                <span class="text-gray-400">সকল প্লেয়ার</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2">{{ $tTask->drill_name }}</td>
                                        <td class="px-3 py-2 font-mono text-[11px]">{{ $tTask->due_date ? $tTask->due_date->format('d M, Y') : '-' }}</td>
                                        <td class="px-3 py-2">
                                            @if($tTask->status === 'reviewed')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                                    ✓ মূল্যায়িত ({{ $tTask->coach_score }}/১০ ★)
                                                </span>
                                            @elseif($tTask->status === 'completed')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                                                    ⏳ সম্পন্ন (রিভিউ বাকি)
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                                    চলমান
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-gray-400">কোনো ড্রিল টাস্ক রেকর্ড নেই।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- New Admissions & Expenses Quick Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pending Online Admission Applications -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">📋</span>
                            <h4 class="font-bold text-gray-900 dark:text-white text-base">অনলাইন ভর্তি আবেদন (অনুমোদনের অপেক্ষায়)</h4>
                        </div>
                        <a href="{{ route('admin.admissions.index') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">সব আবেদন &rarr;</a>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentAdmissions as $adm)
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 overflow-hidden shrink-0 flex items-center justify-center font-bold text-xs">
                                        @if($adm->photo)
                                            <img src="{{ asset('storage/' . $adm->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ mb_substr($adm->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800 dark:text-gray-200 text-xs">{{ $adm->name }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $adm->sport->name ?? 'N/A' }} ({{ $adm->category }}) • {{ $adm->phone }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.admissions.show', $adm) }}" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow">
                                    যাচাই ও অনুমোদন ➔
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-4">বর্তমানে কোনো আবেদন অপেক্ষমান নেই।</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Expenses -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">💸</span>
                            <h4 class="font-bold text-gray-900 dark:text-white text-base">সাম্প্রতিক একাডেমি খরচ ভাউচার</h4>
                        </div>
                        <a href="{{ route('expenses.index') }}" class="text-xs font-semibold text-rose-600 dark:text-rose-400 hover:underline">সকল খরচ &rarr;</a>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentExpenses as $exp)
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-gray-800 dark:text-gray-200 text-xs">{{ $exp->title }}</div>
                                    <div class="text-[11px] text-gray-400">{{ $exp->voucher_no }} • {{ \Carbon\Carbon::parse($exp->expense_date)->format('d M, Y') }}</div>
                                </div>
                                <div class="font-mono font-bold text-rose-600 dark:text-rose-400 text-sm">
                                    ৳{{ number_format($exp->amount) }}
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-4">কোনো খরচ রেকর্ড নেই।</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Batches & Schedules + Notices -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Batches Overview -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                            <span>⚽</span> ট্রেনিং ব্যাচ ও শিডিউল
                        </h4>
                        <a href="{{ route('batches.index') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">সব ব্যাচ &rarr;</a>
                    </div>

                    <div class="space-y-3">
                        @forelse($batches as $batch)
                            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">{{ $batch->sport->icon ?? '⚽' }}</span>
                                    <div>
                                        <div class="font-bold text-gray-800 dark:text-gray-200 text-sm">
                                            {{ $batch->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            মাঠ: {{ $batch->ground }} • কোচ: {{ $batch->coach->name ?? 'অ্যাসাইন করা হয়নি' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs px-2.5 py-1 bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 font-semibold rounded-lg">
                                        {{ $batch->time_slot }} ({{ $batch->days }})
                                    </span>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        {{ $batch->trainees_count }} জন
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">কোনো ব্যাচ তৈরি করা হয়নি।</p>
                        @endforelse
                    </div>
                </div>

                <!-- Notices -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                            <span>📢</span> সাম্প্রতিক নোটিশ
                        </h4>
                        <a href="{{ route('notices.create') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">+ নতুন</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($notices as $notice)
                            <div class="border-l-4 {{ $notice->is_pinned ? 'border-emerald-500' : 'border-slate-400' }} pl-3 py-1">
                                <div class="text-xs text-gray-400">{{ $notice->notice_date }}</div>
                                <div class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-0.5">{{ $notice->title }}</div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $notice->content }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">কোনো নোটিশ নেই।</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Trainees -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                        <span>👥</span> সর্বশেষ ভর্তি হওয়া ট্রেইনি
                    </h4>
                    <a href="{{ route('trainees.index') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">সবাইকে দেখুন &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                        <thead class="text-[11px] uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">ভর্তি নং</th>
                                <th class="px-4 py-3">নাম</th>
                                <th class="px-4 py-3">খেলা ও ক্যাটাগরি</th>
                                <th class="px-4 py-3">ব্যাচ</th>
                                <th class="px-4 py-3">যোগাযোগ</th>
                                <th class="px-4 py-3">স্ট্যাটাস</th>
                                <th class="px-4 py-3 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentTrainees as $tr)
                                <tr>
                                    <td class="px-4 py-3 font-mono font-bold text-gray-900 dark:text-white">{{ $tr->admission_no }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-800 dark:text-gray-200">{{ $tr->name }}</td>
                                    <td class="px-4 py-3">{{ $tr->sport->name ?? '-' }} ({{ $tr->category }})</td>
                                    <td class="px-4 py-3">{{ $tr->batch->name ?? 'ব্যাচহীন' }}</td>
                                    <td class="px-4 py-3">{{ $tr->phone }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-0.5 text-[10px] rounded-full font-semibold {{ $tr->status == 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $tr->status == 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('trainees.show', $tr) }}" class="text-emerald-600 dark:text-emerald-400 font-semibold hover:underline">প্রোফাইল &rarr;</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-400">কোনো ট্রেইনি তথ্য পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

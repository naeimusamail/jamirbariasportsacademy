<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-wider">
                        📋 অফিশিয়াল প্রশিক্ষক / কোচ প্রোফাইল
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">পদবি: <strong class="text-indigo-600">{{ $coach->designation ?? 'প্রধান প্রশিক্ষক' }}</strong></span>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 mt-1">
                    {{ $coach->name }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    জামিরবাড়িয়া স্পোর্টস একাডেমি • {{ $coach->sport->name ?? 'ফুটবল ও ক্রিকেট' }} প্রশিক্ষণ বিভাগ
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('dashboard.coach') }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>📋 কোচ ড্যাশবোর্ড</span>
                </a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('coaches.edit', $coach) }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                        ⚙️ এডিট তথ্য &rarr;
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Hero Coach Profile Banner -->
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-indigo-500/30 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Coach Photo -->
                    <div class="w-36 h-36 sm:w-44 sm:h-44 rounded-2xl bg-slate-800 border-4 border-indigo-500/60 overflow-hidden shrink-0 shadow-2xl flex items-center justify-center">
                        @if($coach->photo)
                            <img src="{{ asset('storage/' . $coach->photo) }}" alt="{{ $coach->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-black text-indigo-400">{{ mb_substr($coach->name, 0, 1) }}</span>
                        @endif
                    </div>

                    <!-- Coach Details -->
                    <div class="flex-1 text-center md:text-left space-y-3">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-indigo-500 text-white shadow-sm">
                                {{ $coach->designation ?? 'প্রধান প্রশিক্ষক' }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-indigo-300 border border-white/10">
                                {{ $coach->sport->name ?? 'অল-স্পোর্টস' }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $coach->status == 'active' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-gray-500/20 text-gray-300' }}">
                                {{ $coach->status == 'active' ? 'সক্রিয় কোচ' : 'নিষ্ক্রিয়' }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-white">{{ $coach->name }}</h3>
                            <p class="text-xs sm:text-sm text-indigo-200/80 mt-0.5">
                                জামিরবাড়িয়া স্পোর্টস একাডেমি • অভিজ্ঞতা: <strong class="text-white">{{ $coach->experience_years ?? 3 }}+ বছর</strong>
                            </p>
                        </div>

                        <!-- 3 Summary Metrics -->
                        <div class="grid grid-cols-3 gap-3 pt-3 border-t border-indigo-500/20 text-center text-xs">
                            <div class="p-2.5 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-[10px] text-indigo-300 block">দায়িত্বপ্রাপ্ত প্লেয়ার</span>
                                <strong class="text-lg font-black text-emerald-400">{{ $totalPlayers }} জন</strong>
                            </div>
                            <div class="p-2.5 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-[10px] text-indigo-300 block">চলতি ব্যাচ</span>
                                <strong class="text-lg font-black text-white">{{ $coach->batches->count() }} টি</strong>
                            </div>
                            <div class="p-2.5 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-[10px] text-indigo-300 block">প্রদত্ত ট্রেনিং ড্রিল</span>
                                <strong class="text-lg font-black text-amber-400">{{ $coach->trainingTasks->count() }} টি</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Personal Info & Batches -->
                <div class="space-y-6">

                    <!-- Coach Details Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 space-y-4">
                        <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                            <span>📞</span> যোগাযোগের বিবরণ ও তথ্য
                        </h4>

                        <div class="text-xs space-y-2.5 text-gray-600 dark:text-gray-300 divide-y divide-gray-100 dark:divide-gray-700">
                            <div class="flex justify-between pt-1">
                                <span class="text-gray-400">ফোন নম্বর:</span>
                                <span class="font-mono font-bold text-emerald-600">{{ $coach->phone }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">ইমেইল:</span>
                                <span class="font-mono text-gray-800 dark:text-gray-200">{{ $coach->email ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">খেলাধুলার ধরন:</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $coach->sport->name ?? 'সাধারণ' }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">যোগদানের তারিখ:</span>
                                <span class="font-mono text-gray-800 dark:text-gray-200">{{ $coach->joining_date ?? '২০২৬-০১-০১' }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">বিশেষ পারদর্শিতা:</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $coach->specialization ?? 'ফিটনেস ও স্কিল ডেভেলপমেন্ট' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Batches Under Supervision -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                <span>📅</span> তত্ত্বাবধানে থাকা ব্যাচসমূহ
                            </h4>
                            <span class="text-xs text-indigo-600 font-bold">{{ $coach->batches->count() }}টি ব্যাচ</span>
                        </div>

                        <div class="space-y-3">
                            @forelse($coach->batches as $batch)
                                <div class="p-3.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <h5 class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm">{{ $batch->name }}</h5>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600">
                                            {{ $batch->trainees->count() }} জন প্লেয়ার
                                        </span>
                                    </div>
                                    <div class="text-[11px] text-gray-500">
                                        সময়: <span class="text-indigo-600 font-semibold">{{ $batch->time_slot }}</span> • দিন: {{ $batch->days }}
                                    </div>
                                    <div class="text-[10px] text-gray-400">মাঠ: {{ $batch->ground ?? 'প্রধান মাঠ' }}</div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-xs text-gray-400">কোনো ব্যাচ নির্ধারিত নেই।</div>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- Right 2 Columns: Players Under Supervision & Training Drills -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Supervised Players List -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                    <span>🏃‍♂️</span> দায়িত্বপ্রাপ্ত প্লেয়ার রোস্টার
                                </h4>
                                <p class="text-xs text-gray-400">কোচের অধীনে প্রশিক্ষণরত খেলোয়াড়বৃন্দ</p>
                            </div>
                            <span class="text-xs font-bold text-emerald-600">{{ $totalPlayers }} জন খেলোয়াড়</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                                <thead class="text-[11px] uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500">
                                    <tr>
                                        <th class="px-4 py-2.5">প্লেয়ার</th>
                                        <th class="px-4 py-2.5">ভর্তি নং</th>
                                        <th class="px-4 py-2.5">ব্যাচ</th>
                                        <th class="px-4 py-2.5">পজিশন</th>
                                        <th class="px-4 py-2.5 text-right">প্রোফাইল</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @php $hasPlayers = false; @endphp
                                    @foreach($coach->batches as $batch)
                                        @foreach($batch->trainees as $t)
                                            @php $hasPlayers = true; @endphp
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                                                <td class="px-4 py-2.5 font-bold text-gray-900 dark:text-white">
                                                    {{ $t->name }}
                                                </td>
                                                <td class="px-4 py-2.5 font-mono text-emerald-600 font-bold">{{ $t->admission_no }}</td>
                                                <td class="px-4 py-2.5">{{ $batch->name }}</td>
                                                <td class="px-4 py-2.5">{{ $t->position ?? 'প্লেয়ার' }}</td>
                                                <td class="px-4 py-2.5 text-right">
                                                    <a href="{{ route('profile.player', $t->id) }}" class="text-indigo-600 hover:underline font-bold">
                                                        প্রোফাইল &rarr;
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                    @if(!$hasPlayers)
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-gray-400">কোনো প্লেয়ার পাওয়া যায়নি।</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Drills & Tasks Assigned by this Coach -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-emerald-500/20">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                    <span>🎯</span> কোচের নির্ধারিত ড্রিল ও অ্যাসাইনমেন্ট হিস্টোরি
                                </h4>
                                <p class="text-xs text-gray-400">প্লেয়ারদের যেসকল টাস্ক ও হোম ড্রিল প্রদান করা হয়েছে</p>
                            </div>
                            <a href="{{ route('tasks.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                                ড্রিল সেন্টার &rarr;
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($coach->trainingTasks as $task)
                                <div class="p-3.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600">
                                                {{ $task->drill_name }}
                                            </span>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm">{{ $task->title }}</h5>
                                        </div>
                                        <div>
                                            @if($task->status === 'reviewed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                                    ✓ মূল্যায়িত ({{ $task->coach_score }}/১০ ★)
                                                </span>
                                            @elseif($task->status === 'completed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                                                    ⏳ মূল্যায়নের অপেক্ষায়
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                                    চলমান
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-[11px] text-gray-500 flex justify-between">
                                        <span>অ্যাসাইনড: <strong>{{ $task->trainee->name ?? ($task->batch->name ?? 'সকল প্লেয়ার') }}</strong></span>
                                        <span>তারিখ: {{ $task->due_date ? $task->due_date->format('d M, Y') : '-' }}</span>
                                    </div>
                                    @if($task->coach_feedback)
                                        <div class="text-[11px] text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/30 p-2 rounded-lg">
                                            <strong>মন্তব্য:</strong> {{ $task->coach_feedback }}
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4 text-xs text-gray-400">কোনো ড্রিল টাস্ক নেই।</div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>


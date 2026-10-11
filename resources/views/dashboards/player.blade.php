<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-bold text-xs">
                        ⚽ প্লেয়ার ড্যাশবোর্ড
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">আইডি: <strong class="font-mono text-emerald-600">{{ $trainee->admission_no ?? 'JSA-2026-001' }}</strong></span>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 mt-1 flex items-center gap-2">
                    <span>স্বাগতম,</span> {{ $trainee->name ?? Auth::user()->name }}! 👋
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    জামিরবাড়িয়া স্পোর্টস একাডেমি • {{ $trainee->sport->name ?? 'অ্যাথলেটিক্স' }} স্কোয়াড ({{ $trainee->category ?? 'Senior' }})
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @if($trainee)
                    <a href="{{ route('admin.id-cards.show', $trainee) }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                        <span>🪪 আমার আইডি কার্ড</span>
                    </a>
                @endif
                <a href="{{ route('live.index') }}" target="_blank" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span>লাইভ ম্যাচ সেন্টার ↗</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Player Stat Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <!-- Attendance Rate -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-emerald-500/20 shadow-sm relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">উপস্থিতি হার</span>
                        <span class="text-lg">📅</span>
                    </div>
                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-2">
                        {{ $attendanceRate }}%
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full mt-2 overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $attendanceRate }}%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">মোট উপস্থিত: {{ $presentAttendance }} / {{ $totalAttendance }} সেশন</span>
                </div>

                <!-- Fee Status -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">ফি ও পেমেন্ট</span>
                        <span class="text-lg">💳</span>
                    </div>
                    <div class="text-2xl font-black text-gray-900 dark:text-white mt-2">
                        ৳{{ number_format($totalPaid) }}
                    </div>
                    @if($duePayments->count() > 0)
                        <span class="text-[10px] text-rose-500 font-bold mt-1 block">
                            ⚠️ {{ $duePayments->count() }}টি মাসের ফি বকেয়া রয়েছে
                        </span>
                    @else
                        <span class="text-[10px] text-emerald-500 font-bold mt-1 block">
                            ✓ সকল ফি পরিশোধিত
                        </span>
                    @endif
                </div>

                <!-- Certificates -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-amber-500/20 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">অর্জিত সনদপত্র</span>
                        <span class="text-lg">📜</span>
                    </div>
                    <div class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-2">
                        {{ $trainee && $trainee->certificates ? $trainee->certificates->count() : 0 }} টি
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">কিউআর ভেরিফায়েড সার্টিফিকেট</span>
                </div>

                <!-- Fitness Score -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-indigo-500/20 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">কোচ রেটিং ও ফিটনেস</span>
                        <span class="text-lg">🏃</span>
                    </div>
                    <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-2">
                        {{ $trainee && $trainee->latestFitness ? $trainee->latestFitness->coach_rating : 5 }} / 5 ★
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">
                        স্প্রিন্ট: {{ $trainee && $trainee->latestFitness && $trainee->latestFitness->sprint_100m_sec ? $trainee->latestFitness->sprint_100m_sec . 's' : 'রেকর্ডকৃত' }}
                    </span>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column (ID Card & Team Squad) -->
                <div class="space-y-6">

                    <!-- Digital ID Card Mini Showcase -->
                    @if($trainee)
                        <div class="bg-gradient-to-br from-slate-950 via-emerald-950 to-slate-950 text-white rounded-3xl p-5 shadow-xl border border-emerald-500/40 relative overflow-hidden">
                            <div class="flex items-center justify-between border-b border-emerald-500/30 pb-3">
                                <div>
                                    <div class="text-xs font-black uppercase text-emerald-300">জামিরবাড়িয়া স্পোর্টস একাডেমি</div>
                                    <div class="text-[9px] uppercase tracking-wider text-emerald-200">OFFICIAL PLAYER ID CARD</div>
                                </div>
                                <span class="text-[10px] font-mono font-bold bg-white/20 px-2.5 py-0.5 rounded-full">{{ $trainee->category }}</span>
                            </div>

                            <div class="mt-4 flex items-center gap-3">
                                <div class="w-16 h-20 rounded-xl bg-slate-900 border-2 border-emerald-400 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if($trainee->photo)
                                        <img src="{{ asset('storage/' . $trainee->photo) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl font-black text-emerald-400">{{ mb_substr($trainee->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-black text-base text-white leading-tight">{{ $trainee->name }}</h4>
                                    <p class="text-xs text-emerald-300">{{ $trainee->sport->name ?? 'প্লেয়ার' }}</p>
                                    <div class="text-[10px] text-gray-300 mt-0.5">পজিশন: <strong class="text-white">{{ $trainee->position ?? 'প্লেয়ার' }}</strong></div>
                                    @if($trainee->jersey_no)
                                        <span class="inline-block text-[10px] font-bold text-amber-300">জার্সি: #{{ $trainee->jersey_no }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-t border-emerald-500/20 flex items-center justify-between text-[11px]">
                                <div>
                                    <span class="text-[9px] text-emerald-300/80 block">আইডি নম্বর:</span>
                                    <span class="font-mono font-bold text-white">{{ $trainee->admission_no }}</span>
                                </div>
                                <div>
                                    <span class="text-[9px] text-emerald-300/80 block">রক্তের গ্রুপ:</span>
                                    <span class="font-bold text-rose-400 font-mono">{{ $trainee->blood_group ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('admin.id-cards.show', $trainee) }}" class="flex-1 text-center py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-xl text-xs font-black shadow transition">
                                    🖨️ পূর্ণাঙ্গ আইডি কার্ড ও প্রিন্ট
                                </a>
                                <a href="{{ $verifyUrl }}" target="_blank" class="px-3 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-bold transition">
                                    QR ভিউ
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Enrolled Sports Badges -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-emerald-500/20 space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                                <span>🏅</span> আমার খেলাসমূহ (My Sports)
                            </h4>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600">
                                {{ $trainee && $trainee->sports ? $trainee->sports->count() : 1 }} টি খেলা
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @if($trainee && $trainee->sports && $trainee->sports->count() > 0)
                                @foreach($trainee->sports as $sp)
                                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl border {{ $sp->pivot->is_primary ? 'border-emerald-500/40 bg-emerald-50/50 dark:bg-emerald-950/30' : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40' }} text-xs">
                                        <span class="text-base">{{ $sp->icon ?? '⚽' }}</span>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white text-xs">{{ $sp->name }}</div>
                                            <div class="text-[9px] text-gray-500">{{ $sp->pivot->position ?? 'প্লেয়ার' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-xs text-emerald-600 font-bold">{{ $trainee->sport->name ?? 'স্পোর্টস' }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Squad & Team Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 space-y-3">
                        <h4 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                            <span>🛡️</span> আমার স্কোয়াড ও দলীয় তথ্য
                        </h4>

                        @if(isset($enrolledTeams) && $enrolledTeams->count() > 0)
                            <div class="space-y-2">
                                @foreach($enrolledTeams as $tm)
                                    <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-900 overflow-hidden shrink-0 flex items-center justify-center text-lg">
                                            @if($tm->logo)
                                                <img src="{{ asset('storage/' . $tm->logo) }}" alt="" class="w-full h-full object-cover">
                                            @else
                                                ⚽
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('public.teams.show', $tm->slug) }}" class="font-bold text-gray-900 dark:text-white text-xs hover:text-emerald-600">
                                                {{ $tm->name }}
                                            </a>
                                            <div class="text-[10px] text-gray-500">{{ $tm->sport_type }} • {{ $tm->category }}</div>
                                            <div class="text-[9px] text-emerald-600 font-semibold">কোচ: {{ $tm->coach_name ?? 'নির্ধারিত' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($team)
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-900 overflow-hidden shrink-0 flex items-center justify-center text-xl">
                                    @if($team->logo)
                                        <img src="{{ asset('storage/' . $team->logo) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        ⚽
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('public.teams.show', $team->slug) }}" class="font-bold text-gray-900 dark:text-white text-sm hover:text-emerald-600">
                                        {{ $team->name }}
                                    </a>
                                    <div class="text-[11px] text-gray-500">{{ $team->sport_type }} • {{ $team->category }}</div>
                                    <div class="text-[10px] text-emerald-600 font-semibold mt-0.5">কোচ: {{ $team->coach_name ?? 'নির্ধারিত' }}</div>
                                </div>
                            </div>
                        @else
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-dashed border-gray-200 dark:border-gray-700 text-xs text-gray-500 text-center">
                                বর্তমানে কোনো টুর্নামেন্ট দলে অন্তর্ভুক্ত নন।
                            </div>
                        @endif

                        <div class="text-xs space-y-1.5 text-gray-600 dark:text-gray-300 pt-2 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between">
                                <span class="text-gray-400">নির্ধারিত ব্যাচ:</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $trainee->batch->name ?? 'জুনিয়র স্কোয়াড' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">প্রশিক্ষক (Coach):</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $trainee->batch->coach->name ?? 'একাডেমি কোচ' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">প্রশিক্ষণের সময়:</span>
                                <span class="text-emerald-600 font-semibold">{{ $trainee->batch->time_slot ?? 'বিকাল ৪:০০ - ৬:০০' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right 2 Columns (Certificates, Attendance, Fees & Matches) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Assigned Training Tasks & Drills (কোচের নির্দেশিত ট্রেনিং টাস্ক) -->
                    <div x-data="{ completeModal: false, completeTaskId: null, taskTitle: '' }" class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-emerald-500/30">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                    <span>🎯</span> কোচের নির্দেশিত ট্রেনিং ড্রিল ও টাস্ক (My Training Drills)
                                </h4>
                                <p class="text-xs text-gray-400">কোচ কর্তৃক নির্ধারিত হোম ড্রিল ও ট্রেনিং সম্পন্ন করুন এবং রিপোর্ট প্রদান করুন</p>
                            </div>
                            <a href="{{ route('tasks.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                                সব টাস্ক &rarr;
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($trainingTasks as $task)
                                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-2.5">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                                {{ $task->category_icon }} {{ $task->drill_name }}
                                            </span>
                                            <span class="px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                                {{ $task->sport_type }}
                                            </span>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-sm">{{ $task->title }}</h5>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($task->status === 'reviewed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                                    ✓ মূল্যায়িত ({{ $task->coach_score }}/১০ ★)
                                                </span>
                                            @elseif($task->status === 'completed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300">
                                                    ⏳ মূল্যায়নের অপেক্ষায়
                                                </span>
                                            @else
                                                <button @click="completeModal = true; completeTaskId = {{ $task->id }}; taskTitle = '{{ addslashes($task->title) }}'" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm transition">
                                                    ✓ সম্পন্ন করেছি
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    @if($task->description)
                                        <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">{{ $task->description }}</p>
                                    @endif

                                    <!-- Player Note if exists -->
                                    @if($task->player_note)
                                        <div class="p-2 rounded-lg bg-cyan-50 dark:bg-cyan-950/20 text-xs text-cyan-800 dark:text-cyan-300 border border-cyan-200/50">
                                            <span class="font-bold text-[10px] block uppercase text-cyan-600">আপনার রিপোর্ট:</span>
                                            {{ $task->player_note }}
                                        </div>
                                    @endif

                                    <div class="flex flex-wrap items-center justify-between text-[11px] text-gray-500 pt-2 border-t border-gray-200/60 dark:border-gray-700/60">
                                        <div>
                                            কোচ: <strong class="text-indigo-600 font-semibold">{{ $task->coach->name ?? 'একাডেমি প্রশিক্ষক' }}</strong>
                                        </div>
                                        <div>
                                            শেষ তারিখ: <span class="font-mono text-gray-700 dark:text-gray-300">{{ $task->due_date ? $task->due_date->format('d M, Y') : '-' }}</span>
                                        </div>
                                    </div>

                                    @if($task->coach_feedback)
                                        <div class="mt-2 p-2.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200/60 dark:border-emerald-800 text-xs">
                                            <span class="font-bold text-emerald-700 dark:text-emerald-300">কোচের মন্তব্য:</span>
                                            <p class="text-gray-700 dark:text-gray-300 mt-0.5">{{ $task->coach_feedback }}</p>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-6 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 text-xs text-gray-400">
                                    কোচ কর্তৃক বর্তমানে কোনো পেন্ডিং ড্রিল বা টাস্ক নেই। নতুন ড্রিল দিলে এখানে প্রদর্শিত হবে।
                                </div>
                            @endforelse
                        </div>

                        <!-- Complete Modal -->
                        <div x-show="completeModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 flex items-center justify-center p-4">
                            <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 dark:border-gray-700" @click.away="completeModal = false">
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">✓ ট্রেনিং ড্রিল সম্পন্ন রিপোর্ট</h3>
                                <p class="text-xs text-gray-400 mt-1" x-text="'টাস্ক: ' + taskTitle"></p>

                                <form :action="'{{ url('/tasks') }}/' + completeTaskId + '/complete'" method="POST" class="mt-4 space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">আপনার নোট বা মন্তব্য (ঐচ্ছিক)</label>
                                        <textarea name="player_note" rows="3" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" placeholder="যেমন: সকালে ৫০টি পুশ-আপ ও ৩০ মিনিট জগিং সম্পূর্ণ করেছি।"></textarea>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="completeModal = false" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold">বাতিল</button>
                                        <button type="submit" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow">জমা দিন</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Earned Certificates -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-amber-500/20">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                    <span>📜</span> অর্জিত অফিসিয়াল সনদপত্র (My Certificates)
                                </h4>
                                <p class="text-xs text-gray-400">একাডেমি হতে প্রাপ্ত কিউআর কোড সম্বলিত সকল ডিজিটাল সার্টিফিকেট</p>
                            </div>
                        </div>

                        @if($trainee && $trainee->certificates && $trainee->certificates->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($trainee->certificates as $cert)
                                    <div class="p-4 rounded-xl border border-amber-200/60 bg-gradient-to-br from-amber-50/50 to-white dark:from-amber-950/20 dark:to-gray-800 flex items-start justify-between gap-3">
                                        <div class="space-y-1">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                                {{ $cert->type_name }}
                                            </span>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-xs">{{ $cert->title }}</h5>
                                            <div class="text-[10px] font-mono text-gray-500">{{ $cert->certificate_no }} • {{ $cert->issue_date->format('d M, Y') }}</div>
                                            @if($cert->grade_or_rank)
                                                <div class="text-[11px] font-bold text-amber-700 dark:text-amber-400">{{ $cert->grade_or_rank }}</div>
                                            @endif
                                        </div>
                                        <a href="{{ route('admin.certificates.show', $cert) }}" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold shrink-0 shadow-sm transition">
                                            🖨️ প্রিন্ট
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 text-xs text-gray-400">
                                আপনার নামে এখনও কোনো সনদপত্র ইস্যু করা হয়নি। কোর্স ও টুর্নামেন্ট সম্পন্ন হলে এখানে দেখা যাবে।
                            </div>
                        @endif
                    </div>

                    <!-- Attendance & Fitness Overview -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-white text-base mb-4 flex items-center gap-2">
                            <span>📅</span> সাম্প্রতিক হাজিরা ও উপস্থিতি লগ
                        </h4>

                        @if($trainee && $trainee->attendances && $trainee->attendances->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
                                @foreach($trainee->attendances as $att)
                                    <div class="p-2.5 rounded-xl border text-center {{ $att->status == 'present' ? 'border-emerald-200 bg-emerald-50/50 dark:bg-emerald-950/30' : ($att->status == 'late' ? 'border-amber-200 bg-amber-50/50 dark:bg-amber-950/30' : 'border-rose-200 bg-rose-50/50 dark:bg-rose-950/30') }}">
                                        <div class="text-[10px] text-gray-500 dark:text-gray-400">{{ $att->date }}</div>
                                        <div class="text-xs font-bold mt-0.5 {{ $att->status == 'present' ? 'text-emerald-600' : ($att->status == 'late' ? 'text-amber-600' : 'text-rose-600') }}">
                                            {{ $att->status == 'present' ? 'উপস্থিত' : ($att->status == 'late' ? 'দেরি' : 'অনুপস্থিত') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-xs text-gray-400">হাজিরা রেকর্ড নেই।</div>
                        @endif
                    </div>

                    <!-- Payment Invoices -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-white text-base mb-4 flex items-center gap-2">
                            <span>💰</span> ফি পরিশোধ ও রসিদ
                        </h4>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                                <thead class="text-[11px] uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500">
                                    <tr>
                                        <th class="px-4 py-2">রসিদ নং</th>
                                        <th class="px-4 py-2">মাস ও বিবরণ</th>
                                        <th class="px-4 py-2">পরিমাণ</th>
                                        <th class="px-4 py-2">পদ্ধতি</th>
                                        <th class="px-4 py-2">স্ট্যাটাস</th>
                                        <th class="px-4 py-2 text-right">রসিদ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($trainee ? $trainee->payments : [] as $pay)
                                        <tr>
                                            <td class="px-4 py-2.5 font-mono font-bold">{{ $pay->invoice_no }}</td>
                                            <td class="px-4 py-2.5">{{ $pay->title }} ({{ $pay->month ?? '' }} {{ $pay->year }})</td>
                                            <td class="px-4 py-2.5 font-semibold text-gray-900 dark:text-white">৳{{ number_format($pay->amount) }}</td>
                                            <td class="px-4 py-2.5 uppercase">{{ $pay->payment_method }}</td>
                                            <td class="px-4 py-2.5">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $pay->status == 'paid' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300' }}">
                                                    {{ $pay->status == 'paid' ? 'পরিশোধিত' : 'বকেয়া' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5 text-right">
                                                <a href="{{ route('payments.show', $pay) }}" class="text-emerald-600 dark:text-emerald-400 font-semibold hover:underline">রসিদ ➔</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-gray-400">কোনো পেমেন্ট রেকর্ড পাওয়া যায়নি।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Upcoming & Live Matches -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                <span>🏆</span> একাডেমি ম্যাচ শিডিউল
                            </h4>
                            <a href="{{ route('live.index') }}" class="text-xs font-bold text-rose-600 hover:underline">লাইভ সেন্টার ↗</a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @forelse($upcomingMatches as $match)
                                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 space-y-2">
                                    <div class="flex items-center justify-between text-[11px]">
                                        <span class="font-bold text-gray-500 uppercase">{{ $match->sport_type }}</span>
                                        @if($match->status === 'live')
                                            <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-600 font-bold animate-pulse text-[10px]">● LIVE</span>
                                        @else
                                            <span class="text-gray-400 text-[10px]">{{ $match->match_datetime ? \Carbon\Carbon::parse($match->match_datetime)->format('d M, h:i A') : 'শিডিউলকৃত' }}</span>
                                        @endif
                                    </div>
                                    <div class="font-bold text-gray-900 dark:text-white text-sm">
                                        {{ $match->team_a }} <span class="text-gray-400 font-normal">বনাম</span> {{ $match->team_b }}
                                    </div>
                                    <a href="{{ route('live.show', $match->slug) }}" class="inline-block text-xs font-bold text-emerald-600 hover:underline">
                                        ম্যাচ স্কোরকার্ড দেখুন &rarr;
                                    </a>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-3 text-xs text-gray-400">আসন্ন কোনো ম্যাচ শিডিউল নেই।</div>
                            @endforelse
                        </div>
                    </div>

            </div>

            <!-- ============================================================== -->
            <!-- 📸 PLAYER DASHBOARD GALLERY WIDGET -->
            <!-- ============================================================== -->
            @if($trainee)
                <div x-data="{ openUploadModal: false, lightboxPhoto: null }" class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700/60 pb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-400 font-bold text-xs">
                                    📸 প্লেয়ার মিডিয়া হাব
                                </span>
                                <span class="text-xs text-gray-400">অ্যাকশন ও প্রোমো ফটো কালেকশন</span>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white mt-1">
                                আমার খেলার মুহূর্ত ও প্রোমো অ্যালবাম
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                আপনার ম্যাচের গোল, বাউন্ডারি, ড্রিল প্রস্তুতি বা অফিসিয়াল প্রোমো শুটের ছবি যোগ করুন
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="openUploadModal = true" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow transition flex items-center gap-1.5">
                                <span>+ নতুন ছবি যোগ করুন</span>
                            </button>
                            <a href="{{ route('profile.player') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold text-xs rounded-xl transition">
                                সম্পূর্ণ প্রোফাইল অ্যালবাম ➔
                            </a>
                        </div>
                    </div>

                    <!-- Gallery Photos Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @forelse($trainee->galleries->take(8) as $photo)
                            <div class="group relative rounded-2xl overflow-hidden bg-slate-900 border border-gray-200 dark:border-gray-700 shadow hover:shadow-lg transition">
                                <div class="aspect-[4/3] w-full overflow-hidden bg-slate-950 cursor-pointer" @click="lightboxPhoto = {
                                    url: '{{ $photo->image_url }}',
                                    title: '{{ addslashes($photo->title) }}',
                                    desc: '{{ addslashes($photo->description ?? '') }}',
                                    category: '{{ $photo->category_label }}',
                                    match: '{{ addslashes($photo->match_name ?? '') }}',
                                    date: '{{ $photo->event_date ? $photo->event_date->format('d M, Y') : '' }}',
                                    featured: {{ $photo->is_featured ? 'true' : 'false' }}
                                }">
                                    <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    
                                    <div class="absolute top-2 left-2">
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase backdrop-blur-md border {{ $photo->category_badge_class }}">
                                            {{ $photo->category_label }}
                                        </span>
                                    </div>
                                    @if($photo->is_featured)
                                        <div class="absolute top-2 right-2">
                                            <span class="px-1.5 py-0.5 rounded-full text-[9px] font-black bg-amber-500 text-slate-950">
                                                ★
                                            </span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <span class="text-white text-base">🔍</span>
                                    </div>
                                </div>
                                <div class="p-3 bg-white dark:bg-gray-800">
                                    <h5 class="font-bold text-xs text-gray-900 dark:text-white line-clamp-1 group-hover:text-rose-500 transition">
                                        {{ $photo->title }}
                                    </h5>
                                    <span class="text-[10px] text-gray-400 block mt-0.5 truncate">
                                        {{ $photo->match_name ?: ($photo->event_date ? $photo->event_date->format('d M, Y') : 'অ্যালবাম ফটো') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-8 text-center bg-gray-50 dark:bg-gray-750/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 space-y-2">
                                <span class="text-3xl block">📸</span>
                                <h4 class="font-bold text-gray-700 dark:text-gray-300 text-xs">আপনার কোনো খেলার বা প্রোমো ছবি এখনও নেই</h4>
                                <button @click="openUploadModal = true" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow">
                                    + প্রথম ছবি আপলোড করুন
                                </button>
                            </div>
                        @endforelse
                    </div>

                    <!-- Lightbox Modal -->
                    <div x-show="lightboxPhoto" x-transition.opacity class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md flex items-center justify-center p-4" style="display: none;" @keydown.escape.window="lightboxPhoto = null">
                        <div @click.away="lightboxPhoto = null" class="bg-slate-900 border border-slate-700 rounded-3xl max-w-3xl w-full overflow-hidden shadow-2xl relative">
                            <button @click="lightboxPhoto = null" class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-slate-950/80 text-white flex items-center justify-center text-lg font-bold hover:bg-rose-600 transition">
                                &times;
                            </button>
                            <div class="bg-black flex items-center justify-center max-h-[60vh] overflow-hidden">
                                <img :src="lightboxPhoto?.url" :alt="lightboxPhoto?.title" class="w-full h-full object-contain max-h-[60vh]">
                            </div>
                            <div class="p-5 text-white space-y-2">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30" x-text="lightboxPhoto?.category"></span>
                                <h4 class="font-black text-base" x-text="lightboxPhoto?.title"></h4>
                                <template x-if="lightboxPhoto?.desc">
                                    <p class="text-xs text-slate-300" x-text="lightboxPhoto?.desc"></p>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Modal -->
                    <div x-show="openUploadModal" x-transition.opacity class="fixed inset-0 z-50 bg-black/75 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
                        <div @click.away="openUploadModal = false" class="bg-white dark:bg-gray-800 rounded-3xl max-w-lg w-full p-6 border border-gray-200 dark:border-gray-700 shadow-2xl text-gray-800 dark:text-white space-y-4">
                            <div class="flex items-center justify-between border-b pb-3 dark:border-gray-700">
                                <h4 class="font-black text-base flex items-center gap-2">
                                    <span>📸</span> গ্যালারিতে নতুন ছবি / প্রোমো মুহূর্ত যোগ করুন
                                </h4>
                                <button @click="openUploadModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                            </div>

                            <form method="POST" action="{{ route('trainees.gallery.store', $trainee) }}" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold mb-1">ছবির শিরোনাম / ক্যাপশন *</label>
                                    <input type="text" name="title" required placeholder="যেমন: টুর্নামেন্ট ম্যাচে গোল মুহূর্ত" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">ক্যাটাগরি *</label>
                                        <select name="category" required class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                            <option value="match_action">⚽🏏 ম্যাচ অ্যাকশন ফটো</option>
                                            <option value="training">🏃 ট্রেনিং ও ড্রিল সেশন</option>
                                            <option value="celebration">🏆 উদযাপন ও ট্রফি অর্জন</option>
                                            <option value="promo">🌟 অফিশিয়াল প্রোমো / পোর্ট্রেট</option>
                                            <option value="other">📸 অন্যান্য স্মরণীয় মুহূর্ত</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">ছবি ফাইল *</label>
                                        <input type="file" name="photo" accept="image/*" required class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-500 file:text-white hover:file:bg-rose-600">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold mb-1">ম্যাচ / ইভেন্টের নাম (ঐচ্ছিক)</label>
                                        <input type="text" name="match_name" placeholder="যেমন: চ্যাম্পিয়নশিপ লিগ ২০২৬" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold mb-1">তারিখ</label>
                                        <input type="date" name="event_date" value="{{ date('Y-m-d') }}" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">বিবরণ / ক্যাপশন নোট (ঐচ্ছিক)</label>
                                    <textarea name="description" rows="2" placeholder="ম্যাচের গুরুত্বপূর্ণ মুহূর্ত বা বর্ণনামূলক তথ্য লিখুন..." class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900"></textarea>
                                </div>
                                <div class="pt-2 flex justify-end gap-2 border-t dark:border-gray-700">
                                    <button type="button" @click="openUploadModal = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-xs font-bold rounded-xl">বাতিল</button>
                                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow">আপলোড করুন &rarr;</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

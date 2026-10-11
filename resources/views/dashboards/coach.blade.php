<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 font-bold text-xs">
                        📋 কোচ প্যানেল ড্যাশবোর্ড
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">পদবি: <strong class="text-indigo-600">{{ $coach->designation ?? 'প্রধান প্রশিক্ষক' }}</strong></span>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 mt-1 flex items-center gap-2">
                    <span>স্বাগতম, কোচ</span> {{ $coach->name ?? Auth::user()->name }}! ⚽
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    জামিরবাড়িয়া স্পোর্টস একাডেমি • {{ $coach->sport->name ?? 'ফুটবল ও ক্রিকেট' }} প্রশিক্ষণ বিভাগ
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('tasks.index') }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>🎯 প্লেয়ারদের টাস্ক ও ড্রিল</span>
                </a>
                <a href="{{ route('attendances.index') }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>📝 দৈনিক হাজিরা</span>
                </a>
                <a href="{{ route('performances.create') }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>🏃 ফিটনেস স্কোর</span>
                </a>
                <a href="{{ route('matches.index') }}" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>🔴 লাইভ ম্যাচ</span>
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

            <!-- Coach Quick Metrics -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-indigo-500/20 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">দায়িত্বপ্রাপ্ত প্লেয়ার</span>
                        <span class="text-lg">🏃‍♂️</span>
                    </div>
                    <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-2">
                        {{ $totalPlayers }} জন
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">নিয়মিত স্কোয়াড সদস্য</span>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-emerald-500/20 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">সক্রিয় ব্যাচ</span>
                        <span class="text-lg">📅</span>
                    </div>
                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-2">
                        {{ $batches->count() }} টি
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">নির্ধারিত প্রশিক্ষণ সেশন</span>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-amber-500/20 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">আজকের হাজিরা</span>
                        <span class="text-lg">✓</span>
                    </div>
                    <div class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-2">
                        {{ $todayPresentCount }} / {{ $todayAttendanceCount }}
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">আজকের উপস্থিতি রেকর্ড</span>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-rose-500/20 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">ফিটনেস অ্যাসেসমেন্ট</span>
                        <span class="text-lg">📊</span>
                    </div>
                    <div class="text-2xl font-black text-rose-600 dark:text-rose-400 mt-2">
                        {{ $recentFitness->count() }} টি
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">সাম্প্রতিক মূল্যায়িত রেকর্ড</span>
                </div>
            </div>

            <!-- Coach Action Hub Banner -->
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-950 text-white rounded-3xl p-6 shadow-xl border border-indigo-500/30 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-1 text-center md:text-left">
                    <span class="px-2.5 py-0.5 rounded-full bg-indigo-500/30 text-indigo-300 text-[10px] font-bold uppercase tracking-wider">
                        ট্রেনিং সেশন টুলস
                    </span>
                    <h3 class="text-lg font-black text-white">দৈনিক প্রশিক্ষণ, হাজিরা ও প্লেয়ার মূল্যায়ন সম্পন্ন করুন</h3>
                    <p class="text-xs text-indigo-200/80">খেলোয়াড়দের উপস্থিতি রেকর্ড করুন এবং নিয়মিত ফিটনেস অগ্রগতি ট্র্যাক করুন।</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('attendances.index') }}" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl text-xs shadow transition flex items-center gap-2">
                        <span>📝 আজকের হাজিরা নিন</span>
                    </a>
                    <a href="{{ route('performances.create') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-xs shadow transition flex items-center gap-2">
                        <span>🏃 ফিটনেস স্কোর দিন</span>
                    </a>
                    <a href="{{ route('admin.id-cards.index') }}" class="px-3.5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl text-xs border border-white/20 transition">
                        🪪 আইডি কার্ড সেন্টার
                    </a>
                </div>
            </div>

            <!-- Main Coach Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Batches & Schedules -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                <span>📅</span> আমার ব্যাচ ও শিডিউল
                            </h4>
                            <span class="text-xs text-gray-400">{{ $batches->count() }}টি ব্যাচ</span>
                        </div>

                        <div class="space-y-3">
                            @forelse($batches as $batch)
                                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <h5 class="font-bold text-gray-900 dark:text-white text-sm">{{ $batch->name }}</h5>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600">
                                            {{ $batch->trainees_count ?? 0 }} জন প্লেয়ার
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 space-y-1">
                                        <div>খেলা: <strong class="text-gray-800 dark:text-gray-200">{{ $batch->sport->name ?? 'ফুটবল' }}</strong></div>
                                        <div>দিন: <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $batch->days ?? 'শনি, সোম, বুধ' }}</span></div>
                                        <div>সময়: <span class="text-emerald-600 font-semibold">{{ $batch->time_slot ?? '৪:০০ - ৬:০০ PM' }}</span></div>
                                    </div>
                                    <div class="pt-2 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center text-xs">
                                        <a href="{{ route('attendances.index', ['batch_id' => $batch->id]) }}" class="text-emerald-600 font-bold hover:underline">
                                            হাজিরা দিন &rarr;
                                        </a>
                                        <a href="{{ route('batches.show', $batch) }}" class="text-gray-500 hover:underline">
                                            বিস্তারিত
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-xs text-gray-400">কোনো ব্যাচ বরাদ্দ নেই।</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Academy Notices -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-white text-base mb-3 flex items-center gap-2">
                            <span>📢</span> কোচিং নোটিশ বোর্ড
                        </h4>
                        <div class="space-y-3">
                            @forelse($notices as $notice)
                                <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700 text-xs">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $notice->title }}</div>
                                    <p class="text-gray-500 mt-1 line-clamp-2 text-[11px]">{{ $notice->content }}</p>
                                    <span class="text-[10px] text-gray-400 font-mono mt-1 block">{{ $notice->notice_date }}</span>
                                </div>
                            @empty
                                <div class="text-xs text-gray-400 text-center py-3">নতুন নোটিশ নেই।</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right 2 Columns: Players Roster & Fitness Performance -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Players Squad List -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                    <span>🏃‍♂️</span> দায়িত্বপ্রাপ্ত প্লেয়ার ও অ্যাথলেট রোস্টার
                                </h4>
                                <p class="text-xs text-gray-400">আপনার প্রশিক্ষণে থাকা সকল সক্রিয় খেলোয়াড়</p>
                            </div>
                            <a href="{{ route('trainees.index') }}" class="text-xs font-bold text-indigo-600 hover:underline">
                                সম্পূর্ণ তালিকা &rarr;
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                                <thead class="text-[11px] uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500">
                                    <tr>
                                        <th class="px-4 py-2.5">প্লেয়ার</th>
                                        <th class="px-4 py-2.5">আইডি নং</th>
                                        <th class="px-4 py-2.5">খেলা ও পজিশন</th>
                                        <th class="px-4 py-2.5">রক্তের গ্রুপ</th>
                                        <th class="px-4 py-2.5 text-right">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($trainees as $t)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                                            <td class="px-4 py-2.5">
                                                <div class="flex items-center gap-2.5">
                                                    <div class="w-8 h-8 rounded-lg bg-slate-900 border border-emerald-500/30 overflow-hidden shrink-0 flex items-center justify-center">
                                                        @if($t->photo)
                                                            <img src="{{ asset('storage/' . $t->photo) }}" alt="" class="w-full h-full object-cover">
                                                        @else
                                                            <span class="font-bold text-emerald-400 text-xs">{{ mb_substr($t->name, 0, 1) }}</span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('trainees.show', $t) }}" class="font-bold text-gray-900 dark:text-white hover:text-emerald-600">
                                                            {{ $t->name }}
                                                        </a>
                                                        <div class="text-[10px] text-gray-400">{{ $t->category }} @if($t->jersey_no) • #{{ $t->jersey_no }} @endif</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2.5 font-mono font-bold text-emerald-600">{{ $t->admission_no }}</td>
                                            <td class="px-4 py-2.5">
                                                <div>{{ $t->sport->name ?? 'সাধারণ' }}</div>
                                                <div class="text-[10px] text-gray-400">{{ $t->position ?? 'প্লেয়ার' }}</div>
                                            </td>
                                            <td class="px-4 py-2.5 font-mono font-bold text-rose-500">{{ $t->blood_group ?? '-' }}</td>
                                            <td class="px-4 py-2.5 text-right space-x-1.5 whitespace-nowrap">
                                                <a href="{{ route('admin.id-cards.show', $t) }}" class="px-2 py-1 bg-emerald-500/10 hover:bg-emerald-500 text-emerald-700 hover:text-white rounded-lg text-[11px] font-bold transition">
                                                    🪪 কার্ড
                                                </a>
                                                <a href="{{ route('performances.create', ['trainee_id' => $t->id]) }}" class="px-2 py-1 bg-indigo-500/10 hover:bg-indigo-500 text-indigo-700 hover:text-white rounded-lg text-[11px] font-bold transition">
                                                    🏃 ফিটনেস
                                                </a>
                                                <a href="{{ route('trainees.show', $t) }}" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg text-[11px] transition">
                                                    প্রোফাইল
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-gray-400">কোনো প্লেয়ার পাওয়া যায়নি।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Training Tasks & Assigned Drills (প্লেয়ারদের জন্য ড্রিল ও টাস্ক) -->
                    <div x-data="{
                        showReviewModal: false,
                        reviewTaskId: null,
                        reviewTaskTitle: '',
                        reviewPlayerNote: ''
                    }" class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-emerald-500/20">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                    <span>🎯</span> প্লেয়ারদের জন্য নির্ধারিত ট্রেনিং ড্রিল ও টাস্ক
                                </h4>
                                <p class="text-xs text-gray-400">প্লেয়ারদের হোম ড্রিল প্রদান করুন এবং তাদের কাজ সম্পন্ন হলে স্কোর ও মূল্যায়ন দিন</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('tasks.index') }}" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                    + ড্রিল সেন্টার ও নতুন টাস্ক &rarr;
                                </a>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @forelse($trainingTasks as $task)
                                <div class="p-3.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                                                {{ $task->drill_name }}
                                            </span>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm">{{ $task->title }}</h5>
                                        </div>
                                        <div class="text-[11px] text-gray-500 dark:text-gray-400">
                                            @if($task->trainee)
                                                প্লেয়ার: <strong class="text-emerald-600">{{ $task->trainee->name }}</strong>
                                            @elseif($task->batch)
                                                ব্যাচ: <strong class="text-indigo-600">{{ $task->batch->name }}</strong>
                                            @else
                                                <span class="text-gray-400">সকল প্লেয়ার</span>
                                            @endif
                                            • শেষ তারিখ: <span class="font-mono text-gray-700 dark:text-gray-300">{{ $task->due_date ? $task->due_date->format('d M, Y') : 'নির্দিষ্ট নেই' }}</span>
                                        </div>
                                        @if($task->player_note)
                                            <div class="text-[10px] text-cyan-600 dark:text-cyan-400 italic">
                                                নোট: "{{ Str::limit($task->player_note, 60) }}"
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        @if($task->status === 'reviewed')
                                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                                ✓ মূল্যায়িত ({{ $task->coach_score }}/১০ ★)
                                            </span>
                                        @elseif($task->status === 'completed')
                                            <button type="button" @click="reviewTaskId = {{ $task->id }}; reviewTaskTitle = '{{ addslashes($task->title) }}'; reviewPlayerNote = '{{ addslashes($task->player_note ?? '') }}'; showReviewModal = true" class="px-3 py-1 rounded-lg text-xs font-bold bg-amber-500 text-slate-950 hover:bg-amber-400 shadow-sm transition">
                                                ★ রিভিউ ও স্কোর দিন
                                            </button>
                                        @else
                                            <form method="POST" action="{{ route('tasks.quick-complete', $task) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 hover:bg-emerald-600 hover:text-white text-gray-700 dark:bg-gray-700 dark:text-gray-200 transition" title="মাঠে সরাসরি সম্পন্ন মার্ক করুন">
                                                    ⚡ সম্পন্ন
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('tasks.index') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">
                                            ডিটেইলস &rarr;
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-xs text-gray-400">
                                    বর্তমানে কোনো নির্ধারিত ড্রিল নেই। <a href="{{ route('tasks.index') }}" class="text-emerald-600 font-bold hover:underline">+ প্রথম ড্রিল তৈরি করুন</a>
                                </div>
                            @endforelse
                        </div>

                        <!-- Coach Quick Review Modal -->
                        <div x-show="showReviewModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
                            <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 dark:border-gray-700 space-y-4" @click.away="showReviewModal = false">
                                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                                    <h3 class="font-bold text-gray-900 dark:text-white text-base">★ ড্রিল মূল্যায়ন ও কোচিং স্কোর</h3>
                                    <button type="button" @click="showReviewModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                                </div>
                                <form :action="'{{ url('/tasks') }}/' + reviewTaskId + '/review'" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <div class="text-xs text-gray-600 dark:text-gray-300">
                                        টাস্ক: <strong class="text-gray-900 dark:text-white" x-text="reviewTaskTitle"></strong>
                                    </div>
                                    <template x-if="reviewPlayerNote">
                                        <div class="p-2.5 rounded-xl bg-blue-50 dark:bg-blue-950/30 text-xs text-blue-900 dark:text-blue-200 border border-blue-200/40">
                                            <span class="font-bold text-[10px] block uppercase text-blue-600">প্লেয়ারের নোট:</span>
                                            <span x-text="reviewPlayerNote"></span>
                                        </div>
                                    </template>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">কোচিং স্কোর (১ থেকে ১০ এর মধ্যে) <span class="text-rose-500">*</span></label>
                                        <input type="number" name="coach_score" min="1" max="10" value="9" required class="w-full text-sm font-mono font-bold rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-amber-400 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">কোচের ফিডব্যাক ও মন্তব্য</label>
                                        <textarea name="coach_feedback" rows="3" placeholder="খেলোয়াড়ের ড্রিল সম্পাদনে পরামর্শ বা প্রশংসা লিখুন..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500"></textarea>
                                    </div>
                                    <div class="flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                        <button type="button" @click="showReviewModal = false" class="px-3.5 py-1.5 bg-gray-100 dark:bg-gray-700 text-xs font-bold rounded-xl">বাতিল</button>
                                        <button type="submit" class="px-4 py-1.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold rounded-xl shadow transition">স্কোর ও ফিডব্যাক দিন ★</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Fitness Test Evaluations -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                <span>📊</span> সাম্প্রতিক প্লেয়ার ফিটনেস টেস্ট রিপোর্ট
                            </h4>
                            <a href="{{ route('performances.create') }}" class="text-xs font-bold text-indigo-600 hover:underline">
                                + নতুন টেস্ট নিন &rarr;
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @forelse($recentFitness as $fit)
                                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $fit->trainee->name ?? 'প্লেয়ার' }}</div>
                                        <span class="text-amber-500 font-bold text-xs">{{ $fit->coach_rating ?? 5 }} ★</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 text-center text-[10px] pt-1">
                                        <div class="p-1.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                            <span class="text-gray-400 block">১০০মি. দৌড়</span>
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $fit->sprint_100m_sec ? $fit->sprint_100m_sec . 's' : '-' }}</span>
                                        </div>
                                        <div class="p-1.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                            <span class="text-gray-400 block">Yo-Yo টেস্ট</span>
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $fit->yoyo_score ?? '-' }}</span>
                                        </div>
                                        <div class="p-1.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                            <span class="text-gray-400 block">তারিখ</span>
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $fit->test_date }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-4 text-xs text-gray-400">কোনো ফিটনেস টেস্ট রিপোর্ট এখনও নেই।</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Upcoming Matches -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                <span>🏆</span> একাডেমি ম্যাচ ও টুর্নামেন্ট
                            </h4>
                            <a href="{{ route('matches.index') }}" class="text-xs font-bold text-rose-600 hover:underline">ম্যাচ কন্ট্রোল প্যানেল &rarr;</a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @forelse($matches as $m)
                                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-1.5">
                                    <div class="flex items-center justify-between text-[11px]">
                                        <span class="font-bold text-gray-500 uppercase">{{ $m->sport_type }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $m->status === 'live' ? 'bg-rose-500/20 text-rose-600 animate-pulse' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ strtoupper($m->status) }}
                                        </span>
                                    </div>
                                    <div class="font-bold text-gray-900 dark:text-white text-sm">
                                        {{ $m->team_a }} vs {{ $m->team_b }}
                                    </div>
                                    <a href="{{ route('matches.scorer', $m->slug) }}" class="inline-block text-xs font-bold text-indigo-600 hover:underline">
                                        স্কোরার কনসোলে প্রবেশ করুন &rarr;
                                    </a>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-3 text-xs text-gray-400">কোনো ম্যাচ নেই।</div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>

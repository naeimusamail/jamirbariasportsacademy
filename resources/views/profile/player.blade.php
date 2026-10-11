<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-bold text-xs uppercase tracking-wider">
                        🏃‍♂️ অফিশিয়াল প্লেয়ার প্রোফাইল
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">আইডি: <strong class="font-mono text-emerald-600">{{ $trainee->admission_no }}</strong></span>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 mt-1">
                    {{ $trainee->name }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $trainee->sport->name ?? 'অ্যাথলেটিক্স' }} • {{ $trainee->category }} স্কোয়াড @if($trainee->jersey_no) • জার্সি #{{ $trainee->jersey_no }} @endif
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.id-cards.show', $trainee) }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>🪪 আইডি কার্ড প্রিন্ট</span>
                </a>
                <a href="{{ route('dashboard.player') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                    প্লেয়ার ড্যাশবোর্ড &rarr;
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Hero Athlete Banner & Profile Card -->
            <div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-emerald-500/30 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Athlete Photo (300x300 proportion) -->
                    <div class="w-36 h-36 sm:w-44 sm:h-44 rounded-2xl bg-slate-800 border-4 border-emerald-500/60 overflow-hidden shrink-0 shadow-2xl flex items-center justify-center">
                        @if($trainee->photo)
                            <img src="{{ asset('storage/' . $trainee->photo) }}" alt="{{ $trainee->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-black text-emerald-400">{{ mb_substr($trainee->name, 0, 1) }}</span>
                        @endif
                    </div>

                    <!-- Athlete Essential Summary -->
                    <div class="flex-1 text-center md:text-left space-y-3">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                            @if($trainee->sports && $trainee->sports->count() > 0)
                                @foreach($trainee->sports as $sp)
                                    <span class="px-3 py-1 rounded-full text-xs font-black {{ $sp->pivot->is_primary ? 'bg-emerald-500 text-slate-950' : 'bg-white/15 text-emerald-200 border border-emerald-400/30' }} shadow-sm flex items-center gap-1">
                                        <span>{{ $sp->icon ?? '⚽' }}</span>
                                        <span>{{ $sp->name }}</span>
                                        @if($sp->pivot->position)
                                            <span class="opacity-75 font-normal">({{ $sp->pivot->position }})</span>
                                        @endif
                                    </span>
                                @endforeach
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-500 text-slate-950 shadow-sm">
                                    {{ $trainee->sport->name ?? 'স্পোর্টস' }}
                                </span>
                            @endif
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-emerald-300 border border-white/10">
                                {{ $trainee->category }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                রক্ত: {{ $trainee->blood_group ?? 'N/A' }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-white">{{ $trainee->name }}</h3>
                            <p class="text-xs sm:text-sm text-emerald-200/80 mt-0.5">
                                জামিরবাড়িয়া স্পোর্টস একাডেমি • ভর্তি নং: <span class="font-mono font-bold text-white">{{ $trainee->admission_no }}</span>
                            </p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2 border-t border-emerald-500/20 text-xs">
                            <div>
                                <span class="text-[10px] text-emerald-300/70 block">নির্ধারিত ব্যাচ</span>
                                <strong class="text-white">{{ $trainee->batch->name ?? 'জুনিয়র স্কোয়াড' }}</strong>
                            </div>
                            <div>
                                <span class="text-[10px] text-emerald-300/70 block">দায়িত্বশীল কোচ</span>
                                <strong class="text-white">{{ $trainee->batch->coach->name ?? 'একাডেমি কোচ' }}</strong>
                            </div>
                            <div>
                                <span class="text-[10px] text-emerald-300/70 block">উপস্থিতি হার</span>
                                <strong class="text-emerald-400 font-bold">{{ $attendanceRate }}%</strong>
                            </div>
                            <div>
                                <span class="text-[10px] text-emerald-300/70 block">ভর্তির তারিখ</span>
                                <strong class="text-white">{{ $trainee->created_at ? $trainee->created_at->format('d M, Y') : '২০২৬' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Info Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Personal & Guardian Details -->
                <div class="space-y-6">
                    <!-- Personal Profile Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 space-y-4">
                        <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                            <span>📋</span> ব্যক্তিগত ও পারিবারিক তথ্য
                        </h4>

                        <div class="text-xs space-y-2.5 text-gray-600 dark:text-gray-300 divide-y divide-gray-100 dark:divide-gray-700">
                            <div class="flex justify-between pt-1">
                                <span class="text-gray-400">নাম:</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $trainee->name }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">পিতার নাম:</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $trainee->father_name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">মাতার নাম:</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $trainee->mother_name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">জন্ম তারিখ / বয়স:</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $trainee->dob ? \Carbon\Carbon::parse($trainee->dob)->format('d M, Y') : ($trainee->age ? $trainee->age . ' বছর' : '-') }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">লিঙ্গ:</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $trainee->gender == 'female' ? 'নারী' : 'পুরুষ' }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">ফোন নম্বর:</span>
                                <span class="font-mono font-bold text-emerald-600">{{ $trainee->phone }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">জরুরি যোগাযোগ:</span>
                                <span class="font-mono text-rose-500 font-bold">{{ $trainee->emergency_contact ?? $trainee->phone }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-400">ঠিকানা:</span>
                                <span class="text-right text-gray-800 dark:text-gray-200 max-w-[200px]">{{ $trainee->address ?? 'জামিরবাড়িয়া' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Digital ID Card Quick Actions -->
                    <div class="bg-gradient-to-br from-slate-900 to-emerald-950 text-white rounded-2xl p-5 shadow-sm border border-emerald-500/30 text-center space-y-3">
                        <div class="text-3xl">🪪</div>
                        <h4 class="font-black text-sm text-white">অফিশিয়াল ডিজিটাল প্লেয়ার আইডি</h4>
                        <p class="text-xs text-emerald-200/80">কিউআর কোড সম্বলিত প্রিন্ট উপযোগী ডিজিটাল কার্ড ডাউনলোড বা প্রিন্ট করুন।</p>
                        <a href="{{ route('admin.id-cards.show', $trainee) }}" class="inline-block w-full py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl text-xs transition">
                            কার্ড ভিউ ও প্রিন্ট &rarr;
                        </a>
                    </div>
                </div>

                <!-- Right 2 Columns: Drills, Performance & Records -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Multi-Sports & Tournament Squad Profile -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-emerald-500/20 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                    <span>🏅</span> মাল্টি-স্পোর্টস অংশগ্রহণ ও পজিশন (Multi-Sports Profile)
                                </h4>
                                <p class="text-xs text-gray-400">এই প্লেয়ারের বিভিন্ন খেলায় অন্তর্ভুক্তি, নির্ধারিত পজিশন ও জার্সি নম্বর</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                মোট {{ $trainee->sports->count() }}টি খেলা
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @forelse($trainee->sports as $sp)
                                <div class="p-4 rounded-xl border {{ $sp->pivot->is_primary ? 'border-emerald-500/40 bg-emerald-50/40 dark:bg-emerald-950/20' : 'border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40' }} space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="text-2xl">{{ $sp->icon ?? '⚽' }}</span>
                                            <div>
                                                <h5 class="font-bold text-gray-900 dark:text-white text-sm">{{ $sp->name }}</h5>
                                                @if($sp->pivot->is_primary)
                                                    <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400">★ প্রধান খেলা</span>
                                                @else
                                                    <span class="text-[10px] text-gray-400">সেকেন্ডারি খেলা</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-[11px] text-gray-500 dark:text-gray-400 pt-2 border-t border-gray-100 dark:border-gray-700 space-y-1">
                                        <div>পজিশন: <strong class="text-gray-800 dark:text-gray-200">{{ $sp->pivot->position ?? ($trainee->position ?? 'প্লেয়ার') }}</strong></div>
                                        @if($sp->pivot->jersey_no || $trainee->jersey_no)
                                            <div>জার্সি: <strong class="text-amber-600 font-bold">#{{ $sp->pivot->jersey_no ?? $trainee->jersey_no }}</strong></div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-3 text-xs text-gray-400 text-center py-3">
                                    {{ $trainee->sport->name ?? 'সাধারণ স্পোর্টস' }}
                                </div>
                            @endforelse
                        </div>

                        @if($trainee->teamPlayers && $trainee->teamPlayers->count() > 0)
                            <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                                <h5 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <span>🛡️</span> টুর্নামেন্ট ও একাডেমি টিম স্কোয়াড
                                </h5>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($trainee->teamPlayers as $tp)
                                        @if($tp->team)
                                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                                <div class="flex items-center gap-2.5">
                                                    <div class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-sm overflow-hidden shrink-0">
                                                        @if($tp->team->logo)
                                                            <img src="{{ asset('storage/' . $tp->team->logo) }}" alt="" class="w-full h-full object-cover">
                                                        @else
                                                            ⚽
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('public.teams.show', $tp->team->slug) }}" class="font-bold text-gray-900 dark:text-white text-xs hover:text-emerald-600">
                                                            {{ $tp->team->name }}
                                                        </a>
                                                        <div class="text-[10px] text-gray-400">{{ $tp->team->sport_type }} • {{ $tp->team->category }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-600">
                                                        {{ $tp->position ?? 'প্লেয়ার' }}
                                                    </span>
                                                    @if($tp->jersey_number)
                                                        <div class="text-[10px] font-mono font-bold text-amber-600 mt-0.5">#{{ $tp->jersey_number }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Training Drills Assigned by Coach -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-indigo-500/20">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                <span>🎯</span> কোচের নির্দেশিত ট্রেনিং ড্রিল ও হোমওয়ার্ক
                            </h4>
                            <span class="text-xs text-indigo-600 font-bold">তদারককারী: {{ $trainee->batch->coach->name ?? 'কোচ' }}</span>
                        </div>

                        <div class="space-y-3">
                            @forelse($trainee->trainingTasks as $task)
                                <div class="p-3.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                                {{ $task->category_icon }} {{ $task->drill_name }}
                                            </span>
                                            <span class="px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                                {{ $task->sport_type }}
                                            </span>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm">{{ $task->title }}</h5>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            @if($task->status === 'reviewed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                                    ✓ মূল্যায়িত ({{ $task->coach_score }}/১০ ★)
                                                </span>
                                            @elseif($task->status === 'completed')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300">
                                                    ⏳ সম্পন্ন (রিভিউ বাকি)
                                                </span>
                                            @else
                                                <a href="{{ route('tasks.index') }}" class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition">
                                                    ✓ ড্রিল সম্পন্ন করুন
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @if($task->description)
                                        <p class="text-xs text-gray-600 dark:text-gray-300">{{ $task->description }}</p>
                                    @endif
                                    @if($task->coach_feedback)
                                        <div class="text-[11px] bg-emerald-50 dark:bg-emerald-950/30 p-2 rounded-lg text-emerald-800 dark:text-emerald-300">
                                            <strong>কোচ মন্তব্য:</strong> {{ $task->coach_feedback }}
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4 text-xs text-gray-400">বর্তমানে কোনো নির্ধারিত ড্রিল টাস্ক নেই।</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Fitness & Performance Metrics -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-white text-base mb-4 flex items-center gap-2">
                            <span>🏃</span> ফিটনেস টেস্ট ও কোচ অ্যাসেসমেন্ট হিস্টোরি
                        </h4>

                        @if($trainee->fitnessRecords && $trainee->fitnessRecords->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($trainee->fitnessRecords as $fit)
                                    <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-2">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="font-mono text-gray-500">{{ $fit->test_date }}</span>
                                            <span class="text-amber-500 font-bold">{{ $fit->coach_rating }} / 5 ★</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-2 text-center text-[10px]">
                                            <div class="p-1.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                                <span class="text-gray-400 block">১০০মি. দৌড়</span>
                                                <strong class="text-gray-900 dark:text-white">{{ $fit->sprint_100m_sec ? $fit->sprint_100m_sec . 's' : '-' }}</strong>
                                            </div>
                                            <div class="p-1.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                                <span class="text-gray-400 block">Yo-Yo টেস্ট</span>
                                                <strong class="text-gray-900 dark:text-white">{{ $fit->yoyo_score ?? '-' }}</strong>
                                            </div>
                                            <div class="p-1.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                                <span class="text-gray-400 block">পুশ-আপ</span>
                                                <strong class="text-gray-900 dark:text-white">{{ $fit->pushups_count ?? '-' }}</strong>
                                            </div>
                                        </div>
                                        @if($fit->remarks)
                                            <p class="text-[11px] text-gray-500 italic mt-1">"{{ $fit->remarks }}"</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-xs text-gray-400">কোনো ফিটনেস টেস্ট রেকর্ড এখনও নেই।</div>
                        @endif
                    </div>

                    <!-- Certificates Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-amber-500/20">
                        <h4 class="font-bold text-gray-900 dark:text-white text-base mb-4 flex items-center gap-2">
                            <span>📜</span> অর্জিত অফিসিয়াল সনদপত্র (Certificates)
                        </h4>

                        @if($trainee->certificates && $trainee->certificates->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($trainee->certificates as $cert)
                                    <div class="p-4 rounded-xl border border-amber-200/60 bg-gradient-to-br from-amber-50/50 to-white dark:from-amber-950/20 dark:to-gray-800 flex items-start justify-between gap-3">
                                        <div class="space-y-1">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                                {{ $cert->type_name }}
                                            </span>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-xs">{{ $cert->title }}</h5>
                                            <div class="text-[10px] font-mono text-gray-500">{{ $cert->certificate_no }}</div>
                                        </div>
                                        <a href="{{ route('admin.certificates.show', $cert) }}" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold shrink-0 shadow-sm transition">
                                            🖨️ প্রিন্ট
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-xs text-gray-400">কোনো সনদপত্র এখনও ইস্যু করা হয়নি।</div>
                        @endif
                    </div>

                </div>

            </div>

            <!-- ============================================================== -->
            <!-- 📸 MATCH ACTION & PROMO PHOTO GALLERY SHOWCASE -->
            <!-- ============================================================== -->
            <div x-data="{
                activeCategory: 'all',
                openUploadModal: false,
                lightboxPhoto: null
            }" class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">

                <!-- Gallery Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-750 pb-5">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-400 font-bold text-xs border border-rose-500/20 flex items-center gap-1.5">
                                <span>📸</span> খেলার মুহূর্ত ও প্রোমো অ্যালবাম
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">মোট ছবি: <strong>{{ $trainee->galleries->count() }}টি</strong></span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white mt-1.5 flex items-center gap-2">
                            <span>অ্যাকশন মুহূর্ত ও অফিসিয়াল মিডিয়া গ্যালারি</span> 🌟
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            ম্যাচে দুর্দান্ত গোল/রান, প্র্যাকটিস সেশন, পুরস্কার বিতরণী ও একাডেমি প্রোমো শুটের স্মৃতি কালেকশন
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isCoach() || Auth::user()->trainee_id == $trainee->id))
                            <button @click="openUploadModal = true" class="px-4 py-2.5 bg-gradient-to-r from-rose-600 to-amber-600 hover:from-rose-500 hover:to-amber-500 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-600/20 flex items-center gap-2 transition transform active:scale-95">
                                <span>+ নতুন ছবি / প্রোমো যোগ করুন</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Category Filter Tabs -->
                <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
                    <button @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 shadow' : 'bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-xl transition">
                        সবগুলো ({{ $trainee->galleries->count() }})
                    </button>
                    <button @click="activeCategory = 'match_action'" :class="activeCategory === 'match_action' ? 'bg-rose-600 text-white shadow' : 'bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1">
                        <span>⚽🏏</span> ম্যাচ অ্যাকশন ({{ $trainee->galleries->where('category', 'match_action')->count() }})
                    </button>
                    <button @click="activeCategory = 'training'" :class="activeCategory === 'training' ? 'bg-emerald-600 text-white shadow' : 'bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1">
                        <span>🏃</span> ট্রেনিং মুহূর্ত ({{ $trainee->galleries->where('category', 'training')->count() }})
                    </button>
                    <button @click="activeCategory = 'celebration'" :class="activeCategory === 'celebration' ? 'bg-amber-600 text-white shadow' : 'bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1">
                        <span>🏆</span> উদযাপন ও ট্রফি ({{ $trainee->galleries->where('category', 'celebration')->count() }})
                    </button>
                    <button @click="activeCategory = 'promo'" :class="activeCategory === 'promo' ? 'bg-cyan-600 text-white shadow' : 'bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 hover:bg-gray-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1">
                        <span>🌟</span> প্রোমো ও পোর্ট্রেট ({{ $trainee->galleries->where('category', 'promo')->count() }})
                    </button>
                </div>

                <!-- Photos Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">
                    @forelse($trainee->galleries as $photo)
                        <div x-show="activeCategory === 'all' || activeCategory === '{{ $photo->category }}'" class="group relative rounded-2xl overflow-hidden bg-slate-900 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-xl hover:border-rose-500/50 transition duration-300 flex flex-col justify-between">
                            
                            <!-- Image Container -->
                            <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-950 cursor-pointer" @click="lightboxPhoto = {
                                url: '{{ $photo->image_url }}',
                                title: '{{ addslashes($photo->title) }}',
                                desc: '{{ addslashes($photo->description ?? '') }}',
                                category: '{{ $photo->category_label }}',
                                match: '{{ addslashes($photo->match_name ?? '') }}',
                                date: '{{ $photo->event_date ? $photo->event_date->format('d M, Y') : '' }}',
                                featured: {{ $photo->is_featured ? 'true' : 'false' }}
                            }">
                                <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                
                                <!-- Top Badges -->
                                <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between pointer-events-none">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider backdrop-blur-md border {{ $photo->category_badge_class }}">
                                        {{ $photo->category_label }}
                                    </span>
                                    @if($photo->is_featured)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-slate-950 shadow flex items-center gap-1">
                                            ★ ফিচার্ড
                                        </span>
                                    @endif
                                </div>

                                <!-- Overlay Hover Icon -->
                                <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <span class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-lg shadow-lg">
                                        🔍
                                    </span>
                                </div>
                            </div>

                            <!-- Photo Details & Caption -->
                            <div class="p-4 bg-white dark:bg-gray-800 space-y-2 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white line-clamp-1 group-hover:text-rose-500 transition">
                                        {{ $photo->title }}
                                    </h4>
                                    @if($photo->description)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mt-1 leading-relaxed">
                                            {{ $photo->description }}
                                        </p>
                                    @endif
                                </div>

                                <div class="pt-2 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-[11px] text-gray-400">
                                    <span class="truncate max-w-[150px]">
                                        @if($photo->match_name)
                                            🏆 {{ $photo->match_name }}
                                        @elseif($photo->event_date)
                                            📅 {{ $photo->event_date->format('d M, Y') }}
                                        @else
                                            📸 একাডেমি অ্যালবাম
                                        @endif
                                    </span>

                                    <!-- Authorized Actions (Delete & Toggle Featured) -->
                                    @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isCoach() || Auth::user()->trainee_id == $trainee->id))
                                        <div class="flex items-center gap-1">
                                            <form method="POST" action="{{ route('gallery.toggle-featured', $photo) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="ফিচার্ড টগল করুন" class="text-xs p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ $photo->is_featured ? 'text-amber-500' : 'text-gray-400' }}">
                                                    ★
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('gallery.destroy', $photo) }}" onsubmit="return confirm('আপনি কি নিশ্চিত যে ছবিটি মুছে ফেলতে চান?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="মুছে ফেলুন" class="text-xs text-rose-500 hover:text-rose-700 p-1">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center bg-gray-50 dark:bg-gray-750/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 space-y-3">
                            <span class="text-4xl block">📸</span>
                            <h4 class="font-bold text-gray-700 dark:text-gray-300 text-sm">এই প্লেয়ারের কোনো খেলার মুহূর্ত বা প্রোমো ছবি এখনও যুক্ত করা হয়নি।</h4>
                            <p class="text-xs text-gray-400">ম্যাচের গোল, চার-ছক্কা, ড্রিল বা প্রোমো শুটের ছবি যোগ করতে নিচের বাটনে ক্লিক করুন।</p>
                            @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isCoach() || Auth::user()->trainee_id == $trainee->id))
                                <button @click="openUploadModal = true" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow">
                                    + প্রথম ছবি যোগ করুন
                                </button>
                            @endif
                        </div>
                    @endforelse
                </div>

                <!-- LIGHTBOX PREVIEW MODAL -->
                <div x-show="lightboxPhoto" x-transition.opacity class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md flex items-center justify-center p-4" style="display: none;" @keydown.escape.window="lightboxPhoto = null">
                    <div @click.away="lightboxPhoto = null" class="bg-slate-900 border border-slate-700 rounded-3xl max-w-4xl w-full overflow-hidden shadow-2xl relative">
                        <!-- Close Button -->
                        <button @click="lightboxPhoto = null" class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-slate-950/80 text-white flex items-center justify-center text-lg font-bold hover:bg-rose-600 transition shadow">
                            &times;
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-3">
                            <!-- Image -->
                            <div class="md:col-span-2 bg-black flex items-center justify-center max-h-[70vh] overflow-hidden">
                                <img :src="lightboxPhoto?.url" :alt="lightboxPhoto?.title" class="w-full h-full object-contain max-h-[70vh]">
                            </div>

                            <!-- Sidebar Details -->
                            <div class="p-6 text-white space-y-4 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30" x-text="lightboxPhoto?.category"></span>
                                        <template x-if="lightboxPhoto?.featured">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-slate-950">★ ফিচার্ড</span>
                                        </template>
                                    </div>

                                    <h3 class="font-black text-lg text-white" x-text="lightboxPhoto?.title"></h3>

                                    <template x-if="lightboxPhoto?.desc">
                                        <p class="text-xs text-slate-300 leading-relaxed" x-text="lightboxPhoto?.desc"></p>
                                    </template>
                                </div>

                                <div class="space-y-2 text-xs text-slate-400 border-t border-slate-800 pt-3">
                                    <template x-if="lightboxPhoto?.match">
                                        <div>🏆 টুর্নামেন্ট/ম্যাচ: <strong class="text-white" x-text="lightboxPhoto?.match"></strong></div>
                                    </template>
                                    <template x-if="lightboxPhoto?.date">
                                        <div>📅 তারিখ: <span class="text-white font-mono" x-text="lightboxPhoto?.date"></span></div>
                                    </template>
                                    <div class="pt-2">
                                        <a :href="lightboxPhoto?.url" target="_blank" class="text-xs text-rose-400 hover:underline flex items-center gap-1 font-bold">
                                            <span>আসল সাইজে ছবি দেখুন ↗</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHOTO UPLOAD MODAL -->
                <div x-show="openUploadModal" x-transition.opacity class="fixed inset-0 z-50 bg-black/75 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
                    <div @click.away="openUploadModal = false" class="bg-white dark:bg-gray-800 rounded-3xl max-w-lg w-full p-6 sm:p-8 border border-gray-200 dark:border-gray-700 shadow-2xl text-gray-800 dark:text-white space-y-4">
                        <div class="flex items-center justify-between border-b pb-3 dark:border-gray-700">
                            <div>
                                <h4 class="font-black text-base flex items-center gap-2">
                                    <span>📸</span> নতুন খেলার মুহূর্ত বা প্রোমো ছবি আপলোড
                                </h4>
                                <p class="text-[11px] text-gray-400">প্লেয়ার: {{ $trainee->name }} ({{ $trainee->admission_no }})</p>
                            </div>
                            <button @click="openUploadModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                        </div>

                        <form method="POST" action="{{ route('trainees.gallery.store', $trainee) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-bold mb-1">ছবির শিরোনাম / ক্যাপশন *</label>
                                <input type="text" name="title" required placeholder="যেমন: ফাইনাল ম্যাচে ফ্রি-কিক থেকে দুর্দান্ত গোল" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900">
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
                                    <label class="block text-xs font-bold mb-1">ছবি ফাইল নির্বাচন করুন *</label>
                                    <input type="file" name="photo" accept="image/*" required class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-500 file:text-white hover:file:bg-rose-600">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold mb-1">ম্যাচ বা ইভেন্টের নাম (ঐচ্ছিক)</label>
                                    <input type="text" name="match_name" placeholder="যেমন: চ্যাম্পিয়নশিপ লিগ ২০২৬" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">তারিখ (ঐচ্ছিক)</label>
                                    <input type="date" name="event_date" value="{{ date('Y-m-d') }}" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold mb-1">সংক্ষিপ্ত বিবরণ / নোট (ঐচ্ছিক)</label>
                                <textarea name="description" rows="2" placeholder="ম্যাচের গুরুত্বপূর্ণ মুহূর্ত বা প্রশিক্ষণের বিশেষ বিবরণ লিখুন..." class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900"></textarea>
                            </div>

                            <div class="flex items-center gap-2 pt-1">
                                <input type="checkbox" name="is_featured" value="1" id="is_featured_chk" class="rounded text-rose-600 focus:ring-rose-500">
                                <label for="is_featured_chk" class="text-xs font-semibold cursor-pointer">
                                    ★ প্রোফাইলের শীর্ষ ফিচার্ড অ্যালবামে দেখান
                                </label>
                            </div>

                            <div class="pt-2 flex justify-end gap-2 border-t dark:border-gray-700">
                                <button type="button" @click="openUploadModal = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-xs font-bold rounded-xl">বাতিল</button>
                                <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow">গ্যালারিতে যুক্ত করুন &rarr;</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>


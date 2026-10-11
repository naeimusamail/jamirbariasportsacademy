<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>⚽</span> {{ $trainee->name }} — ট্রেইনি প্রোফাইল
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">ভর্তি ও আইডি নং: <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $trainee->admission_no }}</span></p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.id-cards.show', $trainee) }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-xs shadow flex items-center gap-1.5 transition">
                    <span>🪪 ডিজিটাল আইডি কার্ড</span>
                </a>
                <a href="{{ route('admin.certificates.create', ['trainee_id' => $trainee->id]) }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-xl text-xs shadow flex items-center gap-1.5 transition">
                    <span>📜 সনদপত্র ইস্যু</span>
                </a>
                <a href="{{ route('trainees.report-card', $trainee) }}" class="px-3.5 py-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl text-xs shadow flex items-center gap-1.5 transition">
                    <span>📑 রিপোর্ট কার্ড</span>
                </a>
                <a href="{{ route('performances.create', ['trainee_id' => $trainee->id]) }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-xs shadow flex items-center gap-1.5 transition">
                    <span>🏃 ফিটনেস</span>
                </a>
                <a href="{{ route('payments.create', ['trainee_id' => $trainee->id]) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs shadow">
                    + ফি গ্রহণ
                </a>
                <a href="{{ route('trainees.edit', $trainee) }}" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-xs">
                    এডিট
                </a>
                <a href="{{ route('trainees.index') }}" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-xs">
                    &larr; তালিকা
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            body * { visibility: hidden; }
            #printable-id-card, #printable-id-card * { visibility: visible; }
            #printable-id-card {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                width: 340px !important;
                border: 2px solid #059669 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- ID Card / Quick Card Column -->
                <div class="space-y-6">
                    <!-- Professional Digital Student ID Card -->
                    <div id="printable-id-card" class="bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-950 text-white rounded-3xl p-6 shadow-2xl relative overflow-hidden border border-emerald-500/40">
                        <!-- Top Glow Decoration -->
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-400/20 rounded-full blur-2xl"></div>

                        <!-- Header -->
                        <div class="flex items-center justify-between border-b border-emerald-500/30 pb-3">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl">⚽</span>
                                <div>
                                    <div class="text-xs font-black tracking-wider uppercase text-emerald-300">জামিরবাড়িয়া স্পোর্টস একাডেমি</div>
                                    <div class="text-[9px] uppercase tracking-widest text-emerald-200/80 font-bold">OFFICIAL PLAYER ID CARD</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-mono font-bold bg-white/20 px-2.5 py-0.5 rounded-full border border-white/20">{{ $trainee->category }}</span>
                        </div>

                        <!-- Middle Athlete Info & Real Photo -->
                        <div class="mt-5 flex items-center space-x-4">
                            <div class="w-20 h-24 rounded-2xl bg-slate-900/80 border-2 border-emerald-400 overflow-hidden shadow-lg shrink-0 flex items-center justify-center">
                                @if($trainee->photo)
                                    <img src="{{ asset('storage/' . $trainee->photo) }}" alt="{{ $trainee->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-3xl text-emerald-400 font-black">
                                        {{ mb_substr($trainee->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <h4 class="font-black text-lg leading-snug truncate text-white">{{ $trainee->name }}</h4>
                                <p class="text-xs text-emerald-300 font-semibold mt-0.5">{{ $trainee->sport->name ?? 'অ্যাথলেটিক্স' }}</p>
                                <p class="text-[11px] text-gray-300 mt-1">পজিশন: <strong class="text-white">{{ $trainee->position ?? 'প্লেয়ার' }}</strong></p>
                                @if($trainee->jersey_no)
                                    <span class="inline-block text-[10px] bg-emerald-500/30 text-emerald-200 px-2 py-0.5 rounded font-bold mt-1">জার্সি: #{{ $trainee->jersey_no }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Details Grid -->
                        <div class="mt-5 pt-3 border-t border-emerald-500/30 grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-emerald-300 block text-[10px]">আইডি / রোল:</span>
                                <span class="font-mono font-black text-white text-xs">{{ $trainee->admission_no }}</span>
                            </div>
                            <div>
                                <span class="text-emerald-300 block text-[10px]">রক্তের গ্রুপ:</span>
                                <span class="font-bold text-rose-300 text-xs">{{ $trainee->blood_group ?? 'অজ্ঞাত' }}</span>
                            </div>
                            <div>
                                <span class="text-emerald-300 block text-[10px]">অভিভাবকের ফোন:</span>
                                <span class="font-mono text-gray-200 text-[11px]">{{ $trainee->phone }}</span>
                            </div>
                            <div>
                                <span class="text-emerald-300 block text-[10px]">ভর্তির তারিখ:</span>
                                <span class="text-gray-200 text-[11px]">{{ $trainee->admission_date }}</span>
                            </div>
                        </div>

                        <!-- Barcode & Full Card Action -->
                        <div class="mt-4 pt-3 border-t border-emerald-500/30 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="font-mono tracking-widest text-[9px] text-emerald-300/80 bg-black/40 px-2 py-1 rounded">
                                    ||| | ||||| || | |||| ||
                                </div>
                                <span class="text-[9px] text-emerald-300/70 border-t border-emerald-400/50 pt-0.5">কিউআর ভেরিফায়েড</span>
                            </div>
                            <a href="{{ route('admin.id-cards.show', $trainee) }}" class="block text-center py-2 bg-emerald-500/30 hover:bg-emerald-500 text-emerald-200 hover:text-white rounded-xl text-xs font-bold transition">
                                🖨️ আইডি কার্ড প্রিন্ট ও ফ্রন্ট/ব্যাক ভিউ &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Contact & Guardian Box -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-white text-base mb-3 flex items-center gap-2">
                            <span>📞</span> জরুরি যোগাযোগ ও ঠিকানা
                        </h4>
                        <ul class="text-xs space-y-2.5 text-gray-600 dark:text-gray-300">
                            <li><strong class="text-gray-800 dark:text-gray-200">অভিভাবক:</strong> {{ $trainee->guardian_name }}</li>
                            <li><strong class="text-gray-800 dark:text-gray-200">মোবাইল:</strong> <span class="font-mono font-bold">{{ $trainee->phone }}</span></li>
                            <li><strong class="text-gray-800 dark:text-gray-200">জরুরি মোবাইল:</strong> <span class="font-mono">{{ $trainee->emergency_phone ?? 'দেওয়া হয়নি' }}</span></li>
                            <li><strong class="text-gray-800 dark:text-gray-200">ঠিকানা:</strong> {{ $trainee->address ?? 'ঠিকানা সংরক্ষিত নেই' }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Main Info Tabs & Histories -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Training & Batch Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-4 flex items-center gap-2">
                            <span>🏅</span> প্রশিক্ষণ ও ব্যাচের বিবরণ
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <span class="text-gray-400 block mb-1">বর্তমান ব্যাচ</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{ $trainee->batch->name ?? 'ব্যাচ বরাদ্দ নেই' }}</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <span class="text-gray-400 block mb-1">অনুশীলন সময়</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{ $trainee->batch->time_slot ?? 'N/A' }}</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <span class="text-gray-400 block mb-1">দায়িত্বপ্রাপ্ত কোচ</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{ $trainee->batch->coach->name ?? 'N/A' }}</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <span class="text-gray-400 block mb-1">মাসিক ফি</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400 text-sm">৳{{ number_format($trainee->monthly_fee) }}</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <span class="text-gray-400 block mb-1">জন্ম তারিখ</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{ $trainee->date_of_birth ?? '-' }}</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <span class="text-gray-400 block mb-1">বর্তমান স্ট্যাটাস</span>
                                <span class="font-bold text-sm {{ $trainee->status == 'active' ? 'text-emerald-600' : 'text-gray-500' }}">
                                    {{ $trainee->status == 'active' ? 'সক্রিয় (Active)' : 'নিষ্ক্রিয়' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Enrolled Multi-Sports Disciplines -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-emerald-500/20">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                                    <span>🏅</span> তালিকাভুক্ত খেলা ও স্পোর্টস ডিসিপ্লিন (Multi-Sports)
                                </h4>
                                <p class="text-xs text-gray-400">এই খেলোয়াড় একই সাথে যে যে খেলায় প্রশিক্ষণ ও অংশ নিচ্ছেন</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                মোট {{ $trainee->sports->count() }}টি খেলা
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @forelse($trainee->sports as $sp)
                                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 space-y-2">
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
                                            <div>জার্সি: <strong class="text-amber-600">#{{ $sp->pivot->jersey_no ?? $trainee->jersey_no }}</strong></div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-3 text-xs text-gray-400 text-center py-4">
                                    {{ $trainee->sport->name ?? 'সাধারণ স্পোর্টস' }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Performance & Fitness Analytics Preview -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                                    <span>🏃</span> শারীরিক সক্ষমতা ও ফিটনেস অ্যাসেসমেন্ট
                                </h4>
                                <p class="text-xs text-gray-400 mt-0.5">বিএমআই, স্প্রিন্ট স্পিড, ইয়ো-ইয়ো স্কোর ও কোচের রেটিং</p>
                            </div>
                            <a href="{{ route('performances.create', ['trainee_id' => $trainee->id]) }}" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 transition">
                                + নতুন অ্যাসেসমেন্ট
                            </a>
                        </div>

                        @if($trainee->fitnessRecords->isNotEmpty())
                            @php $latestFitness = $trainee->fitnessRecords->first(); @endphp
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                                <div class="p-3 bg-indigo-50/50 dark:bg-indigo-950/30 rounded-xl border border-indigo-100 dark:border-indigo-900/40 text-center">
                                    <span class="text-[11px] text-gray-500 dark:text-gray-400 block">BMI (বডি ম্যাস)</span>
                                    <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">{{ $latestFitness->bmi ?? 'N/A' }}</span>
                                </div>
                                <div class="p-3 bg-emerald-50/50 dark:bg-emerald-950/30 rounded-xl border border-emerald-100 dark:border-emerald-900/40 text-center">
                                    <span class="text-[11px] text-gray-500 dark:text-gray-400 block">১০০মি. স্প্রিন্ট</span>
                                    <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">{{ $latestFitness->sprint_100m_sec ? $latestFitness->sprint_100m_sec . 's' : 'N/A' }}</span>
                                </div>
                                <div class="p-3 bg-amber-50/50 dark:bg-amber-950/30 rounded-xl border border-amber-100 dark:border-amber-900/40 text-center">
                                    <span class="text-[11px] text-gray-500 dark:text-gray-400 block">Yo-Yo লেভেল</span>
                                    <span class="text-lg font-black text-amber-600 dark:text-amber-400">{{ $latestFitness->yoyo_score ?? 'N/A' }}</span>
                                </div>
                                <div class="p-3 bg-rose-50/50 dark:bg-rose-950/30 rounded-xl border border-rose-100 dark:border-rose-900/40 text-center">
                                    <span class="text-[11px] text-gray-500 dark:text-gray-400 block">কোচ রেটিং</span>
                                    <span class="text-lg font-black text-rose-600 dark:text-rose-400">{{ $latestFitness->coach_rating ?? 5 }} ★</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('performances.show', $trainee->id) }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                                    সম্পূর্ণ ফিটনেস রিপোর্ট ও অগ্রগতির ইতিহাস দেখুন &rarr;
                                </a>
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-gray-400">এই প্লেয়ারের কোনো ফিটনেস টেস্ট রেকর্ড এখনও যুক্ত করা হয়নি।</p>
                                <a href="{{ route('performances.create', ['trainee_id' => $trainee->id]) }}" class="inline-block mt-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                                    প্রথম ফিটনেস টেস্ট যুক্ত করুন &rarr;
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Official Certificates Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                                    <span>📜</span> অর্জিত অফিসিয়াল সনদপত্র (Certificates)
                                </h4>
                                <p class="text-xs text-gray-400">এই প্লেয়ারের নামে ইস্যুকৃত কিউআর কোড সম্বলিত সকল ডিজিটাল সার্টিফিকেট</p>
                            </div>
                            <a href="{{ route('admin.certificates.create', ['trainee_id' => $trainee->id]) }}" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                + নতুন সনদ ইস্যু
                            </a>
                        </div>

                        @if($trainee->certificates && $trainee->certificates->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($trainee->certificates as $cert)
                                    <div class="p-4 rounded-xl border border-amber-200/60 bg-gradient-to-br from-amber-50/40 to-white dark:from-amber-950/20 dark:to-gray-800 flex items-start justify-between gap-3">
                                        <div class="space-y-1">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                                {{ $cert->type_name }}
                                            </span>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-sm">{{ $cert->title }}</h5>
                                            <div class="text-[10px] font-mono text-gray-500">{{ $cert->certificate_no }} • {{ $cert->issue_date->format('d M, Y') }}</div>
                                            @if($cert->grade_or_rank)
                                                <div class="text-xs font-bold text-amber-700 dark:text-amber-400">অর্জন: {{ $cert->grade_or_rank }}</div>
                                            @endif
                                        </div>
                                        <a href="{{ route('admin.certificates.show', $cert) }}" class="px-2.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold shrink-0 transition shadow-sm">
                                            🖨️ দেখুন
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-gray-400">এই প্লেয়ারের এখনও কোনো সনদপত্র ইস্যু করা হয়নি।</p>
                                <a href="{{ route('admin.certificates.create', ['trainee_id' => $trainee->id]) }}" class="inline-block mt-2 text-xs font-bold text-amber-600 dark:text-amber-400 hover:underline">
                                    প্রথম সনদপত্র ইস্যু করুন &rarr;
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Payment History -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg flex items-center gap-2">
                                <span>💰</span> ফি ও পেমেন্ট হিস্ট্রি
                            </h4>
                            <a href="{{ route('payments.create', ['trainee_id' => $trainee->id]) }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">+ নতুন ফি গ্রহণ</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                                <thead class="text-[11px] uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500">
                                    <tr>
                                        <th class="px-4 py-2.5">রসিদ নং</th>
                                        <th class="px-4 py-2.5">বিবরণ</th>
                                        <th class="px-4 py-2.5">মাস ও বছর</th>
                                        <th class="px-4 py-2.5">পরিমাণ</th>
                                        <th class="px-4 py-2.5">পদ্ধতি</th>
                                        <th class="px-4 py-2.5">স্ট্যাটাস</th>
                                        <th class="px-4 py-2.5 text-right">রসিদ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($trainee->payments as $pay)
                                        <tr>
                                            <td class="px-4 py-3 font-mono font-bold">{{ $pay->invoice_no }}</td>
                                            <td class="px-4 py-3">{{ $pay->title }}</td>
                                            <td class="px-4 py-3">{{ $pay->month ?? '-' }} {{ $pay->year }}</td>
                                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">৳{{ number_format($pay->amount) }}</td>
                                            <td class="px-4 py-3 uppercase text-xs">{{ $pay->payment_method }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $pay->status == 'paid' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300' }}">
                                                    {{ $pay->status == 'paid' ? 'পরিশোধিত' : 'বকেয়া' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('payments.show', $pay) }}" class="text-emerald-600 dark:text-emerald-400 font-semibold hover:underline">রসিদ প্রিন্ট &rarr;</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-gray-400">কোনো পেমেন্ট রেকর্ড পাওয়া যায়নি।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Attendance Log -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-4 flex items-center gap-2">
                            <span>📅</span> সাম্প্রতিক ১০ দিনের হাজিরা রেকর্ড
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                            @forelse($trainee->attendances as $att)
                                <div class="p-3 rounded-xl border text-center {{ $att->status == 'present' ? 'border-emerald-200 bg-emerald-50/50 dark:bg-emerald-950/30' : ($att->status == 'late' ? 'border-amber-200 bg-amber-50/50 dark:bg-amber-950/30' : 'border-rose-200 bg-rose-50/50 dark:bg-rose-950/30') }}">
                                    <div class="text-[11px] text-gray-500 dark:text-gray-400">{{ $att->date }}</div>
                                    <div class="text-xs font-bold mt-1 {{ $att->status == 'present' ? 'text-emerald-600' : ($att->status == 'late' ? 'text-amber-600' : 'text-rose-600') }}">
                                        {{ $att->status == 'present' ? 'উপস্থিত' : ($att->status == 'late' ? 'দেরি' : 'অনুপস্থিত') }}
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-5 text-center text-xs text-gray-400 py-3">হাজিরা রেকর্ড নেই।</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>📑</span> {{ __('প্লেয়ার বাৎসরিক মূল্যায়ন ও একাডেমিক রিপোর্ট কার্ড') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $trainee->name }} ({{ $trainee->admission_no }}) এর ফিটনেস, উপস্থিতি ও কোচ মূল্যায়ন
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow flex items-center gap-1.5 transition">
                    <span>🖨️ প্রিন্ট করুন (A4 Report)</span>
                </button>
                <a href="{{ route('trainees.show', $trainee) }}" class="px-3.5 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold transition">
                    &larr; প্রোফাইলে ফিরুন
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            body * { visibility: hidden; }
            #printable-report, #printable-report * { visibility: visible; }
            #printable-report {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                background: white !important;
                color: #0f172a !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print { display: none !important; }
            @page {
                size: A4 portrait;
                margin: 12mm 15mm;
            }
        }
    </style>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Report Card Container -->
            <div id="printable-report" class="bg-white text-slate-800 rounded-3xl shadow-xl border border-gray-200 overflow-hidden print:border-none print:shadow-none">
                
                <!-- Header Banner with Academy Seal -->
                <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 text-white p-8 relative overflow-hidden border-b-4 border-emerald-500">
                    <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-8 -translate-y-8">
                        <span class="text-[160px]">🏆</span>
                    </div>

                    <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6 text-center sm:text-left">
                        <div class="flex items-center gap-5">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-4xl shadow-lg border-2 border-white/20">
                                ⚽
                            </div>
                            <div>
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-500/30">
                                    Official Academic Progress Report
                                </span>
                                <h1 class="text-2xl sm:text-3xl font-black tracking-tight mt-1 text-white">জামিরবাড়িয়া স্পোর্টস একাডেমি</h1>
                                <p class="text-xs text-gray-300 mt-0.5">গোপালপুর, জামিরবাড়িয়া, ময়মনসিংহ • স্থাপিত: ২০২০</p>
                                <p class="text-[11px] text-emerald-300 font-mono mt-1">রেজিস্ট্রেশন নং: JSA/{{ date('Y') }}/RC-{{ $trainee->id }}</p>
                            </div>
                        </div>

                        <div class="text-center sm:text-right bg-white/5 backdrop-blur px-4 py-3 rounded-2xl border border-white/10">
                            <span class="text-[10px] text-gray-400 uppercase font-black tracking-wider block">মূল্যায়ন শিক্ষাবর্ষ</span>
                            <span class="text-xl font-black text-emerald-400">{{ date('Y') }}</span>
                            <span class="text-[10px] text-gray-400 block mt-0.5">তারিখ: {{ date('d M, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Trainee Info Section -->
                <div class="p-8 border-b border-gray-200 bg-slate-50/60">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <!-- Photo -->
                        <div class="w-32 h-36 rounded-2xl overflow-hidden border-4 border-white shadow-md bg-gray-200 flex-shrink-0 flex items-center justify-center">
                            @if($trainee->photo)
                                <img src="{{ asset('storage/' . $trainee->photo) }}" alt="{{ $trainee->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-gray-400 text-5xl font-black">{{ mb_substr($trainee->name, 0, 1) }}</div>
                            @endif
                        </div>

                        <!-- Details Grid -->
                        <div class="flex-grow grid grid-cols-2 sm:grid-cols-3 gap-y-3 gap-x-6 text-xs">
                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">শিক্ষার্থীর নাম</span>
                                <span class="text-sm font-black text-gray-900">{{ $trainee->name }}</span>
                            </div>

                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">ভর্তি নম্বর (ID)</span>
                                <span class="text-sm font-mono font-black text-emerald-600">{{ $trainee->admission_no }}</span>
                            </div>

                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">প্রধান খেলা (Sport)</span>
                                <span class="text-sm font-bold text-gray-800">{{ $trainee->sport->name ?? 'অজানা' }}</span>
                            </div>

                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">ব্যাচ ও শিফট</span>
                                <span class="font-bold text-gray-800">{{ $trainee->batch->name ?? 'সাধারণ' }}</span>
                            </div>

                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">ক্যাটাগরি / বয়স শ্রেণি</span>
                                <span class="font-bold text-gray-800">{{ $trainee->category ?? 'Senior' }}</span>
                            </div>

                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">খেলার পজিশন / জার্সি</span>
                                <span class="font-bold text-gray-800">{{ $trainee->position ?? '-' }} ({{ $trainee->jersey_no ? '#'.$trainee->jersey_no : 'N/A' }})</span>
                            </div>

                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">অভিভাবকের নাম</span>
                                <span class="font-semibold text-gray-700">{{ $trainee->guardian_name ?? '-' }}</span>
                            </div>

                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">যোগাযোগ নম্বর</span>
                                <span class="font-semibold text-gray-700">{{ $trainee->phone }}</span>
                            </div>

                            <div>
                                <span class="text-gray-500 font-semibold uppercase text-[10px] block">ভর্তির তারিখ</span>
                                <span class="font-semibold text-gray-700">{{ $trainee->admission_date ? \Carbon\Carbon::parse($trainee->admission_date)->format('d M, Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3 Performance Pillars -->
                <div class="p-8 space-y-8">

                    <!-- 1. Attendance & Discipline -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider flex items-center gap-2">
                                <span>📅</span> ১. একাডেমি ক্লাসে উপস্থিতি ও নিয়মানুবর্তিতা (Attendance)
                            </h3>
                            <span class="text-xs font-black px-2.5 py-0.5 rounded-full {{ $attendanceRate >= 80 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $attendanceRate }}% উপস্থিতি
                            </span>
                        </div>

                        <div class="grid grid-cols-4 gap-3 text-center text-xs">
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <span class="text-[10px] text-gray-500 font-semibold uppercase block">মোট সেশন</span>
                                <span class="text-lg font-black text-gray-800">{{ $totalAttendances }}</span>
                            </div>
                            <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                <span class="text-[10px] text-emerald-600 font-semibold uppercase block">উপস্থিত (Present)</span>
                                <span class="text-lg font-black text-emerald-700">{{ $presentCount }}</span>
                            </div>
                            <div class="p-3 bg-amber-50 rounded-xl border border-amber-100">
                                <span class="text-[10px] text-amber-600 font-semibold uppercase block">বিলম্বে (Late)</span>
                                <span class="text-lg font-black text-amber-700">{{ $lateCount }}</span>
                            </div>
                            <div class="p-3 bg-rose-50 rounded-xl border border-rose-100">
                                <span class="text-[10px] text-rose-600 font-semibold uppercase block">অনুপস্থিত (Absent)</span>
                                <span class="text-lg font-black text-rose-700">{{ $absentCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Physical & Fitness Metrics -->
                    <div>
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider flex items-center gap-2 mb-3">
                            <span>⚡</span> ২. শারীরিক গঠন ও ফিটনেস টেস্ট রিপোর্ট (Physical Assessment)
                        </h3>

                        @if($latestFitness)
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    <span class="text-[10px] text-gray-500 font-semibold uppercase block">উচ্চতা / ওজন</span>
                                    <span class="font-black text-gray-800">{{ $latestFitness->height_cm ?? '-' }} সেমি • {{ $latestFitness->weight_kg ?? '-' }} কেজি</span>
                                    <span class="text-[10px] text-gray-400 block mt-0.5">BMI: {{ $latestFitness->bmi ?? '-' }}</span>
                                </div>

                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    <span class="text-[10px] text-gray-500 font-semibold uppercase block">১০০ মি. স্প্রিন্ট গতি</span>
                                    <span class="font-black text-gray-800">{{ $latestFitness->sprint_100m_sec ? $latestFitness->sprint_100m_sec . ' সেকেন্ড' : '-' }}</span>
                                    <span class="text-[10px] text-gray-400 block mt-0.5">অ্যাথলেটিক স্পিড</span>
                                </div>

                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    <span class="text-[10px] text-gray-500 font-semibold uppercase block">ইয়ো-ইয়ো টেস্ট স্কোর</span>
                                    <span class="font-black text-emerald-600">{{ $latestFitness->yoyo_score ?? '-' }}</span>
                                    <span class="text-[10px] text-gray-400 block mt-0.5">সহনশীলতা লেভেল</span>
                                </div>

                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    <span class="text-[10px] text-gray-500 font-semibold uppercase block">স্ট্যামিনা রেটিং</span>
                                    <span class="font-black text-teal-700">{{ $latestFitness->stamina_level ?? 'উত্তম' }}</span>
                                    <span class="text-[10px] text-gray-400 block mt-0.5">কার্ডিও ফিটনেস</span>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 text-xs text-gray-500 text-center">
                                এই শিক্ষার্থীর এখনো কোনো আনুষ্ঠানিক ফিটনেস টেস্ট রেকর্ড এন্ট্রি করা হয়নি। কোচের সাথে যোগাযোগ করুন।
                            </div>
                        @endif
                    </div>

                    <!-- 3. Coach Evaluation & Match Stats -->
                    <div>
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider flex items-center gap-2 mb-3">
                            <span>🎯</span> ৩. মাঠের নৈপুণ্য ও কোচের সার্বিক পর্যবেক্ষণ (Coach Evaluation)
                        </h3>

                        <div class="p-5 bg-gradient-to-br from-emerald-50/50 to-teal-50/30 rounded-2xl border border-emerald-200/60 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase block">ম্যাচ অংশগ্রহণ</span>
                                    <span class="text-lg font-black text-gray-900">{{ $latestFitness->matches_played ?? '০' }} টি অফিশিয়াল ম্যাচ</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase block">রান / গোল / স্কোর</span>
                                    <span class="text-lg font-black text-emerald-700">{{ $latestFitness->goals_or_runs ?? '০' }} স্কোর</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase block">কোচ রেটিং স্কোর</span>
                                    <div class="text-lg font-black text-amber-600 flex items-center gap-1">
                                        <span>⭐</span> {{ $latestFitness->coach_rating ?? '৪.৫' }} / ৫.০
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-emerald-200/60">
                                <span class="text-[11px] font-bold text-gray-600 uppercase block mb-1">কোচের বিশেষ মন্তব্য ও পরামর্শ:</span>
                                <p class="text-xs text-gray-800 italic leading-relaxed bg-white/70 p-3 rounded-xl border border-emerald-100">
                                    "{{ $latestFitness->coach_remarks ?? 'খেলোয়াড় অত্যন্ত মনোযোগী ও অনুশীলনে পরিশ্রমী। টেকনিক্যাল স্কিল দিন দিন বৃদ্ধি পাচ্ছে। তবে নিয়মিত রানিং ও খাদ্যাভ্যাসে ধারাবাহিকতা বজায় রাখা প্রয়োজন।' }}"
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-gray-500 text-[10px] uppercase font-bold block">অনুশীলন টাস্ক সম্পন্ন</span>
                                    <span class="font-bold text-gray-800">{{ $tasksCompleted }} / {{ $tasksTotal }} টি ড্রিল সম্পন্ন</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 text-[10px] uppercase font-bold block">সার্টিফিকেট ও সম্মাননা</span>
                                    <span class="font-bold text-gray-800">{{ $trainee->certificates->count() }} টি সার্টিফিকেট অর্জিত</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Academy Official Signatures -->
                <div class="p-8 pt-12 border-t border-gray-200 bg-slate-50/50">
                    <div class="grid grid-cols-3 gap-6 text-center text-xs">
                        <div>
                            <div class="h-10"></div>
                            <div class="border-t-2 border-dashed border-gray-400 pt-2">
                                <p class="font-bold text-gray-900">প্রধান কোচ</p>
                                <p class="text-[10px] text-gray-500">জামিরবাড়িয়া স্পোর্টস একাডেমি</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-end">
                            <div class="w-16 h-16 rounded-full border-2 border-emerald-600 flex items-center justify-center text-[10px] font-black text-emerald-700 uppercase tracking-tighter text-center leading-tight">
                                JSA<br>SEAL
                            </div>
                            <p class="text-[9px] text-gray-400 mt-1">অফিসিয়াল সিলমোহর</p>
                        </div>

                        <div>
                            <div class="h-10"></div>
                            <div class="border-t-2 border-dashed border-gray-400 pt-2">
                                <p class="font-bold text-gray-900">একাডেমি পরিচালক</p>
                                <p class="text-[10px] text-gray-500">জামিরবাড়িয়া স্পোর্টস একাডেমি</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>


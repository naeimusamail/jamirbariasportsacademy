<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>📊</span> {{ $trainee->name }} — {{ __('প্লেয়ার পারফরম্যান্স ও ফিটনেস রিপোর্ট কার্ড') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    আইডি: <span class="font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $trainee->admission_no }}</span> | 
                    খেলা: {{ $trainee->sport->name ?? 'N/A' }} | ব্যাচ: {{ $trainee->batch->name ?? 'ব্যাচহীন' }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow transition flex items-center gap-1.5">
                    <span>🖨️ রিপোর্ট প্রিন্ট</span>
                </button>
                <a href="{{ route('performances.create', ['trainee_id' => $trainee->id]) }}" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow transition">
                    + নতুন টেস্ট যুক্ত করুন
                </a>
                <a href="{{ route('performances.index') }}" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold">
                    ← তালিকা
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
                color: black !important;
            }
            .no-print { display: none !important; }
        }
    </style>

    <div class="py-8">
        <div id="printable-report" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="no-print p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Player Profile & Academy Banner Card -->
            <div class="bg-gradient-to-r from-indigo-900 via-slate-900 to-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-indigo-500/30">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="w-24 h-28 rounded-2xl bg-slate-800 border-2 border-indigo-400 overflow-hidden shadow-lg shrink-0 flex items-center justify-center">
                            @if($trainee->photo)
                                <img src="{{ asset('storage/' . $trainee->photo) }}" alt="{{ $trainee->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl text-indigo-300 font-black">{{ mb_substr($trainee->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-2xl font-black text-white">{{ $trainee->name }}</h1>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-mono font-bold bg-white/20">{{ $trainee->category }}</span>
                            </div>
                            <p class="text-xs text-indigo-300 mt-1">
                                পজিশন: <strong class="text-white">{{ $trainee->position ?? 'প্লেয়ার' }}</strong> | 
                                জার্সি: <strong class="text-white">#{{ $trainee->jersey_no ?? 'N/A' }}</strong> | 
                                ব্লাড গ্রুপ: <strong class="text-rose-400">{{ $trainee->blood_group ?? 'N/A' }}</strong>
                            </p>
                            <p class="text-[11px] text-gray-400 mt-1">
                                তত্ত্বাবধায়ক কোচ: {{ $trainee->batch->coach->name ?? 'প্রধান কোচ' }} | 
                                ব্যাচ: {{ $trainee->batch->name ?? 'সাধারণ ব্যাচ' }}
                            </p>
                        </div>
                    </div>

                    <div class="text-center sm:text-right border-t sm:border-t-0 sm:border-l border-indigo-500/30 pt-4 sm:pt-0 sm:pl-6">
                        <span class="text-xs text-indigo-300 block">সার্বিক কোচ মূল্যায়ন</span>
                        <div class="text-3xl font-black text-amber-400 mt-0.5">
                            {{ $averageRating }} / 5.0 ★
                        </div>
                        <span class="text-[11px] text-gray-400">মোট টেস্ট সম্পন্ন: {{ $totalTests }} টি</span>
                    </div>
                </div>
            </div>

            <!-- Athletic Metric Summary Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                    <span class="text-xs text-gray-400 uppercase font-semibold block">সর্বশেষ BMI সূচক</span>
                    <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">
                        {{ $latestRecord->bmi ?? 'N/A' }}
                    </div>
                    <span class="text-[11px] font-semibold {{ ($latestRecord->bmi ?? 0) >= 18.5 && ($latestRecord->bmi ?? 0) <= 24.9 ? 'text-emerald-500' : 'text-amber-500' }}">
                        @if($latestRecord && $latestRecord->bmi)
                            {{ $latestRecord->bmi < 18.5 ? 'কম ওজন' : ($latestRecord->bmi <= 24.9 ? 'আদর্শ ওজন' : 'অতিরিক্ত ওজন') }}
                        @else
                            রেকর্ড নেই
                        @endif
                    </span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                    <span class="text-xs text-gray-400 uppercase font-semibold block">সেরা ১০০মি স্প্রিন্ট</span>
                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">
                        {{ $bestSprint ? $bestSprint . 's' : 'N/A' }}
                    </div>
                    <span class="text-[11px] text-gray-400">সর্বোচ্চ গতি</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                    <span class="text-xs text-gray-400 uppercase font-semibold block">মোট গোল / রান</span>
                    <div class="text-2xl font-black text-amber-500 mt-1">
                        {{ $totalGoalsOrRuns }}
                    </div>
                    <span class="text-[11px] text-gray-400">ম্যাচ কন্ট্রিবিউশন</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                    <span class="text-xs text-gray-400 uppercase font-semibold block">উইকেট / অ্যাসিস্ট</span>
                    <div class="text-2xl font-black text-rose-500 mt-1">
                        {{ $totalWicketsOrAssists }}
                    </div>
                    <span class="text-[11px] text-gray-400">সহায়ক অবদান</span>
                </div>
            </div>

            <!-- Historical Progression Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                        <span>📈</span> ফিটনেস টেস্টের ধারাবাহিক অগ্রগতি ইতিহাস
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/60 border-b border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">
                                <th class="p-4">টেস্টের তারিখ</th>
                                <th class="p-4">উচ্চতা ও ওজন</th>
                                <th class="p-4">BMI</th>
                                <th class="p-4">১০০মি. স্প্রিন্ট</th>
                                <th class="p-4">Yo-Yo টেস্ট</th>
                                <th class="p-4">স্ট্যামিনা</th>
                                <th class="p-4">ম্যাচ স্ট্যাটাস</th>
                                <th class="p-4">কোচ রেটিং ও মন্তব্য</th>
                                <th class="p-4 text-right no-print">মুছুন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($records as $rec)
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition">
                                    <td class="p-4 font-semibold text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($rec->test_date)->format('d M, Y') }}
                                    </td>

                                    <td class="p-4 text-gray-700 dark:text-gray-300">
                                        {{ $rec->height_cm ? $rec->height_cm . ' cm' : '-' }} / 
                                        {{ $rec->weight_kg ? $rec->weight_kg . ' kg' : '-' }}
                                    </td>

                                    <td class="p-4 font-mono font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ $rec->bmi ?? '-' }}
                                    </td>

                                    <td class="p-4 font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ $rec->sprint_100m_sec ? $rec->sprint_100m_sec . 's' : '-' }}
                                    </td>

                                    <td class="p-4 font-mono font-bold text-amber-600 dark:text-amber-400">
                                        {{ $rec->yoyo_score ?? '-' }}
                                    </td>

                                    <td class="p-4">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                            {{ $rec->stamina_level === 'Excellent' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : ($rec->stamina_level === 'Good' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : ($rec->stamina_level === 'Average' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300')) }}">
                                            {{ $rec->stamina_level }}
                                        </span>
                                    </td>

                                    <td class="p-4 text-gray-700 dark:text-gray-300">
                                        ম্যাচ: {{ $rec->matches_played }} | 
                                        স্কোর: {{ $rec->goals_or_runs }} | 
                                        অ্যাসিস্ট: {{ $rec->wickets_or_assists }}
                                    </td>

                                    <td class="p-4">
                                        <div class="text-amber-400 font-bold">
                                            @for($i=1; $i<=5; $i++)
                                                <span>{{ $i <= $rec->coach_rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                        @if($rec->coach_remarks)
                                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 max-w-xs">{{ $rec->coach_remarks }}</p>
                                        @endif
                                    </td>

                                    <td class="p-4 text-right no-print">
                                        <form action="{{ route('performances.destroy', $rec) }}" method="POST" onsubmit="return confirm('এই টেস্ট রেকর্ডটি মুছে ফেলতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-semibold">
                                                মুছুন
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="p-8 text-center text-gray-400">
                                        কোনো টেস্ট রেকর্ড যুক্ত করা হয়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer for Printable Report -->
            <div class="p-6 bg-gray-50 dark:bg-gray-900/40 rounded-2xl border border-gray-100 dark:border-gray-700 flex justify-between items-center text-xs text-gray-500">
                <div>
                    জামিরবাড়িয়া স্পোর্টস একাডেমি • অফিসিয়াল পারফরম্যান্স রিপোর্ট
                </div>
                <div class="text-right">
                    তারিখ: {{ date('d M, Y') }} | অনুমোদিত কোচ সিল ও স্বাক্ষর
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


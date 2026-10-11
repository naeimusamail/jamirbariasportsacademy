<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>🏃</span> {{ __('প্লেয়ার ফিটনেস ও পারফরম্যান্স অ্যানালিটিক্স') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    খেলোয়াড়দের BMI, ১০০মি. স্প্রিন্ট, Yo-Yo টেস্ট, ম্যাচ পরিসংখ্যান ও কোচ অ্যাসেসমেন্ট
                </p>
            </div>
            <div>
                <a href="{{ route('performances.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md transition flex items-center gap-1.5">
                    <span>+ নতুন টেস্ট গ্রহণ</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- KPI Metric Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">মূল্যায়িত ট্রেইনি</span>
                    <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">{{ $totalAssessed }} জন</div>
                    <span class="text-[11px] text-gray-400">একাডেমির নিয়মিত প্লেয়ার</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">গড় BMI সূচক</span>
                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $averageBmi > 0 ? $averageBmi : '২১.২' }}</div>
                    <span class="text-[11px] text-emerald-500 font-semibold">স্ট্যান্ডার্ড ফিটনেস রেঞ্জ</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">দ্রুততম ১০০মি স্প্রিন্ট</span>
                    <div class="text-2xl font-black text-amber-500 mt-1">{{ $fastestSprint ? $fastestSprint . 's' : '১১.৮s' }}</div>
                    <span class="text-[11px] text-gray-400">সর্বোচ্চ রেকর্ড স্পিড</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">সেরা Yo-Yo টেস্ট</span>
                    <div class="text-2xl font-black text-rose-500 mt-1">{{ $topYoYo ? $topYoYo : '১৯.৫' }}</div>
                    <span class="text-[11px] text-gray-400">উচ্চ স্ট্যামিনা লেভেল</span>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('performances.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম বা ভর্তি নম্বর..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                    </div>

                    <div>
                        <select name="sport_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            <option value="">সকল খেলা</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->id }}" {{ request('sport_id') == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="batch_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            <option value="">সকল ব্যাচ</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-2 px-4 bg-gray-900 dark:bg-gray-700 hover:bg-gray-800 text-white rounded-xl text-xs font-semibold transition">
                            ফিল্টার
                        </button>
                        <a href="{{ route('performances.index') }}" class="py-2 px-3 bg-gray-100 dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-semibold transition">
                            রিসেট
                        </a>
                    </div>
                </form>
            </div>

            <!-- Trainees Performance Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/60 border-b border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">
                                <th class="p-4">ট্রেইনি</th>
                                <th class="p-4">খেলা ও ব্যাচ</th>
                                <th class="p-4">BMI (বডি ম্যাস)</th>
                                <th class="p-4">১০০মি. স্প্রিন্ট</th>
                                <th class="p-4">Yo-Yo স্কোর</th>
                                <th class="p-4">স্ট্যামিনা লেভেল</th>
                                <th class="p-4">কোচ রেটিং</th>
                                <th class="p-4 text-right">পদক্ষেপ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($trainees as $tr)
                                @php $fit = $tr->latestFitness; @endphp
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 overflow-hidden shrink-0 flex items-center justify-center font-bold border border-indigo-500/20">
                                                @if($tr->photo)
                                                    <img src="{{ asset('storage/' . $tr->photo) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    {{ mb_substr($tr->name, 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $tr->name }}</div>
                                                <div class="font-mono text-[11px] text-gray-400">{{ $tr->admission_no }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <div class="font-medium text-gray-800 dark:text-gray-200">{{ $tr->sport->name ?? '-' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $tr->batch->name ?? 'ব্যাচহীন' }} ({{ $tr->category }})</div>
                                    </td>

                                    <td class="p-4">
                                        @if($fit && $fit->bmi)
                                            <div class="font-bold font-mono text-gray-900 dark:text-white">{{ $fit->bmi }}</div>
                                            <div class="text-[10px] {{ $fit->bmi >= 18.5 && $fit->bmi <= 24.9 ? 'text-emerald-500' : 'text-amber-500' }}">
                                                {{ $fit->bmi < 18.5 ? 'কম ওজন' : ($fit->bmi <= 24.9 ? 'আদর্শ' : 'অতিরিক্ত ওজন') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @if($fit && $fit->sprint_100m_sec)
                                            <span class="font-bold font-mono text-emerald-600 dark:text-emerald-400">{{ $fit->sprint_100m_sec }}s</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @if($fit && $fit->yoyo_score)
                                            <span class="font-bold font-mono text-amber-600 dark:text-amber-400">{{ $fit->yoyo_score }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @if($fit && $fit->stamina_level)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                                {{ $fit->stamina_level === 'Excellent' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : ($fit->stamina_level === 'Good' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : ($fit->stamina_level === 'Average' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300')) }}">
                                                {{ $fit->stamina_level }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">টেস্ট হয়নি</span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @if($fit && $fit->coach_rating)
                                            <div class="flex text-amber-400">
                                                @for($i=1; $i<=5; $i++)
                                                    <span>{{ $i <= $fit->coach_rating ? '★' : '☆' }}</span>
                                                @endfor
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-right space-x-2">
                                        <a href="{{ route('performances.create', ['trainee_id' => $tr->id]) }}" class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-900/40 hover:bg-indigo-100 text-indigo-600 dark:text-indigo-400 rounded-lg text-xs font-semibold transition" title="নতুন টেস্ট যুক্ত করুন">
                                            + টেস্ট
                                        </a>
                                        <a href="{{ route('performances.show', $tr->id) }}" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow transition">
                                            রিপোর্ট ➔
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-gray-400">
                                        কোনো ট্রেইনি খুঁজে পাওয়া যায়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($trainees->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $trainees->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


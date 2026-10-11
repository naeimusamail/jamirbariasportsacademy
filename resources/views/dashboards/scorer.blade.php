<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-400 font-bold text-xs border border-rose-500/20 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        অফিশিয়াল ম্যাচ স্কোরার প্যানেল
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">রোল: <strong class="text-emerald-600">ম্যাচ স্কোরার (Official Scorer)</strong></span>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 mt-1 flex items-center gap-2">
                    স্বাগতম, {{ $user->name }}! 🎯
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    জামিরবাড়িয়া স্পোর্টস একাডেমি • অন-ফিল্ড লাইভ স্কোর ও কমেন্ট্রি সম্প্রচার হাব
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('matches.index') }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>🔴 সকল ম্যাচ ও স্কোরিং</span>
                </a>
                <a href="{{ route('public.tournaments.index') }}" target="_blank" class="px-3.5 py-2 bg-amber-500/10 hover:bg-amber-500 hover:text-slate-950 text-amber-600 dark:text-amber-400 rounded-xl text-xs font-bold transition">
                    <span>🏆 টুর্নামেন্ট হাব ↗</span>
                </a>
                <a href="{{ route('live.index') }}" target="_blank" class="px-3.5 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-800 dark:text-gray-200 rounded-xl text-xs font-semibold transition">
                    <span>পাবলিক লাইভ ভিউ ↗</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-bold flex items-center gap-2">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="p-4 bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 rounded-xl text-sm font-bold flex items-center gap-2">
                    <span>⚠️</span> {{ session('warning') }}
                </div>
            @endif

            <!-- Scorer Quick Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-rose-500/20 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-2 -bottom-2 text-rose-500/10 text-6xl font-black select-none pointer-events-none">🎯</div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">আমার নির্ধারিত ম্যাচ</span>
                        <span class="text-lg">📋</span>
                    </div>
                    <div class="text-3xl font-black text-rose-600 dark:text-rose-400 mt-2">
                        {{ $totalAssigned }} টি
                    </div>
                    <span class="text-[11px] text-gray-400 mt-1 block">আপনার দায়িত্বপ্রাপ্ত ম্যাচ</span>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-emerald-500/20 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-2 -bottom-2 text-emerald-500/10 text-6xl font-black select-none pointer-events-none">🔴</div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">লাইভ চলমান</span>
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                    </div>
                    <div class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-2">
                        {{ $totalLive }} টি
                    </div>
                    <span class="text-[11px] text-gray-400 mt-1 block">মাঠে খেলা চলছে</span>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-blue-500/20 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-2 -bottom-2 text-blue-500/10 text-6xl font-black select-none pointer-events-none">⏳</div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">আসন্ন ম্যাচ</span>
                        <span class="text-lg">⏱️</span>
                    </div>
                    <div class="text-3xl font-black text-blue-600 dark:text-blue-400 mt-2">
                        {{ $totalUpcoming }} টি
                    </div>
                    <span class="text-[11px] text-gray-400 mt-1 block">শীঘ্রই মাঠে গড়াবে</span>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-purple-500/20 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-2 -bottom-2 text-purple-500/10 text-6xl font-black select-none pointer-events-none">🏁</div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">সম্পন্ন ম্যাচ</span>
                        <span class="text-lg">🏆</span>
                    </div>
                    <div class="text-3xl font-black text-purple-600 dark:text-purple-400 mt-2">
                        {{ $totalFinished }} টি
                    </div>
                    <span class="text-[11px] text-gray-400 mt-1 block">ফলাফল রেকর্ড সম্পন্ন</span>
                </div>
            </div>

            <!-- Quick PIN / Code Match Entry Bar -->
            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-rose-950 p-5 rounded-2xl border border-rose-500/30 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-2 text-rose-400 font-extrabold text-xs uppercase tracking-wider">
                        <span>⚡</span> কুইক স্কোরার অ্যাক্সেস
                    </div>
                    <h3 class="font-black text-lg">অন্য কোনো ম্যাচের স্কোরার পিন বা কোড আছে?</h3>
                    <p class="text-xs text-gray-300">এডমিন আপনাকে কোনো ম্যাচের বিশেষ কোড প্রদান করলে সরাসরি এখানে কোড দিয়ে স্কোরবোর্ডে প্রবেশ করুন।</p>
                </div>
                <form method="GET" action="{{ route('matches.index') }}" onsubmit="event.preventDefault(); const code = document.getElementById('quick_match_code').value.trim(); if(code) { window.location.href = '{{ url('/scorer/match') }}/' + code + '?code=' + code; }" class="flex w-full md:w-auto items-center gap-2">
                    <input type="text" id="quick_match_code" placeholder="ম্যাচ স্লাগ বা পিন কোড লিখুন..." required class="px-4 py-2.5 rounded-xl text-sm font-mono font-bold bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-rose-500 w-full md:w-64">
                    <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-sm font-bold whitespace-nowrap shadow-lg shadow-rose-600/30 transition">
                        প্রবেশ করুন &rarr;
                    </button>
                </form>
            </div>

            <!-- LIVE MATCHES RUNNING NOW -->
            @if($liveMatches->count() > 0)
                <div class="bg-rose-950/20 border-2 border-rose-500/40 rounded-3xl p-6 relative overflow-hidden backdrop-blur-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-rose-500 animate-ping"></span>
                            <h3 class="text-lg font-black text-white flex items-center gap-2">
                                🔴 মাঠে সরাসরি লাইভ চলমান ম্যাচ
                            </h3>
                        </div>
                        <span class="text-xs font-bold text-rose-400 bg-rose-500/20 px-3 py-1 rounded-full">
                            {{ $liveMatches->count() }}টি ম্যাচ চলমান
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($liveMatches as $match)
                            <div class="bg-slate-900/90 border border-rose-500/30 rounded-2xl p-5 hover:border-rose-400 transition shadow-lg space-y-4">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-rose-400 uppercase tracking-wide">
                                        @if($match->sport_type == 'cricket') 🏏 ক্রিকেট
                                        @elseif($match->sport_type == 'football') ⚽ ফুটবল
                                        @elseif($match->sport_type == 'badminton') 🏸 ব্যাডমিন্টন
                                        @else 🏃 অন্যান্য
                                        @endif
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[11px] font-black animate-pulse">
                                        ● LIVE NOW
                                    </span>
                                </div>

                                <div>
                                    <h4 class="font-extrabold text-base text-white">{{ $match->title }}</h4>
                                    <p class="text-xs text-gray-400">{{ $match->tournament_name }} • ভেন্যু: {{ $match->venue }}</p>
                                </div>

                                <!-- Current Scores -->
                                <div class="bg-slate-950/60 rounded-xl p-3 border border-slate-800 flex items-center justify-around text-center">
                                    <div class="flex-1">
                                        <div class="text-xs text-gray-400 font-semibold truncate">{{ $match->team_a }}</div>
                                        <div class="text-2xl font-black font-mono text-emerald-400">{{ $match->team_a_score }}</div>
                                    </div>
                                    <div class="text-xs font-black text-rose-500 px-2">VS</div>
                                    <div class="flex-1">
                                        <div class="text-xs text-gray-400 font-semibold truncate">{{ $match->team_b }}</div>
                                        <div class="text-2xl font-black font-mono text-cyan-400">{{ $match->team_b_score }}</div>
                                    </div>
                                </div>

                                @if($match->current_summary)
                                    <div class="text-xs text-amber-300 bg-amber-500/10 px-3 py-1.5 rounded-lg border border-amber-500/20">
                                        📢 {{ $match->current_summary }}
                                    </div>
                                @endif

                                <div class="pt-2 flex flex-wrap items-center justify-between gap-2 border-t border-slate-800">
                                    <div class="flex items-center gap-1.5 text-[11px] text-gray-400">
                                        <span>🔑 পিন:</span>
                                        <code class="px-2 py-0.5 rounded bg-slate-800 text-rose-300 font-bold font-mono">{{ $match->scorer_code }}</code>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('matches.scorer', $match->slug) }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-black shadow-md flex items-center gap-1.5 transition">
                                            <span>🔴 লাইভ স্কোর আপডেট করুন</span> &rarr;
                                        </a>
                                        <a href="{{ route('live.show', $match->slug) }}" target="_blank" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-gray-300 rounded-xl text-xs font-semibold transition">
                                            পাবলিক ভিউ ↗
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- ASSIGNED & ACTIVE MATCHES TABLE -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                            <span>📋</span> আমার দায়িত্বপ্রাপ্ত ও একাডেমির সকল ম্যাচ
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">যেকোনো ম্যাচের ডানদিকের বাটনে ক্লিক করে স্কোরবোর্ড চালু করে খেলা পরিচালনা করুন।</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 rounded-full w-fit">
                        মোট ম্যাচ: {{ $assignedMatches->count() }}টি
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-750 text-gray-500">
                            <tr>
                                <th class="px-5 py-3.5">ম্যাচের বিবরণ ও টুর্নামেন্ট</th>
                                <th class="px-5 py-3.5">খেলা</th>
                                <th class="px-5 py-3.5">দলসমূহ</th>
                                <th class="px-5 py-3.5">স্কোর</th>
                                <th class="px-5 py-3.5">অবস্থা</th>
                                <th class="px-5 py-3.5">স্কোরার পিন কোড</th>
                                <th class="px-5 py-3.5 text-right">স্কোরার অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($assignedMatches as $match)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-750/50 transition">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                                            {{ $match->title }}
                                        </div>
                                        <div class="text-xs text-rose-500 font-semibold">{{ $match->tournament_name }}</div>
                                        <div class="text-[11px] text-gray-400">
                                            মাঠ: {{ $match->venue }} • {{ $match->match_datetime ? \Carbon\Carbon::parse($match->match_datetime)->format('d M, h:i A') : 'তারিখ নির্ধারিত হয়নি' }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="uppercase text-xs font-extrabold px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $match->sport_type }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $match->team_a }} <br><span class="text-xs text-gray-400 font-normal">বনাম</span><br> {{ $match->team_b }}
                                    </td>
                                    <td class="px-5 py-4 font-mono font-black text-base text-gray-900 dark:text-white">
                                        {{ $match->team_a_score }} : {{ $match->team_b_score }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $match->status == 'live' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300 animate-pulse' : ($match->status == 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600') }}">
                                            {{ $match->status == 'live' ? '● LIVE' : ($match->status == 'upcoming' ? 'আসন্ন' : 'সমাপ্ত') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($match->status == 'finished')
                                            <span class="text-xs font-semibold text-rose-500/80 dark:text-rose-400/80 flex items-center gap-1">
                                                <span>🔒</span> পিন মেয়াদোত্তীর্ণ
                                            </span>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <code class="px-2 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 font-mono font-bold text-rose-600 dark:text-rose-400 text-xs border border-gray-200 dark:border-gray-700 select-all">
                                                    {{ $match->scorer_code }}
                                                </code>
                                                <button type="button" onclick="navigator.clipboard.writeText('{{ $match->scorer_code }}'); alert('স্কোরার পিন কপি হয়েছে: {{ $match->scorer_code }}')" title="কপি করুন" class="text-gray-400 hover:text-gray-600 text-xs">
                                                    📋
                                                </button>
                                            </div>
                                            <a href="{{ route('scorer.quick-access', ['slug' => $match->slug, 'code' => $match->scorer_code]) }}" target="_blank" class="text-[11px] text-blue-500 hover:underline block mt-0.5">
                                                সরাসরি অ্যাক্সেস লিংক ↗
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right space-x-2">
                                        @if($match->status == 'finished')
                                            @if(auth()->check() && auth()->user()->isAdmin())
                                                <a href="{{ route('matches.scorer', $match->slug) }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow inline-flex items-center gap-1 transition">
                                                    <span>এডমিন এডিট ⚙️</span>
                                                </a>
                                            @else
                                                <span class="px-3.5 py-2 bg-gray-100 dark:bg-gray-800 text-gray-400 text-xs font-semibold rounded-xl inline-block cursor-not-allowed">
                                                    🔒 ম্যাচ সমাপ্ত
                                                </span>
                                            @endif
                                        @else
                                            <a href="{{ route('matches.scorer', $match->slug) }}" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow inline-flex items-center gap-1 transition">
                                                <span>🔴 স্কোর পরিচালনা</span>
                                            </a>
                                        @endif
                                        <a href="{{ route('live.show', $match->slug) }}" target="_blank" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-xs font-semibold rounded-xl text-gray-700 dark:text-gray-300 inline-block transition">
                                            ভিউ ↗
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-gray-500">
                                        বর্তমানে কোনো ম্যাচ পাওয়া যায়নি। এডমিন কোনো ম্যাচ তৈরি করলে তা এখানে প্রদর্শিত হবে।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SCORER GUIDELINES & FEATURES -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-600 flex items-center justify-center text-xl font-bold">
                        ⚽
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-base">১-ক্লিক দ্রুত স্কোর আপডেট</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        ফুটবল খেলায় গোল (+১ / -১), ফাউল, হলুদ/লাল কার্ড এবং অতিরিক্ত সময় সরাসরি স্কোরার কনসোল থেকে এক ক্লিকে হালনাগাদ করা যায়। দর্শক তাৎক্ষণিক লাইভ দেখতে পাবে।
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/10 text-teal-600 flex items-center justify-center text-xl font-bold">
                        🏏
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-base">ক্রিকেট স্কোর ও ক্রিকইনফো কার্ড</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        রান (+১, চার, ছক্কা), উইকেট, ওভার ও স্ট্রাইক রেটসহ প্রতিটি প্লেয়ারের ব্যক্তিগত রান ও বোলিং ইকোনমি সরাসরি স্কোরকার্ডে এন্ট্রি দিতে পারবেন।
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-xl font-bold">
                        📺
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-base">লাইভ ভিডিও ও কমেন্ট্রি</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        ইউটিউব বা ফেসবুক লাইভ ভিডিও লিংক যুক্ত করতে পারবেন যা ওয়েবসাইটের লাইভ পোর্টালে অটো-প্লে হবে। সাথে প্রতি মিনিটে বল-বাই-বল কমেন্ট্রি পোস্ট করতে পারবেন।
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

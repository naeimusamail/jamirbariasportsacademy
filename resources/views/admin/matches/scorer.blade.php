<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ __('অফিশিয়াল লাইভ স্কোরার কনসোল') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $match->title }} ({{ $match->team_a }} বনাম {{ $match->team_b }})</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('live.show', $match->slug) }}" target="_blank" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>পাবলিক লাইভ ভিউ</span> ↗
                </a>
                <a href="{{ route('matches.index') }}" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold">
                    &larr; ম্যাচ তালিকায় ফিরুন
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Toast Feedback -->
            <div id="toast_msg" class="hidden p-3 rounded-xl bg-emerald-500/20 border border-emerald-500 text-emerald-700 dark:text-emerald-300 text-xs font-bold text-center"></div>

            @if(session('success'))
                <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500 text-emerald-700 dark:text-emerald-300 text-xs font-bold text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if($match->status == 'finished')
                <div class="p-4 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-xs font-semibold flex items-center gap-2 shadow-sm">
                    <span class="text-base">🔒</span>
                    <span>এই ম্যাচটি ইতিমধ্যে সমাপ্ত হয়েছে এবং স্কোরার পিনের মেয়াদ উত্তীর্ণ। বর্তমানে শুধুমাত্র এডমিন প্রিভিলেজ হিসেবে আপনি এই ম্যাচের স্কোর সম্পাদনা করতে পারছেন।</span>
                </div>
            @endif

            <!-- Match Status Bar -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">🛡️ জামিরবাড়িয়া একাডেমি অফিশিয়াল খেলা</span>
                        <span class="text-[11px] px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-600 font-bold border border-rose-500/20">
                            স্কোরার: {{ $match->scorer_name ?: ($match->scorer ? $match->scorer->name : 'অফিশিয়াল একাডেমি স্কোরার') }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $match->title }}</h3>
                    <p class="text-xs text-gray-400">{{ $match->tournament_name }} • ভেন্যু: {{ $match->venue }}</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-100 dark:bg-gray-700/60 text-xs">
                        <span class="text-gray-400">🔑 পিন:</span>
                        @if($match->status == 'finished')
                            <span class="text-rose-500 font-bold text-[11px]">মেয়াদোত্তীর্ণ (Expired)</span>
                        @else
                            <code class="font-mono font-bold text-rose-600 dark:text-rose-400 select-all">{{ $match->scorer_code }}</code>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ route('scorer.quick-access', ['slug' => $match->slug, 'code' => $match->scorer_code]) }}'); alert('স্কোরার মোবাইল লিংক কপি করা হয়েছে!')" title="মোবাইল লিংক কপি করুন" class="text-gray-400 hover:text-gray-600 text-[11px] font-bold">
                                📋
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-xs font-bold text-gray-500 uppercase">স্ট্যাটাস:</label>
                        <select id="match_status_select" onchange="submitScoreUpdate()" class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-xs font-bold text-gray-800 dark:text-gray-200">
                            <option value="upcoming" {{ $match->status == 'upcoming' ? 'selected' : '' }}>আসন্ন (Upcoming)</option>
                            <option value="live" {{ $match->status == 'live' ? 'selected' : '' }}>🔴 লাইভ চলমান (Live Now)</option>
                            <option value="finished" {{ $match->status == 'finished' ? 'selected' : '' }}>সমাপ্ত (Finished)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Scoreboard Control Panel -->
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">
                <h3 class="text-base font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                    <span>🎯</span> লাইভ স্কোরবোর্ড পরিবর্তন
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Team A -->
                    <div class="p-6 bg-gray-50 dark:bg-gray-750 border border-gray-200 dark:border-gray-700 rounded-2xl text-center space-y-4">
                        <h4 class="font-extrabold text-base text-rose-600 dark:text-rose-400">{{ $match->team_a }}</h4>
                        <input type="text" id="team_a_score_input" value="{{ $match->team_a_score }}" class="text-center text-4xl font-black font-mono tracking-wider w-full py-2 rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white">

                        @if($match->sport_type == 'football')
                            <div class="grid grid-cols-3 gap-2">
                                <button onclick="adjustFootballScore('a', 1)" class="py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow">
                                    +১ গোল ⚽
                                </button>
                                <button onclick="adjustFootballScore('a', -1)" class="py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold">
                                    -১ গোল
                                </button>
                                <button onclick="quickEvent('card', '🟨 ফাউল / কার্ড', '{{ $match->team_a }} এর খেলোয়াড়কে সতর্ক করা হলো')" class="py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold">
                                    🟨 কার্ড
                                </button>
                            </div>
                        @elseif($match->sport_type == 'cricket')
                            <div class="grid grid-cols-4 gap-2">
                                <button onclick="adjustCricketRun('a', 1)" class="py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-xl text-xs font-bold">+১</button>
                                <button onclick="adjustCricketRun('a', 4)" class="py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold">+৪ চার</button>
                                <button onclick="adjustCricketRun('a', 6)" class="py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold">+৬ ছক্কা</button>
                                <button onclick="adjustCricketWicket('a')" class="py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold">উইকেট ☝</button>
                            </div>
                        @endif
                    </div>

                    <!-- Team B -->
                    <div class="p-6 bg-gray-50 dark:bg-gray-750 border border-gray-200 dark:border-gray-700 rounded-2xl text-center space-y-4">
                        <h4 class="font-extrabold text-base text-cyan-600 dark:text-cyan-400">{{ $match->team_b }}</h4>
                        <input type="text" id="team_b_score_input" value="{{ $match->team_b_score }}" class="text-center text-4xl font-black font-mono tracking-wider w-full py-2 rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white">

                        @if($match->sport_type == 'football')
                            <div class="grid grid-cols-3 gap-2">
                                <button onclick="adjustFootballScore('b', 1)" class="py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow">
                                    +১ গোল ⚽
                                </button>
                                <button onclick="adjustFootballScore('b', -1)" class="py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold">
                                    -১ গোল
                                </button>
                                <button onclick="quickEvent('card', '🟨 ফাউল / কার্ড', '{{ $match->team_b }} এর খেলোয়াড়কে সতর্ক করা হলো')" class="py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold">
                                    🟨 কার্ড
                                </button>
                            </div>
                        @elseif($match->sport_type == 'cricket')
                            <div class="grid grid-cols-4 gap-2">
                                <button onclick="adjustCricketRun('b', 1)" class="py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-xl text-xs font-bold">+১</button>
                                <button onclick="adjustCricketRun('b', 4)" class="py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold">+৪ চার</button>
                                <button onclick="adjustCricketRun('b', 6)" class="py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold">+৬ ছক্কা</button>
                                <button onclick="adjustCricketWicket('b')" class="py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold">উইকেট ☝</button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Current Summary Input -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase">বর্তমান খেলার পরিস্থিতি / সামারি বার্তা</label>
                    <div class="flex gap-2">
                        <input type="text" id="current_summary_input" value="{{ $match->current_summary }}" placeholder="যেমন: ২য় হাফ চলমান (৭০ মিনিট) বা জয়ের জন্য ৮ বলে ৪ রান প্রয়োজন" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        <button onclick="submitScoreUpdate()" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-xs whitespace-nowrap shadow">
                            আপডেট সংরক্ষণ করুন ✓
                        </button>
                    </div>
                </div>
            </div>

            <!-- 🏏 CRICINFO DETAILED SCORECARD CONSOLE -->
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-3xl shadow-sm border border-emerald-500/30 dark:border-emerald-500/20 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🏏</span>
                        <div>
                            <h3 class="text-base font-black text-gray-900 dark:text-white">ক্রিকইনফো স্টাইল বিস্তারিত স্কোরকার্ড (Full Scorecard)</h3>
                            <p class="text-xs text-gray-400">প্রতিটি প্লেয়ারের ব্যক্তিগত রান, বল, উইকেট, ওভার এবং ম্যাচ সেরার ডেটা যুক্ত করুন</p>
                        </div>
                    </div>
                </div>

                <!-- Match Meta: Toss & Result Update -->
                <form action="{{ route('matches.update-meta', $match->slug) }}" method="POST" class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 space-y-3">
                    @csrf
                    <div class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-1.5 mb-1">
                        <span>🏆</span> টস ও ম্যাচ ফলাফল পরিচালনা
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
                        <div>
                            <label class="block font-semibold text-gray-600 dark:text-gray-400 mb-1">টসে জয়ী দল</label>
                            <input type="text" name="toss_winner" value="{{ $match->toss_winner }}" placeholder="উদা: {{ $match->team_a }}" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-600 dark:text-gray-400 mb-1">টসের সিদ্ধান্ত</label>
                            <select name="toss_decision" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                <option value="">নির্বাচন করুন</option>
                                <option value="bat" {{ $match->toss_decision == 'bat' ? 'selected' : '' }}>ব্যাট করার সিদ্ধান্ত</option>
                                <option value="field" {{ $match->toss_decision == 'field' ? 'selected' : '' }}>ফিল্ডিং/বোলিং করার সিদ্ধান্ত</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-600 dark:text-gray-400 mb-1">ম্যাচ ফলাফল (Match Result)</label>
                            <input type="text" name="match_result" value="{{ $match->match_result }}" placeholder="উদা: {{ $match->team_a }} ২৪ রানে জয়ী" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-600 dark:text-gray-400 mb-1">ম্যাচ সেরা (Player of Match)</label>
                            <input type="text" name="player_of_match" value="{{ $match->player_of_match }}" placeholder="উদা: আরিয়ান আহমেদ (৭৪ রান ও ২ উইকেট)" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition">
                            টস ও ফলাফল সংরক্ষণ করুন ✓
                        </button>
                    </div>
                </form>

                <!-- Add Player Scorecard Entry Form -->
                @php
                    $availablePlayers = collect();
                    if ($match->teamA && $match->teamA->players) {
                        $availablePlayers = $availablePlayers->merge($match->teamA->players);
                    }
                    if ($match->teamB && $match->teamB->players) {
                        $availablePlayers = $availablePlayers->merge($match->teamB->players);
                    }
                @endphp

                <form action="{{ route('matches.add-player-stat', $match->slug) }}" method="POST" class="p-5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-500/30 space-y-4">
                    @csrf
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-emerald-800 dark:text-emerald-300 uppercase tracking-wider flex items-center gap-1.5">
                            <span>➕</span> প্লেয়ারের স্কোরকার্ড এন্ট্রি (ব্যাটিং / বোলিং / গোল)
                        </h4>
                        <span class="text-[10px] text-gray-500 dark:text-gray-400">খেলোয়াড়ের প্রতি ম্যাচের রেকর্ড যুক্ত করুন</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
                        <div>
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">দল নির্বাচন *</label>
                            <select name="team_id" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                @if($match->teamA)
                                    <option value="{{ $match->teamA->id }}">{{ $match->teamA->name }}</option>
                                @endif
                                @if($match->teamB)
                                    <option value="{{ $match->teamB->id }}">{{ $match->teamB->name }}</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">প্লেয়ার নির্বাচন *</label>
                            <select name="team_player_id" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                <option value="">-- প্লেয়ার সিলেক্ট করুন --</option>
                                @foreach($availablePlayers as $ap)
                                    <option value="{{ $ap->id }}">{{ $ap->name }} ({{ $ap->team->name ?? '' }} - {{ $ap->role }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">ইনিংস *</label>
                            <select name="inning" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                <option value="1">১ম ইনিংস (1st Inning)</option>
                                <option value="2">২য় ইনিংস (2nd Inning)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">আউট বিবরণ (Dismissal)</label>
                            <input type="text" name="dismissal_type" value="not out" placeholder="not out, b Shakib, c Rahim" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        </div>
                    </div>

                    <!-- Cricket Batting Row -->
                    <div class="p-3 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 space-y-2">
                        <span class="text-[11px] font-bold text-gray-600 dark:text-gray-400 block uppercase">🏏 ক্রিকেট ব্যাটিং</span>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                            <div>
                                <label class="block text-gray-500 mb-1">রান (Runs)</label>
                                <input type="number" min="0" name="runs_scored" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono font-bold">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">বল (Balls)</label>
                                <input type="number" min="0" name="balls_faced" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">চার (4s)</label>
                                <input type="number" min="0" name="fours" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">ছক্কা (6s)</label>
                                <input type="number" min="0" name="sixes" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                        </div>
                    </div>

                    <!-- Cricket Bowling Row -->
                    <div class="p-3 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 space-y-2">
                        <span class="text-[11px] font-bold text-gray-600 dark:text-gray-400 block uppercase">🎯 ক্রিকেট বোলিং</span>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                            <div>
                                <label class="block text-gray-500 mb-1">ওভার (Overs)</label>
                                <input type="number" step="0.1" min="0" name="overs_bowled" value="0.0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">মেইডেন (Mdns)</label>
                                <input type="number" min="0" name="maidens" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">রান খরচ (Runs)</label>
                                <input type="number" min="0" name="runs_conceded" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">উইকেট (Wkts)</label>
                                <input type="number" min="0" name="wickets_taken" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono text-amber-500 font-bold">
                            </div>
                        </div>
                    </div>

                    <!-- Football Stats Row -->
                    <div class="p-3 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 space-y-2">
                        <span class="text-[11px] font-bold text-gray-600 dark:text-gray-400 block uppercase">⚽ ফুটবল পারফরম্যান্স</span>
                        <div class="grid grid-cols-2 sm:grid-cols-6 gap-3 text-xs">
                            <div>
                                <label class="block text-gray-500 mb-1">গোল (Goals)</label>
                                <input type="number" min="0" name="goals" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono font-bold text-emerald-500">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">অ্যাসিস্ট (Assists)</label>
                                <input type="number" min="0" name="assists" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">মিনিট খেলা (Mins)</label>
                                <input type="number" min="0" name="minutes_played" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">হলুদ কার্ড (🟨)</label>
                                <input type="number" min="0" name="yellow_cards" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono text-amber-500">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">লাল কার্ড (🟥)</label>
                                <input type="number" min="0" name="red_cards" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono text-rose-500">
                            </div>
                            <div class="flex items-center pt-5">
                                <label class="inline-flex items-center text-xs text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <input type="checkbox" name="clean_sheet" value="1" class="rounded border-gray-300 dark:border-gray-700 text-emerald-600 focus:ring-emerald-500">
                                    <span class="ml-1.5 font-bold text-emerald-600">ক্লিন শিট</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Badminton & Athletics Row -->
                    <div class="p-3 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 space-y-2">
                        <span class="text-[11px] font-bold text-gray-600 dark:text-gray-400 block uppercase">🏸 ব্যাডমিন্টন / 🏃 অ্যাথলেটিক্স রেকর্ড</span>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                            <div>
                                <label class="block text-gray-500 mb-1">সেট জয় (Sets Won)</label>
                                <input type="number" min="0" name="sets_won" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">পয়েন্ট (Points)</label>
                                <input type="number" min="0" name="points_scored" value="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 font-mono">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">টাইমিং রেকর্ড (Timing)</label>
                                <input type="text" name="timing_record" placeholder="উদা: 10.82s / 2m 14s" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">পজিশন / মেডেল (Rank)</label>
                                <input type="text" name="position_rank" placeholder="উদা: ১ম স্থান (স্বর্ণপদক)" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
                        <label class="inline-flex items-center text-xs text-gray-700 dark:text-gray-300 cursor-pointer">
                            <input type="checkbox" name="is_player_of_match" value="1" class="rounded border-gray-300 dark:border-gray-700 text-emerald-600 focus:ring-emerald-500">
                            <span class="ml-2 font-bold text-amber-500">⭐ ম্যাচ সেরা খেলোয়াড় (Player of the Match)</span>
                        </label>
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow transition">
                            স্কোরকার্ডে সংরক্ষণ করুন ✓
                        </button>
                    </div>
                </form>

                <!-- Current Scorecard Display Table -->
                @if($match->playerStats->count() > 0)
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wider flex items-center gap-1.5">
                            <span>📋</span> বর্তমান ম্যাচের স্কোরকার্ড এন্ট্রি সমূহ ({{ $match->playerStats->count() }} টি রেকর্ড)
                        </h4>
                        <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700">
                            <table class="w-full text-left text-xs text-gray-700 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-200 uppercase text-[10px]">
                                    <tr>
                                        <th class="p-3">প্লেয়ার</th>
                                        <th class="p-3">দল</th>
                                        <th class="p-3">ইনিংস / হাফ</th>
                                        <th class="p-3">পারফরম্যান্স (ক্রিকেট / ফুটবল / ব্যাডমিন্টন / অ্যাথলেটিক্স)</th>
                                        <th class="p-3">আউট / ভূমিকা</th>
                                        <th class="p-3">বোলিং / শৃঙ্খলা</th>
                                        <th class="p-3">স্ট্রাইক রেট / রেটিং</th>
                                        <th class="p-3 text-right">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($match->playerStats as $stat)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                            <td class="p-3 font-bold text-gray-900 dark:text-white">
                                                {{ $stat->player->name ?? 'প্লেয়ার' }}
                                                @if($stat->is_player_of_match)
                                                    <span class="text-amber-500" title="Player of the Match">⭐ POTM</span>
                                                @endif
                                            </td>
                                            <td class="p-3">{{ $stat->team->name ?? '-' }}</td>
                                            <td class="p-3 font-mono font-semibold">{{ $stat->inning }}st Inn / Half</td>
                                            <td class="p-3 font-mono">
                                                @if($match->sport_type == 'football' || $stat->goals > 0 || $stat->assists > 0)
                                                    <div class="text-emerald-600 dark:text-emerald-400 font-bold">
                                                        ⚽ {{ $stat->goals }} গোল, {{ $stat->assists }} অ্যাসিস্ট ({{ $stat->minutes_played }}' মিনিট)
                                                    </div>
                                                @elseif($match->sport_type == 'badminton' || $stat->sets_won > 0 || $stat->points_scored > 0)
                                                    <div class="text-cyan-600 dark:text-cyan-400 font-bold">
                                                        🏸 {{ $stat->sets_won }} সেট জয় ({{ $stat->points_scored }} পয়েন্ট)
                                                    </div>
                                                @elseif($match->sport_type == 'athletics' || $stat->timing_record)
                                                    <div class="text-purple-600 dark:text-purple-400 font-bold">
                                                        ⏱️ {{ $stat->timing_record }} • {{ $stat->position_rank }}
                                                    </div>
                                                @else
                                                    <div class="font-bold text-emerald-600 dark:text-emerald-400">
                                                        🏏 {{ $stat->runs_scored }} রান ({{ $stat->balls_faced }}b, {{ $stat->fours }}x4, {{ $stat->sixes }}x6)
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="p-3 text-gray-500 text-xs">{{ $stat->dismissal_type ?? '-' }}</td>
                                            <td class="p-3 font-mono text-xs">
                                                @if($stat->overs_bowled > 0)
                                                    {{ $stat->overs_bowled }}-{{ $stat->maidens }}-{{ $stat->runs_conceded }}-<strong class="text-amber-500">{{ $stat->wickets_taken }}w</strong>
                                                @elseif($stat->yellow_cards > 0 || $stat->red_cards > 0)
                                                    <span class="text-amber-500 font-bold">{{ $stat->yellow_cards }}x🟨</span> <span class="text-rose-500 font-bold">{{ $stat->red_cards }}x🟥</span>
                                                @elseif($stat->clean_sheet)
                                                    <span class="text-emerald-600 font-bold">🧤 ক্লিন শিট</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="p-3 font-mono text-[11px]">{{ $stat->strike_rate > 0 ? $stat->strike_rate : '-' }}</td>
                                            <td class="p-3 text-right">
                                                <form action="{{ route('matches.delete-player-stat', [$match->slug, $stat]) }}" method="POST" onsubmit="return confirm('এই রেকর্ডটি ডিলিট করতে চান?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs" title="ডিলিট">✕</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Live Stream URL Controller -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-4">
                <h3 class="text-base font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                    <span>📺</span> লাইভ ভিডিও সম্প্রচার (YouTube / Facebook Live)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div class="sm:col-span-3">
                        <input type="url" id="stream_url_input" value="{{ $match->stream_url }}" placeholder="https://www.youtube.com/watch?v=... বা Facebook Live ভিডিও লিঙ্ক" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button onclick="toggleStream(true)" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-xs shadow">
                            স্ট্রিম অন
                        </button>
                        <button onclick="toggleStream(false)" class="w-full py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-xs">
                            স্ট্রিম অফ
                        </button>
                    </div>
                </div>
                <p class="text-xs text-gray-400">
                    ইউটিউব বা ফেসবুকে লাইভ শুরু করার পর লিংকটি এখানে পেস্ট করে "স্ট্রিম অন" করলেই দর্শকরা লাইভ পেজে খেলা দেখতে পাবেন।
                </p>
            </div>

            <!-- Live Commentary Post -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-4">
                <h3 class="text-base font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                    <span>⚡</span> লাইভ ধারাভাষ্য / ইভেন্ট পোস্ট করুন
                </h3>

                <form id="event_form" onsubmit="submitEvent(event)" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">মিনিট / ওভার</label>
                            <input type="text" id="event_time" placeholder="যেমন: 75' বা 18.2 ov" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-xs">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">ইভেন্টের ধরণ</label>
                            <select id="event_type" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-xs">
                                <option value="goal">⚽ গোল (Goal)</option>
                                <option value="four">🏏 চার (Four)</option>
                                <option value="six">💥 ছক্কা (Six)</option>
                                <option value="wicket">☝ উইকেট (Wicket)</option>
                                <option value="card">🟨 ফাউল / কার্ড</option>
                                <option value="commentary">📣 ধারাভাষ্য</option>
                                <option value="break">⏸ বিরতি</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">শিরোনাম</label>
                            <input type="text" id="event_title" placeholder="যেমন: দুর্দান্ত গোল!" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">বিস্তারিত বিবরণ *</label>
                        <input type="text" id="event_desc" placeholder="যেমন: ১০ নম্বর জার্সিধারী তানভীর আহমেদ চমৎকার গোল করলেন!" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow">
                            + কমেন্ট্রি পোস্ট করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scorer Ajax Script -->
    <script>
        const updateScoreUrl = "{{ route('matches.update-score', $match->slug) }}";
        const addEventUrl = "{{ route('matches.add-event', $match->slug) }}";
        const csrfToken = "{{ csrf_token() }}";

        function showToast(msg) {
            const toast = document.getElementById('toast_msg');
            toast.innerText = msg;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }

        function submitScoreUpdate() {
            const teamAScore = document.getElementById('team_a_score_input').value;
            const teamBScore = document.getElementById('team_b_score_input').value;
            const summary = document.getElementById('current_summary_input').value;
            const status = document.getElementById('match_status_select').value;
            const streamUrl = document.getElementById('stream_url_input').value;

            fetch(updateScoreUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    team_a_score: teamAScore,
                    team_b_score: teamBScore,
                    current_summary: summary,
                    status: status,
                    stream_url: streamUrl
                })
            })
            .then(res => res.json())
            .then(data => {
                showToast("✓ স্কোর আপডেট সফল হয়েছে!");
            })
            .catch(err => console.error(err));
        }

        function adjustFootballScore(team, delta) {
            const elem = document.getElementById(`team_${team}_score_input`);
            let current = parseInt(elem.value) || 0;
            current = Math.max(0, current + delta);
            elem.value = current;

            document.getElementById('match_status_select').value = 'live';
            submitScoreUpdate();

            if (delta > 0) {
                const teamName = team === 'a' ? "{{ $match->team_a }}" : "{{ $match->team_b }}";
                quickEvent('goal', 'গোললল! (GOAL)', `${teamName} এর চমৎকার গোল!`);
            }
        }

        function adjustCricketRun(team, runs) {
            const elem = document.getElementById(`team_${team}_score_input`);
            let parts = elem.value.split('/');
            let currentRuns = parseInt(parts[0]) || 0;
            currentRuns += runs;
            let wicketsAndOvers = parts[1] || '0 (0.0)';
            elem.value = `${currentRuns}/${wicketsAndOvers}`;
            document.getElementById('match_status_select').value = 'live';
            submitScoreUpdate();
        }

        function adjustCricketWicket(team) {
            const elem = document.getElementById(`team_${team}_score_input`);
            let parts = elem.value.split('/');
            let currentRuns = parseInt(parts[0]) || 0;
            let sub = (parts[1] || '0').split(' ');
            let wickets = parseInt(sub[0]) || 0;
            wickets = Math.min(10, wickets + 1);
            let overs = sub[1] || '(0.0)';
            elem.value = `${currentRuns}/${wickets} ${overs}`;
            submitScoreUpdate();
            quickEvent('wicket', 'উইকেট পতন!', 'বোলার চমৎকার ডেলিভারিতে উইকেট শিকার করলেন!');
        }

        function toggleStream(enable) {
            const streamUrl = document.getElementById('stream_url_input').value;
            fetch(updateScoreUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    team_a_score: document.getElementById('team_a_score_input').value,
                    team_b_score: document.getElementById('team_b_score_input').value,
                    status: document.getElementById('match_status_select').value,
                    stream_url: streamUrl,
                    is_streaming: enable ? 1 : 0
                })
            })
            .then(res => res.json())
            .then(() => {
                showToast(enable ? "✓ লাইভ ভিডিও স্ট্রিম সক্রিয় করা হয়েছে!" : "✓ লাইভ ভিডিও স্ট্রিম বন্ধ করা হয়েছে।");
            });
        }

        function quickEvent(type, title, desc) {
            fetch(addEventUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    time_marker: 'LIVE',
                    event_type: type,
                    title: title,
                    description: desc
                })
            })
            .then(res => res.json())
            .then(() => showToast(`✓ ইভেন্ট যুক্ত করা হয়েছে: ${title}`));
        }

        function submitEvent(e) {
            e.preventDefault();
            const time = document.getElementById('event_time').value;
            const type = document.getElementById('event_type').value;
            const title = document.getElementById('event_title').value;
            const desc = document.getElementById('event_desc').value;

            fetch(addEventUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    time_marker: time,
                    event_type: type,
                    title: title,
                    description: desc
                })
            })
            .then(res => res.json())
            .then(() => {
                showToast("✓ নতুন কমেন্ট্রি টাইমলাইনে যোগ করা হয়েছে!");
                document.getElementById('event_desc').value = '';
                document.getElementById('event_title').value = '';
            });
        }
    </script>
</x-app-layout>


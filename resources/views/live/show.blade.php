<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $match->title }} | ক্রিকইনফো ম্যাচ সেন্টার ও লাইভ স্কোরকার্ড</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-rose-500 selection:text-white" x-data="{ activeTab: 'live' }">
    <!-- Header -->
    <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('live.index') }}" class="text-xs font-bold text-slate-400 hover:text-white flex items-center gap-1.5 transition">
                    &larr; ম্যাচ সেন্টারে ফিরুন
                </a>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('public.teams.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 hidden sm:inline-block px-3 py-1 rounded-lg bg-amber-500/10 border border-amber-500/20">
                    🛡️ টিম হাব
                </a>

                @if($match->status == 'live')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-bold uppercase tracking-wider animate-pulse">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        LIVE
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full bg-slate-800 text-slate-400 text-xs font-bold uppercase">
                        {{ $match->status == 'upcoming' ? 'আসন্ন ম্যাচ' : 'ম্যাচ সমাপ্ত' }}
                    </span>
                @endif

                @auth
                    @if($match->status !== 'finished')
                        <a href="{{ route('matches.scorer', $match->slug) }}" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow flex items-center gap-1 transition">
                            <span>স্কোর পরিচালনা</span> ⚙️
                        </a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('matches.scorer', $match->slug) }}" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-500 text-white text-xs font-bold rounded-xl shadow flex items-center gap-1 transition">
                            <span>এডমিন স্কোর এডিট</span> ⚙️
                        </a>
                    @endif
                @else
                    @if($match->status !== 'finished')
                        <a href="{{ route('scorer.quick-access', $match->slug) }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-rose-400 border border-rose-500/30 text-xs font-bold rounded-xl shadow flex items-center gap-1 transition">
                            <span>🔑 স্কোরার পিন</span>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-500/15 border border-rose-500/40 text-rose-300 text-xs sm:text-sm font-semibold flex items-center gap-2 shadow-lg">
                <span class="text-base">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm font-semibold flex items-center gap-2 shadow-lg">
                <span class="text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        <!-- Match Info Banner -->
        <div class="text-center max-w-3xl mx-auto">
            <span class="text-xs font-bold text-rose-400 uppercase tracking-widest">{{ $match->tournament_name ?? 'টুর্নামেন্ট ম্যাচ' }}</span>
            <h1 class="text-2xl sm:text-3xl font-black text-white mt-1">{{ $match->title }}</h1>
            <p class="text-xs text-slate-400 mt-1">ভেন্যু: {{ $match->venue }} • খেলা: {{ strtoupper($match->sport_type) }} • তারিখ: {{ $match->match_datetime ? \Carbon\Carbon::parse($match->match_datetime)->format('d M, Y h:i A') : 'শীঘ্রই' }}</p>
        </div>

        <!-- Big Scoreboard Box -->
        <div class="bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-5 items-center gap-6 text-center">
                <!-- Team A -->
                <div class="md:col-span-2">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-slate-800 border-2 border-slate-700 flex items-center justify-center text-3xl font-black text-white shadow-xl mb-3 overflow-hidden">
                        @if($match->teamA && $match->teamA->logo)
                            <img src="{{ asset('storage/' . $match->teamA->logo) }}" alt="{{ $match->team_a }}" class="w-full h-full object-cover">
                        @else
                            {{ mb_substr($match->team_a, 0, 1) }}
                        @endif
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white">
                        @if($match->teamA)
                            <a href="{{ route('public.teams.show', $match->teamA->slug) }}" class="hover:text-amber-400 transition underline-offset-4 hover:underline">
                                {{ $match->team_a }}
                            </a>
                        @else
                            {{ $match->team_a }}
                        @endif
                    </h3>
                </div>

                <!-- Score Center -->
                <div class="md:col-span-1 space-y-2">
                    <div class="inline-block bg-slate-800/90 border-2 border-rose-500/50 rounded-2xl px-6 py-3 shadow-inner">
                        <div id="live_score_display" class="text-3xl sm:text-4xl font-black font-mono tracking-tight text-white">
                            {{ $match->team_a_score }} : {{ $match->team_b_score }}
                        </div>
                    </div>
                    <div id="live_status_badge" class="text-xs font-bold text-rose-400 uppercase tracking-wider">
                        {{ $match->status == 'live' ? '● সরাসরি সম্প্রচার' : ($match->status == 'upcoming' ? 'আসন্ন' : 'সমাপ্ত') }}
                    </div>
                </div>

                <!-- Team B -->
                <div class="md:col-span-2">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-slate-800 border-2 border-slate-700 flex items-center justify-center text-3xl font-black text-white shadow-xl mb-3 overflow-hidden">
                        @if($match->teamB && $match->teamB->logo)
                            <img src="{{ asset('storage/' . $match->teamB->logo) }}" alt="{{ $match->team_b }}" class="w-full h-full object-cover">
                        @else
                            {{ mb_substr($match->team_b, 0, 1) }}
                        @endif
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white">
                        @if($match->teamB)
                            <a href="{{ route('public.teams.show', $match->teamB->slug) }}" class="hover:text-amber-400 transition underline-offset-4 hover:underline">
                                {{ $match->team_b }}
                            </a>
                        @else
                            {{ $match->team_b }}
                        @endif
                    </h3>
                </div>
            </div>

            <!-- Current Summary Ticker & Toss Info -->
            <div class="mt-8 pt-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex flex-wrap items-center gap-2">
                    @if($match->toss_winner)
                        <span class="px-3 py-1.5 rounded-xl bg-slate-800 text-slate-300 font-semibold border border-slate-700">
                            🪙 টস: <strong class="text-amber-400">{{ $match->toss_winner }}</strong> (সিদ্ধান্ত: {{ $match->toss_decision == 'bat' ? 'ব্যাটিং' : 'বোলিং' }})
                        </span>
                    @endif

                    @if($match->player_of_match)
                        <span class="px-3 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">
                            ⭐ ম্যাচ সেরা: {{ $match->player_of_match }}
                        </span>
                    @endif
                </div>

                <div id="live_summary_box" class="px-4 py-2 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-300 font-bold text-center">
                    ⚡ {{ $match->current_summary ?? 'স্কোর আপডেট করা হচ্ছে...' }}
                </div>
            </div>

            @if($match->match_result)
                <div class="mt-4 p-3 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-center font-bold text-sm">
                    🏆 ফলাফল: {{ $match->match_result }}
                </div>
            @endif
        </div>

        <!-- Match Navigation Tabs -->
        <div class="flex items-center space-x-2 border-b border-slate-800 pb-3 text-xs sm:text-sm font-bold overflow-x-auto whitespace-nowrap">
            <button @click="activeTab = 'live'" :class="activeTab === 'live' ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/20' : 'bg-slate-900 text-slate-400 hover:text-white'" class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0">
                <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                <span>লাইভ হাব ও স্ট্রিম</span>
            </button>
            <button @click="activeTab = 'scorecard'" :class="activeTab === 'scorecard' ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/20' : 'bg-slate-900 text-slate-400 hover:text-white'" class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0">
                <span>{{ $match->sport_type == 'football' ? '⚽' : ($match->sport_type == 'badminton' ? '🏸' : ($match->sport_type == 'athletics' ? '🏃' : '📋')) }}</span>
                <span>
                    @if($match->sport_type == 'football') পূর্ণাঙ্গ স্কোরকার্ড
                    @elseif($match->sport_type == 'badminton') ব্যাডমিন্টন সেট ও পয়েন্ট
                    @elseif($match->sport_type == 'athletics') অ্যাথলেটিক্স ফলাফল
                    @else পূর্ণাঙ্গ স্কোরকার্ড (Cricinfo)
                    @endif
                </span>
            </button>
            <button @click="activeTab = 'squads'" :class="activeTab === 'squads' ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/20' : 'bg-slate-900 text-slate-400 hover:text-white'" class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0">
                <span>👥</span>
                <span>প্লেয়িং স্কোয়াড</span>
            </button>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: LIVE CENTER & VIDEO STREAM & EVENTS -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'live'" class="space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Video Stream Player -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <span>📺</span> সরাসরি ভিডিও সম্প্রচার (Live Stream)
                        </h2>
                        <span id="stream_status_text" class="text-xs {{ $match->is_streaming ? 'text-rose-400 font-bold' : 'text-slate-500' }}">
                            {{ $match->is_streaming ? 'অনলাইনে সম্প্রচারিত হচ্ছে' : 'ভিডিও স্ট্রিম অফলাইন' }}
                        </span>
                    </div>

                    <!-- Video Container -->
                    <div id="video_stream_container" class="aspect-video bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-xl flex items-center justify-center relative">
                        @if($match->is_streaming && $match->embed_url)
                            <iframe id="stream_iframe" src="{{ $match->embed_url }}" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <div class="text-center p-8">
                                <div class="text-5xl mb-4">🎥</div>
                                <h4 class="text-base font-bold text-white">লাইভ ভিডিও স্ট্রিম এখনো যুক্ত করা হয়নি</h4>
                                <p class="text-xs text-slate-400 mt-2 max-w-sm mx-auto">
                                    ম্যাচ চলাকালীন স্কোরার বা একাডেমি কতৃপক্ষ সরাসরি YouTube Live বা Facebook Live লিঙ্ক যুক্ত করলে এখানে ভিডিও প্লেয়ার চালু হবে।
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Share match -->
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                        <span class="text-slate-400">ম্যাচের স্কোর ও সম্প্রচার শেয়ার করুন:</span>
                        <div class="flex gap-2">
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('ম্যাচ লিংক কপি করা হয়েছে!');" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl font-semibold transition">
                                📋 লিংক কপি
                            </button>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($match->title . ' - লাইভ স্কোর দেখুন: ' . url()->current()) }}" target="_blank" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-bold transition">
                                WhatsApp এ শেয়ার
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Live Commentary Ticker -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <span>⚡</span> লাইভ কমেন্ট্রি ও টাইমলাইন
                        </h2>
                        <span class="text-xs text-slate-400">অটো-রিফ্রেশ সক্রিয়</span>
                    </div>

                    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 shadow-xl max-h-[580px] overflow-y-auto space-y-4" id="commentary_list">
                        @forelse($events as $event)
                            <div class="border-l-2 border-rose-500 pl-4 py-1 relative">
                                <div class="absolute -left-1.5 top-2 w-3 h-3 rounded-full bg-rose-500"></div>
                                <div class="flex items-center justify-between text-xs text-slate-400">
                                    <span class="font-bold text-rose-400 font-mono">{{ $event->time_marker ?? '-' }}</span>
                                    <span class="text-[10px]">{{ $event->created_at->diffForHumans() }}</span>
                                </div>
                                @if($event->title)
                                    <h4 class="font-bold text-sm text-white mt-0.5">{{ $event->title }}</h4>
                                @endif
                                <p class="text-xs text-slate-300 mt-1 leading-relaxed">{{ $event->description }}</p>
                            </div>
                        @empty
                            <div class="text-center py-10 text-slate-500 text-xs">
                                এখনো কোনো কমেন্ট্রি যুক্ত করা হয়নি।
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: DETAILED MATCH CENTER & SCORECARD  -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'scorecard'" class="space-y-10" style="display: none;">
            @if($match->sport_type == 'football')
                <!-- FOOTBALL SCORECARD -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800 pb-4">
                        <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                            <span>⚽</span> ফুটবল পূর্ণাঙ্গ ম্যাচ পরিসংখ্যান (Football Match Stats)
                        </h3>
                        <span class="text-xs font-mono text-emerald-400 font-bold bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-xl self-start">
                            গোল, অ্যাসিস্ট ও শৃঙ্খলা
                        </span>
                    </div>

                    <!-- Goals & Assists Highlight Cards -->
                    @php
                        $goalScorers = $match->playerStats->where('goals', '>', 0);
                    @endphp
                    @if($goalScorers->count() > 0)
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">ম্যাচের গোলদাতা ও অ্যাসিস্ট</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($goalScorers as $gs)
                                    <div class="bg-slate-950 p-3.5 rounded-2xl border border-slate-800 flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <span class="text-xl">⚽</span>
                                            <div>
                                                <a href="{{ route('public.players.show', $gs->player->id ?? 1) }}" class="font-bold text-white hover:text-emerald-400 transition text-sm">
                                                    {{ $gs->player->name ?? 'প্লেয়ার' }}
                                                </a>
                                                <span class="text-[11px] text-slate-400 block">{{ $gs->team->name ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-black font-mono text-emerald-400">{{ $gs->goals }} গোল</span>
                                            @if($gs->assists > 0)
                                                <span class="text-[10px] text-amber-400 block font-mono">({{ $gs->assists }} অ্যাসিস্ট)</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Detailed Players Match Stats Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                    <th class="py-2.5 px-3">খেলোয়াড় (Player)</th>
                                    <th class="py-2.5 px-3">দল (Team)</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-emerald-400">গোল (G)</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-amber-400">অ্যাসিস্ট (A)</th>
                                    <th class="py-2.5 px-2 text-center">মিনিট খেলা</th>
                                    <th class="py-2.5 px-2 text-center text-amber-300">হলুদ কার্ড (🟨)</th>
                                    <th class="py-2.5 px-2 text-center text-rose-400">লাল কার্ড (🟥)</th>
                                    <th class="py-2.5 px-2 text-center text-teal-400">ক্লিন শিট</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/80 font-mono">
                                @forelse($match->playerStats as $fps)
                                    <tr class="hover:bg-slate-850/50">
                                        <td class="py-3 px-3 font-bold text-white font-sans">
                                            @if($fps->player)
                                                <a href="{{ route('public.players.show', $fps->player->id) }}" class="hover:text-emerald-400 transition flex items-center gap-2">
                                                    <span>{{ $fps->player->name }}</span>
                                                    @if($fps->is_player_of_match)
                                                        <span class="text-amber-400 text-xs">⭐</span>
                                                    @endif
                                                </a>
                                            @else
                                                খেলোয়াড়
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-slate-300 font-sans text-xs">{{ $fps->team->name ?? '-' }}</td>
                                        <td class="py-3 px-2 text-center font-black text-emerald-400 text-base">{{ $fps->goals }}</td>
                                        <td class="py-3 px-2 text-center font-black text-amber-400 text-base">{{ $fps->assists }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $fps->minutes_played }}'</td>
                                        <td class="py-3 px-2 text-center font-bold text-amber-300">{{ $fps->yellow_cards }}</td>
                                        <td class="py-3 px-2 text-center font-bold text-rose-400">{{ $fps->red_cards }}</td>
                                        <td class="py-3 px-2 text-center font-bold text-teal-400">{{ $fps->clean_sheet ? '🧤 হ্যাঁ' : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-8 text-center text-slate-500 text-xs font-sans">
                                            ফুটবল ম্যাচ স্কোরকার্ডের কোনো রেকর্ড এখনও যোগ করা হয়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($match->sport_type == 'badminton')
                <!-- BADMINTON SCORECARD -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800 pb-4">
                        <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                            <span>🏸</span> ব্যাডমিন্টন সেট ও পয়েন্ট স্কোরকার্ড
                        </h3>
                        <span class="text-xs font-mono text-cyan-400 font-bold bg-cyan-500/10 border border-cyan-500/20 px-3 py-1 rounded-xl self-start">
                            সেট ফলাফল
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                    <th class="py-2.5 px-3">খেলোয়াড় (Player)</th>
                                    <th class="py-2.5 px-3">দল (Team)</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-cyan-400">সেট জয় (Sets)</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-amber-400">মোট পয়েন্ট (Points)</th>
                                    <th class="py-2.5 px-2 text-center">ম্যাচ সেরা</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/80 font-mono">
                                @forelse($match->playerStats as $bps)
                                    <tr class="hover:bg-slate-850/50">
                                        <td class="py-3 px-3 font-bold text-white font-sans">
                                            @if($bps->player)
                                                <a href="{{ route('public.players.show', $bps->player->id) }}" class="hover:text-cyan-400 transition">
                                                    {{ $bps->player->name }}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-slate-300 font-sans text-xs">{{ $bps->team->name ?? '-' }}</td>
                                        <td class="py-3 px-2 text-center font-black text-cyan-400 text-base">{{ $bps->sets_won }}</td>
                                        <td class="py-3 px-2 text-center font-black text-amber-400 text-base">{{ $bps->points_scored }}</td>
                                        <td class="py-3 px-2 text-center">
                                            @if($bps->is_player_of_match)
                                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 text-[10px] font-bold">⭐ MVP</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-500 text-xs font-sans">
                                            ব্যাডমিন্টন স্কোরের রেকর্ড এখনও যোগ করা হয়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($match->sport_type == 'athletics')
                <!-- ATHLETICS SCORECARD -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800 pb-4">
                        <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                            <span>🏃</span> অ্যাথলেটিক্স ইভেন্ট ফলাফল ও টাইমিং লিডারবোর্ড
                        </h3>
                        <span class="text-xs font-mono text-purple-400 font-bold bg-purple-500/10 border border-purple-500/20 px-3 py-1 rounded-xl self-start">
                            টাইম ও র্যাঙ্ক
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                    <th class="py-2.5 px-3">অ্যাথলেট (Athlete)</th>
                                    <th class="py-2.5 px-3">দল (Team)</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-purple-400">টাইমিং রেকর্ড</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-amber-400">পজিশন ও পদক</th>
                                    <th class="py-2.5 px-2 text-center">সেরা ক্রীড়াবিদ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/80 font-mono">
                                @forelse($match->playerStats as $aps)
                                    <tr class="hover:bg-slate-850/50">
                                        <td class="py-3 px-3 font-bold text-white font-sans">
                                            @if($aps->player)
                                                <a href="{{ route('public.players.show', $aps->player->id) }}" class="hover:text-purple-400 transition">
                                                    {{ $aps->player->name }}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-slate-300 font-sans text-xs">{{ $aps->team->name ?? '-' }}</td>
                                        <td class="py-3 px-2 text-center font-black text-purple-400 text-base">{{ $aps->timing_record ?? '-' }}</td>
                                        <td class="py-3 px-2 text-center font-black text-amber-400 text-sm">{{ $aps->position_rank ?? '-' }}</td>
                                        <td class="py-3 px-2 text-center">
                                            @if($aps->is_player_of_match)
                                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 text-[10px] font-bold">⭐ BEST ATHLETE</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-500 text-xs font-sans">
                                            অ্যাথলেটিক্স ইভেন্ট ফলাফল এখনও যোগ করা হয়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- CRICKET SCORECARD (INNING 1 & INNING 2) -->
                <!-- INNING 1 SCORECARD -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800 pb-4 mb-6">
                        <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                            <span>🏏</span> প্রথম ইনিংস (1st Innings Scorecard)
                        </h3>
                        <span class="text-xs font-mono text-amber-400 font-bold bg-amber-500/10 border border-amber-500/20 px-3 py-1 rounded-xl self-start">
                            ব্যাটিং ও বোলিং রেকর্ড
                        </span>
                    </div>

                    <!-- Batting Table -->
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">ব্যাটিং পারফরম্যান্স</h4>
                    <div class="overflow-x-auto mb-8">
                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                    <th class="py-2.5 px-3">ব্যাটার (Batter)</th>
                                    <th class="py-2.5 px-3">আউট হওয়ার ধরন</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-amber-400">রান (R)</th>
                                    <th class="py-2.5 px-2 text-center">বল (B)</th>
                                    <th class="py-2.5 px-2 text-center">৪ (4s)</th>
                                    <th class="py-2.5 px-2 text-center">৬ (6s)</th>
                                    <th class="py-2.5 px-2 text-center text-teal-400">স্ট্রাইক রেট (SR)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/80 font-mono">
                                @forelse($inning1Stats->where('balls_faced', '>', 0) as $b)
                                    <tr class="hover:bg-slate-850/50">
                                        <td class="py-3 px-3 font-bold text-white font-sans">
                                            @if($b->player)
                                                <a href="{{ route('public.players.show', $b->player->id) }}" class="hover:text-amber-400 transition flex items-center gap-2">
                                                    <span>{{ $b->player->name }}</span>
                                                    @if($b->is_player_of_match)
                                                        <span class="text-amber-400 text-xs">⭐</span>
                                                    @endif
                                                </a>
                                            @else
                                                প্লেয়ার
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-slate-400 text-xs font-sans capitalize">
                                            {{ $b->dismissal_type ?? 'নট আউট' }}
                                        </td>
                                        <td class="py-3 px-2 text-center font-black text-amber-400 text-base">{{ $b->runs_scored }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $b->balls_faced }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $b->fours }}</td>
                                        <td class="py-3 px-2 text-center text-rose-400 font-bold">{{ $b->sixes }}</td>
                                        <td class="py-3 px-2 text-center font-bold text-teal-400">{{ $b->strike_rate }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 text-center text-slate-500 text-xs font-sans">
                                            ১ম ইনিংসের ব্যাটিং স্কোর এখনও লিপিবদ্ধ করা হয়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Bowling Table -->
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">বোলিং পারফরম্যান্স</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                    <th class="py-2.5 px-3">বোলার (Bowler)</th>
                                    <th class="py-2.5 px-2 text-center">ওভার (O)</th>
                                    <th class="py-2.5 px-2 text-center">মেডেন (M)</th>
                                    <th class="py-2.5 px-2 text-center">রান (R)</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-rose-400">উইকেট (W)</th>
                                    <th class="py-2.5 px-2 text-center text-teal-400">ইকোনমি (Econ)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/80 font-mono">
                                @forelse($inning1Stats->where('overs_bowled', '>', 0) as $bw)
                                    <tr class="hover:bg-slate-850/50">
                                        <td class="py-3 px-3 font-bold text-white font-sans">
                                            @if($bw->player)
                                                <a href="{{ route('public.players.show', $bw->player->id) }}" class="hover:text-amber-400 transition">
                                                    {{ $bw->player->name }}
                                                </a>
                                            @else
                                                বোলার
                                            @endif
                                        </td>
                                        <td class="py-3 px-2 text-center text-slate-200">{{ $bw->overs_bowled }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $bw->maidens }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $bw->runs_conceded }}</td>
                                        <td class="py-3 px-2 text-center font-black text-rose-400 text-base">{{ $bw->wickets_taken }}</td>
                                        <td class="py-3 px-2 text-center font-bold text-teal-400">{{ $bw->economy_rate }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-slate-500 text-xs font-sans">
                                            ১ম ইনিংসের বোলিং রেকর্ড এখনও লিপিবদ্ধ করা হয়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- INNING 2 SCORECARD -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800 pb-4 mb-6">
                        <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                            <span>🏏</span> দ্বিতীয় ইনিংস (2nd Innings Scorecard)
                        </h3>
                        <span class="text-xs font-mono text-emerald-400 font-bold bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-xl self-start">
                            রান তাড়া ও সমাপ্তি
                        </span>
                    </div>

                    <!-- Batting Table -->
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">ব্যাটিং পারফরম্যান্স</h4>
                    <div class="overflow-x-auto mb-8">
                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                    <th class="py-2.5 px-3">ব্যাটার (Batter)</th>
                                    <th class="py-2.5 px-3">আউট হওয়ার ধরন</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-amber-400">রান (R)</th>
                                    <th class="py-2.5 px-2 text-center">বল (B)</th>
                                    <th class="py-2.5 px-2 text-center">৪ (4s)</th>
                                    <th class="py-2.5 px-2 text-center">৬ (6s)</th>
                                    <th class="py-2.5 px-2 text-center text-teal-400">স্ট্রাইক রেট (SR)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/80 font-mono">
                                @forelse($inning2Stats->where('balls_faced', '>', 0) as $b)
                                    <tr class="hover:bg-slate-850/50">
                                        <td class="py-3 px-3 font-bold text-white font-sans">
                                            @if($b->player)
                                                <a href="{{ route('public.players.show', $b->player->id) }}" class="hover:text-amber-400 transition flex items-center gap-2">
                                                    <span>{{ $b->player->name }}</span>
                                                    @if($b->is_player_of_match)
                                                        <span class="text-amber-400 text-xs">⭐</span>
                                                    @endif
                                                </a>
                                            @else
                                                প্লেয়ার
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-slate-400 text-xs font-sans capitalize">
                                            {{ $b->dismissal_type ?? 'নট আউট' }}
                                        </td>
                                        <td class="py-3 px-2 text-center font-black text-amber-400 text-base">{{ $b->runs_scored }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $b->balls_faced }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $b->fours }}</td>
                                        <td class="py-3 px-2 text-center text-rose-400 font-bold">{{ $b->sixes }}</td>
                                        <td class="py-3 px-2 text-center font-bold text-teal-400">{{ $b->strike_rate }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 text-center text-slate-500 text-xs font-sans">
                                            ২য় ইনিংসের ব্যাটিং স্কোর এখনও লিপিবদ্ধ করা হয়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Bowling Table -->
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">বোলিং পারফরম্যান্স</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                    <th class="py-2.5 px-3">বোলার (Bowler)</th>
                                    <th class="py-2.5 px-2 text-center">ওভার (O)</th>
                                    <th class="py-2.5 px-2 text-center">মেডেন (M)</th>
                                    <th class="py-2.5 px-2 text-center">রান (R)</th>
                                    <th class="py-2.5 px-2 text-center font-bold text-rose-400">উইকেট (W)</th>
                                    <th class="py-2.5 px-2 text-center text-teal-400">ইকোনমি (Econ)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/80 font-mono">
                                @forelse($inning2Stats->where('overs_bowled', '>', 0) as $bw)
                                    <tr class="hover:bg-slate-850/50">
                                        <td class="py-3 px-3 font-bold text-white font-sans">
                                            @if($bw->player)
                                                <a href="{{ route('public.players.show', $bw->player->id) }}" class="hover:text-amber-400 transition">
                                                    {{ $bw->player->name }}
                                                </a>
                                            @else
                                                বোলার
                                            @endif
                                        </td>
                                        <td class="py-3 px-2 text-center text-slate-200">{{ $bw->overs_bowled }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $bw->maidens }}</td>
                                        <td class="py-3 px-2 text-center text-slate-300">{{ $bw->runs_conceded }}</td>
                                        <td class="py-3 px-2 text-center font-black text-rose-400 text-base">{{ $bw->wickets_taken }}</td>
                                        <td class="py-3 px-2 text-center font-bold text-teal-400">{{ $bw->economy_rate }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-slate-500 text-xs font-sans">
                                            ২য় ইনিংসের বোলিং রেকর্ড এখনও লিপিবদ্ধ করা হয়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- TAB 3: PLAYING SQUADS (TEAM A & TEAM B)   -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'squads'" class="space-y-10" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Team A Squad -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center font-black text-white">
                                {{ mb_substr($match->team_a, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-black text-lg text-white">{{ $match->team_a }}</h3>
                                <span class="text-xs text-slate-400">স্কোয়াড তালিকা</span>
                            </div>
                        </div>
                        @if($match->teamA)
                            <a href="{{ route('public.teams.show', $match->teamA->slug) }}" class="text-xs font-bold text-amber-400 hover:underline">
                                টিম প্রোফাইল ➔
                            </a>
                        @endif
                    </div>

                    <div class="space-y-3">
                        @if($match->teamA && $match->teamA->players->count())
                            @foreach($match->teamA->players as $p)
                                <a href="{{ route('public.players.show', $p->id) }}" class="p-3 bg-slate-950/80 hover:bg-slate-800/80 rounded-2xl border border-slate-800/80 flex items-center justify-between transition group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-xs font-bold text-amber-400 overflow-hidden shrink-0 border border-slate-700">
                                            @if($p->photo)
                                                <img src="{{ asset('storage/' . $p->photo) }}" class="w-full h-full object-cover">
                                            @else
                                                #{{ $p->jersey_no ?? '-' }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm text-white group-hover:text-amber-400 transition flex items-center gap-2">
                                                <span>{{ $p->name }}</span>
                                                @if($p->is_captain)
                                                    <span class="px-1.5 py-0.2 bg-amber-500 text-slate-950 font-black text-[9px] rounded">C</span>
                                                @elseif($p->is_vice_captain)
                                                    <span class="px-1.5 py-0.2 bg-slate-700 text-amber-300 font-bold text-[9px] rounded">VC</span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-slate-400">{{ $p->role ?? 'প্লেয়ার' }}</span>
                                        </div>
                                    </div>
                                    <span class="text-xs text-slate-500 group-hover:text-amber-400 transition font-bold font-mono">
                                        স্ট্যাটস ➔
                                    </span>
                                </a>
                            @endforeach
                        @else
                            <div class="py-8 text-center text-xs text-slate-500">
                                এই দলের বিস্তারিত প্লেয়ার স্কোয়াড যুক্ত করা হয়নি।
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Team B Squad -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center font-black text-white">
                                {{ mb_substr($match->team_b, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-black text-lg text-white">{{ $match->team_b }}</h3>
                                <span class="text-xs text-slate-400">স্কোয়াড তালিকা</span>
                            </div>
                        </div>
                        @if($match->teamB)
                            <a href="{{ route('public.teams.show', $match->teamB->slug) }}" class="text-xs font-bold text-amber-400 hover:underline">
                                টিম প্রোফাইল ➔
                            </a>
                        @endif
                    </div>

                    <div class="space-y-3">
                        @if($match->teamB && $match->teamB->players->count())
                            @foreach($match->teamB->players as $p)
                                <a href="{{ route('public.players.show', $p->id) }}" class="p-3 bg-slate-950/80 hover:bg-slate-800/80 rounded-2xl border border-slate-800/80 flex items-center justify-between transition group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-xs font-bold text-amber-400 overflow-hidden shrink-0 border border-slate-700">
                                            @if($p->photo)
                                                <img src="{{ asset('storage/' . $p->photo) }}" class="w-full h-full object-cover">
                                            @else
                                                #{{ $p->jersey_no ?? '-' }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm text-white group-hover:text-amber-400 transition flex items-center gap-2">
                                                <span>{{ $p->name }}</span>
                                                @if($p->is_captain)
                                                    <span class="px-1.5 py-0.2 bg-amber-500 text-slate-950 font-black text-[9px] rounded">C</span>
                                                @elseif($p->is_vice_captain)
                                                    <span class="px-1.5 py-0.2 bg-slate-700 text-amber-300 font-bold text-[9px] rounded">VC</span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-slate-400">{{ $p->role ?? 'প্লেয়ার' }}</span>
                                        </div>
                                    </div>
                                    <span class="text-xs text-slate-500 group-hover:text-amber-400 transition font-bold font-mono">
                                        স্ট্যাটস ➔
                                    </span>
                                </a>
                            @endforeach
                        @else
                            <div class="py-8 text-center text-xs text-slate-500">
                                এই দলের বিস্তারিত প্লেয়ার স্কোয়াড যুক্ত করা হয়নি।
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Auto Polling JavaScript for Live Score & Commentary -->
    <script>
        const slug = "{{ $match->slug }}";
        const pollUrl = "{{ route('live.api.score', $match->slug) }}";

        function pollLiveScore() {
            fetch(pollUrl)
                .then(res => res.json())
                .then(data => {
                    // Update scores
                    const scoreElem = document.getElementById('live_score_display');
                    if (scoreElem) {
                        scoreElem.innerText = `${data.team_a_score} : ${data.team_b_score}`;
                    }

                    // Update summary
                    const summaryElem = document.getElementById('live_summary_box');
                    if (summaryElem && data.current_summary) {
                        summaryElem.innerText = `⚡ ${data.current_summary}`;
                    }

                    // Update status badge
                    const statusElem = document.getElementById('live_status_badge');
                    if (statusElem) {
                        statusElem.innerText = data.status === 'live' ? '● সরাসরি সম্প্রচার' : (data.status === 'upcoming' ? 'আসন্ন' : 'সমাপ্ত');
                    }

                    // Update commentary
                    if (data.events && data.events.length > 0) {
                        const listElem = document.getElementById('commentary_list');
                        let html = '';
                        data.events.forEach(ev => {
                            html += `
                                <div class="border-l-2 border-rose-500 pl-4 py-1 relative">
                                    <div class="absolute -left-1.5 top-2 w-3 h-3 rounded-full bg-rose-500"></div>
                                    <div class="flex items-center justify-between text-xs text-slate-400">
                                        <span class="font-bold text-rose-400 font-mono">${ev.time_marker || '-'}</span>
                                        <span class="text-[10px]">${ev.created_at}</span>
                                    </div>
                                    ${ev.title ? `<h4 class="font-bold text-sm text-white mt-0.5">${ev.title}</h4>` : ''}
                                    <p class="text-xs text-slate-300 mt-1 leading-relaxed">${ev.description}</p>
                                </div>
                            `;
                        });
                        listElem.innerHTML = html;
                    }
                })
                .catch(err => console.error("Polling error:", err));
        }

        // Poll every 4 seconds
        setInterval(pollLiveScore, 4000);
    </script>
</body>
</html>

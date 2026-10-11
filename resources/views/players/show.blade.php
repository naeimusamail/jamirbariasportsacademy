<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $player->name }} - প্লেয়ার পারফরম্যান্স ও ক্যারিয়ার রেকর্ড | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-rose-500 selection:text-white">
    <!-- Navbar -->
    <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('public.teams.show', $player->team->slug) }}" class="text-xs font-bold text-slate-400 hover:text-white flex items-center gap-1.5 transition">
                    &larr; {{ $player->team->name }} স্কোয়াডে ফিরুন
                </a>
            </div>

            <div class="flex items-center space-x-3 text-xs">
                <a href="{{ route('public.teams.index') }}" class="text-amber-400 hover:text-amber-300 font-bold">
                    🛡️ সকল দল
                </a>
                <a href="{{ route('live.index') }}" class="text-rose-400 hover:text-rose-300 font-bold flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                    ম্যাচ সেন্টার
                </a>
            </div>
        </div>
    </header>

    @php
        $sport = $player->team->sport_type ?? 'cricket';
    @endphp

    <!-- Player Header & Bio -->
    <section class="py-12 bg-gradient-to-b from-slate-900 to-slate-950 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <!-- Player Photo (300x300 Standard) -->
                <div class="relative shrink-0">
                    @if($player->photo)
                        <img src="{{ asset('storage/' . $player->photo) }}" alt="{{ $player->name }}" class="w-40 h-40 sm:w-48 sm:h-48 rounded-3xl object-cover border-4 border-amber-500/40 shadow-2xl shadow-amber-500/10">
                    @else
                        <div class="w-40 h-40 sm:w-48 sm:h-48 rounded-3xl bg-gradient-to-tr from-slate-800 to-slate-700 flex items-center justify-center text-amber-400 font-black text-6xl shadow-2xl border-4 border-amber-500/30">
                            {{ mb_substr($player->name, 0, 1) }}
                        </div>
                    @endif

                    <div class="absolute -bottom-2 -right-2 px-3 py-1 bg-amber-500 text-slate-950 font-mono font-black text-xs sm:text-sm rounded-xl shadow-lg">
                        #{{ $player->jersey_no ?? '00' }}
                    </div>
                </div>

                <!-- Bio Details -->
                <div class="flex-1 text-center md:text-left space-y-3">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                        <a href="{{ route('public.teams.show', $player->team->slug) }}" class="px-3 py-1 text-xs font-bold rounded-lg bg-amber-500/10 text-amber-300 border border-amber-500/20 hover:bg-amber-500 hover:text-slate-950 transition flex items-center gap-1.5">
                            <span>🛡️</span>
                            <span>{{ $player->team->name }} ({{ $player->team->short_name }})</span>
                        </a>

                        @if($player->is_captain)
                            <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-amber-500 text-slate-950 uppercase tracking-wider">
                                👑 CAPTAIN
                            </span>
                        @elseif($player->is_vice_captain)
                            <span class="px-2.5 py-1 text-xs font-black rounded-lg bg-slate-800 text-amber-300 border border-slate-700 uppercase tracking-wider">
                                VICE CAPTAIN
                            </span>
                        @endif

                        <span class="px-3 py-1 text-xs font-bold rounded-lg border {{ $sport == 'football' ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20' : ($sport == 'badminton' ? 'bg-cyan-500/10 text-cyan-300 border-cyan-500/20' : ($sport == 'athletics' ? 'bg-purple-500/10 text-purple-300 border-purple-500/20' : 'bg-teal-500/10 text-teal-300 border-teal-500/20')) }} uppercase">
                            @if($sport == 'football') ⚽ ফুটবল
                            @elseif($sport == 'cricket') 🏏 ক্রিকেট
                            @elseif($sport == 'badminton') 🏸 ব্যাডমিন্টন
                            @elseif($sport == 'athletics') 🏃 অ্যাথলেটিক্স
                            @else {{ strtoupper($sport) }}
                            @endif
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        {{ $player->name }}
                    </h1>

                    <p class="text-sm font-semibold text-slate-400">
                        {{ $player->role ?? 'খেলোয়াড়' }} {{ $player->position ? '• ' . $player->position : '' }}
                    </p>

                    <!-- Technical Specs Grid -->
                    <div class="pt-3 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs max-w-2xl">
                        @if($sport == 'cricket')
                            <div class="bg-slate-900/90 p-3 rounded-2xl border border-slate-800">
                                <span class="text-slate-500 block text-[11px]">ব্যাটিং স্টাইল</span>
                                <span class="font-bold text-white">{{ $player->batting_style ?? 'ডানহাতি ব্যাটার' }}</span>
                            </div>
                            <div class="bg-slate-900/90 p-3 rounded-2xl border border-slate-800">
                                <span class="text-slate-500 block text-[11px]">বোলিং স্টাইল</span>
                                <span class="font-bold text-white">{{ $player->bowling_style ?? '-' }}</span>
                            </div>
                        @else
                            <div class="bg-slate-900/90 p-3 rounded-2xl border border-slate-800">
                                <span class="text-slate-500 block text-[11px]">পজিশন / ইভেন্ট</span>
                                <span class="font-bold text-white">{{ $player->position ?? $player->role }}</span>
                            </div>
                            <div class="bg-slate-900/90 p-3 rounded-2xl border border-slate-800">
                                <span class="text-slate-500 block text-[11px]">খেলার ধরন</span>
                                <span class="font-bold text-white">{{ strtoupper($sport) }}</span>
                            </div>
                        @endif

                        <div class="bg-slate-900/90 p-3 rounded-2xl border border-slate-800">
                            <span class="text-slate-500 block text-[11px]">জার্সি নম্বর</span>
                            <span class="font-bold text-amber-400 font-mono">#{{ $player->jersey_no ?? '-' }}</span>
                        </div>
                        <div class="bg-slate-900/90 p-3 rounded-2xl border border-slate-800">
                            <span class="text-slate-500 block text-[11px]">একাডেমি স্ট্যাটাস</span>
                            <span class="font-bold text-emerald-400">{{ $player->trainee ? 'অফিশিয়াল ট্রেইনি' : 'টিম প্লেয়ার' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Career Highlights Ticker (Multi-Sport Dynamic) -->
    <div class="bg-slate-900/80 border-b border-slate-800 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($sport == 'football')
                <!-- FOOTBALL TICKER -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 text-center">
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">ম্যাচ</span>
                        <span class="text-2xl font-black font-mono text-white">{{ $careerStats->matches }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-emerald-400 block tracking-wider">মোট গোল</span>
                        <span class="text-2xl font-black font-mono text-emerald-400">{{ $careerStats->goals }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-amber-400 block tracking-wider">অ্যাসিস্ট</span>
                        <span class="text-2xl font-black font-mono text-amber-400">{{ $careerStats->assists }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-cyan-400 block tracking-wider">মিনিট খেলা</span>
                        <span class="text-2xl font-black font-mono text-cyan-400">{{ $careerStats->minutes_played }}'</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-teal-400 block tracking-wider">ক্লিন শিট</span>
                        <span class="text-2xl font-black font-mono text-teal-400">{{ $careerStats->clean_sheets }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-rose-400 block tracking-wider">কার্ড (হলুদ/লাল)</span>
                        <span class="text-2xl font-black font-mono text-rose-400">{{ $careerStats->yellow_cards }}/{{ $careerStats->red_cards }}</span>
                    </div>
                </div>
            @elseif($sport == 'badminton')
                <!-- BADMINTON TICKER -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">ম্যাচ</span>
                        <span class="text-2xl font-black font-mono text-white">{{ $careerStats->matches }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-cyan-400 block tracking-wider">সেট জয়</span>
                        <span class="text-2xl font-black font-mono text-cyan-400">{{ $careerStats->sets_won }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-amber-400 block tracking-wider">মোট পয়েন্ট</span>
                        <span class="text-2xl font-black font-mono text-amber-400">{{ $careerStats->points_scored }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-emerald-400 block tracking-wider">অ্যাক্টিভ স্ট্যাটাস</span>
                        <span class="text-2xl font-black font-mono text-emerald-400">শীর্ষ শাটলার</span>
                    </div>
                </div>
            @elseif($sport == 'athletics')
                <!-- ATHLETICS TICKER -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">অংশগ্রহণ</span>
                        <span class="text-2xl font-black font-mono text-white">{{ $careerStats->matches }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-purple-400 block tracking-wider">সেরা টাইমিং (PB)</span>
                        <span class="text-2xl font-black font-mono text-purple-400">{{ $careerStats->best_timing }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-amber-400 block tracking-wider">শীর্ষ অর্জন / মেডেল</span>
                        <span class="text-xl font-black font-mono text-amber-400">{{ $careerStats->top_rank }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-emerald-400 block tracking-wider">শৃঙ্খলা</span>
                        <span class="text-2xl font-black font-mono text-emerald-400">ট্র্যাক অ্যান্ড ফিল্ড</span>
                    </div>
                </div>
            @else
                <!-- CRICKET TICKER -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 text-center">
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">ম্যাচ</span>
                        <span class="text-2xl font-black font-mono text-white">{{ $careerStats->matches }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-amber-400 block tracking-wider">মোট রান</span>
                        <span class="text-2xl font-black font-mono text-amber-400">{{ $careerStats->runs }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">সর্বোচ্চ স্কোর</span>
                        <span class="text-2xl font-black font-mono text-white">{{ $careerStats->highest_score }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-teal-400 block tracking-wider">স্ট্রাইক রেট</span>
                        <span class="text-2xl font-black font-mono text-teal-400">{{ $careerStats->strike_rate }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-rose-400 block tracking-wider">মোট উইকেট</span>
                        <span class="text-2xl font-black font-mono text-rose-400">{{ $careerStats->wickets }}</span>
                    </div>
                    <div class="bg-slate-950/80 p-3.5 rounded-2xl border border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-emerald-400 block tracking-wider">সেরা বোলিং</span>
                        <span class="text-2xl font-black font-mono text-emerald-400">{{ $careerStats->best_bowling }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Sport-Specific Performance Tables -->
    <main class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        @if($sport == 'football' || $careerStats->goals > 0 || $careerStats->assists > 0)
            <!-- FOOTBALL CAREER RECORD TABLE -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <span>⚽</span> ফুটবল ক্যারিয়ার রেকর্ড (Football Career Stats)
                    </h3>
                    <span class="text-xs font-mono text-emerald-400 font-bold bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-xl">
                        গোল, অ্যাসিস্ট ও শৃঙ্খলা
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                <th class="py-3 px-3">দল</th>
                                <th class="py-3 px-2 text-center">ম্যাচ</th>
                                <th class="py-3 px-2 text-center font-bold text-emerald-400">গোল (Goals)</th>
                                <th class="py-3 px-2 text-center font-bold text-amber-400">অ্যাসিস্ট (Assists)</th>
                                <th class="py-3 px-2 text-center">মিনিট খেলা</th>
                                <th class="py-3 px-2 text-center text-amber-300">হলুদ কার্ড (🟨)</th>
                                <th class="py-3 px-2 text-center text-rose-400">লাল কার্ড (🟥)</th>
                                <th class="py-3 px-2 text-center text-teal-400">ক্লিন শিট (🧤)</th>
                                <th class="py-3 px-2 text-center">গোল অবদান/ম্যাচ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80 font-mono">
                            <tr class="hover:bg-slate-850/50">
                                <td class="py-4 px-3 font-bold text-white font-sans flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                    {{ $player->team->name }}
                                </td>
                                <td class="py-4 px-2 text-center text-slate-200">{{ $careerStats->matches }}</td>
                                <td class="py-4 px-2 text-center font-black text-emerald-400 text-base">{{ $careerStats->goals }}</td>
                                <td class="py-4 px-2 text-center font-black text-amber-400 text-base">{{ $careerStats->assists }}</td>
                                <td class="py-4 px-2 text-center text-slate-300">{{ $careerStats->minutes_played }}'</td>
                                <td class="py-4 px-2 text-center font-bold text-amber-300">{{ $careerStats->yellow_cards }}</td>
                                <td class="py-4 px-2 text-center font-bold text-rose-400">{{ $careerStats->red_cards }}</td>
                                <td class="py-4 px-2 text-center font-bold text-teal-400">{{ $careerStats->clean_sheets }}</td>
                                <td class="py-4 px-2 text-center font-bold text-white">
                                    {{ $careerStats->matches > 0 ? round(($careerStats->goals + $careerStats->assists) / $careerStats->matches, 2) : 0 }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($sport == 'badminton' || $careerStats->sets_won > 0)
            <!-- BADMINTON CAREER RECORD TABLE -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <span>🏸</span> ব্যাডমিন্টন ক্যারিয়ার রেকর্ড (Badminton Career Stats)
                    </h3>
                    <span class="text-xs font-mono text-cyan-400 font-bold bg-cyan-500/10 border border-cyan-500/20 px-3 py-1 rounded-xl">
                        সেট ও পয়েন্ট তালিকা
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                <th class="py-3 px-3">দল</th>
                                <th class="py-3 px-2 text-center">ম্যাচ সংখ্যা</th>
                                <th class="py-3 px-2 text-center font-bold text-cyan-400">সেট জয় (Sets)</th>
                                <th class="py-3 px-2 text-center font-bold text-amber-400">মোট অর্জিত পয়েন্ট (Points)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80 font-mono">
                            <tr class="hover:bg-slate-850/50">
                                <td class="py-4 px-3 font-bold text-white font-sans flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                    {{ $player->team->name }}
                                </td>
                                <td class="py-4 px-2 text-center text-slate-200">{{ $careerStats->matches }}</td>
                                <td class="py-4 px-2 text-center font-black text-cyan-400 text-base">{{ $careerStats->sets_won }}</td>
                                <td class="py-4 px-2 text-center font-black text-amber-400 text-base">{{ $careerStats->points_scored }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($sport == 'athletics' || $careerStats->best_timing != '-')
            <!-- ATHLETICS RECORD TABLE -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <span>🏃</span> অ্যাথলেটিক্স ও ট্র্যাক রেকর্ড (Athletics Records)
                    </h3>
                    <span class="text-xs font-mono text-purple-400 font-bold bg-purple-500/10 border border-purple-500/20 px-3 py-1 rounded-xl">
                        টাইমিং ও পজিশন
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 text-center">
                        <span class="text-xs text-slate-400 block font-bold">ইভেন্ট অংশগ্রহণ</span>
                        <span class="text-2xl font-black text-white font-mono">{{ $careerStats->matches }}</span>
                    </div>
                    <div class="bg-purple-950/40 p-4 rounded-2xl border border-purple-500/20 text-center">
                        <span class="text-xs text-purple-400 block font-bold">সেরা টাইমিং (Personal Best)</span>
                        <span class="text-2xl font-black text-purple-400 font-mono">{{ $careerStats->best_timing }}</span>
                    </div>
                    <div class="bg-amber-950/40 p-4 rounded-2xl border border-amber-500/20 text-center">
                        <span class="text-xs text-amber-400 block font-bold">শীর্ষ পজিশন / মেডেল</span>
                        <span class="text-2xl font-black text-amber-400 font-mono">{{ $careerStats->top_rank }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if($sport == 'cricket' || $careerStats->runs > 0 || $careerStats->wickets > 0)
            <!-- CRICKET BATTING & FIELDING STATS TABLE -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <span>🏏</span> ক্রিকেট ব্যাটিং ও ফিল্ডিং ক্যারিয়ার রেকর্ড (Batting Stats)
                    </h3>
                    <span class="text-xs font-mono text-amber-400 font-bold bg-amber-500/10 border border-amber-500/20 px-3 py-1 rounded-xl">
                        ক্রিকইনফো স্টাইল ক্যারিয়ার
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                <th class="py-3 px-3">ফরমেট / দল</th>
                                <th class="py-3 px-2 text-center">ম্যাচ (Mat)</th>
                                <th class="py-3 px-2 text-center">ইনিংস (Inns)</th>
                                <th class="py-3 px-2 text-center">নট আউট (NO)</th>
                                <th class="py-3 px-2 text-center font-bold text-amber-400">রান (Runs)</th>
                                <th class="py-3 px-2 text-center">সর্বোচ্চ (HS)</th>
                                <th class="py-3 px-2 text-center">গড় (Avg)</th>
                                <th class="py-3 px-2 text-center">বল (BF)</th>
                                <th class="py-3 px-2 text-center text-teal-400">স্ট্রাইক রেট (SR)</th>
                                <th class="py-3 px-2 text-center text-amber-300">১০০ (100)</th>
                                <th class="py-3 px-2 text-center text-amber-300">৫০ (50)</th>
                                <th class="py-3 px-2 text-center">৪ (4s)</th>
                                <th class="py-3 px-2 text-center">৬ (6s)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80 font-mono">
                            <tr class="hover:bg-slate-850/50">
                                <td class="py-4 px-3 font-bold text-white font-sans flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                    {{ $player->team->name }}
                                </td>
                                <td class="py-4 px-2 text-center text-slate-200">{{ $careerStats->matches }}</td>
                                <td class="py-4 px-2 text-center text-slate-200">{{ $careerStats->innings }}</td>
                                <td class="py-4 px-2 text-center text-slate-300">{{ $careerStats->not_outs }}</td>
                                <td class="py-4 px-2 text-center font-black text-amber-400 text-base">{{ $careerStats->runs }}</td>
                                <td class="py-4 px-2 text-center font-bold text-white">{{ $careerStats->highest_score }}</td>
                                <td class="py-4 px-2 text-center font-bold text-emerald-400">{{ $careerStats->batting_avg }}</td>
                                <td class="py-4 px-2 text-center text-slate-300">{{ $careerStats->balls }}</td>
                                <td class="py-4 px-2 text-center font-bold text-teal-400">{{ $careerStats->strike_rate }}</td>
                                <td class="py-4 px-2 text-center font-bold text-amber-300">{{ $careerStats->hundreds }}</td>
                                <td class="py-4 px-2 text-center font-bold text-amber-300">{{ $careerStats->fifties }}</td>
                                <td class="py-4 px-2 text-center text-slate-300">{{ $careerStats->fours }}</td>
                                <td class="py-4 px-2 text-center text-rose-400 font-bold">{{ $careerStats->sixes }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CRICKET BOWLING STATS TABLE -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <span>🎯</span> ক্রিকেট বোলিং ক্যারিয়ার রেকর্ড (Bowling Stats)
                    </h3>
                    <span class="text-xs font-mono text-rose-400 font-bold bg-rose-500/10 border border-rose-500/20 px-3 py-1 rounded-xl">
                        উইকেট ও বোলিং পারফরম্যান্স
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                                <th class="py-3 px-3">ফরমেট / দল</th>
                                <th class="py-3 px-2 text-center">ম্যাচ (Mat)</th>
                                <th class="py-3 px-2 text-center">ওভার (Overs)</th>
                                <th class="py-3 px-2 text-center">মেডেন (Mdn)</th>
                                <th class="py-3 px-2 text-center">রান খরচ (Runs)</th>
                                <th class="py-3 px-2 text-center font-bold text-rose-400">উইকেট (Wkts)</th>
                                <th class="py-3 px-2 text-center text-emerald-400">সেরা বোলিং (BBI)</th>
                                <th class="py-3 px-2 text-center text-teal-400">ইকোনমি (Econ)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80 font-mono">
                            <tr class="hover:bg-slate-850/50">
                                <td class="py-4 px-3 font-bold text-white font-sans flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    {{ $player->team->name }}
                                </td>
                                <td class="py-4 px-2 text-center text-slate-200">{{ $careerStats->matches }}</td>
                                <td class="py-4 px-2 text-center text-slate-200">{{ $careerStats->overs }}</td>
                                <td class="py-4 px-2 text-center text-slate-300">{{ $careerStats->maidens }}</td>
                                <td class="py-4 px-2 text-center text-slate-300">{{ $careerStats->runs_conceded }}</td>
                                <td class="py-4 px-2 text-center font-black text-rose-400 text-base">{{ $careerStats->wickets }}</td>
                                <td class="py-4 px-2 text-center font-bold text-emerald-400">{{ $careerStats->best_bowling }}</td>
                                <td class="py-4 px-2 text-center font-bold text-teal-400">{{ $careerStats->economy }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- RECENT MATCH-BY-MATCH BREAKDOWN TABLE -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <span>📊</span> ম্যাচ পারফরম্যান্স লগ ও ইতিহাস (Match Log Archive)
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">প্রতিটি ম্যাচে এই খেলোয়াড়ের অবদান ও রেকর্ড</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider font-mono">
                            <th class="py-3 px-3">তারিখ ও ম্যাচ</th>
                            <th class="py-3 px-2 text-center">খেলা / ইনিংস</th>
                            <th class="py-3 px-3">প্রধান পারফরম্যান্স</th>
                            <th class="py-3 px-3">অন্যান্য অবদান / শৃঙ্খলা</th>
                            <th class="py-3 px-2 text-center">ইম্প্যাক্ট / অ্যাওয়ার্ড</th>
                            <th class="py-3 px-3 text-right">ম্যাচ পেজ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @forelse($matchLogs as $log)
                            <tr class="hover:bg-slate-850/50">
                                <td class="py-4 px-3">
                                    <div class="font-bold text-white">{{ $log->liveMatch->title ?? 'ম্যাচ' }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">
                                        {{ $log->liveMatch->match_datetime ? \Carbon\Carbon::parse($log->liveMatch->match_datetime)->format('d M, Y') : '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-center font-mono font-bold text-slate-300">
                                    {{ strtoupper($log->liveMatch->sport_type ?? $sport) }} • #{{ $log->inning }}
                                </td>
                                <td class="py-4 px-3">
                                    @if(($log->liveMatch && $log->liveMatch->sport_type == 'football') || $log->goals > 0 || $log->assists > 0)
                                        <div class="font-mono text-emerald-400 font-bold text-sm">
                                            ⚽ {{ $log->goals }} গোল, {{ $log->assists }} অ্যাসিস্ট
                                        </div>
                                        <div class="text-[11px] text-slate-400">
                                            {{ $log->minutes_played }} মিনিট খেলা
                                        </div>
                                    @elseif(($log->liveMatch && $log->liveMatch->sport_type == 'badminton') || $log->sets_won > 0)
                                        <div class="font-mono text-cyan-400 font-bold text-sm">
                                            🏸 {{ $log->sets_won }} সেট জয়
                                        </div>
                                        <div class="text-[11px] text-slate-400">
                                            {{ $log->points_scored }} পয়েন্ট
                                        </div>
                                    @elseif(($log->liveMatch && $log->liveMatch->sport_type == 'athletics') || $log->timing_record)
                                        <div class="font-mono text-purple-400 font-bold text-sm">
                                            ⏱️ {{ $log->timing_record }}
                                        </div>
                                        <div class="text-[11px] text-slate-400">
                                            {{ $log->position_rank }}
                                        </div>
                                    @else
                                        <div class="font-mono">
                                            <span class="font-black text-amber-400 text-sm">{{ $log->runs_scored }}</span>
                                            <span class="text-slate-400 text-xs">({{ $log->balls_faced }}b, {{ $log->fours }}x4, {{ $log->sixes }}x6)</span>
                                        </div>
                                        <div class="text-[11px] text-slate-400 capitalize">
                                            {{ $log->dismissal_type ?? 'নট আউট' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-3">
                                    @if($log->overs_bowled > 0)
                                        <div class="font-mono">
                                            <span class="font-bold text-rose-400 text-sm">{{ $log->wickets_taken }}/{{ $log->runs_conceded }}</span>
                                            <span class="text-slate-400 text-xs">({{ $log->overs_bowled }} ov, Econ: {{ $log->economy_rate }})</span>
                                        </div>
                                    @elseif($log->yellow_cards > 0 || $log->red_cards > 0)
                                        <div class="text-xs">
                                            @if($log->yellow_cards > 0)<span class="text-amber-400 font-bold mr-1">🟨 {{ $log->yellow_cards }}</span>@endif
                                            @if($log->red_cards > 0)<span class="text-rose-400 font-bold">🟥 {{ $log->red_cards }}</span>@endif
                                        </div>
                                    @elseif($log->clean_sheet)
                                        <span class="text-xs text-teal-400 font-bold">🧤 ক্লিন শিট</span>
                                    @else
                                        <span class="text-slate-500 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-2 text-center">
                                    @if($log->is_player_of_match)
                                        <span class="px-2.5 py-1 rounded-lg bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] font-black tracking-wide">
                                            ⭐ MATCH MVP
                                        </span>
                                    @else
                                        <span class="text-slate-500 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-3 text-right">
                                    @if($log->liveMatch)
                                        <a href="{{ route('live.show', $log->liveMatch->slug) }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-lg text-xs font-semibold transition">
                                            ম্যাচ সেন্টার ➔
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-500 text-xs">
                                    এখনো কোনো ম্যাচ রেকর্ড যোগ করা হয়নি। খেলা অনুষ্ঠিত হলে স্কোরার রেকর্ড এখানে প্রদর্শিত হবে।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($matchLogs->hasPages())
                <div class="mt-6">
                    {{ $matchLogs->links() }}
                </div>
            @endif
        </div>

        <!-- ============================================================== -->
        <!-- 📸 PLAYER MOMENTS & PROMO PHOTO GALLERY SHOWCASE -->
        <!-- ============================================================== -->
        @if(isset($galleries) && $galleries->count() > 0)
            <div x-data="{
                activeCategory: 'all',
                lightboxPhoto: null
            }" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-5">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full bg-rose-500/10 text-rose-400 font-bold text-xs border border-rose-500/20 flex items-center gap-1.5">
                                <span>📸</span> অ্যাকশন মোমেন্টস ও প্রোমো অ্যালবাম
                            </span>
                            <span class="text-xs text-slate-400">মোট ছবি: <strong class="text-white">{{ $galleries->count() }}টি</strong></span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white mt-1.5 flex items-center gap-2">
                            <span>মাঠের স্মরণীয় মুহূর্ত ও অফিসিয়াল মিডিয়া শুট</span> 🌟
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $player->name }} এর গৌরবময় গোল/উইকেট উদযাপন, ট্রেনিং প্রস্তুতি ও স্পোর্টস প্রোমো কালেকশন
                        </p>
                    </div>

                    <!-- Category Filter Tabs -->
                    <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
                        <button @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-amber-500 text-slate-950 shadow' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'" class="px-3.5 py-1.5 rounded-xl transition">
                            সবগুলো ({{ $galleries->count() }})
                        </button>
                        <button @click="activeCategory = 'match_action'" :class="activeCategory === 'match_action' ? 'bg-rose-600 text-white shadow' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1">
                            <span>⚽🏏</span> ম্যাচ অ্যাকশন ({{ $galleries->where('category', 'match_action')->count() }})
                        </button>
                        <button @click="activeCategory = 'training'" :class="activeCategory === 'training' ? 'bg-emerald-600 text-white shadow' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1">
                            <span>🏃</span> ট্রেনিং মুহূর্ত ({{ $galleries->where('category', 'training')->count() }})
                        </button>
                        <button @click="activeCategory = 'celebration'" :class="activeCategory === 'celebration' ? 'bg-amber-600 text-white shadow' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1">
                            <span>🏆</span> উদযাপন ও ট্রফি ({{ $galleries->where('category', 'celebration')->count() }})
                        </button>
                        <button @click="activeCategory = 'promo'" :class="activeCategory === 'promo' ? 'bg-cyan-600 text-white shadow' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1">
                            <span>🌟</span> প্রোমো ও পোর্ট্রেট ({{ $galleries->where('category', 'promo')->count() }})
                        </button>
                    </div>
                </div>

                <!-- Photos Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                    @foreach($galleries as $photo)
                        <div x-show="activeCategory === 'all' || activeCategory === '{{ $photo->category }}'" class="group relative rounded-2xl overflow-hidden bg-slate-950 border border-slate-800 hover:border-amber-500/50 transition duration-300 flex flex-col justify-between shadow-lg">
                            
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

                                <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <span class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-lg shadow-lg">
                                        🔍
                                    </span>
                                </div>
                            </div>

                            <!-- Photo Details & Caption -->
                            <div class="p-4 bg-slate-900 space-y-2 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-white line-clamp-1 group-hover:text-amber-400 transition">
                                        {{ $photo->title }}
                                    </h4>
                                    @if($photo->description)
                                        <p class="text-xs text-slate-400 line-clamp-2 mt-1 leading-relaxed">
                                            {{ $photo->description }}
                                        </p>
                                    @endif
                                </div>

                                <div class="pt-2 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                                    <span class="truncate">
                                        @if($photo->match_name)
                                            🏆 {{ $photo->match_name }}
                                        @elseif($photo->event_date)
                                            📅 {{ $photo->event_date->format('d M, Y') }}
                                        @else
                                            📸 একাডেমি কালেকশন
                                        @endif
                                    </span>
                                    <span class="text-amber-400 font-bold group-hover:underline cursor-pointer" @click="lightboxPhoto = {
                                        url: '{{ $photo->image_url }}',
                                        title: '{{ addslashes($photo->title) }}',
                                        desc: '{{ addslashes($photo->description ?? '') }}',
                                        category: '{{ $photo->category_label }}',
                                        match: '{{ addslashes($photo->match_name ?? '') }}',
                                        date: '{{ $photo->event_date ? $photo->event_date->format('d M, Y') : '' }}',
                                        featured: {{ $photo->is_featured ? 'true' : 'false' }}
                                    }">
                                        ভিউ ➔
                                    </span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- LIGHTBOX PREVIEW MODAL -->
                <div x-show="lightboxPhoto" x-transition.opacity class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex items-center justify-center p-4" style="display: none;" @keydown.escape.window="lightboxPhoto = null">
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
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30" x-text="lightboxPhoto?.category"></span>
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
                                        <a :href="lightboxPhoto?.url" target="_blank" class="text-xs text-amber-400 hover:underline flex items-center gap-1 font-bold">
                                            <span>আসল সাইজে ছবি দেখুন ↗</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-900/50 py-10 mt-16 text-center text-xs text-slate-500">
        <p>© {{ date('Y') }} জামিরবাড়িয়া স্পোর্টস একাডেমি • {{ $player->name }} মাল্টি-স্পোর্টস পারফরম্যান্স প্রোফাইল</p>
    </footer>
</body>
</html>

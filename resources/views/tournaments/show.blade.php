<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tournament->name }} | টুর্নামেন্ট বিস্তারিত | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-amber-500 selection:text-slate-950">

    <!-- Top Navbar -->
    <header class="border-b border-slate-800/80 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-2 sm:gap-4">
            <a href="{{ route('public.tournaments.index') }}" class="flex items-center space-x-2 sm:space-x-3 min-w-0 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 flex items-center justify-center text-slate-950 font-black text-xl shadow shrink-0">
                    🏆
                </div>
                <div class="min-w-0">
                    <span class="text-sm xs:text-base font-black tracking-tight text-white block leading-tight truncate max-w-[140px] xs:max-w-[200px] sm:max-w-none">জামিরবাড়িয়া টুর্নামেন্ট</span>
                    <span class="text-[8px] xs:text-[9px] uppercase tracking-widest text-amber-400 font-bold block truncate max-w-[140px] xs:max-w-none">&larr; সকল টুর্নামেন্টে ফিরুন</span>
                </div>
            </a>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="{{ route('live.index') }}" class="px-2.5 sm:px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-xs transition shadow flex items-center gap-1.5 whitespace-nowrap">
                    <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                    <span><span class="hidden sm:inline">লাইভ </span>ম্যাচ</span>
                </a>
                <a href="{{ route('public.local-players.create') }}" class="px-2.5 sm:px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-xs transition shadow whitespace-nowrap">
                    🌟 <span class="hidden sm:inline">লোকাল প্লেয়ার </span>নিবন্ধন
                </a>
            </div>
        </div>
    </header>

    <!-- Tournament Hero Banner -->
    <section class="py-12 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-950 border-b border-slate-800 relative overflow-hidden">
        <div class="absolute top-0 right-1/4 w-[500px] h-[300px] bg-amber-500/10 blur-[130px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-2">
                        @if($tournament->tournament_type === 'academic')
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-500 text-slate-950 shadow">
                                🎓 একাডেমি টুর্নামেন্ট (Intra-Academy)
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-gradient-to-r from-amber-500 to-rose-500 text-slate-950 shadow">
                                🌟 উন্মুক্ত / লোকাল টুর্নামেন্ট (Open Community)
                            </span>
                        @endif

                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-white uppercase">
                            {{ $tournament->sport_type }}
                        </span>

                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $tournament->status_badge['class'] }}">
                            {{ $tournament->status_badge['label'] }}
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        {{ $tournament->name }}
                    </h1>

                    <p class="text-slate-300 text-sm max-w-2xl leading-relaxed">
                        {{ $tournament->description ?? 'জামিরবাড়িয়া স্পোর্টস একাডেমি আয়োজিত অফিশিয়াল চ্যাম্পিয়নশিপ।' }}
                    </p>

                    <div class="flex flex-wrap items-center gap-6 pt-2 text-xs text-slate-300">
                        <div>
                            <span class="text-slate-400 block text-[10px]">ভেন্যু:</span>
                            <strong class="text-white text-sm">📍 {{ $tournament->venue }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">টুর্নামেন্ট সময়সূচি:</span>
                            <span class="font-mono text-white text-sm">{{ $tournament->start_date ? $tournament->start_date->format('d M, Y') : '-' }} হতে {{ $tournament->end_date ? $tournament->end_date->format('d M, Y') : '-' }}</span>
                        </div>
                        @if($tournament->registration_deadline)
                            <div>
                                <span class="text-amber-400 block text-[10px] font-bold">রেজিস্ট্রেশনের শেষ সময়:</span>
                                <span class="font-mono text-amber-300 text-sm font-bold">⏰ {{ $tournament->registration_deadline->format('d M, Y - h:i A') }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="text-slate-400 block text-[10px]">পুরস্কার পুল:</span>
                            <strong class="text-amber-400 text-sm">🏆 {{ $tournament->prize_pool ?? 'ট্রফি ও সম্মাননা' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 shrink-0">
                    @if($tournament->isRegistrationOpen())
                        <a href="{{ route('public.tournaments.register', $tournament->slug) }}" class="px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black rounded-2xl text-xs sm:text-sm text-center shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-2">
                            <span>📝</span>
                            <span>টুর্নামেন্টে প্লেয়ার নিবন্ধন করুন</span>
                        </a>
                        @if($tournament->registration_deadline)
                            <div class="text-[11px] text-amber-400 text-center font-mono">
                                ⏳ শেষ সময়: {{ $tournament->registration_deadline->format('d M, h:i A') }}
                            </div>
                        @endif
                    @elseif($tournament->isRegistrationUpcoming())
                        <div class="px-6 py-3 bg-slate-800 text-amber-400 border border-amber-500/30 font-bold rounded-2xl text-xs sm:text-sm text-center">
                            ⏳ নিবন্ধন শুরু: {{ $tournament->registration_start_date ? $tournament->registration_start_date->format('d M Y, h:i A') : 'শীঘ্রই' }}
                        </div>
                    @else
                        <div class="px-6 py-3 bg-slate-800 text-rose-400 border border-rose-500/30 font-bold rounded-2xl text-xs sm:text-sm text-center">
                            ⛔ নিবন্ধনের সময় শেষ হয়েছে
                        </div>
                    @endif

                    <a href="{{ route('live.index') }}" class="px-6 py-3 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-2xl text-xs sm:text-sm text-center shadow-lg shadow-rose-600/30 transition flex items-center justify-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        <span>সরাসরি ম্যাচ স্কোরকার্ড দেখুন</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Tabs -->
    <main class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- 1. Points Table / Group Standings -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-black text-white flex items-center gap-2">
                    <span>📊</span> পয়েন্ট টেবিল ও দলীয় অবস্থান (Points Table)
                </h2>
                <span class="text-xs text-slate-400">মোট {{ $tournament->tournamentTeams->count() }}টি দল অন্তর্ভুক্ত</span>
            </div>

            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-950 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4">অবস্থান / দল</th>
                                <th class="px-4 py-4 text-center">গ্রুপ</th>
                                <th class="px-4 py-4 text-center">ম্যাচ</th>
                                <th class="px-4 py-4 text-center">জয়</th>
                                <th class="px-4 py-4 text-center">পরাজয়</th>
                                <th class="px-4 py-4 text-center">ড্র</th>
                                <th class="px-6 py-4 text-right">পয়েন্ট</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($tournament->tournamentTeams as $idx => $tt)
                                <tr class="hover:bg-slate-800/40 transition">
                                    <td class="px-6 py-4 flex items-center gap-3 font-bold text-white">
                                        <span class="w-6 text-slate-500 font-mono">{{ $idx + 1 }}</span>
                                        <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-sm shrink-0 overflow-hidden">
                                            @if($tt->team->logo)
                                                <img src="{{ asset('storage/' . $tt->team->logo) }}" alt="" class="w-full h-full object-cover">
                                            @else
                                                ⚽
                                            @endif
                                        </div>
                                        <a href="{{ route('public.teams.show', $tt->team->slug) }}" class="hover:text-emerald-400 transition">
                                            {{ $tt->team->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-center font-semibold text-slate-400">{{ $tt->group_name }}</td>
                                    <td class="px-4 py-4 text-center font-mono font-bold">{{ $tt->matches_played }}</td>
                                    <td class="px-4 py-4 text-center font-mono text-emerald-400 font-bold">{{ $tt->won }}</td>
                                    <td class="px-4 py-4 text-center font-mono text-rose-400 font-bold">{{ $tt->lost }}</td>
                                    <td class="px-4 py-4 text-center font-mono text-slate-400">{{ $tt->drawn }}</td>
                                    <td class="px-6 py-4 text-right font-mono font-black text-amber-400 text-sm">{{ $tt->points }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                        এই টুর্নামেন্টে এখনও কোনো দল যুক্ত করা হয়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 2. Match Fixtures & Live Scores -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-black text-white flex items-center gap-2">
                    <span>📅</span> ম্যাচ শিডিউল ও লাইভ ফলাফল (Fixtures & Results)
                </h2>
                <a href="{{ route('live.index') }}" class="text-xs text-rose-400 hover:underline font-bold">
                    সকল লাইভ ম্যাচ &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($tournament->matches as $m)
                    <div class="bg-slate-900/90 border border-slate-800 hover:border-slate-700 rounded-3xl p-5 shadow-xl space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-mono">{{ $m->match_datetime ? \Carbon\Carbon::parse($m->match_datetime)->format('d M, h:i A') : 'শীঘ্রই' }}</span>
                            @if($m->status === 'live')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-500/20 text-rose-400 border border-rose-500/40 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span> লাইভ
                                </span>
                            @elseif($m->status === 'finished')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-800 text-slate-400">
                                    সমাপ্ত
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400">
                                    আসন্ন
                                </span>
                            @endif
                        </div>

                        <!-- Scoreboard Row -->
                        <div class="grid grid-cols-5 items-center gap-2 text-center">
                            <div class="col-span-2 text-left">
                                <h4 class="font-bold text-white text-sm truncate">{{ $m->team_a }}</h4>
                                <span class="font-mono font-black text-amber-400 text-base">{{ $m->team_a_score }}</span>
                            </div>
                            <div class="text-xs font-black text-slate-500">VS</div>
                            <div class="col-span-2 text-right">
                                <h4 class="font-bold text-white text-sm truncate">{{ $m->team_b }}</h4>
                                <span class="font-mono font-black text-amber-400 text-base">{{ $m->team_b_score }}</span>
                            </div>
                        </div>

                        @if($m->current_summary)
                            <div class="text-[11px] bg-slate-950 p-2.5 rounded-xl text-slate-300 border border-slate-800/80">
                                {{ $m->current_summary }}
                            </div>
                        @endif

                        <div class="pt-2 flex items-center justify-between text-xs">
                            <span class="text-slate-500 text-[11px]">📍 {{ $m->venue }}</span>
                            <a href="{{ route('live.show', $m->slug) }}" class="text-rose-400 hover:text-rose-300 font-bold">
                                স্কোরকার্ড &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-10 text-center bg-slate-900/50 rounded-3xl border border-slate-800 text-slate-500 text-xs">
                        এখনও এই টুর্নামেন্টের কোনো ম্যাচ নির্ধারণ করা হয়নি।
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 3. Tournament Leaderboard & Top Performers -->
        @php
            $topBatsmen = $tournament->topBatsmen;
            $topBowlers = $tournament->topBowlers;
            $topScorers = $tournament->topGoalScorers;
        @endphp

        @if($topBatsmen->count() > 0 || $topBowlers->count() > 0 || $topScorers->count() > 0)
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-black text-white flex items-center gap-2">
                        <span>🌟</span> টুর্নামেন্ট লিডারবোর্ড ও শীর্ষ পারফর্মার (Leaderboard)
                    </h2>
                    <span class="text-xs text-amber-400 font-bold">অটো-আপডেটেড স্ট্যাটস</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if($tournament->sport_type === 'cricket' || $topBatsmen->count() > 0)
                        <!-- Top Batsmen (Orange Cap / Most Runs) -->
                        <div class="bg-gradient-to-b from-amber-950/30 to-slate-900 border border-amber-500/30 rounded-3xl p-5 shadow-xl space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-amber-500/20">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">🏏</span>
                                    <div>
                                        <h3 class="text-sm font-black text-white">সর্বোচ্চ রান সংগ্রাহক</h3>
                                        <span class="text-[10px] text-amber-400 font-bold uppercase tracking-wider">Top Run Scorers</span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-bold">কমলা ক্যাপ</span>
                            </div>
                            <div class="space-y-2">
                                @forelse($topBatsmen as $rank => $stat)
                                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-950/60 border border-slate-800">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-5 text-center font-mono font-bold text-xs {{ $rank === 0 ? 'text-amber-400 font-black' : 'text-slate-500' }}">#{{ $rank + 1 }}</span>
                                            <div>
                                                <h4 class="text-xs font-bold text-white">{{ $stat->player->name ?? 'প্লেয়ার' }}</h4>
                                                <span class="text-[10px] text-slate-400">{{ $stat->team->name ?? '' }} • {{ $stat->matches_played }} ম্যাচ</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono font-black text-amber-400 text-sm">{{ $stat->total_runs }}</span>
                                            <span class="text-[10px] text-slate-500 block">4s: {{ $stat->total_fours }} | 6s: {{ $stat->total_sixes }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-xs text-slate-500">এখনও কোনো ব্যাটিং রেকর্ড এন্ট্রি হয়নি।</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Top Bowlers (Purple Cap / Most Wickets) -->
                        <div class="bg-gradient-to-b from-purple-950/30 to-slate-900 border border-purple-500/30 rounded-3xl p-5 shadow-xl space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-purple-500/20">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">🎯</span>
                                    <div>
                                        <h3 class="text-sm font-black text-white">সর্বোচ্চ উইকেট শিকারী</h3>
                                        <span class="text-[10px] text-purple-400 font-bold uppercase tracking-wider">Top Wicket Takers</span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full bg-purple-500/20 text-purple-300 text-[10px] font-bold">পার্পল ক্যাপ</span>
                            </div>
                            <div class="space-y-2">
                                @forelse($topBowlers as $rank => $stat)
                                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-950/60 border border-slate-800">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-5 text-center font-mono font-bold text-xs {{ $rank === 0 ? 'text-purple-400 font-black' : 'text-slate-500' }}">#{{ $rank + 1 }}</span>
                                            <div>
                                                <h4 class="text-xs font-bold text-white">{{ $stat->player->name ?? 'প্লেয়ার' }}</h4>
                                                <span class="text-[10px] text-slate-400">{{ $stat->team->name ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono font-black text-purple-400 text-sm">{{ $stat->total_wickets }} উই</span>
                                            <span class="text-[10px] text-slate-500 block">রান: {{ $stat->total_runs_conceded }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-xs text-slate-500">এখনও কোনো বোলিং রেকর্ড এন্ট্রি হয়নি।</div>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    @if($tournament->sport_type === 'football' || $topScorers->count() > 0)
                        <!-- Football Golden Boot (Top Goals) -->
                        <div class="bg-gradient-to-b from-emerald-950/30 to-slate-900 border border-emerald-500/30 rounded-3xl p-5 shadow-xl space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-emerald-500/20">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">⚽</span>
                                    <div>
                                        <h3 class="text-sm font-black text-white">সর্বোচ্চ গোলদাতা</h3>
                                        <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider">Golden Boot Race</span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold">গোল্ডেন বুট</span>
                            </div>
                            <div class="space-y-2">
                                @forelse($topScorers as $rank => $stat)
                                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-950/60 border border-slate-800">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-5 text-center font-mono font-bold text-xs {{ $rank === 0 ? 'text-emerald-400 font-black' : 'text-slate-500' }}">#{{ $rank + 1 }}</span>
                                            <div>
                                                <h4 class="text-xs font-bold text-white">{{ $stat->player->name ?? 'প্লেয়ার' }}</h4>
                                                <span class="text-[10px] text-slate-400">{{ $stat->team->name ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono font-black text-emerald-400 text-sm">{{ $stat->total_goals }} গোল</span>
                                            <span class="text-[10px] text-slate-500 block">অ্যাসিস্ট: {{ $stat->total_assists }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-xs text-slate-500">এখনও কোনো গোল স্কোর এন্ট্রি হয়নি।</div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- 4. Participating Teams Grid -->
        <section class="space-y-4">
            <h2 class="text-xl font-black text-white flex items-center gap-2">
                <span>🛡️</span> টুর্নামেন্টের অংশগ্রহণকারী দলসমূহ (Participating Teams)
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @forelse($tournament->tournamentTeams as $tt)
                    <a href="{{ route('public.teams.show', $tt->team->slug) }}" class="bg-slate-900/80 border border-slate-800 hover:border-amber-500/50 p-4 rounded-2xl text-center space-y-2 group transition">
                        <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-950 border border-slate-800 flex items-center justify-center text-2xl group-hover:scale-105 transition">
                            @if($tt->team->logo)
                                <img src="{{ asset('storage/' . $tt->team->logo) }}" alt="" class="w-full h-full object-cover rounded-2xl">
                            @else
                                ⚽
                            @endif
                        </div>
                        <h4 class="font-bold text-xs text-white group-hover:text-amber-400 transition truncate">{{ $tt->team->name }}</h4>
                        <span class="text-[10px] text-slate-500 block font-mono">{{ $tt->group_name }}</span>
                    </a>
                @empty
                    <div class="col-span-6 py-6 text-center text-slate-500 text-xs">
                        দল অন্তর্ভুক্তির অপেক্ষায়।
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 4. Registered Players Pool (দলযুক্ত ও ড্রাফট পুল) -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-black text-white flex items-center gap-2">
                    <span>👥</span> নিবন্ধিত খেলোয়াড় তালিকা (Registered Players & Draft Pool)
                </h2>
                <span class="text-xs text-slate-400">মোট {{ $tournament->tournamentPlayers->count() }} জন নিবন্ধিত</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($tournament->tournamentPlayers as $p)
                    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center font-black text-sm text-amber-400">
                                {{ mb_substr($p->player_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-xs">{{ $p->player_name }}</h4>
                                <div class="text-[10px] text-slate-400">
                                    {{ $p->position ?? 'প্লেয়ার' }}
                                    @if($p->jersey_no)
                                        <span class="text-amber-400 font-mono">#{{ $p->jersey_no }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            @if($p->team)
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    🛡️ {{ $p->team->name }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    🌟 ড্রাফট পুল (দলহীন)
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 py-8 text-center bg-slate-900/50 rounded-2xl border border-slate-800 text-slate-500 text-xs">
                        এখনও কোনো খেলোয়াড় এই টুর্নামেন্টে নিবন্ধন করেনি।
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 5. Tournament Rules & Instructions -->
        @if($tournament->rules)
            <section class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-3">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <span>📜</span> টুর্নামেন্ট নিয়মাবলী ও গাইডলাইন
                </h3>
                <div class="text-xs sm:text-sm text-slate-300 leading-relaxed whitespace-pre-line">
                    {{ $tournament->rules }}
                </div>
            </section>
        @endif

    </main>

</body>
</html>

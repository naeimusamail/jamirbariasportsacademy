<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $team->name }} | টিম প্রোফাইল ও স্কোয়াড</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-rose-500 selection:text-white">
    <!-- Navbar -->
    <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-2">
            <div class="flex items-center space-x-3 shrink-0">
                <a href="{{ route('public.teams.index') }}" class="text-xs font-bold text-slate-400 hover:text-white flex items-center gap-1.5 transition whitespace-nowrap">
                    &larr; <span class="hidden xs:inline">সকল </span>টিমের তালিকা
                </a>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3 text-xs shrink-0">
                <a href="{{ route('live.index') }}" class="text-rose-400 hover:text-rose-300 font-bold flex items-center gap-1.5 whitespace-nowrap">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                    <span><span class="hidden sm:inline">লাইভ </span>ম্যাচ সেন্টার</span>
                </a>

                @auth
                    <a href="{{ route('admin.teams.show', $team->id) }}" class="px-2.5 sm:px-3 py-1.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl shadow transition flex items-center gap-1 whitespace-nowrap">
                        <span>পরিচালনা</span> ⚙️
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Team Hero Profile Header -->
    <section class="py-12 bg-gradient-to-b from-slate-900 to-slate-950 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <!-- Team Logo (300x300 container) -->
                <div class="relative shrink-0">
                    @if($team->logo)
                        <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-36 h-36 sm:w-44 sm:h-44 rounded-3xl object-cover border-4 border-amber-500/40 shadow-2xl shadow-amber-500/10">
                    @else
                        <div class="w-36 h-36 sm:w-44 sm:h-44 rounded-3xl bg-gradient-to-tr from-amber-500 to-rose-500 flex items-center justify-center text-slate-950 font-black text-6xl shadow-2xl border-4 border-amber-500/30">
                            {{ mb_substr($team->name, 0, 1) }}
                        </div>
                    @endif
                    <span class="absolute -bottom-2 -right-2 px-3 py-1 bg-slate-900 border border-slate-700 text-amber-400 font-mono font-black text-xs rounded-xl shadow">
                        {{ $team->short_name ?? 'TEAM' }}
                    </span>
                </div>

                <!-- Team Info -->
                <div class="flex-1 text-center md:text-left space-y-3">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                        <span class="px-3 py-1 text-xs font-bold rounded-lg border {{ $team->sport_type == 'cricket' ? 'bg-teal-500/10 text-teal-300 border-teal-500/20' : 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20' }} uppercase">
                            {{ $team->sport_type == 'cricket' ? '🏏 ক্রিকেট' : ($team->sport_type == 'football' ? '⚽ ফুটবল' : $team->sport_type) }}
                        </span>
                        <span class="px-3 py-1 text-xs font-bold rounded-lg bg-amber-500/10 text-amber-300 border border-amber-500/20 uppercase">
                            ক্যাটাগরি: {{ $team->category ?? 'সাধারণ' }}
                        </span>
                        <span class="px-3 py-1 text-xs font-bold rounded-lg bg-slate-800 text-slate-300 border border-slate-700">
                            🛡️ জামিরবাড়িয়া একাডেমি স্কোয়াড
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        {{ $team->name }}
                    </h1>

                    @if($team->description)
                        <p class="text-slate-400 text-sm max-w-2xl leading-relaxed">
                            {{ $team->description }}
                        </p>
                    @endif

                    <!-- Key Personnel Badges -->
                    <div class="pt-2 flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs">
                        <div class="bg-slate-900 px-4 py-2 rounded-xl border border-slate-800">
                            <span class="text-slate-500 block text-[11px]">অধিনায়ক (Captain)</span>
                            <span class="font-bold text-amber-400 text-sm">👑 {{ $team->captain_name ?? 'নির্ধারণ করা হয়নি' }}</span>
                        </div>
                        <div class="bg-slate-900 px-4 py-2 rounded-xl border border-slate-800">
                            <span class="text-slate-500 block text-[11px]">প্রধান কোচ (Head Coach)</span>
                            <span class="font-bold text-white text-sm">📋 {{ $team->coach_name ?? 'একাডেমি কোচ' }}</span>
                        </div>
                        <div class="bg-slate-900 px-4 py-2 rounded-xl border border-slate-800">
                            <span class="text-slate-500 block text-[11px]">মোট প্লেয়ার</span>
                            <span class="font-bold text-emerald-400 text-sm">👥 {{ $team->players->count() }} জন</span>
                        </div>
                    </div>
                </div>

                <!-- Overall Record Card -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 w-full md:w-64 text-center shrink-0">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-3">মৌসুম পারফরম্যান্স</span>
                    <div class="grid grid-cols-4 gap-2 text-center mb-4">
                        <div class="bg-slate-950 p-2 rounded-xl">
                            <span class="text-[10px] text-slate-500 block font-bold">ম্যাচ</span>
                            <span class="text-lg font-black font-mono text-white">{{ $team->matches_played }}</span>
                        </div>
                        <div class="bg-emerald-950/50 p-2 rounded-xl border border-emerald-500/20">
                            <span class="text-[10px] text-emerald-400 block font-bold">জয়</span>
                            <span class="text-lg font-black font-mono text-emerald-400">{{ $team->matches_won }}</span>
                        </div>
                        <div class="bg-rose-950/50 p-2 rounded-xl border border-rose-500/20">
                            <span class="text-[10px] text-rose-400 block font-bold">হার</span>
                            <span class="text-lg font-black font-mono text-rose-400">{{ $team->matches_lost }}</span>
                        </div>
                        <div class="bg-slate-950 p-2 rounded-xl">
                            <span class="text-[10px] text-slate-500 block font-bold">ড্র</span>
                            <span class="text-lg font-black font-mono text-slate-300">{{ $team->matches_drawn }}</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-amber-500/20 to-rose-500/20 border border-amber-500/30 p-2.5 rounded-xl">
                        <span class="text-xs text-amber-300 font-bold block">মোট অর্জন</span>
                        <span class="text-2xl font-black font-mono text-amber-400">{{ $team->points }} পয়েন্ট</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <main class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        <!-- 1. OFFICIAL TEAM SQUAD (Cricinfo Roster) -->
        <div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-white flex items-center gap-2">
                        <span>👥</span> অফিসিয়াল টিম স্কোয়াড (Squad Roster)
                    </h2>
                    <p class="text-slate-400 text-xs sm:text-sm mt-1">
                        প্রতিটি প্লেয়ারের ছবিতে ক্লিক করে তার সম্পূর্ণ ক্রিকইনফো ক্যারিয়ার স্ট্যাটস ও পারফরম্যান্স দেখুন।
                    </p>
                </div>
                <span class="text-xs font-mono font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-3 py-1.5 rounded-xl self-start">
                    স্কোয়াড সদস্য: {{ $team->players->count() }} জন
                </span>
            </div>

            <!-- Squad Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($team->players as $player)
                    <div class="bg-slate-900 border border-slate-800 hover:border-amber-500/60 rounded-3xl p-5 shadow-xl hover:shadow-2xl transition duration-300 flex flex-col justify-between group relative overflow-hidden">
                        <!-- Top Accent Tag -->
                        @if($player->is_captain)
                            <div class="absolute top-3 right-3 px-2 py-0.5 rounded-md bg-amber-500 text-slate-950 font-black text-[10px] tracking-widest shadow">
                                CAPTAIN
                            </div>
                        @elseif($player->is_vice_captain)
                            <div class="absolute top-3 right-3 px-2 py-0.5 rounded-md bg-slate-700 text-amber-300 font-bold text-[10px] tracking-widest">
                                VICE CAPTAIN
                            </div>
                        @endif

                        <div>
                            <!-- Player Photo (300x300 Standard) -->
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="relative shrink-0">
                                    @if($player->photo)
                                        <img src="{{ asset('storage/' . $player->photo) }}" alt="{{ $player->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-700 group-hover:border-amber-500 transition shadow">
                                    @else
                                        <div class="w-16 h-16 rounded-2xl bg-slate-800 border-2 border-slate-700 flex items-center justify-center text-xl font-black text-amber-400 group-hover:border-amber-500 transition">
                                            {{ mb_substr($player->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="absolute -bottom-1 -right-1 px-1.5 py-0.2 bg-slate-950 text-slate-300 text-[10px] font-mono font-bold rounded border border-slate-800">
                                        #{{ $player->jersey_no ?? '-' }}
                                    </span>
                                </div>

                                <div class="overflow-hidden">
                                    <h4 class="font-extrabold text-base text-white truncate group-hover:text-amber-400 transition">
                                        {{ $player->name }}
                                    </h4>
                                    <span class="text-xs font-semibold text-slate-400 block truncate">
                                        {{ $player->role ?? 'প্লেয়ার' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Technical Specs -->
                            <div class="bg-slate-950/70 rounded-xl p-3 border border-slate-800/80 space-y-1.5 text-xs text-slate-300 mb-4">
                                @if($player->batting_style)
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">ব্যাটিং:</span>
                                        <span class="font-medium text-slate-200">{{ $player->batting_style }}</span>
                                    </div>
                                @endif
                                @if($player->bowling_style)
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">বোলিং:</span>
                                        <span class="font-medium text-slate-200">{{ $player->bowling_style }}</span>
                                    </div>
                                @endif
                                @if($player->trainee)
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">একাডেমি স্ট্যাটাস:</span>
                                        <span class="font-medium text-emerald-400">অফিশিয়াল ট্রেইনি</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Career Aggregates Preview -->
                            @php $cStats = $player->career_stats; @endphp
                            <div class="grid grid-cols-3 gap-1.5 text-center bg-slate-850 p-2 rounded-xl border border-slate-800 text-[11px] mb-4">
                                <div>
                                    <span class="text-slate-500 block text-[9px] uppercase">ম্যাচ</span>
                                    <span class="font-black text-white font-mono">{{ $cStats->matches }}</span>
                                </div>
                                @if($team->sport_type == 'football')
                                    <div>
                                        <span class="text-slate-500 block text-[9px] uppercase">গোল</span>
                                        <span class="font-black text-emerald-400 font-mono">{{ $cStats->goals }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[9px] uppercase">অ্যাসিস্ট</span>
                                        <span class="font-black text-amber-400 font-mono">{{ $cStats->assists }}</span>
                                    </div>
                                @else
                                    <div>
                                        <span class="text-slate-500 block text-[9px] uppercase">রান</span>
                                        <span class="font-black text-amber-400 font-mono">{{ $cStats->runs }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[9px] uppercase">উইকেট</span>
                                        <span class="font-black text-rose-400 font-mono">{{ $cStats->wickets }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Cricinfo Profile CTA -->
                        <a href="{{ route('public.players.show', $player->id) }}" class="w-full py-2.5 px-3 bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-200 text-xs font-bold rounded-xl text-center transition flex items-center justify-center gap-1.5">
                            <span>ক্রিকইনফো প্রোফাইল দেখুন</span>
                            <span>➔</span>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-slate-900 border border-slate-800 rounded-3xl">
                        <div class="text-4xl mb-3">🏏</div>
                        <h4 class="text-base font-bold text-white">এখনো স্কোয়াড প্লেয়ার যোগ করা হয়নি</h4>
                        <p class="text-xs text-slate-400 mt-1">শীঘ্রই দলের অফিসিয়াল খেলোয়াড় তালিকা প্রকাশ করা হবে।</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. RECENT & UPCOMING MATCHES FOR THIS TEAM -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-black text-white flex items-center gap-2">
                        <span>📅</span> দলের ম্যাচ শিডিউল ও ফলাফল (Match Schedule & Results)
                    </h2>
                    <p class="text-slate-400 text-xs mt-1">এই দলের সাম্প্রতিক ও আসন্ন সকল ম্যাচের তালিকা</p>
                </div>
                <a href="{{ route('live.index') }}" class="text-xs font-bold text-rose-400 hover:text-white transition">
                    সকল ম্যাচ দেখুন &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($matches as $m)
                    <div class="bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-3xl p-5 shadow-lg flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-slate-400 mb-3">
                                <span class="font-semibold text-rose-400">{{ $m->tournament_name ?? 'টুর্নামেন্ট' }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $m->status == 'live' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30 animate-pulse' : ($m->status == 'upcoming' ? 'bg-amber-500/20 text-amber-300' : 'bg-slate-800 text-slate-400') }}">
                                    {{ $m->status == 'live' ? '● লাইভ' : ($m->status == 'upcoming' ? 'আসন্ন' : 'সমাপ্ত') }}
                                </span>
                            </div>

                            <h4 class="font-bold text-sm text-white mb-2">{{ $m->title }}</h4>

                            <div class="bg-slate-950/70 p-3 rounded-2xl border border-slate-800/80 my-3 text-xs space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold {{ $m->team_a == $team->name ? 'text-amber-400 font-extrabold' : 'text-slate-300' }}">{{ $m->team_a }}</span>
                                    <span class="font-mono font-bold text-white">{{ $m->team_a_score ?? '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold {{ $m->team_b == $team->name ? 'text-amber-400 font-extrabold' : 'text-slate-300' }}">{{ $m->team_b }}</span>
                                    <span class="font-mono font-bold text-white">{{ $m->team_b_score ?? '-' }}</span>
                                </div>
                            </div>

                            @if($m->match_result)
                                <div class="text-[11px] font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-lg text-center mb-3">
                                    🏆 {{ $m->match_result }}
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('live.show', $m->slug) }}" class="mt-2 py-2 px-3 bg-slate-800 hover:bg-rose-600 text-white rounded-xl text-xs font-bold text-center transition">
                            স্কোরকার্ড ও লাইভ দেখুন ➔
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center bg-slate-900 border border-slate-800 rounded-2xl text-xs text-slate-500">
                        এই দলের কোনো ম্যাচ এখনও নির্ধারিত হয়নি।
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-900/50 py-10 mt-16 text-center text-xs text-slate-500">
        <p>© {{ date('Y') }} জামিরবাড়িয়া স্পোর্টস একাডেমি • {{ $team->name }} অফিসিয়াল হাব</p>
    </footer>
</body>
</html>


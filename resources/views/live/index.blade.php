<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>লাইভ ম্যাচ সেন্টার | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-rose-500 selection:text-white">

    <!-- Top Navbar -->
    <header x-data="{ mobileMenu: false }" class="border-b border-slate-800/80 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 sm:gap-4">
            <div class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                <a href="{{ url('/') }}" class="flex items-center space-x-2 group min-w-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-rose-600 to-amber-500 flex items-center justify-center text-white font-black text-lg sm:text-xl shadow-lg shadow-rose-500/20 shrink-0">
                        🔴
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs xs:text-base sm:text-lg font-black tracking-tight text-white block leading-tight truncate max-w-[130px] xs:max-w-[210px] sm:max-w-none">জামিরবাড়িয়া লাইভ ম্যাচ</span>
                        <span class="text-[7.5px] xs:text-[9px] sm:text-[10px] uppercase tracking-widest text-rose-400 font-semibold block truncate max-w-[130px] xs:max-w-none">LIVE MATCH & SCORING CENTER</span>
                    </div>
                </a>
            </div>

            <!-- Links -->
            <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-300">
                <a href="{{ route('live.index') }}" class="text-rose-400 flex items-center gap-1.5 font-bold">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span> লাইভ সেন্টার
                </a>
                <a href="{{ route('public.tournaments.index') }}" class="hover:text-amber-400 transition">টুর্নামেন্ট</a>
                <a href="{{ route('public.teams.index') }}" class="hover:text-white transition">টিম ও স্কোয়াড</a>
                <a href="{{ route('public.local-players.create') }}" class="text-emerald-400 hover:text-emerald-300 transition">লোকাল প্লেয়ার পাস</a>
                <a href="{{ url('/') }}" class="hover:text-white transition">হোম</a>
            </nav>

            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-2.5 sm:px-4 py-1.5 sm:py-2 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-xs sm:text-sm shadow transition">
                        ড্যাশবোর্ড / স্কোরার
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-[11px] sm:text-xs font-bold text-rose-400 hover:text-white border border-rose-500/40 bg-rose-500/10 px-2 sm:px-3.5 py-1 sm:py-1.5 rounded-xl flex items-center gap-1 sm:gap-1.5 transition">
                        <span>🎯</span> <span class="hidden xs:inline">স্কোরার </span>লগইন
                    </a>
                @endauth

                <!-- Hamburger button for mobile -->
                <button @click="mobileMenu = !mobileMenu" aria-label="Toggle Mobile Menu" class="md:hidden p-1.5 sm:p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenu, 'block': !mobileMenu}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'block': mobileMenu, 'hidden': !mobileMenu}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile dropdown drawer -->
        <div x-show="mobileMenu" x-transition class="md:hidden border-t border-slate-800 bg-slate-900/98 px-4 py-4 space-y-2 text-sm font-semibold text-slate-200">
            <a href="{{ route('live.index') }}" class="block px-3.5 py-2 rounded-xl text-rose-400 bg-slate-800 font-bold">🔴 লাইভ সেন্টার</a>
            <a href="{{ route('public.tournaments.index') }}" class="block px-3.5 py-2 rounded-xl text-amber-400 hover:bg-slate-800 font-bold">🏆 টুর্নামেন্ট</a>
            <a href="{{ route('public.teams.index') }}" class="block px-3.5 py-2 rounded-xl text-cyan-400 hover:bg-slate-800 font-bold">🛡️ টিম ও স্কোয়াড</a>
            <a href="{{ route('public.local-players.create') }}" class="block px-3.5 py-2 rounded-xl text-emerald-400 hover:bg-slate-800 font-bold">🌟 লোকাল প্লেয়ার পাস</a>
            <a href="{{ route('public.apply') }}" class="block px-3.5 py-2 rounded-xl text-emerald-300 hover:bg-slate-800 font-bold">🚀 অনলাইন আবেদন</a>
            <a href="{{ url('/') }}" class="block px-3.5 py-2 rounded-xl hover:bg-slate-800 font-bold">🏠 একাডেমি হোম</a>
        </div>
    </header>

    <!-- Athletic Stadium Floodlight Hero Header -->
    <section class="py-8 sm:py-12 bg-gradient-to-b from-slate-950 via-[#13070b] to-slate-950 border-b border-slate-800 relative overflow-hidden">
        <div class="absolute top-0 right-1/3 w-[600px] h-[300px] bg-rose-500/10 blur-[130px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 sm:gap-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-rose-500/10 border border-rose-500/30 text-rose-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2 sm:mb-3">
                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-rose-500 animate-ping"></span>
                        রিয়েল-টাইম ম্যাচ সম্প্রচার ও স্কোরবোর্ড
                    </div>
                    <h1 class="text-xl xs:text-2xl sm:text-5xl font-black text-white tracking-tight leading-snug">
                        লাইভ স্কোরবোর্ড ও <span class="bg-gradient-to-r from-rose-400 via-amber-400 to-rose-300 bg-clip-text text-transparent">ম্যাচ কমেন্ট্রি টাইমলাইন</span>
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-base mt-1 sm:mt-2 max-w-2xl leading-relaxed">
                        জামিরবাড়িয়া স্পোর্টস একাডেমির ফুটবল ও ক্রিকেট ম্যাচসমূহের বল-বাই-বল লাইভ স্কোর, খেলার ধারাবিবরণী ও সরাসরি ভিডিও সম্প্রচার।
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('public.tournaments.index') }}" class="px-4 py-2.5 sm:px-5 sm:py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-black flex items-center gap-2 shadow-xl shadow-amber-500/20 transition">
                        <span>🏆 টুর্নামেন্ট</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Container: Left Category Sidebar + Right Matches Area -->
    <main class="py-6 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- ============================================================== -->
            <!-- ⬅️ LEFT SIDEBAR: CATEGORY & SPORT SELECTOR WITH GLOW EFFECTS -->
            <!-- ============================================================== -->
            <aside class="lg:col-span-3 lg:sticky lg:top-24 space-y-6">

                <!-- 1. Category: Sports Disciplines Panel -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-3 backdrop-blur hover:border-rose-500/40 transition">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <h3 class="text-xs font-bold text-rose-400 uppercase tracking-wider flex items-center gap-2">
                            <span>⚽</span> খেলাধুলা ক্যাটাগরি
                        </h3>
                    </div>

                    <div class="space-y-1.5 text-xs font-bold">
                        <a href="{{ route('live.index', array_merge(request()->except('sport', 'page'))) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ !request('sport') ? 'bg-gradient-to-r from-rose-600 to-amber-600 text-white shadow-md shadow-rose-600/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>⚡</span>
                                <span>সকল খেলা</span>
                            </span>
                            <span>✓</span>
                        </a>

                        <a href="{{ route('live.index', array_merge(request()->except('page'), ['sport' => 'football'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('sport') == 'football' ? 'bg-rose-600 text-white shadow-md shadow-rose-600/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>⚽</span>
                                <span>ফুটবল</span>
                            </span>
                        </a>

                        <a href="{{ route('live.index', array_merge(request()->except('page'), ['sport' => 'cricket'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('sport') == 'cricket' ? 'bg-rose-600 text-white shadow-md shadow-rose-600/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🏏</span>
                                <span>ক্রিকেট</span>
                            </span>
                        </a>

                        <a href="{{ route('live.index', array_merge(request()->except('page'), ['sport' => 'badminton'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('sport') == 'badminton' ? 'bg-rose-600 text-white shadow-md shadow-rose-600/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🏸</span>
                                <span>ব্যাডমিন্টন</span>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- 2. Quick Match Status Nav -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-3 backdrop-blur">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">ম্যাচ স্ট্যাটাস</h4>
                    <div class="space-y-1.5 text-xs font-semibold">
                        <div class="flex items-center justify-between p-2 rounded-xl bg-slate-950 border border-slate-800">
                            <span class="flex items-center gap-2 text-rose-400 font-bold">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span> সরাসরি চলমান
                            </span>
                            <span class="font-mono text-white">{{ $liveMatches->count() }}টি</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-slate-950 border border-slate-800">
                            <span class="flex items-center gap-2 text-amber-400">
                                <span>🟡</span> আসন্ন ম্যাচ
                            </span>
                            <span class="font-mono text-white">{{ $upcomingMatches->count() }}টি</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl bg-slate-950 border border-slate-800">
                            <span class="flex items-center gap-2 text-slate-400">
                                <span>⚪</span> সমাপ্ত ফলাফল
                            </span>
                            <span class="font-mono text-white">{{ $finishedMatches->count() }}টি</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Related Sectors -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-950 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-3">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">অন্যান্য সেক্টর</h4>
                    <div class="space-y-2 text-xs">
                        <a href="{{ route('public.tournaments.index') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-850 hover:bg-slate-800 text-amber-400 font-bold border border-slate-800 transition">
                            <span class="flex items-center gap-2">
                                <span>🏆</span> টুর্নামেন্ট হাব
                            </span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.teams.index') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-850 hover:bg-slate-800 text-slate-200 font-bold border border-slate-800 transition">
                            <span class="flex items-center gap-2">
                                <span>🛡️</span> দল ও স্কোয়াড
                            </span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('dashboard.scorer') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold border border-rose-500/30 transition">
                            <span class="flex items-center gap-2">
                                <span>🎯</span> স্কোরার পোর্টাল ও পিন
                            </span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>

            </aside>

            <!-- ============================================================== -->
            <!-- ➡️ RIGHT MAIN CONTENT: LIVE, UPCOMING, & FINISHED MATCHES -->
            <!-- ============================================================== -->
            <div class="lg:col-span-9 space-y-10">

                <!-- 1. ONGOING LIVE MATCHES -->
                <section class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500 animate-pulse"></span>
                            <h2 class="text-xl sm:text-2xl font-black text-white">মাঠে সরাসরি চলছে (LIVE NOW)</h2>
                        </div>
                        <span class="text-xs font-mono text-rose-400 font-bold bg-rose-500/10 border border-rose-500/20 px-2.5 py-1 rounded-full">
                            {{ $liveMatches->count() }} টি ম্যাচ লাইভ
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        @forelse($liveMatches as $match)
                            <div class="bg-gradient-to-br from-slate-900 to-slate-850 border border-rose-500/40 rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-2xl relative overflow-hidden group hover:border-rose-400 transition">
                                <!-- Top Meta -->
                                <div class="flex items-center justify-between text-xs text-slate-400 border-b border-slate-800 pb-2.5 sm:pb-3">
                                    <span class="font-bold text-rose-400 flex items-center gap-1.5 uppercase text-[10px] sm:text-[11px] truncate max-w-[170px] sm:max-w-none">
                                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-rose-500 animate-ping shrink-0"></span>
                                        {{ strtoupper($match->sport_type) }} • {{ $match->tournament_name ?? 'অফিশিয়াল ম্যাচ' }}
                                    </span>

                                    @if($match->is_streaming)
                                        <span class="px-2 sm:px-2.5 py-0.5 rounded-full bg-rose-600 text-white font-black text-[9px] sm:text-[10px] flex items-center gap-1 animate-pulse shrink-0">
                                            📺 লাইভ চলছে
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[10px] sm:text-xs shrink-0">{{ $match->venue }}</span>
                                    @endif
                                </div>

                                <!-- Match Title -->
                                <h3 class="text-sm sm:text-lg font-black text-white mt-2.5 sm:mt-3 truncate">{{ $match->title }}</h3>

                                <!-- Scoreboard Center -->
                                <div class="my-3 sm:my-6 grid grid-cols-5 items-center text-center bg-slate-950/60 p-2.5 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-800/80">
                                    <!-- Team A -->
                                    <div class="col-span-2 min-w-0">
                                        <div class="text-[9px] sm:text-xs font-bold text-slate-400 uppercase truncate">হোস্ট / দল ১</div>
                                        <div class="font-black text-white text-xs sm:text-base truncate mt-0.5 sm:mt-1">{{ $match->team_a }}</div>
                                        <div class="text-lg sm:text-2xl font-black text-rose-400 font-mono mt-0.5 sm:mt-1">{{ $match->team_a_score }}</div>
                                    </div>

                                    <!-- VS Pill -->
                                    <div class="col-span-1 flex flex-col items-center shrink-0">
                                        <span class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-rose-500/20 text-rose-300 font-black text-[10px] sm:text-xs flex items-center justify-center border border-rose-500/30">VS</span>
                                        <span class="text-[8px] sm:text-[10px] font-bold text-rose-400 uppercase mt-1 sm:mt-2 tracking-wider animate-pulse">LIVE</span>
                                    </div>

                                    <!-- Team B -->
                                    <div class="col-span-2 min-w-0">
                                        <div class="text-[9px] sm:text-xs font-bold text-slate-400 uppercase truncate">প্রতিপক্ষ / দল ২</div>
                                        <div class="font-black text-white text-xs sm:text-base truncate mt-0.5 sm:mt-1">{{ $match->team_b }}</div>
                                        <div class="text-lg sm:text-2xl font-black text-rose-400 font-mono mt-0.5 sm:mt-1">{{ $match->team_b_score }}</div>
                                    </div>
                                </div>

                                <!-- Live Summary Ticker -->
                                @if($match->current_summary)
                                    <div class="p-2 sm:p-3 bg-slate-950/70 border border-slate-800 rounded-xl text-[11px] sm:text-xs text-amber-300 font-medium flex items-center gap-1.5 sm:gap-2 mb-3 sm:mb-4">
                                        <span class="text-rose-500">⚡</span>
                                        <span class="truncate">{{ $match->current_summary }}</span>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="pt-3 sm:pt-4 border-t border-slate-800 flex items-center justify-between gap-2">
                                    <a href="{{ route('live.show', $match->slug) }}" class="inline-flex items-center gap-1.5 px-3 sm:px-5 py-2 sm:py-2.5 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-[11px] sm:text-xs transition shadow-lg shadow-rose-600/30">
                                        <span>লাইভ স্কোর ও সম্প্রচার</span>
                                        <span>➔</span>
                                    </a>

                                    @auth
                                        <a href="{{ route('matches.scorer', $match->slug) }}" class="text-[11px] sm:text-xs font-bold text-amber-400 hover:text-amber-300 underline">
                                            স্কোরিং কন্ট্রোল ⚙️
                                        </a>
                                    @else
                                        <a href="{{ route('scorer.quick-access', $match->slug) }}" class="text-[11px] sm:text-xs font-bold text-rose-400 hover:text-rose-300 underline flex items-center gap-1">
                                            <span>🔑</span> স্কোরার পিন
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 py-12 text-center bg-slate-900/60 rounded-3xl border border-slate-800 space-y-2">
                                <div class="text-3xl">🏟️</div>
                                <h4 class="font-bold text-white text-sm">বর্তমানে কোনো লাইভ খেলা চলমান নেই</h4>
                                <p class="text-xs text-slate-400">নিচে আসন্ন ম্যাচের সময়সূচি দেখে রাখুন।</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- 2. UPCOMING MATCHES -->
                <section class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl sm:text-2xl font-black text-white flex items-center gap-2">
                            <span>🟡</span> আসন্ন খেলার সময়সূচি (Upcoming Fixtures)
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @forelse($upcomingMatches as $match)
                            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 hover:border-slate-700 transition">
                                <div class="flex items-center justify-between text-xs text-slate-400 pb-2 border-b border-slate-800">
                                    <span class="font-bold text-emerald-400 uppercase">{{ $match->sport_type }}</span>
                                    <span class="font-mono">{{ $match->match_datetime ? date('d M, h:i A', strtotime($match->match_datetime)) : 'তারিখ আসছে' }}</span>
                                </div>

                                <h4 class="font-bold text-white text-base mt-3">{{ $match->title }}</h4>
                                <div class="my-4 p-3 bg-slate-850 rounded-xl text-xs space-y-1">
                                    <div class="text-white font-semibold">🔴 {{ $match->team_a }}</div>
                                    <div class="text-slate-500 text-[10px] pl-4">বনাম</div>
                                    <div class="text-white font-semibold">🔵 {{ $match->team_b }}</div>
                                </div>
                                <div class="text-xs text-slate-400">ভেন্যু: {{ $match->venue }}</div>

                                <div class="mt-4 pt-3 border-t border-slate-800 flex justify-between items-center">
                                    @auth
                                        <a href="{{ route('matches.scorer', $match->slug) }}" class="text-xs font-bold text-emerald-400 hover:underline">
                                            স্কোর পরিচালনা &rarr;
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-500">আসন্ন খেলা</span>
                                    @endauth
                                    <a href="{{ route('live.show', $match->slug) }}" class="text-xs font-bold text-rose-400 hover:text-rose-300">
                                        পেজ দেখুন
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8 text-slate-500 bg-slate-900 rounded-2xl">
                                কোনো আসন্ন ম্যাচের সূচি নেই।
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- 3. FINISHED MATCHES -->
                @if($finishedMatches->count() > 0)
                    <section class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl sm:text-2xl font-black text-white flex items-center gap-2">
                                <span>⚪</span> সমাপ্ত খেলার ফলাফল (Match Results)
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            @foreach($finishedMatches as $match)
                                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-5">
                                    <div class="flex items-center justify-between text-xs text-slate-400 pb-2 border-b border-slate-800">
                                        <span class="uppercase font-bold">{{ $match->sport_type }}</span>
                                        <span class="px-2 py-0.5 bg-slate-800 text-slate-300 rounded font-bold">সমাপ্ত</span>
                                    </div>

                                    <h4 class="font-bold text-white text-sm mt-3">{{ $match->title }}</h4>
                                    <div class="my-3 text-sm font-bold flex justify-between items-center">
                                        <span>{{ $match->team_a }}: <strong class="text-rose-400">{{ $match->team_a_score }}</strong></span>
                                        <span>{{ $match->team_b }}: <strong class="text-rose-400">{{ $match->team_b_score }}</strong></span>
                                    </div>
                                    <p class="text-xs text-emerald-400">{{ $match->current_summary ?? 'ম্যাচ সমাপ্ত' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800 py-8 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} জামিরবাড়িয়া স্পোর্টস একাডেমি • অফিসিয়াল লাইভ ম্যাচ সেন্টার
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>টুর্নামেন্ট সেক্টর ও লাইভ চ্যাম্পিয়নশিপ | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-amber-500 selection:text-slate-950">

    <!-- Top Navbar -->
    <header x-data="{ mobileMenu: false }" class="border-b border-slate-800/80 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 sm:gap-4">
            <a href="{{ url('/') }}" class="flex items-center space-x-2 sm:space-x-3 min-w-0 group">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-gradient-to-tr from-amber-500 via-rose-500 to-emerald-500 flex items-center justify-center text-slate-950 font-black text-lg sm:text-2xl shadow-lg shadow-amber-500/20 shrink-0">
                    🏆
                </div>
                <div class="min-w-0">
                    <span class="text-xs xs:text-base sm:text-lg font-black tracking-tight text-white block leading-tight truncate max-w-[130px] xs:max-w-[210px] sm:max-w-none">জামিরবাড়িয়া টুর্নামেন্ট</span>
                    <span class="text-[7.5px] xs:text-[9px] sm:text-[10px] uppercase tracking-widest text-amber-400 font-semibold block truncate max-w-[130px] xs:max-w-none">ACADEMY & LOCAL TOURNAMENTS HUB</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-300">
                <a href="{{ route('public.tournaments.index') }}" class="text-amber-400 font-bold">টুর্নামেন্ট হাব</a>
                <a href="{{ route('live.index') }}" class="hover:text-rose-400 transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span> লাইভ ম্যাচ
                </a>
                <a href="{{ route('public.teams.index') }}" class="hover:text-white transition">দল ও স্কোয়াড</a>
                <a href="{{ route('public.local-players.create') }}" class="text-emerald-400 hover:text-emerald-300 transition">লোকাল প্লেয়ার নিবন্ধন</a>
                <a href="{{ url('/') }}" class="hover:text-white transition">হোম</a>
            </nav>

            <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
                <a href="{{ route('public.local-players.create') }}" class="hidden sm:inline-flex items-center px-3.5 sm:px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs transition shadow-md shadow-amber-500/20 whitespace-nowrap">
                    🌟 লোকাল প্লেয়ার পাস
                </a>
                @auth
                    <a href="{{ route('admin.tournaments.index') }}" class="px-2.5 sm:px-4 py-1.5 sm:py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-[11px] sm:text-xs font-bold border border-slate-700 transition whitespace-nowrap">
                        ম্যানেজমেন্ট ⚙️
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-2 sm:px-3 py-1 sm:py-1.5 text-[11px] sm:text-xs text-slate-400 hover:text-white transition whitespace-nowrap">
                        লগইন
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
            <a href="{{ route('public.tournaments.index') }}" class="block px-3.5 py-2 rounded-xl text-amber-400 bg-slate-800 font-bold">🏆 টুর্নামেন্ট হাব</a>
            <a href="{{ route('live.index') }}" class="block px-3.5 py-2 rounded-xl text-rose-400 hover:bg-slate-800 font-bold">🔴 লাইভ ম্যাচ</a>
            <a href="{{ route('public.teams.index') }}" class="block px-3.5 py-2 rounded-xl text-cyan-400 hover:bg-slate-800 font-bold">🛡️ দল ও স্কোয়াড</a>
            <a href="{{ route('public.local-players.create') }}" class="block px-3.5 py-2 rounded-xl text-emerald-400 hover:bg-slate-800 font-bold">🌟 লোকাল প্লেয়ার নিবন্ধন</a>
            <a href="{{ route('public.apply') }}" class="block px-3.5 py-2 rounded-xl text-emerald-300 hover:bg-slate-800 font-bold">🚀 অনলাইন আবেদন</a>
            <a href="{{ url('/') }}" class="block px-3.5 py-2 rounded-xl hover:bg-slate-800 font-bold">🏠 একাডেমি হোম</a>
        </div>
    </header>

    <!-- Athletic Stadium Floodlight Hero Section -->
    <section class="py-8 sm:py-12 relative overflow-hidden bg-gradient-to-b from-slate-950 via-[#061814] to-slate-950 border-b border-slate-800/80">
        <!-- Stadium Floodlight Glow -->
        <div class="absolute top-0 left-1/4 w-[600px] h-[300px] bg-emerald-500/15 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute top-0 right-1/4 w-[600px] h-[300px] bg-amber-500/15 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 sm:gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2 sm:mb-3">
                        <span>🏆</span> অফিশিয়াল চ্যাম্পিয়নশিপ ও টুর্নামেন্ট পোর্টাল
                    </div>
                    <h1 class="text-xl xs:text-2xl sm:text-5xl font-black text-white tracking-tight leading-snug">
                        একাডেমিক ও লোকাল <span class="bg-gradient-to-r from-amber-400 via-emerald-400 to-rose-400 bg-clip-text text-transparent">টুর্নামেন্ট</span>
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-base mt-1.5 sm:mt-3 leading-relaxed">
                        জামিরবাড়িয়া স্পোর্টস একাডেমির নিজস্ব ক্যাডেটদের নিয়ে আন্তঃব্যাচ একাডেমিক টুর্নামেন্ট এবং উন্মুক্ত এলাকার খেলোয়াড় ও ক্লাবের অংশগ্রহণে মেগা লোকাল টুর্নামেন্ট শিডিউল, পয়েন্ট টেবিল ও লাইভ রেজাল্ট।
                    </p>
                </div>

                <!-- Quick Counters & CTA -->
                <div class="grid grid-cols-3 gap-2 sm:gap-3 w-full lg:w-auto">
                    <div class="p-2.5 sm:p-4 rounded-xl sm:rounded-2xl bg-slate-900/80 border border-amber-500/30 text-center backdrop-blur">
                        <div class="text-lg sm:text-3xl font-black text-amber-400">{{ $totalCount }}</div>
                        <div class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 mt-0.5 sm:mt-1">মোট টুর্নামেন্ট</div>
                    </div>
                    <div class="p-2.5 sm:p-4 rounded-xl sm:rounded-2xl bg-slate-900/80 border border-emerald-500/30 text-center backdrop-blur">
                        <div class="text-lg sm:text-3xl font-black text-emerald-400">{{ $academicCount }}</div>
                        <div class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 mt-0.5 sm:mt-1">একাডেমিক</div>
                    </div>
                    <div class="p-2.5 sm:p-4 rounded-xl sm:rounded-2xl bg-slate-900/80 border border-rose-500/30 text-center backdrop-blur">
                        <div class="text-lg sm:text-3xl font-black text-rose-400">{{ $localCount }}</div>
                        <div class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 mt-0.5 sm:mt-1">লোকাল উন্মুক্ত</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Container: Left-side Category / Discipline Sidebar + Right Content Area -->
    <main class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- ============================================================== -->
            <!-- ⬅️ LEFT SIDEBAR: CATEGORY, SPORTS & DISCIPLINE SELECTOR WITH GLOW -->
            <!-- ============================================================== -->
            <aside class="lg:col-span-3 lg:sticky lg:top-24 space-y-6">

                <!-- 1. Category: Tournament Type Selector -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-4 backdrop-blur hover:border-amber-500/40 transition">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <h3 class="text-xs font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                            <span>🏆</span> টুর্নামেন্ট ক্যাটাগরি
                        </h3>
                        <span class="text-[10px] font-mono text-slate-400">{{ $totalCount }}টি</span>
                    </div>

                    <div class="space-y-1.5 text-xs font-bold">
                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('type', 'page'))) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ !request('type') ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>⚡</span>
                                <span>সকল টুর্নামেন্ট</span>
                            </span>
                            <span class="text-[11px] font-mono">{{ $totalCount }}</span>
                        </a>

                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['type' => 'academic'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('type') == 'academic' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 shadow-md shadow-emerald-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🎓</span>
                                <span>একাডেমিক টুর্নামেন্ট</span>
                            </span>
                            <span class="text-[11px] font-mono bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-full">{{ $academicCount }}</span>
                        </a>

                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['type' => 'local'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('type') == 'local' ? 'bg-gradient-to-r from-rose-500 to-amber-500 text-white shadow-md shadow-rose-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🌟</span>
                                <span>উন্মুক্ত / লোকাল টুর্নামেন্ট</span>
                            </span>
                            <span class="text-[11px] font-mono bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded-full">{{ $localCount }}</span>
                        </a>
                    </div>
                </div>

                <!-- 2. Category: Sports Disciplines Selector -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-4 backdrop-blur hover:border-emerald-500/40 transition">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <h3 class="text-xs font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                            <span>⚽</span> খেলাধুলা ডিসিপ্লিন
                        </h3>
                    </div>

                    <div class="space-y-1.5 text-xs font-bold">
                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('sport', 'page'))) }}" 
                           class="flex items-center justify-between px-3.5 py-2 rounded-xl transition {{ !request('sport') ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                            <span>সকল স্পোর্টস</span>
                            <span>✓</span>
                        </a>

                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['sport' => 'football'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2 rounded-xl transition {{ request('sport') == 'football' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>⚽</span>
                                <span>ফুটবল</span>
                            </span>
                        </a>

                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['sport' => 'cricket'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2 rounded-xl transition {{ request('sport') == 'cricket' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🏏</span>
                                <span>ক্রিকেট</span>
                            </span>
                        </a>

                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['sport' => 'badminton'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2 rounded-xl transition {{ request('sport') == 'badminton' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🏸</span>
                                <span>ব্যাডমিন্টন</span>
                            </span>
                        </a>

                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['sport' => 'athletics'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2 rounded-xl transition {{ request('sport') == 'athletics' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🏃</span>
                                <span>অ্যাথলেটিক্স</span>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- 3. Category: Tournament Status -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-3 backdrop-blur">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">টুর্নামেন্ট স্ট্যাটাস</h3>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['status' => 'ongoing'])) }}"
                           class="px-3 py-1.5 rounded-xl border {{ request('status') == 'ongoing' ? 'bg-rose-500/20 border-rose-500 text-rose-300 font-bold' : 'border-slate-800 text-slate-400 hover:text-white' }}">
                            🔴 চলমান (Live)
                        </a>
                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['status' => 'upcoming'])) }}"
                           class="px-3 py-1.5 rounded-xl border {{ request('status') == 'upcoming' ? 'bg-amber-500/20 border-amber-500 text-amber-300 font-bold' : 'border-slate-800 text-slate-400 hover:text-white' }}">
                            🟡 আসন্ন (Upcoming)
                        </a>
                        <a href="{{ route('public.tournaments.index', array_merge(request()->except('page'), ['status' => 'completed'])) }}"
                           class="px-3 py-1.5 rounded-xl border {{ request('status') == 'completed' ? 'bg-gray-500/20 border-gray-500 text-gray-300 font-bold' : 'border-slate-800 text-slate-400 hover:text-white' }}">
                            ⚪ সমাপ্ত
                        </a>
                    </div>
                </div>

                <!-- 4. Quick Action Box: Local Player Card Callout -->
                <div class="bg-gradient-to-br from-amber-950/40 via-slate-900 to-slate-950 border border-amber-500/40 rounded-3xl p-5 shadow-xl space-y-3 text-center">
                    <div class="text-3xl">🌟</div>
                    <h4 class="font-black text-sm text-white">আপনি কি টুর্নামেন্টে খেলতে চান?</h4>
                    <p class="text-xs text-slate-300">একাডেমির বাইরে থাকা যেকোনো এলাকার খেলোয়াড় উন্মুক্ত টুর্নামেন্টের জন্য সরাসরি রেজিস্ট্রেশন করুন।</p>
                    <a href="{{ route('public.local-players.create') }}" class="inline-block w-full py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-xs transition shadow-lg shadow-amber-500/20">
                        লোকাল প্লেয়ার রেজিস্ট্রেশন &rarr;
                    </a>
                </div>

            </aside>

            <!-- ============================================================== -->
            <!-- ➡️ RIGHT MAIN CONTENT: TOURNAMENTS SHOWCASE & GRID -->
            <!-- ============================================================== -->
            <div class="lg:col-span-9 space-y-8">

                <!-- Active Filter Tags Bar -->
                <div class="flex flex-wrap items-center justify-between gap-3 bg-slate-900/60 p-4 rounded-2xl border border-slate-800">
                    <div class="flex items-center gap-2 text-xs">
                        <span class="text-slate-400">ফিল্টার:</span>
                        @if(request('type'))
                            <span class="px-2.5 py-1 rounded-lg bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">
                                {{ request('type') == 'academic' ? '🎓 একাডেমি' : '🌟 লোকাল উন্মুক্ত' }}
                            </span>
                        @endif
                        @if(request('sport'))
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30 uppercase">
                                {{ request('sport') }}
                            </span>
                        @endif
                        @if(request('status'))
                            <span class="px-2.5 py-1 rounded-lg bg-rose-500/20 text-rose-300 font-bold border border-rose-500/30">
                                {{ request('status') }}
                            </span>
                        @endif
                        @if(!request()->hasAny(['type', 'sport', 'status', 'search']))
                            <span class="text-slate-300 font-semibold">সকল ক্যাটাগরি ও ডিসিপ্লিন</span>
                        @endif
                    </div>

                    @if(request()->hasAny(['type', 'sport', 'status', 'search']))
                        <a href="{{ route('public.tournaments.index') }}" class="text-xs text-rose-400 hover:underline">
                            ✕ ফিল্টার রিসেট
                        </a>
                    @endif
                </div>

                <!-- Featured / Live Ongoing Tournaments Hero Cards -->
                @if($featuredTournaments->count() > 0)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-black text-white flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                                <span>লাইভ ও চলমান টুর্নামেন্ট (Live Ongoing)</span>
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @foreach($featuredTournaments as $feat)
                                <div class="bg-gradient-to-br from-slate-900 via-[#0a1914] to-slate-950 border border-emerald-500/40 rounded-3xl p-6 shadow-2xl relative overflow-hidden group hover:border-emerald-400 transition space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            @if($feat->tournament_type === 'academic')
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                                    🎓 একাডেমি টুর্নামেন্ট
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-500/20 text-rose-300 border border-rose-500/40">
                                                    🌟 লোকাল টুর্নামেন্ট
                                                </span>
                                            @endif
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/10 text-slate-300">
                                                {{ $feat->sport_type }}
                                            </span>
                                        </div>
                                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-rose-400 bg-rose-500/10 px-2.5 py-1 rounded-full border border-rose-500/20">
                                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                            চলমান
                                        </span>
                                    </div>

                                    <div>
                                        <h3 class="text-xl font-black text-white group-hover:text-emerald-400 transition">
                                            {{ $feat->name }}
                                        </h3>
                                        <p class="text-xs text-slate-400 mt-1 flex items-center gap-2">
                                            <span>📍 {{ $feat->venue }}</span>
                                            <span>•</span>
                                            <span>🏆 {{ $feat->prize_pool ?? 'মেডেল ও ট্রফি' }}</span>
                                        </p>
                                    </div>

                                    <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-xs">
                                        <span class="text-slate-400 font-mono">
                                            দল: <strong class="text-white">{{ $feat->teams->count() }}</strong>টি • ম্যাচ: <strong class="text-white">{{ $feat->matches_count }}</strong>টি
                                        </span>
                                        <a href="{{ route('public.tournaments.show', $feat->slug) }}" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl text-xs transition shadow">
                                            ম্যাচ ও পয়েন্ট টেবিল &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tournaments Grid -->
                <div class="space-y-4">
                    <h2 class="text-base font-black text-white flex items-center gap-2">
                        <span>📋</span> টুর্নামেন্ট সূচি ও চ্যাম্পিয়নশিপ তালিকা
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @forelse($tournaments as $tourn)
                            <div class="bg-slate-900/90 border border-slate-800 hover:border-amber-500/50 rounded-3xl p-6 shadow-xl flex flex-col justify-between transition hover:-translate-y-1 relative group">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        @if($tourn->tournament_type === 'academic')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                                🎓 একাডেমি
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                                🌟 লোকাল
                                            </span>
                                        @endif

                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $tourn->status_badge['class'] }}">
                                            {{ $tourn->status_badge['label'] }}
                                        </span>
                                    </div>

                                    <div>
                                        <div class="text-2xl mb-1">
                                            @if($tourn->sport_type == 'football') ⚽
                                            @elseif($tourn->sport_type == 'cricket') 🏏
                                            @elseif($tourn->sport_type == 'badminton') 🏸
                                            @else 🏃
                                            @endif
                                        </div>
                                        <h3 class="text-lg font-black text-white leading-snug group-hover:text-amber-400 transition">
                                            {{ $tourn->name }}
                                        </h3>
                                        <p class="text-xs text-slate-400 mt-1 line-clamp-2">
                                            {{ $tourn->description ?? 'জামিরবাড়িয়া স্পোর্টস একাডেমি আয়োজিত টুর্নামেন্ট।' }}
                                        </p>
                                    </div>

                                    <div class="space-y-1.5 text-[11px] text-slate-300 pt-3 border-t border-slate-800">
                                        <div class="flex items-center justify-between">
                                            <span class="text-slate-400">ভেন্যু:</span>
                                            <span class="font-semibold text-white truncate max-w-[170px]">{{ $tourn->venue }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-slate-400">তারিখ:</span>
                                            <span class="font-mono text-slate-200">{{ $tourn->start_date ? $tourn->start_date->format('d M, Y') : 'শীঘ্রই' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-slate-400">পুরস্কার পুল:</span>
                                            <span class="font-bold text-amber-400">{{ $tourn->prize_pool ?? 'ট্রফি ও সম্মাননা' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 pt-4 border-t border-slate-800 flex items-center justify-between">
                                    <span class="text-[11px] text-slate-400">
                                        দল: <strong class="text-white">{{ $tourn->teams->count() }}</strong> / {{ $tourn->total_teams }}
                                    </span>
                                    <a href="{{ route('public.tournaments.show', $tourn->slug) }}" class="px-4 py-2 bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-white font-bold rounded-xl text-xs transition border border-slate-700">
                                        বিস্তারিত দেখুন &rarr;
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 py-16 text-center bg-slate-900/60 rounded-3xl border border-slate-800 space-y-3">
                                <div class="text-4xl">🏆</div>
                                <h3 class="font-bold text-white text-base">কোনো টুর্নামেন্ট পাওয়া যায়নি</h3>
                                <p class="text-xs text-slate-400">ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন।</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $tournaments->links() }}
                    </div>
                </div>

            </div>

        </div>
    </main>

</body>
</html>

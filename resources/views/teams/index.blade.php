<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>দল ও প্লেয়ার হাব | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-amber-500 selection:text-slate-950">

    <!-- Navbar -->
    <header x-data="{ mobileMenu: false }" class="border-b border-slate-800/80 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 sm:gap-4">
            <div class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                <a href="{{ url('/') }}" class="flex items-center space-x-2 min-w-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 flex items-center justify-center text-white font-black text-lg sm:text-xl shadow-lg shadow-amber-500/20 shrink-0">
                        🛡️
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs xs:text-base sm:text-lg font-black tracking-tight text-white block leading-tight truncate max-w-[130px] xs:max-w-[210px] sm:max-w-none">জামিরবাড়িয়া টিম হাব</span>
                        <span class="text-[7.5px] xs:text-[9px] sm:text-[10px] uppercase tracking-widest text-amber-400 font-semibold block truncate max-w-[130px] xs:max-w-none">TEAMS & PERFORMANCE HUB</span>
                    </div>
                </a>
            </div>

            <!-- Links -->
            <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-300">
                <a href="{{ route('public.teams.index') }}" class="text-amber-400 font-bold">সকল দল</a>
                <a href="{{ route('public.tournaments.index') }}" class="hover:text-amber-400 transition">টুর্নামেন্ট</a>
                <a href="{{ route('live.index') }}" class="hover:text-rose-400 transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                    লাইভ ম্যাচ
                </a>
                <a href="{{ route('public.local-players.create') }}" class="text-emerald-400 hover:text-emerald-300 transition">লোকাল প্লেয়ার পাস</a>
                <a href="{{ url('/') }}" class="hover:text-white transition">হোম</a>
            </nav>

            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                @auth
                    <a href="{{ route('admin.teams.index') }}" class="inline-flex items-center px-2.5 sm:px-3.5 py-1.5 sm:py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs sm:text-sm shadow transition">
                        ম্যানেজমেন্ট ⚙️
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-[11px] sm:text-xs font-semibold text-slate-400 hover:text-white border border-slate-700 px-2 sm:px-3 py-1 sm:py-1.5 rounded-xl">
                        লগইন
                    </a>
                @endauth

                <button @click="mobileMenu = !mobileMenu" aria-label="Toggle Mobile Menu" class="md:hidden p-1.5 sm:p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenu, 'block': !mobileMenu}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'block': mobileMenu, 'hidden': !mobileMenu}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenu" x-transition class="md:hidden border-t border-slate-800 bg-slate-900/95 px-4 py-4 space-y-2 text-sm font-semibold text-slate-200">
            <a href="{{ route('public.teams.index') }}" class="block px-3 py-2 rounded-xl text-amber-400 bg-slate-800 font-bold">🛡️ সকল দল ও স্কোয়াড</a>
            <a href="{{ route('public.tournaments.index') }}" class="block px-3 py-2 rounded-xl hover:bg-slate-800">🏆 টুর্নামেন্ট</a>
            <a href="{{ route('live.index') }}" class="block px-3 py-2 rounded-xl text-rose-400 hover:bg-slate-800">🔴 লাইভ ম্যাচ</a>
            <a href="{{ route('public.local-players.create') }}" class="block px-3 py-2 rounded-xl text-emerald-400 hover:bg-slate-800">🌟 লোকাল প্লেয়ার পাস</a>
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-xl hover:bg-slate-800">🏠 একাডেমি হোম</a>
        </div>
    </header>

    <!-- Athletic Stadium Floodlight Hero Header -->
    <section class="py-8 sm:py-12 bg-gradient-to-b from-slate-950 via-[#0a1815] to-slate-950 border-b border-slate-800 relative overflow-hidden">
        <div class="absolute top-0 right-1/3 w-[600px] h-[300px] bg-emerald-500/10 blur-[130px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 sm:gap-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2 sm:mb-3">
                        <span>🛡️</span> একাডেমি ও লোকাল চ্যাম্পিয়নশিপ স্কোয়াড
                    </div>
                    <h1 class="text-xl xs:text-2xl sm:text-5xl font-black text-white tracking-tight leading-snug">
                        টিম ডিরেক্টরি ও <span class="bg-gradient-to-r from-amber-400 via-rose-400 to-amber-300 bg-clip-text text-transparent">প্লেয়ার পারফরম্যান্স পোর্টাল</span>
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-base mt-1 sm:mt-2 max-w-2xl leading-relaxed">
                        একাডেমির সকল দল, খেলোয়াড় স্কোয়াড এবং প্রতিটি প্লেয়ারের ক্রিকইনফো-স্টাইল ব্যাটিং, বোলিং ও অলরাউন্ড পারফরম্যান্স রেকর্ড।
                    </p>
                </div>

                @auth
                    <div>
                        <a href="{{ route('admin.teams.create') }}" class="px-4 py-2.5 sm:px-5 sm:py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-black flex items-center gap-2 shadow-xl shadow-amber-500/20 transition">
                            <span>+ নতুন দল তৈরি করুন</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </section>

    <!-- Main Container: Left Category Sidebar + Right Teams Grid -->
    <main class="py-6 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- ============================================================== -->
            <!-- ⬅️ LEFT SIDEBAR: CATEGORY & SPORT SELECTOR WITH GLOW EFFECTS -->
            <!-- ============================================================== -->
            <aside class="lg:col-span-3 sticky top-24 space-y-6">

                <!-- 1. Category: Sports Disciplines Panel -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-3 backdrop-blur hover:border-amber-500/40 transition">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <h3 class="text-xs font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                            <span>🏆</span> খেলাধুলা ক্যাটাগরি
                        </h3>
                    </div>

                    <div class="space-y-1.5 text-xs font-bold">
                        <a href="{{ route('public.teams.index', array_merge(request()->except('sport', 'page'))) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ !request('sport') ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>⚡</span>
                                <span>সকল খেলা</span>
                            </span>
                            <span>✓</span>
                        </a>

                        <a href="{{ route('public.teams.index', array_merge(request()->except('page'), ['sport' => 'cricket'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('sport') == 'cricket' ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🏏</span>
                                <span>ক্রিকেট দল</span>
                            </span>
                        </a>

                        <a href="{{ route('public.teams.index', array_merge(request()->except('page'), ['sport' => 'football'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('sport') == 'football' ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>⚽</span>
                                <span>ফুটবল দল</span>
                            </span>
                        </a>

                        <a href="{{ route('public.teams.index', array_merge(request()->except('page'), ['sport' => 'badminton'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('sport') == 'badminton' ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🏸</span>
                                <span>ব্যাডমিন্টন</span>
                            </span>
                        </a>

                        <a href="{{ route('public.teams.index', array_merge(request()->except('page'), ['sport' => 'athletics'])) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request('sport') == 'athletics' ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center gap-2">
                                <span>🏃</span>
                                <span>অ্যাথলেটিক্স</span>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- 2. Category: Age / Squad Categories -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-3 backdrop-blur hover:border-emerald-500/40 transition">
                    <h3 class="text-xs font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-800">
                        <span>🎖️</span> স্কোয়াড ক্যাটাগরি
                    </h3>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="px-2.5 py-1 rounded-xl bg-slate-800/80 text-slate-300 border border-slate-700/60 font-semibold">U-12</span>
                        <span class="px-2.5 py-1 rounded-xl bg-slate-800/80 text-slate-300 border border-slate-700/60 font-semibold">U-14</span>
                        <span class="px-2.5 py-1 rounded-xl bg-slate-800/80 text-slate-300 border border-slate-700/60 font-semibold">U-16</span>
                        <span class="px-2.5 py-1 rounded-xl bg-slate-800/80 text-slate-300 border border-slate-700/60 font-semibold">U-19</span>
                        <span class="px-2.5 py-1 rounded-xl bg-amber-500/20 text-amber-300 border border-amber-500/40 font-bold">Senior Open</span>
                    </div>
                </div>

                <!-- 3. Quick Sector Links -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-950 border border-slate-800 rounded-3xl p-5 shadow-xl space-y-3">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">সম্পর্কিত সেক্টর</h4>
                    <div class="space-y-2 text-xs">
                        <a href="{{ route('public.tournaments.index') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-850 hover:bg-slate-800 text-slate-200 font-bold border border-slate-800 transition">
                            <span class="flex items-center gap-2">
                                <span>🏆</span> টুর্নামেন্ট সেক্টর
                            </span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('live.index') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-850 hover:bg-slate-800 text-slate-200 font-bold border border-slate-800 transition">
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span> লাইভ ম্যাচ হাব
                            </span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.local-players.create') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30 transition">
                            <span class="flex items-center gap-2">
                                <span>🌟</span> লোকাল প্লেয়ার পাস
                            </span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>

            </aside>

            <!-- ============================================================== -->
            <!-- ➡️ RIGHT MAIN CONTENT: TEAMS DIRECTORY GRID -->
            <!-- ============================================================== -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Results Header -->
                <div class="flex items-center justify-between bg-slate-900/60 p-4 rounded-2xl border border-slate-800 text-xs">
                    <span class="text-slate-400">
                        মোট প্রদর্শিত দল: <strong class="text-white">{{ $teams->count() }}</strong>টি
                    </span>
                    @if(request('sport'))
                        <a href="{{ route('public.teams.index') }}" class="text-amber-400 hover:underline">
                            ✕ ফিল্টার রিসেট
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($teams as $team)
                        <div class="bg-gradient-to-b from-slate-900 to-slate-900/90 border border-slate-800 hover:border-amber-500/60 rounded-3xl p-6 shadow-xl hover:shadow-2xl hover:shadow-amber-500/10 transition duration-300 flex flex-col justify-between group">
                            <div>
                                <!-- Header with Logo and Code -->
                                <div class="flex items-center justify-between gap-4 mb-4">
                                    <div class="flex items-center space-x-3.5">
                                        @if($team->logo)
                                            <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-amber-500/40 shadow-md">
                                        @else
                                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-rose-500 flex items-center justify-center text-slate-950 font-black text-2xl shadow-md border-2 border-amber-500/30">
                                                {{ mb_substr($team->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-base font-black text-white group-hover:text-amber-400 transition">{{ $team->name }}</h3>
                                            <span class="text-[10px] font-mono font-bold text-slate-400 bg-slate-800/80 px-2 py-0.5 rounded-md border border-slate-700">
                                                {{ $team->short_name ?? 'TEAM' }}
                                            </span>
                                        </div>
                                    </div>

                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg border {{ $team->sport_type == 'cricket' ? 'bg-teal-500/10 text-teal-300 border-teal-500/20' : 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20' }} uppercase">
                                        {{ $team->sport_type == 'cricket' ? '🏏 ক্রিকেট' : ($team->sport_type == 'football' ? '⚽ ফুটবল' : $team->sport_type) }}
                                    </span>
                                </div>

                                <!-- Team Meta: Category, Coach, Captain -->
                                <div class="bg-slate-950/60 rounded-2xl p-3.5 border border-slate-800/80 space-y-1.5 text-xs mb-4">
                                    <div class="flex items-center justify-between text-slate-300">
                                        <span class="text-slate-500 text-[11px]">ক্যাটাগরি:</span>
                                        <span class="font-bold text-amber-400">{{ $team->category ?? 'Senior' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-slate-300">
                                        <span class="text-slate-500 text-[11px]">অধিনায়ক:</span>
                                        <span class="font-semibold text-white">{{ $team->captain_name ?? 'নির্ধারণ বাকি' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-slate-300">
                                        <span class="text-slate-500 text-[11px]">প্রধান কোচ:</span>
                                        <span class="font-semibold text-white">{{ $team->coach_name ?? 'একাডেমি কোচ' }}</span>
                                    </div>
                                </div>

                                <!-- Win / Loss Strip -->
                                <div class="grid grid-cols-5 gap-1 text-center bg-slate-950/80 p-2 rounded-xl border border-slate-800 text-xs mb-4">
                                    <div class="bg-slate-900 p-1 rounded-lg">
                                        <span class="text-[9px] text-slate-400 block font-semibold">ম্যাচ</span>
                                        <span class="font-black text-white font-mono text-xs">{{ $team->matches_played }}</span>
                                    </div>
                                    <div class="bg-emerald-950/40 p-1 rounded-lg border border-emerald-500/20">
                                        <span class="text-[9px] text-emerald-400 block font-semibold">জয়</span>
                                        <span class="font-black text-emerald-400 font-mono text-xs">{{ $team->matches_won }}</span>
                                    </div>
                                    <div class="bg-rose-950/40 p-1 rounded-lg border border-rose-500/20">
                                        <span class="text-[9px] text-rose-400 block font-semibold">হার</span>
                                        <span class="font-black text-rose-400 font-mono text-xs">{{ $team->matches_lost }}</span>
                                    </div>
                                    <div class="bg-slate-900 p-1 rounded-lg">
                                        <span class="text-[9px] text-slate-400 block font-semibold">ড্র</span>
                                        <span class="font-black text-slate-300 font-mono text-xs">{{ $team->matches_drawn }}</span>
                                    </div>
                                    <div class="bg-amber-950/40 p-1 rounded-lg border border-amber-500/30">
                                        <span class="text-[9px] text-amber-400 block font-semibold">পয়েন্ট</span>
                                        <span class="font-black text-amber-400 font-mono text-xs">{{ $team->points }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Action -->
                            <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs">
                                <span class="text-slate-400 flex items-center gap-1.5 font-medium text-[11px]">
                                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                    {{ $team->players_count }} জন স্কোয়াড
                                </span>
                                <a href="{{ route('public.teams.show', $team->slug) }}" class="inline-flex items-center gap-1 px-3.5 py-1.5 bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950 border border-amber-500/30 rounded-xl font-bold transition">
                                    <span>স্কোয়াড দেখুন</span>
                                    <span>➔</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-slate-900/50 border border-slate-800 rounded-3xl">
                            <div class="text-5xl mb-4">🛡️</div>
                            <h3 class="text-lg font-bold text-white">কোনো টিম পাওয়া যায়নি</h3>
                            <p class="text-xs text-slate-400 mt-1">নির্বাচিত ফিল্টারে কোনো সক্রিয় দল নেই।</p>
                        </div>
                    @endforelse
                </div>

                @if($teams instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-6">
                        {{ $teams->links() }}
                    </div>
                @endif

            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-900/50 py-10 mt-16 text-center text-xs text-slate-500">
        <p>© {{ date('Y') }} জামিরবাড়িয়া স্পোর্টস একাডেমি • টিম ও প্লেয়ার পারফরম্যান্স সেন্টার</p>
    </footer>

</body>
</html>

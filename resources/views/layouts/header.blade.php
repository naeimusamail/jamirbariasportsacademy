<header class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-slate-800 bg-slate-900/80 px-4 backdrop-blur-md sm:px-6 lg:px-8">
    <!-- Left: Mobile Hamburger & Academy Brand / Breadcrumb -->
    <div class="flex items-center gap-3">
        <!-- Mobile Drawer Toggle Button -->
        <button type="button" 
                @click="sidebarOpen = true" 
                class="lg:hidden p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none transition"
                aria-label="Open sidebar navigation">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Brand Icon on Mobile -->
        <div class="lg:hidden flex items-center gap-2">
            <span class="text-xl">⚽</span>
            <span class="font-black text-sm text-white truncate">জামিরবাড়িয়া স্পোর্টস</span>
        </div>

        <!-- Desktop Tagline / Context -->
        <div class="hidden lg:flex items-center gap-2 text-xs text-slate-400 font-medium">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            <span>জামিরবাড়িয়া স্পোর্টস একাডেমি • সমন্বিত ম্যানেজমেন্ট প্ল্যাটফর্ম</span>
        </div>
    </div>

    <!-- Right: Quick Live Badges & User Profile Dropdown -->
    <div class="flex items-center gap-3">
        @php
            $hasLive = class_exists(\App\Models\LiveMatch::class) && \App\Models\LiveMatch::where('status', 'live')->exists();
        @endphp

        <!-- Live Scoreboard Quick Link -->
        <a href="{{ route('live.index') }}" target="_blank" 
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition {{ $hasLive ? 'bg-rose-500/10 border border-rose-500/30 text-rose-400 hover:bg-rose-600 hover:text-white' : 'bg-slate-800/80 border border-slate-700/60 text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <span class="w-2 h-2 rounded-full {{ $hasLive ? 'bg-rose-500 animate-ping' : 'bg-emerald-400' }}"></span>
            <span class="hidden sm:inline">{{ $hasLive ? 'লাইভ ম্যাচ চলছে' : 'লাইভ ম্যাচ' }}</span>
            <span class="text-[10px]">↗</span>
        </a>

        <!-- Tournament Hub Quick Link -->
        <a href="{{ route('public.tournaments.index') }}" target="_blank" 
           class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 hover:bg-amber-500 hover:text-slate-950 text-xs font-bold transition">
            <span>🏆</span>
            <span>টুর্নামেন্ট</span>
            <span class="text-[10px]">↗</span>
        </a>

        <!-- User Dropdown Menu -->
        <x-dropdown align="right" width="56">
            <x-slot name="trigger">
                <button class="inline-flex items-center gap-2 p-1.5 sm:px-3 sm:py-1.5 rounded-xl border border-slate-700/80 bg-slate-800/80 hover:bg-slate-700/80 text-xs font-semibold text-slate-200 transition focus:outline-none">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 font-black flex items-center justify-center text-xs">
                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="hidden sm:flex flex-col text-left leading-tight">
                        <span class="font-bold text-slate-100 max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-emerald-400 font-mono">
                            @if(Auth::user()->isPlayer()) প্লেয়ার
                            @elseif(Auth::user()->isCoach()) কোচ
                            @elseif(Auth::user()->isScorer()) স্কোরার
                            @else এডমিন
                            @endif
                        </span>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 hidden sm:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-3 border-b border-slate-700 bg-slate-900 text-xs">
                    <div class="font-bold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-emerald-400 font-mono mt-0.5">
                        {{ Auth::user()->username ? '@'.Auth::user()->username : Auth::user()->email }}
                    </div>
                    <div class="mt-2 pt-2 border-t border-slate-800 flex items-center justify-between text-[11px]">
                        <span class="text-slate-400">রোল:</span>
                        <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 font-bold">
                            @if(Auth::user()->isPlayer()) অ্যাথলেট (Player)
                            @elseif(Auth::user()->isCoach()) প্রশিক্ষক (Coach)
                            @elseif(Auth::user()->isScorer()) ম্যাচ স্কোরার (Scorer)
                            @else একাডেমি এডমিন (Admin)
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Admin Quick Switcher -->
                <div class="py-1 border-b border-slate-800">
                    <div class="px-4 py-1 text-[9px] font-bold text-slate-400 uppercase tracking-wider">ড্যাশবোর্ড ভিউ:</div>
                    <x-dropdown-link :href="route('dashboard.admin')">🛡️ এডমিন ড্যাশবোর্ড</x-dropdown-link>
                    <x-dropdown-link :href="route('dashboard.coach')">📋 কোচ ড্যাশবোর্ড</x-dropdown-link>
                    <x-dropdown-link :href="route('dashboard.player')">⚽ প্লেয়ার ড্যাশবোর্ড</x-dropdown-link>
                </div>

                @if(Auth::user()->isPlayer())
                    <x-dropdown-link :href="route('profile.player')">
                        🏃‍♂️ {{ __('আমার প্লেয়ার প্রোফাইল') }}
                    </x-dropdown-link>
                @elseif(Auth::user()->isCoach())
                    <x-dropdown-link :href="route('profile.coach')">
                        📋 {{ __('আমার কোচ প্রোফাইল') }}
                    </x-dropdown-link>
                @endif

                <x-dropdown-link :href="route('profile.edit')">
                    ⚙️ {{ __('অ্যাকাউন্ট সেটিংস') }}
                </x-dropdown-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-rose-400 hover:text-rose-300">
                        🚪 {{ __('লগ আউট') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>


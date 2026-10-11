<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>অফিসিয়াল বিজ্ঞপ্তি ও নোটিশ হাব | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.4);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.7);
        }
    </style>
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-slate-950 sports-turf-mesh">

    <!-- Top Athletic Navbar -->
    <header x-data="{ mobileMenu: false }" class="border-b border-slate-800/80 bg-slate-900/95 backdrop-blur-md sticky top-0 z-50 transition-all duration-300 shadow-xl shadow-slate-950/40">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 sm:gap-4">
            <a href="{{ url('/') }}" class="flex items-center space-x-2 sm:space-x-3 shrink-0 group min-w-0">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-400 to-amber-400 flex items-center justify-center text-slate-950 font-black text-lg sm:text-2xl shadow-xl shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-300 shrink-0">
                    ⚽
                </div>
                <div class="min-w-0">
                    <span class="text-xs xs:text-base sm:text-xl font-black tracking-tight text-white block leading-tight truncate max-w-[130px] xs:max-w-[210px] sm:max-w-none">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
                    <span class="text-[7.5px] xs:text-[9px] sm:text-[10px] uppercase tracking-widest text-emerald-400 font-bold block truncate max-w-[130px] xs:max-w-none">Jamirbaria Sports Academy</span>
                </div>
            </a>

            <!-- Center Navigation (Clean, Aligned, Single-Line) -->
            <nav class="hidden lg:flex items-center space-x-1 xl:space-x-2 text-xs xl:text-sm font-bold text-slate-300">
                <!-- 1. নোটিশ ও সার্কুলার (Active Page) -->
                <a href="{{ route('public.notice-board') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-emerald-300 bg-emerald-500/15 border border-emerald-500/40 shadow-sm shadow-emerald-500/20 font-black group">
                    <span class="text-emerald-400">📢</span>
                    <span>নোটিশ ও সার্কুলার</span>
                    <span class="absolute bottom-0.5 left-2.5 right-2.5 h-0.5 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full"></span>
                </a>
                <!-- 2. লাইভ ম্যাচ (Placed right after Notice) -->
                <a href="{{ url('/#live-matches') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-rose-300 hover:bg-slate-800/70 border border-transparent hover:border-rose-500/30 group">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    <span>লাইভ ম্যাচ</span>
                </a>
                <!-- 3. স্পোর্টস কারিকুলাম -->
                <a href="{{ url('/#sports-hub') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-white hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-emerald-400 group-hover:rotate-12 transition-transform">⚽</span>
                    <span>খেলাধুলা ও কারিকুলাম</span>
                </a>
                <!-- 4. টুর্নামেন্ট -->
                <a href="{{ route('public.tournaments.index') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-amber-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-amber-400 group-hover:scale-110 transition-transform">🏆</span>
                    <span>টুর্নামেন্ট</span>
                </a>
                <!-- 5. টিম ও স্কোয়াড -->
                <a href="{{ route('public.teams.index') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-cyan-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-cyan-400 group-hover:scale-110 transition-transform">🛡️</span>
                    <span>টিম ও স্কোয়াড</span>
                </a>
                <!-- 6. একাডেমি রুলস -->
                <a href="{{ route('rules') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-amber-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-amber-400 group-hover:rotate-6 transition-transform">📜</span>
                    <span>একাডেমি রুলস</span>
                </a>
            </nav>

            <!-- Right: Auth + Single Online Application CTA Button (No duplicate!) -->
            <div class="flex items-center space-x-1.5 sm:space-x-3 shrink-0">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-2 sm:px-3.5 py-1 sm:py-2 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl text-[11px] sm:text-sm border border-slate-700 transition-all duration-300 shadow hover:border-emerald-500/40 whitespace-nowrap">
                            ড্যাশবোর্ড
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[11px] sm:text-sm font-bold text-slate-300 hover:text-white px-1.5 sm:px-3 py-1 sm:py-2 rounded-xl hover:bg-slate-800/60 transition whitespace-nowrap">
                            লগইন
                        </a>
                    @endauth
                @endif

                <!-- Single Primary Online Application Button -->
                <a href="{{ route('public.apply') }}" class="relative group inline-flex items-center gap-1 sm:gap-2 px-2.5 sm:px-5 py-1 sm:py-2.5 bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-500 hover:from-emerald-400 hover:to-teal-300 text-slate-950 font-black rounded-xl text-xs sm:text-sm transition-all duration-300 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5 active:translate-y-0 whitespace-nowrap overflow-hidden">
                    <span class="text-xs sm:text-sm">🚀</span>
                    <span><span class="hidden xs:inline">অনলাইন </span>আবেদন</span>
                    <span class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 ease-out pointer-events-none"></span>
                </a>

                <!-- Hamburger button for mobile -->
                <button @click="mobileMenu = !mobileMenu" aria-label="Toggle Mobile Menu" class="lg:hidden p-1.5 sm:p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenu, 'block': !mobileMenu}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'block': mobileMenu, 'hidden': !mobileMenu}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile dropdown drawer -->
        <div x-show="mobileMenu" x-transition class="lg:hidden border-t border-slate-800 bg-slate-900/98 px-4 py-4 space-y-2 text-sm font-semibold text-slate-200">
            <a href="{{ route('public.apply') }}" class="block px-3.5 py-2.5 rounded-xl text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 font-black text-center shadow-lg shadow-emerald-500/20">🚀 অনলাইন আবেদন (ভর্তি • লোকাল প্লেয়ার • ভলান্টিয়ার)</a>
            <a href="{{ route('public.notice-board') }}" class="block px-3.5 py-2 rounded-xl text-emerald-400 bg-slate-800 font-bold">📢 নোটিশ ও সার্কুলার হাব</a>
            <a href="{{ url('/#live-matches') }}" class="block px-3.5 py-2 rounded-xl text-rose-400 hover:bg-slate-800 font-bold">🔴 লাইভ ম্যাচ</a>
            <a href="{{ url('/#sports-hub') }}" class="block px-3.5 py-2 rounded-xl hover:bg-slate-800 font-bold">⚽ খেলাধুলা ও কারিকুলাম</a>
            <a href="{{ route('public.tournaments.index') }}" class="block px-3.5 py-2 rounded-xl text-amber-400 hover:bg-slate-800 font-bold">🏆 টুর্নামেন্ট</a>
            <a href="{{ route('public.teams.index') }}" class="block px-3.5 py-2 rounded-xl text-cyan-400 hover:bg-slate-800 font-bold">🛡️ টিম ও স্কোয়াড</a>
            <a href="{{ route('rules') }}" class="block px-3.5 py-2 rounded-xl hover:bg-slate-800 font-bold">📜 একাডেমি রুলস ও টার্মস</a>
        </div>
    </header>

    <div x-data="{ activeNotice: null, activeCircular: null, tab: 'circulars', filterType: 'all' }">

        <!-- ============================================================== -->
        <!-- 📋 DEDICATED OFFICIAL NOTICE BOARD & REGISTRATION CIRCULARS HUB -->
        <!-- ============================================================== -->
        <main class="py-6 sm:py-16 relative">
            <!-- Glow effects -->
            <div class="absolute top-10 left-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <!-- Page Header & Tab Pill Switcher -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-6 sm:mb-10 pb-4 sm:pb-8 border-b border-slate-800">
                    <div>
                        <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2 sm:mb-3">
                            <span>📢</span> অফিসিয়াল ডিজিটাল নোটিশ ও সার্কুলার পোর্টাল
                        </div>
                        <h1 class="text-xl xs:text-2xl sm:text-5xl font-black text-white tracking-tight leading-snug">
                            অফিসিয়াল বিজ্ঞপ্তি ও <span class="bg-gradient-to-r from-emerald-400 to-amber-400 bg-clip-text text-transparent">নোটিশ হাব</span>
                        </h1>
                        <p class="text-slate-400 text-xs sm:text-sm mt-1 sm:mt-2 max-w-2xl leading-relaxed">
                            একাডেমি ভর্তি বিজ্ঞপ্তি, টুর্নামেন্ট সময়সূচী, ড্রাফট সার্কুলার ও প্রাতিষ্ঠানিক নোটিশের সমন্বিত অফিসিয়াল নোটিশ বোর্ড।
                        </p>
                    </div>

                    <!-- Tab Controller Buttons -->
                    <div class="flex items-center gap-1.5 sm:gap-2 p-1 sm:p-1.5 bg-slate-900 border border-slate-800 rounded-xl sm:rounded-2xl shrink-0 self-stretch md:self-auto shadow-xl w-full md:w-auto">
                        <button @click="tab = 'circulars'"
                                :class="tab === 'circulars' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-black shadow-lg shadow-emerald-500/20' : 'text-slate-400 hover:text-white font-bold'"
                                class="flex-1 md:flex-none px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg sm:rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-1 sm:gap-2 text-center">
                            <span>📅</span>
                            <span>সার্কুলার ({{ isset($allCirculars) ? $allCirculars->count() : 0 }})</span>
                        </button>
                        <button @click="tab = 'notices'"
                                :class="tab === 'notices' ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black shadow-lg shadow-amber-500/20' : 'text-slate-400 hover:text-white font-bold'"
                                class="flex-1 md:flex-none px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg sm:rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-1 sm:gap-2 text-center">
                            <span>📌</span>
                            <span>নোটিশ ({{ isset($notices) ? $notices->total() : 0 }})</span>
                        </button>
                    </div>
                </div>

                <!-- TAB 1: REGISTRATION CIRCULARS -->
                <div x-show="tab === 'circulars'" x-transition class="space-y-4 sm:space-y-6">
                    <!-- Circular Filter Buttons -->
                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 pb-2">
                        <button @click="filterType = 'all'" :class="filterType === 'all' ? 'bg-slate-800 text-emerald-400 border-emerald-500/40' : 'bg-slate-900/80 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-bold border transition">
                            সকল সার্কুলার
                        </button>
                        <button @click="filterType = 'admission'" :class="filterType === 'admission' ? 'bg-slate-800 text-emerald-400 border-emerald-500/40' : 'bg-slate-900/80 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-bold border transition">
                            🎓 একাডেমি ভর্তি
                        </button>
                        <button @click="filterType = 'volunteer'" :class="filterType === 'volunteer' ? 'bg-slate-800 text-emerald-400 border-emerald-500/40' : 'bg-slate-900/80 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-bold border transition">
                            🤝 ভলান্টিয়ার নিবন্ধন
                        </button>
                        <button @click="filterType = 'local_player'" :class="filterType === 'local_player' ? 'bg-slate-800 text-emerald-400 border-emerald-500/40' : 'bg-slate-900/80 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-bold border transition">
                            ⚡ লোকাল টুর্নামেন্ট ড্রাফট
                        </button>
                        <button @click="filterType = 'tournament'" :class="filterType === 'tournament' ? 'bg-slate-800 text-emerald-400 border-emerald-500/40' : 'bg-slate-900/80 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-bold border transition">
                            🏆 টুর্নামেন্ট সার্কুলার
                        </button>
                    </div>

                    <!-- Circulars Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @if(isset($allCirculars))
                            @forelse($allCirculars as $c)
                                @php
                                    $isTourn = $c->tournament_id || str_starts_with($c->type, 'tournament_');
                                    $catKey = $isTourn ? 'tournament' : $c->type;
                                    $badge = $c->status_badge;
                                    $status = $c->getStatus();
                                @endphp
                                <div x-show="filterType === 'all' || filterType === '{{ $catKey }}'"
                                     id="circular-{{ $c->id }}"
                                     class="bg-slate-900/90 border border-slate-800 hover:border-slate-700 rounded-2xl sm:rounded-3xl p-4 sm:p-6 flex flex-col justify-between space-y-4 sm:space-y-5 transition shadow-xl relative overflow-hidden group">
                                    
                                    <!-- Top Status & Type Row -->
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-3">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $badge['bg'] }}">
                                                    <span class="w-2 h-2 rounded-full {{ $badge['dot'] }} {{ $status === 'open' ? 'animate-ping' : '' }}"></span>
                                                    {{ $badge['label'] }}
                                                </span>
                                                @if($c->fee)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30 font-mono">
                                                        ফি: ৳{{ number_format($c->fee) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-[11px] font-mono font-bold text-slate-400 uppercase tracking-wider">
                                                {{ $c->type_icon }} {{ $c->type_name }}
                                            </span>
                                        </div>

                                        <h3 class="text-lg font-black text-white group-hover:text-emerald-300 transition cursor-pointer"
                                            @click="activeCircular = {{ json_encode([
                                                'id' => $c->id,
                                                'title' => $c->title,
                                                'type_name' => $c->type_name,
                                                'type_icon' => $c->type_icon,
                                                'status' => $status,
                                                'status_label' => $c->status_label,
                                                'badge_bg' => $badge['bg'],
                                                'badge_dot' => $badge['dot'],
                                                'start_date' => $c->start_date ? $c->start_date->format('d M Y, h:i A') : 'উন্মুক্ত',
                                                'end_date' => $c->end_date ? $c->end_date->format('d M Y, h:i A') : 'পরবর্তী ঘোষণা',
                                                'fee' => $c->fee ? number_format($c->fee) : null,
                                                'description' => $c->description ?: 'একাডেমির অফিসিয়াল রেজিস্ট্রেশন বিজ্ঞপ্তি।',
                                                'apply_url' => $c->apply_url,
                                                'tournament_venue' => $c->tournament?->venue,
                                                'tournament_entry_fee' => $c->tournament?->entry_fee ? number_format($c->tournament->entry_fee) : null,
                                                'upcoming_message' => $c->upcoming_message,
                                                'closed_message' => $c->closed_message,
                                            ]) }}">
                                            {{ $c->title }}
                                        </h3>

                                        <p class="text-xs text-slate-400 mt-2 line-clamp-3 leading-relaxed">
                                            {{ $c->description ?: 'একাডেমির অফিসিয়াল রেজিস্ট্রেশন বিজ্ঞপ্তি।' }}
                                        </p>

                                        @if($c->tournament)
                                            <div class="mt-3 p-2.5 rounded-xl bg-slate-950 border border-slate-800 text-[11px] text-slate-300 space-y-1">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-slate-400">ভেন্যু:</span>
                                                    <span class="font-bold text-white">{{ $c->tournament->venue ?: 'একাডেমি গ্রাউন্ড' }}</span>
                                                </div>
                                                @if($c->tournament->entry_fee > 0)
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-slate-400">টিম এন্ট্রি ফি:</span>
                                                        <span class="font-bold text-amber-400">৳{{ number_format($c->tournament->entry_fee) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Schedule & Actions Bottom -->
                                    <div class="pt-4 border-t border-slate-800/80 space-y-3">
                                        <div class="grid grid-cols-2 gap-2 text-[11px]">
                                            <div class="bg-slate-950/70 p-2.5 rounded-xl border border-slate-800/60">
                                                <div class="text-slate-500 font-semibold">আবেদন শুরু:</div>
                                                <div class="font-mono font-bold text-slate-200 mt-0.5">
                                                    {{ $c->start_date ? $c->start_date->format('d M, Y') : 'অব্যাহত' }}
                                                </div>
                                            </div>
                                            <div class="bg-slate-950/70 p-2.5 rounded-xl border border-slate-800/60">
                                                <div class="text-slate-500 font-semibold">শেষ সময়সীমা:</div>
                                                <div class="font-mono font-bold {{ $c->isClosed() ? 'text-rose-400' : 'text-emerald-400' }} mt-0.5">
                                                    {{ $c->end_date ? $c->end_date->format('d M, Y') : 'পরবর্তী ঘোষণা' }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quick Details Button & Direct Apply Button -->
                                        <div class="space-y-2">
                                            <button type="button"
                                                    @click="activeCircular = {{ json_encode([
                                                        'id' => $c->id,
                                                        'title' => $c->title,
                                                        'type_name' => $c->type_name,
                                                        'type_icon' => $c->type_icon,
                                                        'status' => $status,
                                                        'status_label' => $c->status_label,
                                                        'badge_bg' => $badge['bg'],
                                                        'badge_dot' => $badge['dot'],
                                                        'start_date' => $c->start_date ? $c->start_date->format('d M Y, h:i A') : 'উন্মুক্ত',
                                                        'end_date' => $c->end_date ? $c->end_date->format('d M Y, h:i A') : 'পরবর্তী ঘোষণা',
                                                        'fee' => $c->fee ? number_format($c->fee) : null,
                                                        'description' => $c->description ?: 'একাডেমির অফিসিয়াল রেজিস্ট্রেশন বিজ্ঞপ্তি।',
                                                        'apply_url' => $c->apply_url,
                                                        'tournament_venue' => $c->tournament?->venue,
                                                        'tournament_entry_fee' => $c->tournament?->entry_fee ? number_format($c->tournament->entry_fee) : null,
                                                        'upcoming_message' => $c->upcoming_message,
                                                        'closed_message' => $c->closed_message,
                                                    ]) }}"
                                                    class="w-full py-2 px-3 bg-slate-950 hover:bg-slate-850 border border-slate-800 hover:border-slate-700 text-slate-300 font-bold rounded-xl text-[11px] transition flex items-center justify-center gap-1.5">
                                                <span>ℹ️ সার্কুলার বিবরণী ও শর্তাবলী</span>
                                            </button>

                                            @if($status === 'open')
                                                <a href="{{ $c->apply_url }}" class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black rounded-xl text-xs transition shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                                                    <span>আবেদন ফরম পূরণ করুন</span>
                                                    <span>➔</span>
                                                </a>
                                            @elseif($status === 'upcoming')
                                                <div class="w-full py-2 px-3 bg-amber-500/10 border border-amber-500/30 text-amber-300 rounded-xl text-xs font-bold text-center">
                                                    ⏳ {{ $c->upcoming_message ?: 'শীঘ্রই আবেদন গ্রহণ শুরু হবে' }}
                                                </div>
                                            @elseif($status === 'closed')
                                                <div class="w-full py-2 px-3 bg-rose-500/10 border border-rose-500/30 text-rose-300 rounded-xl text-xs font-bold text-center">
                                                    🛑 {{ $c->closed_message ?: 'আবেদনের সময়সীমা সমাপ্ত হয়েছে' }}
                                                </div>
                                            @else
                                                <div class="w-full py-2 px-3 bg-slate-800 text-slate-400 rounded-xl text-xs font-semibold text-center">
                                                    সাময়িক স্থগিত
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full bg-slate-900 border border-slate-800 rounded-3xl p-12 text-center text-slate-400">
                                    বর্তমানে কোনো রেজিস্ট্রেশন সার্কুলার সক্রিয় নেই।
                                </div>
                            @endforelse
                        @endif
                    </div>
                </div>

                <!-- TAB 2: OFFICIAL NOTICE BOARD -->
                <div x-show="tab === 'notices'" x-transition class="space-y-4 sm:space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @if(isset($notices))
                            @forelse($notices as $notice)
                                <div id="notice-{{ $notice->id }}"
                                     class="bg-slate-900/90 border {{ $notice->is_pinned ? 'border-amber-500/40 bg-gradient-to-b from-amber-950/15 to-slate-900' : 'border-slate-800 hover:border-slate-700' }} rounded-2xl sm:rounded-3xl p-4 sm:p-6 flex flex-col justify-between space-y-3.5 sm:space-y-4 transition shadow-xl relative group">
                                    
                                    <div>
                                        <!-- Notice Meta Badges -->
                                        <div class="flex items-center justify-between gap-2 mb-3">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                @if($notice->is_pinned)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                                        📌 জরুরি নোটিশ
                                                    </span>
                                                @endif
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                                                    {{ $notice->sport->name ?? 'সকল বিভাগ' }}
                                                </span>
                                            </div>
                                            <span class="text-[11px] font-mono text-slate-400">
                                                {{ \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y') }}
                                            </span>
                                        </div>

                                        <h3 class="text-base font-black text-white group-hover:text-amber-300 transition line-clamp-2">
                                            {{ $notice->title }}
                                        </h3>

                                        <p class="text-xs text-slate-300 mt-2 line-clamp-4 leading-relaxed whitespace-pre-line">
                                            {{ $notice->content }}
                                        </p>
                                    </div>

                                    <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between">
                                        <button @click="activeNotice = {{ json_encode([
                                            'title' => $notice->title,
                                            'sport' => $notice->sport->name ?? 'সকল বিভাগ',
                                            'date' => \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y'),
                                            'content' => $notice->content,
                                            'is_pinned' => (bool) $notice->is_pinned,
                                        ]) }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition flex items-center gap-1">
                                            <span>সম্পূর্ণ নোটিশ পড়ুন</span>
                                            <span>➔</span>
                                        </button>
                                        <span class="text-[10px] text-slate-500 font-mono">অফিসিয়াল নোটিশ</span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full bg-slate-900 border border-slate-800 rounded-3xl p-12 text-center text-slate-400">
                                    বর্তমানে নোটিশ বোর্ডে কোনো সাধারণ নোটিশ নেই।
                                </div>
                            @endforelse
                        @endif
                    </div>

                    @if(isset($notices) && $notices->hasPages())
                        <div class="pt-6">
                            {{ $notices->links() }}
                        </div>
                    @endif
                </div>

                <!-- Admin Notice Management Link if Authenticated -->
                @auth
                    @if(auth()->user()->role === 'admin')
                        <div class="mt-12 p-5 rounded-2xl bg-slate-900/80 border border-slate-800 flex flex-wrap items-center justify-between gap-4">
                            <div class="text-xs text-slate-400">
                                🛡️ <strong class="text-white">এডমিন প্যানেল কন্ট্রোল:</strong> আপনি এডমিন হিসেবে নোটিশ বা সার্কুলার পরিবর্তন ও নতুন যোগ করতে পারেন
                            </div>
                            <div class="flex items-center gap-2.5">
                                <a href="{{ route('admin.circulars.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-emerald-500/30 rounded-xl text-xs font-bold transition">
                                    ⚙️ সার্কুলার সময়সূচী হাব
                                </a>
                                <a href="{{ route('notices.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-slate-950 rounded-xl text-xs font-bold transition">
                                    + নতুন নোটিশ দিন
                                </a>
                            </div>
                        </div>
                    @endif
                @endauth

            </div>
        </main>

        <!-- Modal for viewing full notice -->
        <div x-show="activeNotice"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-950/80 backdrop-blur-sm"
             @keydown.escape.window="activeNotice = null">
            <div @click.away="activeNotice = null" class="bg-slate-900 border border-slate-700 max-w-2xl w-full rounded-3xl p-4 sm:p-8 shadow-2xl space-y-4 sm:space-y-5 text-left relative max-h-[85vh] overflow-y-auto">
                <div class="flex items-start justify-between gap-4 border-b border-slate-800 pb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <template x-if="activeNotice?.is_pinned">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                    📌 জরুরি নোটিশ
                                </span>
                            </template>
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-800 text-slate-300" x-text="activeNotice?.sport"></span>
                            <span class="text-xs text-slate-400 font-mono" x-text="'তারিখ: ' + activeNotice?.date"></span>
                        </div>
                        <h3 class="text-lg sm:text-xl font-black text-white" x-text="activeNotice?.title"></h3>
                    </div>
                    <button @click="activeNotice = null" class="text-slate-400 hover:text-white p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-sm font-bold">
                        ✕
                    </button>
                </div>

                <div class="text-sm text-slate-200 leading-relaxed whitespace-pre-line bg-slate-950/60 p-4 sm:p-5 rounded-2xl border border-slate-800/80" x-text="activeNotice?.content"></div>

                <div class="flex items-center justify-between pt-2">
                    <button onclick="window.print()" class="px-3 sm:px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-bold flex items-center gap-1.5 transition">
                        <span>🖨️</span> <span class="hidden xs:inline">নোটিশ </span>প্রিন্ট
                    </button>
                    <button @click="activeNotice = null" class="px-4 sm:px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-bold rounded-xl text-xs transition">
                        বন্ধ করুন
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal for viewing full Circular Details and Direct Apply -->
        <div x-show="activeCircular"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-950/85 backdrop-blur-md"
             @keydown.escape.window="activeCircular = null">
            <div @click.away="activeCircular = null" class="bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-700 max-w-2xl w-full rounded-3xl p-4 sm:p-8 shadow-2xl space-y-4 sm:space-y-6 text-left relative max-h-[85vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex items-start justify-between gap-4 border-b border-slate-800 pb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border" :class="activeCircular?.badge_bg">
                                <span class="w-1.5 h-1.5 rounded-full inline-block mr-1" :class="activeCircular?.badge_dot"></span>
                                <span x-text="activeCircular?.status_label"></span>
                            </span>
                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-mono font-bold bg-slate-800 text-slate-300 border border-slate-700" x-text="activeCircular?.type_name"></span>
                            <template x-if="activeCircular?.fee">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30" x-text="'ফি: ৳' + activeCircular?.fee"></span>
                            </template>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white leading-tight" x-text="activeCircular?.title"></h3>
                    </div>
                    <button @click="activeCircular = null" class="text-slate-400 hover:text-white p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-sm font-bold shrink-0">
                        ✕
                    </button>
                </div>

                <!-- Meta Information Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div class="bg-slate-950/70 p-3.5 rounded-2xl border border-slate-800/80 space-y-1">
                        <span class="text-slate-400 font-semibold block text-[11px]">🚀 আবেদন শুরুর সময়:</span>
                        <span class="font-mono font-bold text-slate-100" x-text="activeCircular?.start_date"></span>
                    </div>
                    <div class="bg-slate-950/70 p-3.5 rounded-2xl border border-slate-800/80 space-y-1">
                        <span class="text-slate-400 font-semibold block text-[11px]">🛑 আবেদনের শেষ সময় (ডেডলাইন):</span>
                        <span class="font-mono font-bold" :class="activeCircular?.status === 'closed' ? 'text-rose-400' : 'text-emerald-400'" x-text="activeCircular?.end_date"></span>
                    </div>
                </div>

                <!-- Tournament Specific Details if available -->
                <template x-if="activeCircular?.tournament_venue">
                    <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 text-xs space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">🏟️ খেলার মাঠ / ভেন্যু:</span>
                            <span class="font-bold text-white" x-text="activeCircular?.tournament_venue"></span>
                        </div>
                        <template x-if="activeCircular?.tournament_entry_fee">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">💰 টিম এন্ট্রি ফি:</span>
                                <span class="font-bold text-amber-400" x-text="'৳' + activeCircular?.tournament_entry_fee"></span>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Circular Description / Guidelines -->
                <div class="space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">সার্কুলার বিবরণী ও নিয়মাবলী:</span>
                    <div class="text-sm text-slate-200 leading-relaxed whitespace-pre-line bg-slate-950/70 p-5 rounded-2xl border border-slate-800/80" x-text="activeCircular?.description"></div>
                </div>

                <!-- Upcoming Notice alert if upcoming -->
                <template x-if="activeCircular?.status === 'upcoming' && activeCircular?.upcoming_message">
                    <div class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs">
                        ⏳ <strong class="text-white">আসন্ন নোটিশ:</strong> <span x-text="activeCircular?.upcoming_message"></span>
                    </div>
                </template>

                <!-- Closed Notice alert if closed -->
                <template x-if="activeCircular?.status === 'closed' && activeCircular?.closed_message">
                    <div class="p-3.5 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs">
                        🛑 <strong class="text-white">সময়সীমা সমাপ্ত:</strong> <span x-text="activeCircular?.closed_message"></span>
                    </div>
                </template>

                <!-- Modal Actions & Direct Apply CTA -->
                <div class="pt-3 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <button @click="activeCircular = null" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-xs transition text-center">
                        বন্ধ করুন
                    </button>

                    <template x-if="activeCircular?.status === 'open'">
                        <a :href="activeCircular?.apply_url"
                           class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black rounded-xl text-sm transition shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2">
                            <span>এই সার্কুলারে আবেদন করুন</span>
                            <span>➔</span>
                        </a>
                    </template>

                    <template x-if="activeCircular?.status === 'upcoming'">
                        <div class="px-5 py-2.5 bg-amber-500/20 text-amber-300 rounded-xl text-xs font-bold border border-amber-500/30 text-center">
                            ⏳ শীঘ্রই আবেদন গ্রহণ শুরু হবে
                        </div>
                    </template>

                    <template x-if="activeCircular?.status === 'closed'">
                        <div class="px-5 py-2.5 bg-rose-500/20 text-rose-300 rounded-xl text-xs font-bold border border-rose-500/30 text-center">
                            🛑 আবেদনের সময়সীমা শেষ
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-950 py-12 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 space-y-4">
            <div class="flex items-center justify-center gap-2">
                <span>⚽</span>
                <span class="font-bold text-slate-300">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
                <span>•</span>
                <span>অফিসিয়াল বিজ্ঞপ্তি ও নোটিশ হাব</span>
            </div>
            <div>
                © {{ date('Y') }} Jamirbaria Sports Academy. সর্বস্বত্ব সংরক্ষিত।
            </div>
        </div>
    </footer>

</body>
</html>


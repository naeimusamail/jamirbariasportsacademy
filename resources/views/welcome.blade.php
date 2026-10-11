<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>জামিরবাড়িয়া স্পোর্টস একাডেমি | Jamirbaria Sports Academy</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 35s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.4);
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.8);
        }
        @media (min-width: 1024px) {
            .hero-layout-grid {
                display: grid !important;
                grid-template-columns: 1fr 420px !important;
                gap: 2.5rem !important;
                align-items: stretch !important;
            }
        }
        @media (min-width: 1280px) {
            .hero-layout-grid {
                grid-template-columns: 1fr 460px !important;
                gap: 3rem !important;
            }
        }
        @media (min-width: 1536px) {
            .hero-layout-grid {
                grid-template-columns: 1fr 500px !important;
                gap: 3.5rem !important;
            }
        }
        @media (max-width: 1023px) {
            .hero-layout-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 2rem !important;
            }
        }
    </style>
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-slate-950 sports-turf-mesh">

    <!-- Top Athletic Navbar -->
    <header x-data="{
        mobileMenu: false,
        activeSection: 'hero',
        init() {
            const sections = [
                { id: 'hero', name: 'hero' },
                { id: 'live-matches', name: 'live' },
                { id: 'sports-hub', name: 'sports' },
                { id: 'tournaments', name: 'tournaments' },
                { id: 'teams', name: 'teams' },
                { id: 'volunteer-wing', name: 'volunteer' }
            ];
            const onScroll = () => {
                const scrollPosition = window.scrollY + 140;
                for (let i = sections.length - 1; i >= 0; i--) {
                    const el = document.getElementById(sections[i].id);
                    if (el && el.offsetTop <= scrollPosition) {
                        this.activeSection = sections[i].name;
                        return;
                    }
                }
                this.activeSection = 'hero';
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        },
        scrollTo(id) {
            this.mobileMenu = false;
            const el = document.getElementById(id);
            if (el) {
                const yOffset = -75;
                const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        }
    }" class="border-b border-slate-800/80 bg-slate-900/95 backdrop-blur-md sticky top-0 z-50 transition-all duration-300 shadow-xl shadow-slate-950/40">
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-1.5 sm:gap-4">
            
            <!-- Academy Brand Identity -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2 sm:space-x-3 shrink-0 group min-w-0">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-400 to-amber-400 flex items-center justify-center text-slate-950 font-black text-lg sm:text-2xl shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-300 shrink-0">
                    ⚽
                </div>
                <div class="min-w-0">
                    <span class="text-xs xs:text-sm sm:text-xl font-black tracking-tight text-white block leading-tight truncate max-w-[130px] xs:max-w-[200px] sm:max-w-none">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
                    <span class="text-[7.5px] xs:text-[8.5px] sm:text-[10px] uppercase tracking-widest text-emerald-400 font-bold block truncate max-w-[130px] xs:max-w-none">Jamirbaria Sports Academy</span>
                </div>
            </a>

            <!-- Category Navigation Links (Clean, Aligned, Single-Line with Smooth Selection Animation) -->
            <nav class="hidden lg:flex items-center space-x-1 xl:space-x-2 text-xs xl:text-sm font-bold text-slate-300">
                
                <!-- 1. নোটিশ ও সার্কুলার -->
                <a href="{{ route('public.notice-board') }}" 
                   class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-emerald-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-emerald-400 group-hover:scale-110 transition-transform">📢</span>
                    <span>নোটিশ ও সার্কুলার</span>
                </a>

                <!-- 2. লাইভ ম্যাচ (Placed right after Notice, Smooth Scroll Spy) -->
                <a href="#live-matches" 
                   @click.prevent="scrollTo('live-matches')" 
                   :class="activeSection === 'live' 
                        ? 'text-rose-300 bg-rose-500/15 border-rose-500/40 shadow-sm shadow-rose-500/20 font-black' 
                        : 'text-slate-300 hover:text-rose-300 hover:bg-slate-800/70 border-transparent hover:border-rose-500/30'"
                   class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 border group">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    <span>লাইভ ম্যাচ</span>
                    <span class="absolute bottom-0.5 left-2.5 right-2.5 h-0.5 bg-gradient-to-r from-rose-400 to-amber-400 rounded-full transition-all duration-300"
                          :class="activeSection === 'live' ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-50'"></span>
                </a>

                <!-- 3. খেলাধুলা ও কারিকুলাম (Smooth Scroll Spy) -->
                <a href="#sports-hub" 
                   @click.prevent="scrollTo('sports-hub')" 
                   :class="activeSection === 'sports' 
                        ? 'text-emerald-300 bg-emerald-500/15 border-emerald-500/40 shadow-sm shadow-emerald-500/20 font-black' 
                        : 'text-slate-300 hover:text-white hover:bg-slate-800/70 border-transparent'"
                   class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 border group">
                    <span class="text-emerald-400 group-hover:rotate-12 transition-transform">⚽</span>
                    <span>খেলাধুলা ও কারিকুলাম</span>
                    <span class="absolute bottom-0.5 left-2.5 right-2.5 h-0.5 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full transition-all duration-300"
                          :class="activeSection === 'sports' ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-50'"></span>
                </a>

                <!-- 4. টুর্নামেন্ট (Smooth Scroll Spy) -->
                <a href="#tournaments" 
                   @click.prevent="scrollTo('tournaments')" 
                   :class="activeSection === 'tournaments' 
                        ? 'text-amber-300 bg-amber-500/15 border-amber-500/40 shadow-sm shadow-amber-500/20 font-black' 
                        : 'text-slate-300 hover:text-white hover:bg-slate-800/70 border-transparent'"
                   class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 border group">
                    <span class="text-amber-400 group-hover:scale-110 transition-transform">🏆</span>
                    <span>টুর্নামেন্ট</span>
                    <span class="absolute bottom-0.5 left-2.5 right-2.5 h-0.5 bg-gradient-to-r from-amber-400 to-amber-500 rounded-full transition-all duration-300"
                          :class="activeSection === 'tournaments' ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-50'"></span>
                </a>

                <!-- 5. টিম ও স্কোয়াড (Smooth Scroll Spy) -->
                <a href="#teams" 
                   @click.prevent="scrollTo('teams')" 
                   :class="activeSection === 'teams' 
                        ? 'text-cyan-300 bg-cyan-500/15 border-cyan-500/40 shadow-sm shadow-cyan-500/20 font-black' 
                        : 'text-slate-300 hover:text-white hover:bg-slate-800/70 border-transparent'"
                   class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 border group">
                    <span class="text-cyan-400 group-hover:scale-110 transition-transform">🛡️</span>
                    <span>টিম ও স্কোয়াড</span>
                    <span class="absolute bottom-0.5 left-2.5 right-2.5 h-0.5 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full transition-all duration-300"
                          :class="activeSection === 'teams' ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-50'"></span>
                </a>

                <!-- 6. একাডেমি রুলস -->
                <a href="{{ route('rules') }}" 
                   class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-amber-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-amber-400 group-hover:rotate-6 transition-transform">📜</span>
                    <span>একাডেমি রুলস</span>
                </a>
            </nav>

            <!-- Right: Auth + Single Online Application CTA Button (No duplicate!) -->
            <div class="flex items-center space-x-1 sm:space-x-3 shrink-0">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-2 sm:px-3.5 py-1.5 sm:py-2 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-lg sm:rounded-xl text-[11px] sm:text-sm border border-slate-700 transition-all duration-300 shadow hover:border-emerald-500/40 whitespace-nowrap">
                            ড্যাশবোর্ড
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[11px] sm:text-sm font-bold text-slate-300 hover:text-white px-1.5 sm:px-3 py-1 sm:py-2 rounded-lg sm:rounded-xl hover:bg-slate-800/60 transition whitespace-nowrap">
                            লগইন
                        </a>
                    @endauth
                @endif

                <!-- The SINGLE Primary Online Application Button -->
                <a href="{{ route('public.apply') }}" 
                   class="relative group inline-flex items-center gap-1 sm:gap-2 px-2.5 sm:px-5 py-1.5 sm:py-2.5 bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-500 hover:from-emerald-400 hover:to-teal-300 text-slate-950 font-black rounded-lg sm:rounded-xl text-[11px] sm:text-sm transition-all duration-300 shadow-md sm:shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5 active:translate-y-0 whitespace-nowrap overflow-hidden">
                    <span class="text-xs sm:text-sm">🚀</span>
                    <span><span class="hidden xs:inline">অনলাইন </span>আবেদন</span>
                    <span class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 ease-out pointer-events-none"></span>
                </a>

                <!-- Hamburger button for mobile -->
                <button @click="mobileMenu = !mobileMenu" aria-label="Toggle Mobile Menu" class="lg:hidden p-1 sm:p-2 rounded-lg sm:rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenu, 'block': !mobileMenu}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'block': mobileMenu, 'hidden': !mobileMenu}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile dropdown drawer -->
        <div x-show="mobileMenu" x-transition class="lg:hidden border-t border-slate-800 bg-slate-900/98 px-3 py-3 space-y-1.5 text-xs sm:text-sm font-semibold text-slate-200">
            <a href="{{ route('public.apply') }}" class="block px-3 py-2 rounded-xl text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 font-black text-center shadow-lg shadow-emerald-500/20">🚀 অনলাইন আবেদন (ভর্তি • লোকাল প্লেয়ার • ভলান্টিয়ার)</a>
            <a href="{{ route('public.notice-board') }}" class="block px-3 py-1.5 rounded-xl text-emerald-400 hover:bg-slate-800 font-bold">📢 নোটিশ ও সার্কুলার হাব</a>
            <a href="#live-matches" @click="scrollTo('live-matches')" class="block px-3 py-1.5 rounded-xl text-rose-400 hover:bg-slate-800 font-bold">🔴 লাইভ ম্যাচ</a>
            <a href="#sports-hub" @click="scrollTo('sports-hub')" class="block px-3 py-1.5 rounded-xl hover:bg-slate-800 font-bold">⚽ খেলাধুলা ও কারিকুলাম</a>
            <a href="#tournaments" @click="scrollTo('tournaments')" class="block px-3 py-1.5 rounded-xl text-amber-400 hover:bg-slate-800 font-bold">🏆 টুর্নামেন্ট</a>
            <a href="#teams" @click="scrollTo('teams')" class="block px-3 py-1.5 rounded-xl text-cyan-400 hover:bg-slate-800 font-bold">🛡️ টিম ও স্কোয়াড</a>
            <a href="{{ route('rules') }}" class="block px-3 py-1.5 rounded-xl hover:bg-slate-800 font-bold">📜 একাডেমি রুলস ও টার্মস</a>
        </div>
    </header>

    <!-- 📢 Live Notice & Announcement Marquee Ticker -->
    @if((isset($notices) && $notices->isNotEmpty()) || (isset($allCirculars) && $allCirculars->where('is_active', true)->isNotEmpty()))
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 border-b border-emerald-500/30 text-xs py-2 px-4 sm:px-6 relative overflow-hidden z-40">
            <div class="max-w-[1550px] mx-auto flex items-center justify-between gap-4">
                <div class="flex items-center gap-2 shrink-0 bg-emerald-500 text-slate-950 font-black px-2.5 py-0.5 rounded-full text-[11px] shadow-sm uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-slate-950 animate-ping"></span>
                    <span>জরুরি ঘোষণা</span>
                </div>
                
                <div class="flex-1 overflow-hidden whitespace-nowrap relative">
                    <div class="inline-block animate-marquee text-slate-200 font-medium">
                        @if(isset($notices))
                            @foreach($notices as $notice)
                                <a href="{{ route('public.notice-board') }}" class="inline-flex items-center gap-1.5 mx-6 hover:text-emerald-400 transition">
                                    <span class="text-emerald-400 font-bold">●</span>
                                    @if($notice->is_pinned)
                                        <span class="bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[10px] px-1.5 py-0.5 rounded font-bold">জরুরি নোটিশ</span>
                                    @endif
                                    <span>{{ $notice->title }}</span>
                                    <span class="text-slate-400 text-[10px]">({{ \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y') }})</span>
                                </a>
                            @endforeach
                        @endif
                        @if(isset($allCirculars))
                            @foreach($allCirculars->where('is_active', true)->take(4) as $c)
                                <a href="{{ route('public.notice-board') }}" class="inline-flex items-center gap-1.5 mx-6 hover:text-amber-400 transition">
                                    <span class="text-amber-400 font-bold">●</span>
                                    <span class="bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] px-1.5 py-0.5 rounded font-bold">সার্কুলার</span>
                                    <span>{{ $c->title }}</span>
                                    @if($c->end_date)
                                        <span class="text-slate-400 text-[10px]">(শেষ সময়: {{ $c->end_date->format('d M') }})</span>
                                    @endif
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <a href="{{ route('public.notice-board') }}" class="shrink-0 text-emerald-400 hover:text-emerald-300 font-bold text-xs flex items-center gap-1 transition">
                    <span class="hidden sm:inline">সকল নোটিশ ও সার্কুলার</span>
                    <span>➔</span>
                </a>
            </div>
        </div>
    @endif

    <div x-data="{ activeNotice: null, activeCircular: null, heroNoticeTab: 'notices' }">

        <!-- Athletic Stadium Floodlight Hero Section -->
        <section id="hero" class="relative overflow-hidden py-8 sm:py-12 lg:py-16 bg-gradient-to-b from-slate-950 via-[#061c16] to-slate-950 border-b border-slate-800 scroll-mt-20">
            <!-- Floodlight Beam Glows -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[400px] bg-emerald-500/15 blur-[140px] rounded-full pointer-events-none"></div>
            <div class="absolute top-20 right-10 w-[400px] h-[300px] bg-amber-500/10 blur-[120px] rounded-full pointer-events-none"></div>

            <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 relative z-10">
                <div class="hero-layout-grid w-full items-stretch">

                    <!-- LEFT COLUMN: Hero Brand Content, CTAs, and Stats -->
                    <div class="flex flex-col justify-between space-y-4 sm:space-y-6 text-left min-w-0">
                        <div class="space-y-2.5 sm:space-y-4">
                            <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                নতুন সেশনের ভর্তি ও টুর্নামেন্ট ড্রাফট • ২০২৬
                            </div>

                            <h1 class="text-xl xs:text-2xl sm:text-5xl xl:text-6xl font-black tracking-tight text-white leading-tight">
                                ভবিষ্যতের চ্যাম্পিয়ন খেলোয়াড় তৈরিতে <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-400 bg-clip-text text-transparent">আমরা প্রতিশ্রুতিবদ্ধ</span>
                            </h1>

                            <p class="text-[11px] sm:text-base text-slate-300 leading-relaxed max-w-2xl">
                                জামিরবাড়িয়া স্পোর্টস একাডেমি পেশাদার ফুটবল, ক্রিকেট, ব্যাডমিন্টন ও অ্যাথলেটিক্সে দক্ষ করে তুলতে উন্নত প্রশিক্ষণ নিশ্চিত করে। পাশাপাশি আয়োজন করে রোমাঞ্চকর একাডেমিক ও উন্মুক্ত লোকাল টুর্নামেন্ট।
                            </p>

                            <!-- Action CTA Buttons Grid -->
                            <div class="pt-1.5 sm:pt-2 flex flex-wrap items-center gap-2 sm:gap-3">
                                <a href="{{ route('public.apply') }}" class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3.5 bg-gradient-to-r from-emerald-500 via-teal-400 to-amber-400 hover:from-emerald-400 hover:to-teal-300 text-slate-950 font-black rounded-xl text-xs sm:text-sm transition shadow-md sm:shadow-xl shadow-emerald-500/25 flex items-center justify-center gap-2 text-center">
                                    <span>🚀</span>
                                    <span>অনলাইন আবেদন ও নিবন্ধন পোর্টাল</span>
                                    <span>➔</span>
                                </a>

                                <a href="{{ route('public.tournaments.index') }}" class="flex-1 sm:flex-initial px-3 sm:px-5 py-2 sm:py-3 bg-slate-900/90 hover:bg-slate-800 border border-amber-500/40 text-amber-400 font-bold rounded-xl text-[11px] sm:text-sm transition flex items-center justify-center gap-1.5 sm:gap-2 shadow text-center">
                                    <span>🏆</span>
                                    <span>টুর্নামেন্ট ও শিডিউল</span>
                                </a>

                                <a href="{{ route('live.index') }}" class="flex-1 sm:flex-initial px-3 sm:px-5 py-2 sm:py-3 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-[11px] sm:text-sm transition shadow-md sm:shadow-lg shadow-rose-600/30 flex items-center justify-center gap-1.5 sm:gap-2 text-center">
                                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white animate-ping"></span>
                                    <span>লাইভ স্কোর</span>
                                </a>

                                <a href="{{ route('admission.track') }}" class="w-full sm:w-auto px-3 sm:px-4 py-2 sm:py-3 bg-slate-900/90 hover:bg-slate-800 border border-slate-700 text-slate-300 font-bold rounded-xl text-[11px] sm:text-sm transition flex items-center justify-center gap-1.5 text-center">
                                    <span>🔍</span>
                                    <span>আবেদন ট্র্যাকিং</span>
                                </a>
                            </div>
                        </div>

                        <!-- Stats Bar (Integrated in left side) -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-slate-800/80">
                            <div class="bg-slate-900/80 border border-slate-800 p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl text-center backdrop-blur hover:border-emerald-500/40 transition">
                                <div class="text-xl sm:text-3xl font-black text-emerald-400">৫০০+</div>
                                <div class="text-[9px] sm:text-[10px] text-slate-400 mt-0.5 uppercase tracking-wider font-bold">একাডেমিক ট্রেইনি</div>
                            </div>
                            <div class="bg-slate-900/80 border border-slate-800 p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl text-center backdrop-blur hover:border-amber-500/40 transition">
                                <div class="text-xl sm:text-3xl font-black text-amber-400">১০০০+</div>
                                <div class="text-[9px] sm:text-[10px] text-slate-400 mt-0.5 uppercase tracking-wider font-bold">টুর্নামেন্ট প্লেয়ার</div>
                            </div>
                            <div class="bg-slate-900/80 border border-slate-800 p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl text-center backdrop-blur hover:border-emerald-500/40 transition">
                                <div class="text-xl sm:text-3xl font-black text-emerald-400">১২+</div>
                                <div class="text-[9px] sm:text-[10px] text-slate-400 mt-0.5 uppercase tracking-wider font-bold">সার্টিফাইড কোচ</div>
                            </div>
                            <div class="bg-slate-900/80 border border-slate-800 p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl text-center backdrop-blur hover:border-rose-500/40 transition">
                                <div class="text-xl sm:text-3xl font-black text-rose-400">৫০+</div>
                                <div class="text-[9px] sm:text-[10px] text-slate-400 mt-0.5 uppercase tracking-wider font-bold">ম্যাচ ও কাপ</div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: TALL VERTICAL NOTICE BOARD & CIRCULAR WIDGET -->
                    <div class="flex flex-col h-full w-full">
                        <div class="bg-gradient-to-b from-slate-900/95 via-slate-900/90 to-slate-950/95 border border-emerald-500/40 hover:border-emerald-500/60 rounded-2xl sm:rounded-3xl p-3.5 sm:p-5 shadow-2xl flex flex-col justify-between h-full backdrop-blur-xl relative overflow-hidden ring-1 ring-white/5 transition">
                            
                            <!-- Subtle Top Glow -->
                            <div class="absolute -top-12 -right-12 w-40 h-40 bg-emerald-500/20 rounded-full blur-2xl pointer-events-none"></div>

                            <!-- Header -->
                            <div class="border-b border-slate-800 pb-2.5 sm:pb-3 mb-2.5 sm:mb-3 relative z-10">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-sm sm:text-base shadow">
                                            📋
                                        </div>
                                        <div>
                                            <h3 class="text-xs sm:text-sm font-black text-white flex items-center gap-1.5">
                                                <span>নোটিশ বোর্ড ও সার্কুলার</span>
                                            </h3>
                                            <span class="text-[9px] sm:text-[10px] text-slate-400">একাডেমি সর্বশেষ আপডেট</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-[9px] sm:text-[10px] text-emerald-400 font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                        <span>লাইভ</span>
                                    </div>
                                </div>

                                <!-- Mini Tab Pill Switcher -->
                                <div class="grid grid-cols-2 gap-1 p-0.5 sm:p-1 bg-slate-950/80 border border-slate-800/80 rounded-lg sm:rounded-xl">
                                    <button @click="heroNoticeTab = 'notices'"
                                            :class="heroNoticeTab === 'notices' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-black shadow-md' : 'text-slate-400 hover:text-white font-semibold'"
                                            class="py-1 px-1.5 rounded-md sm:rounded-lg text-[11px] sm:text-xs transition text-center flex items-center justify-center gap-1">
                                        <span>📌 নোটিশ</span>
                                        <span class="text-[9px] sm:text-[10px] opacity-80">({{ isset($notices) ? $notices->count() : 0 }})</span>
                                    </button>
                                    <button @click="heroNoticeTab = 'circulars'"
                                            :class="heroNoticeTab === 'circulars' ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black shadow-md' : 'text-slate-400 hover:text-white font-semibold'"
                                            class="py-1 px-1.5 rounded-md sm:rounded-lg text-[11px] sm:text-xs transition text-center flex items-center justify-center gap-1">
                                        <span>📅 সার্কুলার</span>
                                        <span class="text-[9px] sm:text-[10px] opacity-80">({{ isset($allCirculars) ? $allCirculars->count() : 0 }})</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Scrollable Feed Content (Tall Vertical Feed) -->
                            <div class="flex-1 overflow-y-auto pr-1 space-y-2 custom-scrollbar max-h-[300px] sm:max-h-[420px] lg:max-h-[440px] xl:max-h-[460px] relative z-10">
                                
                                <!-- 1. NOTICES LIST -->
                                <div x-show="heroNoticeTab === 'notices'" class="space-y-2">
                                    @if(isset($notices))
                                        @forelse($notices as $notice)
                                            <div class="p-2.5 sm:p-3 rounded-xl sm:rounded-2xl bg-slate-950/70 border {{ $notice->is_pinned ? 'border-amber-500/40 bg-gradient-to-r from-amber-950/20 to-slate-950/70' : 'border-slate-800/80 hover:border-slate-700' }} transition hover:bg-slate-950 cursor-pointer space-y-1 group"
                                                 @click="activeNotice = {{ json_encode([
                                                     'title' => $notice->title,
                                                     'sport' => $notice->sport->name ?? 'সকল বিভাগ',
                                                     'date' => \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y'),
                                                     'content' => $notice->content,
                                                     'is_pinned' => (bool) $notice->is_pinned,
                                                 ]) }}">
                                                <div class="flex items-center justify-between gap-1 text-[9px] sm:text-[10px]">
                                                    <div class="flex items-center gap-1">
                                                        @if($notice->is_pinned)
                                                            <span class="px-1.5 py-0.2 rounded font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                                                📌 জরুরি
                                                            </span>
                                                        @endif
                                                        <span class="px-1.5 py-0.2 rounded bg-slate-800 text-slate-300 border border-slate-700 font-medium">
                                                            {{ $notice->sport->name ?? 'সাধারণ' }}
                                                        </span>
                                                    </div>
                                                    <span class="font-mono text-slate-400">
                                                        {{ \Carbon\Carbon::parse($notice->notice_date)->format('d M') }}
                                                    </span>
                                                </div>

                                                <h4 class="text-[11px] sm:text-xs font-bold text-white group-hover:text-emerald-400 transition line-clamp-2 leading-snug">
                                                    {{ $notice->title }}
                                                </h4>

                                                <p class="text-[10px] sm:text-[11px] text-slate-400 line-clamp-2 leading-relaxed">
                                                    {{ Str::limit($notice->content, 90) }}
                                                </p>

                                                <div class="flex items-center justify-between pt-0.5 text-[9px] sm:text-[10px]">
                                                    <span class="text-emerald-400 font-semibold group-hover:underline flex items-center gap-0.5">
                                                        <span>বিস্তারিত পড়ুন</span> ➔
                                                    </span>
                                                    <span class="text-slate-500">ক্লিক করুন</span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-6 text-center text-xs text-slate-500">
                                                বর্তমানে কোনো নোটিশ প্রকাশ করা হয়নি।
                                            </div>
                                        @endforelse
                                    @endif
                                </div>

                                <!-- 2. CIRCULARS LIST -->
                                <div x-show="heroNoticeTab === 'circulars'" class="space-y-2.5">
                                    @if(isset($allCirculars))
                                        @forelse($allCirculars as $c)
                                            @php
                                                $badge = $c->status_badge;
                                                $status = $c->getStatus();
                                            @endphp
                                            <div class="p-3 rounded-2xl bg-slate-950/70 border border-slate-800/80 hover:border-emerald-500/50 transition space-y-2 cursor-pointer group"
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
                                                <div class="flex items-center justify-between gap-1 text-[10px]">
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full font-bold border {{ $badge['bg'] }}">
                                                        <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                                        {{ $badge['label'] }}
                                                    </span>
                                                    <div class="flex items-center gap-1.5">
                                                        @if($c->fee)
                                                            <span class="font-mono text-[9px] text-amber-400 font-bold bg-amber-500/10 px-1.5 py-0.2 rounded border border-amber-500/20">
                                                                ৳{{ number_format($c->fee) }}
                                                            </span>
                                                        @endif
                                                        <span class="font-mono text-slate-400 text-[10px]">
                                                            {{ $c->type_icon }} {{ Str::limit($c->type_name, 16) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="text-xs font-bold text-white group-hover:text-emerald-400 transition line-clamp-2 leading-snug">
                                                        {{ $c->title }}
                                                    </h4>
                                                    @if($c->end_date)
                                                        <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-1 font-mono">
                                                            <span>⏰ শেষ সময়:</span>
                                                            <span class="{{ $c->isClosed() ? 'text-rose-400' : 'text-emerald-400' }} font-bold">
                                                                {{ $c->end_date->format('d M, Y') }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex items-center justify-between pt-1 gap-2">
                                                    @if($status === 'open')
                                                        <a href="{{ $c->apply_url }}" @click.stop
                                                           class="w-full py-1.5 px-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 text-slate-950 font-bold rounded-lg text-[11px] transition flex items-center justify-center gap-1 shadow">
                                                            <span>আবেদন করুন</span> ➔
                                                        </a>
                                                    @elseif($status === 'upcoming')
                                                        <div class="w-full py-1 px-2 bg-amber-500/10 border border-amber-500/30 text-amber-300 rounded-lg text-[10px] font-semibold text-center">
                                                            ⏳ শীঘ্রই শুরু হবে (বিস্তারিত)
                                                        </div>
                                                    @else
                                                        <div class="w-full py-1 px-2 bg-slate-800 text-slate-400 rounded-lg text-[10px] font-semibold text-center">
                                                            🛑 সময় শেষ (বিজ্ঞপ্তি)
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-6 text-center text-xs text-slate-500">
                                                কোনো সার্কুলার সক্রিয় নেই।
                                            </div>
                                        @endforelse
                                    @endif
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="pt-3 border-t border-slate-800/80 mt-3 flex items-center justify-between text-[11px] relative z-10">
                                <a href="{{ route('public.notice-board') }}" class="text-emerald-400 hover:text-emerald-300 font-bold transition flex items-center gap-1">
                                    <span>সকল নোটিশ ও সার্কুলার হাব</span> ➔
                                </a>
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('notices.create') }}" class="px-2 py-1 bg-emerald-600 hover:bg-emerald-500 text-slate-950 rounded-lg text-[10px] font-bold transition">
                                            + নোটিশ দিন
                                        </a>
                                    @endif
                                @endauth
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- ============================================================== -->
        <!-- 📌 INTERACTIVE MODALS FOR RECENT NOTICES & CIRCULARS -->
        <!-- ============================================================== -->
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

    <!-- ============================================================== -->
    <!-- 🔴 LIVE MATCHES & RECENT SCOREBOARD SHOWCASE SECTION -->
    <!-- ============================================================== -->
    <section id="live-matches" class="py-8 sm:py-20 bg-gradient-to-b from-slate-950 via-[#13070b] to-slate-950 border-t border-slate-800 relative overflow-hidden scroll-mt-20">
        <!-- Floodlight glow -->
        <div class="absolute top-0 right-1/4 w-[500px] h-[300px] bg-rose-500/10 blur-[130px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-6 sm:mb-12">
                <div>
                    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-rose-500/10 border border-rose-500/30 text-rose-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2 sm:mb-3">
                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-rose-500 animate-ping"></span>
                        রিয়েল-টাইম ম্যাচ সম্প্রচার • লাইভ ম্যাচ
                    </div>
                    <h2 class="text-xl sm:text-4xl font-black text-white tracking-tight leading-snug">
                        মাঠের লাইভ স্কোর ও <span class="bg-gradient-to-r from-rose-400 via-amber-400 to-rose-300 bg-clip-text text-transparent">রিসেন্ট ম্যাচ আপডেট</span>
                    </h2>
                    <p class="text-slate-300 text-xs sm:text-sm mt-1 sm:mt-2 max-w-2xl leading-relaxed">
                        চলমান ও সর্বশেষ একাডেমি টুর্নামেন্টের ফুটবল এবং ক্রিকেট ম্যাচের সরাসরি স্কোরবোর্ড, বল-বাই-বল কমেন্ট্রি ও ফলাফল।
                    </p>
                </div>

                <div class="shrink-0 flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('live.index') }}" class="px-3.5 py-2 sm:px-5 sm:py-3 bg-rose-600 hover:bg-rose-500 text-white font-black rounded-xl sm:rounded-2xl text-[11px] sm:text-sm inline-flex items-center gap-1.5 sm:gap-2 shadow-lg shadow-rose-600/25 transition">
                        <span>🔴 সকল লাইভ ম্যাচ দেখুন</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>

            <!-- Matches Cards Grid -->
            @if(isset($recentMatches) && $recentMatches->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    @foreach($recentMatches as $match)
                        <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 border {{ $match->status === 'live' ? 'border-rose-500/50 shadow-rose-500/15' : 'border-slate-800 hover:border-slate-700' }} rounded-2xl sm:rounded-3xl p-3.5 sm:p-6 shadow-2xl relative overflow-hidden group transition">
                            
                            <!-- Top Status & Tournament Meta -->
                            <div class="flex items-center justify-between text-xs border-b border-slate-800 pb-2.5 sm:pb-3 gap-2">
                                <span class="font-bold flex items-center gap-1.5 uppercase text-[10px] sm:text-[11px] {{ $match->status === 'live' ? 'text-rose-400' : 'text-slate-400' }} min-w-0 truncate">
                                    @if($match->status === 'live')
                                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-rose-500 animate-ping shrink-0"></span>
                                    @endif
                                    <span class="shrink-0">{{ $match->sport_type === 'cricket' ? '🏏 ক্রিকেট' : '⚽ ফুটবল' }}</span>
                                    <span>•</span>
                                    <span class="truncate max-w-[130px] sm:max-w-[200px]">{{ $match->tournament_name ?? 'অফিশিয়াল ম্যাচ' }}</span>
                                </span>

                                @if($match->status === 'live')
                                    <span class="px-2 sm:px-2.5 py-0.5 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/40 text-[9px] sm:text-[10px] font-black uppercase tracking-wider flex items-center gap-1 animate-pulse shrink-0">
                                        ● সরাসরি চলছে
                                    </span>
                                @elseif($match->status === 'upcoming')
                                    <span class="px-2 sm:px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[9px] sm:text-[10px] font-black uppercase tracking-wider shrink-0">
                                        ⏳ আসন্ন ম্যাচ
                                    </span>
                                @else
                                    <span class="px-2 sm:px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 border border-slate-700 text-[9px] sm:text-[10px] font-black uppercase tracking-wider shrink-0">
                                        🏁 সমাপ্ত
                                    </span>
                                @endif
                            </div>

                            <!-- Match Title -->
                            <h3 class="text-xs sm:text-base font-black text-white mt-2.5 sm:mt-3 truncate">{{ $match->title }}</h3>

                            <!-- Scoreboard Center Grid -->
                            <div class="my-3 sm:my-5 grid grid-cols-5 items-center text-center bg-slate-950/60 p-2.5 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-800/80">
                                <!-- Team A -->
                                <div class="col-span-2 min-w-0">
                                    <div class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase truncate">হোস্ট / দল ১</div>
                                    <div class="font-black text-white text-[11px] sm:text-base truncate mt-0.5 sm:mt-1">{{ $match->team_a }}</div>
                                    <div class="text-base sm:text-2xl font-black text-rose-400 font-mono mt-0.5 sm:mt-1">
                                        {{ $match->team_a_score ?: ($match->status === 'upcoming' ? '—' : '০') }}
                                    </div>
                                </div>

                                <!-- VS Indicator -->
                                <div class="col-span-1 flex flex-col items-center shrink-0">
                                    <span class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-rose-500/20 text-rose-300 font-black text-[10px] sm:text-xs flex items-center justify-center border border-rose-500/30">VS</span>
                                    <span class="text-[8px] sm:text-[9px] font-bold uppercase mt-1 tracking-wider {{ $match->status === 'live' ? 'text-rose-400 animate-pulse' : 'text-slate-500' }}">
                                        {{ strtoupper($match->status) }}
                                    </span>
                                </div>

                                <!-- Team B -->
                                <div class="col-span-2 min-w-0">
                                    <div class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase truncate">ভিজিটর / দল ২</div>
                                    <div class="font-black text-white text-[11px] sm:text-base truncate mt-0.5 sm:mt-1">{{ $match->team_b }}</div>
                                    <div class="text-base sm:text-2xl font-black text-rose-400 font-mono mt-0.5 sm:mt-1">
                                        {{ $match->team_b_score ?: ($match->status === 'upcoming' ? '—' : '০') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Summary & Action -->
                            <div class="flex items-center justify-between pt-1 text-xs gap-2 min-w-0">
                                <div class="text-slate-400 text-[10px] sm:text-[11px] truncate flex-1 min-w-0">
                                    @if($match->current_summary)
                                        <span class="text-emerald-400 font-medium">⚡ {{ $match->current_summary }}</span>
                                    @elseif($match->match_result)
                                        <span class="text-amber-400 font-medium">🏆 {{ $match->match_result }}</span>
                                    @elseif($match->venue)
                                        <span>📍 {{ $match->venue }}</span>
                                    @endif
                                </div>

                                <a href="{{ route('live.show', $match->slug) }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-rose-400 hover:text-rose-300 transition group-hover:translate-x-1 shrink-0 whitespace-nowrap">
                                    <span>স্কোরকার্ড</span>
                                    <span>➔</span>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <!-- Clean Placeholder when no matches created yet -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl sm:rounded-3xl p-6 sm:p-12 text-center max-w-2xl mx-auto space-y-3 sm:space-y-4">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-2xl sm:text-3xl flex items-center justify-center mx-auto">
                        🔴
                    </div>
                    <h3 class="text-base sm:text-xl font-black text-white">বর্তমানে কোনো সরাসরি লাইভ ম্যাচ চলমান নেই</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                        আসন্ন একাডেমি টুর্নামেন্ট ও প্রীতি ম্যাচসমূহ শুরু হলে এখানে রিয়েল-টাইম লাইভ স্কোরবোর্ড ও ম্যাচ কমেন্ট্রি প্রদর্শিত হবে।
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('live.index') }}" class="px-4 py-2.5 sm:px-6 sm:py-3 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-xs sm:text-sm inline-flex items-center gap-2 transition">
                            <span>লাইভ ম্যাচ সেন্টারে প্রবেশ করুন</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 🏅 SPORTS & DISCIPLINE HUB WITH LEFT-SIDE CATEGORY SELECTOR -->
    <!-- ============================================================== -->
    <section id="sports-hub" class="py-8 sm:py-20 bg-slate-950 border-t border-slate-800 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-6 sm:mb-14">
                <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2">
                    <span>⚽</span> খেলাধুলা ও কারিকুলাম
                </div>
                <h2 class="text-xl sm:text-4xl font-black text-white">পেশাদার প্রশিক্ষণ ও স্পোর্টস ডিসিপ্লিন</h2>
                <p class="text-slate-400 text-xs sm:text-sm mt-1 sm:mt-2">বাম পাশের ক্যাটাগরি প্যানেল থেকে যেকোনো খেলা নির্বাচন করে বিস্তারিত দেখুন</p>
            </div>

            <!-- Left Category Navigation Layout with interactive Alpine tabs -->
            <div x-data="{ activeTab: 'football' }" class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-start">

                <!-- ⬅️ LEFT-SIDE CATEGORY SELECTOR -->
                <div class="lg:col-span-4 bg-slate-900/90 border border-slate-800 rounded-2xl sm:rounded-3xl p-3.5 sm:p-5 shadow-2xl backdrop-blur">
                    <div class="pb-2.5 sm:pb-3 border-b border-slate-800 px-1 sm:px-2 flex items-center justify-between mb-2.5 sm:mb-3">
                        <span class="text-[11px] sm:text-xs font-bold text-emerald-400 uppercase tracking-wider">স্পোর্টস ক্যাটাগরি</span>
                        <span class="text-[9px] sm:text-[10px] text-slate-500 font-mono">৪টি প্রধান ডিসিপ্লিন</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2 sm:gap-2.5">
                        <!-- Football Tab -->
                        <button @click="activeTab = 'football'" :class="activeTab === 'football' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 shadow-lg shadow-emerald-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
                            class="w-full text-left flex items-center justify-between p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm transition select-none">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-lg sm:text-2xl">⚽</span>
                                <div>
                                    <div class="font-black text-xs sm:text-sm">ফুটবল একাডেমি</div>
                                    <div class="text-[9px] sm:text-[10px] opacity-80 font-normal">মর্নিং ও ইভনিং সেশন</div>
                                </div>
                            </div>
                            <span class="text-xs">&rarr;</span>
                        </button>

                        <!-- Cricket Tab -->
                        <button @click="activeTab = 'cricket'" :class="activeTab === 'cricket' ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
                            class="w-full text-left flex items-center justify-between p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm transition select-none">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-lg sm:text-2xl">🏏</span>
                                <div>
                                    <div class="font-black text-xs sm:text-sm">ক্রিকেট কোচিং</div>
                                    <div class="text-[9px] sm:text-[10px] opacity-80 font-normal">ব্যাটিং, বোলিং ও নেট প্র্যাকটিস</div>
                                </div>
                            </div>
                            <span class="text-xs">&rarr;</span>
                        </button>

                        <!-- Badminton Tab -->
                        <button @click="activeTab = 'badminton'" :class="activeTab === 'badminton' ? 'bg-gradient-to-r from-teal-500 to-cyan-500 text-slate-950 shadow-lg shadow-teal-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
                            class="w-full text-left flex items-center justify-between p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm transition select-none">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-lg sm:text-2xl">🏸</span>
                                <div>
                                    <div class="font-black text-xs sm:text-sm">ব্যাডমিন্টন প্রশিক্ষণ</div>
                                    <div class="text-[9px] sm:text-[10px] opacity-80 font-normal">সিঙ্গেলস ও ডাবলস</div>
                                </div>
                            </div>
                            <span class="text-xs">&rarr;</span>
                        </button>

                        <!-- Athletics Tab -->
                        <button @click="activeTab = 'athletics'" :class="activeTab === 'athletics' ? 'bg-gradient-to-r from-cyan-500 to-blue-500 text-slate-950 shadow-lg shadow-cyan-500/20' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'"
                            class="w-full text-left flex items-center justify-between p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm transition select-none">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-lg sm:text-2xl">🏃</span>
                                <div>
                                    <div class="font-black text-xs sm:text-sm">অ্যাথলেটিক্স ও ফিটনেস</div>
                                    <div class="text-[9px] sm:text-[10px] opacity-80 font-normal">স্প্রিন্ট ও স্ট্যামিনা</div>
                                </div>
                            </div>
                            <span class="text-xs">&rarr;</span>
                        </button>

                        <!-- Tournaments Quick Link Tab -->
                        <a href="{{ route('public.tournaments.index') }}" class="sm:col-span-2 lg:col-span-1 w-full text-left flex items-center justify-between p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 font-bold text-xs sm:text-sm hover:bg-amber-500 hover:text-slate-950 transition">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-lg sm:text-2xl">🏆</span>
                                <div>
                                    <div class="font-black text-xs sm:text-sm">টুর্নামেন্ট</div>
                                    <div class="text-[9px] sm:text-[10px] font-normal">একাডেমিক ও লোকাল কাপ</div>
                                </div>
                            </div>
                            <span class="text-xs">দেখুন ↗</span>
                        </a>
                    </div>
                </div>

                <!-- ➡️ RIGHT-SIDE INTERACTIVE CONTENT PANELS -->
                <div class="lg:col-span-8 bg-slate-900/90 border border-slate-800 rounded-2xl sm:rounded-3xl p-4 sm:p-8 shadow-2xl relative overflow-hidden backdrop-blur">

                    <!-- Football Panel -->
                    <div x-show="activeTab === 'football'" x-transition class="space-y-4 sm:space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3 sm:pb-4 gap-2">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-2xl sm:text-4xl">⚽</span>
                                <div>
                                    <h3 class="text-base sm:text-2xl font-black text-white">পেশাদার ফুটবল একাডেমি প্রোগ্রাম</h3>
                                    <p class="text-[10px] sm:text-xs text-emerald-400 font-bold">ফিফা স্ট্যান্ডার্ড কারিকুলাম ও ট্যাকটিক্যাল প্রশিক্ষণ</p>
                                </div>
                            </div>
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-emerald-500/10 text-emerald-300 border border-emerald-500/30 shrink-0">
                                সপ্তাহে ৪ দিন সেশন
                            </span>
                        </div>

                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                            বল কন্ট্রোল, ড্রিবলিং, পজিশনাল প্লে, ম্যাচ ট্যাকটিক্স এবং গোলকিপিং টেকনিক। বয়সভিত্তিক অনূর্ধ্ব-১২, ১৪, ১৬ ও ১৯ একাডেমি ফুটবল স্কোয়াড গঠন এবং নিয়মিত টুর্নামেন্ট অংশগ্রহণ।
                        </p>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 pt-1 sm:pt-2">
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">বয়সসীমা:</span>
                                <strong class="text-white text-[11px] sm:text-xs">৬ থেকে ১৮ বছর</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">ভেন্যু:</span>
                                <strong class="text-white text-[11px] sm:text-xs">প্রধান ফুটবল মাঠ</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">টুর্নামেন্ট:</span>
                                <strong class="text-emerald-400 text-[11px] sm:text-xs">আন্তঃব্যাচ ও লোকাল কাপ</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">কোচিং:</span>
                                <strong class="text-white text-[11px] sm:text-xs">লাইসেন্সপ্রাপ্ত কোচ</strong>
                            </div>
                        </div>

                        <div class="pt-2 sm:pt-4 flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('admission.create') }}" class="px-4 py-2.5 sm:px-6 sm:py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl text-[11px] sm:text-xs transition shadow">
                                ফুটবলে ভর্তি আবেদন করুন &rarr;
                            </a>
                            <a href="{{ route('public.tournaments.index', ['sport' => 'football']) }}" class="px-3.5 py-2.5 sm:px-5 sm:py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-[11px] sm:text-xs font-bold transition">
                                ফুটবল টুর্নামেন্ট দেখুন
                            </a>
                        </div>
                    </div>

                    <!-- Cricket Panel -->
                    <div x-show="activeTab === 'cricket'" x-transition class="space-y-4 sm:space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3 sm:pb-4 gap-2">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-2xl sm:text-4xl">🏏</span>
                                <div>
                                    <h3 class="text-base sm:text-2xl font-black text-white">আধুনিক ক্রিকেট কোচিং একাডেমি</h3>
                                    <p class="text-[10px] sm:text-xs text-amber-400 font-bold">আন্তর্জাতিক মানের নেট প্র্যাকটিস ও ম্যাচ সিমুলেশন</p>
                                </div>
                            </div>
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-amber-500/10 text-amber-300 border border-amber-500/30 shrink-0">
                                সপ্তাহে ৫ দিন সেশন
                            </span>
                        </div>

                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                            সঠিক ব্যাটিং গ্রিপ, ফুটওয়ার্ক, পেস ও স্পিন বোলিং ভ্যারিয়েশন, উইকেটকিপিং এবং প্রফেশনাল ফিল্ডিং ড্রিলস। নিয়মিত ক্রিকইনফো স্টাইল স্কোরকার্ড এবং প্লেয়ার ক্যারিয়ার পারফরম্যান্স ট্র্যাকিং।
                        </p>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 pt-1 sm:pt-2">
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">বয়সসীমা:</span>
                                <strong class="text-white text-[11px] sm:text-xs">৭ থেকে ২০ বছর</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">ভেন্যু:</span>
                                <strong class="text-white text-[11px] sm:text-xs">টर्फ ও ম্যাটিং নেট</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">টুর্নামেন্ট:</span>
                                <strong class="text-amber-400 text-[11px] sm:text-xs">টি-টোয়েন্টি ও ওডিআই কাপ</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">পারফরম্যান্স:</span>
                                <strong class="text-white text-[11px] sm:text-xs">ক্রিকইনফো স্কোরকার্ড</strong>
                            </div>
                        </div>

                        <div class="pt-2 sm:pt-4 flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('admission.create') }}" class="px-4 py-2.5 sm:px-6 sm:py-3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-[11px] sm:text-xs transition shadow">
                                ক্রিকেটে ভর্তি আবেদন করুন &rarr;
                            </a>
                            <a href="{{ route('public.teams.index', ['sport' => 'cricket']) }}" class="px-3.5 py-2.5 sm:px-5 sm:py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-[11px] sm:text-xs font-bold transition">
                                ক্রিকেট দল ও স্কোয়াড
                            </a>
                        </div>
                    </div>

                    <!-- Badminton Panel -->
                    <div x-show="activeTab === 'badminton'" x-transition class="space-y-4 sm:space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3 sm:pb-4 gap-2">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-2xl sm:text-4xl">🏸</span>
                                <div>
                                    <h3 class="text-base sm:text-2xl font-black text-white">ইনডোর ব্যাডমিন্টন প্রশিক্ষণ</h3>
                                    <p class="text-[10px] sm:text-xs text-teal-400 font-bold">আন্তর্জাতিক স্ট্যান্ডার্ড সিন্থেটিক কোর্ট ও ফুটওয়ার্ক ড্রিল</p>
                                </div>
                            </div>
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-teal-500/10 text-teal-300 border border-teal-500/30 shrink-0">
                                সপ্তাহে ৪ দিন সেশন
                            </span>
                        </div>

                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                            স্ম্যাশ, ড্রপ শট, নেট প্লে এবং দ্রুত গতিশীল কোর্ট মুভমেন্ট। সিঙ্গেলস ও ডাবলস ক্যাটাগরিতে টুর্নামেন্ট খেলার উপযোগী বিশেষায়িত প্রশিক্ষণ।
                        </p>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 pt-1 sm:pt-2">
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">বয়সসীমা:</span>
                                <strong class="text-white text-[11px] sm:text-xs">৭ থেকে ১৮ বছর</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">ভেন্যু:</span>
                                <strong class="text-white text-[11px] sm:text-xs">ইনডোর কোর্ট</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">ক্যাটাগরি:</span>
                                <strong class="text-teal-400 text-[11px] sm:text-xs">সিঙ্গেলস ও ডাবলস</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">সুবিধা:</span>
                                <strong class="text-white text-[11px] sm:text-xs">নাইট লাইটিং</strong>
                            </div>
                        </div>

                        <div class="pt-2 sm:pt-4 flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('admission.create') }}" class="px-4 py-2.5 sm:px-6 sm:py-3 bg-teal-500 hover:bg-teal-400 text-slate-950 font-black rounded-xl text-[11px] sm:text-xs transition shadow">
                                ব্যাডমিন্টনে ভর্তি আবেদন করুন &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Athletics Panel -->
                    <div x-show="activeTab === 'athletics'" x-transition class="space-y-4 sm:space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3 sm:pb-4 gap-2">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <span class="text-2xl sm:text-4xl">🏃</span>
                                <div>
                                    <h3 class="text-base sm:text-2xl font-black text-white">অ্যাথলেটিক্স ও ফিটনেস প্রোগ্রাম</h3>
                                    <p class="text-[10px] sm:text-xs text-cyan-400 font-bold">স্পিড, স্ট্যামিনা ও বডি কন্ডিশনিং সেশন</p>
                                </div>
                            </div>
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-cyan-500/10 text-cyan-300 border border-cyan-500/30 shrink-0">
                                সপ্তাহে ৩ দিন সেশন
                            </span>
                        </div>

                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                            ১০০মি./২০০মি. স্প্রিন্ট, হাই জাম্প, লং জাম্প, পুশ-আপ এবং Yo-Yo ফিটনেস টেস্ট। সকল ধরনের খেলোয়াড়ের অ্যাথলেটিক সক্ষমতা বাড়ানোর সেরা প্ল্যাটফর্ম।
                        </p>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 pt-1 sm:pt-2">
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">বয়সসীমা:</span>
                                <strong class="text-white text-[11px] sm:text-xs">সব বয়সীদের জন্য</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">ট্র্যাক:</span>
                                <strong class="text-white text-[11px] sm:text-xs">রানিং ট্র্যাক গ্রাউন্ড</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">টেস্টিং:</span>
                                <strong class="text-cyan-400 text-[11px] sm:text-xs">Yo-Yo ও স্প্রিন্ট স্কোর</strong>
                            </div>
                            <div class="bg-slate-950 p-2 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-800">
                                <span class="text-[9px] sm:text-[10px] text-slate-500 block">ফোকাস:</span>
                                <strong class="text-white text-[11px] sm:text-xs">স্ট্যামিনা বৃদ্ধি</strong>
                            </div>
                        </div>

                        <div class="pt-2 sm:pt-4 flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('admission.create') }}" class="px-4 py-2.5 sm:px-6 sm:py-3 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-black rounded-xl text-[11px] sm:text-xs transition shadow">
                                অ্যাথলেটিক্সে ভর্তি আবেদন করুন &rarr;
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 🏆 TOURNAMENT SECTOR & LOCAL PLAYERS SHOWCASE -->
    <!-- ============================================================== -->
    <section id="tournaments" class="py-8 sm:py-20 bg-gradient-to-b from-slate-950 via-[#0a1815] to-slate-950 border-t border-slate-800 relative overflow-hidden scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-8 items-center">

                <!-- Left: Tournament Hub Showcase -->
                <div class="bg-slate-900/90 border border-amber-500/40 rounded-2xl sm:rounded-3xl p-4 sm:p-10 shadow-2xl space-y-3 sm:space-y-5">
                    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                        <span>🏆</span> টুর্নামেন্ট
                    </div>
                    <h3 class="text-lg sm:text-4xl font-black text-white leading-snug sm:leading-tight">
                        একাডেমিক ও লোকাল <span class="bg-gradient-to-r from-amber-400 to-rose-400 bg-clip-text text-transparent">টুর্নামেন্ট চ্যাম্পিয়নশিপ</span>
                    </h3>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                        একাডেমির অভ্যন্তরীণ ব্যাচ টুর্নামেন্ট ছাড়াও যেকোনো এলাকার স্বাধীন টিম ও খেলোয়াড়দের নিয়ে পরিচালিত হয় মেগা টুর্নামেন্ট। সরাসরি পয়েন্ট টেবিল ও ম্যাচ স্কোর দেখুন।
                    </p>
                    <div class="space-y-1.5 sm:space-y-2 pt-1 sm:pt-2 text-[11px] sm:text-xs">
                        <div class="flex items-center gap-2 text-slate-200">
                            <span class="text-emerald-400 font-bold">✓</span> 🎓 একাডেমি আন্তঃব্যাচ কাপ (Intra-Academy)
                        </div>
                        <div class="flex items-center gap-2 text-slate-200">
                            <span class="text-amber-400 font-bold">✓</span> 🌟 উন্মুক্ত লোকাল টুর্নামেন্ট (Open Community Cup)
                        </div>
                        <div class="flex items-center gap-2 text-slate-200">
                            <span class="text-rose-400 font-bold">✓</span> 📊 অফিসিয়াল পয়েন্ট টেবিল, গ্রুপ স্ট্যান্ডিংস ও ট্রফি প্রাইজ
                        </div>
                    </div>
                    <div class="pt-2 sm:pt-4">
                        <a href="{{ route('public.tournaments.index') }}" class="px-4 py-2.5 sm:px-6 sm:py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl sm:rounded-2xl text-xs sm:text-sm inline-flex items-center gap-2 shadow-lg shadow-amber-500/20 transition">
                            <span>টুর্নামেন্টে প্রবেশ করুন</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Open Local Player Registration Showcase -->
                <div class="bg-slate-900/90 border border-emerald-500/40 rounded-2xl sm:rounded-3xl p-4 sm:p-10 shadow-2xl space-y-3 sm:space-y-5">
                    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                        <span>🌟</span> উন্মুক্ত প্লেয়ার ড্রাফট
                    </div>
                    <h3 class="text-lg sm:text-4xl font-black text-white leading-snug sm:leading-tight">
                        লোকাল প্লেয়ার হিসেবে <span class="bg-gradient-to-r from-emerald-400 to-teal-300 bg-clip-text text-transparent">টুর্নামেন্টে খেলুন</span>
                    </h3>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                        আপনি কি একাডেমির বাইরে কোনো ক্লাব বা এলাকার খেলোয়াড়? সম্পূর্ণ বিনামূল্যে নাম রেজিস্টার করে ডিজিটাল টুর্নামেন্ট পাস সংগ্রহ করুন এবং একাডেমি টুর্নামেন্টে অংশ নিন।
                    </p>
                    <div class="space-y-1.5 sm:space-y-2 pt-1 sm:pt-2 text-[11px] sm:text-xs">
                        <div class="flex items-center gap-2 text-slate-200">
                            <span class="text-emerald-400 font-bold">✓</span> মাল্টি-স্পোর্টস নির্বাচন (ফুটবল, ক্রিকেট, ব্যাডমিন্টন)
                        </div>
                        <div class="flex items-center gap-2 text-slate-200">
                            <span class="text-emerald-400 font-bold">✓</span> ৩০০x৩০০ স্কয়ার ছবি আপলোড ও ক্রপ সিস্টেম
                        </div>
                        <div class="flex items-center gap-2 text-slate-200">
                            <span class="text-emerald-400 font-bold">✓</span> কিউআর কোড সম্বলিত অফিসিয়াল ডিজিটাল প্লেয়ার পাস ডাউনলোড
                        </div>
                    </div>
                    <div class="pt-2 sm:pt-4">
                        <a href="{{ route('public.local-players.create') }}" class="px-4 py-2.5 sm:px-6 sm:py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl sm:rounded-2xl text-xs sm:text-sm inline-flex items-center gap-2 shadow-lg shadow-emerald-500/20 transition">
                            <span>লোকাল প্লেয়ার রেজিস্ট্রেশন ফরম</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Cricinfo & Teams Hub Showcase Section -->
    <section id="teams" class="py-8 sm:py-20 bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 border-t border-slate-800 relative overflow-hidden scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-gradient-to-b from-slate-900 to-slate-900/90 border border-amber-500/30 rounded-2xl sm:rounded-3xl p-4 sm:p-12 shadow-2xl relative overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-8 items-center">
                    <div>
                        <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2 sm:mb-4">
                            🏆 ক্রিকইনফো-স্টাইল একাডেমি পোর্টাল
                        </div>
                        <h3 class="text-xl sm:text-4xl font-black text-white tracking-tight leading-snug sm:leading-tight">
                            টিম ডিরেক্টরি, স্কোয়াড ও <span class="bg-gradient-to-r from-amber-400 to-rose-400 bg-clip-text text-transparent">প্লেয়ার ক্যারিয়ার রেকর্ড</span>
                        </h3>
                        <p class="text-slate-300 text-xs sm:text-base mt-2 sm:mt-4 leading-relaxed">
                            জামিরবাড়িয়া স্পোর্টস একাডেমির সকল দলের তালিকা, প্রতিটি দলের প্লেয়ার স্কোয়াড এবং আন্তর্জাতিক মানের ক্রিকইনফো স্টাইলে প্রতিটি খেলোয়াড়ের রান, স্ট্রাইক রেট, বোলিং ইকোনমি ও ম্যাচ লগ সমৃদ্ধ পারফরম্যান্স পোর্টাল।
                        </p>

                        <div class="mt-4 sm:mt-8 flex flex-wrap gap-2.5 sm:gap-4">
                            <a href="{{ route('public.teams.index') }}" class="px-4 py-2.5 sm:px-6 sm:py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs sm:text-sm transition shadow-lg shadow-amber-500/20 flex items-center gap-1.5 sm:gap-2">
                                <span>🛡️ সকল টিম ও স্কোয়াড দেখুন</span>
                                <span>➔</span>
                            </a>
                            <a href="{{ route('live.index') }}" class="px-4 py-2.5 sm:px-6 sm:py-3.5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl text-xs sm:text-sm border border-slate-700 transition flex items-center gap-1.5 sm:gap-2">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                <span>লাইভ স্কোর ও সম্প্রচার</span>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5 sm:gap-4">
                        <div class="bg-slate-950/80 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-slate-800 space-y-1 sm:space-y-2">
                            <div class="text-lg sm:text-2xl">🏏</div>
                            <h4 class="font-bold text-white text-xs sm:text-sm">ক্রিকইনফো স্কোরকার্ড</h4>
                            <p class="text-[10px] sm:text-xs text-slate-400">প্রতি ইনিংসে বল-বাই-বল ব্যাটার ও বোলারদের পরিসংখ্যান।</p>
                        </div>
                        <div class="bg-slate-950/80 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-slate-800 space-y-1 sm:space-y-2">
                            <div class="text-lg sm:text-2xl">👤</div>
                            <h4 class="font-bold text-white text-xs sm:text-sm">প্লেয়ার প্রোফাইল</h4>
                            <p class="text-[10px] sm:text-xs text-slate-400">৩০০x৩০০ ছবি, জার্সি নম্বর ও ক্যারিয়ার রেকর্ড।</p>
                        </div>
                        <div class="bg-slate-950/80 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-slate-800 space-y-1 sm:space-y-2">
                            <div class="text-lg sm:text-2xl">🛡️</div>
                            <h4 class="font-bold text-white text-xs sm:text-sm">দল ও স্কোয়াড</h4>
                            <p class="text-[10px] sm:text-xs text-slate-400">অধিনায়ক, কোচ, পয়েন্ট টেবিল ও জয়-পরাজয়ের পূর্ণ হিসাব।</p>
                        </div>
                        <div class="bg-slate-950/80 p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-slate-800 space-y-1 sm:space-y-2">
                            <div class="text-lg sm:text-2xl">📺</div>
                            <h4 class="font-bold text-white text-xs sm:text-sm">লাইভ ম্যাচ সম্প্রচার</h4>
                            <p class="text-[10px] sm:text-xs text-slate-400">সরাসরি ভিডিও স্ট্রিমিং ও রিয়েল-টাইম কমেন্ট্রি।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Volunteer & Match Day Community Section -->
    <section id="volunteer-wing" class="py-8 sm:py-16 bg-slate-950 border-t border-slate-800 relative overflow-hidden scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-slate-900 via-amber-950/20 to-slate-900 border border-amber-500/30 rounded-2xl sm:rounded-3xl p-4 sm:p-10 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-4 sm:gap-6">
                <div class="space-y-1.5 sm:space-y-2 max-w-2xl text-left">
                    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 rounded-full bg-amber-500/10 text-amber-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                        <span>🤝</span> অফিশিয়াল ভলান্টিয়ার উইং
                    </div>
                    <h3 class="text-base sm:text-3xl font-black text-white leading-snug sm:leading-normal">
                        আমাদের সাথে মাঠে থেকে নেতৃত্ব দিন — <span class="text-amber-400">স্বেচ্ছাসেবক আবেদন</span>
                    </h3>
                    <p class="text-slate-300 text-[11px] sm:text-sm leading-relaxed">
                        মাঠ ও পিচ ব্যবস্থাপনা, মিডিয়া ও লাইভ সম্প্রচার, প্রাথমিক চিকিৎসা, নিরাপত্তা এবং অতিথি আপ্যায়নে যুক্ত হতে অনলাইনে আবেদন করুন। অনুমোদনের পর পান নিজস্ব ডিজিটাল ফটো আইডি ব্যাজ ও টুর্নামেন্ট জার্সি।
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0 w-full md:w-auto">
                    <a href="{{ route('volunteer.create') }}" class="w-full sm:w-auto px-4 py-2.5 sm:px-6 sm:py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black rounded-xl text-xs sm:text-sm shadow-xl shadow-amber-500/25 transition text-center flex items-center justify-center gap-2">
                        <span>🤝 অনলাইনে আবেদন করুন</span> ➔
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-950 py-6 sm:py-12 text-center text-[11px] sm:text-xs text-slate-500 space-y-2 sm:space-y-3">
        <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-6 text-slate-400 font-medium">
            <a href="{{ route('rules') }}" class="hover:text-emerald-400 transition">📜 একাডেমির নিয়মাবলী ও শর্তাবলী</a>
            <span class="hidden xs:inline">•</span>
            <a href="{{ route('admission.create') }}" class="hover:text-emerald-400 transition">📝 অনলাইন ভর্তি</a>
            <span class="hidden xs:inline">•</span>
            <a href="{{ route('volunteer.create') }}" class="hover:text-amber-400 font-bold transition">🤝 ভলান্টিয়ার আবেদন</a>
            <span class="hidden xs:inline">•</span>
            <a href="{{ route('public.tournaments.index') }}" class="hover:text-emerald-400 transition">🏆 টুর্নামেন্ট</a>
        </div>
        <p class="font-semibold text-slate-400">জামিরবাড়িয়া স্পোর্টস একাডেমি • Jamirbaria Sports Academy</p>
        <p>© {{ date('Y') }} সর্বস্বত্ব সংরক্ষিত। পেশাদার ক্রীড়া প্রশিক্ষণ ও টুর্নামেন্ট ম্যানেজমেন্ট সিস্টেম।</p>
    </footer>

</body>
</html>

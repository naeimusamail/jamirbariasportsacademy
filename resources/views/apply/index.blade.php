<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>অনলাইন আবেদন ও নিবন্ধন পোর্টাল | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/cropperjs/cropper.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-slate-950 font-sans pb-20">

    <!-- Top Sticky Header -->
    <header x-data="{ mobileMenu: false }" class="border-b border-slate-800/80 bg-slate-900/95 backdrop-blur-md sticky top-0 z-40 transition-all duration-300 shadow-xl shadow-slate-950/40">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 sm:gap-4">
            <a href="{{ url('/') }}" class="flex items-center space-x-2 sm:space-x-3 shrink-0 group min-w-0">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-400 to-amber-400 flex items-center justify-center text-slate-950 font-black text-lg sm:text-2xl shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-300 shrink-0">
                    ⚽
                </div>
                <div class="min-w-0">
                    <span class="text-xs xs:text-base sm:text-lg font-black tracking-tight text-white block leading-tight truncate max-w-[130px] xs:max-w-[210px] sm:max-w-none">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
                    <span class="text-[7.5px] xs:text-[9px] sm:text-[10px] uppercase tracking-widest text-emerald-400 font-bold block truncate max-w-[130px] xs:max-w-none">কেন্দ্রীয় আবেদন ও নিবন্ধন পোর্টাল</span>
                </div>
            </a>

            <nav class="hidden lg:flex items-center space-x-1 xl:space-x-2 text-xs xl:text-sm font-bold text-slate-300">
                <a href="{{ route('public.notice-board') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-emerald-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-emerald-400 group-hover:scale-110 transition-transform">📢</span>
                    <span>নোটিশ ও সার্কুলার</span>
                </a>
                <a href="{{ url('/#live-matches') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-rose-300 hover:bg-slate-800/70 border border-transparent hover:border-rose-500/30 group">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    <span>লাইভ ম্যাচ</span>
                </a>
                <a href="{{ url('/#sports-hub') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-white hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-emerald-400 group-hover:rotate-12 transition-transform">⚽</span>
                    <span>খেলাধুলা ও কারিকুলাম</span>
                </a>
                <a href="{{ route('public.tournaments.index') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-amber-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-amber-400 group-hover:scale-110 transition-transform">🏆</span>
                    <span>টুর্নামেন্ট</span>
                </a>
                <a href="{{ route('public.teams.index') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-cyan-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-cyan-400 group-hover:scale-110 transition-transform">🛡️</span>
                    <span>টিম ও স্কোয়াড</span>
                </a>
                <a href="{{ route('rules') }}" class="relative px-3 py-2 rounded-xl whitespace-nowrap transition-all duration-300 flex items-center gap-1.5 text-slate-300 hover:text-amber-300 hover:bg-slate-800/70 border border-transparent group">
                    <span class="text-amber-400 group-hover:rotate-6 transition-transform">📜</span>
                    <span>একাডেমি রুলস</span>
                </a>
            </nav>

            <div class="flex items-center space-x-1.5 sm:space-x-3 shrink-0">
                <a href="{{ route('admission.track') }}" class="text-[11px] sm:text-xs font-bold px-2 sm:px-3.5 py-1 sm:py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-1.5 whitespace-nowrap shadow">
                    <span>🔍</span>
                    <span class="hidden sm:inline">আবেদন ট্র্যাকিং</span>
                </a>
                <a href="{{ url('/') }}" class="text-[11px] sm:text-sm font-bold text-slate-400 hover:text-white px-1.5 sm:px-2.5 py-1 sm:py-2 transition whitespace-nowrap">
                    ← হোম
                </a>
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
            <a href="{{ route('public.notice-board') }}" class="block px-3.5 py-2 rounded-xl text-emerald-400 hover:bg-slate-800 font-bold">📢 নোটিশ ও সার্কুলার হাব</a>
            <a href="{{ url('/#live-matches') }}" class="block px-3.5 py-2 rounded-xl text-rose-400 hover:bg-slate-800 font-bold">🔴 লাইভ ম্যাচ</a>
            <a href="{{ url('/#sports-hub') }}" class="block px-3.5 py-2 rounded-xl hover:bg-slate-800 font-bold">⚽ খেলাধুলা ও কারিকুলাম</a>
            <a href="{{ route('public.tournaments.index') }}" class="block px-3.5 py-2 rounded-xl text-amber-400 hover:bg-slate-800 font-bold">🏆 টুর্নামেন্ট</a>
            <a href="{{ route('public.teams.index') }}" class="block px-3.5 py-2 rounded-xl text-cyan-400 hover:bg-slate-800 font-bold">🛡️ টিম ও স্কোয়াড</a>
            <a href="{{ route('rules') }}" class="block px-3.5 py-2 rounded-xl hover:bg-slate-800 font-bold">📜 একাডেমি রুলস ও টার্মস</a>
        </div>
    </header>

    <!-- Main Container with Alpine State -->
    <div x-data="{
        activeTab: '{{ request('tab', $tab ?? 'admission') }}',
        init() {
            const hash = window.location.hash.replace('#', '');
            if (['admission', 'local_player', 'volunteer'].includes(hash)) {
                this.activeTab = hash;
            }
        },
        setTab(t) {
            this.activeTab = t;
            window.location.hash = t;
            const target = document.getElementById('application-workspace');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }" x-init="init()" class="relative">

        <!-- Page Hero Banner -->
        <section class="py-8 sm:py-12 lg:py-16 bg-gradient-to-b from-slate-950 via-[#061713] to-slate-950 border-b border-slate-800/80 relative overflow-hidden">
            <!-- Floodlight Beam Glows -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[350px] bg-emerald-500/15 blur-[140px] rounded-full pointer-events-none"></div>
            <div class="absolute top-10 right-10 w-[400px] h-[250px] bg-amber-500/10 blur-[120px] rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1 sm:py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2.5 sm:mb-4">
                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    সেশন ২০২৬ • সমন্বিত আবেদন ও নিবন্ধন গেটওয়ে
                </div>

                <h1 class="text-2xl xs:text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight max-w-4xl mx-auto">
                    অনলাইন আবেদন ও <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-400 bg-clip-text text-transparent">নিবন্ধন পোর্টাল</span>
                </h1>

                <p class="text-slate-300 text-xs sm:text-sm sm:leading-relaxed max-w-2xl mx-auto mt-2 sm:mt-4">
                    একাডেমির নিয়মিত প্রশিক্ষণার্থী ভর্তি, উন্মুক্ত টুর্নামেন্ট ড্রাফট প্লেয়ার নিবন্ধন এবং ম্যাচ-ডে ভলান্টিয়ার উইংয়ের সমন্বিত ডিজিটাল সিস্টেম। নিচের যেকোনো একটি অপশন বেছে নিয়ে সরাসরি ফরম পূরণ করুন।
                </p>

                <!-- ============================================================== -->
                <!-- 🎯 3 INTERACTIVE TRACK SELECTOR CARDS (THE CORE COMPONENT)   -->
                <!-- ============================================================== -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 sm:gap-5 mt-6 sm:mt-10 text-left max-w-6xl mx-auto">

                    <!-- CARD 1: ACADEMY ADMISSION -->
                    @php
                        $admStatus = $admissionCircular ? $admissionCircular->getStatus() : 'open';
                        $admStatusLabel = $admStatus === 'open' ? 'ভর্তি চলমান' : ($admStatus === 'upcoming' ? 'আসন্ন' : 'সময় শেষ');
                        $admBadgeClass = $admStatus === 'open' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30' : ($admStatus === 'upcoming' ? 'bg-amber-500/10 text-amber-400 border-amber-500/30' : 'bg-rose-500/10 text-rose-400 border-rose-500/30');
                    @endphp
                    <div @click="setTab('admission')"
                         :class="activeTab === 'admission' ? 'border-emerald-500 ring-2 ring-emerald-500/30 bg-slate-900 shadow-2xl shadow-emerald-500/10' : 'border-slate-800 hover:border-emerald-500/40 bg-slate-900/60 opacity-80 hover:opacity-100'"
                         class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl border transition cursor-pointer flex flex-col justify-between group relative overflow-hidden">
                        
                        <!-- Top Row: Icon & Status -->
                        <div>
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl sm:text-2xl group-hover:scale-110 transition-transform">
                                    🎓
                                </div>
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold border flex items-center gap-1.5 {{ $admBadgeClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current {{ $admStatus === 'open' ? 'animate-ping' : '' }}"></span>
                                    <span>{{ $admStatusLabel }}</span>
                                </span>
                            </div>

                            <h3 class="text-base sm:text-lg font-black text-white group-hover:text-emerald-400 transition leading-snug">
                                একাডেমি প্রশিক্ষণার্থী ভর্তি
                            </h3>
                            <p class="text-[11px] sm:text-xs text-slate-400 mt-1 sm:mt-1.5 leading-relaxed">
                                ক্রিকেট, ফুটবল, ব্যাডমিন্টন ও অ্যাথলেটিক্সে পেশাদার প্রশিক্ষণ। U12 থেকে Senior বয়স ভিত্তিক একাডেমি কারিকুলাম।
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-3.5 sm:pt-5 mt-3 sm:mt-4 border-t border-slate-800 flex items-center justify-between text-xs">
                            <span class="font-mono text-emerald-400 font-bold text-[11px] sm:text-xs">
                                ফি: ৳{{ number_format($admissionCircular->fee ?? 1000) }}
                            </span>
                            <span :class="activeTab === 'admission' ? 'bg-emerald-500 text-slate-950 font-black' : 'bg-slate-800 text-slate-300 font-bold group-hover:bg-emerald-500 group-hover:text-slate-950'"
                                  class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs transition flex items-center gap-1">
                                <span x-text="activeTab === 'admission' ? '✓ সক্রিয় ফরম' : 'ভর্তি ফরম ➔'"></span>
                            </span>
                        </div>
                    </div>

                    <!-- CARD 2: LOCAL PLAYER DRAFT PASS -->
                    @php
                        $lpStatus = $localPlayerCircular ? $localPlayerCircular->getStatus() : 'open';
                        $lpStatusLabel = $lpStatus === 'open' ? 'নিবন্ধন উন্মুক্ত' : ($lpStatus === 'upcoming' ? 'আসন্ন' : 'সময় শেষ');
                        $lpBadgeClass = $lpStatus === 'open' ? 'bg-amber-500/10 text-amber-400 border-amber-500/30' : ($lpStatus === 'upcoming' ? 'bg-amber-500/10 text-amber-400 border-amber-500/30' : 'bg-rose-500/10 text-rose-400 border-rose-500/30');
                    @endphp
                    <div @click="setTab('local_player')"
                         :class="activeTab === 'local_player' ? 'border-amber-500 ring-2 ring-amber-500/30 bg-slate-900 shadow-2xl shadow-amber-500/10' : 'border-slate-800 hover:border-amber-500/40 bg-slate-900/60 opacity-80 hover:opacity-100'"
                         class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl border transition cursor-pointer flex flex-col justify-between group relative overflow-hidden">
                        
                        <!-- Top Row: Icon & Status -->
                        <div>
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl sm:text-2xl group-hover:scale-110 transition-transform">
                                    🌟
                                </div>
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold border flex items-center gap-1.5 {{ $lpBadgeClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current {{ $lpStatus === 'open' ? 'animate-ping' : '' }}"></span>
                                    <span>{{ $lpStatusLabel }}</span>
                                </span>
                            </div>

                            <h3 class="text-base sm:text-lg font-black text-white group-hover:text-amber-400 transition leading-snug">
                                লোকাল প্লেয়ার টুর্নামেন্ট পাস
                            </h3>
                            <p class="text-[11px] sm:text-xs text-slate-400 mt-1 sm:mt-1.5 leading-relaxed">
                                ওপেন নকআউট টুর্নামেন্ট ও ড্রাফট স্কোয়াডে খেলার ডিজিটাল প্লেয়ার পাস। ৪-ধাপের সহজ উইজার্ড ও প্রিভিউ কার্ড।
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-3.5 sm:pt-5 mt-3 sm:mt-4 border-t border-slate-800 flex items-center justify-between text-xs">
                            <span class="font-mono text-amber-400 font-bold text-[11px] sm:text-xs">
                                ড্রাফট: সম্পূর্ণ ফ্রি
                            </span>
                            <span :class="activeTab === 'local_player' ? 'bg-amber-500 text-slate-950 font-black' : 'bg-slate-800 text-slate-300 font-bold group-hover:bg-amber-500 group-hover:text-slate-950'"
                                  class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs transition flex items-center gap-1">
                                <span x-text="activeTab === 'local_player' ? '✓ সক্রিয় ফরম' : 'ড্রাফট পাস ➔'"></span>
                            </span>
                        </div>
                    </div>

                    <!-- CARD 3: VOLUNTEER RECRUITMENT -->
                    @php
                        $volStatus = $volunteerCircular ? $volunteerCircular->getStatus() : 'open';
                        $volStatusLabel = $volStatus === 'open' ? 'নিয়োগ চলমান' : ($volStatus === 'upcoming' ? 'আসন্ন' : 'সময় শেষ');
                        $volBadgeClass = $volStatus === 'open' ? 'bg-sky-500/10 text-sky-400 border-sky-500/30' : ($volStatus === 'upcoming' ? 'bg-amber-500/10 text-amber-400 border-amber-500/30' : 'bg-rose-500/10 text-rose-400 border-rose-500/30');
                    @endphp
                    <div @click="setTab('volunteer')"
                         :class="activeTab === 'volunteer' ? 'border-sky-500 ring-2 ring-sky-500/30 bg-slate-900 shadow-2xl shadow-sky-500/10' : 'border-slate-800 hover:border-sky-500/40 bg-slate-900/60 opacity-80 hover:opacity-100'"
                         class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl border transition cursor-pointer flex flex-col justify-between group relative overflow-hidden">
                        
                        <!-- Top Row: Icon & Status -->
                        <div>
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-sky-500/10 border border-sky-500/30 text-sky-400 flex items-center justify-center text-xl sm:text-2xl group-hover:scale-110 transition-transform">
                                    🤝
                                </div>
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold border flex items-center gap-1.5 {{ $volBadgeClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current {{ $volStatus === 'open' ? 'animate-ping' : '' }}"></span>
                                    <span>{{ $volStatusLabel }}</span>
                                </span>
                            </div>

                            <h3 class="text-base sm:text-lg font-black text-white group-hover:text-sky-400 transition leading-snug">
                                অফিসিয়াল ভলান্টিয়ার উইং
                            </h3>
                            <p class="text-[11px] sm:text-xs text-slate-400 mt-1 sm:mt-1.5 leading-relaxed">
                                টুর্নামেন্ট ও ম্যাচ ডে ব্যবস্থাপনা, মিডিয়া সম্প্রচার ও নিরাপত্তা টিমে দায়িত্ব পালন। ফটো আইডি ব্যাজ ও জার্সি সুবিধা।
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-3.5 sm:pt-5 mt-3 sm:mt-4 border-t border-slate-800 flex items-center justify-between text-xs">
                            <span class="font-mono text-sky-400 font-bold text-[11px] sm:text-xs">
                                আইডি ব্যাজ ও কিট
                            </span>
                            <span :class="activeTab === 'volunteer' ? 'bg-sky-500 text-slate-950 font-black' : 'bg-slate-800 text-slate-300 font-bold group-hover:bg-sky-500 group-hover:text-slate-950'"
                                  class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-lg sm:rounded-xl text-[11px] sm:text-xs transition flex items-center gap-1">
                                <span x-text="activeTab === 'volunteer' ? '✓ সক্রিয় ফরম' : 'ভলান্টিয়ার ফরম ➔'"></span>
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- ============================================================== -->
        <!-- 📝 ACTIVE APPLICATION FORM WORKSPACE                         -->
        <!-- ============================================================== -->
        <main id="application-workspace" class="py-6 sm:py-12 relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Sub Header Tab Pill Switcher -->
            <div class="flex items-center justify-center gap-1.5 sm:gap-2 mb-6 sm:mb-10 overflow-x-auto pb-2">
                <button type="button" @click="setTab('admission')"
                        :class="activeTab === 'admission' ? 'bg-emerald-500 text-slate-950 font-black shadow-lg shadow-emerald-500/20' : 'bg-slate-900 text-slate-400 hover:text-white border border-slate-800 font-bold'"
                        class="px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl text-[11px] sm:text-sm transition flex items-center gap-1.5 sm:gap-2 shrink-0">
                    <span>🎓</span>
                    <span>একাডেমি ভর্তি</span>
                </button>

                <button type="button" @click="setTab('local_player')"
                        :class="activeTab === 'local_player' ? 'bg-amber-500 text-slate-950 font-black shadow-lg shadow-amber-500/20' : 'bg-slate-900 text-slate-400 hover:text-white border border-slate-800 font-bold'"
                        class="px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl text-[11px] sm:text-sm transition flex items-center gap-1.5 sm:gap-2 shrink-0">
                    <span>🌟</span>
                    <span>লোকাল প্লেয়ার পাস</span>
                </button>

                <button type="button" @click="setTab('volunteer')"
                        :class="activeTab === 'volunteer' ? 'bg-sky-500 text-slate-950 font-black shadow-lg shadow-sky-500/20' : 'bg-slate-900 text-slate-400 hover:text-white border border-slate-800 font-bold'"
                        class="px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-2xl text-[11px] sm:text-sm transition flex items-center gap-1.5 sm:gap-2 shrink-0">
                    <span>🤝</span>
                    <span>ভলান্টিয়ার আবেদন</span>
                </button>
            </div>

            <!-- TAB 1: ADMISSION FORM -->
            <div x-show="activeTab === 'admission'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0">
                @include('apply.partials.admission')
            </div>

            <!-- TAB 2: LOCAL PLAYER REGISTRATION -->
            <div x-show="activeTab === 'local_player'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="display: none;">
                @include('apply.partials.local-player')
            </div>

            <!-- TAB 3: VOLUNTEER REGISTRATION -->
            <div x-show="activeTab === 'volunteer'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="display: none;">
                @include('apply.partials.volunteer')
            </div>

        </main>

        <!-- ============================================================== -->
        <!-- 🔍 BOTTOM TRACKING & VERIFICATION QUICK BAR                    -->
        <!-- ============================================================== -->
        <section class="border-t border-slate-800 bg-slate-900/40 py-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2">
                            <span>🔍</span> দ্রুত ট্র্যাকিং ও আইডি সংগ্রহ
                        </div>
                        <h4 class="text-xl font-black text-white">পূর্বে যেকোনো ফরম জমা দিয়েছেন?</h4>
                        <p class="text-xs text-slate-400 mt-1">
                            আপনার মোবাইল নম্বর বা আবেদন নম্বর দিয়ে তাৎক্ষণিক আবেদনের অবস্থা যাচাই করুন ও ডিজিটাল পাস সংগ্রহ করুন।
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admission.track') }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-emerald-500/30 rounded-xl text-xs font-bold transition flex items-center gap-2">
                            <span>🎓</span>
                            <span>ভর্তি স্ট্যাটাস ট্র্যাক</span>
                        </a>
                        <a href="{{ route('volunteer.track.search') }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-sky-400 border border-sky-500/30 rounded-xl text-xs font-bold transition flex items-center gap-2">
                            <span>🤝</span>
                            <span>ভলান্টিয়ার আইডি ট্র্যাকিং</span>
                        </a>
                        <a href="{{ route('public.tournaments.index') }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-amber-400 border border-amber-500/30 rounded-xl text-xs font-bold transition flex items-center gap-2">
                            <span>🏆</span>
                            <span>টুর্নামেন্ট সেক্টর</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-950 py-10 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 space-y-3">
            <div class="flex flex-wrap items-center justify-center gap-4 text-slate-400 font-medium">
                <a href="{{ url('/') }}" class="hover:text-emerald-400 transition">হোমপেজ</a>
                <span>•</span>
                <a href="{{ route('public.notice-board') }}" class="hover:text-emerald-400 transition">নোটিশ ও সার্কুলার</a>
                <span>•</span>
                <a href="{{ route('public.tournaments.index') }}" class="hover:text-emerald-400 transition">টুর্নামেন্ট</a>
                <span>•</span>
                <a href="{{ route('rules') }}" class="hover:text-emerald-400 transition">নিয়মাবলী ও শর্তাবলী</a>
            </div>
            <p class="text-slate-400 font-semibold">জামিরবাড়িয়া স্পোর্টস একাডেমি • Jamirbaria Sports Academy</p>
            <p>© 2026 সর্বস্বত্ব সংরক্ষিত।</p>
        </div>
    </footer>

    <!-- Vendor Scripts: Cropper.js -->
    <script src="{{ asset('vendor/cropperjs/cropper.min.js') }}"></script>

    <!-- Unified Form Scripts (Admission, Local Player, Volunteer) -->
    <script>
        // ==============================================================
        // 1. BANGLA TO ENGLISH DIGITS AUTO-CONVERTER
        // ==============================================================
        const bnDigitsMap = { '০': '0', '১': '1', '২': '2', '৩': '3', '৪': '4', '৫': '5', '৬': '6', '৭': '7', '৮': '8', '৯': '9' };
        document.querySelectorAll('.english-number-only').forEach(el => {
            const sanitize = () => {
                let v = el.value.replace(/[০-৯]/g, d => bnDigitsMap[d] || d);
                v = v.replace(/[^0-9+\- ]/g, '');
                if (el.value !== v) el.value = v;
            };
            el.addEventListener('input', sanitize);
            el.addEventListener('change', sanitize);
            el.addEventListener('paste', () => setTimeout(sanitize, 10));
        });

        // ==============================================================
        // 2. ADMISSION LOGIC: CROPPER, PAYMENT METHODS & NID CHECK
        // ==============================================================
        (function initAdmission() {
            // Photo Cropper for Admission
            let admCropper = null;
            const admPhotoInput = document.getElementById('adm_photo-input');
            const admCropperModal = document.getElementById('adm_cropper-modal');
            const admCropperImage = document.getElementById('adm_cropper-image');
            const admCroppedPhoto = document.getElementById('adm_cropped_photo');
            const admPreviewImg = document.getElementById('adm_preview-img');
            const admPreviewPlaceholder = document.getElementById('adm_preview-placeholder');
            const admCropBadge = document.getElementById('adm_crop-badge');

            if (admPhotoInput) {
                admPhotoInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    if (files && files.length > 0) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            admCropperImage.src = evt.target.result;
                            admCropperModal.classList.remove('hidden');
                            if (admCropper) admCropper.destroy();
                            admCropper = new Cropper(admCropperImage, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 0.9,
                            });
                        };
                        reader.readAsDataURL(files[0]);
                    }
                });

                document.getElementById('adm_crop-zoom-in')?.addEventListener('click', () => admCropper && admCropper.zoom(0.1));
                document.getElementById('adm_crop-zoom-out')?.addEventListener('click', () => admCropper && admCropper.zoom(-0.1));
                document.getElementById('adm_crop-rotate-left')?.addEventListener('click', () => admCropper && admCropper.rotate(-90));
                document.getElementById('adm_crop-reset')?.addEventListener('click', () => admCropper && admCropper.reset());

                function closeAdmCropper() {
                    admCropperModal.classList.add('hidden');
                    if (admCropper) {
                        admCropper.destroy();
                        admCropper = null;
                    }
                }
                document.getElementById('adm_cropper-close-btn')?.addEventListener('click', closeAdmCropper);
                document.getElementById('adm_crop-cancel-btn')?.addEventListener('click', closeAdmCropper);

                document.getElementById('adm_crop-confirm-btn')?.addEventListener('click', function() {
                    if (!admCropper) return;
                    const canvas = admCropper.getCroppedCanvas({ width: 300, height: 300, imageSmoothingQuality: 'high' });
                    const base64Url = canvas.toDataURL('image/jpeg', 0.92);
                    admCroppedPhoto.value = base64Url;
                    admPreviewImg.src = base64Url;
                    admPreviewImg.classList.remove('hidden');
                    admPreviewPlaceholder.classList.add('hidden');
                    admCropBadge.classList.remove('hidden');
                    closeAdmCropper();
                });
            }

            // Payment Methods
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const instructionBox = document.getElementById('adm_method-instruction-box');
            const trxContainer = document.getElementById('adm_transaction-fields-container');
            const senderInput = document.getElementById('adm_sender_number');
            const trxInput = document.getElementById('adm_transaction_id');

            const methodGuides = {
                bkash: {
                    title: 'বিকাশ (bKash) পেমেন্ট নির্দেশিকা:',
                    desc: 'বিকাশ পার্সোনাল নম্বরে Send Money করুন: <span class="text-pink-400 font-mono font-bold select-all">01712-345678</span>। টাকা পাঠানোর পর মেসেজের TrxID এবং প্রেরক নম্বরটি লিখুন।',
                    showTrx: true,
                    badgeClass: 'border-pink-500/30 text-pink-300'
                },
                nagad: {
                    title: 'নগদ (Nagad) পেমেন্ট নির্দেশিকা:',
                    desc: 'নগদ পার্সোনাল নম্বরে Send Money করুন: <span class="text-amber-400 font-mono font-bold select-all">01712-345678</span>। টাকা পাঠানোর পর মেসেজের TrxID এবং প্রেরক নম্বরটি লিখুন।',
                    showTrx: true,
                    badgeClass: 'border-amber-500/30 text-amber-300'
                },
                rocket: {
                    title: 'রকেট (Rocket) পেমেন্ট নির্দেশিকা:',
                    desc: 'রকেট পার্সোনাল নম্বরে Send Money করুন: <span class="text-purple-400 font-mono font-bold select-all">01712-345678-9</span>। ট্রানজেকশন সম্পন্ন করে TrxID দিন।',
                    showTrx: true,
                    badgeClass: 'border-purple-500/30 text-purple-300'
                },
                cash: {
                    title: 'অফিস ক্যাশ কাউন্টারে সরাসরি ফি জমা:',
                    desc: 'অনলাইনে আবেদন সম্পন্ন করার পর আপনি সরাসরি জামিরবাড়িয়া একাডেমি অফিস কাউন্টারে এসে ক্যাশ ফি জমা দিতে পারবেন।',
                    showTrx: false,
                    badgeClass: 'border-emerald-500/30 text-emerald-300'
                }
            };

            function updatePaymentUI() {
                const selected = document.querySelector('input[name="payment_method"]:checked')?.value || 'bkash';
                const guide = methodGuides[selected];
                if (!guide || !instructionBox) return;

                instructionBox.className = `p-4 rounded-2xl bg-slate-950 border ${guide.badgeClass} text-xs mb-5`;
                instructionBox.innerHTML = `
                    <div class="font-bold mb-1">${guide.title}</div>
                    <div class="text-slate-300 leading-relaxed">${guide.desc}</div>
                `;

                if (trxContainer) {
                    if (guide.showTrx) {
                        trxContainer.classList.remove('hidden');
                        if (senderInput) senderInput.required = true;
                        if (trxInput) trxInput.required = true;
                    } else {
                        trxContainer.classList.add('hidden');
                        if (senderInput) { senderInput.required = false; senderInput.value = ''; }
                        if (trxInput) { trxInput.required = false; trxInput.value = ''; }
                    }
                }
            }

            paymentMethods.forEach(radio => radio.addEventListener('change', updatePaymentUI));
            updatePaymentUI();

            // NID Duplicate Check
            const nidInput = document.getElementById('adm_nid_or_birth_cert');
            const phoneInput = document.getElementById('adm_phone');
            const nidFeedback = document.getElementById('adm_nid-verify-feedback');
            let checkTimer = null;

            function checkLiveDuplicate() {
                const docVal = nidInput ? nidInput.value.trim() : '';
                const phoneVal = phoneInput ? phoneInput.value.trim() : '';

                if (docVal.length < 8 && phoneVal.length < 10) {
                    if (nidFeedback) nidFeedback.classList.add('hidden');
                    return;
                }

                fetch(`{{ route('api.verify-player-document') }}?nid_or_birth_cert=${encodeURIComponent(docVal)}&phone=${encodeURIComponent(phoneVal)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.report && nidFeedback) {
                            const r = data.report;
                            nidFeedback.classList.remove('hidden');
                            if (r.is_strict_duplicate) {
                                nidFeedback.className = 'mt-1.5 text-xs p-2.5 rounded-xl border border-rose-500/40 bg-rose-500/10 text-rose-300';
                                nidFeedback.innerHTML = `⚠️ <strong>সতর্কবার্তা:</strong> এই নম্বর দিয়ে ইতিমধ্যে একজন প্লেয়ার (${r.matches[0]?.name || 'নিবন্ধিত'}) অ্যাকাউন্টে রয়েছেন।`;
                            } else if (docVal.length >= 10) {
                                nidFeedback.className = 'mt-1.5 text-xs p-2.5 rounded-xl border border-emerald-500/40 bg-emerald-500/10 text-emerald-300';
                                nidFeedback.innerHTML = `✓ <strong>যাচাই সম্পন্ন:</strong> জন্ম নিবন্ধন / এনআইডি নম্বরটি নতুন প্লেয়ার হিসেবে গ্রহণের জন্য প্রস্তুত।`;
                            } else {
                                nidFeedback.classList.add('hidden');
                            }
                        }
                    })
                    .catch(() => {});
            }

            if (nidInput) {
                nidInput.addEventListener('input', () => {
                    clearTimeout(checkTimer);
                    checkTimer = setTimeout(checkLiveDuplicate, 450);
                });
            }
            if (phoneInput) phoneInput.addEventListener('blur', checkLiveDuplicate);
        })();

        // ==============================================================
        // 3. LOCAL PLAYER WIZARD & DUPLICATE CHECKER
        // ==============================================================
        let currentLpStep = 1;
        const totalLpSteps = 4;

        function updateLpSportCardStyle(checkbox) {
            const label = checkbox.closest('.lp-sport-card');
            const indicator = label.querySelector('.lp-sport-check-indicator');
            const icon = label.querySelector('.lp-check-icon');

            if (checkbox.checked) {
                label.classList.add('border-amber-500', 'bg-amber-500/10');
                label.classList.remove('border-slate-800', 'bg-slate-950/60');
                indicator.classList.add('bg-amber-500', 'border-amber-500');
                indicator.classList.remove('border-slate-700');
                icon.classList.remove('hidden');
            } else {
                label.classList.remove('border-amber-500', 'bg-amber-500/10');
                label.classList.add('border-slate-800', 'bg-slate-950/60');
                indicator.classList.remove('bg-amber-500', 'border-amber-500');
                indicator.classList.add('border-slate-700');
                icon.classList.add('hidden');
            }
        }
        document.querySelectorAll('.lp-sport-checkbox').forEach(updateLpSportCardStyle);

        function showLpAlert(msg) {
            const alertBox = document.getElementById('lp_validation-alert');
            const alertMsg = document.getElementById('lp_validation-alert-msg');
            if (alertBox && alertMsg) {
                alertMsg.innerText = msg;
                alertBox.classList.remove('hidden');
                alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        function hideLpAlert() {
            document.getElementById('lp_validation-alert')?.classList.add('hidden');
        }

        function validateAndGoLpStep(nextStep) {
            hideLpAlert();
            if (nextStep === 2 && currentLpStep === 1) {
                const checkedSports = document.querySelectorAll('input[name="sports[]"]:checked');
                if (checkedSports.length === 0) {
                    showLpAlert('অনুগ্রহ করে অন্তত ১টি খেলা নির্বাচন করুন।');
                    return;
                }
            }
            if (nextStep === 3 && currentLpStep === 2) {
                const name = document.getElementById('lp_input_name')?.value.trim();
                const phone = document.getElementById('lp_input_phone')?.value.trim();
                const dob = document.getElementById('lp_input_date_of_birth')?.value;
                const address = document.getElementById('lp_input_address')?.value.trim();

                if (!name) { showLpAlert('খেলোয়াড়ের নাম প্রদান করুন।'); return; }
                if (!phone || phone.length < 11) { showLpAlert('সঠিক ১১ ডিজিটের মোবাইল নম্বর দিন।'); return; }
                if (!dob) { showLpAlert('জন্ম তারিখ নির্বাচন করুন।'); return; }
                if (!address) { showLpAlert('স্থায়ী ঠিকানা প্রদান করুন।'); return; }
            }
            if (nextStep === 4) {
                updateLpReviewCard();
            }
            goToLpStep(nextStep);
        }

        function goToLpStep(step) {
            currentLpStep = step;
            hideLpAlert();

            for (let i = 1; i <= totalLpSteps; i++) {
                const el = document.getElementById('lp_step-' + i);
                if (el) {
                    if (i === step) el.classList.remove('hidden');
                    else el.classList.add('hidden');
                }
            }

            const progressBar = document.getElementById('lp_step-progress-bar');
            if (progressBar) {
                const pct = ((step - 1) / (totalLpSteps - 1)) * 100;
                progressBar.style.width = pct + '%';
            }

            for (let i = 1; i <= totalLpSteps; i++) {
                const badge = document.getElementById('lp_step-badge-' + i);
                const text = document.getElementById('lp_step-text-' + i);
                if (!badge || !text) continue;

                if (i === step) {
                    badge.className = 'w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-amber-500 text-slate-950 ring-4 ring-amber-500/20';
                    text.className = 'text-[11px] font-black mt-1.5 transition text-amber-400';
                    badge.innerHTML = `<span>${i}</span>`;
                } else if (i < step) {
                    badge.className = 'w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-emerald-500 text-slate-950';
                    text.className = 'text-[11px] font-bold mt-1.5 transition text-slate-400';
                    badge.innerHTML = `<span>✓</span>`;
                } else {
                    badge.className = 'w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-slate-800 text-slate-400 border border-slate-700';
                    text.className = 'text-[11px] font-bold mt-1.5 transition text-slate-500';
                    badge.innerHTML = `<span>${i}</span>`;
                }
            }
        }

        function updateLpReviewCard() {
            const name = document.getElementById('lp_input_name')?.value.trim() || 'নাম প্রদান করা হয়নি';
            const phone = document.getElementById('lp_input_phone')?.value.trim() || '-';
            const emergency = document.getElementById('lp_input_emergency_phone')?.value.trim() || 'দেওয়া হয়নি';
            const guardian = document.getElementById('lp_input_guardian_name')?.value.trim() || 'দেওয়া হয়নি';
            const dob = document.getElementById('lp_input_date_of_birth')?.value || '-';
            const blood = document.getElementById('lp_input_blood_group')?.value || 'অজ্ঞাত';
            const nid = document.getElementById('lp_input_nid')?.value.trim() || 'দেওয়া হয়নি';
            const address = document.getElementById('lp_input_address')?.value.trim() || '-';
            const position = document.getElementById('lp_input_position')?.value.trim() || 'সাধারণ প্লেয়ার';
            const jersey = document.getElementById('lp_input_jersey_no')?.value.trim();

            document.getElementById('lp_review-name').innerText = name;
            document.getElementById('lp_review-phone').innerText = phone;
            document.getElementById('lp_review-emergency').innerText = emergency;
            document.getElementById('lp_review-guardian').innerText = guardian;
            document.getElementById('lp_review-dob-blood').innerText = `${dob} (${blood})`;
            document.getElementById('lp_review-nid').innerText = nid;
            document.getElementById('lp_review-address').innerText = address;
            document.getElementById('lp_review-position').innerText = '• ' + position;
            document.getElementById('lp_review-jersey').innerText = jersey ? `#${jersey}` : '';

            // Sports badges
            const badgesContainer = document.getElementById('lp_review-sports-badges');
            if (badgesContainer) {
                badgesContainer.innerHTML = '';
                document.querySelectorAll('input[name="sports[]"]:checked').forEach(sp => {
                    const icon = sp.getAttribute('data-icon') || '⚽';
                    const sname = sp.getAttribute('data-name') || 'খেলা';
                    badgesContainer.innerHTML += `
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-[11px] font-bold">
                            <span>${icon}</span> <span>${sname}</span>
                        </span>
                    `;
                });
            }

            // Cropped photo in review
            const croppedVal = document.getElementById('lp_cropped_photo')?.value;
            const reviewPhoto = document.getElementById('lp_review-photo');
            const reviewPhotoPlaceholder = document.getElementById('lp_review-photo-placeholder');
            if (croppedVal && reviewPhoto && reviewPhotoPlaceholder) {
                reviewPhoto.src = croppedVal;
                reviewPhoto.classList.remove('hidden');
                reviewPhotoPlaceholder.classList.add('hidden');
            }
        }

        // Local Player Cropper
        (function initLpCropper() {
            let lpCropper = null;
            const photoInput = document.getElementById('lp_player_photo_input');
            const modal = document.getElementById('lp_cropperModal');
            const img = document.getElementById('lp_cropperImage');
            const applyBtn = document.getElementById('lp_applyCropBtn');
            const cancelBtn = document.getElementById('lp_cancelCropBtn');
            const closeBtn = document.getElementById('lp_closeModalBtn');
            const previewImg = document.getElementById('lp_preview_crop_img');
            const placeholder = document.getElementById('lp_placeholder_icon');
            const croppedInput = document.getElementById('lp_cropped_photo');

            if (photoInput) {
                photoInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    if (files && files.length > 0) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            img.src = evt.target.result;
                            modal.classList.remove('hidden');
                            if (lpCropper) lpCropper.destroy();
                            lpCropper = new Cropper(img, {
                                aspectRatio: 1,
                                viewMode: 1,
                                autoCropArea: 0.9,
                            });
                        };
                        reader.readAsDataURL(files[0]);
                    }
                });

                function close() {
                    modal.classList.add('hidden');
                    if (lpCropper) { lpCropper.destroy(); lpCropper = null; }
                }
                cancelBtn?.addEventListener('click', close);
                closeBtn?.addEventListener('click', close);

                applyBtn?.addEventListener('click', function() {
                    if (!lpCropper) return;
                    const canvas = lpCropper.getCroppedCanvas({ width: 300, height: 300, imageSmoothingQuality: 'high' });
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                    croppedInput.value = dataUrl;
                    previewImg.src = dataUrl;
                    previewImg.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    close();
                });
            }

            // Live Duplicate Check for Local Player
            const livePhone = document.getElementById('lp_input_phone');
            const liveNid = document.getElementById('lp_input_nid');
            const pBadge = document.getElementById('lp_phone-status-badge');
            const nBadge = document.getElementById('lp_nid-status-badge');
            const pFeedback = document.getElementById('lp_phone-feedback');
            const nFeedback = document.getElementById('lp_nid-feedback');
            let lpTimeout = null;

            function check() {
                clearTimeout(lpTimeout);
                lpTimeout = setTimeout(() => {
                    const pVal = livePhone ? livePhone.value.trim() : '';
                    const nVal = liveNid ? liveNid.value.trim() : '';
                    if (!pVal && !nVal) return;

                    fetch(`{{ route('api.verify-player-document') }}?phone=${encodeURIComponent(pVal)}&nid_or_birth_cert=${encodeURIComponent(nVal)}`)
                        .then(r => r.json())
                        .then(res => {
                            if (res.success && res.report) {
                                const matches = res.report.matches || [];
                                const pMatch = matches.find(m => m.field === 'phone');
                                if (pMatch && pFeedback && pBadge) {
                                    pBadge.className = 'text-[10px] font-bold px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 border border-rose-500/30';
                                    pBadge.innerText = '⚠️ পূর্বে ব্যবহৃত নম্বর';
                                    pBadge.classList.remove('hidden');
                                    pFeedback.className = 'mt-1 text-[11px] font-bold text-rose-300 bg-rose-950/60 p-2 rounded-xl block';
                                    pFeedback.innerText = pMatch.message;
                                    pFeedback.classList.remove('hidden');
                                } else if (pVal.length >= 11 && pBadge) {
                                    pBadge.className = 'text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
                                    pBadge.innerText = '✓ ইউনিক নম্বর';
                                    pBadge.classList.remove('hidden');
                                    if (pFeedback) pFeedback.classList.add('hidden');
                                }

                                const nMatch = matches.find(m => m.field === 'nid_or_birth_cert');
                                if (nMatch && nFeedback && nBadge) {
                                    nBadge.className = 'text-[10px] font-bold px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 border border-rose-500/30';
                                    nBadge.innerText = '⚠️ ডুপ্লিকেট NID';
                                    nBadge.classList.remove('hidden');
                                    nFeedback.className = 'mt-1 text-[11px] font-bold text-rose-300 bg-rose-950/60 p-2 rounded-xl block';
                                    nFeedback.innerText = nMatch.message;
                                    nFeedback.classList.remove('hidden');
                                } else if (nVal.length >= 8 && nBadge) {
                                    nBadge.className = 'text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
                                    nBadge.innerText = '✓ ইউনিক সনদ';
                                    nBadge.classList.remove('hidden');
                                    if (nFeedback) nFeedback.classList.add('hidden');
                                }
                            }
                        })
                        .catch(() => {});
                }, 400);
            }
            if (livePhone) livePhone.addEventListener('input', check);
            if (liveNid) liveNid.addEventListener('input', check);
        })();

        // ==============================================================
        // 4. VOLUNTEER CROPPER LOGIC
        // ==============================================================
        (function initVolunteer() {
            let volCropper = null;
            const photoInput = document.getElementById('vol_photo-input');
            const modal = document.getElementById('vol_cropper-modal');
            const img = document.getElementById('vol_cropper-image');
            const croppedInput = document.getElementById('vol_cropped_photo');
            const previewImg = document.getElementById('vol_preview-img');
            const placeholder = document.getElementById('vol_preview-placeholder');
            const badge = document.getElementById('vol_crop-badge');

            if (photoInput) {
                photoInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    if (files && files.length > 0) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            img.src = evt.target.result;
                            modal.classList.remove('hidden');
                            if (volCropper) volCropper.destroy();
                            volCropper = new Cropper(img, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 0.9,
                            });
                        };
                        reader.readAsDataURL(files[0]);
                    }
                });

                document.getElementById('vol_crop-zoom-in')?.addEventListener('click', () => volCropper && volCropper.zoom(0.1));
                document.getElementById('vol_crop-zoom-out')?.addEventListener('click', () => volCropper && volCropper.zoom(-0.1));
                document.getElementById('vol_crop-rotate-left')?.addEventListener('click', () => volCropper && volCropper.rotate(-90));
                document.getElementById('vol_crop-reset')?.addEventListener('click', () => volCropper && volCropper.reset());

                function closeVol() {
                    modal.classList.add('hidden');
                    if (volCropper) { volCropper.destroy(); volCropper = null; }
                }
                document.getElementById('vol_cropper-close-btn')?.addEventListener('click', closeVol);
                document.getElementById('vol_crop-cancel-btn')?.addEventListener('click', closeVol);

                document.getElementById('vol_crop-confirm-btn')?.addEventListener('click', function() {
                    if (!volCropper) return;
                    const canvas = volCropper.getCroppedCanvas({ width: 300, height: 300, imageSmoothingQuality: 'high' });
                    const base64Url = canvas.toDataURL('image/jpeg', 0.92);
                    croppedInput.value = base64Url;
                    previewImg.src = base64Url;
                    previewImg.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    badge.classList.remove('hidden');
                    closeVol();
                });
            }
        })();
    </script>

</body>
</html>


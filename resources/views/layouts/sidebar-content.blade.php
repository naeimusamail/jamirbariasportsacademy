@php
    $user = Auth::user();
    $pendingAdmissionsCount = class_exists(\App\Models\AdmissionApplication::class)
        ? \App\Models\AdmissionApplication::where('status', 'pending')->count()
        : 0;
    $liveMatchesCount = class_exists(\App\Models\LiveMatch::class)
        ? \App\Models\LiveMatch::where('status', 'live')->count()
        : 0;
@endphp

<div class="flex flex-col h-full bg-slate-900/95 text-slate-100 select-none">
    <!-- 1. Top Academy Branding -->
    <div class="px-5 py-5 border-b border-slate-800 flex items-center justify-between shrink-0 bg-slate-950/40">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 p-0.5 shadow-lg shadow-emerald-900/40 shrink-0 group-hover:scale-105 transition-transform">
                <div class="w-full h-full rounded-[10px] bg-slate-950 flex items-center justify-center text-lg">
                    ⚽
                </div>
            </div>
            <div class="min-w-0">
                <h1 class="text-sm font-black text-white leading-tight truncate group-hover:text-emerald-400 transition-colors">
                    জামিরবাড়িয়া একাডেমি
                </h1>
                <p class="text-[10px] text-emerald-400/80 font-bold tracking-wide flex items-center gap-1 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    স্পোর্টস পোর্টাল ২০২৬
                </p>
            </div>
        </a>

        <!-- Mobile Drawer Close Button -->
        <button type="button" @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- 2. User Role Card -->
    <div class="px-4 py-3.5 border-b border-slate-800/80 bg-slate-950/20 shrink-0">
        <div class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-800/50 border border-slate-700/50">
            <div class="w-9 h-9 rounded-lg bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-base shrink-0">
                @if($user->isPlayer()) 🏃
                @elseif($user->isCoach()) 📋
                @elseif($user->isScorer()) 🎯
                @else 🛡️
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 truncate">
                        @if($user->isPlayer()) প্লেয়ার
                        @elseif($user->isCoach()) কোচ
                        @elseif($user->isScorer()) স্কোরার
                        @else এডমিন
                        @endif
                    </span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                </div>
                <div class="text-xs font-bold text-white truncate">{{ $user->name }}</div>
                <div class="text-[10px] text-slate-400 font-mono truncate">{{ $user->username ? '@'.$user->username : $user->email }}</div>
            </div>
        </div>
    </div>

    <!-- 3. Scrollable Categorized Navigation Links -->
    <div class="flex-1 overflow-y-auto px-3.5 py-4 space-y-5 text-xs font-medium custom-scrollbar">

        @if($user->isPlayer())
            {{-- ==================== ⚽ PLAYER NAVIGATION ==================== --}}
            <div>
                <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between">
                    <span>⚽ অ্যাথলেট ড্যাশবোর্ড</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('dashboard.player') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                            <span>মূল ড্যাশবোর্ড</span>
                        </div>
                    </a>

                    @php $myTraineeId = $user->trainee_id ?? 1; @endphp
                    <a href="{{ route('admin.id-cards.show', $myTraineeId) }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('admin.id-cards.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🪪</span>
                            <span>আমার আইডি কার্ড</span>
                        </div>
                    </a>

                    <a href="{{ route('tasks.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('tasks.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🎯</span>
                            <span>ট্রেনিং টাস্ক ও ড্রিল</span>
                        </div>
                    </a>

                    <a href="{{ route('performances.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('performances.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📈</span>
                            <span>ফিটনেস ও রেটিং</span>
                        </div>
                    </a>

                    <a href="{{ route('payments.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">💳</span>
                            <span>ফি ও রসিদ</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.certificates.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('admin.certificates.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📜</span>
                            <span>অর্জিত সনদপত্র</span>
                        </div>
                    </a>

                    <a href="{{ route('public.teams.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('public.teams.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🛡️</span>
                            <span>দল ও স্কোয়াড</span>
                        </div>
                    </a>

                    <a href="{{ route('notices.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('notices.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📢</span>
                            <span>নোটিশ বোর্ড</span>
                        </div>
                    </a>
                </div>
            </div>

        @elseif($user->isCoach())
            {{-- ==================== 📋 COACH NAVIGATION ==================== --}}
            <div>
                <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between">
                    <span>📋 কোচিং পরিচালনা</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('dashboard.coach') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                            <span>কোচ ড্যাশবোর্ড</span>
                        </div>
                    </a>

                    <a href="{{ route('tasks.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('tasks.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🎯</span>
                            <span>ড্রিল ও টাস্ক</span>
                        </div>
                    </a>

                    <a href="{{ route('trainees.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('trainees.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🏃</span>
                            <span>প্লেয়ার তালিকা</span>
                        </div>
                    </a>

                    <a href="{{ route('batches.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('batches.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📅</span>
                            <span>ব্যাচ ও শিডিউল</span>
                        </div>
                    </a>

                    <a href="{{ route('attendances.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">✓</span>
                            <span>হাজিরা গ্রহণ</span>
                        </div>
                    </a>

                    <a href="{{ route('performances.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('performances.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📈</span>
                            <span>ফিটনেস অ্যাসেসমেন্ট</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.id-cards.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('admin.id-cards.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🪪</span>
                            <span>আইডি কার্ড</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.teams.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('admin.teams.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🛡️</span>
                            <span>দল ও স্কোয়াড</span>
                        </div>
                    </a>

                    <a href="{{ route('matches.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('matches.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🔴</span>
                            <span>ম্যাচ ও স্কোরিং</span>
                        </div>
                    </a>
                </div>
            </div>

        @elseif($user->isScorer())
            {{-- ==================== 🎯 SCORER NAVIGATION ==================== --}}
            <div>
                <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between">
                    <span>🎯 স্কোরার অপারেশন</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('dashboard.scorer') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-rose-600 to-rose-700 text-white shadow-md shadow-rose-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🎯</span>
                            <span>স্কোরার ড্যাশবোর্ড</span>
                        </div>
                    </a>

                    <a href="{{ route('matches.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('matches.*') ? 'bg-gradient-to-r from-rose-600 to-rose-700 text-white shadow-md shadow-rose-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🔴</span>
                            <span>সকল ম্যাচ ও স্কোরিং</span>
                        </div>
                    </a>

                    <a href="{{ route('public.teams.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('public.teams.*') ? 'bg-gradient-to-r from-rose-600 to-rose-700 text-white shadow-md shadow-rose-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🛡️</span>
                            <span>দল ও স্কোয়াড</span>
                        </div>
                    </a>

                    <a href="{{ route('public.tournaments.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group text-slate-300 hover:bg-slate-800/80 hover:text-white">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🏆</span>
                            <span>টুর্নামেন্ট হাব</span>
                        </div>
                    </a>

                    <a href="{{ route('notices.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold transition group {{ request()->routeIs('notices.*') ? 'bg-gradient-to-r from-rose-600 to-rose-700 text-white shadow-md shadow-rose-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📢</span>
                            <span>নোটিশ বোর্ড</span>
                        </div>
                    </a>
                </div>
            </div>

        @else
            {{-- ==================== 🛡️ ADMIN NAVIGATION (CATEGORIZED) ==================== --}}
            
            <!-- Category 1: মনিটরিং ও ওভারভিউ -->
            <div>
                <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between">
                    <span>📊 ওভারভিউ ও মনিটরিং</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                            <span>মূল ড্যাশবোর্ড</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.admissions.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.admissions.*') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md shadow-amber-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📋</span>
                            <span>ভর্তি আবেদন</span>
                        </div>
                        @if($pendingAdmissionsCount > 0)
                            <span class="text-[10px] font-black px-1.5 py-0.5 rounded-full bg-amber-400 text-slate-950 animate-pulse">
                                {{ $pendingAdmissionsCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.circulars.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.circulars.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📅</span>
                            <span>সার্কুলার ও সময়সূচি</span>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Start/Stop</span>
                    </a>

                    <a href="{{ route('attendances.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">✓</span>
                            <span>দৈনিক হাজিরা</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Category 2: প্লেয়ার ও অ্যাথলেট হাব -->
            <div>
                <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between border-t border-slate-800/80 pt-3">
                    <span>👥 প্লেয়ার ও ট্রেনিং</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.players.search') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.players.search') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🔍</span>
                            <span>সার্বজনীন প্লেয়ার সার্চ</span>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">ID / মেইল</span>
                    </a>

                    <a href="{{ route('admin.duplicate-audit.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.duplicate-audit.*') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md shadow-amber-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🛡️</span>
                            <span>ডুপ্লিকেট ডক অডিট</span>
                        </div>
                    </a>

                    <a href="{{ route('trainees.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('trainees.index') || request()->routeIs('trainees.show') || request()->routeIs('trainees.edit') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🏃</span>
                            <span>প্লেয়ার তালিকা</span>
                        </div>
                    </a>

                    <a href="{{ route('tasks.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('tasks.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🎯</span>
                            <span>ড্রিল ও টাস্ক</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.id-cards.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.id-cards.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🪪</span>
                            <span>ডিজিটাল আইডি কার্ড</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.certificates.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.certificates.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📜</span>
                            <span>সনদপত্র সেন্টার</span>
                        </div>
                    </a>

                    <a href="{{ route('performances.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('performances.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📈</span>
                            <span>ফিটনেস ও রেটিং</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Category 3: টুর্নামেন্ট, ক্লাব ও ম্যাচ -->
            <div>
                <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between border-t border-slate-800/80 pt-3">
                    <span>🏆 ক্লাব ও টুর্নামেন্ট</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.teams.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.teams.*') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md shadow-amber-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🛡️</span>
                            <span>ক্লাব ও দল</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.tournaments.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.tournaments.*') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md shadow-amber-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🏆</span>
                            <span>টুর্নামেন্ট ও শিডিউল</span>
                        </div>
                    </a>

                    <a href="{{ route('matches.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('matches.*') ? 'bg-gradient-to-r from-rose-600 to-rose-500 text-white shadow-md shadow-rose-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🔴</span>
                            <span>ম্যাচ ও লাইভ স্কোর</span>
                        </div>
                        @if($liveMatchesCount > 0)
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-rose-500 text-white animate-pulse">
                                {{ $liveMatchesCount }} LIVE
                            </span>
                        @endif
                    <a href="{{ route('admin.volunteers.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.volunteers.*') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md shadow-amber-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">🤝</span>
                            <span>ভলান্টিয়ার হাব</span>
                        </div>
                        @php
                            $pendingVolunteersCount = class_exists(\App\Models\Volunteer::class) ? \App\Models\Volunteer::where('status', 'pending')->count() : 0;
                        @endphp
                        @if($pendingVolunteersCount > 0)
                            <span class="text-[10px] font-black px-1.5 py-0.5 rounded-full bg-amber-400 text-slate-950 animate-pulse">
                                {{ $pendingVolunteersCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Category 4: একাডেমি অপারেশন ও ফাইন্যান্স -->
            <div>
                <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between border-t border-slate-800/80 pt-3">
                    <span>💰 পরিচালনা ও হিসাব</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('batches.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('batches.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📅</span>
                            <span>ব্যাচ ও শিডিউল</span>
                        </div>
                    </a>

                    <a href="{{ route('coaches.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('coaches.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📋</span>
                            <span>কোচিং স্টাফ</span>
                        </div>
                    </a>

                    <a href="{{ route('payments.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('payments.index') || request()->routeIs('payments.create') || request()->routeIs('payments.show') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">💳</span>
                            <span>ফি কালেকশন</span>
                        </div>
                    </a>

                    <a href="{{ route('payments.defaulters') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('payments.defaulters') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md shadow-amber-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">⚠️</span>
                            <span>বকেয়া ফি তালিকা</span>
                        </div>
                    </a>

                    <a href="{{ route('reports.financial') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('reports.financial') ? 'bg-gradient-to-r from-teal-600 to-emerald-600 text-white shadow-md shadow-teal-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                            <span>ক্যাশ বুক ও P&L</span>
                        </div>
                    </a>

                    <a href="{{ route('expenses.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('expenses.*') ? 'bg-gradient-to-r from-rose-600 to-rose-500 text-white shadow-md shadow-rose-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">💸</span>
                            <span>ব্যয় ভাউচার ও হিসাব</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.sms.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.sms.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📲</span>
                            <span>বাল্ক SMS হাব</span>
                        </div>
                    </a>

                    <a href="{{ route('notices.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('notices.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">📢</span>
                            <span>নোটিশ বোর্ড</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.backup.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl font-semibold transition group {{ request()->routeIs('admin.backup.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md shadow-indigo-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base group-hover:scale-110 transition-transform">💾</span>
                            <span>ডাটাবেজ ব্যাকআপ</span>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        <!-- Quick Public Links For All Roles -->
        <div class="border-t border-slate-800/80 pt-3 space-y-1">
            <div class="px-3 pb-1.5 text-[10px] font-black uppercase tracking-wider text-slate-500">
                🌐 পাবলিক পোর্টাল
            </div>
            
            <a href="{{ route('public.tournaments.index') }}" target="_blank"
               class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-amber-400/90 hover:bg-amber-500/10 hover:text-amber-300 transition group">
                <div class="flex items-center gap-2.5">
                    <span class="text-base group-hover:scale-110 transition-transform">🏆</span>
                    <span>টুর্নামেন্ট হাব</span>
                </div>
                <span class="text-[10px] font-mono">↗</span>
            </a>

            <a href="{{ route('live.index') }}" target="_blank"
               class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-rose-400/90 hover:bg-rose-500/10 hover:text-rose-300 transition group">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                    <span>লাইভ স্কোরবোর্ড</span>
                </div>
                <span class="text-[10px] font-mono">↗</span>
            </a>

            <a href="{{ route('rules') }}" target="_blank"
               class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-slate-400 hover:bg-slate-800/60 hover:text-emerald-400 transition group">
                <div class="flex items-center gap-2.5">
                    <span class="text-base group-hover:scale-110 transition-transform">📜</span>
                    <span>একাডেমি রুলস ও টার্মস</span>
                </div>
                <span class="text-[10px] font-mono">↗</span>
            </a>
        </div>
    </div>

    <!-- 4. Bottom Footer with Quick Logout -->
    <div class="p-3.5 border-t border-slate-800 bg-slate-950/60 shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-slate-800 hover:bg-rose-950/60 hover:text-rose-300 border border-slate-700 hover:border-rose-800/60 text-xs font-bold text-slate-300 transition">
                <span>🚪</span>
                <span>লগ আউট (Sign Out)</span>
            </button>
        </form>
    </div>
</div>


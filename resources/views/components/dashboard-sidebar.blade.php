@props([
    'role' => 'admin',
    'activeCategory' => 'all'
])

@php
    $user = Auth::user();
@endphp

<aside class="w-full lg:w-72 shrink-0">
    <!-- Category Sidebar Container with Sticky Positioning & Glassmorphism -->
    <div class="sticky top-6 space-y-4">

        <!-- User Role Profile Glass Card -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 via-slate-800/80 to-slate-900/90 p-5 border border-slate-700/60 shadow-xl backdrop-blur-md">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="flex items-center gap-3.5 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 p-0.5 shadow-lg shadow-emerald-900/40 shrink-0">
                    <div class="w-full h-full rounded-[10px] bg-slate-950 flex items-center justify-center text-lg font-black text-emerald-400">
                        @if($role === 'admin') 🛡️
                        @elseif($role === 'player') ⚽
                        @elseif($role === 'coach') 📋
                        @elseif($role === 'scorer') 🎯
                        @else 👤
                        @endif
                    </div>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1.5">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                            @if($role === 'admin') এডমিন কন্ট্রোল
                            @elseif($role === 'player') অ্যাথলেট প্রোফাইল
                            @elseif($role === 'coach') কোচ প্যানেল
                            @elseif($role === 'scorer') অফিসিয়াল স্কোরার
                            @endif
                        </span>
                    </div>
                    <h3 class="text-sm font-black text-white truncate mt-0.5">{{ $user->name }}</h3>
                    <p class="text-[11px] text-slate-400 truncate font-mono">{{ $user->username ?? $user->email }}</p>
                </div>
            </div>

            <!-- Quick Academy Status -->
            <div class="mt-4 pt-3 border-t border-slate-700/50 flex items-center justify-between text-[11px] text-slate-300">
                <span class="flex items-center gap-1">
                    <span>🏛️</span> একাডেমি সেশন ২০২৬
                </span>
                <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold border border-emerald-500/30">
                    সক্রিয়
                </span>
            </div>
        </div>

        <!-- Sidebar Navigation Sections / Categories -->
        <div class="rounded-2xl bg-slate-900/80 p-3.5 border border-slate-800 shadow-xl backdrop-blur-md space-y-5">

            @if($role === 'admin')
                <!-- ADMIN CATEGORIES -->
                
                <!-- Category 1: সাধারণ ও মনিটরিং -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between">
                        <span>📊 ওভারভিউ ও মনিটরিং</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('dashboard') && !request()->has('filter') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                                <span>মূল ড্যাশবোর্ড</span>
                            </div>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ request()->routeIs('dashboard') ? 'bg-black/30 text-white' : 'bg-slate-800 text-slate-400' }}">হোম</span>
                        </a>

                        <a href="{{ route('admin.admissions.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('admin.admissions.*') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md shadow-amber-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📋</span>
                                <span>ভর্তি আবেদনসমূহ</span>
                            </div>
                            @php 
                                $pendingCount = class_exists(\App\Models\AdmissionApplication::class) 
                                    ? \App\Models\AdmissionApplication::where('status', 'pending')->count() 
                                    : 0; 
                            @endphp
                            @if($pendingCount > 0)
                                <span class="text-[10px] font-black px-1.5 py-0.5 rounded-full bg-amber-400 text-slate-950 animate-pulse">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('attendances.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">✓</span>
                                <span>দৈনিক হাজিরা রেজিস্টার</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Category 2: প্লেয়ার ও ট্রেইনি ব্যবস্থাপনা -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between border-t border-slate-800/80 pt-3">
                        <span>👥 শিক্ষার্থী ও প্লেয়ার</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('trainees.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('trainees.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🏃</span>
                                <span>ট্রেইনি ও অ্যাথলেট তালিকা</span>
                            </div>
                            <span class="text-[10px] font-mono text-slate-400">{{ \App\Models\Trainee::count() }}</span>
                        </a>

                        <a href="{{ route('trainees.create') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:bg-slate-800/80 hover:text-emerald-400 transition-all duration-200 group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">➕</span>
                                <span>নতুন ট্রেইনি ভর্তি ফর্ম</span>
                            </div>
                        </a>

                        <a href="{{ route('admin.id-cards.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('admin.id-cards.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🪪</span>
                                <span>ডিজিটাল আইডি কার্ড হাব</span>
                            </div>
                        </a>

                        <a href="{{ route('admin.certificates.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('admin.certificates.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📜</span>
                                <span>সনদপত্র ইস্যু ও যাচাই</span>
                            </div>
                        </a>

                        <a href="{{ route('performances.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('performances.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📈</span>
                                <span>ফিটনেস ও পারফরম্যান্স</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Category 3: ক্লাব, টিম ও টুর্নামেন্ট -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between border-t border-slate-800/80 pt-3">
                        <span>🏆 ক্লাব ও টুর্নামেন্ট হাব</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('admin.teams.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('admin.teams.*') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🛡️</span>
                                <span>ক্লাব রেজিস্ট্রেশন ও দল</span>
                            </div>
                            <span class="text-[10px] font-mono {{ request()->routeIs('admin.teams.*') ? 'text-slate-900' : 'text-slate-400' }}">{{ \App\Models\Team::count() }}</span>
                        </a>

                        <a href="{{ route('admin.tournaments.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('admin.tournaments.*') ? 'bg-gradient-to-r from-amber-600 to-amber-500 text-slate-950 font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🏆</span>
                                <span>টুর্নামেন্ট ও অটো শিডিউল</span>
                            </div>
                            <span class="text-[10px] font-mono {{ request()->routeIs('admin.tournaments.*') ? 'text-slate-900' : 'text-slate-400' }}">{{ \App\Models\Tournament::count() }}</span>
                        </a>

                        <a href="{{ route('matches.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('matches.*') ? 'bg-gradient-to-r from-rose-600 to-rose-500 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🔴</span>
                                <span>ম্যাচ ও লাইভ স্কোরবোর্ড</span>
                            </div>
                            @php 
                                $liveMatchesCount = class_exists(\App\Models\LiveMatch::class) 
                                    ? \App\Models\LiveMatch::where('status', 'live')->count() 
                                    : 0; 
                            @endphp
                            @if($liveMatchesCount > 0)
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-rose-500 text-white animate-pulse">
                                    {{ $liveMatchesCount }} LIVE
                                </span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Category 4: একাডেমি অপারেশন ও অ্যাকাউন্টিং -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between border-t border-slate-800/80 pt-3">
                        <span>💰 অর্থ ও পরিচালনা</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('batches.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('batches.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📅</span>
                                <span>ব্যাচ ও সময়সূচি</span>
                            </div>
                        </a>

                        <a href="{{ route('coaches.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('coaches.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📋</span>
                                <span>কোচিং স্টাফ ও দায়িত্ব</span>
                            </div>
                        </a>

                        <a href="{{ route('tasks.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('tasks.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🎯</span>
                                <span>ট্রেনিং ড্রিল ও টাস্ক</span>
                            </div>
                        </a>

                        <a href="{{ route('payments.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">💳</span>
                                <span>ফি আদায় ও পেমেন্ট</span>
                            </div>
                        </a>

                        <a href="{{ route('expenses.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('expenses.*') ? 'bg-gradient-to-r from-rose-600 to-rose-500 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">💸</span>
                                <span>ব্যয় ভাউচার ও লেজার</span>
                            </div>
                        </a>

                        <a href="{{ route('notices.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('notices.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📢</span>
                                <span>নোটিশ বোর্ড</span>
                            </div>
                        </a>
                    </div>
                </div>

            @elseif($role === 'player')
                <!-- PLAYER CATEGORIES -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between">
                        <span>⚽ আমার অ্যাথলেট হাব</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('dashboard.player') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                                <span>প্লেয়ার ড্যাশবোর্ড</span>
                            </div>
                        </a>

                        @php $myTraineeId = Auth::user()->trainee_id ?? (isset($trainee) ? $trainee->id : null); @endphp
                        @if($myTraineeId)
                            <a href="{{ route('admin.id-cards.show', $myTraineeId) }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('admin.id-cards.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-base group-hover:scale-110 transition-transform">🪪</span>
                                    <span>আমার ডিজিটাল আইডি</span>
                                </div>
                            </a>
                        @endif

                        <a href="{{ route('tasks.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('tasks.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🎯</span>
                                <span>কোচ প্রদত্ত ড্রিল ও টাস্ক</span>
                            </div>
                        </a>

                        <a href="{{ route('performances.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('performances.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📈</span>
                                <span>ফিটনেস ও রেটিং রেকর্ড</span>
                            </div>
                        </a>

                        <a href="{{ route('payments.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">💳</span>
                                <span>ফি পরিশোধ ও রসিদ</span>
                            </div>
                        </a>

                        <a href="{{ route('admin.certificates.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('admin.certificates.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📜</span>
                                <span>অর্জিত সনদপত্র</span>
                            </div>
                        </a>

                        <a href="{{ route('public.tournaments.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group text-slate-300 hover:bg-slate-800/80 hover:text-white">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🏆</span>
                                <span>টুর্নামেন্ট রেজিস্ট্রেশন হাব</span>
                            </div>
                            <span class="text-[10px] text-amber-400 font-bold">লাইভ</span>
                        </a>

                        <a href="{{ route('live.index') }}" target="_blank"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group text-rose-300 hover:bg-rose-950/40 hover:text-rose-200">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                <span>ম্যাচ সেন্টার ও লাইভ স্কোর</span>
                            </div>
                            <span class="text-[10px] font-bold">↗</span>
                        </a>
                    </div>
                </div>

            @elseif($role === 'coach')
                <!-- COACH CATEGORIES -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between">
                        <span>📋 কোচিং পরিচালনা</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('dashboard.coach') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                                <span>কোচ ড্যাশবোর্ড</span>
                            </div>
                        </a>

                        <a href="{{ route('tasks.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('tasks.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🎯</span>
                                <span>ড্রিল ও ট্রেনিং অ্যাসাইনমেন্ট</span>
                            </div>
                        </a>

                        <a href="{{ route('trainees.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('trainees.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🏃</span>
                                <span>প্লেয়ার ও স্কোয়াড তালিকা</span>
                            </div>
                        </a>

                        <a href="{{ route('batches.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('batches.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📅</span>
                                <span>আমার ব্যাচ ও শিডিউল</span>
                            </div>
                        </a>

                        <a href="{{ route('attendances.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">✓</span>
                                <span>আজকের হাজিরা গ্রহণ</span>
                            </div>
                        </a>

                        <a href="{{ route('performances.create') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('performances.create') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">📈</span>
                                <span>ফিটনেস মূল্যায়ন প্রদান</span>
                            </div>
                        </a>

                        <a href="{{ route('matches.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group text-slate-300 hover:bg-slate-800/80 hover:text-white">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🔴</span>
                                <span>ম্যাচ ও লাইভ ফলাফল</span>
                            </div>
                        </a>
                    </div>
                </div>

            @elseif($role === 'scorer')
                <!-- SCORER CATEGORIES -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400 flex items-center justify-between">
                        <span>🎯 স্কোরার অপারেশন হাব</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('dashboard.scorer') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-rose-600 to-rose-700 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🎯</span>
                                <span>স্কোরার ড্যাশবোর্ড</span>
                            </div>
                        </a>

                        <a href="{{ route('matches.index') }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group {{ request()->routeIs('matches.*') ? 'bg-gradient-to-r from-rose-600 to-rose-700 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🔴</span>
                                <span>আমার সকল নির্ধারিত ম্যাচ</span>
                            </div>
                        </a>

                        <a href="{{ route('public.tournaments.index') }}" target="_blank"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group text-slate-300 hover:bg-slate-800/80 hover:text-white">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base group-hover:scale-110 transition-transform">🏆</span>
                                <span>টুর্নামেন্ট ফিক্সচার হাব</span>
                            </div>
                            <span class="text-[10px] font-bold">↗</span>
                        </a>

                        <a href="{{ route('live.index') }}" target="_blank"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 group text-rose-300 hover:bg-rose-950/40 hover:text-rose-200">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                <span>পাবলিক লাইভ সম্প্রচার</span>
                            </div>
                            <span class="text-[10px] font-bold">↗</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Quick Academy Rules / Help link for everyone -->
            <div class="pt-3 border-t border-slate-800/80">
                <a href="{{ route('rules') }}" target="_blank" 
                   class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-slate-400 hover:bg-slate-800/50 hover:text-emerald-400 transition-colors group">
                    <span class="flex items-center gap-2">
                        <span>📜</span> একাডেমি রুলস ও টার্মস
                    </span>
                    <span class="text-[10px] text-slate-500 group-hover:text-emerald-400 transition-colors">↗</span>
                </a>
            </div>

        </div>

        <!-- Academi Direct Hotline Mini Box -->
        <div class="p-3.5 rounded-2xl bg-gradient-to-br from-emerald-950/40 to-slate-900/60 border border-emerald-500/20 text-slate-300 text-xs">
            <div class="flex items-center gap-2 text-emerald-400 font-bold text-[11px] mb-1">
                <span>⚡</span> কুইক সাপোর্ট ও রিপোর্ট
            </div>
            <p class="text-[11px] text-slate-400 leading-relaxed">
                জামিরবাড়িয়া স্পোর্টস একাডেমি ডিজিটাল সিস্টেমে কোনো তথ্য বা কারিগরি সমস্যার সম্মুখীন হলে প্রধান পরিচালকের সাথে যোগাযোগ করুন।
            </p>
        </div>

    </div>
</aside>

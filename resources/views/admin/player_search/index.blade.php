<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-white flex items-center gap-2.5">
                    <span>🔍</span> প্লেয়ার সার্বজনীন সার্চ হাব (Universal Player Search)
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    যেকোনো খেলোয়াড়কে আইডি নং, নাম, ইউজারনেম, ইমেইল, মোবাইল বা NID/জন্মনিবন্ধন নম্বর দিয়ে এক ক্লিকে খুঁজুন।
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.duplicate-audit.index') }}"
                   class="px-4 py-2 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 font-bold text-xs flex items-center gap-2 transition shadow-sm">
                    <span>🛡️</span>
                    <span>ডুপ্লিকেট ডকুমেন্ট অডিট</span>
                </a>
                <a href="{{ route('trainees.create') }}"
                   class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-1.5 transition shadow-lg shadow-emerald-950/40">
                    <span>+</span>
                    <span>নতুন ট্রেইনি</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. Search Box Component -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 sm:p-7 shadow-xl">
                <form action="{{ route('admin.players.search') }}" method="GET" class="relative">
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-slate-400 text-lg">🔍</span>
                        <input type="text" name="q" id="universal_search_input" value="{{ $term }}"
                               placeholder="আইডি নং (যেমন: JSA-2026-001), নাম, @ইউজারনেম, ইমেইল, মোবাইল বা NID লিখে এন্টার দিন..."
                               autofocus
                               class="w-full pl-12 pr-28 py-4 rounded-2xl bg-slate-950 border border-slate-700/80 text-white text-sm sm:text-base focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-500 shadow-inner">
                        <button type="submit"
                                class="absolute right-2 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center gap-1.5">
                            <span>অনুসন্ধান</span>
                            <span>&rarr;</span>
                        </button>
                    </div>

                    <!-- Search Suggestions / Quick Filters -->
                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                        <span class="font-semibold text-slate-500">দ্রুত ফিল্টার:</span>
                        <a href="{{ route('admin.players.search', ['q' => 'Senior']) }}" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 transition">সিনিয়র</a>
                        <a href="{{ route('admin.players.search', ['q' => 'U-16']) }}" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 transition">U-16</a>
                        <a href="{{ route('admin.players.search', ['q' => 'U-14']) }}" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 transition">U-14</a>
                        <a href="{{ route('admin.players.search', ['q' => 'JSA-LOC']) }}" class="px-2.5 py-1 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 transition">লোকাল ড্রাফট প্লেয়ার</a>
                        @if(!empty($term))
                            <a href="{{ route('admin.players.search') }}" class="ml-auto text-rose-400 hover:text-rose-300 font-semibold transition">&times; সার্চ ফিল্টার ক্লিয়ার করুন</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- 2. Search Status / Results Header -->
            <div class="flex items-center justify-between">
                <div class="text-xs sm:text-sm text-slate-300 font-semibold flex items-center gap-2">
                    <span>📊 প্রাপ্ত ফলাফল:</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">
                        {{ $players->total() }} জন খেলোয়াড়
                    </span>
                    @if(!empty($term))
                        <span class="text-slate-500">• কীওয়ার্ড: "<span class="text-white font-mono">{{ $term }}</span>"</span>
                    @endif
                </div>
            </div>

            <!-- 3. Players Result Grid -->
            @if($players->isEmpty())
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-12 text-center">
                    <div class="w-16 h-16 rounded-3xl bg-slate-800 flex items-center justify-center text-3xl mx-auto mb-4 text-slate-500">
                        🔍
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1">কোনো খেলোয়াড় খুঁজে পাওয়া যায়নি</h3>
                    <p class="text-xs text-slate-400 max-w-md mx-auto">
                        আইডি নাম্বার, নাম, মোবাইল বা ইমেইল সঠিক বানানে লিখেছেন কিনা পুনরায় যাচাই করুন।
                    </p>
                    <div class="mt-6 flex justify-center gap-3">
                        <a href="{{ route('admin.players.search') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition">
                            সকল খেলোয়াড় দেখুন
                        </a>
                        <a href="{{ route('trainees.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold transition">
                            + নতুন এন্ট্রি দিন
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($players as $pl)
                        <div class="bg-slate-900/90 border border-slate-800 hover:border-slate-700/80 rounded-3xl p-5 shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 flex flex-col justify-between group">
                            <div>
                                <!-- Card Header: Avatar & Admission ID -->
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-800 border-2 border-slate-700 flex items-center justify-center overflow-hidden shrink-0 shadow-md">
                                            @if($pl->photo)
                                                <img src="{{ asset('storage/' . $pl->photo) }}" alt="{{ $pl->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-black text-slate-400">👤</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-black text-white text-base truncate group-hover:text-emerald-400 transition-colors">
                                                {{ $pl->name }}
                                            </h4>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-md bg-slate-800 text-amber-400 border border-slate-700">
                                                    {{ $pl->admission_no }}
                                                </span>
                                                @if($pl->isLocal())
                                                    <span class="text-[9px] font-black uppercase px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                                        লোকাল ড্রাফট
                                                    </span>
                                                @else
                                                    <span class="text-[9px] font-black uppercase px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                                        একাডেমিক
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $pl->status === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                        {{ $pl->status === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                    </span>
                                </div>

                                <!-- Linked Account User / Email / Username -->
                                @if($pl->user)
                                    <div class="p-2.5 rounded-xl bg-slate-950/60 border border-slate-800/80 text-[11px] mb-3 flex items-center justify-between">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="text-emerald-400">🔑</span>
                                            <span class="font-mono text-white font-bold truncate">{{ $pl->user->username ? '@'.$pl->user->username : $pl->user->name }}</span>
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-mono truncate max-w-[140px]">{{ $pl->user->email }}</span>
                                    </div>
                                @endif

                                <!-- Details List -->
                                <div class="space-y-1.5 text-xs text-slate-300 border-t border-slate-800/80 pt-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500">খেলা ও রোল:</span>
                                        <span class="font-semibold text-white truncate max-w-[170px]">
                                            {{ $pl->sport_names ?? 'N/A' }} {{ $pl->position ? '• '.$pl->position : '' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500">মোবাইল নম্বর:</span>
                                        <a href="tel:{{ $pl->phone }}" class="font-mono font-bold text-amber-400 hover:underline">
                                            {{ $pl->phone }}
                                        </a>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500">NID / জন্মসনদ:</span>
                                        <span class="font-mono text-slate-300 {{ empty($pl->nid_or_birth_cert) ? 'text-slate-500' : '' }}">
                                            {{ $pl->nid_or_birth_cert ?? 'দেওয়া হয়নি' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500">ক্যাটাগরি / বয়স:</span>
                                        <span class="font-semibold text-white">
                                            {{ $pl->category }} • {{ $pl->blood_group ?? 'রক্ত N/A' }}
                                        </span>
                                    </div>
                                    @if($pl->jersey_no)
                                        <div class="flex items-center justify-between">
                                            <span class="text-slate-500">জার্সি নম্বর:</span>
                                            <span class="font-mono font-bold text-white">#{{ $pl->jersey_no }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 pt-3 border-t border-slate-800 grid grid-cols-2 gap-2">
                                <a href="{{ route('admin.id-cards.show', $pl->id) }}"
                                   class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold text-center transition flex items-center justify-center gap-1">
                                    <span>🪪</span>
                                    <span>আইডি কার্ড</span>
                                </a>
                                <a href="{{ route('trainees.show', $pl->id) }}"
                                   class="px-3 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold text-center transition flex items-center justify-center gap-1">
                                    <span>👤</span>
                                    <span>প্রোফাইল</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pt-4">
                    {{ $players->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>


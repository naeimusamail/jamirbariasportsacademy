<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>🛡️</span> {{ __('ক্লাব ও টিম রেজিস্ট্রেশন ব্যবস্থাপনা (Club & Team Registration)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    একাডেমির অনুমোদিত সকল ক্লাব ও টিম রেজিস্ট্রেশন, স্কোয়াড পরিচালনা ও প্লেয়ার তালিকা ব্যবস্থাপনা
                </p>
            </div>
            <a href="{{ route('admin.teams.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-600/20 flex items-center gap-2 transition">
                <span>➕ নতুন ক্লাব / টিম রেজিস্ট্রেশন করুন</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Filter & Search Toolbar -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('admin.teams.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                        <select name="sport_id" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500">
                            <option value="">সকল খেলা (All Sports)</option>
                            @foreach($sports as $sp)
                                <option value="{{ $sp->id }}" {{ request('sport_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 w-full sm:w-80">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="টিমের নাম বা কোচ দিয়ে খুঁজুন..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500">
                        <button type="submit" class="px-4 py-2 bg-gray-900 dark:bg-gray-700 hover:bg-gray-800 text-white rounded-xl text-xs font-semibold">খুঁজুন</button>
                    </div>
                </form>
            </div>

            <!-- Teams Grid -->
            @if($teams->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($teams as $team)
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-slate-950 font-black text-xl shadow overflow-hidden shrink-0">
                                            @if($team->logo)
                                                <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ $team->short_name ? substr($team->short_name, 0, 3) : 'JSA' }}
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-black text-base text-gray-900 dark:text-white">{{ $team->name }}</h3>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">{{ $team->short_name }}</span>
                                                <span class="text-gray-400">•</span>
                                                <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ $team->category }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $team->status === 'active' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $team->status === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-3 py-3 border-y border-gray-100 dark:border-gray-700 text-xs mb-4">
                                    <div>
                                        <span class="text-gray-400 block text-[11px]">খেলার ধরন:</span>
                                        <span class="font-bold text-gray-800 dark:text-gray-200">
                                            {{ $team->sport->name ?? ucfirst($team->sport_type) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400 block text-[11px]">স্কোয়াড মেম্বার:</span>
                                        <span class="font-bold text-emerald-600 dark:text-emerald-400 font-mono text-sm">
                                            👥 {{ $team->players_count }} জন প্লেয়ার
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400 block text-[11px]">অধিনায়ক (Captain):</span>
                                        <span class="font-medium text-gray-800 dark:text-gray-200">
                                            {{ $team->captain_name ?? 'নির্ধারণ করা হয়নি' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400 block text-[11px]">প্রধান কোচ:</span>
                                        <span class="font-medium text-gray-800 dark:text-gray-200">
                                            {{ $team->coach_name ?? 'একাডেমি কোচ' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Match Performance Record -->
                                <div class="flex items-center justify-between p-3 rounded-2xl bg-gray-50 dark:bg-gray-900/50 text-xs mb-4">
                                    <div class="text-center">
                                        <span class="text-[10px] text-gray-400 block">ম্যাচ</span>
                                        <span class="font-bold font-mono text-gray-800 dark:text-gray-200">{{ $team->matches_played }}</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-[10px] text-emerald-500 block">জয়</span>
                                        <span class="font-bold font-mono text-emerald-600 dark:text-emerald-400">{{ $team->matches_won }}</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-[10px] text-rose-500 block">হার</span>
                                        <span class="font-bold font-mono text-rose-600 dark:text-rose-400">{{ $team->matches_lost }}</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-[10px] text-amber-500 block">ড্র/টাই</span>
                                        <span class="font-bold font-mono text-amber-600 dark:text-amber-400">{{ $team->matches_drawn }}</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-[10px] text-blue-500 block">পয়েন্ট</span>
                                        <span class="font-bold font-mono text-blue-600 dark:text-blue-400">{{ $team->points }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-2">
                                <a href="{{ route('admin.teams.show', $team) }}" class="px-4 py-2 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                                    <span>👥 স্কোয়াড পরিচালনা</span> ➔
                                </a>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.teams.edit', $team) }}" class="p-2 text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-lg transition" title="এডিট করুন">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই টিমটি ডিলিট করতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 transition" title="মুছে ফেলুন">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4">
                    {{ $teams->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700">
                    <span class="text-5xl block mb-3">🛡️</span>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">কোনো টিম পাওয়া যায়নি</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 max-w-sm mx-auto mb-6">
                        একাডেমির দল তৈরি করুন এবং ক্রিকইনফো স্টাইল স্কোর ও প্লেয়ার পারফরম্যান্স ট্র্যাকিং শুরু করুন।
                    </p>
                    <a href="{{ route('admin.teams.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow transition">
                        ➕ প্রথম টিম তৈরি করুন
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>


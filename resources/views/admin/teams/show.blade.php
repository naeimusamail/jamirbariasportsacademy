<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-slate-950 font-black text-2xl shadow overflow-hidden shrink-0">
                    @if($team->logo)
                        <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover">
                    @else
                        {{ $team->short_name ? substr($team->short_name, 0, 3) : 'JSA' }}
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                            {{ $team->name }}
                        </h2>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                            {{ $team->category }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ $team->sport->name ?? ucfirst($team->sport_type) }} • কোড: <span class="font-mono font-bold">{{ $team->short_name }}</span> • স্কোয়াড: <span class="font-bold text-emerald-600">{{ $team->players->count() }} জন</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('public.teams.show', $team->slug) }}" target="_blank" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shadow transition flex items-center gap-1.5">
                    <span>🌐 পাবলিক ভিউ</span> ↗
                </a>
                <a href="{{ route('admin.teams.edit', $team) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold transition">
                    ✏️ এডিট টিম
                </a>
                <a href="{{ route('admin.teams.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold transition">
                    &larr; টিম তালিকা
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 rounded-xl bg-sky-500/10 border border-sky-500/30 text-sky-600 dark:text-sky-400 text-sm font-semibold">
                    ℹ {{ session('info') }}
                </div>
            @endif

            <!-- Team Stats Banner -->
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                    <span class="text-xs text-gray-400 block mb-1">মোট ম্যাচ</span>
                    <span class="font-black text-2xl text-gray-900 dark:text-white font-mono">{{ $team->matches_played }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                    <span class="text-xs text-emerald-500 block mb-1">জয় (Wins)</span>
                    <span class="font-black text-2xl text-emerald-600 dark:text-emerald-400 font-mono">{{ $team->matches_won }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                    <span class="text-xs text-rose-500 block mb-1">পরাজয় (Losses)</span>
                    <span class="font-black text-2xl text-rose-600 dark:text-rose-400 font-mono">{{ $team->matches_lost }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                    <span class="text-xs text-amber-500 block mb-1">ড্র / টাই</span>
                    <span class="font-black text-2xl text-amber-600 dark:text-amber-400 font-mono">{{ $team->matches_drawn }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center col-span-2 sm:col-span-1">
                    <span class="text-xs text-blue-500 block mb-1">মোট পয়েন্ট</span>
                    <span class="font-black text-2xl text-blue-600 dark:text-blue-400 font-mono">{{ $team->points }}</span>
                </div>
            </div>

            <!-- Add Player to Squad & Squad Table -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Add Player Panel (1 col) -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 h-fit">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-lg">➕</span>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">স্কোয়াডে নতুন প্লেয়ার যুক্ত করুন</h3>
                    </div>

                    <form action="{{ route('admin.teams.add-player', $team) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">নিবন্ধিত প্লেয়ার থেকে নির্বাচন (একাডেমিক ও লোকাল)</label>
                            <select name="trainee_id" id="trainee_select" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                <option value="">-- প্লেয়ার নির্বাচন করুন (একাডেমিক / লোকাল) --</option>
                                @foreach($trainees as $tr)
                                    <option value="{{ $tr->id }}" data-name="{{ $tr->name }}" data-jersey="{{ $tr->jersey_no }}" data-position="{{ $tr->position }}">
                                        {{ $tr->isLocal() ? '🏆 [লোকাল] ' : '🎓 [একাডেমি] ' }}{{ $tr->name }} ({{ $tr->admission_no }} - {{ $tr->position ?? 'প্লেয়ার' }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-gray-400 mt-1">বা অতিথি/গেস্ট প্লেয়ারের জন্য নিচে সরাসরি নাম লিখুন:</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">প্লেয়ারের পূর্ণ নাম *</label>
                            <input type="text" name="name" id="player_name_input" placeholder="যেমন: তামিম ইকবাল" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">জার্সি নম্বর</label>
                                <input type="text" name="jersey_no" id="player_jersey_input" placeholder="যেমন: 7 বা 18" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-mono">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">প্লেয়ারের ভূমিকা / রোল *</label>
                                <select name="role" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                    <optgroup label="ক্রিকেট রোল">
                                        <option value="Top-order Batter">টপ-অর্ডার ব্যাটসম্যান (Batter)</option>
                                        <option value="Middle-order Batter">মিডল-অর্ডার ব্যাটসম্যান</option>
                                        <option value="Wicketkeeper-Batter">উইকেটকিপার-ব্যাটসম্যান (WK)</option>
                                        <option value="All-Rounder" selected>অল-রাউন্ডার (All-Rounder)</option>
                                        <option value="Fast Bowler">পেস বোলার (Fast Bowler)</option>
                                        <option value="Spin Bowler">স্পিন বোলার (Spin Bowler)</option>
                                    </optgroup>
                                    <optgroup label="ফুটবল রোল">
                                        <option value="Goalkeeper">গোলরক্ষক (GK)</option>
                                        <option value="Defender">ডিফেন্ডার (CB/FB)</option>
                                        <option value="Midfielder">মিডফিল্ডার (MF)</option>
                                        <option value="Striker">স্ট্রাইকার / ফরোয়ার্ড (FW)</option>
                                    </optgroup>
                                    <optgroup label="ব্যাডমিন্টন রোল">
                                        <option value="Singles Specialist">সিঙ্গেলস প্লেয়ার (Singles)</option>
                                        <option value="Doubles Specialist">ডাবলস প্লেয়ার (Doubles)</option>
                                        <option value="Mixed Doubles">মিক্সড ডাবলস (Mixed)</option>
                                    </optgroup>
                                    <optgroup label="অ্যাথলেটিক্স ও অন্যান্য">
                                        <option value="Sprinter (100m/200m)">স্প্রিন্টার (Sprinter)</option>
                                        <option value="Middle-distance Runner">দৌড়বিদ (Runner)</option>
                                        <option value="Long/High Jumper">জাম্পার (Jumper)</option>
                                        <option value="Athlete">সাধারণ অ্যাথলেট (Athlete)</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">সুনির্দিষ্ট পজিশন / ইভেন্ট (Position / Event)</label>
                            <input type="text" name="position" placeholder="উদা: লেফট উইং, সেন্টার ব্যাক, ১০০মি স্প্রিন্ট, মেইন শাটলার" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">ব্যাটিং স্টাইল (যদি প্রযোজ্য)</label>
                                <select name="batting_style" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                    <option value="">প্রযোজ্য নয়</option>
                                    <option value="Right-hand bat">ডানহাতি ব্যাট (RHB)</option>
                                    <option value="Left-hand bat">বামহাতি ব্যাট (LHB)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">বোলিং স্টাইল</label>
                                <select name="bowling_style" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                    <option value="">বোলিং করেন না</option>
                                    <option value="Right-arm fast">ডানহাতি ফাস্ট পেসার</option>
                                    <option value="Right-arm medium">ডানহাতি মিডিয়াম পেস</option>
                                    <option value="Right-arm offbreak">ডানহাতি অফ-স্পিন</option>
                                    <option value="Right-arm legbreak">ডানহাতি লেগ-স্পিন</option>
                                    <option value="Left-arm fast">বামহাতি ফাস্ট পেসার</option>
                                    <option value="Slow left-arm orthodox">বামহাতি অর্থোডক্স স্পিন</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-1">
                            <label class="inline-flex items-center text-xs text-gray-700 dark:text-gray-300 cursor-pointer">
                                <input type="checkbox" name="is_captain" value="1" class="rounded border-gray-300 dark:border-gray-700 text-emerald-600 focus:ring-emerald-500">
                                <span class="ml-2 font-bold text-emerald-600">টিম ক্যাপ্টেন (C)</span>
                            </label>

                            <label class="inline-flex items-center text-xs text-gray-700 dark:text-gray-300 cursor-pointer">
                                <input type="checkbox" name="is_vice_captain" value="1" class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 font-bold text-blue-600">সহ-অধিনায়ক (VC)</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-1.5">
                            <span>স্কোয়াডে যুক্ত করুন</span> ➔
                        </button>
                    </form>
                </div>

                <!-- Squad Roster List (2 cols) -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span>👥</span> স্কোয়াড ও প্লেয়ার তালিকা (Squad Roster)
                            </h3>
                            <p class="text-[11px] text-gray-400">এই প্লেয়াররা ম্যাচের স্কোরকার্ডে অন্তর্ভুক্ত হতে পারবেন</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 font-mono">
                            {{ $team->players->count() }} জন সদস্য
                        </span>
                    </div>

                    @if($team->players->count() > 0)
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($team->players as $player)
                                <div class="py-3 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <!-- Player Photo -->
                                        <div class="w-11 h-11 rounded-xl bg-gray-100 dark:bg-gray-700 overflow-hidden shrink-0 border border-gray-200 dark:border-gray-600 flex items-center justify-center">
                                            @if($player->photo)
                                                <img src="{{ asset('storage/' . $player->photo) }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                                            @elseif($player->trainee && $player->trainee->photo)
                                                <img src="{{ asset('storage/' . $player->trainee->photo) }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-sm font-bold text-gray-400">{{ $player->jersey_no ?? '#' }}</span>
                                            @endif
                                        </div>

                                        <div>
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('public.players.show', $player->id) }}" target="_blank" class="font-bold text-xs text-gray-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                                                    {{ $player->name }}
                                                </a>
                                                @if($player->is_captain)
                                                    <span class="px-1.5 py-0.2 rounded bg-emerald-500 text-slate-950 font-black text-[10px]">C</span>
                                                @endif
                                                @if($player->is_vice_captain)
                                                    <span class="px-1.5 py-0.2 rounded bg-blue-500 text-white font-bold text-[10px]">VC</span>
                                                @endif
                                                @if($player->jersey_no)
                                                    <span class="text-[10px] text-gray-400 font-mono">#{{ $player->jersey_no }}</span>
                                                @endif
                                            </div>

                                            <div class="flex items-center gap-2 text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                                                <span class="font-medium text-emerald-600 dark:text-emerald-400">{{ $player->role }}</span>
                                                @if($player->batting_style)
                                                    <span>• {{ $player->batting_style }}</span>
                                                @endif
                                                @if($player->bowling_style)
                                                    <span>• {{ $player->bowling_style }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('public.players.show', $player->id) }}" target="_blank" class="px-2.5 py-1 text-[11px] font-semibold bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-300 rounded-lg transition" title="ক্রিকইনফো স্টাইল প্লেয়ার প্রোফাইল">
                                            📊 প্রোফাইল
                                        </a>

                                        <form action="{{ route('admin.teams.remove-player', [$team, $player]) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই প্লেয়ারকে স্কোয়াড থেকে বাদ দিতে চান?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-gray-400 hover:text-rose-500 transition" title="স্কোয়াড থেকে বাদ দিন">
                                                ✕
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-xs text-gray-400">
                            এখনো কোনো প্লেয়ার স্কোয়াডে যুক্ত করা হয়নি। বামপাশের ফরম ব্যবহার করে প্লেয়ার যুক্ত করুন।
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    <script>
        document.getElementById('trainee_select')?.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            if (opt && opt.value) {
                document.getElementById('player_name_input').value = opt.getAttribute('data-name') || '';
                document.getElementById('player_jersey_input').value = opt.getAttribute('data-jersey') || '';
            }
        });
    </script>
</x-app-layout>


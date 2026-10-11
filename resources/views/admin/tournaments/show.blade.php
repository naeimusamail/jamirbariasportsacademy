<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>🏆</span> {{ $tournament->name }}
                </h2>
                <div class="flex items-center gap-2 mt-1">
                    @if($tournament->tournament_type === 'academic')
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                            🎓 একাডেমি টুর্নামেন্ট
                        </span>
                    @else
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                            🌟 লোকাল টুর্নামেন্ট
                        </span>
                    @endif
                    <span class="text-xs text-gray-400">| ভেন্যু: {{ $tournament->venue }}</span>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.tournaments.finances', $tournament) }}" class="px-3.5 py-1.5 bg-gradient-to-r from-amber-500 to-amber-400 hover:from-amber-400 hover:to-amber-300 text-slate-950 rounded-xl text-xs font-black shadow flex items-center gap-1.5 transition">
                    <span>💰</span> টুর্নামেন্ট আয়-ব্যয় ও বাজেট
                </a>
                <a href="{{ route('public.tournaments.show', $tournament->slug) }}" target="_blank" class="px-3 py-1.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-xl text-xs font-bold">
                    পাবলিক ভিউ ↗
                </a>
                <a href="{{ route('admin.tournaments.edit', $tournament) }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold">
                    সম্পাদনা
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-2xl text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Manage Teams Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Add Team to Tournament (1 col) -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 h-fit space-y-4">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                        <span>➕</span> টুর্নামেন্টে দল অন্তর্ভুক্ত করুন
                    </h3>

                    @if($availableTeams->count() > 0)
                        <form action="{{ route('admin.tournaments.add-team', $tournament) }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">দল নির্বাচন করুন</label>
                                <select name="team_id" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                                    @foreach($availableTeams as $at)
                                        <option value="{{ $at->id }}">{{ $at->name }} ({{ $at->category }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">গ্রুপ নাম (ঐচ্ছিক)</label>
                                <input type="text" name="group_name" value="গ্রুপ ক" placeholder="যেমন: গ্রুপ ক, গ্রুপ খ" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                            </div>

                            <button type="submit" class="w-full py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-xs transition shadow">
                                + টুর্নামেন্টে যুক্ত করুন
                            </button>
                        </form>
                    @else
                        <div class="text-xs text-gray-400 p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                            এই খেলার আর কোনো অতিরিক্ত দল খালি নেই। নতুন দল তৈরি করতে টিম ম্যানেজমেন্টে যান।
                        </div>
                    @endif
                </div>

                <!-- Enrolled Teams Table (2 cols) -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                            <span>🛡️</span> টুর্নামেন্টের দলীয় তালিকা ({{ $tournament->tournamentTeams->count() }}/{{ $tournament->total_teams }})
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-[10px] uppercase text-gray-400">
                                <tr>
                                    <th class="p-3">দল</th>
                                    <th class="p-3">গ্রুপ</th>
                                    <th class="p-3 text-center">ম্যাচ</th>
                                    <th class="p-3 text-center">জয়</th>
                                    <th class="p-3 text-center">পয়েন্ট</th>
                                    <th class="p-3 text-right">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($tournament->tournamentTeams as $tt)
                                    <tr>
                                        <td class="p-3 font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                            <span>⚽</span>
                                            <span>{{ $tt->team->name }}</span>
                                        </td>
                                        <td class="p-3">{{ $tt->group_name }}</td>
                                        <td class="p-3 text-center font-mono">{{ $tt->matches_played }}</td>
                                        <td class="p-3 text-center font-mono text-emerald-600">{{ $tt->won }}</td>
                                        <td class="p-3 text-center font-mono font-bold text-amber-500">{{ $tt->points }}</td>
                                        <td class="p-3 text-right">
                                            <form action="{{ route('admin.tournaments.remove-team', [$tournament, $tt->team]) }}" method="POST" class="inline" onsubmit="return confirm('দলটি টুর্নামেন্ট থেকে বাদ দিতে চান?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:underline font-bold">
                                                    অপসারণ
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-gray-400">
                                            কোনো দল এখনও অন্তর্ভুক্ত করা হয়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- ============================================================== -->
            <!-- 📅 MATCH FIXTURES & SCHEDULE MANAGEMENT -->
            <!-- ============================================================== -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-white flex items-center gap-2">
                            <span>📅</span> ম্যাচ শিডিউল ও ফিক্সচার (Match Fixtures & Schedule)
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">
                            শুরু ({{ $tournament->start_date ? $tournament->start_date->format('d M, Y') : 'অনির্ধারিত' }}) হতে ফাইনাল ({{ $tournament->end_date ? $tournament->end_date->format('d M, Y') : 'অনির্ধারিত' }}) পর্যন্ত টিম অনুযায়ী অটো শিডিউল তৈরি বা কাস্টমাইজ করুন।
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.tournaments.generate-schedule', $tournament) }}" method="POST" onsubmit="return confirm('দলসমূহের মধ্যে প্রাথমিক আপকামিং ম্যাচ শিডিউল তৈরি করতে চান?')">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black rounded-xl text-xs transition shadow flex items-center gap-1.5">
                                <span>⚡</span> অটো শিডিউল তৈরি করুন
                            </button>
                        </form>
                        <a href="{{ route('matches.create') }}?tournament_id={{ $tournament->id }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold rounded-xl text-xs transition">
                            + নতুন ম্যাচ
                        </a>
                    </div>
                </div>

                <!-- Match List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($tournament->matches as $m)
                        <div class="bg-gray-50 dark:bg-gray-900/80 rounded-2xl p-4 border border-gray-200 dark:border-gray-700 space-y-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-mono text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                    <span>🕒</span> {{ $m->match_datetime ? \Carbon\Carbon::parse($m->match_datetime)->format('d M, Y - h:i A') : 'তারিখ নির্ধারিত হয়নি' }}
                                </span>
                                @if($m->status === 'live')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500/10 text-rose-500 border border-rose-500/20 animate-pulse">
                                        ● লাইভ (Live)
                                    </span>
                                @elseif($m->status === 'finished')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                        সমাপ্ত (Finished)
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                        আপকামিং (Upcoming)
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-5 items-center gap-2 text-center py-2 bg-white dark:bg-gray-800 rounded-xl px-3 border border-gray-100 dark:border-gray-700">
                                <div class="col-span-2 text-left font-bold text-xs text-gray-900 dark:text-white truncate">
                                    {{ $m->team_a }}
                                </div>
                                <div class="text-[10px] font-black text-gray-400">VS</div>
                                <div class="col-span-2 text-right font-bold text-xs text-gray-900 dark:text-white truncate">
                                    {{ $m->team_b }}
                                </div>
                            </div>

                            <!-- Schedule update form -->
                            <form action="{{ route('admin.tournaments.update-match-schedule', [$tournament, $m]) }}" method="POST" class="pt-2 border-t border-gray-200 dark:border-gray-700/60 flex flex-wrap items-center gap-2 text-xs">
                                @csrf
                                @method('PATCH')
                                <div class="flex-1 min-w-[170px]">
                                    <input type="datetime-local" name="match_datetime" value="{{ $m->match_datetime ? \Carbon\Carbon::parse($m->match_datetime)->format('Y-m-d\TH:i') : '' }}" required
                                        class="w-full text-[11px] py-1 px-2 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                                </div>
                                <div class="flex-1 min-w-[140px]">
                                    <input type="text" name="venue" value="{{ $m->venue }}" placeholder="ভেন্যু" required
                                        class="w-full text-[11px] py-1 px-2 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                                </div>
                                <div class="w-28">
                                    <select name="status" class="w-full text-[11px] py-1 px-2 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                                        <option value="upcoming" {{ $m->status === 'upcoming' ? 'selected' : '' }}>আপকামিং</option>
                                        <option value="live" {{ $m->status === 'live' ? 'selected' : '' }}>লাইভ</option>
                                        <option value="finished" {{ $m->status === 'finished' ? 'selected' : '' }}>সমাপ্ত</option>
                                    </select>
                                </div>
                                <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-lg text-[11px] transition shrink-0">
                                    সংরক্ষণ
                                </button>
                                <a href="{{ route('matches.scorer', $m->slug) }}" target="_blank" class="px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:text-white rounded-lg text-[10px] font-bold shrink-0">
                                    স্কোরার ↗
                                </a>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-2 p-8 text-center bg-gray-50 dark:bg-gray-900 rounded-2xl text-xs text-gray-400">
                            কোনো ম্যাচ ফিক্সচার তৈরি করা হয়নি। ওপরের "⚡ অটো শিডিউল তৈরি করুন" বাটনে ক্লিক করে স্বয়ংক্রিয় প্রাথমিক ফিক্সচার তৈরি করুন।
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- 👥 TOURNAMENT REGISTERED PLAYERS & DRAFT/SELECTION SYSTEM -->
            <!-- ============================================================== -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-white flex items-center gap-2">
                            <span>👥</span> নিবন্ধিত প্লেয়ার তালিকা ও টিম সিলেকশন (Registered Players & Team Assignment)
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">
                            টুর্নামেন্টে প্লেয়ার অ্যাকাউন্ট দিয়ে নিবন্ধিত খেলোয়াড়দের তালিকা। দলহীন খেলোয়াড়দের (Free Agents) এখান থেকে টুর্নামেন্টের নির্দিষ্ট টিমে সিলেক্ট/এসাইন করুন।
                        </p>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <span class="px-3 py-1 bg-amber-500/10 text-amber-500 rounded-full font-bold">
                            মোট নিবন্ধিত: {{ $tournament->tournamentPlayers->count() }}
                        </span>
                        <span class="px-3 py-1 bg-rose-500/10 text-rose-500 rounded-full font-bold">
                            দলহীন: {{ $tournament->tournamentPlayers->whereNull('team_id')->count() }}
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-[10px] uppercase text-gray-400">
                            <tr>
                                <th class="p-3">প্লেয়ার নাম</th>
                                <th class="p-3">মোবাইল</th>
                                <th class="p-3">ইউজার / রোল</th>
                                <th class="p-3">পজিশন / জার্সি</th>
                                <th class="p-3">বর্তমান দল</th>
                                <th class="p-3 text-right">টিম সিলেকশন ও এসাইন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($tournament->tournamentPlayers as $tp)
                                <tr>
                                    <td class="p-3 font-bold text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center font-black text-xs">
                                                {{ mb_substr($tp->player_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div>{{ $tp->player_name }}</div>
                                                @if($tp->notes)
                                                    <div class="text-[10px] text-gray-400 font-normal">{{ $tp->notes }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 font-mono">{{ $tp->player_phone }}</td>
                                    <td class="p-3">
                                        @if($tp->user)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                {{ $tp->user->username ?: $tp->user->email }} ({{ $tp->user->role }})
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        {{ $tp->position ?? 'সাধারণ' }}
                                        @if($tp->jersey_no)
                                            <span class="font-mono text-amber-500 font-bold">#{{ $tp->jersey_no }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @if($tp->team)
                                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                🛡️ {{ $tp->team->name }}
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                                ⚠️ দল ছাড়া (Free Agent)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right">
                                        <form action="{{ route('admin.tournaments.assign-player', [$tournament, $tp]) }}" method="POST" class="inline-flex items-center gap-2">
                                            @csrf
                                            <select name="team_id" required class="text-[11px] py-1 px-2 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                                                <option value="">টিম নির্বাচন করুন...</option>
                                                @foreach($tournament->teams as $tm)
                                                    <option value="{{ $tm->id }}" {{ $tp->team_id == $tm->id ? 'selected' : '' }}>
                                                        {{ $tm->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-3 py-1 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-lg text-[11px] transition">
                                                সিলেক্ট
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">
                                        এখনও কোনো খেলোয়াড় এই টুর্নামেন্টে নিবন্ধন করেনি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>👥</span> {{ __('খেলোয়াড় ও ট্রেইনি ডিরেক্টরি') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">একাডেমিক ট্রেইনি এবং উন্মুক্ত টুর্নামেন্টের লোকাল প্লেয়ারদের সম্পূর্ণ তালিকা</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.players.search') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl text-xs sm:text-sm transition shadow-sm border border-slate-700">
                    <span>🔍</span> সার্বজনীন সার্চ (ID/মেইল)
                </a>
                <a href="{{ route('trainees.export', request()->query()) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs sm:text-sm transition">
                    <span>📥</span> CSV এক্সপোর্ট
                </a>
                <a href="{{ route('public.local-players.create') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-500/10 hover:bg-amber-500 text-amber-600 dark:text-amber-400 hover:text-slate-950 font-bold border border-amber-500/30 rounded-xl text-xs sm:text-sm transition shadow-sm">
                    <span>🏆</span> + লোকাল প্লেয়ার ফরম ↗
                </a>
                <a href="{{ route('trainees.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs sm:text-sm shadow transition">
                    + নতুন একাডেমি প্লেয়ার
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter Bar -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('trainees.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম / আইডি / ফোন..." class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">

                    <select name="player_type" class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">সকল প্লেয়ার (All Types)</option>
                        <option value="academic" {{ request('player_type') == 'academic' ? 'selected' : '' }}>🎓 একাডেমি প্লেয়ার</option>
                        <option value="local" {{ request('player_type') == 'local' ? 'selected' : '' }}>🏆 লোকাল প্লেয়ার (Tournament)</option>
                    </select>

                    <select name="sport_id" class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">সকল খেলা (All Sports)</option>
                        @foreach($sports as $sp)
                            <option value="{{ $sp->id }}" {{ request('sport_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                        @endforeach
                    </select>

                    <select name="batch_id" class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">সকল ব্যাচ (All Batches)</option>
                        @foreach($batches as $b)
                            <option value="{{ $b->id }}" {{ request('batch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>

                    <select name="category" class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">সকল ক্যাটাগরি</option>
                        <option value="U-12" {{ request('category') == 'U-12' ? 'selected' : '' }}>Under-12</option>
                        <option value="U-14" {{ request('category') == 'U-14' ? 'selected' : '' }}>Under-14</option>
                        <option value="U-16" {{ request('category') == 'U-16' ? 'selected' : '' }}>Under-16</option>
                        <option value="U-19" {{ request('category') == 'U-19' ? 'selected' : '' }}>Under-19</option>
                        <option value="Senior" {{ request('category') == 'Senior' ? 'selected' : '' }}>Senior / Open</option>
                    </select>

                    <div class="flex gap-2">
                        <button type="submit" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition">
                            ফিল্টার
                        </button>
                        @if(request()->hasAny(['search', 'player_type', 'sport_id', 'batch_id', 'category']))
                            <a href="{{ route('trainees.index') }}" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-gray-700 dark:text-gray-200 rounded-xl text-sm flex items-center justify-center">
                                রিসেট
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Trainees Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-5 py-3.5">ভর্তি নং</th>
                                <th class="px-5 py-3.5">নাম ও অভিভাবক</th>
                                <th class="px-5 py-3.5">খেলা ও ক্যাটাগরি</th>
                                <th class="px-5 py-3.5">ব্যাচ ও পজিশন</th>
                                <th class="px-5 py-3.5">ফোন নম্বর</th>
                                <th class="px-5 py-3.5">রক্তের গ্রুপ</th>
                                <th class="px-5 py-3.5">মাসিক ফি</th>
                                <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($trainees as $tr)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-750 transition">
                                    <td class="px-5 py-4">
                                        <div class="font-mono font-bold text-emerald-600 dark:text-emerald-400 text-xs">
                                            {{ $tr->admission_no }}
                                        </div>
                                        @if($tr->isLocal())
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-black bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30">
                                                🏆 লোকাল
                                            </span>
                                        @else
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                                🎓 একাডেমি
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 overflow-hidden shrink-0 flex items-center justify-center font-bold text-xs border border-emerald-500/20">
                                                @if($tr->photo)
                                                    <img src="{{ asset('storage/' . $tr->photo) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    {{ mb_substr($tr->name, 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white">{{ $tr->name }}</div>
                                                @if($tr->isLocal() && $tr->organization_or_area)
                                                    <div class="text-[11px] text-amber-600 dark:text-amber-400 font-semibold mt-0.5">এলাকা/দল: {{ $tr->organization_or_area }}</div>
                                                @else
                                                    <div class="text-xs text-gray-400 mt-0.5">অভিভাবক: {{ $tr->guardian_name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap items-center gap-1">
                                            @if($tr->sports && $tr->sports->count() > 0)
                                                @foreach($tr->sports as $sp)
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full {{ $sp->pivot->is_primary ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-500/30' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                                                        <span>{{ $sp->icon ?? '⚽' }}</span>
                                                        <span>{{ $sp->name }}</span>
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-xs font-semibold">{{ $tr->sport->name ?? '-' }}</span>
                                            @endif
                                        </div>
                                        <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 rounded">
                                            {{ $tr->category }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-medium text-gray-800 dark:text-gray-200">{{ $tr->batch->name ?? 'ব্যাচ বরাদ্দ নেই' }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">জার্সি: #{{ $tr->jersey_no ?? '-' }} ({{ $tr->position ?? 'সাধারণ' }})</div>
                                    </td>
                                    <td class="px-5 py-4 font-medium">{{ $tr->phone }}</td>
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-rose-50 dark:bg-rose-950 text-rose-600 dark:text-rose-400">
                                            {{ $tr->blood_group ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-gray-800 dark:text-gray-200">
                                        ৳{{ number_format($tr->monthly_fee) }}
                                    </td>
                                    <td class="px-5 py-4 text-right space-x-2">
                                        <a href="{{ route('trainees.show', $tr) }}" class="text-emerald-600 dark:text-emerald-400 font-semibold hover:underline">প্রোফাইল</a>
                                        <a href="{{ route('trainees.edit', $tr) }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">এডিট</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-gray-500">কোনো ট্রেইনি খুঁজে পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $trainees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


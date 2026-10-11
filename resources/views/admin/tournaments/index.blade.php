<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>🏆</span> {{ __('টুর্নামেন্ট সেক্টর ম্যানেজমেন্ট (Tournaments)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">একাডেমিক এবং উন্মুক্ত লোকাল টুর্নামেন্ট আয়োজন ও দল পরিচালনা</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('public.tournaments.index') }}" target="_blank" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-gray-700 dark:text-gray-200 font-bold rounded-xl text-xs transition">
                    পাবলিক পোর্টাল ভিউ ↗
                </a>
                <a href="{{ route('admin.tournaments.create') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-xs transition shadow">
                    + নতুন টুর্নামেন্ট তৈরি করুন
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-2xl text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2 bg-white dark:bg-gray-800 p-3 rounded-2xl border border-gray-100 dark:border-gray-700 text-xs font-bold">
                <a href="{{ route('admin.tournaments.index') }}" class="px-3 py-1.5 rounded-xl {{ !request('type') ? 'bg-amber-500 text-slate-950' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400' }}">
                    সকল টুর্নামেন্ট
                </a>
                <a href="{{ route('admin.tournaments.index', ['type' => 'academic']) }}" class="px-3 py-1.5 rounded-xl {{ request('type') == 'academic' ? 'bg-emerald-600 text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400' }}">
                    🎓 একাডেমি টুর্নামেন্ট
                </a>
                <a href="{{ route('admin.tournaments.index', ['type' => 'local']) }}" class="px-3 py-1.5 rounded-xl {{ request('type') == 'local' ? 'bg-rose-600 text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400' }}">
                    🌟 লোকাল টুর্নামেন্ট
                </a>
            </div>

            <!-- Tournaments Table -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4">টুর্নামেন্ট নাম</th>
                                <th class="px-4 py-4">ধরন (Type)</th>
                                <th class="px-4 py-4">খেলা / স্পোর্টস</th>
                                <th class="px-4 py-4">দল / ম্যাচ</th>
                                <th class="px-4 py-4">পুরস্কার পুল</th>
                                <th class="px-4 py-4">স্ট্যাটাস</th>
                                <th class="px-6 py-4 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($tournaments as $t)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-750 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $t->name }}</div>
                                        <div class="text-[11px] text-gray-400">📍 {{ $t->venue }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($t->tournament_type === 'academic')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30">
                                                🎓 একাডেমি
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/30">
                                                🌟 লোকাল উন্মুক্ত
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-gray-800 dark:text-gray-200 uppercase">
                                        {{ $t->sport_type }}
                                    </td>
                                    <td class="px-4 py-4 font-mono font-semibold">
                                        {{ $t->teams->count() }} দল • {{ $t->matches_count }} ম্যাচ
                                    </td>
                                    <td class="px-4 py-4 font-bold text-amber-600 dark:text-amber-400">
                                        {{ $t->prize_pool ?? 'ট্রফি' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $t->status_badge['class'] }}">
                                            {{ $t->status_badge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('admin.tournaments.finances', $t) }}" class="px-2.5 py-1 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg font-bold hover:bg-amber-500 hover:text-slate-950 transition">
                                            💰 আয়-ব্যয়
                                        </a>
                                        <a href="{{ route('admin.tournaments.show', $t) }}" class="px-3 py-1 bg-emerald-500/10 text-emerald-600 rounded-lg font-bold hover:bg-emerald-500 hover:text-white transition">
                                            দল ব্যবস্থাপনা
                                        </a>
                                        <a href="{{ route('admin.tournaments.edit', $t) }}" class="px-2 py-1 text-blue-600 hover:underline font-bold">
                                            এডিট
                                        </a>
                                        <form action="{{ route('admin.tournaments.destroy', $t) }}" method="POST" class="inline-block" onsubmit="return confirm('টুর্নামেন্টটি মুছে ফেলতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 text-rose-600 hover:underline font-bold">
                                                মুছুন
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                        কোনো টুর্নামেন্ট পাওয়া যায়নি। উপরে "+ নতুন টুর্নামেন্ট তৈরি করুন" এ ক্লিক করুন।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $tournaments->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

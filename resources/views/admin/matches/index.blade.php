<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500 animate-pulse"></span>
                    {{ __('একাডেমি লাইভ ম্যাচ ও স্কোরার কন্ট্রোল') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">জামিরবাড়িয়া স্পোর্টস একাডেমির সকল খেলা পরিচালনা ও লাইভ স্কোরার নির্ধারণ</p>
            </div>
            <div class="flex items-center gap-2">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('matches.create') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-sm shadow transition">
                        + নতুন ম্যাচ তৈরি করুন
                    </a>
                @endif
                <a href="{{ route('live.index') }}" target="_blank" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-800 dark:text-gray-200 rounded-xl text-sm font-semibold transition">
                    পাবলিক লাইভ হাব ↗
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-bold flex items-center gap-2">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="p-4 bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 rounded-xl text-sm font-bold flex items-center gap-2">
                    <span>⚠️</span> {{ session('warning') }}
                </div>
            @endif

            <!-- Scorer Management & Quick Link Box (Admin only) -->
            @if(Auth::user()->isAdmin())
                <div x-data="{ openScorerModal: false }" class="bg-gradient-to-r from-slate-900 to-slate-800 border border-slate-700 text-white p-5 rounded-2xl shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-black uppercase">অফিশিয়াল স্কোরার প্যানেল</span>
                            <span class="text-xs text-slate-400">নিবন্ধিত স্কোরার: <strong>{{ isset($scorers) ? $scorers->count() : 1 }} জন</strong></span>
                        </div>
                        <h3 class="text-base font-black text-white">খেলার মাঠে লাইভ স্কোরার নিয়োগ ও মোবাইল এক্সেস</h3>
                        <p class="text-xs text-slate-300">
                            স্কোরারকে স্কোরার একাউন্ট (<strong>scorer@jamirbaria.com</strong>) অথবা নিচের টেবিল থেকে ম্যাচের <strong>কুইক স্কোরার লিংক ও পিন</strong> প্রদান করুন।
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="openScorerModal = true" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold shadow transition flex items-center gap-1.5 whitespace-nowrap">
                            <span>+ নতুন স্কোরার তৈরি করুন</span>
                        </button>
                    </div>

                    <!-- Modal for Adding Scorer -->
                    <div x-show="openScorerModal" class="fixed inset-0 z-50 overflow-y-auto bg-black/70 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
                        <div @click.away="openScorerModal = false" class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-white shadow-2xl space-y-4">
                            <div class="flex items-center justify-between border-b pb-3 dark:border-gray-700">
                                <h4 class="font-black text-base flex items-center gap-2">
                                    <span>🎯</span> নতুন অফিসিয়াল স্কোরার নিবন্ধন
                                </h4>
                                <button @click="openScorerModal = false" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
                            </div>

                            <form method="POST" action="{{ route('admin.scorers.store') }}" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold mb-1">স্কোরারের পূর্ণ নাম *</label>
                                    <input type="text" name="name" required placeholder="যেমন: রাকিব হাসান" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-800 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">লগইন ইমেইল *</label>
                                    <input type="email" name="email" required placeholder="rakib.scorer@jamirbaria.com" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-800 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">পাসওয়ার্ড *</label>
                                    <input type="password" name="password" required value="password" placeholder="কমপক্ষে ৬ অক্ষর" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-800 dark:text-white">
                                </div>
                                <div class="pt-2 flex justify-end gap-2">
                                    <button type="button" @click="openScorerModal = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-xs font-bold rounded-xl">বাতিল</button>
                                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow">স্কোরার সেভ করুন &rarr;</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Match Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-base">একাডেমির সকল খেলার তালিকা ও স্কোরার কন্ট্রোল</h3>
                        <p class="text-xs text-gray-400">স্কোরার বা এডমিন প্যানেল থেকে স্কোর পরিবর্তন করলে তা তাৎক্ষণিক পাবলিক লাইভ সাইটে আপডেট হবে।</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 rounded-full w-fit">
                        মোট ম্যাচ: {{ $matches->total() }}টি
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500">
                            <tr>
                                <th class="px-5 py-3.5">ম্যাচের নাম ও টুর্নামেন্ট</th>
                                <th class="px-5 py-3.5">খেলা</th>
                                <th class="px-5 py-3.5">প্রতিদ্বন্দ্বী দল</th>
                                <th class="px-5 py-3.5">স্কোর</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                                <th class="px-5 py-3.5">নিযুক্ত স্কোরার ও পিন</th>
                                <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($matches as $match)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-750 transition">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $match->title }}</div>
                                        <div class="text-xs text-rose-500 font-semibold">{{ $match->tournament_name }}</div>
                                        <div class="text-[11px] text-gray-400">মাঠ: {{ $match->venue }}</div>
                                    </td>
                                    <td class="px-5 py-4 uppercase text-xs font-bold">{{ $match->sport_type }}</td>
                                    <td class="px-5 py-4 font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $match->team_a }} <br><span class="text-xs text-gray-400 font-normal">বনাম</span><br> {{ $match->team_b }}
                                    </td>
                                    <td class="px-5 py-4 font-mono font-black text-base text-gray-900 dark:text-white">
                                        {{ $match->team_a_score }} : {{ $match->team_b_score }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $match->status == 'live' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300 animate-pulse' : ($match->status == 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600') }}">
                                            {{ $match->status == 'live' ? '● LIVE' : ($match->status == 'upcoming' ? 'আসন্ন' : 'সমাপ্ত') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                                            👤 {{ $match->scorer_name ?: ($match->scorer ? $match->scorer->name : 'অফিশিয়াল স্কোরার') }}
                                        </div>
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <code class="px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-900 font-mono font-bold text-rose-600 dark:text-rose-400 text-xs border border-gray-200 dark:border-gray-700 select-all">
                                                {{ $match->scorer_code }}
                                            </code>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ route('scorer.quick-access', ['slug' => $match->slug, 'code' => $match->scorer_code]) }}'); alert('স্কোরার লিংক কপি করা হয়েছে!')" title="স্কোরার লিংক কপি করুন" class="px-2 py-0.5 rounded bg-rose-500/10 text-rose-600 hover:bg-rose-500 hover:text-white text-[11px] font-bold transition">
                                                লিংক কপি 📋
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-right space-x-1.5 whitespace-nowrap">
                                        <a href="{{ route('matches.scorer', $match->slug) }}" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow inline-block transition">
                                            স্কোর পরিচালনা 🔴
                                        </a>
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{ route('matches.edit', $match) }}" class="px-2.5 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold inline-block transition">
                                                এডিট ⚙️
                                            </a>
                                        @endif
                                        <a href="{{ route('live.show', $match->slug) }}" target="_blank" class="px-2.5 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-semibold inline-block transition">
                                            ভিউ ↗
                                        </a>
                                        @if(Auth::user()->isAdmin())
                                            <form method="POST" action="{{ route('matches.destroy', $match) }}" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ম্যাচটি মুছে ফেলতে চান?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-rose-600 hover:underline px-1">মুছুন</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-gray-500">কোনো ম্যাচ পাওয়া যায়নি। "+ নতুন ম্যাচ তৈরি করুন" বাটনে ক্লিক করে ম্যাচ তৈরি করুন।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $matches->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

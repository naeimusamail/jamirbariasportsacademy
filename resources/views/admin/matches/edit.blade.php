<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                    {{ __('ম্যাচ ও স্কোরার সেটিংস পরিবর্তন') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $match->title }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('matches.scorer', $match->slug) }}" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition">
                    🔴 স্কোরার কনসোল
                </a>
                <a href="{{ route('matches.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                    &larr; ম্যাচ তালিকায় ফিরুন
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">

                <form method="POST" action="{{ route('matches.update', $match) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ম্যাচের শিরোনাম *</label>
                        <input type="text" name="title" value="{{ old('title', $match->title) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">খেলার ধরণ *</label>
                            <select name="sport_type" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="football" {{ $match->sport_type == 'football' ? 'selected' : '' }}>⚽ ফুটবল</option>
                                <option value="cricket" {{ $match->sport_type == 'cricket' ? 'selected' : '' }}>🏏 ক্রিকেট</option>
                                <option value="badminton" {{ $match->sport_type == 'badminton' ? 'selected' : '' }}>🏸 ব্যাডমিন্টন</option>
                                <option value="other" {{ $match->sport_type == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ম্যাচ স্ট্যাটাস *</label>
                            <select name="status" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-bold">
                                <option value="upcoming" {{ $match->status == 'upcoming' ? 'selected' : '' }}>আসন্ন (Upcoming)</option>
                                <option value="live" {{ $match->status == 'live' ? 'selected' : '' }}>🔴 লাইভ চলমান (Live Now)</option>
                                <option value="finished" {{ $match->status == 'finished' ? 'selected' : '' }}>সমাপ্ত (Finished)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">টুর্নামেন্ট বা সিরিজের নাম</label>
                            <input type="text" name="tournament_name" value="{{ old('tournament_name', $match->tournament_name) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700/40 space-y-4">
                        <div class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                            <span>🛡️</span> দল নির্বাচন করুন
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">দল ১ (Team A) - সিলেকশন *</label>
                                <select name="team_a_id" id="team_a_select" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                    <option value="">-- নিবন্ধিত ক্লাব / দল থেকে বাছাই করুন --</option>
                                    @foreach($teams as $t)
                                        <option value="{{ $t->id }}" data-name="{{ $t->name }}" {{ old('team_a_id', $match->team_a_id) == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }} ({{ $t->category }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="team_a" id="team_a_text" value="{{ old('team_a', $match->team_a) }}">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">দল ২ (Team B) - সিলেকশন *</label>
                                <select name="team_b_id" id="team_b_select" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                    <option value="">-- নিবন্ধিত ক্লাব / দল থেকে বাছাই করুন --</option>
                                    @foreach($teams as $t)
                                        <option value="{{ $t->id }}" data-name="{{ $t->name }}" {{ old('team_b_id', $match->team_b_id) == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }} ({{ $t->category }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="team_b" id="team_b_text" value="{{ old('team_b', $match->team_b) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Scorer Assignment & PIN Section -->
                    <div class="p-5 rounded-2xl bg-rose-500/5 dark:bg-rose-950/20 border border-rose-500/30 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-rose-600 dark:text-rose-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span>🎯</span> অফিশিয়াল স্কোরার নির্ধারণ ও অ্যাক্সেস কোড
                            </span>
                            <span class="text-[11px] text-gray-500">অন-ফিল্ড লাইভ স্কোরার</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">দায়িত্বপ্রাপ্ত স্কোরার</label>
                                <select name="scorer_id" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                    <option value="">-- নির্দিষ্ট স্কোরার নেই (যে কেউ পিন কোড দিয়ে আপডেট করবে) --</option>
                                    @foreach($scorers as $sc)
                                        <option value="{{ $sc->id }}" {{ $match->scorer_id == $sc->id ? 'selected' : '' }}>
                                            {{ $sc->name }} ({{ $sc->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">স্কোরার সিক্রেট পিন / কোড (Scorer PIN)</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" name="scorer_code" id="scorer_code_input" value="{{ old('scorer_code', $match->scorer_code) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-mono font-black text-rose-600 uppercase">
                                    <button type="button" onclick="document.getElementById('scorer_code_input').value = 'SC' + Math.floor(1000 + Math.random() * 9000);" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-xl whitespace-nowrap" title="নতুন পিন তৈরি">
                                        রিলোড 🔄
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Direct Scorer Share Link Box -->
                        <div class="pt-2 border-t border-rose-500/20 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                            <span class="text-gray-400">অন-ফিল্ড স্কোরার ডিরেক্ট লিংক:</span>
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <input type="text" readonly value="{{ route('scorer.quick-access', ['slug' => $match->slug, 'code' => $match->scorer_code]) }}" id="direct_share_link" class="text-[11px] font-mono bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg px-2 py-1 text-gray-600 dark:text-gray-300 w-full sm:w-80 select-all">
                                <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('direct_share_link').value); alert('স্কোরার লিংক কপি করা হয়েছে!')" class="px-3 py-1 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold whitespace-nowrap shadow">
                                    কপি 📋
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">মাঠ / ভেন্যু *</label>
                            <input type="text" name="venue" value="{{ old('venue', $match->venue) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ম্যাচের তারিখ ও সময়</label>
                            <input type="datetime-local" name="match_datetime" value="{{ old('match_datetime', $match->match_datetime ? \Carbon\Carbon::parse($match->match_datetime)->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">লাইভ ভিডিও স্ট্রিমিং লিংক (YouTube / Facebook)</label>
                        <input type="url" name="stream_url" value="{{ old('stream_url', $match->stream_url) }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <script>
                        document.getElementById('team_a_select')?.addEventListener('change', function() {
                            const opt = this.options[this.selectedIndex];
                            if (opt && opt.value) {
                                document.getElementById('team_a_text').value = opt.getAttribute('data-name') || '';
                            }
                        });
                        document.getElementById('team_b_select')?.addEventListener('change', function() {
                            const opt = this.options[this.selectedIndex];
                            if (opt && opt.value) {
                                document.getElementById('team_b_text').value = opt.getAttribute('data-name') || '';
                            }
                        });
                    </script>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('matches.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-semibold">
                            বাতিল
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow">
                            পরিবর্তন সংরক্ষণ করুন &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

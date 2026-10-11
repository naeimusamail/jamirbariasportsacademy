<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                {{ __('নতুন একাডেমি অফিশিয়াল ম্যাচ তৈরি') }}
            </h2>
            <a href="{{ route('matches.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                &larr; ম্যাচ তালিকায় ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-800 dark:text-emerald-300">
                    🛡️ এটি জামিরবাড়িয়া স্পোর্টস একাডেমির <strong>অফিশিয়াল ম্যাচ</strong> হিসেবে তৈরি হবে। এই ম্যাচের স্কোর শুধুমাত্র এডমিন প্যানেল থেকে পরিচালনা করা যাবে।
                </div>

                <form method="POST" action="{{ route('matches.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ম্যাচের শিরোনাম *</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="যেমন: জামিরবাড়িয়া গোল্ড কাপ ফাইনাল ২০২৬" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">খেলার ধরণ *</label>
                            <select name="sport_type" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="football">⚽ ফুটবল</option>
                                <option value="cricket">🏏 ক্রিকেট</option>
                                <option value="badminton">🏸 ব্যাডমিন্টন</option>
                                <option value="other">অন্যান্য</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">টুর্নামেন্ট বা সিরিজের নাম</label>
                            <input type="text" name="tournament_name" value="{{ old('tournament_name', 'জামিরবাড়িয়া চ্যাম্পিয়নশিপ লিগ') }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700/40 space-y-4">
                        <div class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                            <span>🛡️</span> দল নির্বাচন করুন (নিবন্ধিত টিম বা কাস্টম নাম)
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">দল ১ (Team A) - সিলেকশন *</label>
                                <select name="team_a_id" id="team_a_select" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                    <option value="">-- নিবন্ধিত ক্লাব / দল থেকে বাছাই করুন --</option>
                                    @foreach($teams as $t)
                                        <option value="{{ $t->id }}" data-name="{{ $t->name }}" {{ old('team_a_id') == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }} ({{ $t->category }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="team_a" id="team_a_text" value="{{ old('team_a') }}">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">দল ২ (Team B) - সিলেকশন *</label>
                                <select name="team_b_id" id="team_b_select" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                    <option value="">-- নিবন্ধিত ক্লাব / দল থেকে বাছাই করুন --</option>
                                    @foreach($teams as $t)
                                        <option value="{{ $t->id }}" data-name="{{ $t->name }}" {{ old('team_b_id') == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }} ({{ $t->category }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="team_b" id="team_b_text" value="{{ old('team_b') }}">
                            </div>
                        </div>

                        <!-- Toss Details -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-200 dark:border-gray-600 text-xs">
                            <div>
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">টসে জয়ী দল (Toss Winner)</label>
                                <input type="text" name="toss_winner" value="{{ old('toss_winner') }}" placeholder="যেমন: জামিরবাড়িয়া টাইগার্স" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-xs">
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">টসের সিদ্ধান্ত (Toss Decision)</label>
                                <select name="toss_decision" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-xs">
                                    <option value="">টসের সিদ্ধান্ত নির্বাচন...</option>
                                    <option value="bat" {{ old('toss_decision') == 'bat' ? 'selected' : '' }}>ব্যাট করার সিদ্ধান্ত (Batted First)</option>
                                    <option value="field" {{ old('toss_decision') == 'field' ? 'selected' : '' }}>ফিল্ডিং/বোলিং করার সিদ্ধান্ত (Fielded First)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">মাঠ / ভেন্যু *</label>
                            <input type="text" name="venue" value="{{ old('venue', 'জামিরবাড়িয়া প্রধান একাডেমি স্টেডিয়াম') }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ম্যাচের তারিখ ও সময়</label>
                            <input type="datetime-local" name="match_datetime" value="{{ old('match_datetime', date('Y-m-d\TH:i')) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
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
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">দায়িত্বপ্রাপ্ত স্কোরার নির্বাচন করুন</label>
                                <select name="scorer_id" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                    <option value="">-- যে কেউ পিন কোড দিয়ে আপডেট করতে পারবে --</option>
                                    @foreach($scorers as $sc)
                                        <option value="{{ $sc->id }}" {{ (old('scorer_id') == $sc->id || $loop->first) ? 'selected' : '' }}>
                                            {{ $sc->name }} ({{ $sc->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-[11px] text-gray-400 mt-0.5 block">স্কোরারের ড্যাশবোর্ডে এই ম্যাচটি সরাসরি শো করবে।</span>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">স্কোরার সিক্রেট পিন / কোড (Scorer PIN)</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" name="scorer_code" id="scorer_code_input" value="{{ old('scorer_code', $suggestedCode ?? 'SC'.rand(1000,9999)) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-mono font-black text-rose-600 uppercase">
                                    <button type="button" onclick="document.getElementById('scorer_code_input').value = 'SC' + Math.floor(1000 + Math.random() * 9000);" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-xl whitespace-nowrap" title="নতুন পিন তৈরি">
                                        রিলোড 🔄
                                    </button>
                                </div>
                                <span class="text-[11px] text-gray-400 mt-0.5 block">এই কোডটি মোবাইল বা লিংকের মাধ্যমে স্কোরারকে দেওয়া যাবে।</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">লাইভ ভিডিও স্ট্রিমিং লিংক (YouTube / Facebook)</label>
                        <input type="url" name="stream_url" value="{{ old('stream_url') }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
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
                        <button type="submit" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-sm font-bold shadow">
                            অফিশিয়াল ম্যাচ পাবলিশ করুন &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


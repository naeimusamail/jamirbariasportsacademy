<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>📲</span> {{ __('বাল্ক SMS ব্রডকাস্ট ও অভিভাবক নোটিফিকেশন হাব') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    শিক্ষার্থী, অভিভাবক ও কোচের মোবাইলে এক ক্লিকে অফিশিয়াল নোটিশ ও বকেয়া ফি তাগাদা পাঠান
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>সিমুলেটর ও গেটওয়ে সক্রিয়</span>
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{
        recipientGroup: 'all',
        message: '',
        templates: {
            fee: 'প্রিয় অভিভাবক, জামিরবাড়িয়া স্পোর্টস একাডেমির চলতি মাসের ফি বকেয়া রয়েছে। অনুগ্রহ করে দ্রুত একাডেমি অফিসে বা বিকাশ নম্বরে পরিশোধের অনুরোধ করা হচ্ছে।',
            tournament: 'প্রিয় খেলোয়াড়, আগামী শুক্রবার একাডেমির মাঠে অফিসিয়াল টুর্নামেন্ট ম্যাচ অনুষ্ঠিত হবে। সকাল ৮টার মধ্যে জার্সি ও কিটসহ মাঠে উপস্থিত হতে হবে।',
            weather: 'বিশেষ নোটিশ: প্রতিকূল আবহাওয়ার কারণে আজকের অনুশীলন সাময়িকভাবে স্থগিত থাকবে এবং পরবর্তী শিডিউল অনুযায়ী অনুষ্ঠিত হবে। - একাডেমি কর্তৃপক্ষ',
            meeting: 'জরুরি নোটিশ: আগামী রবিবার একাডেমির সকল খেলোয়াড় ও অভিভাবকদের সাথে বিশেষ মতবিনিময় সভা অনুষ্ঠিত হবে। উপস্থিত থাকার অনুরোধ রইল।'
        },
        applyTemplate(key) {
            this.message = this.templates[key];
        },
        get charCount() {
            return this.message.length;
        },
        get smsParts() {
            return Math.ceil(this.message.length / 70) || 1;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-bold flex items-center gap-2">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-sm font-bold flex items-center gap-2">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            <!-- 3 Top Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-emerald-500/20">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-emerald-600 dark:text-emerald-400">মোট সক্রিয় খেলোয়াড়</span>
                        <span class="text-2xl">👥</span>
                    </div>
                    <div class="text-3xl font-black text-gray-900 dark:text-white mt-2">{{ $activeTraineesCount }}</div>
                    <p class="text-xs text-gray-400 mt-1">যাদের অ্যাকাউন্টে সচল ফোন নম্বর যুক্ত আছে</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-amber-500/20">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-amber-600 dark:text-amber-400">বকেয়া ফি শিক্ষার্থী (চলতি মাস)</span>
                        <span class="text-2xl">⚠️</span>
                    </div>
                    <div class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-2">{{ $defaultersCount }}</div>
                    <p class="text-xs text-gray-400 mt-1">তাগাদা এসএমএস এর জন্য প্রস্তুত</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-teal-500/20">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-teal-600 dark:text-teal-400">সর্বমোট প্রেরিত SMS</span>
                        <span class="text-2xl">📤</span>
                    </div>
                    <div class="text-3xl font-black text-teal-600 dark:text-teal-400 mt-2">{{ number_format($totalSentSms) }}</div>
                    <p class="text-xs text-gray-400 mt-1">ব্রডকাস্ট হিস্ট্রির মোট মেসেজ সংখ্যা</p>
                </div>
            </div>

            <!-- Compose SMS Broadcast Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                <div class="border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                    <h3 class="text-lg font-black text-gray-900 dark:text-white flex items-center gap-2">
                        <span>✉️</span> নতুন এসএমএস ক্যাম্পেইন কম্পোজ করুন
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">গ্রুপ নির্বাচন করুন অথবা রেডিমেড টেমপ্লেট ক্লিক করে এক ক্লিকে ব্রডকাস্ট পাঠান</p>
                </div>

                <form method="POST" action="{{ route('admin.sms.send') }}" class="space-y-6">
                    @csrf

                    <!-- Target Group Selection -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                            এসএমএস প্রাপক নির্বাচন (Target Audience) <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="recipient_group" value="all" x-model="recipientGroup" class="peer sr-only">
                                <div class="p-3.5 rounded-2xl border text-center transition peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-300 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 font-bold text-xs">
                                    <span class="text-lg block mb-1">📢</span>
                                    সকল শিক্ষার্থী ({{ $activeTraineesCount }})
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="recipient_group" value="defaulters" x-model="recipientGroup" class="peer sr-only">
                                <div class="p-3.5 rounded-2xl border text-center transition peer-checked:border-amber-500 peer-checked:bg-amber-500/10 peer-checked:text-amber-700 dark:peer-checked:text-amber-300 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 font-bold text-xs">
                                    <span class="text-lg block mb-1">⚠️</span>
                                    বকেয়া ফি গ্রাহক ({{ $defaultersCount }})
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="recipient_group" value="batch" x-model="recipientGroup" class="peer sr-only">
                                <div class="p-3.5 rounded-2xl border text-center transition peer-checked:border-blue-500 peer-checked:bg-blue-500/10 peer-checked:text-blue-700 dark:peer-checked:text-blue-300 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 font-bold text-xs">
                                    <span class="text-lg block mb-1">⏱️</span>
                                    নির্দিষ্ট ব্যাচ
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="recipient_group" value="sport" x-model="recipientGroup" class="peer sr-only">
                                <div class="p-3.5 rounded-2xl border text-center transition peer-checked:border-teal-500 peer-checked:bg-teal-500/10 peer-checked:text-teal-700 dark:peer-checked:text-teal-300 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 font-bold text-xs">
                                    <span class="text-lg block mb-1">⚽</span>
                                    নির্দিষ্ট খেলা
                                </div>
                            </label>

                            <label class="cursor-pointer col-span-2 sm:col-span-1">
                                <input type="radio" name="recipient_group" value="custom" x-model="recipientGroup" class="peer sr-only">
                                <div class="p-3.5 rounded-2xl border text-center transition peer-checked:border-purple-500 peer-checked:bg-purple-500/10 peer-checked:text-purple-700 dark:peer-checked:text-purple-300 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 font-bold text-xs">
                                    <span class="text-lg block mb-1">📱</span>
                                    কাস্টম নম্বর
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Dynamic Options based on selection -->
                    <div x-show="recipientGroup === 'batch'" x-cloak class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">কোন ব্যাচের শিক্ষার্থীদের পাঠাবেন?</label>
                        <select name="batch_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                            @foreach($batches as $b)
                                <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->time_slot }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="recipientGroup === 'sport'" x-cloak class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">কোন খেলার শিক্ষার্থীদের পাঠাবেন?</label>
                        <select name="sport_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                            @foreach($sports as $sp)
                                <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="recipientGroup === 'custom'" x-cloak class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">ফোন নম্বরসমূহ (কমা দিয়ে লিখুন)</label>
                        <input type="text" name="custom_numbers" placeholder="017XXXXXXXX, 018XXXXXXXX, 019XXXXXXXX" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                    </div>

                    <!-- Quick Template Buttons -->
                    <div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2">⚡ কুইক টেমপ্লেট থেকে মেসেজ বসান:</span>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" @click="applyTemplate('fee')" class="px-3 py-1.5 bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded-xl text-xs font-bold border border-amber-500/30 transition">
                                💰 ফি বকেয়া তাগাদা
                            </button>
                            <button type="button" @click="applyTemplate('tournament')" class="px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 rounded-xl text-xs font-bold border border-emerald-500/30 transition">
                                🏆 টুর্নামেন্ট নোটিশ
                            </button>
                            <button type="button" @click="applyTemplate('weather')" class="px-3 py-1.5 bg-blue-500/10 hover:bg-blue-500/20 text-blue-700 dark:text-blue-300 rounded-xl text-xs font-bold border border-blue-500/30 transition">
                                🌧️ আবহাওয়া / অনুশীলন সূচি
                            </button>
                            <button type="button" @click="applyTemplate('meeting')" class="px-3 py-1.5 bg-purple-500/10 hover:bg-purple-500/20 text-purple-700 dark:text-purple-300 rounded-xl text-xs font-bold border border-purple-500/30 transition">
                                📢 মতবিনিময় সভা
                            </button>
                        </div>
                    </div>

                    <!-- Message Body & Live Counter -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                মেসেজ বিবরণ (বাংলা বা ইংরেজি) <span class="text-rose-500">*</span>
                            </label>
                            <div class="text-xs font-mono font-bold text-gray-500">
                                <span x-text="charCount">0</span> অক্ষর • <span class="text-emerald-600 dark:text-emerald-400" x-text="smsParts">1</span> পার্ট এসএমএস
                            </div>
                        </div>

                        <textarea name="message" x-model="message" rows="4" placeholder="আপনার বার্তাটি এখানে লিখুন..." required class="w-full text-sm rounded-2xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" onclick="return confirm('আপনি কি নিশ্চিত যে নির্বাচিত প্রাপকদের কাছে এই SMS ব্রডকাস্ট পাঠাতে চান?')" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm rounded-2xl shadow-lg hover:shadow-emerald-500/25 transition flex items-center gap-2">
                            <span>🚀</span> এসএমএস ব্রডকাস্ট পাঠান
                        </button>
                    </div>
                </form>
            </div>

            <!-- Outbox / Broadcast Logs Table -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>📜</span> এসএমএস প্রেরণের ইতিহাস (Outbox Logs)
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">সম্প্রতি পাঠানো সকল ব্রডকাস্টের তালিকা ও স্ট্যাটাস</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase tracking-wider font-bold text-[10px]">
                            <tr>
                                <th class="p-4">তারিখ ও সময়</th>
                                <th class="p-4">টার্গেট গ্রুপ</th>
                                <th class="p-4">প্রাপক সংখ্যা</th>
                                <th class="p-4">মেসেজ প্রিভিউ</th>
                                <th class="p-4">এসএমএস সাইজ</th>
                                <th class="p-4 text-center">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($smsLogs as $log)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30">
                                    <td class="p-4 font-mono font-medium text-gray-500">
                                        {{ $log->created_at->format('d M, Y h:i A') }}
                                    </td>
                                    <td class="p-4 font-bold text-gray-800 dark:text-gray-200">
                                        @if($log->recipient_group == 'all')
                                            📢 সকল শিক্ষার্থী
                                        @elseif($log->recipient_group == 'defaulters')
                                            ⚠️ বকেয়া ফি শিক্ষার্থী
                                        @elseif($log->recipient_group == 'batch')
                                            ⏱️ ব্যাচ
                                        @elseif($log->recipient_group == 'sport')
                                            ⚽ খেলা
                                        @else
                                            📱 কাস্টম নম্বর
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <span class="font-black text-gray-900 dark:text-white">{{ $log->recipient_count }}</span> জন
                                        <div class="text-[10px] text-gray-400 truncate max-w-xs">{{ $log->sample_recipients }}</div>
                                    </td>
                                    <td class="p-4 max-w-md">
                                        <p class="text-xs text-gray-700 dark:text-gray-300 line-clamp-2">{{ $log->message }}</p>
                                    </td>
                                    <td class="p-4 font-mono text-gray-500">
                                        {{ $log->sms_parts }} পার্ট
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">
                                            ✓ সফল (Sent)
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">
                                        এখনো কোনো বাল্ক এসএমএস ব্রডকাস্ট পাঠানো হয়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($smsLogs->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $smsLogs->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>


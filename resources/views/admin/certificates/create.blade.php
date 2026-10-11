<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>📜</span> {{ __('নতুন সনদপত্র (Certificate) ইস্যু করুন') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    প্লেয়ারের অর্জন, কোর্স সমাপ্তি বা টুর্নামেন্ট সাফল্যের জন্য ডিজিটাল কিউআর ভেরিফায়েড সার্টিফিকেট তৈরি করুন
                </p>
            </div>
            <a href="{{ route('admin.certificates.index') }}" class="px-3.5 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                &larr; সনদপত্র তালিকা
            </a>
        </div>
    </x-slot>

    <div class="py-8" x-data="{
        desc: 'জামিরবাড়িয়া স্পোর্টস একাডেমির প্রশিক্ষণ কার্যক্রমে সফলতার সাথে অংশগ্রহণ ও নির্ধারিত ক্রীড়া দক্ষতা প্রদর্শনপূর্বক এই সনদপত্র প্রদান করা হলো।',
        fillTemplate(type) {
            if (type === 'completion') {
                this.desc = 'জামিরবাড়িয়া স্পোর্টস একাডেমির নিয়মিত প্রশিক্ষণ কার্যক্রমে একনিষ্ঠতার সাথে অংশগ্রহণ ও নির্ধারিত ক্রীড়া মডিউল সফলভাবে সমাপ্ত করার স্বীকৃতিস্বরূপ এই সনদপত্র প্রদান করা হলো।';
            } else if (type === 'champion') {
                this.desc = 'জামিরবাড়িয়া স্পোর্টস একাডেমি আয়োজিত আন্তঃএকাডেমি টুর্নামেন্টে অসামান্য ক্রীড়াশৈলী ও দলগত নেতৃত্ব প্রদর্শন করে চ্যাম্পিয়ন গৌরব অর্জন করায় এই সম্মাননা পত্র প্রদান করা হলো।';
            } else if (type === 'mvp') {
                this.desc = 'টুর্নামেন্টে সর্বোত্তম অল-রাউন্ড নৈপুণ্য ও দৃষ্টান্তমূলক ক্রীড়া প্রতিভা প্রদর্শনপূর্বক \'প্লেয়ার অব দ্য টুর্নামেন্ট / শ্রেষ্ঠ খেলোয়াড়\' খেতাব অর্জন করায় এই গৌরবময় সনদপত্র প্রদান করা হলো।';
            } else if (type === 'participation') {
                this.desc = 'জামিরবাড়িয়া স্পোর্টস একাডেমির বিশেষ ক্রীড়া ক্যাম্প ও প্রতিযোগিতায় সক্রিয় অংশগ্রহণ এবং প্রশংসনীয় স্পোর্টসম্যানশিপ প্রদর্শনের স্বীকৃতিস্বরূপ এই অংশগ্রহণ সনদপত্র প্রদান করা হলো।';
            }
        }
    }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-700 dark:text-rose-400 rounded-2xl text-xs font-bold mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.certificates.store') }}" class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">
                @csrf

                <!-- Section: Player & Number -->
                <div class="border-b border-gray-100 dark:border-gray-700 pb-6">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span>👤</span> প্রাপক প্লেয়ার ও সনদ তথ্য
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Trainee Selection -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">প্লেয়ার নির্বাচন করুন <span class="text-rose-500">*</span></label>
                            <select name="trainee_id" required class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                                <option value="">-- প্লেয়ার বাছাই করুন --</option>
                                @foreach($trainees as $t)
                                    <option value="{{ $t->id }}" {{ (old('trainee_id', $selectedTraineeId) == $t->id) ? 'selected' : '' }}>
                                        {{ $t->name }} ({{ $t->admission_no }}) — {{ $t->sport->name ?? 'অ্যাথলেটিক্স' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Certificate Number -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">অফিসিয়াল সনদপত্র নম্বর <span class="text-rose-500">*</span></label>
                            <input type="text" name="certificate_no" value="{{ old('certificate_no', $defaultCertificateNo) }}" required class="w-full text-xs font-mono font-bold rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-emerald-400 focus:ring-emerald-500">
                            <span class="text-[10px] text-gray-400">অনন্য সনদ ট্র্যাকিং কোড যা কিউআর কোডে যুক্ত থাকবে</span>
                        </div>
                    </div>
                </div>

                <!-- Section: Certificate Details -->
                <div class="border-b border-gray-100 dark:border-gray-700 pb-6">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span>🏅</span> সনদের ধরন ও অর্জন
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">সনদের মূল শিরোনাম <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', 'প্রশিক্ষণ সমাপ্তি ও দক্ষতা সনদপত্র') }}" required placeholder="উদাঃ বাৎসরিক ক্রিকেট ক্যাম্প সমাপনী সনদ" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">সনদের শ্রেণি (Type) <span class="text-rose-500">*</span></label>
                            <select name="certificate_type" required class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                                <option value="completion" {{ old('certificate_type') == 'completion' ? 'selected' : '' }}>প্রশিক্ষণ সমাপ্তি (Completion)</option>
                                <option value="achievement" {{ old('certificate_type') == 'achievement' ? 'selected' : '' }}>অর্জন ও চ্যাম্পিয়ন (Achievement)</option>
                                <option value="appreciation" {{ old('certificate_type') == 'appreciation' ? 'selected' : '' }}>বিশেষ সম্মাননা (Appreciation)</option>
                                <option value="participation" {{ old('certificate_type') == 'participation' ? 'selected' : '' }}>অংশগ্রহণ (Participation)</option>
                            </select>
                        </div>

                        <!-- Sport -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">খেলা (Sport)</label>
                            <select name="sport_id" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                                <option value="">সকল খেলা / সাধারণ</option>
                                @foreach($sports as $s)
                                    <option value="{{ $s->id }}" {{ old('sport_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Event or Course -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">কোর্স বা ইভেন্টের নাম</label>
                            <input type="text" name="event_or_course" value="{{ old('event_or_course', 'বেসিক স্পোর্টস স্কিলস ও ফিটনেস প্রোগ্রাম ২০২৬') }}" placeholder="উদাঃ একাডেমি ফুটবল কাপ ২০২৬" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                        </div>

                        <!-- Grade / Rank -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">র‌্যাঙ্ক / অর্জন / গ্রেড (ঐচ্ছিক)</label>
                            <input type="text" name="grade_or_rank" value="{{ old('grade_or_rank') }}" placeholder="উদাঃ চ্যাম্পিয়ন, এ+, ম্যান অব দ্য ম্যাচ" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <!-- Section: Citation & Signatory -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                            <span>✍️</span> প্রশংসাপত্র বক্তব্য ও স্বাক্ষর
                        </h3>
                        <!-- Quick Templates -->
                        <div class="flex flex-wrap items-center gap-1.5 text-[10px]">
                            <span class="text-gray-400 font-bold">টেমপ্লেট অটো-ফিল:</span>
                            <button type="button" @click="fillTemplate('completion')" class="px-2 py-1 rounded-lg bg-emerald-500/10 hover:bg-emerald-500 text-emerald-600 hover:text-white font-bold transition">সমাপ্তি</button>
                            <button type="button" @click="fillTemplate('champion')" class="px-2 py-1 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-600 hover:text-white font-bold transition">চ্যাম্পিয়ন</button>
                            <button type="button" @click="fillTemplate('mvp')" class="px-2 py-1 rounded-lg bg-purple-500/10 hover:bg-purple-500 text-purple-600 hover:text-white font-bold transition">এমভিপি</button>
                            <button type="button" @click="fillTemplate('participation')" class="px-2 py-1 rounded-lg bg-blue-500/10 hover:bg-blue-500 text-blue-600 hover:text-white font-bold transition">অংশগ্রহণ</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">প্রশংসাসূচক বিবরণ (Citation Body) <span class="text-rose-500">*</span></label>
                        <textarea name="description" rows="3" x-model="desc" required class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500 leading-relaxed">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">ইস্যুর তারিখ <span class="text-rose-500">*</span></label>
                            <input type="date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">অনুমোদিত স্বাক্ষরকারীর পদবি <span class="text-rose-500">*</span></label>
                            <input type="text" name="instructor_name" value="{{ old('instructor_name', 'পরিচালক ও প্রধান প্রশিক্ষক') }}" required class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.certificates.index') }}" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold transition">
                        বাতিল
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black shadow-lg shadow-emerald-600/30 transition flex items-center gap-2">
                        <span>📜 সনদপত্র তৈরি ও প্রিভিউ দেখুন</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>


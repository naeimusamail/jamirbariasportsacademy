<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>🏃</span> {{ __('নতুন প্লেয়ার ফিটনেস ও পারফরম্যান্স টেস্ট এন্ট্রি') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    উচ্চতা, ওজন, স্প্রিন্ট স্পিড ও স্ট্যামিনা টেস্টের ফলাফল সংরক্ষণ করুন
                </p>
            </div>
            <a href="{{ route('performances.index') }}" class="px-3.5 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold">
                ← তালিকায় ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-600 rounded-xl text-xs">
                    <div class="font-bold mb-1">ত্রুটি সংশোধন করুন:</div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('performances.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- 1. Trainee & Date -->
                    <div>
                        <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">
                            ১. খেলোয়াড় ও টেস্টের তারিখ
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">ট্রেইনি / প্লেয়ার নির্বাচন করুন <span class="text-rose-500">*</span></label>
                                <select name="trainee_id" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                                    <option value="">প্লেয়ার বাছাই করুন...</option>
                                    @foreach($trainees as $tr)
                                        <option value="{{ $tr->id }}" {{ (old('trainee_id') == $tr->id || $selectedTraineeId == $tr->id) ? 'selected' : '' }}>
                                            {{ $tr->name }} ({{ $tr->admission_no }}) — {{ $tr->sport->name ?? '' }} [{{ $tr->category }}]
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">টেস্টের তারিখ <span class="text-rose-500">*</span></label>
                                <input type="date" name="test_date" value="{{ old('test_date', date('Y-m-d')) }}" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-gray-700" />

                    <!-- 2. Physical & BMI with Live Calculator -->
                    <div>
                        <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">
                            ২. শারীরিক গঠন ও BMI সূচক
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">উচ্চতা (সেন্টিমিটার / cm)</label>
                                <input type="number" step="0.5" name="height_cm" id="height_cm" value="{{ old('height_cm') }}" placeholder="উদা: 170" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">ওজন (কেজি / kg)</label>
                                <input type="number" step="0.5" name="weight_kg" id="weight_kg" value="{{ old('weight_kg') }}" placeholder="উদা: 62" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            </div>

                            <div class="p-3 bg-indigo-50/50 dark:bg-indigo-950/30 rounded-xl border border-indigo-100 dark:border-indigo-900/40 flex flex-col justify-center items-center">
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">লাইভ বিএমআই (BMI)</span>
                                <div id="live-bmi" class="text-xl font-black text-indigo-600 dark:text-indigo-400">--</div>
                                <span id="live-bmi-label" class="text-[10px] font-semibold text-gray-400">উচ্চতা ও ওজন দিন</span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-gray-700" />

                    <!-- 3. Speed & Stamina Drills -->
                    <div>
                        <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">
                            ৩. স্পিড, স্ট্যামিনা ও ফিটনেস ড্রিলস
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">১০০ মিটার স্প্রিন্ট (সেকেন্ড)</label>
                                <input type="number" step="0.01" name="sprint_100m_sec" value="{{ old('sprint_100m_sec') }}" placeholder="উদা: 12.4" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Yo-Yo টেস্ট স্কোর / লেভেল</label>
                                <input type="text" name="yoyo_score" value="{{ old('yoyo_score') }}" placeholder="উদা: 18.2" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">স্ট্যামিনা লেভেল <span class="text-rose-500">*</span></label>
                                <select name="stamina_level" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                                    <option value="Good" {{ old('stamina_level') == 'Good' ? 'selected' : '' }}>Good (ভালো)</option>
                                    <option value="Excellent" {{ old('stamina_level') == 'Excellent' ? 'selected' : '' }}>Excellent (অসাধারণ)</option>
                                    <option value="Average" {{ old('stamina_level') == 'Average' ? 'selected' : '' }}>Average (মোটামুটি)</option>
                                    <option value="Needs Improvement" {{ old('stamina_level') == 'Needs Improvement' ? 'selected' : '' }}>Needs Improvement (উন্নতি দরকার)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-gray-700" />

                    <!-- 4. Match Performance & Coach Rating -->
                    <div>
                        <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">
                            ৪. ম্যাচ পারফরম্যান্স ও কোচের মূল্যায়ন
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">অংশগ্রহণকৃত ম্যাচ সংখ্যা</label>
                                <input type="number" name="matches_played" value="{{ old('matches_played', 0) }}" min="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">গোল / রান (Goals/Runs)</label>
                                <input type="number" name="goals_or_runs" value="{{ old('goals_or_runs', 0) }}" min="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">উইকেট / অ্যাসিস্ট (Wickets/Assists)</label>
                                <input type="number" name="wickets_or_assists" value="{{ old('wickets_or_assists', 0) }}" min="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">কোচ রেটিং (১-৫ স্টার) <span class="text-rose-500">*</span></label>
                                <select name="coach_rating" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">
                                    <option value="5" {{ old('coach_rating', 5) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ ৫ স্টার (চমৎকার)</option>
                                    <option value="4" {{ old('coach_rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ ৪ স্টার (খুব ভালো)</option>
                                    <option value="3" {{ old('coach_rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ ৩ স্টার (সন্তোষজনক)</option>
                                    <option value="2" {{ old('coach_rating') == 2 ? 'selected' : '' }}>⭐⭐ ২ স্টার (গড়পড়তা)</option>
                                    <option value="1" {{ old('coach_rating') == 1 ? 'selected' : '' }}>⭐ ১ স্টার (বিশেষ ড্রিল প্রয়োজন)</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">কোচের পরামর্শ ও মূল্যায়ন মন্তব্য</label>
                                <textarea name="coach_remarks" rows="2" placeholder="উদা: স্প্রিন্টে অগ্রগতি ভালো, তবে স্ট্যামিনা আরও বাড়াতে প্রতিদিন সকালে লং রানিং প্রয়োজন..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-indigo-500">{{ old('coach_remarks') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
                        <a href="{{ route('performances.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold">
                            বাতিল
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md transition">
                            টেস্ট রেকর্ড সংরক্ষণ করুন &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const heightInput = document.getElementById('height_cm');
        const weightInput = document.getElementById('weight_kg');
        const liveBmi = document.getElementById('live-bmi');
        const liveBmiLabel = document.getElementById('live-bmi-label');

        function calculateBmi() {
            const h = parseFloat(heightInput.value);
            const w = parseFloat(weightInput.value);

            if (h > 0 && w > 0) {
                const heightMeters = h / 100;
                const bmi = (w / (heightMeters * heightMeters)).toFixed(1);
                liveBmi.textContent = bmi;

                if (bmi < 18.5) {
                    liveBmiLabel.textContent = 'কম ওজন (Underweight)';
                    liveBmiLabel.className = 'text-[10px] font-bold text-amber-500';
                } else if (bmi <= 24.9) {
                    liveBmiLabel.textContent = 'আদর্শ ওজন (Normal BMI)';
                    liveBmiLabel.className = 'text-[10px] font-bold text-emerald-500';
                } else if (bmi <= 29.9) {
                    liveBmiLabel.textContent = 'অতিরিক্ত ওজন (Overweight)';
                    liveBmiLabel.className = 'text-[10px] font-bold text-amber-500';
                } else {
                    liveBmiLabel.textContent = 'স্থূলতা (Obese)';
                    liveBmiLabel.className = 'text-[10px] font-bold text-rose-500';
                }
            } else {
                liveBmi.textContent = '--';
                liveBmiLabel.textContent = 'উচ্চতা ও ওজন দিন';
                liveBmiLabel.className = 'text-[10px] font-semibold text-gray-400';
            }
        }

        heightInput.addEventListener('input', calculateBmi);
        weightInput.addEventListener('input', calculateBmi);
    </script>
</x-app-layout>


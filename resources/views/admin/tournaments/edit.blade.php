<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>✏️</span> {{ __('টুর্নামেন্ট সম্পাদনা (Edit Tournament)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $tournament->name }}</p>
            </div>
            <a href="{{ route('admin.tournaments.index') }}" class="text-xs text-emerald-600 dark:text-emerald-400 font-bold hover:underline">
                &larr; তালিকায় ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('admin.tournaments.update', $tournament) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">টুর্নামেন্টের পূর্ণ নাম *</label>
                            <input type="text" name="name" value="{{ old('name', $tournament->name) }}" required
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">টুর্নামেন্টের ধরন *</label>
                            <select name="tournament_type" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                                <option value="academic" {{ old('tournament_type', $tournament->tournament_type) == 'academic' ? 'selected' : '' }}>🎓 একাডেমিক টুর্নামেন্ট</option>
                                <option value="local" {{ old('tournament_type', $tournament->tournament_type) == 'local' ? 'selected' : '' }}>🌟 লোকাল / উন্মুক্ত টুর্নামেন্ট</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">খেলার ধরন *</label>
                            <select name="sport_type" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                                <option value="football" {{ old('sport_type', $tournament->sport_type) == 'football' ? 'selected' : '' }}>⚽ ফুটবল</option>
                                <option value="cricket" {{ old('sport_type', $tournament->sport_type) == 'cricket' ? 'selected' : '' }}>🏏 ক্রিকেট</option>
                                <option value="badminton" {{ old('sport_type', $tournament->sport_type) == 'badminton' ? 'selected' : '' }}>🏸 ব্যাডমিন্টন</option>
                                <option value="athletics" {{ old('sport_type', $tournament->sport_type) == 'athletics' ? 'selected' : '' }}>🏃 অ্যাথলেটিক্স</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">ভেন্যু / খেলার মাঠ *</label>
                            <input type="text" name="venue" value="{{ old('venue', $tournament->venue) }}" required
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">পুরস্কার পুল / প্রাইজ মানি</label>
                            <input type="text" name="prize_pool" value="{{ old('prize_pool', $tournament->prize_pool) }}"
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">শুরুর তারিখ</label>
                            <input type="date" name="start_date" value="{{ old('start_date', $tournament->start_date?->format('Y-m-d')) }}"
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">সমাপ্তির তারিখ</label>
                            <input type="date" name="end_date" value="{{ old('end_date', $tournament->end_date?->format('Y-m-d')) }}"
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">রেজিস্ট্রেশন শুরুর সময় (Registration Start Time) 🚀</label>
                            <input type="datetime-local" name="registration_start_date" value="{{ old('registration_start_date', $tournament->registration_start_date?->format('Y-m-d\TH:i')) }}"
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                            <span class="text-[10px] text-gray-400">খালি রাখলে অবিলম্বে নিবন্ধন শুরু হবে</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">রেজিস্ট্রেশনের শেষ সময় (Registration Deadline) ⏰</label>
                            <input type="datetime-local" name="registration_deadline" value="{{ old('registration_deadline', $tournament->registration_deadline?->format('Y-m-d\TH:i')) }}"
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                            <span class="text-[10px] text-gray-400">এই সময়ের পর আর প্লেয়ার রেজিস্ট্রেশন করতে পারবে না</span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">মোট দল</label>
                            <input type="number" name="total_teams" value="{{ old('total_teams', $tournament->total_teams) }}" min="2" max="64" required
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">স্ট্যাটাস *</label>
                            <select name="status" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">
                                <option value="upcoming" {{ old('status', $tournament->status) == 'upcoming' ? 'selected' : '' }}>আসন্ন (Upcoming)</option>
                                <option value="ongoing" {{ old('status', $tournament->status) == 'ongoing' ? 'selected' : '' }}>চলমান (Ongoing)</option>
                                <option value="completed" {{ old('status', $tournament->status) == 'completed' ? 'selected' : '' }}>সমাপ্ত (Completed)</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">সংক্ষিপ্ত বিবরণ</label>
                            <textarea name="description" rows="2"
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">{{ old('description', $tournament->description) }}</textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">টুর্নামেন্টের নিয়মাবলী ও গাইডলাইন</label>
                            <textarea name="rules" rows="4"
                                class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white">{{ old('rules', $tournament->rules) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs transition shadow">
                            আপডেট সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

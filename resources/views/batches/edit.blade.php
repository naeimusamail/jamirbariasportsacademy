<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>✏️</span> {{ __('ব্যাচ ও কোচ অ্যাসাইনমেন্ট সম্পাদনা (Edit Batch)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">অ্যাডমিন কর্তৃক ব্যাচের সময়সূচি, মাঠ ও দায়িত্বপ্রাপ্ত কোচ পরিবর্তন</p>
            </div>
            <a href="{{ route('batches.index') }}" class="text-xs text-emerald-600 dark:text-emerald-400 font-bold hover:underline">
                &larr; ব্যাচ তালিকায় ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('batches.update', $batch) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">স্পোর্টস / খেলা *</label>
                        <select name="sport_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            @foreach($sports as $s)
                                <option value="{{ $s->id }}" {{ old('sport_id', $batch->sport_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->icon }} {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">দায়িত্বপ্রাপ্ত কোচ (অ্যাডমিন কর্তৃক নির্ধারণ)</label>
                        <select name="coach_id" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            <option value="">কোচ বরাদ্দ নেই</option>
                            @foreach($coaches as $c)
                                <option value="{{ $c->id }}" {{ old('coach_id', $batch->coach_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} ({{ $c->designation }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ব্যাচের নাম *</label>
                        <input type="text" name="name" value="{{ old('name', $batch->name) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">অনুশীলনের দিনসমূহ *</label>
                        <input type="text" name="days" value="{{ old('days', $batch->days) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">সময়সূচি (Time Slot) *</label>
                        <input type="text" name="time_slot" value="{{ old('time_slot', $batch->time_slot) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">মাঠ / ভেন্যু *</label>
                        <input type="text" name="ground" value="{{ old('ground', $batch->ground) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ধারণক্ষমতা *</label>
                            <input type="number" name="capacity" value="{{ old('capacity', $batch->capacity) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">স্ট্যাটাস *</label>
                            <select name="status" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="active" {{ old('status', $batch->status) == 'active' ? 'selected' : '' }}>সক্রিয়</option>
                                <option value="inactive" {{ old('status', $batch->status) == 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow">
                            আপডেট সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

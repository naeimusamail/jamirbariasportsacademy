<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                {{ __('নতুন ট্রেনিং ব্যাচ তৈরি করুন') }}
            </h2>
            <a href="{{ route('batches.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                &larr; ব্যাচ তালিকায় ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="POST" action="{{ route('batches.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">খেলার নাম *</label>
                        <select name="sport_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            <option value="">খেলা নির্বাচন করুন</option>
                            @foreach($sports as $sp)
                                <option value="{{ $sp->id }}" {{ old('sport_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">দায়িত্বপ্রাপ্ত কোচ (অ্যাডমিন কর্তৃক অ্যাসাইনমেন্ট)</label>
                        <select name="coach_id" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            <option value="">কোচ নির্বাচন করুন (Admin Assigned)</option>
                            @foreach($coaches as $c)
                                <option value="{{ $c->id }}" {{ old('coach_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->designation }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ব্যাচের নাম *</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="যেমন: ফুটবল অনূর্ধ্ব-১৬ মর্নিং ব্যাচ" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">অনুশীলনের দিনসমূহ *</label>
                        <input type="text" name="days" value="{{ old('days') }}" placeholder="যেমন: শনি, সোম, বুধ" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">সময়সূচি (Time Slot) *</label>
                        <input type="text" name="time_slot" value="{{ old('time_slot') }}" placeholder="যেমন: সকাল ৬:৩০ - ৮:০০" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">মাঠ / ভেন্যু *</label>
                        <input type="text" name="ground" value="{{ old('ground', 'প্রধান খেলার মাঠ') }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">সর্বোচ্চ ধারণক্ষমতা *</label>
                            <input type="number" name="capacity" value="{{ old('capacity', 25) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">স্ট্যাটাস *</label>
                            <select name="status" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>সক্রিয়</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('batches.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-semibold">
                            বাতিল
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow">
                            ব্যাচ তৈরি করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                {{ __('নতুন একাডেমি নোটিশ প্রকাশ করুন') }}
            </h2>
            <a href="{{ route('notices.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                &larr; নোটিশ বোর্ডে ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="POST" action="{{ route('notices.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">নোটিশের লক্ষ্য / খেলার বিভাগ</label>
                        <select name="sport_id" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            <option value="">সকল প্লেয়ার ও বিভাগের জন্য (সাধারণ)</option>
                            @foreach($sports as $sp)
                                <option value="{{ $sp->id }}" {{ old('sport_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">নোটিশের শিরোনাম *</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="যেমন: টুর্নামেন্টের প্রস্তুতি ম্যাচ ও সময়সূচি" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">প্রকাশের তারিখ *</label>
                        <input type="date" name="notice_date" value="{{ old('notice_date', date('Y-m-d')) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">বিস্তারিত বিবরণ *</label>
                        <textarea name="content" rows="6" placeholder="নোটিশের সম্পূর্ণ বিবরণ এখানে লিখুন..." required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">{{ old('content') }}</textarea>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="is_pinned" id="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <label for="is_pinned" class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                            গুরুত্বপূর্ণ নোটিশ হিসেবে উপরে পিন (Pin) করে রাখুন
                        </label>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('notices.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-semibold">
                            বাতিল
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow">
                            প্রকাশ করুন &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


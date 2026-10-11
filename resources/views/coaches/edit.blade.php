<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                {{ __('কোচ তথ্য পরিবর্তন') }}
            </h2>
            <a href="{{ route('coaches.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                &larr; তালিকায় ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="POST" action="{{ route('coaches.update', $coach) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">খেলার নাম *</label>
                        <select name="sport_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            @foreach($sports as $sp)
                                <option value="{{ $sp->id }}" {{ old('sport_id', $coach->sport_id) == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">কোচের পুরো নাম *</label>
                        <input type="text" name="name" value="{{ old('name', $coach->name) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">পদবী / রোল *</label>
                        <input type="text" name="designation" value="{{ old('designation', $coach->designation) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">মোবাইল নম্বর *</label>
                            <input type="text" name="phone" value="{{ old('phone', $coach->phone) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ইমেইল ঠিকানা</label>
                            <input type="email" name="email" value="{{ old('email', $coach->email) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">কোচিং অভিজ্ঞতা ও যোগ্যতা</label>
                        <textarea name="experience" rows="3" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">{{ old('experience', $coach->experience) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">স্ট্যাটাস *</label>
                        <select name="status" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            <option value="active" {{ old('status', $coach->status) == 'active' ? 'selected' : '' }}>সক্রিয়</option>
                            <option value="inactive" {{ old('status', $coach->status) == 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                        </select>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('coaches.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-semibold">
                            বাতিল
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow">
                            আপডেট সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


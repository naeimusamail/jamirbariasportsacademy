<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(Auth::user()->isPlayer())
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="font-bold text-sm">⚽ প্লেয়ার প্রোফাইল কার্ড সক্রিয়</span>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-0.5">আপনার পারফরম্যান্স, আইডি কার্ড, সার্টিফিকেট এবং ড্রিল রেকর্ড দেখতে প্রোফাইলে যান।</p>
                    </div>
                    <a href="{{ route('profile.player') }}" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow">
                        আমার প্লেয়ার প্রোফাইল ➔
                    </a>
                </div>
            @elseif(Auth::user()->isCoach())
                <div class="p-4 bg-indigo-500/10 border border-indigo-500/30 text-indigo-800 dark:text-indigo-300 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="font-bold text-sm">📋 অফিশিয়াল কোচ প্রোফাইল সক্রিয়</span>
                        <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-0.5">আপনার দায়িত্বপ্রাপ্ত ব্যাচ, প্লেয়ার তালিকা ও ড্রিল হিস্টোরি দেখতে প্রোফাইলে যান।</p>
                    </div>
                    <a href="{{ route('profile.coach') }}" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold shadow">
                        আমার কোচ প্রোফাইল ➔
                    </a>
                </div>
            @elseif(Auth::user()->isScorer())
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-800 dark:text-rose-300 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="font-bold text-sm">🎯 অফিশিয়াল ম্যাচ স্কোরার প্রোফাইল সক্রিয়</span>
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-0.5">আপনার দায়িত্বপ্রাপ্ত ম্যাচ পরিচালনা করতে সরাসরি স্কোরার ড্যাশবোর্ডে প্রবেশ করুন।</p>
                    </div>
                    <a href="{{ route('dashboard.scorer') }}" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold shadow">
                        স্কোরার ড্যাশবোর্ড ➔
                    </a>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

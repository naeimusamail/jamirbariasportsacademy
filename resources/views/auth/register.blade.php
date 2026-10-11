<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-black text-gray-900 dark:text-white">📝 নতুন অ্যাকাউন্ট তৈরি</h2>
        <p class="text-xs text-gray-500">জামিরবাড়িয়া স্পোর্টস একাডেমি পোর্টাল</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('পূর্ণ নাম (Full Name)')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="উদাঃ সাকিবুল ইসলাম" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('ইউজারনেম (Username - ঐচ্ছিক)')" />
            <x-text-input id="username" class="block mt-1 w-full font-mono" type="text" name="username" :value="old('username')" placeholder="উদাঃ sakib2026 (খালি রাখলে স্বয়ংক্রিয়ভাবে তৈরি হবে)" autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('ইমেইল এড্রেস (Email Address)')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="sakib@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('পাসওয়ার্ড (Password)')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('পাসওয়ার্ড নিশ্চিতকরণ (Confirm Password)')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-800">
            <a class="text-xs text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-400 font-semibold" href="{{ route('login') }}">
                {{ __('ইতিমধ্যে অ্যাকাউন্ট আছে? লগইন করুন') }}
            </a>

            <x-primary-button class="bg-emerald-600 hover:bg-emerald-700">
                {{ __('নিবন্ধন সম্পন্ন করুন') }} ➔
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

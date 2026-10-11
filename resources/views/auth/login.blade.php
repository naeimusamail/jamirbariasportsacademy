<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Portal Title & Subtitle -->
    <div class="text-center mb-6">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[11px] font-bold mb-2">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            সেন্ট্রাল অথেনটিকেশন পোর্টাল
        </div>
        <h2 class="text-xl font-black text-white">
            অ্যাকাউন্টে সাইন ইন করুন
        </h2>
        <p class="text-xs text-slate-400 mt-1">
            এডমিন, প্লেয়ার, কোচ অথবা স্কোরার — আপনার তথ্য দিয়ে সরাসরি ড্যাশবোর্ডে প্রবেশ করুন।
        </p>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Username or Email Address -->
        <div x-data="typewriter(['sakib_07', 'tanvir***@gmail.com', 'rahat_khan', 'arif***@yahoo.com', 'naimur_jsa', 'fahim***@gmail.com', 'hasan_2026'])">
            <label for="login" class="block text-xs font-bold text-slate-300 mb-1.5">
                ইউজারনেম অথবা ইমেইল এড্রেস
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-sm">
                    👤
                </div>
                <input id="login" 
                       type="text" 
                       name="login" 
                       value="{{ old('login', old('email', request('username'))) }}"
                       required 
                       autofocus 
                       :placeholder="text + ' ▌'" 
                       @focus="isFocused = true"
                       @blur="isFocused = false"
                       autocomplete="username" 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-950/70 border border-slate-700/80 text-white placeholder-slate-400 text-sm font-medium focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition shadow-inner">
            </div>
            <x-input-error :messages="$errors->get('login') ?: $errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-300">
                    পাসওয়ার্ড
                </label>
                @if (Route::has('password.request'))
                    <a class="text-[11px] font-semibold text-emerald-400 hover:text-emerald-300 hover:underline transition" href="{{ route('password.request') }}">
                        পাসওয়ার্ড ভুলে গেছেন?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-sm">
                    🔒
                </div>
                <input id="password" 
                       :type="show ? 'text' : 'password'" 
                       name="password" 
                       required 
                       placeholder="••••••••" 
                       autocomplete="current-password" 
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-slate-950/70 border border-slate-700/80 text-white placeholder-slate-500 text-sm font-medium focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition shadow-inner">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 text-xs">
                    <span x-show="!show">👁️</span>
                    <span x-show="show" x-cloak>🙈</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember" class="rounded bg-slate-950 border-slate-700 text-emerald-600 shadow-sm focus:ring-emerald-500 focus:ring-offset-slate-900">
                <span class="ms-2 text-slate-400">লগইন মনে রাখুন</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-emerald-900/40 hover:shadow-emerald-900/60 transform active:scale-[0.99] transition duration-200 flex items-center justify-center gap-2">
                <span>লগইন করুন</span>
                <span class="text-base">➔</span>
            </button>
        </div>

        <!-- Back to Website -->
        <div class="pt-4 border-t border-slate-800/80 text-center">
            <a class="text-xs text-slate-400 hover:text-emerald-400 inline-flex items-center gap-1.5 transition font-medium" href="{{ url('/') }}">
                <span>&larr;</span> মূল ওয়েবসাইটে ফিরে যান
            </a>
        </div>
    </form>
</x-guest-layout>

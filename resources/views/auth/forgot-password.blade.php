<x-guest-layout>
    <div x-data="{
        activeTab: '{{ old('tab') === 'username' || $errors->has('username_error') || $errors->has('query') || old('query') || session('recovered_user') || request('tab') === 'username' ? 'username' : 'password' }}'
    }" class="space-y-5">

        <!-- Top Header & Tab Pills -->
        <div class="text-center space-y-1">
            <h2 class="text-xl font-black text-white flex items-center justify-center gap-2">
                <span>🔐</span> {{ __('অ্যাকাউন্ট রিকভারি সেন্টার') }}
            </h2>
            <p class="text-xs text-slate-400">
                পাসওয়ার্ড অথবা ভুলে যাওয়া ইউজারনেম দ্রুত পুনরুদ্ধার করুন
            </p>
        </div>

        <!-- Tab Toggle Buttons -->
        <div class="flex items-center justify-center p-1 bg-slate-950/90 rounded-2xl border border-slate-800">
            <button type="button"
                    @click="activeTab = 'password'"
                    :class="activeTab === 'password' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-400 hover:text-white'"
                    class="flex-1 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                <span>🔑</span> পাসওয়ার্ড ভুলে গেছেন
            </button>
            <button type="button"
                    @click="activeTab = 'username'"
                    :class="activeTab === 'username' ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md' : 'text-slate-400 hover:text-white'"
                    class="flex-1 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                <span>👤</span> ইউজারনেম ভুলে গেছেন
            </button>
        </div>

        <!-- ============================================== -->
        <!-- TAB 1: FORGOT PASSWORD -->
        <!-- ============================================== -->
        <div x-show="activeTab === 'password'" class="space-y-4">
            <div class="text-xs leading-relaxed bg-emerald-500/10 p-3.5 rounded-2xl border border-emerald-500/20 text-emerald-300">
                💡 আপনার অ্যাকাউন্টের নিবন্ধিত <strong>ইমেইল এড্রেস</strong> অথবা <strong>ইউজারনেম</strong> লিখুন। আমরা আপনাকে নতুন পাসওয়ার্ড নির্ধারণ করার নির্দেশনা প্রদান করব।
            </div>

            <!-- Session Status Alert -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="tab" value="password">

                <div x-data="typewriter(['sakib_07', 'tanvir***@gmail.com', 'rahat_khan', 'arif***@yahoo.com', 'naimur_jsa', 'fahim***@gmail.com', 'hasan_2026'])">
                    <label for="email" class="block text-xs font-bold text-slate-300 mb-1.5">
                        ইমেইল অথবা ইউজারনেম
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-sm">
                            👤
                        </div>
                        <input id="email" 
                               type="text" 
                               name="email" 
                               value="{{ old('email') }}"
                               required 
                               autofocus 
                               :placeholder="text + ' ▌'" 
                               @focus="isFocused = true"
                               @blur="isFocused = false"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-950/70 border border-slate-700/80 text-white placeholder-slate-400 text-sm font-medium focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition shadow-inner">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <button type="button" @click="activeTab = 'username'" class="text-xs text-emerald-400 hover:text-emerald-300 hover:underline transition">
                        ইউজারনেম মনে নেই? &rarr;
                    </button>

                    <button type="submit" class="py-2.5 px-5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold rounded-xl text-xs shadow-lg shadow-emerald-900/40 hover:shadow-emerald-900/60 transform active:scale-[0.99] transition flex items-center gap-1.5">
                        <span>রিসেট লিঙ্ক পাঠান</span>
                        <span>➔</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================== -->
        <!-- TAB 2: FORGOT USERNAME (ইউজারনেম রিকভারি) -->
        <!-- ============================================== -->
        <div x-show="activeTab === 'username'" style="display: none;" class="space-y-4">
            <div class="text-xs leading-relaxed bg-indigo-500/10 p-3.5 rounded-2xl border border-indigo-500/20 text-indigo-300">
                🔍 ইউজারনেম মনে না থাকলে আপনার নিবন্ধিত <strong>ইমেইল</strong>, <strong>মোবাইল নম্বর</strong>, অথবা স্টুডেন্ট <strong>ভর্তি আইডি (JSA-xxxx)</strong> দিন। সিস্টেম তাৎক্ষণিক আপনার ইউজারনেম বের করে দেবে।
            </div>

            <!-- Recovered Username Success Result Card -->
            @if(session('recovered_user'))
                <div class="p-5 rounded-3xl bg-slate-900/90 border border-emerald-500/40 text-white space-y-4 shadow-2xl relative overflow-hidden">
                    <div class="flex items-center justify-between border-b border-white/10 pb-2.5">
                        <span class="text-xs font-bold text-emerald-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> ইউজারনেম সফলভাবে পাওয়া গেছে!
                        </span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            {{ session('recovered_user')['role'] }}
                        </span>
                    </div>

                    <!-- Details on Left + Round Photo on Right -->
                    <div class="flex items-center justify-between gap-4">
                        <div class="space-y-2 min-w-0 flex-1">
                            <div>
                                <span class="text-[11px] text-slate-400 uppercase tracking-wider block mb-1">আপনার লগইন ইউজারনেম:</span>
                                <span class="font-mono text-xl sm:text-2xl font-black text-amber-400 tracking-wider bg-slate-950 px-3.5 py-1.5 rounded-xl border border-amber-500/30 inline-block shadow-inner">
                                    {{ session('recovered_user')['username'] }}
                                </span>
                            </div>

                            <div class="text-xs text-slate-300 space-y-0.5 pt-1">
                                <div>নাম: <strong class="text-white">{{ session('recovered_user')['name'] }}</strong></div>
                                <div>ইমেইল: <span class="font-mono text-slate-400 text-[11px]">{{ session('recovered_user')['email'] }}</span></div>
                            </div>
                        </div>

                        <!-- Round Photo on Right -->
                        <div class="relative w-16 h-16 sm:w-20 sm:h-20 rounded-full ring-4 ring-emerald-500/30 p-1 bg-gradient-to-tr from-emerald-600/30 to-teal-500/20 shadow-xl shrink-0">
                            @php
                                $recPhoto = session('recovered_user')['photo'] ?? ('https://ui-avatars.com/api/?name=' . urlencode(session('recovered_user')['name']) . '&background=059669&color=ffffff&bold=true&size=128');
                            @endphp
                            <img src="{{ $recPhoto }}" 
                                 alt="{{ session('recovered_user')['name'] }}" 
                                 class="w-full h-full object-cover rounded-full bg-slate-950">
                            <span class="absolute bottom-1 right-1 w-3.5 h-3.5 rounded-full bg-emerald-400 ring-2 ring-slate-900 shadow"></span>
                        </div>
                    </div>

                    <div class="pt-1">
                        <a href="{{ route('login', ['username' => session('recovered_user')['username']]) }}"
                           class="w-full text-center block py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold rounded-xl text-xs shadow-lg shadow-emerald-900/40 hover:shadow-emerald-900/60 transform active:scale-[0.99] transition duration-200">
                            এই ইউজারনেম দিয়ে লগইন করুন ➔
                        </a>
                    </div>
                </div>
            @endif

            <!-- Recovery Error Message -->
            @if($errors->has('username_error'))
                <div class="p-3 bg-rose-500/10 border border-rose-500/30 text-rose-400 rounded-xl text-xs font-semibold">
                    {{ $errors->first('username_error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('username.recover') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="tab" value="username">

                <div x-data="typewriter(['01712-******', 'JSA-2026-014', 'sakib***@gmail.com', '01834-******', 'JSA-2026-108', 'tanvir***@yahoo.com', '01955-******', 'JSA-2026-057'])">
                    <label for="query" class="block text-xs font-bold text-slate-300 mb-1.5">
                        ইমেইল, মোবাইল নম্বর বা স্টুডেন্ট আইডি (JSA-xxxx)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-sm">
                            🔍
                        </div>
                        <input id="query" 
                               type="text" 
                               name="query" 
                               value="{{ old('query') }}"
                               required 
                               :placeholder="text + ' ▌'" 
                               @focus="isFocused = true"
                               @blur="isFocused = false"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-950/70 border border-slate-700/80 text-white placeholder-slate-400 text-sm font-medium focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-inner">
                    </div>
                    <x-input-error :messages="$errors->get('query')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <button type="button" @click="activeTab = 'password'" class="text-xs text-slate-400 hover:text-emerald-400 hover:underline transition">
                        &larr; পাসওয়ার্ড রিসেট করুন
                    </button>

                    <button type="submit" class="py-2.5 px-5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl text-xs shadow-lg shadow-indigo-900/40 transform active:scale-[0.99] transition flex items-center gap-1.5">
                        <span>ইউজারনেম খুঁজুন</span>
                        <span>🔍</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Back to Login Footer -->
        <div class="text-center pt-4 border-t border-slate-800/80">
            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-400 hover:text-emerald-400 transition">
                &larr; {{ __('লগইন পেজে ফিরে যান') }}
            </a>
        </div>

    </div>
</x-guest-layout>

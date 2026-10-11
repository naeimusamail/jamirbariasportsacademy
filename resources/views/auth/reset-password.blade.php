<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center space-y-1">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[11px] font-bold mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                পাসওয়ার্ড পরিবর্তন
            </div>
            <h2 class="text-xl font-black text-white">
                নতুন পাসওয়ার্ড সেট করুন
            </h2>
            <p class="text-xs text-slate-400">
                আপনার অ্যাকাউন্টের জন্য একটি শক্তিশালী নতুন পাসওয়ার্ড নির্ধারণ করুন।
            </p>

            @php
                $currentUser = $user ?? ($request->email ? \App\Models\User::with(['trainee', 'coach'])->where('email', $request->email)->first() : null);
                $profilePhoto = null;
                if ($currentUser && $currentUser->trainee && !empty($currentUser->trainee->photo)) {
                    $profilePhoto = asset('storage/' . $currentUser->trainee->photo);
                } elseif ($currentUser) {
                    $profilePhoto = 'https://ui-avatars.com/api/?name=' . urlencode($currentUser->name) . '&background=059669&color=ffffff&bold=true&size=128';
                }
            @endphp
            @if($currentUser)
                <div class="pt-2 flex justify-center">
                    <div class="flex flex-col items-center p-4 rounded-3xl bg-slate-950/60 border border-slate-800/80 shadow-2xl w-full max-w-xs">
                        <!-- Round Profile Photo on TOP -->
                        <div class="relative w-16 h-16 sm:w-20 sm:h-20 rounded-full ring-4 ring-emerald-500/30 p-1 bg-gradient-to-tr from-emerald-600/30 to-teal-500/20 shadow-xl shrink-0">
                            <img src="{{ $profilePhoto }}" 
                                 alt="{{ $currentUser->name }}" 
                                 class="w-full h-full object-cover rounded-full bg-slate-900">
                            <span class="absolute bottom-1 right-1 w-3.5 h-3.5 rounded-full bg-emerald-400 ring-2 ring-slate-950 shadow-md"></span>
                        </div>

                        <!-- Full Name BELOW -->
                        <div class="mt-2.5 text-center">
                            <h3 class="text-sm sm:text-base font-black text-white tracking-tight">
                                {{ $currentUser->name }}
                            </h3>
                            <div class="inline-flex items-center gap-1.5 mt-1 px-2.5 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[11px] font-mono text-emerald-400">
                                <span>@<span>{{ $currentUser->username }}</span></span>
                                @if($currentUser->role)
                                    <span class="text-slate-500">•</span>
                                    <span class="font-sans text-[10px] text-emerald-300 font-bold">
                                        {{ match($currentUser->role) {
                                            'admin' => 'এডমিন',
                                            'coach' => 'কোচ',
                                            'player' => 'খেলোয়াড়',
                                            'scorer' => 'স্কোরার',
                                            default => $currentUser->role
                                        } }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <!-- Password Reset Token & Hidden Email -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />

            <!-- New Password -->
            <div x-data="{ show: false }">
                <label for="password" class="block text-xs font-bold text-slate-300 mb-1.5">
                    নতুন পাসওয়ার্ড
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-sm">
                        🔒
                    </div>
                    <input id="password" 
                           :type="show ? 'text' : 'password'" 
                           name="password" 
                           required 
                           autofocus
                           placeholder="কমপক্ষে ৮ অক্ষরের পাসওয়ার্ড" 
                           autocomplete="new-password" 
                           class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-slate-950/70 border border-slate-700/80 text-white placeholder-slate-500 text-sm font-medium focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition shadow-inner">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 text-xs">
                        <span x-show="!show">👁️</span>
                        <span x-show="show" x-cloak>🙈</span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block text-xs font-bold text-slate-300 mb-1.5">
                    নতুন পাসওয়ার্ড নিশ্চিত করুন
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-sm">
                        🔑
                    </div>
                    <input id="password_confirmation" 
                           :type="show ? 'text' : 'password'" 
                           name="password_confirmation" 
                           required 
                           placeholder="পাসওয়ার্ডটি পুনরায় লিখুন" 
                           autocomplete="new-password" 
                           class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-slate-950/70 border border-slate-700/80 text-white placeholder-slate-500 text-sm font-medium focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition shadow-inner">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 text-xs">
                        <span x-show="!show">👁️</span>
                        <span x-show="show" x-cloak>🙈</span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-emerald-900/40 hover:shadow-emerald-900/60 transform active:scale-[0.99] transition duration-200 flex items-center justify-center gap-2">
                    <span>পাসওয়ার্ড পরিবর্তন সম্পন্ন করুন</span>
                    <span class="text-base">➔</span>
                </button>
            </div>

            <!-- Back to Login -->
            <div class="pt-4 border-t border-slate-800/80 text-center">
                <a class="text-xs text-slate-400 hover:text-emerald-400 inline-flex items-center gap-1.5 transition font-medium" href="{{ route('login') }}">
                    <span>&larr;</span> লগইন পেজে ফিরে যান
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>

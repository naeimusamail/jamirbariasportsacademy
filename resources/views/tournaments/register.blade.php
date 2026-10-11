<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>টুর্নামেন্টে খেলোয়াড় নিবন্ধন | {{ $tournament->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-amber-500 selection:text-slate-950">

    <!-- Top Navbar -->
    <header class="border-b border-slate-800/80 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <a href="{{ route('public.tournaments.show', $tournament->slug) }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-rose-500 flex items-center justify-center text-slate-950 font-black text-xl shadow">
                    🏆
                </div>
                <div>
                    <span class="text-base font-black tracking-tight text-white block">{{ $tournament->name }}</span>
                    <span class="text-[10px] text-amber-400 font-bold block">&larr; টুর্নামেন্ট পেইজে ফিরুন</span>
                </div>
            </a>

            <div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                    রেজিস্ট্রেশন ফরম
                </span>
            </div>
        </div>
    </header>

    <main class="py-10 px-4 sm:px-6 max-w-3xl mx-auto space-y-8" x-data="{ accountAction: 'register', hasTeam: 'no' }">

        <!-- Tournament Info Header -->
        <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-white/10 text-white">
                    {{ $tournament->sport_type }}
                </span>
                <span class="text-xs text-slate-400">
                    ভেন্যু: <strong class="text-white">{{ $tournament->venue }}</strong>
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-black text-white">
                টুর্নামেন্টে খেলোয়াড় নিবন্ধন (Player Registration)
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-800 text-xs">
                <div>
                    <span class="text-slate-400 block text-[10px]">টুর্নামেন্ট সময়সূচি:</span>
                    <span class="font-mono text-white">{{ $tournament->start_date ? $tournament->start_date->format('d M, Y') : '-' }} হতে {{ $tournament->end_date ? $tournament->end_date->format('d M, Y') : '-' }}</span>
                </div>
                @if($tournament->registration_deadline)
                    <div>
                        <span class="text-amber-400 block text-[10px] font-bold">রেজিস্ট্রেশনের শেষ সময়:</span>
                        <span class="font-mono text-amber-300 font-bold">⏰ {{ $tournament->registration_deadline->format('d M, Y - h:i A') }}</span>
                    </div>
                @endif
            </div>

            <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-xs text-emerald-300 space-y-1">
                <div class="font-bold flex items-center gap-1.5">
                    <span>💡</span> গুরুত্বপূর্ণ তথ্য:
                </div>
                <p>• যাদের কোনো দল নেই, তারা <strong>"দল ছাড়া / কোনো দল নেই"</strong> অপশন সিলেক্ট করে এককভাবে নিবন্ধন করতে পারবেন।</p>
                <p>• সিলেকশন বা ড্রাফটের সময় টুর্নামেন্ট অ্যাডমিন আপনাকে যেকোনো দলে অন্তর্ভুক্ত করে দেবেন।</p>
                <p>• টুর্নামেন্টে নিবন্ধনের জন্য প্লেয়ার অ্যাকাউন্ট প্রয়োজন। অ্যাকাউন্ট না থাকলে নিচের ফর্ম পূরণ করলে স্বয়ংক্রিয়ভাবে তৈরি হয়ে যাবে।</p>
            </div>
        </div>

        @if($errors->any())
            <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-300 rounded-2xl text-xs space-y-1">
                <div class="font-bold">অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</div>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-300 rounded-2xl text-xs font-bold">
                {{ session('error') }}
            </div>
        @endif

        <!-- Registration Form -->
        <form action="{{ route('public.tournaments.register.store', $tournament->slug) }}" method="POST" class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
            @csrf

            <!-- 1. Player Account Verification / Setup -->
            @auth
                <div class="p-4 bg-slate-800/80 rounded-2xl border border-slate-700/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-slate-950 font-black flex items-center justify-center text-sm">
                            {{ mb_substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">লগইনকৃত অ্যাকাউন্ট:</div>
                            <div class="text-sm font-bold text-white">{{ auth()->user()->name }} ({{ auth()->user()->role }})</div>
                            <div class="text-[11px] text-slate-400 font-mono">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        যাচাইকৃত প্লেয়ার
                    </span>
                </div>
            @else
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                        <h3 class="font-bold text-sm text-white flex items-center gap-2">
                            <span>🔑</span> প্লেয়ার অ্যাকাউন্ট এক্সেস
                        </h3>
                        <div class="flex items-center gap-2 bg-slate-800 p-1 rounded-xl text-xs font-bold">
                            <button type="button" @click="accountAction = 'register'" :class="accountAction === 'register' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white'" class="px-3 py-1 rounded-lg transition">
                                নতুন অ্যাকাউন্ট
                            </button>
                            <button type="button" @click="accountAction = 'login'" :class="accountAction === 'login' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white'" class="px-3 py-1 rounded-lg transition">
                                পূর্বের লগইন
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="account_action" :value="accountAction">

                    <!-- Login Form Section -->
                    <div x-show="accountAction === 'login'" class="space-y-4 p-4 bg-slate-950/60 rounded-2xl border border-slate-800" style="display: none;">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">ইমেইল অথবা ইউজারনেম *</label>
                            <input type="text" name="login_email" value="{{ old('login_email') }}" placeholder="ইমেইল বা ইউজারনেম লিখুন"
                                class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">পাসওয়ার্ড *</label>
                            <input type="password" name="login_password" placeholder="আপনার অ্যাকাউন্টের পাসওয়ার্ড"
                                class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                        </div>
                    </div>

                    <!-- New Player Account Section -->
                    <div x-show="accountAction === 'register'" class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-slate-950/60 rounded-2xl border border-slate-800">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-1">ইমেইল এড্রেস *</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com"
                                class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">পাসওয়ার্ড *</label>
                            <input type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর"
                                class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">পাসওয়ার্ড নিশ্চিত করুন *</label>
                            <input type="password" name="password_confirmation" placeholder="পাসওয়ার্ড পুনরায় লিখুন"
                                class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-1">ইউজারনেম (ঐচ্ছিক)</label>
                            <input type="text" name="username" value="{{ old('username') }}" placeholder="যেমন: shakib75"
                                class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                        </div>
                    </div>
                </div>
            @endauth

            <!-- 2. Player Information Section -->
            <div class="space-y-4 pt-4 border-t border-slate-800">
                <h3 class="font-bold text-sm text-white flex items-center gap-2">
                    <span>🏃</span> খেলোয়াড়ের ব্যক্তিগত তথ্য
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">খেলোয়াড়ের পূর্ণ নাম *</label>
                        <input type="text" name="player_name" value="{{ old('player_name', auth()->user()?->name) }}" required placeholder="আপনার পূর্ণ নাম"
                            class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">মোবাইল নম্বর *</label>
                        <input type="tel" name="player_phone" value="{{ old('player_phone') }}" required placeholder="017xxxxxxxx"
                            class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">খেলার পজিশন / রোল</label>
                        <input type="text" name="position" value="{{ old('position') }}" placeholder="যেমন: স্ট্রাইকার, অলরাউন্ডার, ডিফেন্ডার, ওপেনার"
                            class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">পছন্দের জার্সি নম্বর (ঐচ্ছিক)</label>
                        <input type="text" name="jersey_no" value="{{ old('jersey_no') }}" placeholder="যেমন: 7, 10, 75"
                            class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                    </div>
                </div>
            </div>

            <!-- 3. Team Selection / Free Agent Option -->
            <div class="space-y-4 pt-4 border-t border-slate-800">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-sm text-white flex items-center gap-2">
                        <span>🛡️</span> দলীয় তথ্য (টিম সিলেকশন)
                    </h3>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-semibold text-slate-300">আপনার কি কোনো নির্দিষ্ট দল রয়েছে?</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="p-3 rounded-2xl border cursor-pointer flex items-center gap-3 transition"
                            :class="hasTeam === 'no' ? 'bg-amber-500/10 border-amber-500 text-amber-300 font-bold' : 'bg-slate-950 border-slate-800 text-slate-400'">
                            <input type="radio" x-model="hasTeam" value="no" class="text-amber-500 focus:ring-amber-500">
                            <div>
                                <div class="text-xs">দল ছাড়া / কোনো দল নেই (Free Agent)</div>
                                <div class="text-[10px] text-slate-400 font-normal">অ্যাডমিন সিলেকশনের মাধ্যমে আপনাকে উপযুক্ত দলে যুক্ত করবেন</div>
                            </div>
                        </label>

                        <label class="p-3 rounded-2xl border cursor-pointer flex items-center gap-3 transition"
                            :class="hasTeam === 'yes' ? 'bg-emerald-500/10 border-emerald-500 text-emerald-300 font-bold' : 'bg-slate-950 border-slate-800 text-slate-400'">
                            <input type="radio" x-model="hasTeam" value="yes" class="text-emerald-500 focus:ring-emerald-500">
                            <div>
                                <div class="text-xs">আমার নির্দিষ্ট দল রয়েছে</div>
                                <div class="text-[10px] text-slate-400 font-normal">টুর্নামেন্টের অন্তর্ভুক্ত যেকোনো একটি দল নির্বাচন করুন</div>
                            </div>
                        </label>
                    </div>

                    <!-- Team dropdown (only shown if hasTeam is 'yes') -->
                    <div x-show="hasTeam === 'yes'" class="pt-2" style="display: none;">
                        <label class="block text-xs font-semibold text-slate-300 mb-1">টুর্নামেন্টের দল নির্বাচন করুন *</label>
                        <select name="team_id" class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">
                            <option value="">-- দল বেছে নিন --</option>
                            @foreach($teams as $t)
                                <option value="{{ $t->id }}" {{ old('team_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }} ({{ $t->category }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-2">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">বিশেষ নোট বা পূর্বের অভিজ্ঞতা (ঐচ্ছিক)</label>
                    <textarea name="notes" rows="2" placeholder="আপনার অতীতের পারফরম্যান্স বা কোনো তথ্য..."
                        class="w-full text-xs rounded-xl bg-slate-900 border-slate-700 text-white focus:border-amber-500 focus:ring-amber-500">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                <a href="{{ route('public.tournaments.show', $tournament->slug) }}" class="text-xs text-slate-400 hover:text-white">
                    বাতিল করুন
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black rounded-xl text-xs sm:text-sm transition shadow-lg shadow-amber-500/20">
                    নিবন্ধন সম্পূর্ণ করুন &rarr;
                </button>
            </div>
        </form>

    </main>

</body>
</html>


<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>স্কোরার অ্যাক্সেস পিন কোড যাচাই | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#070d14] text-slate-100 min-h-screen flex flex-col justify-between selection:bg-rose-500 selection:text-white sports-turf-mesh">

    <!-- Top Navigation -->
    <header class="border-b border-slate-800/80 bg-slate-900/60 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-rose-500 font-black text-lg">
                <span class="text-2xl">⚽</span>
                <span class="text-white">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('live.show', $match->slug) }}" target="_blank" class="text-xs text-slate-300 hover:text-white flex items-center gap-1">
                    <span>লাইভ ভিউ</span> ↗
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white rounded-lg text-xs font-bold transition">
                        ড্যাশবোর্ড
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs text-slate-300 hover:text-white">
                        লগইন
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main PIN Verification Section -->
    <main class="max-w-md mx-auto w-full px-4 py-12 flex-1 flex flex-col justify-center">
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-rose-950/30 backdrop-blur-md relative overflow-hidden">
            <!-- Glow background effect -->
            <div class="absolute -top-20 -right-20 w-44 h-44 bg-rose-600/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-44 h-44 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="text-center space-y-2 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-rose-600 to-amber-500 text-white mx-auto flex items-center justify-center text-3xl shadow-lg shadow-rose-600/30">
                    🔑
                </div>
                <h1 class="text-xl font-black text-white pt-2">অফিশিয়াল স্কোরার ভেরিফিকেশন</h1>
                <p class="text-xs text-slate-400">
                    এই ম্যাচের স্কোর আপডেট করতে এডমিন কর্তৃক নির্ধারিত স্কোরার পিন বা সিক্রেট কোড প্রদান করুন।
                </p>
            </div>

            <!-- Match Preview Card -->
            <div class="bg-slate-950/70 border border-slate-800 rounded-2xl p-4 mb-6 space-y-2 text-center">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-rose-400 bg-rose-500/10 px-2.5 py-0.5 rounded-full border border-rose-500/20">
                    {{ $match->sport_type == 'cricket' ? '🏏 ক্রিকেট ম্যাচ' : ($match->sport_type == 'football' ? '⚽ ফুটবল ম্যাচ' : '🏸 টুর্নামেন্ট ম্যাচ') }}
                </span>
                <h2 class="text-sm font-black text-white">{{ $match->title }}</h2>
                <div class="text-xs font-semibold text-slate-300 flex items-center justify-center gap-2">
                    <span class="text-emerald-400 font-bold">{{ $match->team_a }}</span>
                    <span class="text-rose-500 font-extrabold text-[10px]">VS</span>
                    <span class="text-cyan-400 font-bold">{{ $match->team_b }}</span>
                </div>
                <div class="text-[11px] text-slate-400 pt-1">
                    মাঠ: {{ $match->venue }}
                </div>
            </div>

            @if($errors->has('scorer_code'))
                <div class="mb-4 p-3 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-300 text-xs font-bold text-center">
                    ❌ {{ $errors->first('scorer_code') }}
                </div>
            @endif

            @if($match->status === 'finished')
                <div class="p-5 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-center space-y-3">
                    <div class="text-3xl">🔒</div>
                    <h3 class="text-sm font-black text-rose-400 uppercase tracking-wide">স্কোরার পিন মেয়াদোত্তীর্ণ (PIN Expired)</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        এই ম্যাচটি ইতিমধ্যে সমাপ্ত হয়ে গেছে। একাডেমি অফিশিয়াল নিয়ম অনুযায়ী ম্যাচ সমাপ্ত হওয়ার পর স্কোরার পিনের কার্যকারিতা স্বয়ংক্রিয়ভাবে বাতিল হয়ে যায়। সমাপ্ত ম্যাচের কোনো তথ্য কেবলমাত্র একাডেমি এডমিন সম্পাদনা করতে পারবেন।
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('live.show', $match->slug) }}" class="inline-block px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition">
                            ← লাইভ ম্যাচ পেজে ফিরে যান
                        </a>
                    </div>
                </div>
            @else
                <!-- Form -->
                <form method="POST" action="{{ route('scorer.verify-pin', $match->slug) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1.5 text-center">
                            ম্যাচ স্কোরার পিন / কোড (Scorer PIN Code) *
                        </label>
                        <input type="text" name="scorer_code" value="{{ old('scorer_code', request('code')) }}" placeholder="যেমন: K92J1A" autofocus required class="w-full text-center text-xl font-mono font-black tracking-widest uppercase py-3 rounded-xl bg-slate-950 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-rose-500 placeholder-slate-600">
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-500 hover:to-rose-600 text-white font-black text-sm rounded-xl shadow-lg shadow-rose-600/30 transition transform active:scale-95 flex items-center justify-center gap-2">
                        <span>ভেরিফাই করুন ও স্কোরিং শুরু করুন</span> &rarr;
                    </button>
                </form>
            @endif

            <div class="mt-6 pt-4 border-t border-slate-800 text-center text-xs text-slate-400 space-y-2">
                <p>আপনার কাছে কি নির্ধারিত স্কোরার অ্যাকাউন্ট আছে?</p>
                <a href="{{ route('login') }}" class="inline-block text-rose-400 hover:underline font-bold">
                    স্কোরার লগইন পেজে যান &rarr;
                </a>
            </div>
        </div>
    </main>

    <footer class="border-t border-slate-800/80 py-4 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} জামিরবাড়িয়া স্পোর্টস একাডেমি • লাইভ ম্যাচ ও ডিজিটাল স্কোরার সিস্টেম
    </footer>

</body>
</html>

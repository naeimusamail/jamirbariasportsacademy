<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $trainee->name }} — অফিসিয়াল প্লেয়ার ভেরিফিকেশন | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Hind Siliguri', 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-white min-h-screen flex flex-col justify-between selection:bg-emerald-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <header class="border-b border-white/10 bg-slate-900/60 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <span class="text-2xl">⚽</span>
                <div>
                    <h1 class="text-sm font-black text-white uppercase tracking-wider">জামিরবাড়িয়া স্পোর্টস একাডেমি</h1>
                    <p class="text-[9px] text-emerald-400 font-bold uppercase tracking-widest">OFFICIAL PLAYER VERIFICATION</p>
                </div>
            </a>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    যাচাইকৃত ডেটাবেজ
                </span>
            </div>
        </div>
    </header>

    <!-- Main Verification Shield Canvas -->
    <main class="max-w-3xl mx-auto px-4 py-12 w-full">
        <div class="relative bg-gradient-to-b from-slate-900 via-slate-900/90 to-slate-950 rounded-3xl p-6 sm:p-10 border border-emerald-500/30 shadow-2xl overflow-hidden">
            
            <!-- Glow background -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Verification Badge Ribbon -->
            <div class="text-center pb-6 border-b border-white/10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-bold mb-3">
                    <span class="text-emerald-400">✓</span> অফিসিয়াল অনুমোদিত প্লেয়ার রেকর্ড (AUTHENTIC PLAYER)
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-white">
                    জামিরবাড়িয়া স্পোর্টস একাডেমি প্লেয়ার ভেরিফিকেশন
                </h2>
                <p class="text-xs text-gray-400 mt-1">
                    ডিজিটাল আইডি কার্ডের কিউআর কোড স্ক্যান করার মাধ্যমে এই তথ্য সরাসরি একাডেমির সার্ভার থেকে সংগৃহীত হয়েছে।
                </p>
            </div>

            <!-- Player Profile Spotlight -->
            <div class="mt-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 bg-white/5 rounded-2xl p-6 border border-white/10">
                <!-- 300x300 Image Frame -->
                <div class="w-32 h-32 rounded-2xl p-1 bg-gradient-to-tr from-amber-400 to-emerald-400 shadow-xl shrink-0 overflow-hidden">
                    <div class="w-full h-full rounded-xl bg-slate-950 overflow-hidden flex items-center justify-center">
                        @if($trainee->photo)
                            <img src="{{ asset('storage/' . $trainee->photo) }}" alt="{{ $trainee->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-black text-emerald-400">{{ mb_substr($trainee->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Info Column -->
                <div class="text-center sm:text-left flex-1 space-y-2">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold border border-emerald-400/30">
                            {{ $trainee->sport->name ?? 'অ্যাথলেটিক্স' }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-bold border border-amber-400/30">
                            {{ $trainee->category }}
                        </span>
                        @if($trainee->jersey_no)
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-white font-mono text-[10px] font-bold">
                                জার্সি #{{ $trainee->jersey_no }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-2xl font-black text-white">{{ $trainee->name }}</h3>
                    <p class="text-xs text-gray-300">পজিশন / ভূমিকা: <strong class="text-white">{{ $trainee->position ?? 'প্লেয়ার' }}</strong></p>

                    <div class="pt-2 flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs font-mono">
                        <div>
                            <span class="text-gray-400 block text-[10px]">অফিসিয়াল আইডি:</span>
                            <span class="font-bold text-emerald-400 text-sm">{{ $trainee->admission_no }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px]">স্ট্যাটাস:</span>
                            @if($trainee->status === 'active')
                                <span class="text-emerald-400 font-bold">● সক্রিয় (ACTIVE)</span>
                            @else
                                <span class="text-gray-400">নিষ্ক্রিয়</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Credentials Grid -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-white/5 border border-white/5 space-y-1">
                    <span class="text-gray-400 text-[10px] block">রক্তের গ্রুপ (Blood Group):</span>
                    <span class="font-bold text-rose-400 text-sm font-mono">{{ $trainee->blood_group ?? 'রেকর্ডে নেই' }}</span>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/5 space-y-1">
                    <span class="text-gray-400 text-[10px] block">ভর্তির সেশন ও তারিখ:</span>
                    <span class="font-bold text-white text-sm">{{ \Carbon\Carbon::parse($trainee->admission_date)->format('d M, Y') }}</span>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/5 space-y-1">
                    <span class="text-gray-400 text-[10px] block">নির্ধারিত ব্যাচ:</span>
                    <span class="font-bold text-white text-sm">{{ $trainee->batch->name ?? 'নিয়মিত প্রশিক্ষণ স্কোয়াড' }}</span>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/5 space-y-1">
                    <span class="text-gray-400 text-[10px] block">যাচাইকরণ সময়কাল:</span>
                    <span class="font-mono text-emerald-300 text-xs">{{ now()->format('d M, Y - h:i A') }} (সরাসরি ভেরিফায়েড)</span>
                </div>
            </div>

            <!-- Academy Guarantee Footer -->
            <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-gray-400">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🏛️</span>
                    <div>
                        <div class="font-bold text-white">জামিরবাড়িয়া স্পোর্টস একাডেমি কার্যালয়</div>
                        <div class="text-[10px]">জামিরবাড়িয়া, ময়মনসিংহ • হেল্পলাইন: +৮৮০ ১৭০০-০০০০০০</div>
                    </div>
                </div>

                <a href="{{ url('/') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition">
                    একাডেমি হোমপেজ
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 border-t border-white/10 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} জামিরবাড়িয়া স্পোর্টস একাডেমি (Jamirbaria Sports Academy). সর্বস্বত্ব সংরক্ষিত।
    </footer>

</body>
</html>


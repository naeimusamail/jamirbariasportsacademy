<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>লোকাল প্লেয়ার টুর্নামেন্ট পাস | {{ $player->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body { background: white !important; color: black !important; padding: 0 !important; }
            .no-print { display: none !important; }
            .print-card { box-shadow: none !important; border: 2px solid #0f172a !important; margin: 0 auto !important; }
        }
    </style>
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen py-10 px-4 flex flex-col items-center justify-center selection:bg-amber-500 selection:text-slate-950">

    <!-- Top Navigation / Actions -->
    <div class="max-w-md w-full mb-6 flex items-center justify-between no-print">
        <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-semibold">
            &larr; হোমপেইজে ফিরুন
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs shadow flex items-center gap-1.5 transition">
                <span>🖨️</span>
                <span>প্রিন্ট / ডাউনলোড</span>
            </button>
            <a href="{{ route('public.tournaments.index') }}" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-semibold transition">
                টুর্নামেন্ট সমূহ &rarr;
            </a>
        </div>
    </div>

    <!-- Official Tournament Player Pass / Card (CR-80 Badge Size Ratio) -->
    <div class="max-w-md w-full bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 border-2 border-amber-500/60 rounded-3xl p-6 sm:p-7 shadow-2xl relative overflow-hidden print-card">
        <!-- Stadium glow accent -->
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-amber-500/20 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Card Header -->
        <div class="flex items-center justify-between border-b border-amber-500/30 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center text-slate-950 font-black text-xl shadow">
                    🏆
                </div>
                <div>
                    <h3 class="font-black text-sm text-white uppercase tracking-tight">জামিরবাড়িয়া স্পোর্টস একাডেমি</h3>
                    <p class="text-[9px] uppercase tracking-widest text-amber-400 font-bold">OFFICIAL TOURNAMENT PLAYER PASS</p>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-black bg-amber-500/20 text-amber-300 border border-amber-500/40">
                লোকাল প্লেয়ার
            </span>
        </div>

        <!-- Player Main Profile -->
        <div class="mt-5 flex items-center gap-4">
            <!-- 300x300 proportion Athlete Photo -->
            <div class="w-24 h-24 rounded-2xl bg-slate-800 border-2 border-amber-400 overflow-hidden shrink-0 shadow-lg flex items-center justify-center">
                @if($player->photo)
                    <img src="{{ asset('storage/' . $player->photo) }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-4xl font-black text-amber-400">{{ mb_substr($player->name, 0, 1) }}</span>
                @endif
            </div>

            <!-- Basic Details -->
            <div class="space-y-1">
                <h4 class="font-black text-lg text-white leading-tight">{{ $player->name }}</h4>
                <div class="text-xs text-amber-300 font-semibold flex items-center gap-1.5">
                    <span>🛡️ দল / এলাকা:</span>
                    <strong class="text-white">{{ $player->organization_or_area ?? 'লোকাল প্লেয়ার' }}</strong>
                </div>
                <div class="text-[11px] text-slate-300">
                    পজিশন: <strong class="text-white">{{ $player->position ?? 'প্লেয়ার' }}</strong>
                    @if($player->jersey_no)
                        <span class="ml-1 text-amber-400 font-bold">#{{ $player->jersey_no }}</span>
                    @endif
                </div>
                <div class="text-[10px] text-slate-400 font-mono">
                    ক্যাটাগরি: <strong class="text-slate-200">{{ $player->category }}</strong>
                </div>
            </div>
        </div>

        <!-- Multi-Sports Enrolled -->
        <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between">
            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">টুর্নামেন্ট স্পোর্টস:</span>
            <div class="flex flex-wrap gap-1.5">
                @foreach($player->sports as $sp)
                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-amber-500/10 text-amber-300 border border-amber-500/30 flex items-center gap-1">
                        <span>{{ $sp->icon ?? '⚽' }}</span>
                        <span>{{ $sp->name }}</span>
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Pass Meta Grid & QR Code -->
        <div class="mt-4 pt-3 border-t border-slate-800 grid grid-cols-3 gap-2 items-center">
            <div class="col-span-2 space-y-1 text-[11px]">
                <div>
                    <span class="text-[10px] text-slate-400 block">প্লেয়ার পাস নম্বর:</span>
                    <strong class="font-mono text-amber-300 font-bold text-xs">{{ $player->admission_no }}</strong>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 block">মোবাইল:</span>
                    <span class="font-mono text-slate-200">{{ $player->phone }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 block">রক্তের গ্রুপ:</span>
                    <span class="font-mono font-bold text-rose-400">{{ $player->blood_group ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- QR Code -->
            <div class="flex flex-col items-center justify-center p-2 bg-white rounded-xl shrink-0">
                <div class="w-20 h-20 flex items-center justify-center">
                    {!! $qrCodeSvg !!}
                </div>
                <span class="text-[8px] font-bold text-slate-900 uppercase mt-0.5 tracking-tighter">QR VERIFIED</span>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="mt-5 pt-3 border-t border-amber-500/20 text-center text-[9px] text-slate-400">
            এই পাস প্রদর্শন করে খেলোয়াড় একাডেমি পরিচালিত যেকোনো অনুমোদিত টুর্নামেন্টে অংশ নিতে পারবেন।
        </div>
    </div>

    <!-- Confirmation / Success Alert -->
    <div class="max-w-md w-full mt-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs text-center space-y-1 no-print">
        <strong class="font-bold block">✓ সফলভাবে সংরক্ষিত হয়েছে!</strong>
        <p>আপনার টুর্নামেন্ট প্লেয়ার কার্ডটি ফোনে সেভ করে রাখুন বা প্রিন্ট করে রাখুন।</p>
    </div>

</body>
</html>

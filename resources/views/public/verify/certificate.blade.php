<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সনদপত্র সত্যতা যাচাই — {{ $certificate->certificate_no }} | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Hind+Siliguri:wght@400;500;600;700;800&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Hind Siliguri', 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-white min-h-screen flex flex-col justify-between selection:bg-amber-500 selection:text-slate-950">

    <!-- Top Navigation Bar -->
    <header class="border-b border-white/10 bg-slate-900/60 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <span class="text-2xl">⚽</span>
                <div>
                    <h1 class="text-sm font-black text-white uppercase tracking-wider">জামিরবাড়িয়া স্পোর্টস একাডেমি</h1>
                    <p class="text-[9px] text-amber-400 font-bold uppercase tracking-widest">OFFICIAL CERTIFICATE VERIFICATION</p>
                </div>
            </a>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    অনুমোদিত সনদপত্র
                </span>
            </div>
        </div>
    </header>

    <!-- Main Verification Canvas -->
    <main class="max-w-3xl mx-auto px-4 py-12 w-full">
        <div class="relative bg-gradient-to-b from-slate-900 via-slate-900/90 to-slate-950 rounded-3xl p-6 sm:p-10 border border-amber-500/30 shadow-2xl overflow-hidden">
            
            <!-- Glow background -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Verified Badge Banner -->
            <div class="text-center pb-6 border-b border-white/10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-bold mb-3">
                    <span class="text-emerald-400 font-black">✓</span> ভেরিফায়েড আসল সনদপত্র (OFFICIALLY VERIFIED CERTIFICATE)
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-white">
                    {{ $certificate->title }}
                </h2>
                <p class="text-xs text-amber-300 font-mono mt-1 font-bold">
                    সনদপত্র ট্র্যাকিং আইডি: {{ $certificate->certificate_no }}
                </p>
            </div>

            <!-- Recipient Player Spotlight -->
            <div class="mt-8 bg-white/5 rounded-2xl p-6 border border-white/10 space-y-4">
                <div class="flex flex-col sm:flex-row items-center gap-5">
                    <div class="w-24 h-24 rounded-2xl p-1 bg-gradient-to-tr from-amber-400 to-emerald-400 shadow-xl shrink-0 overflow-hidden">
                        <div class="w-full h-full rounded-xl bg-slate-950 overflow-hidden flex items-center justify-center">
                            @if($certificate->trainee->photo)
                                <img src="{{ asset('storage/' . $certificate->trainee->photo) }}" alt="{{ $certificate->trainee->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-black text-amber-400">{{ mb_substr($certificate->trainee->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="text-center sm:text-left flex-1 space-y-1">
                        <span class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">সনদপত্র অর্জনকারী খেলোয়াড়:</span>
                        <h3 class="text-2xl font-black text-white">{{ $certificate->trainee->name }}</h3>
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 text-xs">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-bold">
                                খেলা: {{ $certificate->sport->name ?? $certificate->trainee->sport->name ?? 'অ্যাথলেটিক্স' }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-gray-300 font-mono">
                                আইডি: {{ $certificate->trainee->admission_no }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-bold">
                                {{ $certificate->type_name }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Citation Quote -->
                <div class="p-4 rounded-xl bg-black/40 border border-amber-500/20 text-xs text-amber-100 italic leading-relaxed text-center sm:text-left">
                    "{{ $certificate->description }}"
                </div>
            </div>

            <!-- Certificate Verification Data Grid -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-white/5 border border-white/5 space-y-1">
                    <span class="text-gray-400 text-[10px] block">কোর্স বা ইভেন্ট:</span>
                    <span class="font-bold text-white text-sm">{{ $certificate->event_or_course ?? 'জামিরবাড়িয়া স্পোর্টস একাডেমি প্রশিক্ষণ' }}</span>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/5 space-y-1">
                    <span class="text-gray-400 text-[10px] block">অর্জিত স্থান / ফলাফল:</span>
                    <span class="font-bold text-amber-300 text-sm">{{ $certificate->grade_or_rank ?? 'সাফল্যের সাথে সমাপ্ত' }}</span>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/5 space-y-1">
                    <span class="text-gray-400 text-[10px] block">ইস্যুর তারিখ:</span>
                    <span class="font-bold text-white text-sm">{{ $certificate->issue_date->format('d F, Y') }}</span>
                </div>

                <div class="p-4 rounded-xl bg-white/5 border border-white/5 space-y-1">
                    <span class="text-gray-400 text-[10px] block">ইস্যুকারী কর্তৃপক্ষ:</span>
                    <span class="font-bold text-emerald-400 text-sm">{{ $certificate->instructor_name }}</span>
                </div>
            </div>

            <!-- Academy Guarantee Footer -->
            <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-gray-400">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🏛️</span>
                    <div>
                        <div class="font-bold text-white">জামিরবাড়িয়া স্পোর্টস একাডেমি রেজিস্ট্রি</div>
                        <div class="text-[10px]">এই সনদপত্রটি একটি বৈধ সরকারি অনুমোদিত ডিজিটাল কপি।</div>
                    </div>
                </div>

                <a href="{{ url('/') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-xs transition">
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


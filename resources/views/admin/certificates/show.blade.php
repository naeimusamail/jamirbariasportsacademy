<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>📜</span> {{ $certificate->title }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    সনদ নং: <span class="font-mono font-bold text-amber-600">{{ $certificate->certificate_no }}</span> • প্রাপক: <strong class="text-gray-800 dark:text-gray-200">{{ $certificate->trainee->name }}</strong>
                </p>
            </div>
            <div class="flex items-center gap-2 no-print">
                <button onclick="window.print()" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-amber-600/30 flex items-center gap-2 transition">
                    <span>🖨️ সনদপত্র প্রিন্ট / PDF</span>
                </button>
                <a href="{{ route('admin.certificates.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                    &larr; সনদপত্র তালিকা
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Certificate Specific & Print Stylesheet -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;900&family=Great+Vibes&family=Hind+Siliguri:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,900;1,700&display=swap');

        .cert-font-serif {
            font-family: 'Cinzel', 'Playfair Display', serif;
        }
        .cert-font-script {
            font-family: 'Great Vibes', cursive;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }
            body {
                background: white !important;
                color: #1a1a1a !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print, header, nav, footer {
                display: none !important;
            }
            .cert-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
                width: 100vw !important;
                height: 100vh !important;
                max-width: none !important;
                border-radius: 0 !important;
            }
        }
    </style>

    <div class="py-8" x-data="{ copied: false }">
        <div class="max-w-6xl mx-auto px-4 space-y-6">

            <!-- Action Toolbar (No Print) -->
            <div class="no-print bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🖨️</span>
                    <div>
                        <div class="text-xs font-bold text-gray-800 dark:text-gray-200">A4 ল্যান্ডস্কেপ প্রিন্ট ফরম্যাট</div>
                        <div class="text-[11px] text-gray-500">কালার প্রিন্টারে স্ট্যান্ডার্ড A4 পেপারে শতভাগ নিঁখুত রেজোলিউশনে প্রিন্ট হবে</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="navigator.clipboard.writeText('{{ $verifyUrl }}'); copied = true; setTimeout(() => copied = false, 2500)" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition">
                        <span x-text="copied ? '✓ লিংক কপি হয়েছে' : '🔗 ভেরিফিকেশন লিংক'"></span>
                    </button>
                    <a href="{{ $verifyUrl }}" target="_blank" class="px-3.5 py-2 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-xs font-bold transition">
                        পাবলিক ভেরিফিকেশন পেজ ↗
                    </a>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- 📜 HIGH-RESOLUTION CERTIFICATE CANVAS (A4 Landscape) -->
            <!-- ======================================================== -->
            <div class="flex justify-center overflow-x-auto py-2">
                <div class="cert-wrapper w-[1050px] min-h-[720px] bg-[#fbf9f4] text-slate-900 rounded-3xl shadow-2xl p-8 relative overflow-hidden border-[12px] border-[#c29b38] select-none">
                    
                    <!-- Inner Ornamental Borders -->
                    <div class="w-full h-full border-4 border-emerald-900/80 rounded-xl p-8 relative flex flex-col justify-between bg-gradient-to-br from-[#ffffff] via-[#fbf9f5] to-[#f4eee1]">
                        
                        <!-- Watermark Academy Crest in Background -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-[0.04] pointer-events-none">
                            <span class="text-[320px]">⚽</span>
                        </div>

                        <!-- Corner Ornamental Accents -->
                        <div class="absolute -top-3 -left-3 w-8 h-8 border-t-4 border-l-4 border-[#c29b38]"></div>
                        <div class="absolute -top-3 -right-3 w-8 h-8 border-t-4 border-r-4 border-[#c29b38]"></div>
                        <div class="absolute -bottom-3 -left-3 w-8 h-8 border-b-4 border-l-4 border-[#c29b38]"></div>
                        <div class="absolute -bottom-3 -right-3 w-8 h-8 border-b-4 border-r-4 border-[#c29b38]"></div>

                        <!-- TOP HEADER -->
                        <div class="text-center relative z-10">
                            <!-- Logo and Academy Bilingual Title -->
                            <div class="flex items-center justify-center gap-3">
                                <span class="text-4xl">⚽</span>
                                <div>
                                    <h1 class="text-2xl font-black tracking-wider text-emerald-950 uppercase">জামিরবাড়িয়া স্পোর্টস একাডেমি</h1>
                                    <h2 class="cert-font-serif text-sm font-bold tracking-[0.25em] text-[#a47e24] uppercase">JAMIRBARIA SPORTS ACADEMY</h2>
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-500 tracking-wider mt-0.5">গভ. রেজিস্টার্ড বহুমুখী ক্রীড়া প্রশিক্ষণ কেন্দ্র • জামিরবাড়িয়া, ময়মনসিংহ</p>

                            <!-- Certificate Badge Ribbon Graphic -->
                            <div class="mt-4 inline-flex items-center gap-2 px-6 py-1 bg-gradient-to-r from-amber-600 via-[#d4af37] to-amber-600 text-white rounded-full shadow-md text-xs font-bold uppercase tracking-widest border border-amber-300">
                                <span>★</span> {{ $certificate->type_name }} <span>★</span>
                            </div>

                            <div class="mt-2">
                                <h3 class="cert-font-serif text-3xl font-black uppercase tracking-wider text-slate-900">
                                    {{ $certificate->title }}
                                </h3>
                                <div class="w-32 h-0.5 bg-gradient-to-r from-transparent via-[#c29b38] to-transparent mx-auto mt-1"></div>
                            </div>
                        </div>

                        <!-- RECIPIENT BODY -->
                        <div class="text-center my-4 relative z-10 px-12 space-y-3">
                            <p class="text-sm font-medium text-gray-600 italic">
                                এই সম্মাননা ও গৌরবময় স্বীকৃতিপত্র সগৌরবে প্রদান করা হচ্ছে —
                            </p>

                            <!-- Player Name in Grand Typography -->
                            <div class="py-1">
                                <span class="text-4xl md:text-5xl font-black text-emerald-950 border-b-2 border-[#c29b38]/60 pb-2 px-8 inline-block drop-shadow-sm">
                                    {{ $certificate->trainee->name }}
                                </span>
                            </div>

                            <!-- Player Metadata Pill -->
                            <div class="flex items-center justify-center gap-4 text-xs font-semibold text-gray-700">
                                <span>আইডি নং: <strong class="font-mono text-emerald-800">{{ $certificate->trainee->admission_no }}</strong></span>
                                <span>•</span>
                                <span>খেলা: <strong class="text-amber-900">{{ $certificate->sport->name ?? $certificate->trainee->sport->name ?? 'অল-রাউন্ড অ্যাথলেট' }}</strong></span>
                                <span>•</span>
                                <span>ক্যাটাগরি: <strong class="text-slate-800">{{ $certificate->trainee->category }}</strong></span>
                                @if($certificate->grade_or_rank)
                                    <span>•</span>
                                    <span>অর্জন: <strong class="text-emerald-700 uppercase">{{ $certificate->grade_or_rank }}</strong></span>
                                @endif
                            </div>

                            <!-- Citation Description -->
                            <div class="max-w-2xl mx-auto mt-2">
                                <p class="text-sm md:text-base text-gray-800 leading-relaxed font-serif italic px-6 py-2 bg-amber-50/50 rounded-2xl border border-amber-200/40">
                                    "{{ $certificate->description }}"
                                </p>
                            </div>

                            @if($certificate->event_or_course)
                                <div class="text-xs text-gray-600 font-medium">
                                    ইভেন্ট / কোর্স: <strong class="text-gray-900">{{ $certificate->event_or_course }}</strong>
                                </div>
                            @endif
                        </div>

                        <!-- BOTTOM CERTIFICATE FOOTER -->
                        <div class="pt-4 border-t border-emerald-900/20 relative z-10 flex items-end justify-between px-6">
                            
                            <!-- Left: Scannable Vector QR Code -->
                            <div class="flex items-center gap-3">
                                <div class="w-20 h-20 bg-white p-1 rounded-xl shadow-md border border-amber-300 shrink-0 flex items-center justify-center">
                                    {!! $qrCodeSvg !!}
                                </div>
                                <div class="text-left text-[10px] space-y-0.5">
                                    <span class="font-bold text-emerald-900 block">স্মার্ট কিউআর ভেরিফাইড</span>
                                    <span class="font-mono text-gray-600 block text-[9px]">{{ $certificate->certificate_no }}</span>
                                    <span class="text-gray-400 block text-[8px]">স্ক্যান করে অনলাইন সত্যতা যাচাই করুন</span>
                                    <span class="font-semibold text-gray-600 block text-[9px]">তারিখ: {{ $certificate->issue_date->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Center: Golden Seal Graphic -->
                            <div class="text-center flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-amber-600 via-[#ffd700] to-amber-700 p-1 shadow-xl flex items-center justify-center">
                                    <div class="w-full h-full rounded-full border-2 border-dashed border-white/80 flex flex-col items-center justify-center text-center text-amber-950 font-black">
                                        <span class="text-[9px] tracking-widest uppercase">JSA SEAL</span>
                                        <span class="text-[7px] uppercase tracking-wider text-amber-900">VERIFIED</span>
                                        <span class="text-xs">★</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold tracking-widest uppercase text-amber-900 mt-1">OFFICIAL SEAL</span>
                            </div>

                            <!-- Right: Dual Authorized Signatures -->
                            <div class="flex items-center gap-8 text-center">
                                <div>
                                    <div class="w-32 border-b-2 border-slate-800 mb-1 pb-1">
                                        <span class="cert-font-script text-xl text-emerald-900">N. Rahman</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-800 uppercase block">প্রধান প্রশিক্ষক</span>
                                    <span class="text-[8px] text-gray-500 block">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
                                </div>

                                <div>
                                    <div class="w-32 border-b-2 border-slate-800 mb-1 pb-1">
                                        <span class="cert-font-script text-xl text-amber-900">Director Sign</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-800 uppercase block">একাডেমি পরিচালক</span>
                                    <span class="text-[8px] text-gray-500 block">কার্যনির্বাহী সংসদ</span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>


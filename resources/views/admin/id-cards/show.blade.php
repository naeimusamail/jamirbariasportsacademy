<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>🪪</span> {{ $trainee->name }} — ডিজিটাল প্লেয়ার আইডি কার্ড
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    অফিসিয়াল কিউআর কোড সম্বলিত ভেরিফায়েড অ্যাথলেট পরিচয়পত্র • আইডি: <span class="font-mono font-bold text-emerald-600">{{ $trainee->admission_no }}</span>
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2 no-print">
                <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-600/20 flex items-center gap-1.5 transition">
                    <span>🖨️ আইডি কার্ড প্রিন্ট করুন</span>
                </button>
                <a href="{{ route('admin.certificates.create', ['trainee_id' => $trainee->id]) }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>📜 সনদপত্র ইস্যু</span>
                </a>
                <a href="{{ route('trainees.show', $trainee) }}" class="px-3.5 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                    &larr; প্লেয়ার প্রোফাইল
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Print Stylesheet -->
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .no-print, header, nav, footer {
                display: none !important;
            }
            .print-container {
                display: flex !important;
                flex-direction: row !important;
                justify-content: center !important;
                gap: 24px !important;
                padding: 10px !important;
                background: transparent !important;
                page-break-inside: avoid !important;
            }
            .id-card-wrap {
                box-shadow: none !important;
                border: 1px solid #10b981 !important;
                page-break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>

    <div class="py-8" x-data="{ side: 'both', copied: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Control Bar (No Print) -->
            <div class="no-print bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400">প্রিভিউ মোড:</span>
                    <button @click="side = 'both'" :class="side === 'both' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                        উভয় পাশ (Front & Back)
                    </button>
                    <button @click="side = 'front'" :class="side === 'front' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                        সম্মুখভাগ (Front Only)
                    </button>
                    <button @click="side = 'back'" :class="side === 'back' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                        পশ্চাদ্ভাগ (Back Only)
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="navigator.clipboard.writeText('{{ $verifyUrl }}'); copied = true; setTimeout(() => copied = false, 2500)" class="px-3.5 py-1.5 bg-slate-900 text-white hover:bg-slate-800 rounded-lg text-xs font-bold flex items-center gap-1.5 transition">
                        <span x-text="copied ? '✓ লিংক কপি হয়েছে' : '🔗 ভেরিফিকেশন লিংক কপি'"></span>
                    </button>
                    <a href="{{ $verifyUrl }}" target="_blank" class="px-3 py-1.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-500/20 rounded-lg text-xs font-bold transition">
                        পাবলিক ভিউ ↗
                    </a>
                </div>
            </div>

            <!-- Print Container -->
            <div class="print-container flex flex-wrap items-start justify-center gap-8 py-4">

                <!-- ========================================== -->
                <!-- 🪪 FRONT SIDE (সম্মুখভাগ) -->
                <!-- ========================================== -->
                <div x-show="side === 'both' || side === 'front'" class="id-card-wrap w-[340px] h-[530px] rounded-3xl overflow-hidden relative shadow-2xl flex flex-col justify-between select-none bg-gradient-to-b from-slate-950 via-emerald-950 to-slate-950 text-white border-2 border-emerald-500/40">
                    <!-- Hologram / Top Accent Ribbon -->
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-400 via-amber-300 to-emerald-400"></div>
                    <div class="absolute -top-16 -right-16 w-36 h-36 bg-emerald-400/10 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-amber-400/10 rounded-full blur-2xl"></div>

                    <!-- Card Header -->
                    <div class="pt-5 px-5 pb-3 border-b border-emerald-500/20 text-center relative z-10">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-2xl drop-shadow">⚽</span>
                            <div>
                                <h3 class="font-black text-sm tracking-wider uppercase text-emerald-300">জামিরবাড়িয়া স্পোর্টস একাডেমি</h3>
                                <p class="text-[9px] font-bold tracking-widest text-emerald-100 uppercase">JAMIRBARIA SPORTS ACADEMY</p>
                            </div>
                        </div>
                        <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-[9px] font-bold text-emerald-200 uppercase tracking-widest">
                            <span>★</span> OFFICIAL ATHLETE ID CARD <span>★</span>
                        </div>
                    </div>

                    <!-- Player Photo & Badge Center -->
                    <div class="px-5 py-2 flex flex-col items-center text-center relative z-10">
                        <!-- 300x300 Image Container with Gold Border -->
                        <div class="relative">
                            <div class="w-28 h-28 rounded-2xl p-1 bg-gradient-to-tr from-amber-400 to-emerald-400 shadow-xl overflow-hidden">
                                <div class="w-full h-full rounded-xl overflow-hidden bg-slate-900 flex items-center justify-center">
                                    @if($trainee->photo)
                                        <img src="{{ asset('storage/' . $trainee->photo) }}" alt="{{ $trainee->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-4xl font-black text-emerald-400">{{ mb_substr($trainee->name, 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                            @if($trainee->jersey_no)
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-slate-950 border-2 border-amber-400 text-amber-300 font-mono font-black text-xs flex items-center justify-center shadow-md">
                                    #{{ $trainee->jersey_no }}
                                </div>
                            @endif
                        </div>

                        <!-- Name & Sport Title -->
                        <h4 class="font-black text-lg text-white mt-3 leading-snug drop-shadow-sm">{{ $trainee->name }}</h4>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs font-bold text-emerald-300">{{ $trainee->sport->name ?? 'অল-রাউন্ডার' }}</span>
                            <span class="text-[10px] text-gray-400">•</span>
                            <span class="text-[11px] font-semibold text-gray-200">{{ $trainee->position ?? 'প্লেয়ার' }}</span>
                        </div>
                    </div>

                    <!-- Details Table -->
                    <div class="px-5 py-2 relative z-10">
                        <div class="bg-black/40 rounded-2xl p-3 border border-emerald-500/20 grid grid-cols-2 gap-2 text-[11px]">
                            <div>
                                <span class="text-[9px] uppercase tracking-wider text-emerald-300/80 block">আইডি নম্বর:</span>
                                <span class="font-mono font-black text-white text-xs">{{ $trainee->admission_no }}</span>
                            </div>
                            <div>
                                <span class="text-[9px] uppercase tracking-wider text-emerald-300/80 block">ক্যাটাগরি:</span>
                                <span class="font-bold text-amber-300">{{ $trainee->category }}</span>
                            </div>
                            <div>
                                <span class="text-[9px] uppercase tracking-wider text-emerald-300/80 block">রক্তের গ্রুপ:</span>
                                <span class="font-bold text-rose-400 font-mono">{{ $trainee->blood_group ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-[9px] uppercase tracking-wider text-emerald-300/80 block">ভর্তির সেশন:</span>
                                <span class="text-gray-200">{{ \Carbon\Carbon::parse($trainee->admission_date)->format('Y') }}-{{ \Carbon\Carbon::parse($trainee->admission_date)->addYear()->format('y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer / Barcode -->
                    <div class="px-5 pb-4 pt-1 flex items-center justify-between border-t border-emerald-500/20 text-[10px] text-emerald-300/70 relative z-10">
                        <div class="font-mono text-[9px] tracking-widest bg-black/60 px-2 py-0.5 rounded border border-white/10">
                            ||| | ||||| || | |||| ||
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] text-gray-300 font-semibold">ভেরিফায়েড প্লেয়ার</span>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 🪪 BACK SIDE (পশ্চাদ্ভাগ) -->
                <!-- ========================================== -->
                <div x-show="side === 'both' || side === 'back'" class="id-card-wrap w-[340px] h-[530px] rounded-3xl overflow-hidden relative shadow-2xl flex flex-col justify-between select-none bg-gradient-to-b from-slate-900 via-slate-950 to-emerald-950 text-white border-2 border-emerald-500/40">
                    <!-- Top Ribbon -->
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-500 via-amber-400 to-emerald-500"></div>

                    <!-- Back Header -->
                    <div class="pt-5 px-5 pb-3 border-b border-white/10 text-center">
                        <h4 class="font-black text-xs uppercase tracking-widest text-emerald-300">নির্দেশনাবলী ও জরুরি তথ্য</h4>
                        <p class="text-[9px] text-gray-400">JAMIRBARIA SPORTS ACADEMY • TERMS & VERIFICATION</p>
                    </div>

                    <!-- Instructions List -->
                    <div class="px-5 py-2 space-y-2 text-[10px] text-gray-300 leading-relaxed">
                        <div class="p-2.5 rounded-xl bg-white/5 border border-white/5 space-y-1">
                            <p class="flex items-start gap-1.5">
                                <span class="text-emerald-400">●</span>
                                <span>এই কার্ডটি জামিরবাড়িয়া স্পোর্টস একাডেমির সম্পত্তি এবং হস্তান্তরযোগ্য নয়।</span>
                            </p>
                            <p class="flex items-start gap-1.5">
                                <span class="text-emerald-400">●</span>
                                <span>অনুশীলন ও টুর্নামেন্ট চলাকালে কার্ড প্রদর্শন বাধ্যতামূলক।</span>
                            </p>
                            <p class="flex items-start gap-1.5">
                                <span class="text-emerald-400">●</span>
                                <span>কার্ডটি পাওয়া গেলে নিচে উল্লেখিত হেল্পলাইন নম্বরে যোগাযোগ করার অনুরোধ করা হলো।</span>
                            </p>
                        </div>

                        <!-- Guardian & Emergency Info -->
                        <div class="p-2.5 rounded-xl bg-black/40 border border-emerald-500/20 space-y-1 text-[11px]">
                            <div class="flex justify-between">
                                <span class="text-gray-400 text-[10px]">অভিভাবকের নাম:</span>
                                <span class="font-bold text-white">{{ $trainee->guardian_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400 text-[10px]">অভিভাবকের ফোন:</span>
                                <span class="font-mono font-bold text-emerald-300">{{ $trainee->phone }}</span>
                            </div>
                            @if($trainee->emergency_phone)
                                <div class="flex justify-between">
                                    <span class="text-gray-400 text-[10px]">জরুরি ফোন:</span>
                                    <span class="font-mono text-rose-300">{{ $trainee->emergency_phone }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Live Scannable Vector QR Code -->
                    <div class="px-5 py-2 flex items-center justify-between gap-3 bg-white/5 rounded-2xl mx-5 border border-white/10">
                        <div class="w-20 h-20 bg-white p-1 rounded-xl shadow shrink-0 flex items-center justify-center">
                            {!! $qrCodeSvg !!}
                        </div>
                        <div class="space-y-1 text-left">
                            <span class="inline-block px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[9px] font-bold">
                                স্মার্টফোন স্ক্যান
                            </span>
                            <h5 class="font-black text-xs text-white">কিউআর কোড যাচাই</h5>
                            <p class="text-[9px] text-gray-300 leading-tight">
                                ক্যামেরায় স্ক্যান করে সরাসরি একাডেমির অফিসিয়াল ডেটাবেজ থেকে প্লেয়ার যাচাই করুন।
                            </p>
                        </div>
                    </div>

                    <!-- Authority Signature & Stamp Footer -->
                    <div class="px-5 pb-4 pt-2 border-t border-white/10 flex items-center justify-between text-[10px]">
                        <div>
                            <div class="text-[9px] text-gray-400">একাডেমি ঠিকানা:</div>
                            <div class="text-[10px] font-bold text-gray-200">জামিরবাড়িয়া, ময়মনসিংহ</div>
                            <div class="text-[9px] text-emerald-400 font-mono">হেল্পলাইন: +৮৮০ ১৭০০-০০০০০০</div>
                        </div>

                        <!-- Seal / Signature Area -->
                        <div class="text-center relative">
                            <!-- Official Seal Stamp Graphic -->
                            <div class="w-14 h-14 rounded-full border border-emerald-400/40 border-dashed absolute -top-9 right-1 pointer-events-none flex items-center justify-center text-[7px] text-emerald-400/60 font-black rotate-12">
                                SEAL APPROVED
                            </div>
                            <div class="w-24 border-b border-white/40 mb-1">
                                <span class="font-serif italic text-xs text-emerald-300">JSA Authority</span>
                            </div>
                            <span class="text-[8px] text-gray-300 font-bold block uppercase tracking-wider">পরিচালক / প্রধান কোচ</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>


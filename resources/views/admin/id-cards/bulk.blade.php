<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বাল্ক আইডি কার্ড প্রিন্ট শিট — জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            background: #f1f5f9;
        }
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .a4-sheet {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 10mm !important;
                page-break-after: always;
            }
            .id-card {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                page-break-inside: avoid !important;
            }
        }
    </style>
</head>
<body class="p-6">

    <!-- Top Action Bar -->
    <div class="max-w-5xl mx-auto mb-6 p-4 bg-white rounded-2xl shadow-sm border border-gray-200 flex items-center justify-between no-print">
        <div>
            <h1 class="text-lg font-black text-gray-900 flex items-center gap-2">
                <span>🖨️</span> বাল্ক প্লেয়ার আইডি কার্ড প্রিন্ট ভিউ
            </h1>
            <p class="text-xs text-gray-500">মোট কার্ড সংখ্যা: <strong class="text-emerald-600 font-mono text-sm">{{ count($cardsData) }} টি</strong></p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow flex items-center gap-2 transition">
                <span>🖨️ প্রিন্ট করুন (Print A4)</span>
            </button>
            <button onclick="window.close()" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs transition">
                বন্ধ করুন
            </button>
        </div>
    </div>

    <!-- Cards Sheet Container (A4 Printable Layout) -->
    <div class="max-w-5xl mx-auto space-y-8">
        @foreach($cardsData->chunk(4) as $pageIndex => $chunk)
            <div class="a4-sheet bg-white p-8 rounded-3xl shadow-xl border border-dashed border-gray-300">
                <div class="text-[10px] text-gray-400 mb-4 pb-2 border-b border-gray-100 flex justify-between items-center no-print">
                    <span>শিট নং: {{ $pageIndex + 1 }} • জামিরবাড়িয়া স্পোর্টস একাডেমি অফিসিয়াল কার্ড শিট</span>
                    <span>A4 পেপার সাইজ অনুযায়ী কাটিং মার্ক সহ</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center">
                    @foreach($chunk as $item)
                        @php $trainee = $item['trainee']; @endphp
                        <!-- Single Card (Front) with Cut Guides -->
                        <div class="id-card w-[320px] h-[490px] rounded-2xl overflow-hidden relative shadow-lg flex flex-col justify-between bg-gradient-to-b from-slate-950 via-emerald-950 to-slate-950 text-white border-2 border-emerald-500/40">
                            <!-- Top Accent Ribbon -->
                            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-400 via-amber-300 to-emerald-400"></div>

                            <!-- Header -->
                            <div class="pt-4 px-4 pb-2 border-b border-emerald-500/20 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-xl">⚽</span>
                                    <div>
                                        <h3 class="font-black text-xs uppercase tracking-wider text-emerald-300">জামিরবাড়িয়া স্পোর্টস একাডেমি</h3>
                                        <p class="text-[8px] font-bold tracking-widest text-emerald-100 uppercase">JAMIRBARIA SPORTS ACADEMY</p>
                                    </div>
                                </div>
                                <div class="mt-1.5 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-[8px] font-bold text-emerald-200 uppercase tracking-wider border border-emerald-400/20">
                                    ★ OFFICIAL ATHLETE ID ★
                                </div>
                            </div>

                            <!-- Photo & Info -->
                            <div class="px-4 py-1 flex flex-col items-center text-center">
                                <div class="relative">
                                    <div class="w-24 h-24 rounded-2xl p-1 bg-gradient-to-tr from-amber-400 to-emerald-400 shadow overflow-hidden">
                                        <div class="w-full h-full rounded-xl overflow-hidden bg-slate-900 flex items-center justify-center">
                                            @if($trainee->photo)
                                                <img src="{{ asset('storage/' . $trainee->photo) }}" alt="{{ $trainee->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-3xl font-black text-emerald-400">{{ mb_substr($trainee->name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($trainee->jersey_no)
                                        <div class="absolute -bottom-1.5 -right-1.5 w-7 h-7 rounded-full bg-slate-950 border border-amber-400 text-amber-300 font-mono font-black text-[10px] flex items-center justify-center">
                                            #{{ $trainee->jersey_no }}
                                        </div>
                                    @endif
                                </div>

                                <h4 class="font-black text-base text-white mt-2 leading-tight">{{ $trainee->name }}</h4>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="text-[11px] font-bold text-emerald-300">{{ $trainee->sport->name ?? 'অ্যাথলেট' }}</span>
                                    <span class="text-[9px] text-gray-400">•</span>
                                    <span class="text-[10px] text-gray-200">{{ $trainee->position ?? 'প্লেয়ার' }}</span>
                                </div>
                            </div>

                            <!-- Details Box -->
                            <div class="px-4 py-1">
                                <div class="bg-black/50 rounded-xl p-2.5 border border-emerald-500/20 grid grid-cols-2 gap-1.5 text-[10px]">
                                    <div>
                                        <span class="text-[8px] uppercase text-emerald-300/80 block">আইডি নম্বর:</span>
                                        <span class="font-mono font-bold text-white text-[11px]">{{ $trainee->admission_no }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[8px] uppercase text-emerald-300/80 block">ক্যাটাগরি:</span>
                                        <span class="font-bold text-amber-300">{{ $trainee->category }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[8px] uppercase text-emerald-300/80 block">রক্তের গ্রুপ:</span>
                                        <span class="font-bold text-rose-400 font-mono">{{ $trainee->blood_group ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[8px] uppercase text-emerald-300/80 block">ফোন:</span>
                                        <span class="font-mono text-gray-200">{{ $trainee->phone }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- QR & Footer Strip -->
                            <div class="px-4 pb-3 pt-1 border-t border-emerald-500/20 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-12 bg-white p-0.5 rounded-lg shrink-0 flex items-center justify-center">
                                        {!! $item['qrSvg'] !!}
                                    </div>
                                    <div class="text-[8px] text-gray-300 leading-tight">
                                        <span class="font-bold text-emerald-300 block">QR ভেরিফিকেশন</span>
                                        স্ক্যান করে যাচাই করুন
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="w-16 border-b border-white/40 mb-0.5"></div>
                                    <span class="text-[7px] text-gray-400 block uppercase">অনুমোদিত স্বাক্ষর</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>


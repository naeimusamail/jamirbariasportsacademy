<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ভলান্টিয়ার আইডি ব্যাজ - {{ $volunteer->volunteer_no }} | {{ $volunteer->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-badge {
                box-shadow: none !important;
                border: 2px solid #0f172a !important;
                page-break-inside: avoid !important;
                margin: 0 auto !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen py-8 px-4 flex flex-col items-center justify-center selection:bg-amber-500">

    <!-- Action Toolbar (Hidden on print) -->
    <div class="no-print mb-6 max-w-sm w-full flex items-center justify-between gap-3">
        <a href="{{ route('volunteer.tracking', $volunteer->volunteer_no) }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
            <span>&larr;</span> ট্র্যাকিং পেজে ফিরুন
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-black shadow-lg shadow-amber-500/20 transition flex items-center gap-1.5">
            <span>🖨️ আইডি ব্যাজ প্রিন্ট করুন</span>
        </button>
    </div>

    <!-- Official Vertical Event Volunteer Badge -->
    <div class="print-badge w-full max-w-[340px] bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 border-2 border-slate-700/80 rounded-3xl shadow-2xl relative overflow-hidden text-center flex flex-col justify-between p-6">
        
        <!-- Background Accents -->
        <div class="absolute -top-16 -right-16 w-36 h-36 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <!-- 1. Lanyard Clip Hole Visual Marker -->
        <div class="flex justify-center mb-3">
            <div class="w-12 h-2.5 rounded-full bg-slate-800 border border-slate-600 shadow-inner"></div>
        </div>

        <!-- 2. Academy Header -->
        <div class="border-b border-slate-800 pb-3 mb-4 space-y-1">
            <div class="flex items-center justify-center gap-2">
                <span class="text-2xl">⚽</span>
                <div class="text-left">
                    <h2 class="text-xs font-black tracking-wider uppercase text-white leading-tight">জামিরবাড়িয়া স্পোর্টস একাডেমি</h2>
                    <p class="text-[9px] font-bold text-amber-400 tracking-wide">JAMIRBARIA SPORTS ACADEMY</p>
                </div>
            </div>
            
            <div class="pt-1.5 flex items-center justify-center gap-2">
                <span class="px-3 py-0.5 rounded-full bg-amber-500 text-slate-950 font-black text-[10px] uppercase tracking-widest shadow">
                    ★ OFFICIAL VOLUNTEER ★
                </span>
            </div>
        </div>

        <!-- 3. Photo & ID -->
        <div class="flex flex-col items-center mb-4">
            <div class="w-28 h-28 rounded-2xl p-1 bg-gradient-to-tr from-amber-500 via-emerald-500 to-teal-400 shadow-xl mb-3">
                <div class="w-full h-full rounded-[14px] bg-slate-900 overflow-hidden flex items-center justify-center">
                    @if($volunteer->photo)
                        <img src="{{ asset('storage/' . $volunteer->photo) }}" alt="{{ $volunteer->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-4xl text-slate-600">👤</span>
                    @endif
                </div>
            </div>

            <!-- Name -->
            <h1 class="text-lg font-black text-white leading-snug">
                {{ $volunteer->name }}
            </h1>
            @if($volunteer->name_en)
                <p class="text-xs font-semibold text-slate-400 font-sans tracking-wide">
                    {{ $volunteer->name_en }}
                </p>
            @endif

            <!-- ID Badge Number -->
            <div class="mt-2 px-3 py-1 rounded-lg bg-slate-950 border border-slate-700/80 font-mono font-black text-amber-400 text-xs tracking-wider">
                ID: {{ $volunteer->volunteer_no }}
            </div>
        </div>

        <!-- 4. Department & Duty Pill -->
        <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-3 mb-4 space-y-1.5 text-xs text-left">
            <div class="flex justify-between items-center text-[11px]">
                <span class="text-slate-400">বিভাগ:</span>
                <span class="font-bold text-emerald-400 text-right">{{ $volunteer->department_name }}</span>
            </div>
            
            @if($volunteer->assigned_duties)
                <div class="flex justify-between items-start text-[11px] pt-1 border-t border-slate-800/80">
                    <span class="text-slate-400 shrink-0">দায়িত্ব:</span>
                    <span class="font-bold text-white text-right leading-tight ml-2">{{ $volunteer->assigned_duties }}</span>
                </div>
            @endif

            @if($volunteer->tournament)
                <div class="flex justify-between items-center text-[10px] pt-1 border-t border-slate-800/80">
                    <span class="text-slate-400">টুর্নামেন্ট:</span>
                    <span class="font-semibold text-amber-300 text-right">{{ $volunteer->tournament->name }}</span>
                </div>
            @endif

            <div class="flex justify-between items-center text-[10px] pt-1 border-t border-slate-800/80">
                <span class="text-slate-400">ব্লাড গ্রুপ:</span>
                <span class="font-bold text-rose-400">{{ $volunteer->blood_group ?: 'N/A' }} | টি-শার্ট: {{ $volunteer->tshirt_size }}</span>
            </div>
        </div>

        <!-- 5. Footer with Emergency & Seal -->
        <div class="pt-2 border-t border-slate-800 flex items-center justify-between text-left">
            <div class="space-y-0.5">
                <p class="text-[9px] text-slate-400 uppercase tracking-wider">জরুরি যোগাযোগ:</p>
                <p class="text-[11px] font-mono font-black text-white leading-none">
                    {{ $volunteer->emergency_phone ?: $volunteer->phone }}
                </p>
                <p class="text-[8px] text-slate-500 mt-1">মাঠে এই ব্যাজ দৃশ্যমান রাখা বাধ্যতামূলক</p>
            </div>

            <div class="text-right">
                <div class="text-xs text-amber-400 font-bold tracking-tighter italic">
                    Jamirbaria Sports
                </div>
                <div class="text-[8px] text-slate-500 uppercase tracking-widest">
                    অনুমোদিত ভলান্টিয়ার উইং
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions below badge (hidden on print) -->
    <div class="no-print mt-6 text-center text-xs text-slate-400 max-w-sm">
        💡 <strong>প্রিন্ট নির্দেশিকা:</strong> প্রিন্টারে A6 বা স্ট্যান্ডার্ড আইডি কার্ড সাইজ পেপারে প্রিন্ট করে লেমিনেট করে ইভেন্টের ল্যানিয়ার্ড ফিতায় ঝুলিয়ে নিন।
    </div>
</body>
</html>


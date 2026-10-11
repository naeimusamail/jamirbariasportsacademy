<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>আবেদন সফল হয়েছে | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body { background: white !important; color: black !important; }
            .no-print { display: none !important; }
            .print-card { border: 2px solid #000 !important; box-shadow: none !important; color: #000 !important; background: #fff !important; }
            .print-text-dark { color: #000 !important; }
            .print-bg-gray { background-color: #f3f4f6 !important; }
        }
    </style>
</head>
<body class="antialiased bg-slate-900 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-white pb-16">
    <!-- Navbar (Hidden on Print) -->
    <header class="no-print border-b border-slate-800 bg-slate-900/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <span class="text-xl">⚽</span>
                <span class="font-bold text-sm text-white">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
            </a>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admission.create') }}" class="text-xs text-slate-400 hover:text-white">নতুন আবেদন</a>
                <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-white">হোম</a>
            </div>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 sm:px-6 pt-10">
        <!-- Success Banner (Hidden on Print) -->
        <div class="no-print text-center mb-8">
            <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 text-3xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/40 animate-bounce">
                ✓
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">আবেদন সফলভাবে গৃহীত হয়েছে!</h1>
            <p class="text-slate-400 text-sm mt-1">
                আপনার আবেদন নম্বরটি সংরক্ষণ করুন অথবা এই স্লিপটি প্রিন্ট করে সাথে রাখুন।
            </p>
        </div>

        <!-- Official Printable Slip Card -->
        <div class="print-card bg-slate-800 border border-slate-700 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <div class="border-b border-slate-700/80 pb-6 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center text-2xl font-black shrink-0">
                        ⚽
                    </div>
                    <div>
                        <h2 class="print-text-dark font-black text-lg text-white">জামিরবাড়িয়া স্পোর্টস একাডেমি</h2>
                        <p class="text-xs text-emerald-400 font-semibold tracking-wider">ভর্তি আবেদন মানি রিসিট / স্লিপ (২০২৬)</p>
                    </div>
                </div>

                <div class="text-right sm:text-right">
                    <span class="text-[11px] text-slate-400 block">আবেদন ট্র্যাকিং নম্বর</span>
                    <span class="inline-block px-3 py-1 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono font-black text-base border border-emerald-500/30">
                        {{ $application->application_no }}
                    </span>
                </div>
            </div>

            <!-- Content Grid with Photo -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Photo Box -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-32 h-36 rounded-2xl bg-slate-900 border-2 border-slate-700 overflow-hidden shadow-inner flex items-center justify-center mb-2">
                        @if($application->photo)
                            <img src="{{ asset('storage/' . $application->photo) }}" alt="Applicant Photo" class="w-full h-full object-cover">
                        @else
                            <div class="text-slate-500 text-xs">ছবি নেই</div>
                        @endif
                    </div>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                        {{ $application->status === 'approved' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($application->status === 'rejected' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30') }}">
                        স্ট্যাটাস: {{ $application->status === 'approved' ? 'অনুমোদিত' : ($application->status === 'rejected' ? 'বাতিল' : 'বিচারাধীন (Pending)') }}
                    </span>
                </div>

                <!-- Info Table -->
                <div class="sm:col-span-2 space-y-2.5 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">প্লেয়ারের নাম:</span>
                        <span class="print-text-dark font-bold text-white">
                            {{ $application->name }}
                            @if($application->name_en)
                                <span class="text-slate-400 text-[11px] font-normal">({{ $application->name_en }})</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">অভিভাবকের নাম:</span>
                        <span class="print-text-dark font-semibold text-slate-200">{{ $application->guardian_name }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">খেলার বিভাগ:</span>
                        <span class="print-text-dark font-semibold text-emerald-400">{{ $application->sport->name ?? 'N/A' }} ({{ $application->category }})</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">পজিশন / রোল:</span>
                        <span class="print-text-dark text-slate-200">{{ $application->position ?? 'সাধারণ' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">মোবাইল নম্বর:</span>
                        <span class="print-text-dark font-mono text-slate-200">{{ $application->phone }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">রক্তের গ্রুপ:</span>
                        <span class="print-text-dark font-bold text-rose-400">{{ $application->blood_group ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">পেমেন্ট মাধ্যম:</span>
                        <span class="print-text-dark font-semibold text-emerald-400">
                            {{ \App\Models\AdmissionApplication::paymentMethodNames()[$application->payment_method] ?? strtoupper($application->payment_method) }}
                            (৳{{ number_format($application->payment_amount, 2) }})
                        </span>
                    </div>
                    @if($application->transaction_id)
                        <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                            <span class="text-slate-400">ট্রানজেকশন আইডি (TrxID):</span>
                            <span class="print-text-dark font-mono font-bold text-white">{{ $application->transaction_id }}</span>
                        </div>
                    @endif
                    @if($application->sender_number)
                        <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                            <span class="text-slate-400">প্রেরকের নম্বর:</span>
                            <span class="print-text-dark font-mono text-slate-300">{{ $application->sender_number }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">পেমেন্ট স্ট্যাটাস:</span>
                        <span class="print-text-dark font-semibold {{ $application->payment_status === 'paid' ? 'text-emerald-400' : 'text-amber-400' }}">
                            {{ $application->payment_status === 'paid' ? 'পরিশোধিত (Paid)' : ($application->payment_method === 'cash' ? 'কাউন্টারে প্রদেয় (Cash on Arrival)' : 'যাচাই অপেক্ষমান (Verification Pending)') }}
                        </span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-700/50">
                        <span class="text-slate-400">আবেদনের তারিখ:</span>
                        <span class="print-text-dark text-slate-300">{{ $application->created_at->format('d M, Y (h:i A)') }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Notice -->
            <div class="mt-6 pt-4 border-t border-slate-700/80 text-[11px] text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p>📍 হেল্পলাইন: +৮৮০ ১৭১২-৩৪৫৬৭৮ | জামিরবাড়িয়া, ময়মনসিংহ</p>
                <p class="font-mono text-slate-500">JSA-TOKEN-{{ substr(md5($application->id), 0, 8) }}</p>
            </div>
        </div>

        <!-- Action Buttons (Hidden on Print) -->
        <div class="no-print mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="window.print()" class="w-full sm:w-auto px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20">
                <span>🖨️ স্লিপটি প্রিন্ট / পিডিএফ ডাউনলোড করুন</span>
            </button>
            <a href="{{ route('admission.track') }}?query={{ $application->application_no }}" class="w-full sm:w-auto px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold rounded-xl text-sm border border-slate-700 transition text-center">
                🔍 স্ট্যাটাস চেক করুন
            </a>
        </div>
    </main>
</body>
</html>


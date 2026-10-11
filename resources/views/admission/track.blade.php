<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>আবেদনের অবস্থা যাচাই | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-900 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-white pb-16">
    <!-- Navbar -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <span class="text-xl">⚽</span>
                <span class="font-bold text-sm text-white">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
            </a>
            <div class="flex items-center space-x-3 text-xs">
                <a href="{{ route('admission.create') }}" class="text-emerald-400 hover:text-emerald-300 font-semibold">+ নতুন ভর্তি আবেদন</a>
                <a href="{{ url('/') }}" class="text-slate-400 hover:text-white">হোম</a>
            </div>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 sm:px-6 pt-10">
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-black text-white">আবেদনের বর্তমান অবস্থা যাচাই</h1>
            <p class="text-slate-400 text-sm mt-1">
                আপনার আবেদন নম্বর (Application No) অথবা মোবাইল নম্বর প্রদান করুন।
            </p>
        </div>

        <!-- Search Box -->
        <div class="bg-slate-800/90 border border-slate-700 rounded-2xl p-6 shadow-xl mb-8">
            <form action="{{ route('admission.track') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="query" value="{{ request('query') }}" required placeholder="উদা: APP-2026-001 অথবা ০১৭১২-৩৪৫৬৭৮" class="flex-1 bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 text-sm">
                <button type="submit" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-xl text-sm transition shrink-0 flex items-center justify-center gap-2">
                    🔍 অনুসন্ধান করুন
                </button>
            </form>
        </div>

        @if(request()->filled('query'))
            @if($application)
                <!-- Found Application Result Card -->
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-4 mb-5">
                        <div>
                            <span class="text-xs text-slate-400 block">আবেদন নম্বর</span>
                            <span class="text-base font-black font-mono text-emerald-400">{{ $application->application_no }}</span>
                        </div>
                        <div>
                            @if($application->status === 'approved')
                                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold">
                                    ✓ ভর্তি অনুমোদিত (Approved)
                                </span>
                            @elseif($application->status === 'rejected')
                                <span class="px-3 py-1 rounded-full bg-rose-500/20 text-rose-400 border border-rose-500/30 text-xs font-bold">
                                    ✕ বাতিল করা হয়েছে
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs font-bold animate-pulse">
                                    ⏳ প্রক্রিয়াধীন (Pending Review)
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs mb-6">
                        <div>
                            <span class="text-slate-400 block mb-0.5">প্লেয়ারের নাম:</span>
                            <span class="font-bold text-white text-sm">{{ $application->name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">অভিভাবক:</span>
                            <span class="font-medium text-slate-200">{{ $application->guardian_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">খেলা ও ক্যাটাগরি:</span>
                            <span class="font-medium text-emerald-400">{{ $application->sport->name ?? 'N/A' }} ({{ $application->category }})</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">আবেদনের তারিখ:</span>
                            <span class="text-slate-300">{{ $application->created_at->format('d M, Y') }}</span>
                        </div>
                    </div>

                    @if($application->status === 'approved' && $application->trainee)
                        <!-- Enrolled Trainee Badge Info -->
                        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 mb-4">
                            <h4 class="font-bold text-emerald-400 text-sm mb-1">🎉 অভিনন্দন! প্লেয়ার একাডেমি রেজিস্ট্রেশন সম্পন্ন হয়েছে।</h4>
                            <p class="text-xs text-slate-300">
                                অফিসিয়াল প্লেয়ার আইডি / রোল: <strong class="text-white font-mono">{{ $application->trainee->admission_no }}</strong> | 
                                নির্ধারিত ব্যাচ: <strong class="text-white">{{ $application->trainee->batch->name ?? 'বরাদ্দ প্রক্রিয়াধীন' }}</strong>
                            </p>
                        </div>
                    @endif

                    @if($application->admin_notes)
                        <div class="p-4 rounded-xl bg-slate-900 border border-slate-700 text-xs text-slate-300">
                            <strong class="text-slate-400 block mb-1">একাডেমির মন্তব্য:</strong>
                            {{ $application->admin_notes }}
                        </div>
                    @endif

                    <div class="mt-6 pt-4 border-t border-slate-700/80 flex justify-between items-center text-xs">
                        <a href="{{ route('admission.success', $application->application_no) }}" class="text-emerald-400 hover:text-emerald-300 font-semibold">
                            📄 আবেদন স্লিপ দেখুন / প্রিন্ট ➔
                        </a>
                    </div>
                </div>
            @else
                <div class="p-8 rounded-2xl bg-slate-800/50 border border-slate-700 text-center text-slate-400">
                    <p class="text-base font-bold text-rose-400 mb-1">কোনো আবেদন খুঁজে পাওয়া যায়নি!</p>
                    <p class="text-xs">দয়া করে সঠিক আবেদন নম্বর বা আবেদনের সময় দেওয়া মোবাইল নম্বরটি প্রবেশ করান।</p>
                </div>
            @endif
        @endif
    </main>
</body>
</html>


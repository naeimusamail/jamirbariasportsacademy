<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ভলান্টিয়ার আবেদন ট্র্যাকিং | {{ $volunteer->volunteer_no }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#070d14] text-slate-100 min-h-screen selection:bg-amber-500 selection:text-slate-950 font-sans sports-turf-mesh pb-16">

    <!-- Navbar -->
    <header class="border-b border-slate-800/80 bg-slate-900/70 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-4xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <span class="text-2xl">⚽</span>
                <span class="font-bold text-sm text-white">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('volunteer.create') }}" class="px-3 py-1.5 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30 rounded-xl text-xs font-bold transition">
                    + নতুন আবেদন
                </a>
                <a href="{{ url('/') }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                    হোম
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 pt-8 space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm font-semibold flex items-center gap-2 shadow-lg">
                <span class="text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tracking Card -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden backdrop-blur-sm">
            <div class="border-b border-slate-800 pb-5 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-amber-400 bg-amber-500/10 px-2.5 py-0.5 rounded-full border border-amber-500/20">
                        ভলান্টিয়ার ট্র্যাকিং স্লিপ
                    </span>
                    <h2 class="text-lg font-black text-white mt-1">জামিরবাড়িয়া স্পোর্টস একাডেমি</h2>
                    <p class="text-xs text-slate-400">তারিখ: {{ $volunteer->created_at->format('d M, Y (h:i A)') }}</p>
                </div>

                <div class="text-left sm:text-right">
                    <span class="text-[11px] text-slate-400 block">আবেদন ট্র্যাকিং নম্বর</span>
                    <span class="inline-block px-3 py-1 rounded-xl bg-amber-500/20 text-amber-400 font-mono font-black text-base border border-amber-500/30">
                        {{ $volunteer->volunteer_no }}
                    </span>
                </div>
            </div>

            <!-- Profile & Status Header -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pb-6 border-b border-slate-800">
                <div class="w-28 h-28 rounded-2xl bg-slate-950 border-2 border-slate-700 overflow-hidden shadow-xl shrink-0 flex items-center justify-center">
                    @if($volunteer->photo)
                        <img src="{{ asset('storage/' . $volunteer->photo) }}" alt="{{ $volunteer->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl text-slate-600">👤</span>
                    @endif
                </div>

                <div class="flex-1 text-center sm:text-left space-y-1.5">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <h1 class="text-xl font-black text-white">
                            {{ $volunteer->name }}
                            @if($volunteer->name_en)
                                <span class="text-xs font-semibold text-slate-400">({{ $volunteer->name_en }})</span>
                            @endif
                        </h1>

                        <!-- Status Badge -->
                        @if($volunteer->status === 'approved')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 w-fit mx-auto sm:mx-0">
                                ✓ অনুমোদিত (Approved)
                            </span>
                        @elseif($volunteer->status === 'active')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-cyan-500/15 border border-cyan-500/30 text-cyan-400 w-fit mx-auto sm:mx-0">
                                ● সক্রিয় ডিউটিতে (Active)
                            </span>
                        @elseif($volunteer->status === 'rejected')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-500/15 border border-rose-500/30 text-rose-400 w-fit mx-auto sm:mx-0">
                                ✕ বাতিল (Rejected)
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/15 border border-amber-500/30 text-amber-400 w-fit mx-auto sm:mx-0">
                                ⏳ অপেক্ষমাণ (Pending Review)
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-amber-400 font-semibold">
                        {{ $volunteer->department_name }}
                    </p>
                    <p class="text-xs text-slate-400 font-mono">
                        মোবাইল: <span class="text-white">{{ $volunteer->phone }}</span>
                        @if($volunteer->emergency_phone)
                            • জরুরি: <span class="text-slate-300">{{ $volunteer->emergency_phone }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Assigned Duty Callout if Approved -->
            @if($volunteer->status === 'approved' || $volunteer->status === 'active')
                <div class="my-5 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-emerald-400 uppercase tracking-wider flex items-center gap-1.5">
                            <span>🛡️</span> নির্ধারিত দায়িত্ব ও ডিউটি (Assigned Duty)
                        </span>
                        @if($volunteer->tournament)
                            <span class="text-[11px] font-bold text-slate-300 bg-slate-900 px-2 py-0.5 rounded-md border border-slate-700">
                                🏆 {{ $volunteer->tournament->name }}
                            </span>
                        @endif
                    </div>
                    <div class="text-sm font-bold text-white">
                        {{ $volunteer->assigned_duties ?: 'একাডেমি গ্রাউন্ড ও ইভেন্ট কো-অর্ডিনেশন' }}
                    </div>
                    @if($volunteer->assigned_venue)
                        <div class="text-xs text-slate-300">
                            📍 ভেন্যু / লোকেশন: <span class="font-semibold text-emerald-300">{{ $volunteer->assigned_venue }}</span>
                        </div>
                    @endif
                </div>

                <!-- Print ID Card Action Button -->
                <div class="mb-5">
                    <a href="{{ route('volunteer.id-card', $volunteer->volunteer_no) }}" target="_blank" class="w-full py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black rounded-xl text-sm shadow-xl shadow-amber-500/20 flex items-center justify-center gap-2 transition">
                        <span>🪪 অফিসিয়াল ফটো আইডি ব্যাজ প্রিন্ট করুন</span>
                        <span>➔</span>
                    </a>
                </div>
            @else
                <div class="my-5 p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-xs text-slate-300 leading-relaxed">
                    ℹ️ <strong>পর্যালোচনা প্রক্রিয়াধীন:</strong> একাডেমি এডমিন প্যানেল থেকে আপনার আবেদনটি যাচাই-বাছাই করা হচ্ছে। অনুমোদন সম্পন্ন হওয়ার সাথে সাথেই এখান থেকে আপনি আপনার অফিসিয়াল <strong>ফটো আইডি ব্যাজ</strong> প্রিন্ট বা ডাউনলোড করতে পারবেন।
                </div>
            @endif

            <!-- Details List -->
            <div class="space-y-2 text-xs pt-2">
                <div class="flex justify-between py-2 border-b border-slate-800">
                    <span class="text-slate-400">টি-শার্ট সাইজ:</span>
                    <span class="font-bold text-amber-400 bg-slate-950 px-2.5 py-0.5 rounded border border-slate-800">{{ $volunteer->tshirt_size }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-800">
                    <span class="text-slate-400">রক্তের গ্রুপ:</span>
                    <span class="font-bold text-rose-400">{{ $volunteer->blood_group ?: 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-800">
                    <span class="text-slate-400">শিক্ষা প্রতিষ্ঠান / পেশা:</span>
                    <span class="text-slate-200">{{ $volunteer->organization_or_institution ?: 'সাধারণ' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-800">
                    <span class="text-slate-400">ঠিকানা:</span>
                    <span class="text-slate-200 text-right">{{ $volunteer->address }}</span>
                </div>
            </div>
        </div>

        <!-- Another search box -->
        <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <span class="text-slate-400">অন্য কোনো আবেদন চেক করতে চান?</span>
            <form action="{{ route('volunteer.track.search') }}" method="POST" class="flex items-center gap-2 w-full sm:w-auto">
                @csrf
                <input type="text" name="query" placeholder="আবেদন নম্বর / ফোন..." required class="bg-slate-950 border border-slate-700 rounded-xl px-3 py-1.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-amber-500 flex-1">
                <button type="submit" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl text-xs transition">যাচাই</button>
            </form>
        </div>
    </main>
</body>
</html>


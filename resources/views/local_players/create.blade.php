<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>উন্মুক্ত প্লেয়ার টুর্নামেন্ট রেজিস্ট্রেশন | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-amber-500 selection:text-slate-950">

    <!-- Header Navbar -->
    <header class="border-b border-slate-800/80 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-amber-500 to-rose-500 flex items-center justify-center text-slate-950 font-black text-2xl shadow-lg shadow-amber-500/20">
                    🏆
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight text-white block">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
                    <span class="text-[10px] uppercase tracking-widest text-amber-400 font-semibold block">OPEN LOCAL PLAYER TOURNAMENT REGISTRATION</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-300">
                <a href="{{ route('public.tournaments.index') }}" class="text-amber-400 hover:text-amber-300 transition">টুর্নামেন্ট হাব</a>
                <a href="{{ route('public.teams.index') }}" class="hover:text-white transition">দল ও স্কোয়াড</a>
                <a href="{{ route('live.index') }}" class="hover:text-rose-400 transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span> লাইভ ম্যাচ
                </a>
                <a href="{{ route('admission.create') }}" class="text-emerald-400 hover:text-emerald-300 transition">একাডেমিক ভর্তি</a>
                <a href="{{ url('/') }}" class="hover:text-white transition">হোম</a>
            </nav>
        </div>
    </header>

    <!-- Main Wizard Section -->
    <main class="py-10 sm:py-14 relative overflow-hidden bg-gradient-to-b from-slate-950 via-[#071311] to-slate-950">

        <!-- Ambient Stadium Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[350px] bg-amber-500/10 blur-[140px] rounded-full pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <!-- Banner Header -->
            <div class="text-center max-w-2xl mx-auto mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-bold uppercase tracking-wider mb-3">
                    <span>🌟</span> উন্মুক্ত টুর্নামেন্ট প্লেয়ার ড্রাফট
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    লোকাল প্লেয়ার <span class="bg-gradient-to-r from-amber-400 via-rose-400 to-amber-300 bg-clip-text text-transparent">রেজিস্ট্রেশন উইজার্ড</span>
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-2">
                    ৪টি সহজ ধাপে তথ্য দিন, সবশেষে পূর্ণাঙ্গ প্রিভিউ কার্ড দেখে নিশ্চিত হয়ে সাবমিট করুন।
                </p>
            </div>

            <!-- Stepper Progress Tracker -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 sm:p-6 mb-8 shadow-xl backdrop-blur">
                <div class="flex items-center justify-between relative mb-4">
                    <!-- Progress line background -->
                    <div class="absolute top-1/2 left-0 right-0 h-1 bg-slate-800 -translate-y-1/2 z-0"></div>
                    <!-- Active progress line -->
                    <div id="step-progress-bar" class="absolute top-1/2 left-0 h-1 bg-gradient-to-r from-amber-500 to-emerald-500 -translate-y-1/2 z-0 transition-all duration-500" style="width: 0%;"></div>

                    <!-- Step 1 Button -->
                    <button type="button" onclick="goToStep(1)" class="relative z-10 flex flex-col items-center group cursor-pointer focus:outline-none">
                        <div id="step-badge-1" class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-amber-500 text-slate-950 ring-4 ring-amber-500/20">
                            <span>১</span>
                        </div>
                        <span id="step-text-1" class="text-[11px] font-black mt-1.5 transition text-amber-400">খেলা নির্বাচন</span>
                    </button>

                    <!-- Step 2 Button -->
                    <button type="button" onclick="goToStep(2)" class="relative z-10 flex flex-col items-center group cursor-pointer focus:outline-none">
                        <div id="step-badge-2" class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-slate-800 text-slate-400 border border-slate-700">
                            <span>২</span>
                        </div>
                        <span id="step-text-2" class="text-[11px] font-bold mt-1.5 transition text-slate-500">ব্যক্তিগত তথ্য</span>
                    </button>

                    <!-- Step 3 Button -->
                    <button type="button" onclick="goToStep(3)" class="relative z-10 flex flex-col items-center group cursor-pointer focus:outline-none">
                        <div id="step-badge-3" class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-slate-800 text-slate-400 border border-slate-700">
                            <span>৩</span>
                        </div>
                        <span id="step-text-3" class="text-[11px] font-bold mt-1.5 transition text-slate-500">পজিশন ও ছবি</span>
                    </button>

                    <!-- Step 4 Button (Review) -->
                    <button type="button" onclick="goToStep(4)" class="relative z-10 flex flex-col items-center group cursor-pointer focus:outline-none">
                        <div id="step-badge-4" class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-slate-800 text-slate-400 border border-slate-700">
                            <span>৪</span>
                        </div>
                        <span id="step-text-4" class="text-[11px] font-bold mt-1.5 transition text-slate-500">যাচাই ও প্রিভিউ</span>
                    </button>
                </div>

                <!-- Step Info Label -->
                <div class="text-center pt-2 border-t border-slate-800/80 text-xs text-slate-400" id="step-desc-text">
                    <span class="font-mono text-amber-400 font-bold">ধাপ ১ / ৪:</span>
                    <span class="text-white font-semibold"> পছন্দের খেলাসমেত টুর্নামেন্ট নির্বাচন করুন</span>
                </div>
            </div>

            <!-- Server Error Display -->
            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-bold flex items-center gap-2">
                    <span class="text-lg">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs">
                    <strong class="font-bold block mb-1">নিচের তথ্যগুলো সংশোধন করুন:</strong>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $isCircularOpen = isset($circular) ? $circular->isOpen() : true;
                $isCircularUpcoming = isset($circular) ? $circular->isUpcoming() : false;
            @endphp

            @if(!$isCircularOpen)
                <!-- Circular Closed or Upcoming Card -->
                <div class="bg-slate-900/90 border {{ $isCircularUpcoming ? 'border-amber-500/40 bg-gradient-to-b from-amber-950/20 to-slate-900/90' : 'border-rose-500/40 bg-gradient-to-b from-rose-950/20 to-slate-900/90' }} rounded-3xl p-8 sm:p-12 shadow-2xl backdrop-blur text-center max-w-2xl mx-auto space-y-6">
                    <div class="w-20 h-20 mx-auto rounded-3xl {{ $isCircularUpcoming ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }} flex items-center justify-center text-4xl shadow-xl">
                        {{ $isCircularUpcoming ? '⏳' : '🛑' }}
                    </div>

                    <div class="space-y-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $isCircularUpcoming ? 'bg-amber-500/10 text-amber-400 border border-amber-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                            {{ $isCircularUpcoming ? 'নিবন্ধন আসন্ন (Upcoming)' : 'আবেদন গ্রহণ বন্ধ (Closed)' }}
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-white">
                            {{ $circular->title ?? 'লোকাল প্লেয়ার ড্রাফট সার্কুলার' }}
                        </h2>
                        <p class="text-slate-300 text-sm leading-relaxed max-w-lg mx-auto">
                            @if($isCircularUpcoming)
                                {{ $circular->upcoming_message ?: 'লোকাল প্লেয়ার টুর্নামেন্ট ড্রাফট নিবন্ধন খুব শীঘ্রই শুরু হবে।' }}
                            @else
                                {{ $circular->closed_message ?: 'লোকাল প্লেয়ার টুর্নামেন্ট ড্রাফট নিবন্ধনের সময়সীমা সমাপ্ত হয়েছে।' }}
                            @endif
                        </p>
                    </div>

                    <!-- Timing Details Badge -->
                    <div class="p-4 rounded-2xl bg-slate-950/90 border border-slate-800 inline-block text-left text-xs space-y-1.5">
                        @if($isCircularUpcoming && $circular && $circular->start_date)
                            <div class="text-slate-400 flex items-center gap-2">
                                <span>🚀 নিবন্ধন শুরুর সময়:</span>
                                <strong class="text-amber-400 font-mono">{{ $circular->start_date->format('d M Y, h:i A') }}</strong>
                            </div>
                        @endif
                        @if($circular && $circular->end_date)
                            <div class="text-slate-400 flex items-center gap-2">
                                <span>🛑 নিবন্ধনের শেষ সময় / ডেডলাইন:</span>
                                <strong class="text-rose-400 font-mono">{{ $circular->end_date->format('d M Y, h:i A') }}</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Navigation Action Buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('public.tournaments.index') }}" 
                           class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition flex items-center justify-center gap-2">
                            <span>🏆 সকল টুর্নামেন্ট ব্রাউজ করুন</span>
                        </a>
                        <a href="{{ url('/') }}" 
                           class="w-full sm:w-auto px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 transition flex items-center justify-center gap-2">
                            <span>← একাডেমি হোমপেজ</span>
                        </a>
                    </div>
                </div>
            @else
            <!-- Client Validation Alert Message -->
            <div id="validation-alert" class="hidden mb-6 p-4 rounded-2xl bg-rose-500/15 border border-rose-500/40 text-rose-300 text-xs font-bold flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-2">
                    <span class="text-lg">⚠️</span>
                    <span id="validation-alert-msg"></span>
                </div>
                <button type="button" onclick="hideAlert()" class="text-slate-400 hover:text-white text-base font-bold">&times;</button>
            </div>

            @if(isset($circular) && $circular->end_date)
                <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-amber-950/40 via-slate-900 to-amber-950/40 border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xl">⏰</span>
                        <div>
                            <div class="font-bold text-white">{{ $circular->title }}</div>
                            <div class="text-slate-400">নিবন্ধনের শেষ সময়: <span class="text-amber-400 font-mono font-bold">{{ $circular->end_date->format('d M Y, h:i A') }}</span></div>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30 shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                        নিবন্ধন উন্মুক্ত রয়েছে
                    </span>
                </div>
            @endif

            <!-- Main Form -->
            <form id="localPlayerForm" action="{{ route('public.local-players.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl backdrop-blur">
                @csrf

                <!-- ============================================================ -->
                <!-- STEP 1: MULTI-SPORTS SELECTION                              -->
                <!-- ============================================================ -->
                <div id="step-1" class="wizard-step space-y-6">
                    <div class="border-b border-slate-800 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <h3 class="text-base sm:text-lg font-black text-white">ধাপ ১: টুর্নামেন্টের খেলা নির্বাচন করুন</h3>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            আপনি কোন কোন খেলায় উন্মুক্ত টুর্নামেন্টে অংশ নিতে চান? এক বা একাধিক খেলা নির্বাচন করতে পারবেন।
                        </p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($sports as $sp)
                            <label class="sport-card relative flex flex-col items-center text-center p-5 rounded-2xl border transition cursor-pointer select-none border-slate-800 bg-slate-950/60 hover:border-slate-700">
                                <input type="checkbox" name="sports[]" value="{{ $sp->id }}" data-name="{{ $sp->name }}" data-icon="{{ $sp->icon ?? '⚽' }}"
                                       class="sport-checkbox sr-only"
                                       onchange="updateSportCardStyle(this)"
                                       {{ $loop->first ? 'checked' : '' }}>
                                <span class="text-4xl mb-2">{{ $sp->icon ?? '⚽' }}</span>
                                <span class="font-bold text-sm text-white">{{ $sp->name }}</span>
                                <span class="text-[10px] text-slate-400 mt-1">{{ $sp->type == 'team' ? 'দলীয় খেলা' : 'ব্যক্তিগত' }}</span>

                                <div class="sport-check-indicator mt-3 w-5 h-5 rounded-full border border-slate-700 flex items-center justify-center transition">
                                    <span class="check-icon hidden text-[10px] font-black">✓</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800/80 text-xs text-slate-400 flex items-center gap-3">
                        <span class="text-2xl">💡</span>
                        <span>যেসব খেলায় আপনি পারদর্শী সেগুলো সিলেক্ট করুন। নির্বাচিত প্রতিটি খেলায় আপনার নামে টুর্নামেন্ট ড্রাফট শিট তৈরি হবে।</span>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="button" onclick="validateAndGoStep(2)"
                                class="px-7 py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-xs uppercase tracking-wider shadow-lg transition flex items-center gap-2">
                            <span>পরবর্তী ধাপ (ব্যক্তিগত তথ্য)</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- STEP 2: PERSONAL & CONTACT INFO                             -->
                <!-- ============================================================ -->
                <div id="step-2" class="wizard-step hidden space-y-6">
                    <div class="border-b border-slate-800 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <h3 class="text-base sm:text-lg font-black text-white">ধাপ ২: খেলোয়াড়ের ব্যক্তিগত ও যোগাযোগের তথ্য</h3>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            আপনার জাতীয় পরিচয়পত্র বা জন্মনিবন্ধন অনুযায়ী সঠিক তথ্য দিন।
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 text-xs">
                        <!-- Full Name -->
                        <div class="lg:col-span-2">
                            <label class="block font-semibold text-slate-300 mb-1.5">খেলোয়াড়ের পুরো নাম <span class="text-rose-500">*</span></label>
                            <input type="text" id="input_name" name="name" value="{{ old('name') }}" placeholder="যেমন: তানভীর আহমেদ সামি" required
                                   class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">বয়সভিত্তিক ক্যাটাগরি <span class="text-rose-500">*</span></label>
                            <select id="input_category" name="category" required
                                    class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-medium">
                                <option value="Senior" {{ old('category') == 'Senior' ? 'selected' : '' }}>সিনিয়র (Senior / Open)</option>
                                <option value="U-19" {{ old('category') == 'U-19' ? 'selected' : '' }}>অনূর্ধ্ব-১৯ (U-19)</option>
                                <option value="U-16" {{ old('category') == 'U-16' ? 'selected' : '' }}>অনূর্ধ্ব-১৬ (U-16)</option>
                                <option value="U-14" {{ old('category') == 'U-14' ? 'selected' : '' }}>অনূর্ধ্ব-১৪ (U-14)</option>
                                <option value="U-12" {{ old('category') == 'U-12' ? 'selected' : '' }}>অনূর্ধ্ব-১২ (U-12)</option>
                            </select>
                        </div>

                        <!-- Phone -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="font-semibold text-slate-300">খেলোয়াড়ের মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                                <span id="phone-status-badge" class="hidden text-[10px] font-bold px-1.5 py-0.5 rounded"></span>
                            </div>
                            <input type="text" id="input_phone" name="phone" value="{{ old('phone') }}" placeholder="017XXXXXXXX" required
                                   class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-mono transition">
                            <div id="phone-feedback" class="mt-1 text-[11px] hidden font-semibold"></div>
                        </div>

                        <!-- Emergency Phone -->
                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">জরুরি মোবাইল / অভিভাবকের নম্বর</label>
                            <input type="text" id="input_emergency_phone" name="emergency_phone" value="{{ old('emergency_phone') }}" placeholder="018XXXXXXXX"
                                   class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-mono">
                        </div>

                        <!-- Guardian Name -->
                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">অভিভাবকের নাম</label>
                            <input type="text" id="input_guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" placeholder="পিতা / মাতার নাম"
                                   class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">জন্ম তারিখ <span class="text-rose-500">*</span></label>
                            <input type="date" id="input_date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                   class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                        </div>

                        <!-- Blood Group -->
                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">রক্তের গ্রুপ</label>
                            <select id="input_blood_group" name="blood_group"
                                    class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                                <option value="">অজ্ঞাত / টেস্ট করা হয়নি</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- NID / Birth Cert -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="font-semibold text-slate-300">জাতীয় পরিচয়পত্র / জন্মনিবন্ধন নং</label>
                                <span id="nid-status-badge" class="hidden text-[10px] font-bold px-1.5 py-0.5 rounded"></span>
                            </div>
                            <input type="text" id="input_nid" name="nid_or_birth_cert" value="{{ old('nid_or_birth_cert') }}" placeholder="১০ বা ১৭ ডিজিট"
                                   class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-mono transition">
                            <div id="nid-feedback" class="mt-1 text-[11px] hidden font-semibold"></div>
                        </div>

                        <!-- Address -->
                        <div class="sm:col-span-2 lg:col-span-3">
                            <label class="block font-semibold text-slate-300 mb-1.5">স্থায়ী ঠিকানা / বর্তমান বাসস্থান <span class="text-rose-500">*</span></label>
                            <textarea id="input_address" name="address" rows="2" placeholder="গ্রাম/পাড়া/এলাকা, ডাকঘর, থানা, জেলা" required
                                      class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <button type="button" onclick="goToStep(1)"
                                class="px-5 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-xs transition">
                            &larr; আগের ধাপ
                        </button>
                        <button type="button" onclick="validateAndGoStep(3)"
                                class="px-7 py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-xs uppercase tracking-wider shadow-lg transition flex items-center gap-2">
                            <span>পরবর্তী ধাপ (পজিশন ও ছবি)</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- STEP 3: POSITION, JERSEY & PHOTO UPLOAD                     -->
                <!-- ============================================================ -->
                <div id="step-3" class="wizard-step hidden space-y-6">
                    <div class="border-b border-slate-800 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <h3 class="text-base sm:text-lg font-black text-white">ধাপ ৩: খেলার ভূমিকা ও পাসপোর্ট সাইজ ছবি</h3>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            টুর্নামেন্ট ডিজিটাল আইডি কার্ড ও ম্যাচ রোস্টারের জন্য আপনার ভূমিকা ও ছবি যুক্ত করুন।
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">খেলার প্রধান পজিশন / রোল</label>
                            <input type="text" id="input_position" name="position" value="{{ old('position') }}" placeholder="যেমন: অলরাউন্ডার / ওপেনিং ব্যাটার / স্ট্রাইকার / ডিফেন্ডার"
                                   class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                            <p class="text-[10px] text-slate-500 mt-1">আপনার প্রধান খেলার অবস্থান বা ভূমিকা লিখুন।</p>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">পছন্দের জার্সি নম্বর (ঐচ্ছিক)</label>
                            <input type="text" id="input_jersey_no" name="jersey_no" value="{{ old('jersey_no') }}" placeholder="যেমন: 10, 07, 18, 99"
                                   class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-mono">
                            <p class="text-[10px] text-slate-500 mt-1">টুর্নামেন্ট কিট ও জার্সির পেছনে প্রিন্ট হবে।</p>
                        </div>
                    </div>

                    <!-- Photo Upload and 300x300 Cropper -->
                    <div class="p-6 rounded-2xl bg-slate-950/70 border border-slate-800 space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-white text-xs uppercase tracking-wider flex items-center gap-2">
                                <span>📷</span> অফিসিয়াল পাসপোর্ট ছবি (৩০০x৩০০ ক্রপার সিস্টেম)
                            </h4>
                            <span class="text-[10px] text-amber-400 font-mono">Square 1:1 Aspect Ratio</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-center">
                            <div class="sm:col-span-2 space-y-2">
                                <input type="file" id="player_photo_input" accept="image/*"
                                       class="block w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer">
                                <p class="text-[11px] text-slate-400">ছবি সিলেক্ট করার পর ক্রপ টুল ওপেন হবে। এটি আপনার অফিসিয়াল প্লেয়ার পাসে প্রিন্ট হবে।</p>
                                <input type="hidden" name="cropped_photo" id="cropped_photo" value="{{ old('cropped_photo') }}">
                            </div>

                            <div class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-900 border border-slate-800 text-center">
                                <div class="w-24 h-24 rounded-2xl bg-slate-950 border-2 border-amber-500/40 overflow-hidden flex items-center justify-center shadow-inner">
                                    <img id="preview_crop_img" src="" alt="প্রিভিউ" class="w-full h-full object-cover hidden">
                                    <span id="placeholder_icon" class="text-3xl text-slate-700">👤</span>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-2 font-mono">৩০০x৩০০ ক্রপ প্রিভিউ</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <button type="button" onclick="goToStep(2)"
                                class="px-5 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-xs transition">
                            &larr; আগের ধাপ
                        </button>
                        <button type="button" onclick="validateAndGoStep(4)"
                                class="px-7 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-xl text-xs uppercase tracking-wider shadow-lg transition flex items-center gap-2">
                            <span>চূড়ান্ত প্রিভিউ দেখুন</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- STEP 4: FULL REVIEW PREVIEW CARD & CONFIRM BEFORE SUBMIT    -->
                <!-- ============================================================ -->
                <div id="step-4" class="wizard-step hidden space-y-6">
                    <div class="border-b border-slate-800 pb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                    <h3 class="text-base sm:text-lg font-black text-white">ধাপ ৪: চূড়ান্ত প্রিভিউ ও যাচাইকরণ (Review All Data)</h3>
                                </div>
                                <p class="text-xs text-slate-400 mt-1">
                                    সাবমিট করার পূর্বে আপনার সকল তথ্য একবার ভালোভাবে দেখে নিন। কোনো ভুল থাকলে পেছনের ধাপে গিয়ে ঠিক করতে পারেন।
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-bold">
                                চূড়ান্ত ধাপ
                            </span>
                        </div>
                    </div>

                    <!-- Digital Player Draft Card Preview -->
                    <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 rounded-3xl border-2 border-emerald-500/30 p-6 sm:p-8 shadow-2xl relative overflow-hidden">
                        <!-- Top Accent Banner -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-800">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-2xl bg-slate-950 border-2 border-amber-400/50 overflow-hidden flex items-center justify-center shadow-lg shrink-0">
                                    <img id="review-photo" src="" alt="Photo" class="w-full h-full object-cover hidden">
                                    <span id="review-photo-placeholder" class="text-3xl text-slate-700">👤</span>
                                </div>
                                <div>
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/30 text-[10px] font-black uppercase tracking-wider">
                                        উন্মুক্ত প্লেয়ার টুর্নামেন্ট ড্রাফট
                                    </span>
                                    <h2 id="review-name" class="text-xl sm:text-2xl font-black text-white mt-1">খেলোয়াড়ের নাম</h2>
                                    <div class="flex items-center gap-2 mt-1 text-xs">
                                        <span id="review-category" class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 font-bold">Senior</span>
                                        <span id="review-position" class="text-slate-400"></span>
                                        <span id="review-jersey" class="text-amber-400 font-mono font-bold"></span>
                                    </div>
                                </div>
                            </div>

                            <button type="button" onclick="goToStep(2)" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold border border-slate-700 transition">
                                ✏️ তথ্য সম্পাদনা
                            </button>
                        </div>

                        <!-- Data Grid Summary -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 py-6 text-xs border-b border-slate-800">
                            <div>
                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">নির্বাচিত খেলাসমূহ:</span>
                                <div id="review-sports-badges" class="flex flex-wrap gap-2 mt-1.5">
                                    <!-- Dynamic sports list inserted here -->
                                </div>
                            </div>

                            <div>
                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">রেজিস্ট্রেশন স্ট্যাটাস:</span>
                                <span class="text-sm font-bold text-emerald-400 mt-1 block">উন্মুক্ত ফ্রি ড্রাফট (সকল টুর্নামেন্টের জন্য সক্রিয়)</span>
                            </div>

                            <div>
                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">প্রধান মোবাইল নম্বর:</span>
                                <span id="review-phone" class="text-sm font-mono font-bold text-white mt-0.5 block">-</span>
                            </div>

                            <div>
                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">জরুরি / অভিভাবকের ফোন:</span>
                                <span id="review-emergency" class="text-sm font-mono font-bold text-slate-300 mt-0.5 block">-</span>
                            </div>

                            <div>
                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">অভিভাবকের নাম:</span>
                                <span id="review-guardian" class="font-semibold text-white mt-0.5 block">-</span>
                            </div>

                            <div>
                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">জন্ম তারিখ ও রক্তের গ্রুপ:</span>
                                <span id="review-dob-blood" class="font-semibold text-white mt-0.5 block">-</span>
                            </div>

                            <div>
                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">NID / জন্মনিবন্ধন নং:</span>
                                <span id="review-nid" class="font-mono text-slate-300 mt-0.5 block">-</span>
                            </div>

                            <div>
                                <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">স্থায়ী ঠিকানা:</span>
                                <span id="review-address" class="text-slate-200 mt-0.5 block leading-relaxed">-</span>
                            </div>
                        </div>

                        <!-- Confirmation Agreement Checkbox -->
                        <div class="pt-5 flex items-start gap-3">
                            <input type="checkbox" id="confirm_declaration" required checked
                                   class="mt-1 w-4 h-4 rounded text-emerald-500 focus:ring-emerald-400 border-slate-700 bg-slate-900">
                            <label for="confirm_declaration" class="text-xs text-slate-300 select-none cursor-pointer leading-relaxed">
                                আমি নিশ্চিত করছি যে উপরে প্রদত্ত সকল ব্যক্তিগত, যোগাযোগ ও খেলার তথ্য সম্পূর্ণ সঠিক। আমি জামিরবাড়িয়া স্পোর্টস একাডেমির টুর্নামেন্ট আচরণবিধি ও নিয়মাবলী মেনে খেলতে সম্মত।
                            </label>
                        </div>
                    </div>

                    <!-- Final Action Buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="button" onclick="goToStep(3)"
                                class="w-full sm:w-auto px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-xs transition">
                            &larr; সংশোধনের জন্য পূর্বের ধাপে যান
                        </button>

                        <button type="submit"
                                class="w-full sm:w-auto px-9 py-4 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black rounded-2xl text-sm shadow-xl shadow-emerald-500/25 transition transform hover:scale-[1.02] flex items-center justify-center gap-2">
                            <span>🚀 তথ্য চূড়ান্ত করে সাবমিট করুন</span>
                            <span>➔</span>
                        </button>
                    </div>
                </div>

            </form>
            @endif

        </div>
    </main>

    <!-- Cropper Modal Popup -->
    <div id="cropperModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-700 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
            <div class="flex items-center justify-between">
                <h4 class="font-bold text-white text-base">ছবি ক্রপ করুন (৩০০x৩০০ স্কয়ার)</h4>
                <button type="button" id="closeModalBtn" class="text-slate-400 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="max-h-80 overflow-hidden rounded-xl bg-black flex items-center justify-center">
                <img id="cropperImage" src="" alt="Crop image" class="max-w-full">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" id="cancelCropBtn" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition">বাতিল</button>
                <button type="button" id="applyCropBtn" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-black transition">ক্রপ সংরক্ষণ করুন</button>
            </div>
        </div>
    </div>

    <!-- Cropper & Wizard Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function showAlert(msg) {
            const alertBox = document.getElementById('validation-alert');
            const alertMsg = document.getElementById('validation-alert-msg');
            alertMsg.innerText = msg;
            alertBox.classList.remove('hidden');
            window.scrollTo({ top: 180, behavior: 'smooth' });
        }

        function hideAlert() {
            document.getElementById('validation-alert').classList.add('hidden');
        }

        function updateSportCardStyle(checkbox) {
            const card = checkbox.closest('.sport-card');
            const indicator = card.querySelector('.sport-check-indicator');
            const icon = card.querySelector('.check-icon');

            if (checkbox.checked) {
                card.classList.add('border-amber-500', 'bg-amber-500/10', 'shadow-lg', 'shadow-amber-500/10');
                card.classList.remove('border-slate-800', 'bg-slate-950/60');
                indicator.classList.add('border-amber-500', 'bg-amber-500', 'text-slate-950');
                indicator.classList.remove('border-slate-700');
                icon.classList.remove('hidden');
            } else {
                card.classList.remove('border-amber-500', 'bg-amber-500/10', 'shadow-lg', 'shadow-amber-500/10');
                card.classList.add('border-slate-800', 'bg-slate-950/60');
                indicator.classList.remove('border-amber-500', 'bg-amber-500', 'text-slate-950');
                indicator.classList.add('border-slate-700');
                icon.classList.add('hidden');
            }
        }

        // Initialize sports cards styling
        document.querySelectorAll('.sport-checkbox').forEach(cb => {
            updateSportCardStyle(cb);
        });

        function validateStep1() {
            hideAlert();
            const checkedSports = document.querySelectorAll('input[name="sports[]"]:checked');
            if (checkedSports.length === 0) {
                showAlert('অনুগ্রহ করে অন্তত একটি খেলা নির্বাচন করুন!');
                return false;
            }
            return true;
        }

        function validateStep2() {
            hideAlert();
            const name = document.getElementById('input_name').value.trim();
            const phone = document.getElementById('input_phone').value.trim();
            const dob = document.getElementById('input_date_of_birth').value;
            const address = document.getElementById('input_address').value.trim();

            if (!name) {
                showAlert('খেলোয়াড়ের পুরো নাম আবশ্যক!');
                document.getElementById('input_name').focus();
                return false;
            }
            if (!phone) {
                showAlert('মোবাইল নম্বর আবশ্যক!');
                document.getElementById('input_phone').focus();
                return false;
            }
            if (!dob) {
                showAlert('জন্ম তারিখ নির্বাচন করুন!');
                document.getElementById('input_date_of_birth').focus();
                return false;
            }
            if (!address) {
                showAlert('স্থায়ী ঠিকানা বা বাসস্থান আবশ্যক!');
                document.getElementById('input_address').focus();
                return false;
            }
            if (phoneDuplicateError) {
                showAlert('এই মোবাইল নম্বর দিয়ে ইতিমধ্যে একজন নিবন্ধিত আছেন! অনুগ্রহ করে অন্য নম্বর প্রদান করুন।');
                document.getElementById('input_phone').focus();
                return false;
            }
            if (nidDuplicateError) {
                showAlert('এই NID / জন্ম নিবন্ধন সনদ নম্বর দিয়ে ইতিমধ্যে একজন নিবন্ধিত আছেন! অনুগ্রহ করে সঠিক তথ্য প্রদান করুন।');
                document.getElementById('input_nid').focus();
                return false;
            }
            return true;
        }

        function validateAndGoStep(targetStep) {
            if (targetStep === 2) {
                if (!validateStep1()) return;
                goToStep(2);
            } else if (targetStep === 3) {
                if (!validateStep2()) return;
                goToStep(3);
            } else if (targetStep === 4) {
                if (!validateStep1() || !validateStep2()) return;
                populateReviewCard();
                goToStep(4);
            }
        }

        function populateReviewCard() {
            // Name
            const name = document.getElementById('input_name').value.trim() || 'খেলোয়াড়ের নাম';
            document.getElementById('review-name').innerText = name;

            // Category
            const category = document.getElementById('input_category').value || 'Senior';
            document.getElementById('review-category').innerText = category;

            // Position & Jersey
            const position = document.getElementById('input_position').value.trim();
            document.getElementById('review-position').innerText = position ? '• ' + position : '';
            const jersey = document.getElementById('input_jersey_no').value.trim();
            document.getElementById('review-jersey').innerText = jersey ? '#' + jersey : '';

            // Phone
            document.getElementById('review-phone').innerText = document.getElementById('input_phone').value.trim() || '-';
            document.getElementById('review-emergency').innerText = document.getElementById('input_emergency_phone').value.trim() || 'দেওয়া হয়নি';
            document.getElementById('review-guardian').innerText = document.getElementById('input_guardian_name').value.trim() || 'অভিভাবক';

            // DOB & Blood
            const dob = document.getElementById('input_date_of_birth').value || '-';
            const blood = document.getElementById('input_blood_group').value;
            document.getElementById('review-dob-blood').innerText = dob + (blood ? ' (' + blood + ')' : '');

            // NID & Address
            document.getElementById('review-nid').innerText = document.getElementById('input_nid').value.trim() || 'প্রযোজ্য নয়';
            document.getElementById('review-address').innerText = document.getElementById('input_address').value.trim() || '-';

            // Photo
            const croppedPhoto = document.getElementById('cropped_photo').value;
            const reviewPhoto = document.getElementById('review-photo');
            const reviewPlaceholder = document.getElementById('review-photo-placeholder');
            if (croppedPhoto && croppedPhoto.startsWith('data:image')) {
                reviewPhoto.src = croppedPhoto;
                reviewPhoto.classList.remove('hidden');
                reviewPlaceholder.classList.add('hidden');
            } else {
                reviewPhoto.classList.add('hidden');
                reviewPlaceholder.classList.remove('hidden');
            }

            // Sports Badges
            const badgesContainer = document.getElementById('review-sports-badges');
            badgesContainer.innerHTML = '';
            document.querySelectorAll('input[name="sports[]"]:checked').forEach(cb => {
                const sName = cb.getAttribute('data-name');
                const sIcon = cb.getAttribute('data-icon');
                const badge = document.createElement('span');
                badge.className = 'px-2.5 py-1 rounded-xl bg-slate-800 border border-slate-700 text-white font-bold flex items-center gap-1.5 text-xs';
                badge.innerHTML = `<span>${sIcon}</span><span>${sName}</span>`;
                badgesContainer.appendChild(badge);
            });
        }

        function goToStep(step) {
            if (step > 1 && !validateStep1()) return;
            if (step > 2 && !validateStep2()) return;

            if (step === 4) {
                populateReviewCard();
            }

            currentStep = step;
            hideAlert();

            // Toggle step visibility
            for (let i = 1; i <= totalSteps; i++) {
                const stepEl = document.getElementById('step-' + i);
                if (i === step) {
                    stepEl.classList.remove('hidden');
                } else {
                    stepEl.classList.add('hidden');
                }
            }

            // Update Progress Bar
            const percent = ((step - 1) / (totalSteps - 1)) * 100;
            document.getElementById('step-progress-bar').style.width = percent + '%';

            // Update Stepper Badges
            for (let i = 1; i <= totalSteps; i++) {
                const badge = document.getElementById('step-badge-' + i);
                const text = document.getElementById('step-text-' + i);

                badge.className = 'w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md ';

                if (i === step) {
                    if (step === 4) {
                        badge.className += 'bg-emerald-500 text-slate-950 ring-4 ring-emerald-500/20 font-black';
                        text.className = 'text-[11px] font-black mt-1.5 transition text-emerald-400';
                    } else {
                        badge.className += 'bg-amber-500 text-slate-950 ring-4 ring-amber-500/20';
                        text.className = 'text-[11px] font-black mt-1.5 transition text-amber-400';
                    }
                    badge.innerHTML = `<span>${i}</span>`;
                } else if (i < step) {
                    badge.className += 'bg-emerald-500 text-slate-950 font-black';
                    text.className = 'text-[11px] font-bold mt-1.5 transition text-slate-400';
                    badge.innerHTML = `<span>✓</span>`;
                } else {
                    badge.className += 'bg-slate-800 text-slate-400 border border-slate-700';
                    text.className = 'text-[11px] font-bold mt-1.5 transition text-slate-500';
                    badge.innerHTML = `<span>${i}</span>`;
                }
            }

            // Update description label
            const descEl = document.getElementById('step-desc-text');
            const descriptions = [
                'পছন্দের খেলাসমেত টুর্নামেন্ট নির্বাচন করুন',
                'খেলোয়াড়ের নাম, যোগাযোগ ও পরিচয় তথ্য প্রদান করুন',
                'খেলার ভূমিকা, জার্সি নম্বর ও পাসপোর্ট ছবি আপলোড করুন',
                'সকল তথ্য একনজরে ভালোভাবে দেখে নিশ্চিত হয়ে সাবমিট করুন'
            ];
            descEl.innerHTML = `<span class="font-mono text-amber-400 font-bold">ধাপ ${step} / ${totalSteps}:</span> <span class="text-white font-semibold"> ${descriptions[step - 1]}</span>`;

            window.scrollTo({ top: 120, behavior: 'smooth' });
        }

        // ==========================================
        // CROPPER.JS IMPLEMENTATION
        // ==========================================
        let cropper = null;
        const photoInput = document.getElementById('player_photo_input');
        const cropperModal = document.getElementById('cropperModal');
        const cropperImage = document.getElementById('cropperImage');
        const applyCropBtn = document.getElementById('applyCropBtn');
        const cancelCropBtn = document.getElementById('cancelCropBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const previewCropImg = document.getElementById('preview_crop_img');
        const placeholderIcon = document.getElementById('placeholder_icon');
        const croppedPhotoInput = document.getElementById('cropped_photo');

        photoInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    cropperImage.src = event.target.result;
                    cropperModal.classList.remove('hidden');
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(cropperImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 0.9,
                        minCropBoxWidth: 150,
                        minCropBoxHeight: 150,
                    });
                };
                reader.readAsDataURL(files[0]);
            }
        });

        applyCropBtn.addEventListener('click', function() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                    imageSmoothingQuality: 'high',
                });
                const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                croppedPhotoInput.value = dataUrl;
                previewCropImg.src = dataUrl;
                previewCropImg.classList.remove('hidden');
                placeholderIcon.classList.add('hidden');
                closeCropper();
            }
        });

        function closeCropper() {
            cropperModal.classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        cancelCropBtn.addEventListener('click', closeCropper);
        closeModalBtn.addEventListener('click', closeCropper);

        // ==========================================
        // ⚡ REAL-TIME AUTOMATIC DUPLICATE VERIFICATION
        // ==========================================
        let phoneDuplicateError = false;
        let nidDuplicateError = false;
        let verifyTimeout = null;

        const livePhoneInput = document.getElementById('input_phone');
        const liveNidInput = document.getElementById('input_nid');
        const phoneBadge = document.getElementById('phone-status-badge');
        const nidBadge = document.getElementById('nid-status-badge');
        const phoneFeedback = document.getElementById('phone-feedback');
        const nidFeedback = document.getElementById('nid-feedback');

        function triggerDuplicateCheck() {
            clearTimeout(verifyTimeout);
            verifyTimeout = setTimeout(performLiveVerification, 400);
        }

        if (livePhoneInput) {
            livePhoneInput.addEventListener('input', triggerDuplicateCheck);
            livePhoneInput.addEventListener('blur', performLiveVerification);
        }
        if (liveNidInput) {
            liveNidInput.addEventListener('input', triggerDuplicateCheck);
            liveNidInput.addEventListener('blur', performLiveVerification);
        }

        function performLiveVerification() {
            const phoneVal = livePhoneInput ? livePhoneInput.value.trim() : '';
            const nidVal = liveNidInput ? liveNidInput.value.trim() : '';
            const nameVal = document.getElementById('input_name').value.trim();
            const dobVal = document.getElementById('input_date_of_birth').value;

            if (!phoneVal && !nidVal) {
                resetBadge(phoneBadge, phoneFeedback, livePhoneInput);
                resetBadge(nidBadge, nidFeedback, liveNidInput);
                phoneDuplicateError = false;
                nidDuplicateError = false;
                return;
            }

            fetch('{{ route("api.verify-player-document") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    phone: phoneVal,
                    nid_or_birth_cert: nidVal,
                    name: nameVal,
                    date_of_birth: dobVal
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success && res.report) {
                    const matches = res.report.matches || [];
                    
                    // Check phone match
                    const phoneMatch = matches.find(m => m.field === 'phone');
                    if (phoneMatch) {
                        phoneDuplicateError = true;
                        setDangerBadge(phoneBadge, phoneFeedback, livePhoneInput, '⚠️ ইতিমধ্যে নিবন্ধিত', phoneMatch.message);
                    } else if (phoneVal.length >= 11) {
                        phoneDuplicateError = false;
                        setSuccessBadge(phoneBadge, phoneFeedback, livePhoneInput, '✓ ইউনিক নম্বর');
                    } else {
                        phoneDuplicateError = false;
                        resetBadge(phoneBadge, phoneFeedback, livePhoneInput);
                    }

                    // Check NID match
                    const nidMatch = matches.find(m => m.field === 'nid_or_birth_cert');
                    if (nidMatch) {
                        nidDuplicateError = true;
                        setDangerBadge(nidBadge, nidFeedback, liveNidInput, '⚠️ ডুপ্লিকেট NID/সনদ', nidMatch.message);
                    } else if (nidVal.length >= 8) {
                        nidDuplicateError = false;
                        setSuccessBadge(nidBadge, nidFeedback, liveNidInput, '✓ ইউনিক ডকুমেন্ট');
                    } else {
                        nidDuplicateError = false;
                        resetBadge(nidBadge, nidFeedback, liveNidInput);
                    }
                }
            })
            .catch(err => console.error('Verification error:', err));
        }

        function setDangerBadge(badge, feedback, input, badgeText, feedbackText) {
            if (!badge || !feedback || !input) return;
            badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 border border-rose-500/30';
            badge.innerText = badgeText;
            badge.classList.remove('hidden');

            feedback.className = 'mt-1 text-[11px] font-bold text-rose-300 bg-rose-950/60 border border-rose-800/60 p-2.5 rounded-xl block shadow-sm';
            feedback.innerHTML = `⚠️ ${feedbackText}`;
            feedback.classList.remove('hidden');

            input.classList.remove('border-slate-700', 'border-emerald-500');
            input.classList.add('border-rose-500', 'ring-1', 'ring-rose-500');
        }

        function setSuccessBadge(badge, feedback, input, badgeText) {
            if (!badge || !feedback || !input) return;
            badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
            badge.innerText = badgeText;
            badge.classList.remove('hidden');

            feedback.className = 'mt-1 text-[11px] font-semibold text-emerald-400 hidden';
            feedback.innerHTML = '';

            input.classList.remove('border-slate-700', 'border-rose-500', 'ring-rose-500');
            input.classList.add('border-emerald-500');
        }

        function resetBadge(badge, feedback, input) {
            if (!badge || !feedback || !input) return;
            badge.classList.add('hidden');
            feedback.classList.add('hidden');
            feedback.innerHTML = '';
            input.classList.remove('border-rose-500', 'ring-1', 'ring-rose-500', 'border-emerald-500');
            input.classList.add('border-slate-700');
        }
    </script>
</body>
</html>

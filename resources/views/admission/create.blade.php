<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>অনলাইন ভর্তি আবেদন | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/cropperjs/cropper.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-900 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-white pb-16">
    <!-- Header -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-slate-950 font-black text-2xl shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                    ⚽
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight text-white block">জামিরবাড়িয়া স্পোর্টস একাডেমি</span>
                    <span class="text-xs uppercase tracking-widest text-emerald-400 font-semibold block">Jamirbaria Sports Academy</span>
                </div>
            </a>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admission.track') }}" class="text-xs font-semibold px-3 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition">
                    🔍 আবেদনের স্ট্যাটাস যাচাই
                </a>
                <a href="{{ url('/') }}" class="text-xs font-medium text-slate-400 hover:text-white px-2 py-1 transition">
                    ← হোমপেজ
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <!-- Hero Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                সেশন ২০২৬ • অনলাইন ভর্তি ফরম
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white">নতুন প্লেয়ার ভর্তি আবেদন</h1>
            <p class="text-slate-400 text-sm mt-2">
                সঠিক তথ্য দিয়ে ফরমটি পূরণ করুন। আবেদন যাচাই শেষে একাডেমি কর্তৃপক্ষ আপনার সাথে যোগাযোগ করবে।
            </p>
        </div>

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm flex items-center gap-3">
                <span class="text-xl">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm">
                <div class="font-bold mb-1">অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</div>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
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
            <div class="bg-slate-800/90 border {{ $isCircularUpcoming ? 'border-amber-500/40 bg-gradient-to-b from-amber-950/20 to-slate-900/90' : 'border-rose-500/40 bg-gradient-to-b from-rose-950/20 to-slate-900/90' }} rounded-3xl p-8 sm:p-12 shadow-2xl backdrop-blur text-center max-w-2xl mx-auto space-y-6">
                <div class="w-20 h-20 mx-auto rounded-3xl {{ $isCircularUpcoming ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }} flex items-center justify-center text-4xl shadow-xl">
                    {{ $isCircularUpcoming ? '⏳' : '🛑' }}
                </div>

                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $isCircularUpcoming ? 'bg-amber-500/10 text-amber-400 border border-amber-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                        {{ $isCircularUpcoming ? 'নিবন্ধন আসন্ন (Upcoming)' : 'আবেদন গ্রহণ বন্ধ (Closed)' }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-white">
                        {{ $circular->title ?? 'ভর্তি সার্কুলার' }}
                    </h2>
                    <p class="text-slate-300 text-sm leading-relaxed max-w-lg mx-auto">
                        @if($isCircularUpcoming)
                            {{ $circular->upcoming_message ?: '২০২৬ শিক্ষাবর্ষের ভর্তি আবেদন খুব শীঘ্রই শুরু হতে যাচ্ছে।' }}
                        @else
                            {{ $circular->closed_message ?: '২০২৬ শিক্ষাবর্ষের প্রাথমিক ভর্তি আবেদন সময়সীমা সমাপ্ত হয়েছে।' }}
                        @endif
                    </p>
                </div>

                <!-- Timing Details Badge -->
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-700/80 inline-block text-left text-xs space-y-1.5">
                    @if($isCircularUpcoming && $circular && $circular->start_date)
                        <div class="text-slate-400 flex items-center gap-2">
                            <span>🚀 আবেদন শুরুর নির্ধারিত সময়:</span>
                            <strong class="text-amber-400 font-mono">{{ $circular->start_date->format('d M Y, h:i A') }}</strong>
                        </div>
                    @endif
                    @if($circular && $circular->end_date)
                        <div class="text-slate-400 flex items-center gap-2">
                            <span>🛑 আবেদনের শেষ সময় / ডেডলাইন:</span>
                            <strong class="text-rose-400 font-mono">{{ $circular->end_date->format('d M Y, h:i A') }}</strong>
                        </div>
                    @endif
                </div>

                <!-- Navigation Action Buttons -->
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('admission.track') }}" 
                       class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-600 transition flex items-center justify-center gap-2">
                        <span>🔍 পূর্ববর্তী আবেদন ট্র্যাক করুন</span>
                    </a>
                    <a href="{{ url('/') }}" 
                       class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-900/30 transition flex items-center justify-center gap-2">
                        <span>← একাডেমি হোমপেজ</span>
                    </a>
                </div>
            </div>
        @else
        <!-- Form Card -->
        <div class="bg-slate-800/80 border border-slate-700 rounded-3xl p-6 sm:p-10 shadow-2xl backdrop-blur">
            @if(isset($circular))
                <div class="mb-6 p-4.5 rounded-2xl bg-gradient-to-r from-emerald-950/40 via-slate-900 to-emerald-950/40 border border-emerald-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
                    <div class="flex items-start sm:items-center gap-3">
                        <span class="text-2xl p-2 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400">🎓</span>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-black text-white text-sm sm:text-base">{{ $circular->title }}</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    আবেদন চলমান
                                </span>
                            </div>
                            @if($circular->description)
                                <p class="text-slate-400 text-xs mt-1">{{ $circular->description }}</p>
                            @endif
                            <div class="flex items-center gap-3 text-[11px] text-slate-300 mt-1 flex-wrap">
                                @if($circular->start_date)
                                    <span>শুরু: <strong class="text-slate-100 font-mono">{{ $circular->start_date->format('d M Y, h:i A') }}</strong></span>
                                    <span>•</span>
                                @endif
                                @if($circular->end_date)
                                    <span>শেষ সময়: <strong class="text-amber-400 font-mono">{{ $circular->end_date->format('d M Y, h:i A') }}</strong></span>
                                @endif
                                @if($circular->fee)
                                    <span>•</span>
                                    <span>নির্ধারিত ফি: <strong class="text-emerald-400 font-mono">৳{{ number_format($circular->fee) }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admission.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @if(isset($circular))
                    <input type="hidden" name="circular_id" value="{{ $circular->id }}">
                @endif

                <!-- Section 1: Sports Selection -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                        <h2 class="text-base font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                            <span>🏆</span> ১. খেলাধুলার ধরন ও বয়স ক্যাটাগরি
                        </h2>
                        <span class="self-start sm:self-auto px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            ✓ মাল্টি-স্পোর্টস অ্যাডমিশন (একই সাথে একাধিক খেলায় ভর্তি)
                        </span>
                    </div>

                    <!-- Multi-Sport Selection Cards -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">
                            কাঙ্ক্ষিত খেলাসমূহ নির্বাচন করুন (এক বা একাধিক খেলা বাছাই করা যাবে) <span class="text-rose-400">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($sports as $sport)
                                <label class="relative flex flex-col p-3.5 rounded-2xl border border-slate-700 hover:border-emerald-500 cursor-pointer bg-slate-900/80 transition has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-950/30">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-2xl">{{ $sport->icon ?? '⚽' }}</span>
                                        <input type="checkbox" name="sports[]" value="{{ $sport->id }}" {{ (is_array(old('sports')) && in_array($sport->id, old('sports'))) || ($loop->first && !old('sports')) ? 'checked' : '' }} class="rounded text-emerald-600 focus:ring-emerald-500 border-slate-600 bg-slate-800">
                                    </div>
                                    <span class="font-bold text-xs text-white">{{ $sport->name }}</span>
                                    <span class="text-[10px] text-slate-400 mt-0.5 line-clamp-1">{{ $sport->description ?? '' }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-slate-400 mt-2">খেলোয়াড় একই সাথে ফুটবল, ক্রিকেট, অ্যাথলেটিক্স বা ব্যাডমিন্টনে ভর্তি হতে পারবেন।</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">বয়স ক্যাটাগরি <span class="text-rose-400">*</span></label>
                        <select name="category" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                            <option value="">ক্যাটাগরি বাছাই করুন...</option>
                            <option value="U-12" {{ old('category') == 'U-12' ? 'selected' : '' }}>U-12 (অনূর্ধ্ব ১২)</option>
                            <option value="U-14" {{ old('category') == 'U-14' ? 'selected' : '' }}>U-14 (অনূর্ধ্ব ১৪)</option>
                            <option value="U-16" {{ old('category', 'U-16') == 'U-16' ? 'selected' : '' }}>U-16 (অনূর্ধ্ব ১৬)</option>
                            <option value="U-19" {{ old('category') == 'U-19' ? 'selected' : '' }}>U-19 (অনূর্ধ্ব ১৯)</option>
                            <option value="Senior" {{ old('category') == 'Senior' ? 'selected' : '' }}>Senior (সিনিয়র)</option>
                        </select>
                    </div>
                </div>

                <hr class="border-slate-700/60" />

                <!-- Section 2: Personal Information -->
                <div>
                    <h2 class="text-base font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>👤</span> ২. প্লেয়ারের ব্যক্তিগত তথ্য
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">
                                প্লেয়ারের নাম (বাংলায়) <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="উদা: আরিয়ান আহমেদ" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>প্লেয়ারের নাম (ইংরেজিতে)</span>
                                <span class="text-[10px] text-slate-400 font-normal">Full Name (English)</span>
                            </label>
                            <input type="text" name="name_en" value="{{ old('name_en') }}" placeholder="e.g. Arian Ahmed" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">অভিভাবকের নাম (Father/Mother/Guardian) <span class="text-rose-400">*</span></label>
                            <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" required placeholder="অভিভাবকের পূর্ণ নাম" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">জন্ম তারিখ (Date of Birth) <span class="text-rose-400">*</span></label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>জন্ম নিবন্ধন / জাতীয় পরিচয়পত্র নম্বর (NID / Birth Cert)</span>
                                <span class="text-[10px] text-emerald-400 font-mono">লাইভ ভেরিফিকেশন</span>
                            </label>
                            <input type="text" name="nid_or_birth_cert" id="nid_or_birth_cert" value="{{ old('nid_or_birth_cert') }}" placeholder="উদা: 20081234567890123 (১০/১৩/১৭ ডিজিট)" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm font-mono">
                            <div id="nid-verify-feedback" class="hidden mt-1.5 text-xs p-2.5 rounded-xl border"></div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">রক্তের গ্রুপ (Blood Group)</label>
                            <select name="blood_group" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                                <option value="">বাছাই করুন (ঐচ্ছিক)...</option>
                                <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">পজিশন / রোল (Position/Speciality)</label>
                            <input type="text" name="position" value="{{ old('position') }}" placeholder="উদা: স্ট্রাইকার / অলরাউন্ডার / স্প্রিন্টার" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">কাঙ্ক্ষিত জার্সি নম্বর / সাইজ (Jersey No / Size)</label>
                            <input type="text" name="jersey_no" value="{{ old('jersey_no') }}" placeholder="উদা: ৭ অথবা সাইজ M/L" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">শিক্ষা প্রতিষ্ঠান বা কর্মক্ষেত্র (School/College/Organization)</label>
                            <input type="text" name="organization_or_area" value="{{ old('organization_or_area') }}" placeholder="উদা: জামিরবাড়িয়া উচ্চ বিদ্যালয় / সরকারি কলেজ" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-700/60" />

                <!-- Section 3: Contact & Address -->
                <div>
                    <h2 class="text-base font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>📞</span> ৩. যোগাযোগ ও ঠিকানা
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>মোবাইল নম্বর (ইংরেজিতে) <span class="text-rose-400">*</span></span>
                                <span class="text-[10px] text-emerald-400 font-mono">English digits only</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="01712345678" pattern="[0-9+ -]+" inputmode="numeric" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm font-mono english-number-only">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>জরুরি যোগাযোগের নম্বর (Emergency)</span>
                                <span class="text-[10px] text-slate-400 font-mono">English digits</span>
                            </label>
                            <input type="tel" name="emergency_phone" id="emergency_phone" value="{{ old('emergency_phone') }}" placeholder="01812345678" pattern="[0-9+ -]+" inputmode="numeric" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm font-mono english-number-only">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">বর্তমান ঠিকানা <span class="text-rose-400">*</span></label>
                            <textarea name="address" rows="3" required placeholder="গ্রাম/রোড, থানা, জেলা" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-700/60" />

                <!-- Section 4: Photo Upload with 300x300 Cropper -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-base font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                            <span>📸</span> ৪. প্লেয়ারের পাসপোর্ট সাইজ ছবি (Player Photo)
                        </h2>
                        <span class="text-[11px] font-semibold text-emerald-300 bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">
                            📐 সাইজ: ৩০০ × ৩০০ পিক্সেল (১:১)
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-6 p-5 rounded-2xl bg-slate-900/60 border border-slate-700/60">
                        <!-- Photo Preview Box -->
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-2xl bg-slate-800 border-2 border-dashed border-slate-600 flex items-center justify-center overflow-hidden shrink-0 shadow-inner" id="preview-box">
                                <img id="preview-img" src="" alt="Photo Preview" class="w-full h-full object-cover hidden">
                                <span id="preview-placeholder" class="text-slate-400 text-xs text-center px-2">ছবি আপলোড করুন</span>
                            </div>
                            <span id="crop-badge" class="hidden absolute -bottom-2 -right-2 bg-emerald-500 text-slate-950 font-bold text-[10px] px-2 py-0.5 rounded-full shadow">✓ 300×300</span>
                        </div>

                        <div class="flex-1 w-full space-y-2">
                            <label class="block text-xs font-semibold text-slate-300">ছবি নির্বাচন করুন (কম্পিউটার বা মোবাইল থেকে)</label>
                            <input type="file" name="photo" id="photo-input" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/10 file:text-emerald-400 hover:file:bg-emerald-500/20 cursor-pointer">
                            <!-- Hidden input storing the 300x300 cropped base64 image -->
                            <input type="hidden" name="cropped_photo" id="cropped_photo">
                            
                            <p class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                <span class="text-emerald-400">💡</span> ছবি সিলেক্ট করার সাথে সাথেই আপনি ছবিটিকে সহজে ড্র্যাগ, জুম ও রোটেট করে সঠিক ৩০০×৩০০ মাপে কেটে নিতে পারবেন।
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-700/60" />

                <!-- Section 5: Manual Payment Selection (ম্যানুয়াল ফি পরিশোধ) -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-base font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                            <span>💳</span> ৫. ভর্তি ফি পরিশোধ (Manual Payment)
                        </h2>
                        <span class="text-xs font-bold text-white bg-slate-700/80 px-3 py-1 rounded-full border border-slate-600">
                            ভর্তি ফি: <span class="text-emerald-400 font-mono text-sm">৳ ১,০০০</span>
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mb-4">
                        আমাদের অফিসিয়াল একাউন্টে ফি পাঠিয়ে ট্রানজেকশন তথ্য দিন অথবা সরাসরি একাডেমির অফিসে এসে ক্যাশ ফি জমা দিন।
                    </p>

                    <input type="hidden" name="payment_amount" value="1000">

                    <!-- Payment Method Radio Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-5">
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="bkash" class="peer sr-only" {{ old('payment_method', 'bkash') == 'bkash' ? 'checked' : '' }}>
                            <div class="p-3 rounded-xl border border-slate-700 bg-slate-900/60 peer-checked:border-pink-500 peer-checked:bg-pink-500/10 peer-checked:text-pink-400 text-center transition hover:border-slate-600">
                                <div class="text-xl mb-1">📱</div>
                                <div class="text-xs font-bold">বিকাশ</div>
                                <div class="text-[10px] text-slate-400">bKash Personal</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="nagad" class="peer sr-only" {{ old('payment_method') == 'nagad' ? 'checked' : '' }}>
                            <div class="p-3 rounded-xl border border-slate-700 bg-slate-900/60 peer-checked:border-orange-500 peer-checked:bg-orange-500/10 peer-checked:text-orange-400 text-center transition hover:border-slate-600">
                                <div class="text-xl mb-1">📱</div>
                                <div class="text-xs font-bold">নগদ</div>
                                <div class="text-[10px] text-slate-400">Nagad Personal</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="rocket" class="peer sr-only" {{ old('payment_method') == 'rocket' ? 'checked' : '' }}>
                            <div class="p-3 rounded-xl border border-slate-700 bg-slate-900/60 peer-checked:border-purple-500 peer-checked:bg-purple-500/10 peer-checked:text-purple-400 text-center transition hover:border-slate-600">
                                <div class="text-xl mb-1">📱</div>
                                <div class="text-xs font-bold">রকেট</div>
                                <div class="text-[10px] text-slate-400">Rocket Personal</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="peer sr-only" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                            <div class="p-3 rounded-xl border border-slate-700 bg-slate-900/60 peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 peer-checked:text-emerald-400 text-center transition hover:border-slate-600">
                                <div class="text-xl mb-1">💵</div>
                                <div class="text-xs font-bold">অফিস ক্যাশ</div>
                                <div class="text-[10px] text-slate-400">Cash on Counter</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="bank" class="peer sr-only" {{ old('payment_method') == 'bank' ? 'checked' : '' }}>
                            <div class="p-3 rounded-xl border border-slate-700 bg-slate-900/60 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 peer-checked:text-blue-400 text-center transition hover:border-slate-600">
                                <div class="text-xl mb-1">🏦</div>
                                <div class="text-xs font-bold">ব্যাংক ডিপোজিট</div>
                                <div class="text-[10px] text-slate-400">Bank Transfer</div>
                            </div>
                        </label>
                    </div>

                    <!-- Dynamic Payment Instructions Card -->
                    <div id="method-instruction-box" class="p-4 rounded-2xl bg-slate-900/80 border border-slate-700 text-xs mb-5">
                        <!-- Populated by JS -->
                    </div>

                    <!-- Trx Details (Hidden if Cash) -->
                    <div id="transaction-fields-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1" id="sender-label">
                                প্রেরকের মোবাইল নম্বর (English digits) <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" name="sender_number" id="sender_number" value="{{ old('sender_number') }}" placeholder="01712345678" inputmode="numeric" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white font-mono focus:ring-2 focus:ring-emerald-500 text-sm english-number-only">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1" id="trx-label">
                                ট্রানজেকশন আইডি (TrxID / রেফারেন্স) <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" placeholder="উদা: BCL829AKX7" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white font-mono focus:ring-2 focus:ring-emerald-500 text-sm uppercase">
                        </div>
                    </div>
                </div>

                <!-- Terms & Submit -->
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-700/60">
                    <label class="flex items-start gap-2.5 cursor-pointer text-xs text-slate-300">
                        <input type="checkbox" name="agree_terms" required checked class="rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-500 mt-0.5">
                        <span>
                            আমি জামিরবাড়িয়া স্পোর্টস একাডেমির <a href="{{ route('rules') }}" target="_blank" class="text-emerald-400 font-bold hover:underline">নিয়মাবলী ও শর্তাবলী (Rules & Terms)</a> পড়েছি এবং এর সাথে সম্পূর্ণ একমত পোষণ করছি।
                        </span>
                    </label>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black rounded-xl text-base shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2 shrink-0">
                        <span>জমা দিন ও আবেদন নিশ্চিত করুন</span>
                        <span>➔</span>
                    </button>
                </div>
            </form>
        </div>
        @endif
    </main>

    <!-- 300x300 Cropper Modal Dialog -->
    <div id="cropper-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/85 backdrop-blur-sm hidden">
        <div class="bg-slate-900 border border-slate-700 rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-emerald-400 text-lg">✂️</span>
                    <div>
                        <h3 class="text-sm font-bold text-white">ছবি ক্রপ করুন (৩০০ × ৩০০ পিক্সেল)</h3>
                        <p class="text-[11px] text-slate-400">ছবিটি প্রয়োজনমতো জুম বা রোটেট করে বক্সে বসান</p>
                    </div>
                </div>
                <button type="button" id="cropper-close-btn" class="text-slate-400 hover:text-white text-xl font-bold p-1 leading-none">&times;</button>
            </div>

            <!-- Cropping Workspace -->
            <div class="p-4 flex-1 overflow-hidden flex items-center justify-center bg-slate-950/60">
                <div class="max-h-[50vh] max-w-full">
                    <img id="cropper-image" src="" alt="Crop Image" class="max-w-full block">
                </div>
            </div>

            <!-- Cropper Controls Toolbar -->
            <div class="px-4 py-2.5 bg-slate-800/80 border-t border-slate-800 flex flex-wrap items-center justify-center gap-2 text-xs">
                <button type="button" id="crop-zoom-in" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">🔍+ জুম ইন</button>
                <button type="button" id="crop-zoom-out" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">🔍- জুম আউট</button>
                <button type="button" id="crop-rotate-left" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">↺ ৯০° বামে</button>
                <button type="button" id="crop-rotate-right" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">↻ ৯০° ডানে</button>
                <button type="button" id="crop-reset" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">⟲ রিসেট</button>
            </div>

            <!-- Modal Action Buttons -->
            <div class="px-6 py-4 border-t border-slate-800 flex items-center justify-between bg-slate-900">
                <button type="button" id="crop-cancel-btn" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:bg-slate-800 border border-slate-700">বাতিল</button>
                <button type="button" id="crop-confirm-btn" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-lg shadow-emerald-500/20 flex items-center gap-1.5">
                    <span>✓ ৩০০×৩০০ সাইজে সংরক্ষণ করুন</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Cropper.js Script -->
    <script src="{{ asset('vendor/cropperjs/cropper.min.js') }}"></script>
    <script>
        // -------------------------------------------------------------
        // 1. Cropper.js 300x300 Modal Logic
        // -------------------------------------------------------------
        let cropper = null;
        const photoInput = document.getElementById('photo-input');
        const cropperModal = document.getElementById('cropper-modal');
        const cropperImage = document.getElementById('cropper-image');
        const croppedPhotoInput = document.getElementById('cropped_photo');
        const previewImg = document.getElementById('preview-img');
        const previewPlaceholder = document.getElementById('preview-placeholder');
        const cropBadge = document.getElementById('crop-badge');

        photoInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(evt) {
                    cropperImage.src = evt.target.result;
                    cropperModal.classList.remove('hidden');
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(cropperImage, {
                        aspectRatio: 1, // 1:1 square
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 0.9,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        // Controls
        document.getElementById('crop-zoom-in').addEventListener('click', () => cropper && cropper.zoom(0.1));
        document.getElementById('crop-zoom-out').addEventListener('click', () => cropper && cropper.zoom(-0.1));
        document.getElementById('crop-rotate-left').addEventListener('click', () => cropper && cropper.rotate(-90));
        document.getElementById('crop-rotate-right').addEventListener('click', () => cropper && cropper.rotate(90));
        document.getElementById('crop-reset').addEventListener('click', () => cropper && cropper.reset());

        function closeCropper() {
            cropperModal.classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }
        document.getElementById('cropper-close-btn').addEventListener('click', closeCropper);
        document.getElementById('crop-cancel-btn').addEventListener('click', closeCropper);

        // Confirm Crop & Generate 300x300 Output
        document.getElementById('crop-confirm-btn').addEventListener('click', function() {
            if (!cropper) return;
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            const base64Url = canvas.toDataURL('image/jpeg', 0.92);
            croppedPhotoInput.value = base64Url;
            previewImg.src = base64Url;
            previewImg.classList.remove('hidden');
            previewPlaceholder.classList.add('hidden');
            cropBadge.classList.remove('hidden');

            closeCropper();
        });

        // -------------------------------------------------------------
        // 2. Manual Payment Method Switcher
        // -------------------------------------------------------------
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const instructionBox = document.getElementById('method-instruction-box');
        const trxContainer = document.getElementById('transaction-fields-container');
        const senderLabel = document.getElementById('sender-label');
        const trxLabel = document.getElementById('trx-label');
        const senderInput = document.getElementById('sender_number');
        const trxInput = document.getElementById('transaction_id');

        const methodGuides = {
            bkash: {
                title: 'বিকাশ (bKash) পেমেন্ট নির্দেশিকা:',
                desc: 'বিকাশ অ্যাপ বা *247# থেকে <strong>Send Money</strong> করুন আমাদের পার্সোনাল নাম্বারে: <span class="text-pink-400 font-mono font-bold text-sm select-all">01712-345678</span>। টাকা পাঠানোর পর মেসেজের <strong>TrxID</strong> এবং আপনার বিকাশ নাম্বারটি নিচে লিখুন।',
                senderPlaceholder: 'যে বিকাশ নম্বর থেকে টাকা পাঠিয়েছেন (01XXXXXXXXX)',
                trxPlaceholder: 'উদা: BCL829AKX7',
                showTrx: true,
                badgeClass: 'border-pink-500/30 text-pink-300'
            },
            nagad: {
                title: 'নগদ (Nagad) পেমেন্ট নির্দেশিকা:',
                desc: 'নগদ অ্যাপ বা *167# থেকে <strong>Send Money</strong> করুন আমাদের পার্সোনাল নাম্বারে: <span class="text-orange-400 font-mono font-bold text-sm select-all">01712-345678</span>। টাকা পাঠানোর পর ট্রানজেকশন আইডি (TrxID) ও আপনার নগদ নাম্বার নিচে দিন।',
                senderPlaceholder: 'যে নগদ নম্বর থেকে টাকা পাঠিয়েছেন (01XXXXXXXXX)',
                trxPlaceholder: 'উদা: 7D76AK29',
                showTrx: true,
                badgeClass: 'border-orange-500/30 text-orange-300'
            },
            rocket: {
                title: 'রকেট (Rocket) পেমেন্ট নির্দেশিকা:',
                desc: 'রকেট অ্যাপ বা *322# থেকে <strong>Send Money</strong> করুন: <span class="text-purple-400 font-mono font-bold text-sm select-all">01712-345678-9</span>। সফল ট্রানজেকশনের TrxID ও প্রেরক রকেট নম্বর নিচে দিন।',
                senderPlaceholder: '১২ ডিজিটের রকেট মোবাইল নম্বর',
                trxPlaceholder: 'উদা: 92837482',
                showTrx: true,
                badgeClass: 'border-purple-500/30 text-purple-300'
            },
            bank: {
                title: 'ব্যাংক ট্রান্সফার / চেক / ডিপোজিট স্লিপ নির্দেশিকা:',
                desc: 'ব্যাংক হিসাব নাম: <strong>জামিরবাড়িয়া স্পোর্টস একাডেমি</strong> | হিসাব নং: <span class="text-blue-400 font-mono font-bold text-sm select-all">102.120.45678</span> | সোনালী ব্যাংক / ডাচ-বাংলা ব্যাংক লিমিটেড। ডিপোজিট স্লিপের রেফারেন্স বা চেক নম্বর নিচে দিন।',
                senderPlaceholder: 'প্রেরকের ব্যাংক একাউন্ট নাম / নম্বর',
                trxPlaceholder: 'ব্যাংক ডিপোজিট স্লিপ নং / রেফারেন্স নং',
                showTrx: true,
                badgeClass: 'border-blue-500/30 text-blue-300'
            },
            cash: {
                title: 'অফিস ক্যাশ কাউন্টারে সরাসরি ফি জমা:',
                desc: 'অনলাইনে আবেদন সম্পন্ন করার পর আপনি সরাসরি জামিরবাড়িয়া একাডেমি অফিস কাউন্টারে এসে ক্যাশ ৳১,০০০ ফি জমা দিয়ে ভর্তি অনুমোদন চূড়ান্ত করতে পারবেন।',
                showTrx: false,
                badgeClass: 'border-emerald-500/30 text-emerald-300'
            }
        };

        function updatePaymentUI() {
            const selected = document.querySelector('input[name="payment_method"]:checked')?.value || 'bkash';
            const guide = methodGuides[selected];
            if (!guide) return;

            instructionBox.className = `p-4 rounded-2xl bg-slate-900/80 border ${guide.badgeClass} text-xs mb-5`;
            instructionBox.innerHTML = `
                <div class="font-bold mb-1">${guide.title}</div>
                <div class="text-slate-300 leading-relaxed">${guide.desc}</div>
            `;

            if (guide.showTrx) {
                trxContainer.classList.remove('hidden');
                senderInput.required = true;
                trxInput.required = true;
                senderInput.placeholder = guide.senderPlaceholder;
                trxInput.placeholder = guide.trxPlaceholder;
            } else {
                trxContainer.classList.add('hidden');
                senderInput.required = false;
                trxInput.required = false;
                senderInput.value = '';
                trxInput.value = '';
            }
        }

        paymentMethods.forEach(radio => radio.addEventListener('change', updatePaymentUI));
        updatePaymentUI();

        // -------------------------------------------------------------
        // 3. Live Real-time NID / Birth Cert Duplicate Checker
        // -------------------------------------------------------------
        const nidInput = document.getElementById('nid_or_birth_cert');
        const phoneInput = document.querySelector('input[name="phone"]');
        const nidFeedback = document.getElementById('nid-verify-feedback');
        let checkTimer = null;

        function checkLiveDuplicate() {
            const docVal = nidInput ? nidInput.value.trim() : '';
            const phoneVal = phoneInput ? phoneInput.value.trim() : '';

            if (docVal.length < 8 && phoneVal.length < 10) {
                if (nidFeedback) nidFeedback.classList.add('hidden');
                return;
            }

            fetch(`{{ route('api.verify-player-document') }}?nid_or_birth_cert=${encodeURIComponent(docVal)}&phone=${encodeURIComponent(phoneVal)}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.report && nidFeedback) {
                        const r = data.report;
                        nidFeedback.classList.remove('hidden');
                        if (r.is_strict_duplicate) {
                            nidFeedback.className = 'mt-1.5 text-xs p-2.5 rounded-xl border border-rose-500/40 bg-rose-500/10 text-rose-300';
                            nidFeedback.innerHTML = `⚠️ <strong>সতর্কবার্তা:</strong> এই নম্বর দিয়ে ইতিমধ্যে একজন প্লেয়ার (${r.matches[0]?.name || 'নিবন্ধিত'}) অ্যাকাউন্টে রয়েছেন।`;
                        } else if (docVal.length >= 10) {
                            nidFeedback.className = 'mt-1.5 text-xs p-2.5 rounded-xl border border-emerald-500/40 bg-emerald-500/10 text-emerald-300';
                            nidFeedback.innerHTML = `✓ <strong>যাচাই সম্পন্ন:</strong> জন্ম নিবন্ধন / এনআইডি নম্বরটি নতুন প্লেয়ার হিসেবে গ্রহণের জন্য প্রস্তুত।`;
                        } else {
                            nidFeedback.classList.add('hidden');
                        }
                    }
                })
                .catch(() => {});
        }

        if (nidInput) {
            nidInput.addEventListener('input', () => {
                clearTimeout(checkTimer);
                checkTimer = setTimeout(checkLiveDuplicate, 450);
            });
        }
        if (phoneInput) {
            phoneInput.addEventListener('blur', checkLiveDuplicate);
        }

        // -------------------------------------------------------------
        // 4. English Digits Only (Auto-convert Bangla digits 0-9 & strip letters)
        // -------------------------------------------------------------
        const bnDigitsMap = { '০': '0', '১': '1', '২': '2', '৩': '3', '৪': '4', '৫': '5', '৬': '6', '৭': '7', '৮': '8', '৯': '9' };
        function enforceEnglishPhone(el) {
            if (!el) return;
            const sanitize = () => {
                let v = el.value;
                // Replace any Bangla digits with English digits
                v = v.replace(/[০-৯]/g, d => bnDigitsMap[d] || d);
                // Keep only English digits, +, -, and spaces
                v = v.replace(/[^0-9+\- ]/g, '');
                if (el.value !== v) {
                    el.value = v;
                }
            };
            el.addEventListener('input', sanitize);
            el.addEventListener('change', sanitize);
            el.addEventListener('paste', () => setTimeout(sanitize, 10));
        }

        document.querySelectorAll('.english-number-only, #sender_number, #phone, #emergency_phone').forEach(enforceEnglishPhone);
    </script>
</body>
</html>

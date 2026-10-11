<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>স্বেচ্ছাসেবক (Volunteer) আবেদন | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/cropperjs/cropper.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#070d14] text-slate-100 min-h-screen selection:bg-amber-500 selection:text-slate-950 font-sans sports-turf-mesh pb-20">

    <!-- Top Sticky Header -->
    <header class="border-b border-slate-800/80 bg-slate-900/70 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <span class="text-2xl">⚽</span>
                <div>
                    <h1 class="text-sm font-black text-white leading-tight">জামিরবাড়িয়া স্পোর্টস একাডেমি</h1>
                    <p class="text-[10px] text-amber-400 font-bold">অফিসিয়াল ভলান্টিয়ার উইং • ২০২৬</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <form action="{{ route('volunteer.track.search') }}" method="POST" class="hidden sm:flex items-center">
                    @csrf
                    <div class="relative">
                        <input type="text" name="query" placeholder="আবেদন নম্বর / ফোন..." required class="bg-slate-950 border border-slate-700/80 rounded-xl px-3 py-1.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-amber-500 w-44">
                        <button type="submit" class="absolute right-1 top-1 px-2 py-0.5 bg-amber-500 text-slate-950 font-bold rounded-lg text-[10px]">খুঁজুন</button>
                    </div>
                </form>
                <a href="{{ url('/') }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                    হোম পেজ
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 pt-8">
        <!-- Hero Title Banner -->
        <div class="text-center mb-8 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-bold uppercase tracking-wider">
                <span>🤝</span> জামিরবাড়িয়া একাডেমি ভলান্টিয়ার্স
            </div>
            <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                স্বেচ্ছাসেবক আবেদন ফরম (Volunteer Registration)
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 max-w-2xl mx-auto leading-relaxed">
                আমাদের বিভিন্ন টুর্নামেন্ট, ম্যাচ ডে, একাডেমি প্রোগ্রাম ও সামাজিক ক্রীড়া ইভেন্টে মাঠে থেকে নেতৃত্ব দিন। নির্বাচিত স্বেচ্ছাসেবকদের একাডেমি কর্তৃক অফিসিয়াল ফটো আইডি ব্যাজ, ভলান্টিয়ার জার্সি ও প্রশংসাপত্র প্রদান করা হবে।
            </p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-bold flex items-center gap-2">
                <span>❌</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs space-y-1">
                <div class="font-bold flex items-center gap-1.5">
                    <span>⚠️</span> অনুগ্রহ করে নিচের ভুলগুলো সংশোধন করুন:
                </div>
                <ul class="list-disc pl-5 space-y-0.5">
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
                        {{ $isCircularUpcoming ? 'আবেদন আসন্ন (Upcoming)' : 'আবেদন গ্রহণ বন্ধ (Closed)' }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-white">
                        {{ $circular->title ?? 'ভলান্টিয়ার সার্কুলার' }}
                    </h2>
                    <p class="text-slate-300 text-sm leading-relaxed max-w-lg mx-auto">
                        @if($isCircularUpcoming)
                            {{ $circular->upcoming_message ?: 'ভলান্টিয়ার আবেদন প্রক্রিয়া খুব শীঘ্রই শুরু হতে যাচ্ছে।' }}
                        @else
                            {{ $circular->closed_message ?: 'ভলান্টিয়ার আবেদন প্রক্রিয়া বর্তমানে বন্ধ রয়েছে বা নির্ধারিত সময়সীমা সমাপ্ত হয়েছে।' }}
                        @endif
                    </p>
                </div>

                <!-- Timing Details Badge -->
                <div class="p-4 rounded-2xl bg-slate-950/90 border border-slate-800 inline-block text-left text-xs space-y-1.5">
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
                    <a href="{{ route('volunteer.tracking', 'VOL-SEARCH') }}" 
                       class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition flex items-center justify-center gap-2">
                        <span>🔍 পূর্ববর্তী ভলান্টিয়ার ট্র্যাকিং</span>
                    </a>
                    <a href="{{ url('/') }}" 
                       class="w-full sm:w-auto px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 transition flex items-center justify-center gap-2">
                        <span>← একাডেমি হোমপেজ</span>
                    </a>
                </div>
            </div>
        @else
        <!-- Form Card -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden backdrop-blur-sm">
            <!-- Glow background -->
            <div class="absolute -top-32 -right-32 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            @if(isset($circular) && $circular->end_date)
                <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-amber-950/40 via-slate-900 to-amber-950/40 border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xl">⏰</span>
                        <div>
                            <div class="font-bold text-white">{{ $circular->title }}</div>
                            <div class="text-slate-400">আবেদনের শেষ সময়: <span class="text-amber-400 font-mono font-bold">{{ $circular->end_date->format('d M Y, h:i A') }}</span></div>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30 shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                        আবেদন উন্মুক্ত রয়েছে
                    </span>
                </div>
            @endif

            <form action="{{ route('volunteer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section 1: Department & Event Preference -->
                <div>
                    <h2 class="text-sm font-black text-amber-400 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>🎯</span> ১. আগ্রহ ও কাজের বিভাগ (Department & Event)
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">
                                যে বিভাগে কাজ করতে বেশি আগ্রহী <span class="text-rose-400">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($departments as $key => $label)
                                    <label class="relative flex items-center gap-3 p-3.5 rounded-2xl border border-slate-700/80 hover:border-amber-500 cursor-pointer bg-slate-950/60 transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-500/10">
                                        <input type="radio" name="department" value="{{ $key }}" {{ old('department', 'general') == $key ? 'checked' : '' }} class="text-amber-500 focus:ring-amber-500 border-slate-600 bg-slate-800">
                                        <span class="text-xs font-bold text-white">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">নির্দিষ্ট কোনো টুর্নামেন্টের জন্য আবেদন করছেন? (ঐচ্ছিক)</label>
                            <select name="tournament_id" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                                <option value="">সকল একাডেমি ও লোকাল টুর্নামেন্ট (উন্মুক্ত ভলান্টিয়ার)</option>
                                @foreach($tournaments as $t)
                                    <option value="{{ $t->id }}" {{ old('tournament_id') == $t->id ? 'selected' : '' }}>
                                        🏆 {{ $t->name }} ({{ strtoupper($t->sport_type) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 2: Personal Information -->
                <div>
                    <h2 class="text-sm font-black text-amber-400 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>👤</span> ২. ব্যক্তিগত বিবরণ (Personal Information)
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">
                                আপনার নাম (বাংলায়) <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="উদা: রাকিবুল ইসলাম" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>নাম (ইংরেজিতে / Full Name)</span>
                                <span class="text-[10px] text-slate-400">আইডি কার্ডের জন্য</span>
                            </label>
                            <input type="text" name="name_en" value="{{ old('name_en') }}" placeholder="e.g. Rakibul Islam" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">লিঙ্গ (Gender) <span class="text-rose-400">*</span></label>
                            <select name="gender" required class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                                <option value="male" {{ old('gender', 'male') == 'male' ? 'selected' : '' }}>পুরুষ (Male)</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>নারী (Female)</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>অন্যান্য (Other)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">জন্ম তারিখ (Date of Birth)</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">রক্তের গ্রুপ (Blood Group)</label>
                            <select name="blood_group" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
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
                            <label class="block text-xs font-semibold text-slate-300 mb-2">
                                টি-শার্ট / জার্সির সাইজ (T-Shirt Size) <span class="text-rose-400">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                @foreach($tshirtSizes as $size)
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="tshirt_size" value="{{ $size }}" {{ old('tshirt_size', 'M') == $size ? 'checked' : '' }} class="peer sr-only">
                                        <div class="py-2.5 text-center rounded-xl bg-slate-950 border border-slate-700/80 peer-checked:border-amber-500 peer-checked:bg-amber-500/20 peer-checked:text-amber-400 text-xs font-black transition">
                                            {{ $size }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">শিক্ষা প্রতিষ্ঠান বা বর্তমান পেশা (School / College / Job)</label>
                            <input type="text" name="organization_or_institution" value="{{ old('organization_or_institution') }}" placeholder="উদা: ঢাকা কলেজ / চাকরিজীবী / শিক্ষার্থী" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 3: Contact & Address -->
                <div>
                    <h2 class="text-sm font-black text-amber-400 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>📞</span> ৩. যোগাযোগ ও ঠিকানা
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>মোবাইল নম্বর (ইংরেজিতে) <span class="text-rose-400">*</span></span>
                                <span class="text-[10px] text-amber-400 font-mono">English digits only</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="01712345678" pattern="[0-9+ -]+" inputmode="numeric" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs font-mono english-number-only">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>জরুরি যোগাযোগের নম্বর (Emergency)</span>
                                <span class="text-[10px] text-slate-400 font-mono">English digits</span>
                            </label>
                            <input type="tel" name="emergency_phone" id="emergency_phone" value="{{ old('emergency_phone') }}" placeholder="01812345678" pattern="[0-9+ -]+" inputmode="numeric" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs font-mono english-number-only">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">ইমেইল ঠিকানা (ঐচ্ছিক)</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">বর্তমান ঠিকানা (গ্রাম/এলাকা, থানা, জেলা) <span class="text-rose-400">*</span></label>
                            <textarea name="address" rows="2" required placeholder="গ্রাম/মহল্লা, থানা, জেলা" class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">{{ old('address') }}</textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">পূর্বের কোনো ভলান্টিয়ার কাজের অভিজ্ঞতা বা দক্ষতা (ঐচ্ছিক)</label>
                            <textarea name="experience" rows="2" placeholder="পূর্বে কোনো খেলাধুলা, স্কাউট, বিএনসিসি বা সামাজিক সংগঠনে ভলান্টিয়ার কাজের অভিজ্ঞতা থাকলে লিখুন..." class="w-full bg-slate-950 border border-slate-700/80 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">{{ old('experience') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 4: Photo Upload with 300x300 Cropper -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-sm font-black text-amber-400 uppercase tracking-wider flex items-center gap-2">
                            <span>📸</span> ৪. ভলান্টিয়ার আইডি ব্যাজের ছবি (Passport Photo)
                        </h2>
                        <span class="text-[11px] font-semibold text-amber-300 bg-amber-500/10 px-2.5 py-1 rounded-full border border-amber-500/20">
                            📐 সাইজ: ৩০০ × ৩০০ পিক্সেল (১:১)
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-6 p-5 rounded-2xl bg-slate-950/70 border border-slate-800">
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-2xl bg-slate-900 border-2 border-dashed border-slate-700 flex items-center justify-center overflow-hidden shrink-0 shadow-inner" id="preview-box">
                                <img id="preview-img" src="" alt="Photo Preview" class="w-full h-full object-cover hidden">
                                <span id="preview-placeholder" class="text-slate-400 text-xs text-center px-2">ছবি আপলোড করুন</span>
                            </div>
                            <span id="crop-badge" class="hidden absolute -bottom-2 -right-2 bg-amber-500 text-slate-950 font-bold text-[10px] px-2 py-0.5 rounded-full shadow">✓ 300×300</span>
                        </div>

                        <div class="flex-1 w-full space-y-2">
                            <label class="block text-xs font-semibold text-slate-300">ছবি নির্বাচন করুন (কম্পিউটার বা মোবাইল থেকে)</label>
                            <input type="file" name="photo" id="photo-input" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-500/10 file:text-amber-400 hover:file:bg-amber-500/20 cursor-pointer">
                            <input type="hidden" name="cropped_photo" id="cropped_photo">
                            
                            <p class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                <span class="text-amber-400">💡</span> নির্বাচিত ছবিটি আপনি নিজে ড্র্যাগ ও জুম করে সঠিক ৩০০×৩০০ মাপে কেটে নিতে পারবেন যা আপনার ডিজিটাল ভলান্টিয়ার আইডি কার্ডে প্রদর্শিত হবে।
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Terms & Submit -->
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-800">
                    <label class="flex items-start gap-2.5 cursor-pointer text-xs text-slate-300">
                        <input type="checkbox" name="agree" required checked class="rounded border-slate-700 bg-slate-950 text-amber-500 focus:ring-amber-500 mt-0.5">
                        <span>
                            আমি শপথ করছি যে জামিরবাড়িয়া স্পোর্টস একাডেমির শৃঙ্খলা, নিয়মাবলী ও ম্যাচ ডে নির্দেশিকা নিষ্ঠার সাথে পালন করব।
                        </span>
                    </label>

                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black rounded-xl text-sm shadow-xl shadow-amber-500/20 transition-all flex items-center justify-center gap-2 shrink-0">
                        <span>আবেদন জমা দিন</span>
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
                    <span class="text-amber-400 text-lg">✂️</span>
                    <div>
                        <h3 class="text-sm font-bold text-white">ছবি ক্রপ করুন (৩০০ × ৩০০ পিক্সেল)</h3>
                        <p class="text-[11px] text-slate-400">ছবিটি প্রয়োজনমতো জুম বা রোটেট করে বক্সে বসান</p>
                    </div>
                </div>
                <button type="button" id="cropper-close-btn" class="text-slate-400 hover:text-white text-xl font-bold p-1 leading-none">&times;</button>
            </div>

            <div class="p-4 flex-1 overflow-hidden flex items-center justify-center bg-slate-950/60">
                <div class="max-h-[50vh] max-w-full">
                    <img id="cropper-image" src="" alt="Crop Image" class="max-w-full block">
                </div>
            </div>

            <div class="px-4 py-2.5 bg-slate-800/80 border-t border-slate-800 flex flex-wrap items-center justify-center gap-2 text-xs">
                <button type="button" id="crop-zoom-in" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">🔍+ জুম ইন</button>
                <button type="button" id="crop-zoom-out" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">🔍- জুম আউট</button>
                <button type="button" id="crop-rotate-left" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">↺ ৯০° বামে</button>
                <button type="button" id="crop-rotate-right" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">↻ ৯০° ডানে</button>
                <button type="button" id="crop-reset" class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold">⟲ রিসেট</button>
            </div>

            <div class="px-6 py-4 border-t border-slate-800 flex items-center justify-between bg-slate-900">
                <button type="button" id="crop-cancel-btn" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:bg-slate-800 border border-slate-700">বাতিল</button>
                <button type="button" id="crop-confirm-btn" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20 flex items-center gap-1.5">
                    <span>✓ ৩০০×৩০০ সাইজে সংরক্ষণ করুন</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/cropperjs/cropper.min.js') }}"></script>
    <script>
        // Cropper Logic
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
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(cropperImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 0.9,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

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

        // Enforce English Digits on Phone Inputs
        const bnDigitsMap = { '০': '0', '১': '1', '২': '2', '৩': '3', '৪': '4', '৫': '5', '৬': '6', '৭': '7', '৮': '8', '৯': '9' };
        document.querySelectorAll('.english-number-only').forEach(el => {
            const sanitize = () => {
                let v = el.value.replace(/[০-৯]/g, d => bnDigitsMap[d] || d);
                v = v.replace(/[^0-9+\- ]/g, '');
                if (el.value !== v) el.value = v;
            };
            el.addEventListener('input', sanitize);
            el.addEventListener('change', sanitize);
            el.addEventListener('paste', () => setTimeout(sanitize, 10));
        });
    </script>
</body>
</html>


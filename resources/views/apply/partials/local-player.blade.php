@php
    $lpCircular = $localPlayerCircular ?? $circular ?? null;
    $isLpOpen = $lpCircular ? $lpCircular->isOpen() : true;
    $isLpUpcoming = $lpCircular ? $lpCircular->isUpcoming() : false;
@endphp

<div class="space-y-6">

    @if (session('error') && request('tab', $tab ?? '') === 'local_player')
        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm flex items-center gap-3">
            <span class="text-xl">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any() && request('tab', $tab ?? '') === 'local_player')
        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm">
            <div class="font-bold mb-1">অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!$isLpOpen)
        <!-- Circular Closed or Upcoming Card -->
        <div class="bg-slate-900/90 border {{ $isLpUpcoming ? 'border-amber-500/40 bg-gradient-to-b from-amber-950/20 to-slate-900/90' : 'border-rose-500/40 bg-gradient-to-b from-rose-950/20 to-slate-900/90' }} rounded-3xl p-8 sm:p-12 shadow-2xl backdrop-blur text-center max-w-2xl mx-auto space-y-6">
            <div class="w-20 h-20 mx-auto rounded-3xl {{ $isLpUpcoming ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }} flex items-center justify-center text-4xl shadow-xl">
                {{ $isLpUpcoming ? '⏳' : '🛑' }}
            </div>

            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $isLpUpcoming ? 'bg-amber-500/10 text-amber-400 border border-amber-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                    {{ $isLpUpcoming ? 'নিবন্ধন আসন্ন (Upcoming)' : 'নিবন্ধন গ্রহণ বন্ধ (Closed)' }}
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white">
                    {{ $lpCircular->title ?? 'লোকাল প্লেয়ার টুর্নামেন্ট ড্রাফট' }}
                </h2>
                <p class="text-slate-300 text-sm leading-relaxed max-w-lg mx-auto">
                    @if($isLpUpcoming)
                        {{ $lpCircular->upcoming_message ?: 'লোকাল প্লেয়ার টুর্নামেন্ট ড্রাফট খুব শীঘ্রই শুরু হতে যাচ্ছে।' }}
                    @else
                        {{ $lpCircular->closed_message ?: 'লোকাল প্লেয়ার টুর্নামেন্ট ড্রাফট নিবন্ধনের সময়সীমা সমাপ্ত হয়েছে।' }}
                    @endif
                </p>
            </div>

            <!-- Timing Details Badge -->
            <div class="p-4 rounded-2xl bg-slate-950/90 border border-slate-800 inline-block text-left text-xs space-y-1.5">
                @if($isLpUpcoming && $lpCircular && $lpCircular->start_date)
                    <div class="text-slate-400 flex items-center gap-2">
                        <span>🚀 নিবন্ধন শুরুর সময়:</span>
                        <strong class="text-amber-400 font-mono">{{ $lpCircular->start_date->format('d M Y, h:i A') }}</strong>
                    </div>
                @endif
                @if($lpCircular && $lpCircular->end_date)
                    <div class="text-slate-400 flex items-center gap-2">
                        <span>🛑 নিবন্ধনের শেষ সময় / ডেডলাইন:</span>
                        <strong class="text-rose-400 font-mono">{{ $lpCircular->end_date->format('d M Y, h:i A') }}</strong>
                    </div>
                @endif
            </div>

            <!-- Navigation Action Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('public.tournaments.index') }}" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition flex items-center justify-center gap-2">
                    <span>🏆 টুর্নামেন্ট সূচী দেখুন</span>
                </a>
                <button type="button" @click="activeTab = 'admission'" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-2">
                    <span>🎓 একাডেমি ভর্তি আবেদন করুন</span>
                </button>
            </div>
        </div>
    @else
        <!-- Stepper Progress Tracker -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-5 sm:p-6 mb-4 shadow-xl backdrop-blur">
            <div class="flex items-center justify-between relative mb-4">
                <!-- Progress line background -->
                <div class="absolute top-1/2 left-0 right-0 h-1 bg-slate-800 -translate-y-1/2 z-0"></div>
                <!-- Active progress line -->
                <div id="lp_step-progress-bar" class="absolute top-1/2 left-0 h-1 bg-gradient-to-r from-amber-500 to-emerald-500 -translate-y-1/2 z-0 transition-all duration-500" style="width: 0%;"></div>

                <!-- Step 1 Button -->
                <button type="button" onclick="goToLpStep(1)" class="relative z-10 flex flex-col items-center group cursor-pointer focus:outline-none">
                    <div id="lp_step-badge-1" class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-amber-500 text-slate-950 ring-4 ring-amber-500/20">
                        <span>১</span>
                    </div>
                    <span id="lp_step-text-1" class="text-[11px] font-black mt-1.5 transition text-amber-400">খেলা নির্বাচন</span>
                </button>

                <!-- Step 2 Button -->
                <button type="button" onclick="goToLpStep(2)" class="relative z-10 flex flex-col items-center group cursor-pointer focus:outline-none">
                    <div id="lp_step-badge-2" class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-slate-800 text-slate-400 border border-slate-700">
                        <span>২</span>
                    </div>
                    <span id="lp_step-text-2" class="text-[11px] font-bold mt-1.5 transition text-slate-500">ব্যক্তিগত তথ্য</span>
                </button>

                <!-- Step 3 Button -->
                <button type="button" onclick="goToLpStep(3)" class="relative z-10 flex flex-col items-center group cursor-pointer focus:outline-none">
                    <div id="lp_step-badge-3" class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-slate-800 text-slate-400 border border-slate-700">
                        <span>৩</span>
                    </div>
                    <span id="lp_step-text-3" class="text-[11px] font-bold mt-1.5 transition text-slate-500">পজিশন ও ছবি</span>
                </button>

                <!-- Step 4 Button (Review) -->
                <button type="button" onclick="goToLpStep(4)" class="relative z-10 flex flex-col items-center group cursor-pointer focus:outline-none">
                    <div id="lp_step-badge-4" class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition shadow-md bg-slate-800 text-slate-400 border border-slate-700">
                        <span>৪</span>
                    </div>
                    <span id="lp_step-text-4" class="text-[11px] font-bold mt-1.5 transition text-slate-500">যাচাই ও প্রিভিউ</span>
                </button>
            </div>

            <!-- Dynamic step description text -->
            <div id="lp_step-desc-text" class="text-center text-xs text-slate-400 pt-2 border-t border-slate-800/80">
                <span class="font-mono text-amber-400 font-bold">ধাপ ১ / ৪:</span> <span class="text-white font-semibold">পছন্দের খেলাসমেত টুর্নামেন্ট নির্বাচন করুন</span>
            </div>
        </div>

        <!-- Client Validation Alert Message -->
        <div id="lp_validation-alert" class="hidden mb-6 p-4 rounded-2xl bg-rose-500/15 border border-rose-500/40 text-rose-300 text-xs font-bold flex items-center justify-between shadow-lg">
            <div class="flex items-center gap-2">
                <span class="text-lg">⚠️</span>
                <span id="lp_validation-alert-msg"></span>
            </div>
            <button type="button" onclick="hideLpAlert()" class="text-slate-400 hover:text-white text-base font-bold">&times;</button>
        </div>

        @if($lpCircular && $lpCircular->end_date)
            <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-amber-950/40 via-slate-900 to-amber-950/40 border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <span class="text-xl">⏰</span>
                    <div>
                        <div class="font-bold text-white">{{ $lpCircular->title }}</div>
                        <div class="text-slate-400">নিবন্ধনের শেষ সময়: <span class="text-amber-400 font-mono font-bold">{{ $lpCircular->end_date->format('d M Y, h:i A') }}</span></div>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30 shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    নিবন্ধন উন্মুক্ত রয়েছে
                </span>
            </div>
        @endif

        <div class="text-left mb-6 pb-4 border-b border-slate-800">
            <h3 class="text-xl sm:text-2xl font-black text-white">লোকাল প্লেয়ার রেজিস্ট্রেশন উইজার্ড</h3>
            <p class="text-slate-400 text-xs mt-1">৪টি সহজ ধাপে তথ্য দিন, সবশেষে পূর্ণাঙ্গ প্রিভিউ কার্ড দেখে নিশ্চিত হয়ে সাবমিট করুন।</p>
        </div>

        <!-- Main Form -->
        <form id="localPlayerForm" action="{{ route('public.local-players.store') }}?tab=local_player" method="POST" enctype="multipart/form-data"
              class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl backdrop-blur text-left">
            @csrf

            <!-- ============================================================ -->
            <!-- STEP 1: MULTI-SPORTS SELECTION                              -->
            <!-- ============================================================ -->
            <div id="lp_step-1" class="lp-wizard-step space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <h4 class="text-base sm:text-lg font-black text-white">ধাপ ১: টুর্নামেন্টের খেলা নির্বাচন করুন</h4>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        আপনি কোন কোন খেলায় উন্মুক্ত টুর্নামেন্টে অংশ নিতে চান? এক বা একাধিক খেলা নির্বাচন করতে পারবেন।
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($sports as $sp)
                        <label class="lp-sport-card relative flex flex-col items-center text-center p-5 rounded-2xl border transition cursor-pointer select-none border-slate-800 bg-slate-950/60 hover:border-slate-700">
                            <input type="checkbox" name="sports[]" value="{{ $sp->id }}" data-name="{{ $sp->name }}" data-icon="{{ $sp->icon ?? '⚽' }}"
                                   class="lp-sport-checkbox sr-only"
                                   onchange="updateLpSportCardStyle(this)"
                                   {{ $loop->first ? 'checked' : '' }}>
                            <span class="text-4xl mb-2">{{ $sp->icon ?? '⚽' }}</span>
                            <span class="font-bold text-sm text-white">{{ $sp->name }}</span>
                            <span class="text-[10px] text-slate-400 mt-1">{{ $sp->type == 'team' ? 'দলীয় খেলা' : 'ব্যক্তিগত' }}</span>

                            <div class="lp-sport-check-indicator mt-3 w-5 h-5 rounded-full border border-slate-700 flex items-center justify-center transition">
                                <span class="lp-check-icon hidden text-[10px] font-black">✓</span>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800/80 text-xs text-slate-400 flex items-center gap-3">
                    <span class="text-2xl">💡</span>
                    <span>যেসব খেলায় আপনি পারদর্শী সেগুলো সিলেক্ট করুন। নির্বাচিত প্রতিটি খেলায় আপনার নামে টুর্নামেন্ট ড্রাফট শিট তৈরি হবে।</span>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="button" onclick="validateAndGoLpStep(2)"
                            class="px-8 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black rounded-xl text-xs uppercase tracking-wider shadow-lg shadow-amber-500/20 transition flex items-center gap-2">
                        <span>পরবর্তী ধাপ (ব্যক্তিগত তথ্য)</span>
                        <span>&rarr;</span>
                    </button>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- STEP 2: PERSONAL & CONTACT INFORMATION                       -->
            <!-- ============================================================ -->
            <div id="lp_step-2" class="lp-wizard-step hidden space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <h4 class="text-base sm:text-lg font-black text-white">ধাপ ২: খেলোয়াড়ের ব্যক্তিগত ও যোগাযোগের তথ্য</h4>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        সঠিক নাম, মোবাইল নম্বর এবং জাতীয় পরিচয়পত্র / জন্মনিবন্ধন নম্বর দিন।
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 text-xs">
                    <!-- Player Name -->
                    <div class="sm:col-span-2 lg:col-span-2">
                        <label class="block font-semibold text-slate-300 mb-1.5">খেলোয়াড়ের পূর্ণ নাম (বাংলায়) <span class="text-rose-500">*</span></label>
                        <input type="text" id="lp_input_name" name="name" value="{{ old('name') }}" placeholder="যেমন: মো: আরিফুল ইসলাম" required
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <!-- English Name -->
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1.5">নাম (ইংরেজিতে)</label>
                        <input type="text" id="lp_input_name_en" name="name_en" value="{{ old('name_en') }}" placeholder="e.g. Ariful Islam"
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <!-- Primary Phone with Live Duplicate Check -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="font-semibold text-slate-300">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                            <span id="lp_phone-status-badge" class="hidden text-[10px] font-bold px-1.5 py-0.5 rounded"></span>
                        </div>
                        <input type="text" id="lp_input_phone" name="phone" value="{{ old('phone') }}" placeholder="017XXXXXXXX" required
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-mono transition english-number-only">
                        <div id="lp_phone-feedback" class="mt-1 text-[11px] hidden font-semibold"></div>
                    </div>

                    <!-- Emergency Phone -->
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1.5">জরুরি মোবাইল / অভিভাবকের নম্বর</label>
                        <input type="text" id="lp_input_emergency_phone" name="emergency_phone" value="{{ old('emergency_phone') }}" placeholder="018XXXXXXXX"
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-mono english-number-only">
                    </div>

                    <!-- Guardian Name -->
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1.5">অভিভাবকের নাম</label>
                        <input type="text" id="lp_input_guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" placeholder="পিতা / মাতার নাম"
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1.5">জন্ম তারিখ <span class="text-rose-500">*</span></label>
                        <input type="date" id="lp_input_date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <!-- Blood Group -->
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1.5">রক্তের গ্রুপ</label>
                        <select id="lp_input_blood_group" name="blood_group"
                                class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                            <option value="">অজ্ঞাত / টেস্ট করা হয়নি</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- NID / Birth Cert with Live Duplicate Check -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="font-semibold text-slate-300">জাতীয় পরিচয়পত্র / জন্মনিবন্ধন নং</label>
                            <span id="lp_nid-status-badge" class="hidden text-[10px] font-bold px-1.5 py-0.5 rounded"></span>
                        </div>
                        <input type="text" id="lp_input_nid" name="nid_or_birth_cert" value="{{ old('nid_or_birth_cert') }}" placeholder="১০ বা ১৭ ডিজিট"
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-mono transition">
                        <div id="lp_nid-feedback" class="mt-1 text-[11px] hidden font-semibold"></div>
                    </div>

                    <!-- Address -->
                    <div class="sm:col-span-2 lg:col-span-3">
                        <label class="block font-semibold text-slate-300 mb-1.5">স্থায়ী ঠিকানা / বর্তমান বাসস্থান <span class="text-rose-500">*</span></label>
                        <textarea id="lp_input_address" name="address" rows="2" placeholder="গ্রাম/পাড়া/এলাকা, ডাকঘর, থানা, জেলা" required
                                  class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" onclick="goToLpStep(1)"
                            class="px-5 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-xs transition">
                        &larr; আগের ধাপ
                    </button>
                    <button type="button" onclick="validateAndGoLpStep(3)"
                            class="px-7 py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-xs uppercase tracking-wider shadow-lg transition flex items-center gap-2">
                        <span>পরবর্তী ধাপ (পজিশন ও ছবি)</span>
                        <span>&rarr;</span>
                    </button>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- STEP 3: POSITION, JERSEY & PHOTO UPLOAD                     -->
            <!-- ============================================================ -->
            <div id="lp_step-3" class="lp-wizard-step hidden space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <h4 class="text-base sm:text-lg font-black text-white">ধাপ ৩: খেলার ভূমিকা ও পাসপোর্ট সাইজ ছবি</h4>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        টুর্নামেন্ট ডিজিটাল আইডি কার্ড ও ম্যাচ রোস্টারের জন্য আপনার ভূমিকা ও ছবি যুক্ত করুন।
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1.5">খেলার প্রধান পজিশন / রোল</label>
                        <input type="text" id="lp_input_position" name="position" value="{{ old('position') }}" placeholder="যেমন: অলরাউন্ডার / ওপেনিং ব্যাটার / স্ট্রাইকার / ডিফেন্ডার"
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-300 mb-1.5">পছন্দের জার্সি নম্বর (ঐচ্ছিক)</label>
                        <input type="text" id="lp_input_jersey_no" name="jersey_no" value="{{ old('jersey_no') }}" placeholder="যেমন: 10, 07, 18, 99"
                               class="w-full rounded-xl bg-slate-950 border border-slate-700 text-white text-xs p-3 focus:border-amber-500 focus:ring-amber-500 font-mono">
                    </div>
                </div>

                <!-- Photo Upload and 300x300 Cropper -->
                <div class="p-6 rounded-2xl bg-slate-950/70 border border-slate-800 space-y-4">
                    <div class="flex items-center justify-between">
                        <h5 class="font-bold text-white text-xs uppercase tracking-wider flex items-center gap-2">
                            <span>📷</span> অফিসিয়াল পাসপোর্ট ছবি (৩০০x৩০০ ক্রপার সিস্টেম)
                        </h5>
                        <span class="text-[10px] text-amber-400 font-mono">Square 1:1 Aspect Ratio</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-center">
                        <div class="sm:col-span-2 space-y-2">
                            <input type="file" id="lp_player_photo_input" accept="image/*"
                                   class="block w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer">
                            <p class="text-[11px] text-slate-400">ছবি সিলেক্ট করার পর ক্রপ টুল ওপেন হবে। এটি আপনার অফিসিয়াল প্লেয়ার পাসে প্রিন্ট হবে।</p>
                            <input type="hidden" name="cropped_photo" id="lp_cropped_photo" value="{{ old('cropped_photo') }}">
                        </div>

                        <div class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-900 border border-slate-800 text-center">
                            <div class="w-24 h-24 rounded-2xl bg-slate-950 border-2 border-amber-500/40 overflow-hidden flex items-center justify-center shadow-inner">
                                <img id="lp_preview_crop_img" src="" alt="প্রিভিউ" class="w-full h-full object-cover hidden">
                                <span id="lp_placeholder_icon" class="text-3xl text-slate-700">👤</span>
                            </div>
                            <span class="text-[10px] text-slate-400 mt-2 font-mono">৩০০x৩০০ ক্রপ প্রিভিউ</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" onclick="goToLpStep(2)"
                            class="px-5 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-xs transition">
                        &larr; আগের ধাপ
                    </button>
                    <button type="button" onclick="validateAndGoLpStep(4)"
                            class="px-7 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-xl text-xs uppercase tracking-wider shadow-lg transition flex items-center gap-2">
                        <span>চূড়ান্ত প্রিভিউ দেখুন</span>
                        <span>&rarr;</span>
                    </button>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- STEP 4: FULL REVIEW PREVIEW CARD & CONFIRM BEFORE SUBMIT    -->
            <!-- ============================================================ -->
            <div id="lp_step-4" class="lp-wizard-step hidden space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                <h4 class="text-base sm:text-lg font-black text-white">ধাপ ৪: চূড়ান্ত প্রিভিউ ও যাচাইকরণ (Review All Data)</h4>
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
                                <img id="lp_review-photo" src="" alt="Photo" class="w-full h-full object-cover hidden">
                                <span id="lp_review-photo-placeholder" class="text-3xl text-slate-700">👤</span>
                            </div>
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/30 text-[10px] font-black uppercase tracking-wider">
                                    উন্মুক্ত প্লেয়ার টুর্নামেন্ট ড্রাফট
                                </span>
                                <h2 id="lp_review-name" class="text-xl sm:text-2xl font-black text-white mt-1">খেলোয়াড়ের নাম</h2>
                                <div class="flex items-center gap-2 mt-1 text-xs">
                                    <span id="lp_review-category" class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 font-bold">Senior</span>
                                    <span id="lp_review-position" class="text-slate-400"></span>
                                    <span id="lp_review-jersey" class="text-amber-400 font-mono font-bold"></span>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="goToLpStep(2)" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold border border-slate-700 transition">
                            ✏️ তথ্য সম্পাদনা
                        </button>
                    </div>

                    <!-- Data Grid Summary -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 py-6 text-xs border-b border-slate-800">
                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">নির্বাচিত খেলাসমূহ:</span>
                            <div id="lp_review-sports-badges" class="flex flex-wrap gap-2 mt-1.5">
                                <!-- Dynamic sports list inserted here -->
                            </div>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">রেজিস্ট্রেশন স্ট্যাটাস:</span>
                            <span class="text-sm font-bold text-emerald-400 mt-1 block">উন্মুক্ত ফ্রি ড্রাফট (সকল টুর্নামেন্টের জন্য সক্রিয়)</span>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">প্রধান মোবাইল নম্বর:</span>
                            <span id="lp_review-phone" class="text-sm font-mono font-bold text-white mt-0.5 block">-</span>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">জরুরি / অভিভাবকের ফোন:</span>
                            <span id="lp_review-emergency" class="text-sm font-mono font-bold text-slate-300 mt-0.5 block">-</span>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">অভিভাবকের নাম:</span>
                            <span id="lp_review-guardian" class="font-semibold text-white mt-0.5 block">-</span>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">জন্ম তারিখ ও রক্তের গ্রুপ:</span>
                            <span id="lp_review-dob-blood" class="font-semibold text-white mt-0.5 block">-</span>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">NID / জন্মনিবন্ধন নং:</span>
                            <span id="lp_review-nid" class="font-mono text-slate-300 mt-0.5 block">-</span>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider block">স্থায়ী ঠিকানা:</span>
                            <span id="lp_review-address" class="text-slate-200 mt-0.5 block leading-relaxed">-</span>
                        </div>
                    </div>

                    <!-- Confirmation Agreement Checkbox -->
                    <div class="pt-5 flex items-start gap-3">
                        <input type="checkbox" id="lp_confirm_declaration" required checked
                               class="mt-1 w-4 h-4 rounded text-emerald-500 focus:ring-emerald-400 border-slate-700 bg-slate-900">
                        <label for="lp_confirm_declaration" class="text-xs text-slate-300 select-none cursor-pointer leading-relaxed">
                            আমি নিশ্চিত করছি যে উপরে প্রদত্ত সকল ব্যক্তিগত, যোগাযোগ ও খেলার তথ্য সম্পূর্ণ সঠিক। আমি জামিরবাড়িয়া স্পোর্টস একাডেমির টুর্নামেন্ট আচরণবিধি ও নিয়মাবলী মেনে খেলতে সম্মত।
                        </label>
                    </div>
                </div>

                <!-- Final Action Buttons -->
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="button" onclick="goToLpStep(3)"
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

<!-- Cropper Modal Popup for Local Player -->
<div id="lp_cropperModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h4 class="font-bold text-white text-base">ছবি ক্রপ করুন (৩০০x৩০০ স্কয়ার)</h4>
            <button type="button" id="lp_closeModalBtn" class="text-slate-400 hover:text-white text-2xl leading-none">&times;</button>
        </div>
        <div class="max-h-80 overflow-hidden rounded-xl bg-black flex items-center justify-center">
            <img id="lp_cropperImage" src="" alt="Crop image" class="max-w-full">
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <button type="button" id="lp_cancelCropBtn" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition">বাতিল</button>
            <button type="button" id="lp_applyCropBtn" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-black transition">ক্রপ সংরক্ষণ করুন</button>
        </div>
    </div>
</div>

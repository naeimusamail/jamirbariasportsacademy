@php
    $admCircular = $admissionCircular ?? $circular ?? null;
    $isAdmOpen = $admCircular ? $admCircular->isOpen() : true;
    $isAdmUpcoming = $admCircular ? $admCircular->isUpcoming() : false;
@endphp

<div class="space-y-6">

    @if (session('error') && request('tab', $tab ?? '') === 'admission')
        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm flex items-center gap-3">
            <span class="text-xl">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any() && request('tab', $tab ?? '') === 'admission')
        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm">
            <div class="font-bold mb-1">অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!$isAdmOpen)
        <!-- Circular Closed or Upcoming Card -->
        <div class="bg-slate-900/90 border {{ $isAdmUpcoming ? 'border-amber-500/40 bg-gradient-to-b from-amber-950/20 to-slate-900/90' : 'border-rose-500/40 bg-gradient-to-b from-rose-950/20 to-slate-900/90' }} rounded-3xl p-8 sm:p-12 shadow-2xl backdrop-blur text-center max-w-2xl mx-auto space-y-6">
            <div class="w-20 h-20 mx-auto rounded-3xl {{ $isAdmUpcoming ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }} flex items-center justify-center text-4xl shadow-xl">
                {{ $isAdmUpcoming ? '⏳' : '🛑' }}
            </div>

            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $isAdmUpcoming ? 'bg-amber-500/10 text-amber-400 border border-amber-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                    {{ $isAdmUpcoming ? 'নিবন্ধন আসন্ন (Upcoming)' : 'আবেদন গ্রহণ বন্ধ (Closed)' }}
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white">
                    {{ $admCircular->title ?? 'একাডেমি ভর্তি সার্কুলার' }}
                </h2>
                <p class="text-slate-300 text-sm leading-relaxed max-w-lg mx-auto">
                    @if($isAdmUpcoming)
                        {{ $admCircular->upcoming_message ?: '২০২৬ শিক্ষাবর্ষের ভর্তি আবেদন খুব শীঘ্রই শুরু হতে যাচ্ছে।' }}
                    @else
                        {{ $admCircular->closed_message ?: '২০২৬ শিক্ষাবর্ষের প্রাথমিক ভর্তি আবেদন সময়সীমা সমাপ্ত হয়েছে।' }}
                    @endif
                </p>
            </div>

            <!-- Timing Details Badge -->
            <div class="p-4 rounded-2xl bg-slate-950/90 border border-slate-800 inline-block text-left text-xs space-y-1.5">
                @if($isAdmUpcoming && $admCircular && $admCircular->start_date)
                    <div class="text-slate-400 flex items-center gap-2">
                        <span>🚀 আবেদন শুরুর নির্ধারিত সময়:</span>
                        <strong class="text-amber-400 font-mono">{{ $admCircular->start_date->format('d M Y, h:i A') }}</strong>
                    </div>
                @endif
                @if($admCircular && $admCircular->end_date)
                    <div class="text-slate-400 flex items-center gap-2">
                        <span>🛑 আবেদনের শেষ সময় / ডেডলাইন:</span>
                        <strong class="text-rose-400 font-mono">{{ $admCircular->end_date->format('d M Y, h:i A') }}</strong>
                    </div>
                @endif
            </div>

            <!-- Navigation Action Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('admission.track') }}" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition flex items-center justify-center gap-2">
                    <span>🔍 পূর্ববর্তী আবেদন ট্র্যাক করুন</span>
                </a>
                <button type="button" @click="activeTab = 'local_player'" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 transition flex items-center justify-center gap-2">
                    <span>🌟 লোকাল প্লেয়ার ড্রাফটে আবেদন করুন</span>
                </button>
            </div>
        </div>
    @else
        <!-- Form Card -->
        <div class="bg-slate-900/90 border border-slate-800 hover:border-slate-700 rounded-3xl p-6 sm:p-10 shadow-2xl backdrop-blur transition">
            @if($admCircular)
                <div class="mb-8 p-5 rounded-2xl bg-gradient-to-r from-emerald-950/40 via-slate-950 to-emerald-950/40 border border-emerald-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
                    <div class="flex items-start sm:items-center gap-3.5">
                        <span class="text-2xl p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 shrink-0">🎓</span>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-black text-white text-base sm:text-lg">{{ $admCircular->title }}</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                    আবেদন চলমান
                                </span>
                            </div>
                            @if($admCircular->description)
                                <p class="text-slate-400 text-xs mt-1.5 leading-relaxed">{{ $admCircular->description }}</p>
                            @endif
                            <div class="flex items-center gap-3 text-[11px] text-slate-300 mt-2 flex-wrap font-mono">
                                @if($admCircular->start_date)
                                    <span>শুরু: <strong class="text-slate-100">{{ $admCircular->start_date->format('d M Y, h:i A') }}</strong></span>
                                    <span>•</span>
                                @endif
                                @if($admCircular->end_date)
                                    <span>শেষ সময়: <strong class="text-amber-400">{{ $admCircular->end_date->format('d M Y, h:i A') }}</strong></span>
                                @endif
                                @if($admCircular->fee)
                                    <span>•</span>
                                    <span class="text-emerald-400 font-bold">ভর্তি ফি: ৳{{ number_format($admCircular->fee) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-left mb-8 pb-4 border-b border-slate-800">
                <h3 class="text-xl sm:text-2xl font-black text-white">নতুন প্লেয়ার ভর্তি আবেদন</h3>
                <p class="text-slate-400 text-xs mt-1">প্রশিক্ষণার্থীর সঠিক ও নির্ভুল তথ্য দিয়ে ফরমটি সম্পূর্ণ করুন।</p>
            </div>

            <form id="admissionForm" action="{{ route('admission.store') }}?tab=admission" method="POST" enctype="multipart/form-data" class="space-y-8 text-left">
                @csrf
                @if($admCircular)
                    <input type="hidden" name="circular_id" value="{{ $admCircular->id }}">
                @endif

                <!-- Section 1: Sports Selection -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                        <h4 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                            <span>🏆</span> ১. খেলাধুলার ধরন ও বয়স ক্যাটাগরি
                        </h4>
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
                            @foreach ($sports as $sport)
                                <label class="relative flex flex-col items-center p-4 rounded-2xl border cursor-pointer transition select-none bg-slate-950/60 border-slate-800 hover:border-emerald-500/50 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/10">
                                    <input type="checkbox" name="sports[]" value="{{ $sport->id }}" 
                                        {{ (is_array(old('sports')) && in_array($sport->id, old('sports'))) || ($loop->first && !old('sports')) ? 'checked' : '' }}
                                        class="sr-only">
                                    <span class="text-3xl mb-1">{{ $sport->icon ?? '⚽' }}</span>
                                    <span class="text-xs font-bold text-white text-center">{{ $sport->name }}</span>
                                    <span class="text-[10px] text-slate-400 mt-0.5">{{ $sport->type === 'team' ? 'দলীয়' : 'ব্যক্তিগত' }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">বয়স ক্যাটাগরি (Age Category) <span class="text-rose-400">*</span></label>
                        <select name="category" required class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                            <option value="">ক্যাটাগরি বাছাই করুন...</option>
                            <option value="U-12" {{ old('category') == 'U-12' ? 'selected' : '' }}>U-12 (অনূর্ধ্ব ১২)</option>
                            <option value="U-14" {{ old('category') == 'U-14' ? 'selected' : '' }}>U-14 (অনূর্ধ্ব ১৪)</option>
                            <option value="U-16" {{ old('category', 'U-16') == 'U-16' ? 'selected' : '' }}>U-16 (অনূর্ধ্ব ১৬)</option>
                            <option value="U-19" {{ old('category') == 'U-19' ? 'selected' : '' }}>U-19 (অনূর্ধ্ব ১৯)</option>
                            <option value="Senior" {{ old('category') == 'Senior' ? 'selected' : '' }}>Senior (সিনিয়র)</option>
                        </select>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 2: Personal Information -->
                <div>
                    <h4 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>👤</span> ২. প্লেয়ারের ব্যক্তিগত তথ্য
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">
                                প্লেয়ারের নাম (বাংলায়) <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="উদা: আরিয়ান আহমেদ" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>প্লেয়ারের নাম (ইংরেজিতে)</span>
                                <span class="text-[10px] text-slate-400 font-normal">Full Name (English)</span>
                            </label>
                            <input type="text" name="name_en" value="{{ old('name_en') }}" placeholder="e.g. Arian Ahmed" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">অভিভাবকের নাম (Father/Mother/Guardian) <span class="text-rose-400">*</span></label>
                            <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" required placeholder="অভিভাবকের পূর্ণ নাম" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">জন্ম তারিখ (Date of Birth) <span class="text-rose-400">*</span></label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>জন্ম নিবন্ধন / জাতীয় পরিচয়পত্র নম্বর (NID / Birth Cert)</span>
                                <span class="text-[10px] text-emerald-400 font-mono">লাইভ ভেরিফিকেশন</span>
                            </label>
                            <input type="text" name="nid_or_birth_cert" id="adm_nid_or_birth_cert" value="{{ old('nid_or_birth_cert') }}" placeholder="উদা: 20081234567890123" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm font-mono">
                            <div id="adm_nid-verify-feedback" class="hidden mt-1.5 text-xs p-2.5 rounded-xl border"></div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">রক্তের গ্রুপ (Blood Group)</label>
                            <select name="blood_group" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
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
                            <input type="text" name="position" value="{{ old('position') }}" placeholder="উদা: স্ট্রাইকার / অলরাউন্ডার / স্প্রিন্টার" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">কাঙ্ক্ষিত জার্সি নম্বর / সাইজ</label>
                            <input type="text" name="jersey_no" value="{{ old('jersey_no') }}" placeholder="উদা: ৭ অথবা সাইজ M/L" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">শিক্ষা প্রতিষ্ঠান বা কর্মক্ষেত্র</label>
                            <input type="text" name="organization_or_area" value="{{ old('organization_or_area') }}" placeholder="উদা: জামিরবাড়িয়া উচ্চ বিদ্যালয় / সরকারি কলেজ" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 3: Contact & Address -->
                <div>
                    <h4 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>📞</span> ৩. যোগাযোগ ও ঠিকানা
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>মোবাইল নম্বর (ইংরেজিতে) <span class="text-rose-400">*</span></span>
                                <span class="text-[10px] text-emerald-400 font-mono">English digits only</span>
                            </label>
                            <input type="tel" name="phone" id="adm_phone" value="{{ old('phone') }}" required placeholder="01712345678" pattern="[0-9+ -]+" inputmode="numeric" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm font-mono english-number-only">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center justify-between">
                                <span>জরুরি যোগাযোগের নম্বর (Emergency)</span>
                                <span class="text-[10px] text-slate-400 font-mono">English digits</span>
                            </label>
                            <input type="tel" name="emergency_phone" id="adm_emergency_phone" value="{{ old('emergency_phone') }}" placeholder="01812345678" pattern="[0-9+ -]+" inputmode="numeric" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm font-mono english-number-only">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">বর্তমান ঠিকানা <span class="text-rose-400">*</span></label>
                            <textarea name="address" rows="3" required placeholder="গ্রাম/রোড, থানা, জেলা" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 4: Photo Upload with 300x300 Cropper -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                            <span>📸</span> ৪. প্লেয়ারের পাসপোর্ট সাইজ ছবি (Player Photo)
                        </h4>
                        <span class="text-[11px] font-semibold text-emerald-300 bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">
                            📐 ৩০০ × ৩০০ পিক্সেল (১:১)
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-6 p-5 rounded-2xl bg-slate-950/60 border border-slate-800">
                        <!-- Photo Preview Box -->
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-2xl bg-slate-900 border-2 border-dashed border-slate-700 flex items-center justify-center overflow-hidden shrink-0 shadow-inner" id="adm_preview-box">
                                <img id="adm_preview-img" src="" alt="Photo Preview" class="w-full h-full object-cover hidden">
                                <span id="adm_preview-placeholder" class="text-slate-400 text-xs text-center px-2">ছবি আপলোড করুন</span>
                            </div>
                            <span id="adm_crop-badge" class="hidden absolute -bottom-2 -right-2 bg-emerald-500 text-slate-950 font-bold text-[10px] px-2 py-0.5 rounded-full shadow">✓ 300×300</span>
                        </div>

                        <div class="flex-1 w-full space-y-2">
                            <label class="block text-xs font-semibold text-slate-300">ছবি নির্বাচন করুন (কম্পিউটার বা মোবাইল থেকে)</label>
                            <input type="file" name="photo" id="adm_photo-input" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/10 file:text-emerald-400 hover:file:bg-emerald-500/20 cursor-pointer">
                            <input type="hidden" name="cropped_photo" id="adm_cropped_photo">
                            
                            <p class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                <span class="text-emerald-400">💡</span> ছবি সিলেক্ট করার পর ড্র্যাগ ও জুম করে ৩০০×৩০০ স্কয়ার ক্রপ করুন।
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 5: Health & Medical Details -->
                <div>
                    <h4 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>🩺</span> ৫. শারীরিক ও স্বাস্থ্য সংক্রান্ত তথ্য (ঐচ্ছিক)
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">উচ্চতা (Height)</label>
                            <input type="text" name="height" value="{{ old('height') }}" placeholder="উদা: 5' 6''" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">ওজন (Weight)</label>
                            <input type="text" name="weight" value="{{ old('weight') }}" placeholder="উদা: 54 kg" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-xs font-semibold text-slate-300 mb-2">পূর্ববর্তী কোনো বড় ইনজুরি বা স্বাস্থ্য সমস্যা থাকলে উল্লেখ করুন</label>
                            <textarea name="medical_history" rows="2" placeholder="উদা: শ্বাসকষ্ট, এলার্জি বা কোনো অতীত অস্ত্রোপচার..." class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm">{{ old('medical_history') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 6: Payment Details -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                            <span>💳</span> ৬. প্রাথমিক ভর্তি ফি ও পেমেন্ট পদ্ধতি
                        </h4>
                        <span class="text-xs font-mono font-bold text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
                            নির্ধারিত ফি: ৳{{ number_format($admCircular->fee ?? 1000) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                        <label class="relative flex flex-col items-center p-3.5 rounded-2xl border cursor-pointer transition select-none bg-slate-950/60 border-slate-800 hover:border-pink-500/50 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-500/10">
                            <input type="radio" name="payment_method" value="bkash" checked class="sr-only">
                            <span class="text-2xl mb-1">📱</span>
                            <span class="text-xs font-bold text-white">বিকাশ (bKash)</span>
                            <span class="text-[10px] text-pink-400 font-mono mt-0.5">Send Money</span>
                        </label>
                        <label class="relative flex flex-col items-center p-3.5 rounded-2xl border cursor-pointer transition select-none bg-slate-950/60 border-slate-800 hover:border-amber-500/50 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-500/10">
                            <input type="radio" name="payment_method" value="nagad" class="sr-only">
                            <span class="text-2xl mb-1">⚡</span>
                            <span class="text-xs font-bold text-white">নগদ (Nagad)</span>
                            <span class="text-[10px] text-amber-400 font-mono mt-0.5">Send Money</span>
                        </label>
                        <label class="relative flex flex-col items-center p-3.5 rounded-2xl border cursor-pointer transition select-none bg-slate-950/60 border-slate-800 hover:border-purple-500/50 has-[:checked]:border-purple-500 has-[:checked]:bg-purple-500/10">
                            <input type="radio" name="payment_method" value="rocket" class="sr-only">
                            <span class="text-2xl mb-1">🚀</span>
                            <span class="text-xs font-bold text-white">রকেট (Rocket)</span>
                            <span class="text-[10px] text-purple-400 font-mono mt-0.5">Personal</span>
                        </label>
                        <label class="relative flex flex-col items-center p-3.5 rounded-2xl border cursor-pointer transition select-none bg-slate-950/60 border-slate-800 hover:border-emerald-500/50 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/10">
                            <input type="radio" name="payment_method" value="cash" class="sr-only">
                            <span class="text-2xl mb-1">🏢</span>
                            <span class="text-xs font-bold text-white">অফিস ক্যাশ</span>
                            <span class="text-[10px] text-emerald-400 font-mono mt-0.5">অফিস কাউন্টারে</span>
                        </label>
                    </div>

                    <!-- Payment instructions dynamic box -->
                    <div id="adm_method-instruction-box" class="p-4 rounded-2xl bg-slate-950 border border-slate-800 text-xs mb-5">
                        <div class="font-bold text-pink-400 mb-1">বিকাশ (bKash) পেমেন্ট নির্দেশিকা:</div>
                        <div class="text-slate-300 leading-relaxed">
                            বিকাশ পার্সোনাল নম্বরে Send Money করুন: <span class="text-white font-mono font-bold select-all">01712-345678</span>। টাকা পাঠানোর পর মেসেজের TrxID এবং প্রেরক নম্বরটি লিখুন।
                        </div>
                    </div>

                    <div id="adm_transaction-fields-container" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">প্রেরক মোবাইল নম্বর (Sender Number)</label>
                            <input type="tel" name="sender_number" id="adm_sender_number" placeholder="01XXXXXXXXX" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm font-mono english-number-only">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">ট্রানজেকশন আইডি (TrxID)</label>
                            <input type="text" name="transaction_id" id="adm_transaction_id" placeholder="উদা: BCL829AKX7" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 text-sm font-mono uppercase">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[11px] text-slate-400">
                        🔒 আপনার প্রদত্ত তথ্য জামিরবাড়িয়া একাডেমি প্রাইভেসি পলিসি অনুযায়ী সংরক্ষিত।
                    </p>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black rounded-xl text-sm shadow-xl shadow-emerald-500/25 transition flex items-center justify-center gap-2">
                        <span>ভর্তি আবেদন সাবমিট করুন</span>
                        <span>➔</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>

<!-- Cropper Modal for Admission -->
<div id="adm_cropper-modal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-lg w-full space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                <span>✂️</span> পাসপোর্ট সাইজ ছবি ক্রপ করুন (১:১)
            </h3>
            <button type="button" id="adm_cropper-close-btn" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
        </div>
        <div class="max-h-80 overflow-hidden rounded-2xl bg-black">
            <img id="adm_cropper-image" src="" alt="To Crop" class="max-w-full">
        </div>
        <div class="flex items-center justify-center gap-2 pt-2">
            <button type="button" id="adm_crop-zoom-in" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-xs text-slate-300 font-bold">🔍+ জুম ইন</button>
            <button type="button" id="adm_crop-zoom-out" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-xs text-slate-300 font-bold">🔍- জুম আউট</button>
            <button type="button" id="adm_crop-rotate-left" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-xs text-slate-300 font-bold">↺ রোটেট</button>
            <button type="button" id="adm_crop-reset" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-xs text-slate-300 font-bold">রিসেট</button>
        </div>
        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
            <button type="button" id="adm_crop-cancel-btn" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-xl text-xs font-bold text-slate-300">বাতিল</button>
            <button type="button" id="adm_crop-confirm-btn" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-xl text-xs font-black shadow-lg shadow-emerald-500/20">ক্রপ নিশ্চিত করুন</button>
        </div>
    </div>
</div>

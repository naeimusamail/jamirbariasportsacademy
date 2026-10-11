@php
    $volCircular = $volunteerCircular ?? $circular ?? null;
    $isVolOpen = $volCircular ? $volCircular->isOpen() : true;
    $isVolUpcoming = $volCircular ? $volCircular->isUpcoming() : false;
@endphp

<div class="space-y-6">

    @if (session('error') && request('tab', $tab ?? '') === 'volunteer')
        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm flex items-center gap-3">
            <span class="text-xl">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any() && request('tab', $tab ?? '') === 'volunteer')
        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm">
            <div class="font-bold mb-1">অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!$isVolOpen)
        <!-- Circular Closed or Upcoming Card -->
        <div class="bg-slate-900/90 border {{ $isVolUpcoming ? 'border-amber-500/40 bg-gradient-to-b from-amber-950/20 to-slate-900/90' : 'border-rose-500/40 bg-gradient-to-b from-rose-950/20 to-slate-900/90' }} rounded-3xl p-8 sm:p-12 shadow-2xl backdrop-blur text-center max-w-2xl mx-auto space-y-6">
            <div class="w-20 h-20 mx-auto rounded-3xl {{ $isVolUpcoming ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }} flex items-center justify-center text-4xl shadow-xl">
                {{ $isVolUpcoming ? '⏳' : '🛑' }}
            </div>

            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $isVolUpcoming ? 'bg-amber-500/10 text-amber-400 border border-amber-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                    {{ $isVolUpcoming ? 'আবেদন আসন্ন (Upcoming)' : 'আবেদন গ্রহণ বন্ধ (Closed)' }}
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white">
                    {{ $volCircular->title ?? 'ভলান্টিয়ার নিয়োগ সার্কুলার' }}
                </h2>
                <p class="text-slate-300 text-sm leading-relaxed max-w-lg mx-auto">
                    @if($isVolUpcoming)
                        {{ $volCircular->upcoming_message ?: 'ভলান্টিয়ার নিয়োগ আবেদন খুব শীঘ্রই শুরু হতে যাচ্ছে।' }}
                    @else
                        {{ $volCircular->closed_message ?: 'ভলান্টিয়ার নিয়োগের বর্তমান সেশনের সময়সীমা সমাপ্ত হয়েছে।' }}
                    @endif
                </p>
            </div>

            <!-- Timing Details Badge -->
            <div class="p-4 rounded-2xl bg-slate-950/90 border border-slate-800 inline-block text-left text-xs space-y-1.5">
                @if($isVolUpcoming && $volCircular && $volCircular->start_date)
                    <div class="text-slate-400 flex items-center gap-2">
                        <span>🚀 আবেদন শুরুর সময়:</span>
                        <strong class="text-amber-400 font-mono">{{ $volCircular->start_date->format('d M Y, h:i A') }}</strong>
                    </div>
                @endif
                @if($volCircular && $volCircular->end_date)
                    <div class="text-slate-400 flex items-center gap-2">
                        <span>🛑 আবেদনের শেষ সময় / ডেডলাইন:</span>
                        <strong class="text-rose-400 font-mono">{{ $volCircular->end_date->format('d M Y, h:i A') }}</strong>
                    </div>
                @endif
            </div>

            <!-- Navigation Action Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('volunteer.track.search') }}" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition flex items-center justify-center gap-2">
                    <span>🔍 ভলান্টিয়ার আইডি ও ট্র্যাকিং</span>
                </a>
                <button type="button" @click="activeTab = 'admission'" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-2">
                    <span>🎓 একাডেমি ভর্তি ফরম দেখুন</span>
                </button>
            </div>
        </div>
    @else
        <!-- Form Card -->
        <div class="bg-slate-900/90 border border-slate-800 hover:border-slate-700 rounded-3xl p-6 sm:p-10 shadow-2xl backdrop-blur transition text-left">
            @if($volCircular)
                <div class="mb-8 p-5 rounded-2xl bg-gradient-to-r from-amber-950/40 via-slate-950 to-amber-950/40 border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
                    <div class="flex items-start sm:items-center gap-3.5">
                        <span class="text-2xl p-2.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 shrink-0">🤝</span>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-black text-white text-base sm:text-lg">{{ $volCircular->title }}</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                    আবেদন চলমান
                                </span>
                            </div>
                            @if($volCircular->description)
                                <p class="text-slate-400 text-xs mt-1.5 leading-relaxed">{{ $volCircular->description }}</p>
                            @endif
                            <div class="flex items-center gap-3 text-[11px] text-slate-300 mt-2 flex-wrap font-mono">
                                @if($volCircular->start_date)
                                    <span>শুরু: <strong class="text-slate-100">{{ $volCircular->start_date->format('d M Y, h:i A') }}</strong></span>
                                    <span>•</span>
                                @endif
                                @if($volCircular->end_date)
                                    <span>শেষ সময়: <strong class="text-amber-400">{{ $volCircular->end_date->format('d M Y, h:i A') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-left mb-8 pb-4 border-b border-slate-800">
                <h3 class="text-xl sm:text-2xl font-black text-white">স্বেচ্ছাসেবক আবেদন ফরম (Volunteer Registration)</h3>
                <p class="text-slate-400 text-xs mt-1">মাঠ ও পিচ ব্যবস্থাপনা, মিডিয়া, প্রাথমিক চিকিৎসা, নিরাপত্তা এবং অতিথি আপ্যায়নে যুক্ত হতে আবেদন করুন।</p>
            </div>

            <form id="volunteerForm" action="{{ route('volunteer.store') }}?tab=volunteer" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section 1: Department & Assignment Preference -->
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                        <span>🎯</span> ১. দায়িত্ব বিভাগ ও টুর্নামেন্ট নির্বাচন
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">কাঙ্ক্ষিত বিভাগ / দায়িত্ব <span class="text-rose-400">*</span></label>
                            <select name="department" required class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                                <option value="">বিভাগ বাছাই করুন...</option>
                                @foreach($departments as $key => $name)
                                    <option value="{{ $key }}" {{ old('department') == $key ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">টুর্নামেন্ট বা ইভেন্ট অগ্রাধিকার (ঐচ্ছিক)</label>
                            <select name="tournament_id" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 text-xs">
                                <option value="">যেকোনো টুর্নামেন্ট / সাধারণ একাডেমি ডিউটি</option>
                                @foreach($tournaments as $t)
                                    <option value="{{ $t->id }}" {{ old('tournament_id') == $t->id ? 'selected' : '' }}>{{ $t->name }} ({{ $t->sport->name ?? 'অল' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 2: Personal Information -->
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                        <span>👤</span> ২. ব্যক্তিগত ও যোগাযোগের তথ্য
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 text-xs">
                        <div class="sm:col-span-2">
                            <label class="block font-semibold text-slate-300 mb-1.5">পূর্ণ নাম (বাংলায়) <span class="text-rose-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="উদা: তানভীর আহমেদ" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">নাম (ইংরেজিতে)</label>
                            <input type="text" name="name_en" value="{{ old('name_en') }}" placeholder="e.g. Tanvir Ahmed" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">মোবাইল নম্বর <span class="text-rose-400">*</span></label>
                            <input type="tel" name="phone" id="vol_phone" value="{{ old('phone') }}" required placeholder="017XXXXXXXX" pattern="[0-9+ -]+" inputmode="numeric" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 font-mono english-number-only">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">জরুরি মোবাইল নম্বর</label>
                            <input type="tel" name="emergency_phone" id="vol_emergency_phone" value="{{ old('emergency_phone') }}" placeholder="018XXXXXXXX" pattern="[0-9+ -]+" inputmode="numeric" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 font-mono english-number-only">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">ইমেইল ঠিকানা (ঐচ্ছিক)</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">লিঙ্গ (Gender) <span class="text-rose-400">*</span></label>
                            <select name="gender" required class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>পুরুষ (Male)</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>নারী (Female)</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>অন্যান্য (Other)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">রক্তের গ্রুপ</label>
                            <select name="blood_group" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">
                                <option value="">বাছাই করুন...</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1.5">জার্সি সাইজ (T-Shirt Size) <span class="text-rose-400">*</span></label>
                            <select name="tshirt_size" required class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">
                                @foreach($tshirtSizes as $size)
                                    <option value="{{ $size }}" {{ old('tshirt_size', 'L') == $size ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2 lg:col-span-3">
                            <label class="block font-semibold text-slate-300 mb-1.5">শিক্ষা প্রতিষ্ঠান / পেশা / সংস্থা</label>
                            <input type="text" name="organization_or_institution" value="{{ old('organization_or_institution') }}" placeholder="উদা: ঢাকা কলেজ / চাকরিজীবী" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div class="sm:col-span-2 lg:col-span-3">
                            <label class="block font-semibold text-slate-300 mb-1.5">স্থায়ী ঠিকানা <span class="text-rose-400">*</span></label>
                            <textarea name="address" rows="2" required placeholder="গ্রাম/রোড, থানা, জেলা" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">{{ old('address') }}</textarea>
                        </div>

                        <div class="sm:col-span-2 lg:col-span-3">
                            <label class="block font-semibold text-slate-300 mb-1.5">পূর্ববর্তী অভিজ্ঞতা বা বিশেষ দক্ষতা (যদি থাকে)</label>
                            <textarea name="experience" rows="2" placeholder="পূর্বে কোনো টুর্নামেন্ট বা সামাজিক কাজে ভলান্টিয়ার করার অভিজ্ঞতা..." class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-amber-500">{{ old('experience') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800" />

                <!-- Section 3: Photo Upload with Cropper -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                            <span>📸</span> ৩. ভলান্টিয়ার ফটো আইডি ছবি (৩০০x৩০০)
                        </h4>
                        <span class="text-[11px] font-semibold text-amber-300 bg-amber-500/10 px-2.5 py-1 rounded-full border border-amber-500/20">
                            আইডি কার্ড ও ব্যাজ প্রিন্টের জন্য
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-6 p-5 rounded-2xl bg-slate-950/60 border border-slate-800">
                        <!-- Photo Preview Box -->
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-2xl bg-slate-900 border-2 border-dashed border-slate-700 flex items-center justify-center overflow-hidden shrink-0 shadow-inner" id="vol_preview-box">
                                <img id="vol_preview-img" src="" alt="Photo Preview" class="w-full h-full object-cover hidden">
                                <span id="vol_preview-placeholder" class="text-slate-400 text-xs text-center px-2">ছবি আপলোড করুন</span>
                            </div>
                            <span id="vol_crop-badge" class="hidden absolute -bottom-2 -right-2 bg-amber-500 text-slate-950 font-bold text-[10px] px-2 py-0.5 rounded-full shadow">✓ 300×300</span>
                        </div>

                        <div class="flex-1 w-full space-y-2 text-xs">
                            <label class="block font-semibold text-slate-300">ছবি নির্বাচন করুন (কম্পিউটার বা মোবাইল থেকে)</label>
                            <input type="file" name="photo" id="vol_photo-input" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-500/10 file:text-amber-400 hover:file:bg-amber-500/20 cursor-pointer">
                            <input type="hidden" name="cropped_photo" id="vol_cropped_photo">
                            
                            <p class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                <span class="text-amber-400">💡</span> নির্বাচিত ভলান্টিয়ারদের এই ছবি দিয়ে অফিসিয়াল কিউআর-কোডযুক্ত ফটো আইডি কার্ড তৈরি হবে।
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[11px] text-slate-400">
                        🤝 অনুমোদনের পর আপনি এসএমএস ও অনলাইন ট্র্যাকিংয়ের মাধ্যমে আইডি কার্ড ডাউনলোড করতে পারবেন।
                    </p>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black rounded-xl text-sm shadow-xl shadow-amber-500/25 transition flex items-center justify-center gap-2">
                        <span>🤝 ভলান্টিয়ার আবেদন জমা দিন</span>
                        <span>➔</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>

<!-- Cropper Modal for Volunteer -->
<div id="vol_cropper-modal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-lg w-full space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h4 class="text-sm font-bold text-white flex items-center gap-2">
                <span>✂️</span> ভলান্টিয়ার ছবি ক্রপ করুন (১:১)
            </h4>
            <button type="button" id="vol_cropper-close-btn" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
        </div>
        <div class="max-h-80 overflow-hidden rounded-2xl bg-black">
            <img id="vol_cropper-image" src="" alt="To Crop" class="max-w-full">
        </div>
        <div class="flex items-center justify-center gap-2 pt-2">
            <button type="button" id="vol_crop-zoom-in" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-xs text-slate-300 font-bold">🔍+ জুম ইন</button>
            <button type="button" id="vol_crop-zoom-out" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-xs text-slate-300 font-bold">🔍- জুম আউট</button>
            <button type="button" id="vol_crop-rotate-left" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-xs text-slate-300 font-bold">↺ রোটেট</button>
            <button type="button" id="vol_crop-reset" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-xs text-slate-300 font-bold">রিসেট</button>
        </div>
        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
            <button type="button" id="vol_crop-cancel-btn" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-xl text-xs font-bold text-slate-300">বাতিল</button>
            <button type="button" id="vol_crop-confirm-btn" class="px-5 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-black shadow-lg shadow-amber-500/20">ক্রপ নিশ্চিত করুন</button>
        </div>
    </div>
</div>

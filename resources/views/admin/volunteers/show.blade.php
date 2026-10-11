<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
                    <span>🤝</span> {{ __('ভলান্টিয়ার পর্যালোচনা ও ডিউটি অ্যাসাইন') }} - {{ $volunteer->volunteer_no }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    স্বেচ্ছাসেবকের তথ্য যাচাই, অনুমোদন ও টুর্নামেন্টে সুনির্দিষ্ট দায়িত্ব বণ্টন করুন
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.volunteers.index') }}" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold transition">
                    &larr; তালিকায় ফিরে যান
                </a>
                <a href="{{ route('volunteer.id-card', $volunteer->volunteer_no) }}" target="_blank" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-black shadow flex items-center gap-1.5 transition">
                    <span>🪪 ফটো আইডি ব্যাজ প্রিন্ট</span> ↗
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold flex items-center gap-2">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Volunteer Profile Card -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 space-y-5">
                    <div class="text-center pb-5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-32 h-32 rounded-2xl bg-gray-100 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 overflow-hidden mx-auto mb-3 flex items-center justify-center shadow">
                            @if($volunteer->photo)
                                <img src="{{ asset('storage/' . $volunteer->photo) }}" alt="{{ $volunteer->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl text-gray-400">👤</span>
                            @endif
                        </div>

                        <h3 class="text-lg font-black text-gray-900 dark:text-white">
                            {{ $volunteer->name }}
                        </h3>
                        @if($volunteer->name_en)
                            <p class="text-xs text-gray-400">{{ $volunteer->name_en }}</p>
                        @endif

                        <div class="mt-2 inline-block px-3 py-1 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 font-mono font-bold text-xs border border-amber-500/20">
                            {{ $volunteer->volunteer_no }}
                        </div>

                        <div class="mt-2">
                            @if($volunteer->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400">
                                    ✓ অনুমোদিত (Approved)
                                </span>
                            @elseif($volunteer->status === 'active')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-400">
                                    ● সক্রিয় ডিউটিতে (Active)
                                </span>
                            @elseif($volunteer->status === 'rejected')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-400">
                                    ✕ বাতিল (Rejected)
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400">
                                    ⏳ অপেক্ষমাণ (Pending)
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Personal Information List -->
                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-gray-400 block">বিভাগ:</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $volunteer->department_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">মোবাইল নম্বর:</span>
                            <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $volunteer->phone }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">জরুরি যোগাযোগ:</span>
                            <span class="font-mono text-gray-700 dark:text-gray-300">{{ $volunteer->emergency_phone ?: 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">টি-শার্ট সাইজ:</span>
                            <span class="font-bold text-amber-600 dark:text-amber-400 text-sm font-mono">{{ $volunteer->tshirt_size }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">রক্তের গ্রুপ:</span>
                            <span class="font-bold text-rose-500">{{ $volunteer->blood_group ?: 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">শিক্ষা প্রতিষ্ঠান / পেশা:</span>
                            <span class="text-gray-800 dark:text-gray-200">{{ $volunteer->organization_or_institution ?: 'সাধারণ' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">ঠিকানা:</span>
                            <span class="text-gray-800 dark:text-gray-200">{{ $volunteer->address }}</span>
                        </div>
                        @if($volunteer->experience)
                            <div>
                                <span class="text-gray-400 block">পূর্ব অভিজ্ঞতা:</span>
                                <span class="text-gray-800 dark:text-gray-200 leading-relaxed">{{ $volunteer->experience }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Duty Assignment & Status Control -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Form 1: Assign Duty & Venue -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-7 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="border-b border-gray-100 dark:border-gray-700 pb-4 mb-5">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span>🛡️</span> টুর্নামেন্ট ও ডিউটি বণ্টন (Duty Roster)
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">এই ভলান্টিয়ারের সুনির্দিষ্ট দায়িত্ব ও ভেন্যু নির্ধারণ করুন</p>
                        </div>

                        <form method="POST" action="{{ route('admin.volunteers.assign-duty', $volunteer->id) }}" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    অর্পিত দায়িত্বের বিবরণ (Assigned Duty) *
                                </label>
                                <textarea name="assigned_duties" rows="2" required placeholder="উদা: পিচ কভার ম্যানেজমেন্ট ও গ্রাউন্ড বাউন্ডারি লাইন কো-অর্ডিনেশন" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">{{ old('assigned_duties', $volunteer->assigned_duties) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        ভেন্যু বা নির্দিষ্ট মাঠ (Assigned Venue)
                                    </label>
                                    <input type="text" name="assigned_venue" value="{{ old('assigned_venue', $volunteer->assigned_venue) }}" placeholder="উদা: প্রধান গ্রাউন্ড - জামিরবাড়িয়া" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        টুর্নামেন্ট নির্ধারণ (Tournament)
                                    </label>
                                    <select name="tournament_id" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">
                                        <option value="">উন্মুক্ত একাডেমি ইভেন্টস</option>
                                        @foreach($tournaments as $t)
                                            <option value="{{ $t->id }}" {{ old('tournament_id', $volunteer->tournament_id) == $t->id ? 'selected' : '' }}>
                                                🏆 {{ $t->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    বিভাগ পরিবর্তন করতে চাইলে (Department)
                                </label>
                                <select name="department" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">
                                    @foreach($departments as $k => $d)
                                        <option value="{{ $k }}" {{ old('department', $volunteer->department) == $k ? 'selected' : '' }}>
                                            {{ $d }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    অ্যাডমিন নোট (অভ্যন্তরীণ নির্দেশিকা)
                                </label>
                                <input type="text" name="admin_notes" value="{{ old('admin_notes', $volunteer->admin_notes) }}" placeholder="যেমন: ম্যাচ শুরুর ২ ঘণ্টা আগে মাঠে উপস্থিত থাকতে হবে" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">
                            </div>

                            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs shadow transition">
                                ✓ দায়িত্ব ও ভেন্যু সেভ করুন
                            </button>
                        </form>
                    </div>

                    <!-- Form 2: Quick Status Change (Approve / Reject) -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm">আবেদনের সিদ্ধান্ত (Status)</h4>
                            <p class="text-xs text-gray-400">অনুমোদন করলে ভলান্টিয়ার আইডি কার্ড সক্রিয় হয়ে যাবে</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('admin.volunteers.update-status', $volunteer->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold transition">
                                    ✓ অনুমোদন (Approve)
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.volunteers.update-status', $volunteer->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-xl text-xs font-bold transition">
                                    ● সক্রিয় ডিউটিতে (Active)
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.volunteers.update-status', $volunteer->id) }}" class="inline" onsubmit="return confirm('আপনি কি নিশ্চিত যে আবেদনটি বাতিল করতে চান?')">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold transition">
                                    ✕ বাতিল
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.volunteers.destroy', $volunteer->id) }}" class="inline" onsubmit="return confirm('স্থায়ীভাবে এই ভলান্টিয়ার রেকর্ড মুছে ফেলতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 rounded-xl text-xs transition" title="মুছে ফেলুন">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


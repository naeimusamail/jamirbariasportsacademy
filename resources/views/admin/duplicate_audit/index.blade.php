<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-white flex items-center gap-2.5">
                    <span>🛡️</span> ডুপ্লিকেট ডকুমেন্ট ও প্লেয়ার অডিট হাব (Duplicate Audit Hub)
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    পুরো ডাটাবেজ স্বয়ংক্রিয়ভাবে স্ক্যান করে ডুপ্লিকেট NID/জন্মসনদ, মোবাইল নম্বর ও সন্দেহভাজন আইডি শনাক্তকরণ।
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.players.search') }}"
                   class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs flex items-center gap-2 transition">
                    <span>🔍</span>
                    <span>সার্বজনীন প্লেয়ার সার্চ</span>
                </a>
                <a href="{{ route('admin.duplicate-audit.index') }}"
                   class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-1.5 transition shadow-lg shadow-emerald-950/40">
                    <span>🔄</span>
                    <span>রি-স্ক্যান করুন</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. Audit Metric Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-slate-400 text-xs font-semibold block">মোট ডুপ্লিকেট ঘটনা</span>
                        <span class="text-2xl sm:text-3xl font-black text-white mt-1 block">
                            {{ $audit['total_duplicates_found'] }}
                        </span>
                        <span class="text-[10px] text-slate-500 mt-0.5 block">প্রভাবিত রেকর্ড: {{ $audit['total_affected_players'] }} টি</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-slate-800 flex items-center justify-center text-xl text-amber-400 border border-slate-700">
                        ⚖️
                    </div>
                </div>

                <div class="bg-slate-900 border {{ count($audit['duplicate_nids']) > 0 ? 'border-rose-500/50 bg-rose-950/10' : 'border-slate-800' }} rounded-3xl p-5 shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-slate-400 text-xs font-semibold block">ডুপ্লিকেট NID / জন্মসনদ</span>
                        <span class="text-2xl sm:text-3xl font-black {{ count($audit['duplicate_nids']) > 0 ? 'text-rose-400' : 'text-white' }} mt-1 block">
                            {{ count($audit['duplicate_nids']) }}
                        </span>
                        <span class="text-[10px] {{ count($audit['duplicate_nids']) > 0 ? 'text-rose-400 font-bold' : 'text-slate-500' }} mt-0.5 block">
                            {{ count($audit['duplicate_nids']) > 0 ? 'উচ্চ ঝুঁকি (Severe Risk)' : 'কোনো সমস্যা নেই' }}
                        </span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl {{ count($audit['duplicate_nids']) > 0 ? 'bg-rose-500/20 text-rose-400 border border-rose-500/40' : 'bg-slate-800 text-slate-400 border border-slate-700' }} flex items-center justify-center text-xl">
                        🪪
                    </div>
                </div>

                <div class="bg-slate-900 border {{ count($audit['duplicate_phones']) > 0 ? 'border-amber-500/50 bg-amber-950/10' : 'border-slate-800' }} rounded-3xl p-5 shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-slate-400 text-xs font-semibold block">একই মোবাইল নম্বর</span>
                        <span class="text-2xl sm:text-3xl font-black {{ count($audit['duplicate_phones']) > 0 ? 'text-amber-400' : 'text-white' }} mt-1 block">
                            {{ count($audit['duplicate_phones']) }}
                        </span>
                        <span class="text-[10px] {{ count($audit['duplicate_phones']) > 0 ? 'text-amber-400 font-bold' : 'text-slate-500' }} mt-0.5 block">
                            {{ count($audit['duplicate_phones']) > 0 ? 'সতর্কতা প্রয়োজন' : 'কোনো ডুপ্লিকেট নেই' }}
                        </span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl {{ count($audit['duplicate_phones']) > 0 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/40' : 'bg-slate-800 text-slate-400 border border-slate-700' }} flex items-center justify-center text-xl">
                        📱
                    </div>
                </div>

                <div class="bg-slate-900 border {{ count($audit['duplicate_identities']) > 0 ? 'border-indigo-500/50 bg-indigo-950/10' : 'border-slate-800' }} rounded-3xl p-5 shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-slate-400 text-xs font-semibold block">একই নাম + জন্মতারিখ</span>
                        <span class="text-2xl sm:text-3xl font-black text-indigo-400 mt-1 block">
                            {{ count($audit['duplicate_identities']) }}
                        </span>
                        <span class="text-[10px] text-indigo-400 mt-0.5 block">সম্ভাব্য পরিচয় সাদৃশ্য</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/40 flex items-center justify-center text-xl">
                        👥
                    </div>
                </div>
            </div>

            <!-- 2. Clean State Banner (If no duplicates exist) -->
            @if($audit['total_duplicates_found'] === 0)
                <div class="bg-gradient-to-r from-emerald-950/60 to-slate-900 border border-emerald-500/30 rounded-3xl p-10 text-center shadow-xl">
                    <div class="w-16 h-16 rounded-3xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-3xl mx-auto mb-4 text-emerald-400">
                        ✓
                    </div>
                    <h3 class="text-xl font-black text-white">অভিনন্দন! ডাটাবেজ ১০০% ইউনিক ও নির্ভুল</h3>
                    <p class="text-xs text-slate-300 max-w-lg mx-auto mt-2 leading-relaxed">
                        সিস্টেমের সকল খেলোয়াড়ের NID, ডিজিটাল জন্ম নিবন্ধন সনদ নম্বর এবং মোবাইল নম্বর সম্পূর্ণ ইউনিক রয়েছে। নতুন কোনো ডুপ্লিকেট তথ্য সনাক্ত হয়নি।
                    </p>
                    <div class="mt-6 flex justify-center gap-3">
                        <a href="{{ route('admin.players.search') }}"
                           class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2">
                            <span>🔍 প্লেয়ার সার্চ হাব দেখুন</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 3. High Risk: Duplicate NID / Birth Cert Groups -->
            @if(!empty($audit['duplicate_nids']))
                <div class="space-y-4">
                    <div class="flex items-center gap-2 text-rose-400 font-bold text-sm">
                        <span>🔴</span>
                        <span>উচ্চ ঝুঁকি: একই NID / জন্মসনদ একাধিক প্রোফাইলে ব্যবহৃত ({{ count($audit['duplicate_nids']) }} টি গ্রুপ)</span>
                    </div>

                    @foreach($audit['duplicate_nids'] as $docNumber => $group)
                        <div class="bg-slate-900 border border-rose-500/30 rounded-3xl p-5 sm:p-6 shadow-xl space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-800 pb-3">
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-300 font-mono text-xs font-black">
                                        NID/সনদ: {{ $docNumber }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-semibold">
                                        এই নম্বরটি {{ count($group) }} জন খেলোয়াড়ের ডাটাতে বিদ্যমান
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($group as $tr)
                                    <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center overflow-hidden shrink-0">
                                                @if($tr->photo)
                                                    <img src="{{ asset('storage/' . $tr->photo) }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-lg">👤</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <h5 class="text-sm font-bold text-white truncate">{{ $tr->name }}</h5>
                                                <span class="text-[10px] font-mono font-bold text-amber-400">{{ $tr->admission_no }}</span>
                                                <span class="block text-[10px] text-slate-400">{{ $tr->player_type === 'local' ? 'উন্মুক্ত লোকাল প্লেয়ার' : 'একাডেমিক' }}</span>
                                            </div>
                                        </div>
                                        <div class="text-[11px] text-slate-300 space-y-1 border-t border-slate-800/80 pt-2 mb-3">
                                            <div>ফোন: <span class="font-mono text-white">{{ $tr->phone }}</span></div>
                                            <div>জন্মতারিখ: <span class="font-mono text-white">{{ $tr->date_of_birth }}</span></div>
                                            <div>নিবন্ধন তারিখ: <span class="text-slate-400">{{ $tr->created_at->format('d M, Y') }}</span></div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <a href="{{ route('trainees.show', $tr->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold text-center transition">
                                                প্রোফাইল
                                            </a>
                                            <a href="{{ route('trainees.edit', $tr->id) }}" class="px-2.5 py-1.5 rounded-lg bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/30 text-[11px] font-bold text-center transition">
                                                সংশোধন
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- 4. Medium Risk: Duplicate Phone Groups -->
            @if(!empty($audit['duplicate_phones']))
                <div class="space-y-4">
                    <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                        <span>🟡</span>
                        <span>সতর্কতা: একই মোবাইল নম্বর একাধিক প্লেয়ারে ব্যবহৃত ({{ count($audit['duplicate_phones']) }} টি গ্রুপ)</span>
                    </div>

                    @foreach($audit['duplicate_phones'] as $phoneNo => $group)
                        <div class="bg-slate-900 border border-amber-500/30 rounded-3xl p-5 sm:p-6 shadow-xl space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-800 pb-3">
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-300 font-mono text-xs font-black">
                                        ফোন: {{ $phoneNo }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-semibold">
                                        একই নম্বরে {{ count($group) }} জন নিবন্ধিত
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($group as $tr)
                                    <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center overflow-hidden shrink-0">
                                                @if($tr->photo)
                                                    <img src="{{ asset('storage/' . $tr->photo) }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-lg">👤</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <h5 class="text-sm font-bold text-white truncate">{{ $tr->name }}</h5>
                                                <span class="text-[10px] font-mono font-bold text-amber-400">{{ $tr->admission_no }}</span>
                                                <span class="block text-[10px] text-slate-400">{{ $tr->player_type === 'local' ? 'লোকাল প্লেয়ার' : 'একাডেমিক' }}</span>
                                            </div>
                                        </div>
                                        <div class="text-[11px] text-slate-300 space-y-1 border-t border-slate-800/80 pt-2 mb-3">
                                            <div>NID/সনদ: <span class="font-mono text-white">{{ $tr->nid_or_birth_cert ?? 'N/A' }}</span></div>
                                            <div>অভিভাবক: <span class="text-slate-400">{{ $tr->guardian_name }}</span></div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <a href="{{ route('trainees.show', $tr->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold text-center transition">
                                                প্রোফাইল
                                            </a>
                                            <a href="{{ route('trainees.edit', $tr->id) }}" class="px-2.5 py-1.5 rounded-lg bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/30 text-[11px] font-bold text-center transition">
                                                সংশোধন
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- 5. Name + Date of Birth Matches -->
            @if(!empty($audit['duplicate_identities']))
                <div class="space-y-4">
                    <div class="flex items-center gap-2 text-indigo-400 font-bold text-sm">
                        <span>👥</span>
                        <span>সম্ভাব্য সাদৃশ্য: হুবহু একই নাম এবং একই জন্মতারিখ ({{ count($audit['duplicate_identities']) }} টি গ্রুপ)</span>
                    </div>

                    @foreach($audit['duplicate_identities'] as $identKey => $group)
                        <div class="bg-slate-900 border border-indigo-500/30 rounded-3xl p-5 sm:p-6 shadow-xl space-y-4">
                            <div class="border-b border-slate-800 pb-3">
                                <span class="px-3 py-1 rounded-xl bg-indigo-500/20 border border-indigo-500/40 text-indigo-300 text-xs font-bold">
                                    {{ $group[0]->name }} (জন্ম: {{ $group[0]->date_of_birth }})
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($group as $tr)
                                    <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center overflow-hidden shrink-0">
                                                @if($tr->photo)
                                                    <img src="{{ asset('storage/' . $tr->photo) }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-lg">👤</span>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <h5 class="text-sm font-bold text-white truncate">{{ $tr->name }}</h5>
                                                <span class="text-[10px] font-mono font-bold text-amber-400">{{ $tr->admission_no }}</span>
                                                <span class="block text-[10px] text-slate-400">{{ $tr->player_type === 'local' ? 'লোকাল' : 'একাডেমিক' }}</span>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <a href="{{ route('trainees.show', $tr->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold text-center transition">
                                                প্রোফাইল
                                            </a>
                                            <a href="{{ route('trainees.edit', $tr->id) }}" class="px-2.5 py-1.5 rounded-lg bg-indigo-500/20 hover:bg-indigo-500/30 text-indigo-300 border border-indigo-500/30 text-[11px] font-bold text-center transition">
                                                সংশোধন
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>


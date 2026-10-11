<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>🪪</span> {{ __('প্লেয়ার ডিজিটাল আইডি কার্ড সেন্টার') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    সকল প্লেয়ারের কিউআর কোড (QR Code) ও ৩০০×৩০০ ছবি সম্বলিত ডিজিটাল আইডি কার্ড প্রস্তুত ও প্রিন্ট করুন
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.certificates.index') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                    <span>📜</span> {{ __('সনদপত্র সেন্টার') }}
                </a>
                <a href="{{ route('trainees.index') }}" class="px-3.5 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                    &larr; {{ __('প্লেয়ার তালিকা') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ selected: [] }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Filter & Search Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('admin.id-cards.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1">প্লেয়ারের নাম / আইডি / ফোন</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম বা JSA-2026-001..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                    </div>

                    <!-- Sport Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1">খেলা (Sport)</label>
                        <select name="sport_id" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                            <option value="">সকল খেলা</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->id }}" {{ request('sport_id') == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Batch Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1">ব্যাচ</label>
                        <select name="batch_id" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                            <option value="">সকল ব্যাচ</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow">
                            ফিল্টার করুন
                        </button>
                        <a href="{{ route('admin.id-cards.index') }}" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-bold transition">
                            রিসেট
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bulk Action Bar -->
            <div class="flex flex-wrap items-center justify-between gap-3 bg-gradient-to-r from-emerald-900 to-slate-900 text-white p-4 rounded-2xl shadow-lg border border-emerald-500/30">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🖨️</span>
                    <div>
                        <h4 class="text-sm font-bold">একসাথে একাধিক আইডি কার্ড প্রিন্ট (Bulk Print)</h4>
                        <p class="text-xs text-emerald-200/80">নিচের তালিকা থেকে প্লেয়ার সিলেক্ট করে একসাথে A4 শিটে প্রিন্ট করুন</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <form method="GET" action="{{ route('admin.id-cards.bulk') }}" target="_blank" class="inline">
                        <!-- Dynamic hidden inputs for selected IDs -->
                        <template x-for="id in selected" :key="id">
                            <input type="hidden" name="trainee_ids[]" :value="id">
                        </template>
                        <button type="submit" :disabled="selected.length === 0" :class="selected.length === 0 ? 'opacity-50 cursor-not-allowed bg-gray-700' : 'bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black shadow-lg shadow-emerald-500/30'" class="px-4 py-2 rounded-xl text-xs transition flex items-center gap-1.5">
                            <span>🖨️ সিলেক্টকৃত কার্ড প্রিন্ট</span>
                            <span x-show="selected.length > 0" class="px-1.5 py-0.5 rounded-full bg-slate-950 text-white text-[10px]" x-text="selected.length"></span>
                        </button>
                    </form>

                    <a href="{{ route('admin.id-cards.bulk', request()->all()) }}" target="_blank" class="px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-bold border border-white/20 transition">
                        ফিল্টারের সবাই প্রিন্ট (সর্বোচ্চ ৩০)
                    </a>
                </div>
            </div>

            <!-- Player Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="p-4 w-10 text-center">
                                    <input type="checkbox" @click="selected = ($event.target.checked ? [{{ $trainees->pluck('id')->join(',') }}] : [])" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </th>
                                <th class="p-4">প্লেয়ার প্রোফাইল</th>
                                <th class="p-4">আইডি নং</th>
                                <th class="p-4">খেলা ও ক্যাটাগরি</th>
                                <th class="p-4">রক্তের গ্রুপ</th>
                                <th class="p-4">ফোন / জরুরি</th>
                                <th class="p-4 text-center">স্ট্যাটাস</th>
                                <th class="p-4 text-right">আইডি কার্ড অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                            @forelse($trainees as $trainee)
                                <tr class="hover:bg-emerald-50/40 dark:hover:bg-gray-750 transition">
                                    <td class="p-4 text-center">
                                        <input type="checkbox" :value="{{ $trainee->id }}" x-model="selected" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-900 border border-emerald-500/40 overflow-hidden shrink-0 flex items-center justify-center">
                                                @if($trainee->photo)
                                                    <img src="{{ asset('storage/' . $trainee->photo) }}" alt="{{ $trainee->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="font-bold text-emerald-400 text-sm">{{ mb_substr($trainee->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $trainee->name }}</div>
                                                <div class="text-[11px] text-gray-500">{{ $trainee->batch->name ?? 'ব্যাচ বরাদ্দহীন' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ $trainee->admission_no }}
                                    </td>
                                    <td class="p-4">
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $trainee->sport->name ?? 'সাধারণ' }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $trainee->category }} @if($trainee->jersey_no) • #{{ $trainee->jersey_no }} @endif</div>
                                    </td>
                                    <td class="p-4">
                                        @if($trainee->blood_group)
                                            <span class="px-2 py-0.5 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 font-bold font-mono text-[11px]">
                                                {{ $trainee->blood_group }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-[11px]">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 font-mono text-[11px]">
                                        <div>{{ $trainee->phone }}</div>
                                        @if($trainee->emergency_phone)
                                            <div class="text-[10px] text-gray-400">জরুরি: {{ $trainee->emergency_phone }}</div>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($trainee->status === 'active')
                                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-[10px]">সক্রিয়</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full bg-gray-500/10 text-gray-500 text-[10px]">নিষ্ক্রিয়</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                        <a href="{{ route('admin.id-cards.show', $trainee) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                            <span>🪪 কার্ড দেখুন ও প্রিন্ট</span>
                                        </a>
                                        <a href="{{ route('admin.certificates.create', ['trainee_id' => $trainee->id]) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-500/10 hover:bg-amber-500 text-amber-700 hover:text-white dark:text-amber-300 rounded-lg text-xs font-bold transition">
                                            <span>📜 সনদপত্র</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-gray-500">
                                        কোনো প্লেয়ার পাওয়া যায়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($trainees->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $trainees->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>


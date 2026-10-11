<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>📋</span> {{ __('অনলাইন ভর্তি আবেদন ব্যবস্থাপনা') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    পাবলিক পোর্টাল থেকে আসা আবেদনসমূহ যাচাই, অনুমোদন এবং ব্যাচে অন্তর্ভুক্ত করুন
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                    বিচারাধীন: {{ $pendingCount }} টি
                </span>
                <a href="{{ route('admission.create') }}" target="_blank" class="inline-flex items-center px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-semibold shadow transition">
                    + পাবলিক ফর্ম দেখুন ↗
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold flex items-center justify-between">
                    <span>✓ {{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="p-4 rounded-xl bg-sky-500/10 border border-sky-500/30 text-sky-600 dark:text-sky-400 text-sm font-semibold">
                    ℹ {{ session('info') }}
                </div>
            @endif

            <!-- Filter & Search Toolbar -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('admin.admissions.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম, আবেদন নং বা মোবাইল..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-emerald-500">
                    </div>

                    <div>
                        <select name="circular_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-emerald-500">
                            <option value="">সকল ভর্তি সার্কুলার</option>
                            @if(isset($circulars))
                                @foreach($circulars as $circ)
                                    <option value="{{ $circ->id }}" {{ request('circular_id') == $circ->id ? 'selected' : '' }}>
                                        🎓 {{ Str::limit($circ->title, 28) }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div>
                        <select name="status" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-emerald-500">
                            <option value="">সকল স্ট্যাটাস</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ বিচারাধীন (Pending)</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✓ অনুমোদিত (Approved)</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>✕ বাতিল (Rejected)</option>
                        </select>
                    </div>

                    <div>
                        <select name="sport_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-emerald-500">
                            <option value="">সকল খেলা</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->id }}" {{ request('sport_id') == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-2 px-4 bg-gray-900 dark:bg-gray-700 hover:bg-gray-800 text-white rounded-xl text-xs font-semibold transition">
                            ফিল্টার
                        </button>
                        <a href="{{ route('admin.admissions.index') }}" class="py-2 px-3 bg-gray-100 dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-semibold transition">
                            রিসেট
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table of Applications -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/60 border-b border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">
                                <th class="p-4">আবেদনকারী</th>
                                <th class="p-4">আবেদন নং</th>
                                <th class="p-4">ভর্তি সার্কুলার</th>
                                <th class="p-4">খেলা ও ক্যাটাগরি</th>
                                <th class="p-4">অভিভাবক ও যোগাযোগ</th>
                                <th class="p-4">তারিখ</th>
                                <th class="p-4">স্ট্যাটাস</th>
                                <th class="p-4 text-right">পদক্ষেপ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                            @forelse($applications as $app)
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden shrink-0 flex items-center justify-center font-bold text-gray-600 dark:text-gray-300">
                                                @if($app->photo)
                                                    <img src="{{ asset('storage/' . $app->photo) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    {{ mb_substr($app->name, 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $app->name }}</div>
                                                <div class="text-[11px] text-gray-400">{{ $app->position ?? 'সাধারণ' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ $app->application_no }}
                                    </td>
                                    <td class="p-4">
                                        @if($app->circular)
                                            <a href="{{ route('admin.admissions.index', ['circular_id' => $app->circular->id]) }}" class="inline-flex items-center gap-1 font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">
                                                <span>🎓</span> {{ Str::limit($app->circular->title, 26) }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-[11px]">সাধারণ ভর্তি</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-200">{{ $app->sport->name ?? 'N/A' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $app->category }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-gray-800 dark:text-gray-200 font-medium">{{ $app->guardian_name }}</div>
                                        <div class="font-mono text-gray-500 dark:text-gray-400">{{ $app->phone }}</div>
                                    </td>
                                    <td class="p-4 text-gray-500 dark:text-gray-400">
                                        {{ $app->created_at->format('d M, Y') }}
                                    </td>
                                    <td class="p-4">
                                        @if($app->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700">
                                                ✓ অনুমোদিত
                                            </span>
                                        @elseif($app->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-300 border border-rose-300 dark:border-rose-700">
                                                ✕ বাতিল
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 border border-amber-300 dark:border-amber-700">
                                                ⏳ বিচারাধীন
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('admin.admissions.show', $app) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg text-xs transition">
                                            পর্যালোচনা ও সিদ্ধান্ত ➔
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-gray-400">
                                        কোনো ভর্তি আবেদন পাওয়া যায়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($applications->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


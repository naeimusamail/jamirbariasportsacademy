<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
                    <span>🤝</span> {{ __('ভলান্টিয়ার হাব ও ডিউটি রোস্টার') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    টুর্নামেন্ট ও একাডেমি ইভেন্টের স্বেচ্ছাসেবক আবেদন পর্যালোচনা, অনুমোদন ও দায়িত্ব বণ্টন
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('volunteer.create') }}" target="_blank" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-black shadow flex items-center gap-1.5 transition">
                    <span>+ নতুন আবেদন ফরম</span> ↗
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold flex items-center gap-2">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- 1. Stats Counter Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm text-center">
                    <span class="text-xs font-bold text-gray-400 block">মোট আবেদন</span>
                    <span class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['total'] }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm text-center">
                    <span class="text-xs font-bold text-amber-500 block">⏳ অপেক্ষমাণ</span>
                    <span class="text-2xl font-black text-amber-500">{{ $stats['pending'] }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm text-center">
                    <span class="text-xs font-bold text-emerald-500 block">✓ অনুমোদিত</span>
                    <span class="text-2xl font-black text-emerald-500">{{ $stats['approved'] }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm text-center">
                    <span class="text-xs font-bold text-cyan-500 block">🛡️ ডিউটি বরাদ্দ</span>
                    <span class="text-2xl font-black text-cyan-500">{{ $stats['duty_assigned'] }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm text-center">
                    <span class="text-xs font-bold text-rose-500 block">✕ বাতিল</span>
                    <span class="text-2xl font-black text-rose-500">{{ $stats['rejected'] }}</span>
                </div>
            </div>

            <!-- 2. Search & Filter Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
                <form method="GET" action="{{ route('admin.volunteers.index') }}" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                    <div class="sm:col-span-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম, আবেদন নং বা মোবাইল দিয়ে খুঁজুন..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <select name="status" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">
                            <option value="all">সকল স্ট্যাটাস</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ অপেক্ষমাণ</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✓ অনুমোদিত</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>● সক্রিয় ডিউটিতে</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>✕ বাতিল</option>
                        </select>
                    </div>

                    <div>
                        <select name="department" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">
                            <option value="all">সকল কাজের বিভাগ</option>
                            @foreach($departments as $k => $dep)
                                <option value="{{ $k }}" {{ request('department') == $k ? 'selected' : '' }}>{{ $dep }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <select name="tshirt_size" class="w-1/2 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-2 py-2 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500">
                            <option value="all">টি-শার্ট</option>
                            @foreach($tshirtSizes as $sz)
                                <option value="{{ $sz }}" {{ request('tshirt_size') == $sz ? 'selected' : '' }}>{{ $sz }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-1/2 px-3 py-2 bg-gray-900 hover:bg-gray-800 dark:bg-amber-500 dark:hover:bg-amber-400 dark:text-slate-950 text-white rounded-xl text-xs font-bold transition">
                            ফিল্টার
                        </button>
                    </div>
                </form>
            </div>

            <!-- 3. Volunteers Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                        <thead class="text-[11px] uppercase bg-gray-50 dark:bg-gray-750 text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-5 py-4">ভলান্টিয়ার</th>
                                <th class="px-5 py-4">বিভাগ ও টুর্নামেন্ট</th>
                                <th class="px-5 py-4">যোগাযোগ</th>
                                <th class="px-5 py-4">টি-শার্ট</th>
                                <th class="px-5 py-4">অর্পিত দায়িত্ব</th>
                                <th class="px-5 py-4">স্ট্যাটাস</th>
                                <th class="px-5 py-4 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($volunteers as $v)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-750/50 transition">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-11 h-11 rounded-xl bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 overflow-hidden shrink-0 flex items-center justify-center">
                                                @if($v->photo)
                                                    <img src="{{ asset('storage/' . $v->photo) }}" alt="{{ $v->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-lg text-gray-400">👤</span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white text-sm">
                                                    {{ $v->name }}
                                                </div>
                                                @if($v->name_en)
                                                    <div class="text-[11px] text-gray-400">{{ $v->name_en }}</div>
                                                @endif
                                                <div class="font-mono text-[10px] text-amber-600 dark:text-amber-400 font-bold">
                                                    {{ $v->volunteer_no }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $v->department_name }}
                                        </div>
                                        @if($v->tournament)
                                            <div class="text-[10px] text-amber-500 font-bold mt-0.5">
                                                🏆 {{ $v->tournament->name }}
                                            </div>
                                        @else
                                            <div class="text-[10px] text-gray-400 mt-0.5">উন্মুক্ত একাডেমি ইভেন্টস</div>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 font-mono">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $v->phone }}</div>
                                        <div class="text-[10px] text-gray-400 truncate max-w-[150px] font-sans">{{ $v->address }}</div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-xs font-black font-mono text-amber-600 dark:text-amber-400">
                                            {{ $v->tshirt_size }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4">
                                        @if($v->assigned_duties)
                                            <div class="font-semibold text-emerald-600 dark:text-emerald-400 text-xs max-w-[180px]">
                                                {{ $v->assigned_duties }}
                                            </div>
                                            @if($v->assigned_venue)
                                                <div class="text-[10px] text-gray-400">📍 {{ $v->assigned_venue }}</div>
                                            @endif
                                        @else
                                            <span class="text-gray-400 italic text-[11px]">বরাদ্দ করা হয়নি</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        @if($v->status === 'approved')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400">
                                                ✓ অনুমোদিত
                                            </span>
                                        @elseif($v->status === 'active')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-400">
                                                ● সক্রিয়
                                            </span>
                                        @elseif($v->status === 'rejected')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-400">
                                                ✕ বাতিল
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400">
                                                ⏳ অপেক্ষমাণ
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.volunteers.show', $v->id) }}" class="p-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-bold" title="বিস্তারিত ও ডিউটি বণ্টন">
                                                ⚙️ রিভিউ
                                            </a>

                                            <a href="{{ route('volunteer.id-card', $v->volunteer_no) }}" target="_blank" class="p-1.5 bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/20 rounded-lg text-xs font-bold" title="ফটো আইডি ব্যাজ">
                                                🪪 আইডি
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-gray-400">
                                        কোনো ভলান্টিয়ার আবেদন পাওয়া যায়নি।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($volunteers->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $volunteers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


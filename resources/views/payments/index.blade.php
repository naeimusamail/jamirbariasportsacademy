<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                    {{ __('ফি ও পেমেন্ট কালেকশন (Fees & Accounting)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">একাডেমির সকল ফি গ্রহণ ও বকেয়া হিসাব</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('reports.financial') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-teal-500/10 hover:bg-teal-500/20 text-teal-600 dark:text-teal-400 border border-teal-500/30 font-bold rounded-xl text-xs sm:text-sm transition">
                    <span>📊</span> ক্যাশ বুক / P&L
                </a>
                <a href="{{ route('payments.defaulters') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 font-bold rounded-xl text-xs sm:text-sm transition">
                    <span>⚠️</span> বকেয়া ফি তালিকা
                </a>
                <a href="{{ route('payments.export', request()->query()) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs sm:text-sm transition">
                    <span>📥</span> CSV এক্সপোর্ট
                </a>
                <a href="{{ route('payments.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-xs sm:text-sm shadow">
                    + নতুন ফি গ্রহণ করুন
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Balance Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs text-emerald-100 font-bold uppercase tracking-wider">মোট ফি আদায় (Total Collected)</span>
                        <div class="text-3xl font-black mt-1">৳{{ number_format($totalCollected) }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">✓</div>
                </div>

                <div class="bg-gradient-to-r from-rose-600 to-amber-700 rounded-2xl p-6 text-white shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs text-rose-100 font-bold uppercase tracking-wider">মোট বকেয়া ফি (Total Due)</span>
                        <div class="text-3xl font-black mt-1">৳{{ number_format($totalDue) }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">⚠️</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('payments.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="রসিদ নং / ট্রেইনির নাম..." class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">

                    <select name="status" class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        <option value="">সকল স্ট্যাটাস</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>পরিশোধিত (Paid)</option>
                        <option value="due" {{ request('status') == 'due' ? 'selected' : '' }}>বকেয়া (Due)</option>
                    </select>

                    <select name="fee_type" class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        <option value="">সকল ফির ধরণ</option>
                        <option value="monthly" {{ request('fee_type') == 'monthly' ? 'selected' : '' }}>মাসিক ফি</option>
                        <option value="admission" {{ request('fee_type') == 'admission' ? 'selected' : '' }}>ভর্তি ফি</option>
                        <option value="jersey" {{ request('fee_type') == 'jersey' ? 'selected' : '' }}>জার্সি / কিট চার্জ</option>
                        <option value="tournament" {{ request('fee_type') == 'tournament' ? 'selected' : '' }}>টুর্নামেন্ট ফি</option>
                    </select>

                    <div class="flex gap-2">
                        <button type="submit" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition">
                            ফিল্টার
                        </button>
                        @if(request()->hasAny(['search', 'status', 'fee_type']))
                            <a href="{{ route('payments.index') }}" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-sm flex items-center justify-center">
                                রিসেট
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500">
                            <tr>
                                <th class="px-5 py-3.5">রসিদ নং</th>
                                <th class="px-5 py-3.5">ট্রেইনি বিবরণ</th>
                                <th class="px-5 py-3.5">ফির শিরোনাম ও ধরণ</th>
                                <th class="px-5 py-3.5">মাস ও বছর</th>
                                <th class="px-5 py-3.5">পরিমাণ</th>
                                <th class="px-5 py-3.5">পদ্ধতি</th>
                                <th class="px-5 py-3.5">স্ট্যাটাস</th>
                                <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($payments as $pay)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-750 transition">
                                    <td class="px-5 py-4 font-mono font-bold text-gray-900 dark:text-white">
                                        {{ $pay->invoice_no }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $pay->trainee->name ?? 'অজানা' }}</div>
                                        <div class="text-xs text-gray-400 font-mono">{{ $pay->trainee->admission_no ?? '-' }} • {{ $pay->trainee->phone ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-medium text-gray-800 dark:text-gray-200">{{ $pay->title }}</div>
                                        <span class="text-xs px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                            {{ $pay->fee_type }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 font-medium">{{ $pay->month ?? '-' }} {{ $pay->year }}</td>
                                    <td class="px-5 py-4 font-black text-gray-900 dark:text-white">
                                        ৳{{ number_format($pay->amount) }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="uppercase text-xs font-semibold px-2 py-0.5 bg-slate-100 dark:bg-slate-700 rounded">
                                            {{ $pay->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $pay->status == 'paid' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                                            {{ $pay->status == 'paid' ? 'পরিশোধিত' : 'বকেয়া' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right space-x-2">
                                        <a href="{{ route('payments.show', $pay) }}" class="text-emerald-600 dark:text-emerald-400 font-semibold hover:underline">রসিদ &rarr;</a>
                                        @if($pay->status == 'due')
                                            <form method="POST" action="{{ route('payments.mark-paid', $pay) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-xs font-bold text-teal-600 hover:underline">পরিশোধ মার্ক</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-gray-500">কোনো পেমেন্ট তথ্য পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


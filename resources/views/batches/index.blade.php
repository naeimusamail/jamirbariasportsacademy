<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>📋</span> {{ __('ট্রেনিং ব্যাচ ও শিডিউল (Batches)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">একাডেমির সকল খেলার অনুশীলন সেশন, সময়সূচি ও দায়িত্বপ্রাপ্ত কোচ</p>
            </div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('batches.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow">
                    + নতুন ব্যাচ তৈরি করুন (Admin)
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 text-xs font-bold border border-amber-500/20">
                    <span>🛡️</span> অ্যাডমিন নির্ধারিত শিডিউল ভিউ
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-emerald-950/20 border border-emerald-500/30 rounded-2xl flex items-start gap-3">
                <span class="text-xl">🛡️</span>
                <div class="text-xs space-y-0.5">
                    <strong class="text-emerald-700 dark:text-emerald-300 font-bold block">অ্যাডমিন কেন্দ্রীয় নিয়ন্ত্রণ নীতি:</strong>
                    <p class="text-gray-600 dark:text-gray-400">সকল খেলার ট্রেনিং ব্যাচ তৈরি, শিডিউল নির্ধারণ এবং কোন ব্যাচে কোন কোচ প্রশিক্ষণ দিবেন তা সম্পূর্ণভাবে একাডেমি অ্যাডমিন নির্ধারণ করেন। কোচগণ তাদের নির্ধারিত ব্যাচের প্লেয়ারদের হাজিরা, ড্রিল ও পারফরম্যান্স তদারকি করবেন।</p>
                </div>
            </div>

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($batches as $batch)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:border-emerald-500/50 transition">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl">{{ $batch->sport->icon ?? '⚽' }}</span>
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $batch->status == 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $batch->status == 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                </span>
                            </div>

                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mt-3">
                                {{ $batch->name }}
                            </h3>
                            <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">{{ $batch->sport->name ?? '-' }}</p>

                            <div class="mt-4 space-y-2 text-xs text-gray-600 dark:text-gray-300">
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <span class="text-gray-400">বার / দিন:</span>
                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $batch->days }}</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <span class="text-gray-400">সময়সূচি:</span>
                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $batch->time_slot }}</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <span class="text-gray-400">মাঠ / ভেন্যু:</span>
                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $batch->ground }}</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <span class="text-gray-400">ট্রেইনার / কোচ:</span>
                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $batch->coach->name ?? 'কোচ নির্ধারিত নেই' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500">
                                প্লেয়ার: <strong class="text-gray-900 dark:text-white">{{ $batch->trainees_count }}</strong> / {{ $batch->capacity }} জন
                            </span>
                            <div class="space-x-2">
                                <a href="{{ route('batches.show', $batch) }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">বিস্তারিত &rarr;</a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('batches.edit', $batch) }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">এডিট (Admin)</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-500 bg-white dark:bg-gray-800 rounded-2xl">
                        কোনো ট্রেনিং ব্যাচ তৈরি করা হয়নি।
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $batches->links() }}
            </div>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                    {{ __('কোচ ও ট্রেইনার প্যানেল (Coaches)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">একাডেমির অভিজ্ঞ প্রশিক্ষক ও টেকনিক্যাল স্টাফ</p>
            </div>
            <a href="{{ route('coaches.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow">
                + নতুন কোচ যুক্ত করুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($coaches as $coach)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl">{{ $coach->sport->icon ?? '🧢' }}</span>
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $coach->status == 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $coach->status == 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                </span>
                            </div>

                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mt-3">
                                {{ $coach->name }}
                            </h3>
                            <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">{{ $coach->designation }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $coach->sport->name ?? '-' }}</div>

                            <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-xs space-y-1.5 text-gray-600 dark:text-gray-300">
                                <div><strong>অভিজ্ঞতা:</strong> {{ $coach->experience ?? 'তথ্য নেই' }}</div>
                                <div><strong>ফোন:</strong> {{ $coach->phone }}</div>
                                <div><strong>ইমেইল:</strong> {{ $coach->email ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                দায়িত্বে: <strong class="text-gray-900 dark:text-white">{{ $coach->batches->count() }}টি ব্যাচ</strong>
                            </span>
                            <a href="{{ route('coaches.edit', $coach) }}" class="text-xs font-semibold text-blue-600 hover:underline">
                                এডিট তথ্য &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-500 bg-white dark:bg-gray-800 rounded-2xl">
                        কোনো কোচের তথ্য যোগ করা হয়নি।
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                    {{ $batch->name }}
                </h2>
                <p class="text-xs text-gray-500">{{ $batch->sport->name ?? '-' }} • মাঠ: {{ $batch->ground }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('attendances.index', ['batch_id' => $batch->id]) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow">
                    হাজিরা নিন 📋
                </a>
                <a href="{{ route('batches.index') }}" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-sm">
                    &larr; সব ব্যাচ
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-xs text-gray-400">বার / দিন</span>
                    <div class="font-bold text-gray-900 dark:text-white mt-1">{{ $batch->days }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-xs text-gray-400">সময়সূচি</span>
                    <div class="font-bold text-gray-900 dark:text-white mt-1">{{ $batch->time_slot }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-xs text-gray-400">দায়িত্বপ্রাপ্ত কোচ</span>
                    <div class="font-bold text-gray-900 dark:text-white mt-1">{{ $batch->coach->name ?? 'অ্যাসাইন নেই' }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="text-xs text-gray-400">নিবন্ধিত প্লেয়ার</span>
                    <div class="font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $batch->trainees->count() }} / {{ $batch->capacity }} জন</div>
                </div>
            </div>

            <!-- Trainees in this batch -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">ব্যাচের অন্তর্ভুক্ত প্লেয়ারবৃন্দ</h3>
                    <a href="{{ route('trainees.create') }}" class="text-xs font-semibold text-emerald-600 hover:underline">+ নতুন ভর্তি</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-500">
                            <tr>
                                <th class="px-4 py-3">ভর্তি নং</th>
                                <th class="px-4 py-3">নাম</th>
                                <th class="px-4 py-3">ক্যাটাগরি ও পজিশন</th>
                                <th class="px-4 py-3">জার্সি #</th>
                                <th class="px-4 py-3">ফোন নম্বর</th>
                                <th class="px-4 py-3 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($batch->trainees as $tr)
                                <tr>
                                    <td class="px-4 py-3 font-mono font-bold text-emerald-600">{{ $tr->admission_no }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $tr->name }}</td>
                                    <td class="px-4 py-3">{{ $tr->category }} ({{ $tr->position ?? '-' }})</td>
                                    <td class="px-4 py-3 font-mono">#{{ $tr->jersey_no ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $tr->phone }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('trainees.show', $tr) }}" class="text-emerald-600 hover:underline font-semibold">প্রোফাইল &rarr;</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-500">এই ব্যাচে এখনো কোনো প্লেয়ার নেই।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                    {{ __('ডিজিটাল দৈনিক হাজিরা (Daily Attendance)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">তারিখ ও ব্যাচ ভিত্তিক দ্রুত হাজিরা গ্রহণ</p>
            </div>
            @if($selectedBatch)
                <button type="button" onclick="markAllPresent()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow">
                    ✓ সবাইকে উপস্থিত করুন (All Present)
                </button>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Batch and Date Selector -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">ব্যাচ নির্বাচন করুন</label>
                        <select name="batch_id" onchange="this.form.submit()" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            @foreach($batches as $b)
                                <option value="{{ $b->id }}" {{ $selectedBatchId == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }} ({{ $b->time_slot }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">হাজিরার তারিখ</label>
                        <input type="date" name="date" value="{{ $selectedDate }}" onchange="this.form.submit()" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2.5 bg-gray-900 dark:bg-gray-700 hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition">
                            লোড করুন
                        </button>
                    </div>
                </form>
            </div>

            <!-- Attendance Form -->
            @if($selectedBatch)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 dark:border-gray-700 pb-4 mb-6 gap-2">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">
                                {{ $selectedBatch->name }}
                            </h3>
                            <p class="text-xs text-gray-400">কোচ: {{ $selectedBatch->coach->name ?? 'N/A' }} • সময়: {{ $selectedBatch->time_slot }} • তারিখ: {{ $selectedDate }}</p>
                        </div>
                        <div class="text-xs text-gray-500">
                            মোট ট্রেইনি: <strong class="text-emerald-600">{{ $trainees->count() }}</strong> জন
                        </div>
                    </div>

                    @if($trainees->count() > 0)
                        <form method="POST" action="{{ route('attendances.store') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="batch_id" value="{{ $selectedBatchId }}">
                            <input type="hidden" name="date" value="{{ $selectedDate }}">

                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($trainees as $tr)
                                    @php
                                        $currentStatus = $attendances[$tr->id]->status ?? 'present';
                                        $currentNote = $attendances[$tr->id]->note ?? '';
                                    @endphp
                                    <div class="py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center font-bold text-sm text-gray-700 dark:text-gray-200">
                                                #{{ $tr->jersey_no ?? $loop->iteration }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $tr->name }}</div>
                                                <div class="text-xs text-gray-400 font-mono">{{ $tr->admission_no }} • {{ $tr->category }}</div>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-3">
                                            <!-- Present -->
                                            <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 dark:border-gray-700 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-950 has-[:checked]:border-emerald-500 text-xs font-semibold">
                                                <input type="radio" name="attendance[{{ $tr->id }}]" value="present" {{ $currentStatus == 'present' ? 'checked' : '' }} class="status-present text-emerald-600 focus:ring-emerald-500">
                                                <span class="text-emerald-700 dark:text-emerald-400">উপস্থিত</span>
                                            </label>

                                            <!-- Late -->
                                            <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 dark:border-gray-700 has-[:checked]:bg-amber-50 dark:has-[:checked]:bg-amber-950 has-[:checked]:border-amber-500 text-xs font-semibold">
                                                <input type="radio" name="attendance[{{ $tr->id }}]" value="late" {{ $currentStatus == 'late' ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500">
                                                <span class="text-amber-700 dark:text-amber-400">দেরি</span>
                                            </label>

                                            <!-- Absent -->
                                            <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 dark:border-gray-700 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-950 has-[:checked]:border-rose-500 text-xs font-semibold">
                                                <input type="radio" name="attendance[{{ $tr->id }}]" value="absent" {{ $currentStatus == 'absent' ? 'checked' : '' }} class="text-rose-600 focus:ring-rose-500">
                                                <span class="text-rose-700 dark:text-rose-400">অনুপস্থিত</span>
                                            </label>

                                            <!-- Note -->
                                            <input type="text" name="notes[{{ $tr->id }}]" value="{{ $currentNote }}" placeholder="মন্তব্য (ছুটি/অসুস্থ)" class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-xs py-1.5 px-3 w-36">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                                <button type="submit" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow-md shadow-emerald-600/20 transition">
                                    হাজিরা সংরক্ষণ করুন ✓
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-10 text-gray-500">
                            এই ব্যাচে কোনো সক্রিয় ট্রেইনি ভর্তি নেই। <a href="{{ route('trainees.create') }}" class="text-emerald-600 font-semibold underline">নতুন ভর্তি করুন</a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        function markAllPresent() {
            document.querySelectorAll('.status-present').forEach(radio => {
                radio.checked = true;
            });
        }
    </script>
</x-app-layout>


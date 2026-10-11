<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                {{ __('নতুন ফি গ্রহণ ও রসিদ তৈরি') }}
            </h2>
            <a href="{{ route('payments.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                &larr; পেমেন্ট তালিকায় ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="POST" action="{{ route('payments.store') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">রসিদ নম্বর (Invoice No.) *</label>
                            <input type="text" name="invoice_no" value="{{ old('invoice_no', $defaultInvoiceNo) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-mono">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">প্লেয়ার *</label>
                            <select name="trainee_id" id="trainee_select" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="">প্লেয়ার নির্বাচন করুন</option>
                                @foreach($trainees as $tr)
                                    <option value="{{ $tr->id }}" data-fee="{{ $tr->monthly_fee }}" {{ (old('trainee_id') == $tr->id || $selectedTraineeId == $tr->id) ? 'selected' : '' }}>
                                        {{ $tr->name }} ({{ $tr->admission_no }} - ৳{{ $tr->monthly_fee }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ফির শিরোনাম *</label>
                        <input type="text" name="title" id="fee_title" value="{{ old('title', 'চলতি মাসের প্রশিক্ষণ ফি') }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ফির ধরণ *</label>
                            <select name="fee_type" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="monthly" {{ old('fee_type') == 'monthly' ? 'selected' : '' }}>মাসিক প্রশিক্ষণ ফি</option>
                                <option value="admission" {{ old('fee_type') == 'admission' ? 'selected' : '' }}>নতুন ভর্তি ফি</option>
                                <option value="jersey" {{ old('fee_type') == 'jersey' ? 'selected' : '' }}>জার্সি ও কিট চার্জ</option>
                                <option value="tournament" {{ old('fee_type') == 'tournament' ? 'selected' : '' }}>টুর্নামেন্ট রেজিস্ট্রেশন</option>
                                <option value="other" {{ old('fee_type') == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ফির মাস</label>
                            <select name="month" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                @foreach(['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'] as $m)
                                    <option value="{{ $m }}" {{ old('month', 'অক্টোবর') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">বছর *</label>
                            <input type="text" name="year" value="{{ old('year', '2026') }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">টাকার পরিমাণ (BDT) *</label>
                            <input type="number" step="10" name="amount" id="fee_amount" value="{{ old('amount', 1000) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-bold">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">পেমেন্ট মাধ্যম *</label>
                            <select name="payment_method" id="payment_method_select" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>💵 নগদ ক্যাশ (Cash)</option>
                                <option value="bkash" {{ old('payment_method') == 'bkash' ? 'selected' : '' }}>📱 বিকাশ (bKash)</option>
                                <option value="nagad" {{ old('payment_method') == 'nagad' ? 'selected' : '' }}>📱 নগদ (Nagad)</option>
                                <option value="rocket" {{ old('payment_method') == 'rocket' ? 'selected' : '' }}>📱 রকেট (Rocket)</option>
                                <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>🏦 ব্যাংক ট্রান্সফার / চেক (Bank)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">পেমেন্ট স্ট্যাটাস *</label>
                            <select name="status" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>পরিশোধিত (Paid)</option>
                                <option value="due" {{ old('status') == 'due' ? 'selected' : '' }}>বকেয়া (Due)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Manual Payment Tracking Details -->
                    <div id="manual-trx-details" class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 space-y-4">
                        <div class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-1.5">
                            <span>🧾</span> ট্রানজেকশন ও ভাউচার বিবরণ
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1" id="label-trx-id">
                                    ট্রানজেকশন আইডি (TrxID) / চেক নং / রেফারেন্স
                                </label>
                                <input type="text" name="transaction_id" value="{{ old('transaction_id') }}" placeholder="যেমন: TRX9284752 / CHQ-104" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-mono uppercase">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1" id="label-sender-no">
                                    প্রেরকের মোবাইল / ব্যাংক হিসাব নম্বর
                                </label>
                                <input type="text" name="sender_number" value="{{ old('sender_number') }}" placeholder="যেমন: 01712345678 বা হিসাব নং" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-mono">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                গ্রহণকারী কর্মকর্তা / ক্যাশিয়ারের নাম (Received By)
                            </label>
                            <input type="text" name="received_by" value="{{ old('received_by', auth()->user()->name ?? 'অফিস ক্যাশিয়ার') }}" placeholder="দায়িত্বপ্রাপ্ত কর্মকর্তার নাম" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">পেমেন্টের তারিখ *</label>
                            <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">মন্তব্য (ঐচ্ছিক)</label>
                            <input type="text" name="note" value="{{ old('note') }}" placeholder="অতিরিক্ত কোনো তথ্য বা নোট" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('payments.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-semibold">
                            বাতিল
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow">
                            রসিদ তৈরি ও সংরক্ষণ করুন &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>💸</span> {{ __('নতুন একাডেমি খরচ ভাউচার এন্ট্রি') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    সরঞ্জাম ক্রয়, মাঠ মেরামত, স্টাফ বেতন বা অন্যান্য বিলের ভাউচার তৈরি করুন
                </p>
            </div>
            <a href="{{ route('expenses.index') }}" class="px-3.5 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold">
                ← তালিকায় ফিরুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-600 rounded-xl text-xs">
                    <div class="font-bold mb-1">ত্রুটি সংশোধন করুন:</div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <form action="{{ route('expenses.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">ভাউচার নম্বর (Voucher No.) <span class="text-rose-500">*</span></label>
                            <input type="text" name="voucher_no" value="{{ old('voucher_no', $defaultVoucherNo) }}" required class="w-full text-xs font-mono font-bold rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">খরচের তারিখ <span class="text-rose-500">*</span></label>
                            <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">খরচের শিরোনাম / উদ্দেশ্য <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="উদা: ৫টি নতুন ফুটবল ও মার্কার কোণ ক্রয়" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">টুর্নামেন্ট বা ইভেন্ট (ঐচ্ছিক)</label>
                            <select name="tournament_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                                <option value="">-- সাধারণ একাডেমি খরচ --</option>
                                @foreach($tournaments as $t)
                                    <option value="{{ $t->id }}" {{ old('tournament_id') == $t->id ? 'selected' : '' }}>🏆 {{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">যুক্ত ভলান্টিয়ার (ঐচ্ছিক)</label>
                            <select name="volunteer_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                                <option value="">-- কোনো নির্দিষ্ট ভলান্টিয়ার নেই --</option>
                                @foreach($volunteers as $v)
                                    <option value="{{ $v->id }}" {{ old('volunteer_id') == $v->id ? 'selected' : '' }}>🤝 {{ $v->name }} ({{ $v->volunteer_no }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">খরচের খাত (Category) <span class="text-rose-500">*</span></label>
                            <select name="category" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                                <option value="">খাত নির্বাচন করুন...</option>
                                @foreach($categories as $key => $name)
                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">সরঞ্জাম / আইটেমের নাম (ঐচ্ছিক)</label>
                            <input type="text" name="item_name" value="{{ old('item_name') }}" placeholder="উদা: ক্রিকেট বল (লাল সিমি), ব্যাট, জার্সি, হুইসেল" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                        </div>
                    </div>

                    <!-- Itemized Calculation -->
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 space-y-3">
                        <div class="text-[11px] font-bold text-gray-600 dark:text-gray-400 flex items-center justify-between">
                            <span>🔢 সরঞ্জাম সংখ্যা ও দর হিসাব (ঐচ্ছিক হিসাবকারী)</span>
                            <span class="text-[10px] text-gray-400 font-normal">একক দর × পরিমাণ = মোট টাকা</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">একক দর (প্রতিটির মূল্য)</label>
                                <input type="number" step="0.5" id="unit_price" name="unit_price" value="{{ old('unit_price') }}" placeholder="৳ দর" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">সংখ্যা / পরিমাণ (পিস)</label>
                                <input type="number" step="1" id="quantity" name="quantity" value="{{ old('quantity') }}" placeholder="সংখ্যা" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-rose-600 dark:text-rose-400 mb-1">মোট খরচ (Amount in BDT) <span class="text-rose-500">*</span></label>
                                <input type="number" step="1" id="amount" name="amount" value="{{ old('amount') }}" placeholder="মোট টাকা..." required min="1" class="w-full text-xs font-bold rounded-xl border-rose-300 dark:border-rose-700 bg-white dark:bg-gray-900 text-rose-600 dark:text-rose-400 focus:ring-rose-500">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">পেমেন্ট মাধ্যম (Payment Method) <span class="text-rose-500">*</span></label>
                            <select name="payment_method" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>নগদ (Cash)</option>
                                <option value="bkash" {{ old('payment_method') == 'bkash' ? 'selected' : '' }}>বিকাশ (bKash)</option>
                                <option value="nagad" {{ old('payment_method') == 'nagad' ? 'selected' : '' }}>নগদ (Nagad)</option>
                                <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>ব্যাংক ট্রান্সফার</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">প্রাপক / সরবরাহকারী (Paid To)</label>
                            <input type="text" name="paid_to" value="{{ old('paid_to') }}" placeholder="উদা: অলিম্পিক স্পোর্টস / কোচ শফিক" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">অতিরিক্ত নোট / মেমো নম্বর (ঐচ্ছিক)</label>
                        <textarea name="note" rows="2" placeholder="দোকানের ক্যাশ মেমো নং বা ব্যয়ের বিস্তারিত তথ্য..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500">{{ old('note') }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
                        <a href="{{ route('expenses.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold">
                            বাতিল
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md transition">
                            ভাউচার সংরক্ষণ করুন &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unitPrice = document.getElementById('unit_price');
            const qty = document.getElementById('quantity');
            const amount = document.getElementById('amount');

            function calc() {
                const u = parseFloat(unitPrice.value) || 0;
                const q = parseFloat(qty.value) || 0;
                if (u > 0 && q > 0) {
                    amount.value = Math.round(u * q);
                }
            }

            if (unitPrice && qty) {
                unitPrice.addEventListener('input', calc);
                qty.addEventListener('input', calc);
            }
        });
    </script>
</x-app-layout>


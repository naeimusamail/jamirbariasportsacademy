<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                {{ __('মানি রসিদ (Official Money Receipt)') }}
            </h2>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow">
                    🖨️ প্রিন্ট করুন (Print Receipt)
                </button>
                <a href="{{ route('payments.index') }}" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-sm">
                    &larr; পেমেন্ট তালিকা
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Printable Voucher -->
            <div class="bg-white text-gray-800 p-8 sm:p-10 rounded-2xl shadow-lg border border-gray-200 print:border-none print:shadow-none print:p-0">
                <!-- Header -->
                <div class="border-b-2 border-emerald-600 pb-6 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <span class="text-3xl">⚽</span>
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">জামিরবাড়িয়া স্পোর্টস একাডেমি</h1>
                    </div>
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-1">Jamirbaria Sports Academy • Mymensingh, Bangladesh</p>
                    <p class="text-[11px] text-gray-500 mt-0.5">হেল্পলাইন: +৮৮০ ১৭১২-৩৪৫৬৭৮ • ইমেইল: accounts@jamirbariasports.com</p>
                    <div class="inline-block mt-3 px-4 py-1 bg-emerald-100 text-emerald-900 font-extrabold text-xs rounded-full uppercase tracking-wider">
                        টাকা জমার অফিসিয়াল রসিদ (MONEY RECEIPT)
                    </div>
                </div>

                <!-- Meta Info -->
                <div class="grid grid-cols-2 gap-4 py-6 text-sm border-b border-gray-200">
                    <div>
                        <div class="text-xs text-gray-400 uppercase font-semibold">রসিদ নম্বর:</div>
                        <div class="font-mono font-black text-base text-gray-900">{{ $payment->invoice_no }}</div>
                        <div class="text-xs text-gray-400 uppercase font-semibold mt-2">তারিখ:</div>
                        <div class="font-semibold text-gray-800">{{ $payment->payment_date }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-400 uppercase font-semibold">প্লেয়ারের নাম:</div>
                        <div class="font-bold text-base text-gray-900">{{ $payment->trainee->name ?? '-' }}</div>
                        <div class="text-xs text-gray-500">ভর্তি নং: <span class="font-mono font-bold">{{ $payment->trainee->admission_no ?? '-' }}</span></div>
                        <div class="text-xs text-gray-500">খেলা: {{ $payment->trainee->sport->name ?? '-' }} ({{ $payment->trainee->category ?? '-' }})</div>
                    </div>
                </div>

                <!-- Receipt Table -->
                <div class="py-6 border-b border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                            <tr>
                                <th class="px-4 py-3">ক্রমিক</th>
                                <th class="px-4 py-3">ফির বিবরণ ও খাত</th>
                                <th class="px-4 py-3">মাস / সময়কাল</th>
                                <th class="px-4 py-3 text-right">টাকা (BDT)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-4 py-4 font-bold">০১.</td>
                                <td class="px-4 py-4">
                                    <div class="font-bold text-gray-900 text-base">{{ $payment->title }}</div>
                                    <div class="text-xs text-gray-600 mt-1 space-y-0.5">
                                        <div><span class="font-semibold">খাত:</span> {{ ucfirst($payment->fee_type) }}</div>
                                        <div>
                                            <span class="font-semibold">পেমেন্ট মাধ্যম:</span> 
                                            <span class="font-bold text-emerald-700">
                                                {{ \App\Models\Payment::paymentMethodNames()[$payment->payment_method] ?? strtoupper($payment->payment_method) }}
                                            </span>
                                        </div>
                                        @if($payment->transaction_id)
                                            <div><span class="font-semibold">ট্রানজেকশন আইডি (TrxID):</span> <span class="font-mono font-bold">{{ $payment->transaction_id }}</span></div>
                                        @endif
                                        @if($payment->sender_number)
                                            <div><span class="font-semibold">প্রেরক মোবাইল/হিসাব:</span> <span class="font-mono">{{ $payment->sender_number }}</span></div>
                                        @endif
                                        @if($payment->received_by)
                                            <div><span class="font-semibold">টাকা গ্রহণকারী:</span> {{ $payment->received_by }}</div>
                                        @endif
                                        @if($payment->note)
                                            <div class="text-gray-500 italic"><span class="font-semibold">নোট:</span> {{ $payment->note }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 font-medium">{{ $payment->month ?? '-' }} {{ $payment->year }}</td>
                                <td class="px-4 py-4 font-bold text-right text-base text-gray-900">৳{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-900">
                                <td colspan="3" class="px-4 py-3 font-bold text-right uppercase text-xs">মোট পরিশোধিত টাকা (Total Paid):</td>
                                <td class="px-4 py-3 font-black text-right text-lg text-emerald-700">৳{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Footer Signatures -->
                <div class="pt-12 grid grid-cols-2 gap-8 text-center text-xs">
                    <div>
                        <div class="border-t border-gray-400 pt-2 font-semibold text-gray-600">
                            প্লেয়ার / অভিভাবকের স্বাক্ষর
                        </div>
                    </div>
                    <div>
                        <div class="border-t border-gray-400 pt-2 font-semibold text-gray-900">
                            দায়িত্বপ্রাপ্ত কর্মকর্তা / একাডেমি কতৃপক্ষ
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-100 text-center text-[10px] text-gray-400">
                    কম্পিউটার জেনারেটেড অফিসিয়াল রসিদ • জামিরবাড়িয়া স্পোর্টস একাডেমি • {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


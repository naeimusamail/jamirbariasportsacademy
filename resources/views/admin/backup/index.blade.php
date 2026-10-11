<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>💾</span> {{ __('সিস্টেম ব্যাকআপ ও ডাটাবেজ সেন্টার') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    সম্পূর্ণ ডাটাবেজ স্ন্যাপশট ডাউনলোড এবং সিস্টেম নিরাপত্তা নিয়ন্ত্রণ
                </p>
            </div>
            <div>
                <a href="{{ route('admin.backup.download') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl text-xs shadow-lg hover:shadow-emerald-500/25 transition flex items-center gap-2">
                    <span>⬇️</span> ডাটাবেজ ব্যাকআপ ডাউনলোড (.sql)
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- System Metrics Banner -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-emerald-500/20">
                    <span class="text-[10px] font-bold uppercase text-emerald-600 dark:text-emerald-400 block">ডাটাবেজ টেবিল সংখ্যা</span>
                    <div class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $systemInfo['total_tables'] }} টি</div>
                    <span class="text-[10px] text-gray-400">MySQL স্কিমা</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-teal-500/20">
                    <span class="text-[10px] font-bold uppercase text-teal-600 dark:text-teal-400 block">মোট ডাটা রেকর্ড</span>
                    <div class="text-2xl font-black text-teal-600 dark:text-teal-400 mt-1">{{ number_format($systemInfo['total_rows']) }}</div>
                    <span class="text-[10px] text-gray-400">সিস্টেমের মোট রো সংখ্যা</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-blue-500/20">
                    <span class="text-[10px] font-bold uppercase text-blue-600 dark:text-blue-400 block">PHP ও ফ্রেমওয়ার্ক</span>
                    <div class="text-2xl font-black text-gray-900 dark:text-white mt-1">PHP {{ $systemInfo['php_version'] }}</div>
                    <span class="text-[10px] text-gray-400">Laravel v{{ $systemInfo['laravel_version'] }}</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-purple-500/20">
                    <span class="text-[10px] font-bold uppercase text-purple-600 dark:text-purple-400 block">ডাটাবেজের নাম</span>
                    <div class="text-xl font-mono font-black text-purple-600 dark:text-purple-400 mt-1 truncate" title="{{ $systemInfo['database'] }}">
                        {{ $systemInfo['database'] }}
                    </div>
                    <span class="text-[10px] text-gray-400">{{ $systemInfo['db_connection'] }} সংযোগ</span>
                </div>
            </div>

            <!-- Instant Backup Download Banner -->
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-3xl">
                        🗄️
                    </div>
                    <div>
                        <h3 class="text-lg font-black tracking-tight">এক ক্লিকে সম্পূর্ণ ডাটাবেজ ব্যাকআপ নিন</h3>
                        <p class="text-xs text-slate-300 mt-1 max-w-xl">
                            একাডেমির সকল খেলোয়াড়, ম্যাচ স্কোর, টুর্নামেন্ট হিস্ট্রি, লেনদেন এবং ফি এর একটি পূর্ণাঙ্গ `.sql` ব্যাকআপ ডাউনলোড করে আপনার গুগল ড্রাইভ বা পিসিতে সংরক্ষণ করুন।
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.backup.download') }}" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black rounded-2xl text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/30 transition flex items-center gap-2">
                        <span>📥</span> ডাউনলোড SQL ডাম্প
                    </a>
                </div>
            </div>

            <!-- Database Table Summary Grid -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>📊</span> ডাটাবেজ টেবিল ও রেকর্ড বিবরণী
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">প্রতিটি টেবিলের বর্তমান ডাটা সাইজ ও স্বাস্থ্য</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($tableList as $tbl)
                            <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-2xl border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                                <div class="truncate mr-2">
                                    <span class="font-mono text-xs font-bold text-gray-800 dark:text-gray-200 block truncate">{{ $tbl['name'] }}</span>
                                    <span class="text-[10px] text-gray-400">InnoDB Table</span>
                                </div>
                                <span class="px-2.5 py-1 bg-white dark:bg-gray-800 rounded-xl text-xs font-black text-emerald-600 dark:text-emerald-400 shadow-sm border border-gray-100 dark:border-gray-700">
                                    {{ $tbl['rows'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Backup Restoration Guide -->
            <div class="bg-slate-50 dark:bg-gray-800/60 p-6 rounded-3xl border border-dashed border-gray-300 dark:border-gray-700 text-xs text-gray-600 dark:text-gray-400 space-y-2">
                <h4 class="font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                    <span>💡</span> কিভাবে ব্যাকআপ রিস্টোর করবেন?
                </h4>
                <p>
                    ১. ডাউনলোড করা <strong>jamirbaria_backup_*.sql</strong> ফাইলটি সংরক্ষণ করুন।<br>
                    ২. phpMyAdmin, MySQL Workbench অথবা কমান্ড লাইনে: <code class="bg-gray-200 dark:bg-gray-900 px-1.5 py-0.5 rounded font-mono text-emerald-600">mysql -u root -p database_name &lt; jamirbaria_backup_*.sql</code> রান করলেই সম্পূর্ণ ডাটা মুহূর্তের মধ্যে ফিরে আসবে।
                </p>
            </div>

        </div>
    </div>
</x-app-layout>


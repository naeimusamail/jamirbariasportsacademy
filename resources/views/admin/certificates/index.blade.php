<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <span>📜</span> {{ __('প্লেয়ার সনদপত্র (Certificate) সেন্টার') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    কোর্স সমাপ্তি, টুর্নামেন্ট চ্যাম্পিয়নশিপ ও বিশেষ অর্জনের জন্য কিউআর কোড সম্বলিত অফিসিয়াল সার্টিফিকেট প্রদান করুন
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.certificates.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-600/20 flex items-center gap-1.5 transition">
                    <span>+ নতুন সনদপত্র ইস্যু করুন</span>
                </a>
                <a href="{{ route('admin.id-cards.index') }}" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition">
                    <span>🪪 আইডি কার্ড সেন্টার</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Success Message -->
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-2xl text-xs font-bold flex items-center gap-2">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <span class="text-[10px] font-bold uppercase text-gray-400">মোট সনদপত্র</span>
                    <div class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ \App\Models\Certificate::count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-emerald-500/20 shadow-sm bg-gradient-to-br from-emerald-50/50 to-transparent dark:from-emerald-950/20">
                    <span class="text-[10px] font-bold uppercase text-emerald-600 dark:text-emerald-400">প্রশিক্ষণ সমাপ্তি</span>
                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ \App\Models\Certificate::where('certificate_type', 'completion')->count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-amber-500/20 shadow-sm bg-gradient-to-br from-amber-50/50 to-transparent dark:from-amber-950/20">
                    <span class="text-[10px] font-bold uppercase text-amber-600 dark:text-amber-400">টুর্নামেন্ট ও সম্মাননা</span>
                    <div class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">{{ \App\Models\Certificate::whereIn('certificate_type', ['achievement', 'appreciation'])->count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-blue-500/20 shadow-sm bg-gradient-to-br from-blue-50/50 to-transparent dark:from-blue-950/20">
                    <span class="text-[10px] font-bold uppercase text-blue-600 dark:text-blue-400">অংশগ্রহণ সনদ</span>
                    <div class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1">{{ \App\Models\Certificate::where('certificate_type', 'participation')->count() }}</div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('admin.certificates.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1">প্লেয়ারের নাম / সনদ নং</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম বা JSA-CERT-..." class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1">সনদের ধরন</label>
                        <select name="certificate_type" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                            <option value="">সকল ধরন</option>
                            <option value="completion" {{ request('certificate_type') == 'completion' ? 'selected' : '' }}>প্রশিক্ষণ সমাপ্তি</option>
                            <option value="achievement" {{ request('certificate_type') == 'achievement' ? 'selected' : '' }}>অর্জন / চ্যাম্পিয়নশিপ</option>
                            <option value="appreciation" {{ request('certificate_type') == 'appreciation' ? 'selected' : '' }}>বিশেষ সম্মাননা</option>
                            <option value="participation" {{ request('certificate_type') == 'participation' ? 'selected' : '' }}>অংশগ্রহণ সনদ</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1">খেলা (Sport)</label>
                        <select name="sport_id" class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:ring-emerald-500">
                            <option value="">সকল খেলা</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->id }}" {{ request('sport_id') == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow">
                            ফিল্টার
                        </button>
                        <a href="{{ route('admin.certificates.index') }}" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-bold">
                            রিসেট
                        </a>
                    </div>
                </form>
            </div>

            <!-- Certificates Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="p-4">সনদপত্র নং</th>
                                <th class="p-4">প্লেয়ার প্রোফাইল</th>
                                <th class="p-4">সনদের শিরোনাম ও ধরন</th>
                                <th class="p-4">ইভেন্ট / কোর্স</th>
                                <th class="p-4">র‌্যাঙ্ক / অর্জন</th>
                                <th class="p-4">ইস্যুর তারিখ</th>
                                <th class="p-4 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                            @forelse($certificates as $cert)
                                <tr class="hover:bg-amber-50/40 dark:hover:bg-gray-750 transition">
                                    <td class="p-4 font-mono font-bold text-amber-600 dark:text-amber-400">
                                        {{ $cert->certificate_no }}
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-9 h-9 rounded-xl bg-slate-900 border border-emerald-500/30 overflow-hidden shrink-0 flex items-center justify-center">
                                                @if($cert->trainee->photo)
                                                    <img src="{{ asset('storage/' . $cert->trainee->photo) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    <span class="font-bold text-emerald-400 text-xs">{{ mb_substr($cert->trainee->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('trainees.show', $cert->trainee) }}" class="font-bold text-gray-900 dark:text-white hover:text-emerald-600">
                                                    {{ $cert->trainee->name }}
                                                </a>
                                                <div class="text-[10px] text-gray-400 font-mono">{{ $cert->trainee->admission_no }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $cert->title }}</div>
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold
                                            @if($cert->certificate_type === 'completion') bg-emerald-500/10 text-emerald-600 dark:text-emerald-400
                                            @elseif($cert->certificate_type === 'achievement') bg-amber-500/10 text-amber-600 dark:text-amber-400
                                            @elseif($cert->certificate_type === 'appreciation') bg-purple-500/10 text-purple-600 dark:text-purple-400
                                            @else bg-blue-500/10 text-blue-600 dark:text-blue-400 @endif">
                                            {{ $cert->type_name }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-600 dark:text-gray-300">
                                        {{ $cert->event_or_course ?? 'সাধারণ একাডেমি কোর্স' }}
                                    </td>
                                    <td class="p-4 font-bold text-amber-600 dark:text-amber-400">
                                        {{ $cert->grade_or_rank ?? '-' }}
                                    </td>
                                    <td class="p-4 font-mono text-[11px] text-gray-500">
                                        {{ $cert->issue_date->format('d M, Y') }}
                                    </td>
                                    <td class="p-4 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('admin.certificates.show', $cert) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                            <span>🖨️ দেখুন ও প্রিন্ট</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.certificates.destroy', $cert) }}" class="inline" onsubmit="return confirm('আপনি কি এই সনদপত্রটি মুছে ফেলতে চান?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg transition">
                                                ✕
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-500">
                                        এখনও কোনো সনদপত্র ইস্যু করা হয়নি। উপরে "নতুন সনদপত্র ইস্যু করুন" বাটনে ক্লিক করুন।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($certificates->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $certificates->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>


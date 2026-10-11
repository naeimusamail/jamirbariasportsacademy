<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                    <span>📝</span> {{ __('আবেদন পর্যালোচনা ও সিদ্ধান্ত') }} - {{ $admission->application_no }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    আবেদনকারীর তথ্য যাচাই করুন এবং একাডেমিতে প্লেয়ার হিসেবে গ্রহণ করুন
                </p>
            </div>
            <div>
                <a href="{{ route('admin.admissions.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold transition">
                    ← আবেদনের তালিকায় ফিরে যান
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="p-4 rounded-xl bg-sky-500/10 border border-sky-500/30 text-sky-600 dark:text-sky-400 text-sm font-semibold">
                    ℹ {{ session('info') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-sm font-semibold">
                    ✕ {{ session('error') }}
                </div>
            @endif

            <!-- Applicant Profile Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-6 border-b border-gray-100 dark:border-gray-700 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-24 rounded-2xl bg-gray-100 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 overflow-hidden shrink-0 flex items-center justify-center shadow">
                            @if($admission->photo)
                                <img src="{{ asset('storage/' . $admission->photo) }}" alt="{{ $admission->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl text-gray-400">👤</span>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <h1 class="text-2xl font-black text-gray-900 dark:text-white flex items-baseline gap-2">
                                    <span>{{ $admission->name }}</span>
                                    @if($admission->name_en)
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">({{ $admission->name_en }})</span>
                                    @endif
                                </h1>
                                @if($admission->status === 'approved')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        ✓ অনুমোদিত
                                    </span>
                                @elseif($admission->status === 'rejected')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300">
                                        ✕ বাতিল
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                                        ⏳ অপেক্ষমান
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                আবেদন নং: <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $admission->application_no }}</span> | 
                                তারিখ: {{ $admission->created_at->format('d M, Y (h:i A)') }}
                            </p>
                        </div>
                    </div>

                    @if($admission->trainee_id)
                        <a href="{{ route('trainees.show', $admission->trainee_id) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5 transition">
                            <span>🎓 ট্রেইনি প্রোফাইল দেখুন</span> ➔
                        </a>
                    @endif
                </div>

                <!-- Info Details -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-6 text-xs">
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-400 block">আবেদনকৃত খেলাসমূহ (Multi-Sports):</span>
                            <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                @forelse($admission->applied_sports as $sp)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-500/20">
                                        {{ $sp->icon ?? '⚽' }} {{ $sp->name }}
                                    </span>
                                @empty
                                    <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $admission->sport->name ?? 'N/A' }}</span>
                                @endforelse
                            </div>
                        </div>
                        <div>
                            <span class="text-gray-400 block">বয়স ক্যাটাগরি:</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $admission->category }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">পজিশন / রোল:</span>
                            <span class="text-gray-800 dark:text-gray-200">{{ $admission->position ?? 'সাধারণ' }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-400 block">অভিভাবকের নাম:</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200 text-sm">{{ $admission->guardian_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">মোবাইল নম্বর:</span>
                            <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $admission->phone }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">জরুরি যোগাযোগ:</span>
                            <span class="font-mono text-gray-600 dark:text-gray-400">{{ $admission->emergency_phone ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-400 block">জন্ম তারিখ:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">{{ $admission->date_of_birth ? \Carbon\Carbon::parse($admission->date_of_birth)->format('d M, Y') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">জন্ম নিবন্ধন / এনআইডি:</span>
                            <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $admission->nid_or_birth_cert ?? 'প্রদান করা হয়নি' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">রক্তের গ্রুপ:</span>
                            <span class="font-bold text-rose-500">{{ $admission->blood_group ?? 'অজানা' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">জার্সি নম্বর / সাইজ:</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $admission->jersey_no ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">শিক্ষা প্রতিষ্ঠান / কর্মক্ষেত্র:</span>
                            <span class="text-gray-700 dark:text-gray-300">{{ $admission->organization_or_area ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">বর্তমান ঠিকানা:</span>
                            <span class="text-gray-700 dark:text-gray-300">{{ $admission->address }}</span>
                        </div>
                    </div>
                </div>

                <!-- Manual Payment Information Box -->
                <div class="mt-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-500/20 text-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3 border-b border-emerald-500/10 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-base">💳</span>
                            <span class="font-bold text-gray-900 dark:text-white text-sm">ম্যানুয়াল ভর্তি ফি পেমেন্ট তথ্য</span>
                        </div>
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold
                            {{ $admission->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' }}">
                            পেমেন্ট স্ট্যাটাস: {{ $admission->payment_status === 'paid' ? 'পরিশোধিত (Paid)' : ($admission->payment_method === 'cash' ? 'কাউন্টারে প্রদেয় ক্যাশ' : 'যাচাই অপেক্ষমান') }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 block">পেমেন্ট মাধ্যম:</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                {{ \App\Models\AdmissionApplication::paymentMethodNames()[$admission->payment_method] ?? strtoupper($admission->payment_method) }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 block">টাকার পরিমাণ:</span>
                            <span class="font-bold text-gray-900 dark:text-white font-mono text-sm">
                                ৳{{ number_format($admission->payment_amount, 2) }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 block">ট্রানজেকশন আইডি (TrxID):</span>
                            <span class="font-mono font-bold text-gray-900 dark:text-white">
                                {{ $admission->transaction_id ?? 'প্রযোজ্য নয় / ক্যাশ' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 block">প্রেরকের মোবাইল / হিসাব:</span>
                            <span class="font-mono text-gray-900 dark:text-white">
                                {{ $admission->sender_number ?? 'প্রযোজ্য নয়' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($admission->admin_notes)
                    <div class="mt-6 p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700 text-xs">
                        <strong class="text-gray-500 block mb-1">এডমিন নোট / সিদ্ধান্তের কারণ:</strong>
                        <p class="text-gray-700 dark:text-gray-300">{{ $admission->admin_notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Decision Action Panels (Only if pending or can change) -->
            @if($admission->status === 'pending')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Approve Form (2 Columns) -->
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-500/30 dark:border-emerald-500/20">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xl">✅</span>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">আবেদন অনুমোদন ও ব্যাচ বরাদ্দ করুন</h3>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">
                            অনুমোদন নিশ্চিত করলে প্লেয়ার তালিকায় নতুন ট্রেইনি তৈরি হবে এবং অটোমেটিক আইডি নম্বর জেনারেট হবে।
                        </p>

                        <form action="{{ route('admin.admissions.approve', $admission) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">ব্যাচ নির্ধারণ করুন <span class="text-rose-500">*</span></label>
                                <select name="batch_id" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-emerald-500">
                                    <option value="">ব্যাচ নির্বাচন করুন...</option>
                                    @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->name }} ({{ $batch->schedule_days }} - {{ $batch->start_time }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">মাসিক ফি (টাকা) <span class="text-rose-500">*</span></label>
                                    <input type="number" name="monthly_fee" value="1000" required min="0" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">ভর্তির তারিখ <span class="text-rose-500">*</span></label>
                                    <input type="date" name="admission_date" value="{{ date('Y-m-d') }}" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-emerald-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">এডমিন নোট / মন্তব্য (ঐচ্ছিক)</label>
                                <textarea name="admin_notes" rows="2" placeholder="ভর্তি সংক্রান্ত কোনো বিশেষ তথ্য..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-emerald-500"></textarea>
                            </div>

                            <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs shadow-md transition flex items-center justify-center gap-2">
                                <span>অনুমোদন করুন ও ট্রেইনি হিসেবে যুক্ত করুন</span>
                                <span>✓</span>
                            </button>
                        </form>
                    </div>

                    <!-- Reject Form (1 Column) -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm border border-rose-500/30 dark:border-rose-500/20">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xl">🚫</span>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">আবেদন বাতিল করুন</h3>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">
                            যদি আসন খালি না থাকে অথবা শর্তাবলী অপূর্ণ থাকে, বাতিল করার কারণ উল্লেখ করুন।
                        </p>

                        <form action="{{ route('admin.admissions.reject', $admission) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">বাতিলের কারণ <span class="text-rose-500">*</span></label>
                                <textarea name="admin_notes" rows="4" required placeholder="উদা: বয়সসীমা অতিক্রম করেছে অথবা বর্তমান ব্যাচে আসন পূর্ণ..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-rose-500"></textarea>
                            </div>

                            <button type="submit" onclick="return confirm('আপনি কি নিশ্চিত যে এই আবেদনটি বাতিল করতে চান?')" class="w-full py-3 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-xs shadow-md transition">
                                আবেদন বাতিল করুন ✕
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>


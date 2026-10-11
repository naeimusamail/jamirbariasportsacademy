<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-xs border border-emerald-500/20 flex items-center gap-1.5">
                        <span>🏃</span> ট্রেনিং ড্রিল ও প্লেয়ার টাস্ক হাব
                    </span>
                    <span class="text-xs text-slate-400">মোট ড্রিল: <strong class="text-white">{{ $totalCount }}টি</strong></span>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 mt-1 flex items-center gap-2">
                    <span>📋</span> {{ __('প্লেয়ার ট্রেনিং ড্রিল, হোমওয়ার্ক ও মূল্যায়ন কেন্দ্র') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    কোচ কর্তৃক খেলোয়াড় ও ব্যাচভিত্তিক বিশেষায়িত স্কিল ড্রিল নির্ধারণ, প্লেয়ারদের সমাপ্তি রিপোর্ট এবং স্কোরিং সিস্টেম
                </p>
            </div>
            <div class="flex items-center gap-2">
                @if(Auth::user()->isCoach() || Auth::user()->isAdmin())
                    <button @click="$dispatch('open-create-task-modal')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-black rounded-xl text-xs shadow-lg shadow-emerald-600/20 flex items-center gap-1.5 transition">
                        <span>+ নতুন ড্রিল / টাস্ক দিন</span>
                    </button>
                @endif
                <a href="{{ route('dashboard') }}" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-bold transition">
                    &larr; ড্যাশবোর্ড
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{
        showCreateModal: false,
        showCompleteModal: false,
        showReviewModal: false,
        activeTaskId: null,
        activeTaskTitle: '',
        activePlayerNote: '',
        templates: {{ json_encode($drillTemplates) }},
        selectedTemplate: '',
        applyTemplate() {
            if (!this.selectedTemplate) return;
            const t = this.templates.find(item => item.title === this.selectedTemplate);
            if (t) {
                document.getElementById('task_title').value = t.title;
                document.getElementById('task_sport').value = t.sport_type;
                document.getElementById('task_category').value = t.drill_category;
                document.getElementById('task_priority').value = t.priority;
                document.getElementById('task_desc').value = t.description;
            }
        }
    }" @open-create-task-modal.window="showCreateModal = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-2xl text-xs font-bold flex items-center gap-2">
                    <span class="text-base">✓</span> {{ session('success') }}
                </div>
            @endif

            <!-- Role Context & Status Counters Banner -->
            <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-indigo-950 text-white rounded-3xl p-6 border border-slate-800 shadow-xl space-y-4">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-wider border border-emerald-500/30">
                            @if(Auth::user()->isPlayer()) ⚽ প্লেয়ার অ্যাথলেট প্যানেল @elseif(Auth::user()->isCoach()) 📋 কোচ ট্রেনিং কমান্ড সেন্টার @else 🛡️ একাডেমি এডমিন সুপারভিশন @endif
                        </div>
                        <h3 class="text-lg sm:text-xl font-black text-white">
                            @if(Auth::user()->isPlayer())
                                আপনার প্রশিক্ষকের দেওয়া ট্রেনিং ড্রিলসমূহ সময়মতো সম্পন্ন করুন ও ফলাফল জানান
                            @else
                                খেলোয়াড়দের দৈনন্দিন স্কিল, টেকনিক্যাল ড্রিল ও ফিটনেস কার্যক্ষমতা মূল্যায়ন করুন
                            @endif
                        </h3>
                        <p class="text-xs text-slate-400">
                            প্রতিটি ড্রিল সমাপ্তির পর কোচিং ফিডব্যাক ও ১০ ভিত্তিক পারফরম্যান্স স্কোরিং প্রদান করা হয়।
                        </p>
                    </div>

                    <!-- Status Filter Tabs -->
                    <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
                        <a href="{{ route('tasks.index') }}" class="px-3.5 py-1.5 rounded-xl transition {{ !request('status') ? 'bg-emerald-500 text-slate-950 shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                            সবগুলো ({{ $totalCount }})
                        </a>
                        <a href="{{ route('tasks.index', array_merge(request()->query(), ['status' => 'pending'])) }}" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ request('status') === 'pending' ? 'bg-amber-500 text-slate-950 shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                            <span>⏳</span> চলমান ({{ $pendingCount }})
                        </a>
                        <a href="{{ route('tasks.index', array_merge(request()->query(), ['status' => 'completed'])) }}" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ request('status') === 'completed' ? 'bg-cyan-500 text-slate-950 shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                            <span>🚀</span> সম্পন্ন / রিভিউ বাকি ({{ $completedCount }})
                        </a>
                        <a href="{{ route('tasks.index', array_merge(request()->query(), ['status' => 'reviewed'])) }}" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ request('status') === 'reviewed' ? 'bg-emerald-500 text-slate-950 shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                            <span>★</span> মূল্যায়িত ({{ $reviewedCount }})
                        </a>
                    </div>
                </div>

                <!-- Category Sub-Filters -->
                <div class="pt-3 border-t border-slate-800/80 flex flex-wrap items-center gap-2 text-xs">
                    <span class="text-slate-400 text-[11px] font-bold">ক্যাটাগরি ফিল্টার:</span>
                    <a href="{{ route('tasks.index', array_filter(array_merge(request()->query(), ['drill_category' => null]))) }}" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ !request('drill_category') ? 'bg-slate-700 text-white' : 'bg-slate-850 text-slate-400 hover:text-white' }}">
                        সকল ক্যাটাগরি
                    </a>
                    <a href="{{ route('tasks.index', array_merge(request()->query(), ['drill_category' => 'fitness'])) }}" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ request('drill_category') === 'fitness' ? 'bg-indigo-600 text-white' : 'bg-slate-850 text-slate-400 hover:text-white' }}">
                        ⚡ ফিটনেস ও স্ট্যামিনা
                    </a>
                    <a href="{{ route('tasks.index', array_merge(request()->query(), ['drill_category' => 'technical'])) }}" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ request('drill_category') === 'technical' ? 'bg-emerald-600 text-white' : 'bg-slate-850 text-slate-400 hover:text-white' }}">
                        🎯 টেকনিক্যাল স্কিল
                    </a>
                    <a href="{{ route('tasks.index', array_merge(request()->query(), ['drill_category' => 'tactical'])) }}" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ request('drill_category') === 'tactical' ? 'bg-amber-600 text-white' : 'bg-slate-850 text-slate-400 hover:text-white' }}">
                        🧠 কৌশলগত (Tactical)
                    </a>
                    <a href="{{ route('tasks.index', array_merge(request()->query(), ['drill_category' => 'recovery'])) }}" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ request('drill_category') === 'recovery' ? 'bg-cyan-600 text-white' : 'bg-slate-850 text-slate-400 hover:text-white' }}">
                        🧘 রিকভারি ও মোবেলিটি
                    </a>
                </div>
            </div>

            <!-- Task List Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($tasks as $task)
                    <div class="bg-slate-900 rounded-3xl p-6 shadow-xl border border-slate-800 hover:border-emerald-500/40 transition duration-300 flex flex-col justify-between space-y-4">
                        <div>
                            <!-- Header tags -->
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider
                                    @if($task->drill_category === 'fitness') bg-indigo-500/20 text-indigo-400 border border-indigo-500/30
                                    @elseif($task->drill_category === 'tactical') bg-amber-500/20 text-amber-400 border border-amber-500/30
                                    @elseif($task->drill_category === 'technical') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                                    @else bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 @endif">
                                    {{ $task->category_icon }} {{ $task->category_name }}
                                </span>

                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ $task->status_badge_class }}">
                                    @if($task->status === 'reviewed')
                                        ✓ স্কোর: {{ $task->coach_score }}/১০ ★
                                    @elseif($task->status === 'completed')
                                        🚀 সম্পন্ন (রিভিউ বাকি)
                                    @else
                                        ⏳ চলমান
                                    @endif
                                </span>
                            </div>

                            <!-- Sport & Priority -->
                            <div class="flex items-center justify-between text-[11px] mb-2">
                                <span class="text-slate-400 font-semibold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    খেলা: <strong class="text-slate-200">{{ $task->sport_type }}</strong>
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $task->priority_badge_class }}">
                                    {{ $task->priority_label }}
                                </span>
                            </div>

                            <h4 class="font-black text-white text-base leading-snug hover:text-emerald-400 transition">
                                {{ $task->title }}
                            </h4>

                            <p class="text-xs text-slate-300 mt-2 leading-relaxed">
                                {{ $task->description }}
                            </p>

                            <!-- Target & Coach details -->
                            <div class="mt-4 pt-3 border-t border-slate-800 space-y-1.5 text-xs text-slate-400">
                                <div class="flex justify-between items-center">
                                    <span>প্রশিক্ষক (Coach):</span>
                                    <strong class="text-slate-200">{{ $task->coach->name ?? 'একাডেমি কোচ' }}</strong>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span>বরাদ্দকৃত প্লেয়ার:</span>
                                    @if($task->trainee)
                                        <span class="font-bold text-emerald-400">{{ $task->trainee->name }} ({{ $task->trainee->admission_no }})</span>
                                    @elseif($task->batch)
                                        <span class="font-bold text-indigo-400">{{ $task->batch->name }} (সম্পূর্ণ ব্যাচ)</span>
                                    @else
                                        <span class="text-slate-400">সকল অ্যাথলেট</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center">
                                    <span>জমার শেষ তারিখ:</span>
                                    <span class="font-mono font-bold {{ $task->is_overdue ? 'text-rose-400' : 'text-slate-200' }}">
                                        {{ $task->due_date ? $task->due_date->format('d M, Y') : '-' }}
                                        @if($task->is_overdue)
                                            <span class="text-[10px] text-rose-400">(অতিক্রম)</span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Player Note if exists -->
                            @if($task->player_note)
                                <div class="mt-3 p-3 rounded-2xl bg-cyan-950/30 border border-cyan-800/40 text-[11px] text-cyan-200">
                                    <span class="font-black block text-[10px] uppercase text-cyan-400 mb-0.5">🚀 প্লেয়ারের অনুশীলনী নোট:</span>
                                    "{{ $task->player_note }}"
                                </div>
                            @endif

                            <!-- Coach Feedback if exists -->
                            @if($task->coach_feedback)
                                <div class="mt-2.5 p-3 rounded-2xl bg-emerald-950/30 border border-emerald-800/40 text-[11px] text-emerald-200">
                                    <div class="flex items-center justify-between mb-0.5">
                                        <span class="font-black text-[10px] uppercase text-emerald-400">★ কোচের মূল্যায়ন ও ফিডব্যাক:</span>
                                        <span class="font-mono font-black text-amber-400 text-xs">{{ $task->coach_score }}/১০ ★</span>
                                    </div>
                                    <p>"{{ $task->coach_feedback }}"</p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Footer -->
                        <div class="pt-3 border-t border-slate-800 flex items-center justify-between gap-2">
                            <!-- Player Actions -->
                            @if(Auth::user()->isPlayer() && $task->status === 'pending')
                                <button type="button" @click="activeTaskId = {{ $task->id }}; activeTaskTitle = '{{ addslashes($task->title) }}'; showCompleteModal = true" class="w-full py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-xl text-xs font-black transition shadow-lg shadow-emerald-500/20">
                                    ✓ ড্রিল সম্পন্ন করেছি (রিপোর্ট দিন)
                                </button>
                            @elseif(Auth::user()->isPlayer() && $task->status === 'completed')
                                <span class="w-full text-center py-2 bg-slate-800 text-cyan-400 rounded-xl text-xs font-bold border border-cyan-500/30">
                                    ⏳ কোচের মূল্যায়নের অপেক্ষায়
                                </span>
                            @elseif(Auth::user()->isPlayer() && $task->status === 'reviewed')
                                <span class="w-full text-center py-2 bg-emerald-500/10 text-emerald-400 rounded-xl text-xs font-bold border border-emerald-500/20">
                                    ✓ ড্রিল সফলভাবে সম্পন্ন ও মূল্যায়িত ({{ $task->coach_score }}/১০ ★)
                                </span>
                            @endif

                            <!-- Coach / Admin Actions -->
                            @if(Auth::user()->isCoach() || Auth::user()->isAdmin())
                                @if($task->status === 'completed')
                                    <button type="button" @click="activeTaskId = {{ $task->id }}; activeTaskTitle = '{{ addslashes($task->title) }}'; activePlayerNote = '{{ addslashes($task->player_note ?? '') }}'; showReviewModal = true" class="flex-1 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-black transition shadow-lg shadow-amber-500/20">
                                        ★ মূল্যায়ন ও স্কোর দিন
                                    </button>
                                @elseif($task->status === 'pending')
                                    <form method="POST" action="{{ route('tasks.quick-complete', $task) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-emerald-600 hover:text-white text-slate-300 rounded-xl text-xs font-bold transition border border-slate-700" title="সরাসরি মাঠে সম্পন্ন হিসেবে চিহ্নিত করুন">
                                            ⚡ সম্পন্ন মার্ক করুন
                                        </button>
                                    </form>
                                @else
                                    <span class="flex-1 text-center py-1.5 text-xs font-bold text-emerald-400 bg-emerald-500/10 rounded-xl border border-emerald-500/20">
                                        ✓ সম্পন্ন ({{ $task->coach_score }}/১০)
                                    </span>
                                @endif

                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('টাস্কটি মুছে ফেলতে চান?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-400 hover:bg-rose-500/20 rounded-xl transition" title="মুছুন">
                                        ✕
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-slate-900 rounded-3xl border border-dashed border-slate-800 text-slate-400 space-y-3">
                        <span class="text-5xl block">🏃‍♂️</span>
                        <h4 class="text-base font-bold text-white">বর্তমানে কোনো ট্রেনিং ড্রিল বা টাস্ক নেই।</h4>
                        <p class="text-xs text-slate-500">ফিল্টার পরিবর্তন করে দেখুন অথবা নতুন ট্রেনিং ড্রিল তৈরি করুন।</p>
                        @if(Auth::user()->isCoach() || Auth::user()->isAdmin())
                            <button @click="showCreateModal = true" class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-black rounded-xl text-xs shadow transition">
                                + প্রথম ড্রিল অ্যাসাইন করুন
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($tasks->hasPages())
                <div class="p-4 bg-slate-900 border border-slate-800 rounded-2xl">
                    {{ $tasks->links() }}
                </div>
            @endif

        </div>

        <!-- ============================================== -->
        <!-- 📝 MODAL: CREATE TRAINING TASK (COACH & ADMIN) -->
        <!-- ============================================== -->
        <div x-show="showCreateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-800 space-y-4" @click.away="showCreateModal = false">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="font-black text-white text-base flex items-center gap-2">
                        <span>📋</span> নতুন ট্রেনিং ড্রিল / টাস্ক তৈরি
                    </h3>
                    <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-white text-xl font-bold">&times;</button>
                </div>

                <!-- Preset Template Picker -->
                <div class="p-3.5 rounded-2xl bg-indigo-950/40 border border-indigo-500/30 space-y-1.5">
                    <label class="block text-xs font-black text-indigo-300">
                        ⚡ রেডিমেড ড্রিল লাইব্রেরি (১-ক্লিকে পূরণ করুন):
                    </label>
                    <select x-model="selectedTemplate" @change="applyTemplate()" class="w-full text-xs rounded-xl bg-slate-950 border-slate-700 text-slate-200 focus:ring-emerald-500">
                        <option value="">-- ড্রিল টেমপ্লেট নির্বাচন করুন (ঐচ্ছিক) --</option>
                        <template x-for="item in templates" :key="item.title">
                            <option :value="item.title" x-text="item.template_name"></option>
                        </template>
                    </select>
                </div>

                <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">ড্রিলের নাম / শিরোনাম <span class="text-rose-500">*</span></label>
                        <input type="text" id="task_title" name="title" required placeholder="উদাঃ ১০০মি. স্প্রিন্ট ও পুশআপ টেস্ট" class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">ড্রিলের ক্যাটাগরি</label>
                            <select id="task_category" name="drill_category" required class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500">
                                <option value="fitness">ফিটনেস ও স্ট্যামিনা</option>
                                <option value="technical">টেকনিক্যাল স্কিল</option>
                                <option value="tactical">কৌশলগত (Tactical)</option>
                                <option value="recovery">রিকভারি ও স্ট্রেচিং</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">খেলা (Sport)</label>
                            <input type="text" id="task_sport" name="sport_type" value="ফুটবল" required class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">নির্দিষ্ট ব্যাচ (ঐচ্ছিক)</label>
                            <select name="batch_id" class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500">
                                <option value="">-- সম্পূর্ণ ব্যাচ নির্বাচন --</option>
                                @foreach($batches as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">নির্দিষ্ট প্লেয়ার (ঐচ্ছিক)</label>
                            <select name="trainee_id" class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500">
                                <option value="">-- ব্যাচের সকল প্লেয়ার --</option>
                                @foreach($trainees as $tr)
                                    <option value="{{ $tr->id }}">{{ $tr->name }} ({{ $tr->admission_no }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">জমার শেষ তারিখ <span class="text-rose-500">*</span></label>
                            <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">অগ্রাধিকার (Priority)</label>
                            <select id="task_priority" name="priority" required class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500">
                                <option value="normal">সাধারণ (Normal)</option>
                                <option value="high">জরুরি (High)</option>
                                <option value="low">ঐচ্ছিক (Low)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">ড্রিল বা টাস্কের বিস্তারিত নির্দেশনা <span class="text-rose-500">*</span></label>
                        <textarea id="task_desc" name="description" rows="3" required placeholder="খেলোয়াড় কীভাবে অনুশীলন করবে তার স্পষ্ট নির্দেশনা দিন..." class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500"></textarea>
                    </div>

                    <div class="pt-3 border-t border-slate-800 flex justify-end gap-2">
                        <button type="button" @click="showCreateModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition">বাতিল</button>
                        <button type="submit" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-xl text-xs font-black shadow-lg shadow-emerald-500/20 transition">টাস্ক বরাদ্দ করুন</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- ✓ MODAL: PLAYER COMPLETE TASK -->
        <!-- ============================================== -->
        <div x-show="showCompleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-800 space-y-4" @click.away="showCompleteModal = false">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="font-black text-white text-base flex items-center gap-2">
                        <span>✓</span> ড্রিল সমাপ্তি নিশ্চিতকরণ
                    </h3>
                    <button type="button" @click="showCompleteModal = false" class="text-slate-400 hover:text-white text-xl font-bold">&times;</button>
                </div>
                <form :action="'{{ url('/tasks') }}/' + activeTaskId + '/complete'" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div class="text-xs text-slate-300 p-3 rounded-xl bg-slate-950 border border-slate-800">
                        অনুশীলনী: <strong class="text-emerald-400" x-text="activeTaskTitle"></strong>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">আপনার অভিজ্ঞতা, টাইমিং বা সমাপ্তি রিপোর্ট <span class="text-emerald-400">*</span></label>
                        <textarea name="player_note" rows="3" required placeholder="যেমন: আজ সকালে ৩ সেট স্প্রিন্ট শেষ করেছি, গড় সময় ১৩.২ সেকেন্ড লেগেছে..." class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500"></textarea>
                    </div>
                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-800">
                        <button type="button" @click="showCompleteModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl">বাতিল</button>
                        <button type="submit" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-xs font-black rounded-xl shadow-lg shadow-emerald-500/20 transition">সম্পন্ন জমা দিন ➔</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- ★ MODAL: COACH REVIEW TASK -->
        <!-- ============================================== -->
        <div x-show="showReviewModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-800 space-y-4" @click.away="showReviewModal = false">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="font-black text-white text-base flex items-center gap-2">
                        <span>★</span> ড্রিল মূল্যায়ন ও কোচিং স্কোর
                    </h3>
                    <button type="button" @click="showReviewModal = false" class="text-slate-400 hover:text-white text-xl font-bold">&times;</button>
                </div>
                <form :action="'{{ url('/tasks') }}/' + activeTaskId + '/review'" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-2 text-xs">
                        <div class="p-3 rounded-xl bg-slate-950 border border-slate-800 text-slate-300">
                            টাস্ক: <strong class="text-white" x-text="activeTaskTitle"></strong>
                        </div>
                        <template x-if="activePlayerNote">
                            <div class="p-3 rounded-xl bg-cyan-950/40 border border-cyan-800/40 text-cyan-200">
                                <span class="font-bold block text-[10px] uppercase text-cyan-400">প্লেয়ারের সাবমিশন:</span>
                                <span x-text="activePlayerNote"></span>
                            </div>
                        </template>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">কোচিং স্কোর (১ থেকে ১০ এর মধ্যে) <span class="text-rose-500">*</span></label>
                        <input type="number" name="coach_score" min="1" max="10" value="9" required class="w-full text-base font-mono font-black rounded-xl border-slate-700 bg-slate-950 text-amber-400 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">কোচের ফিডব্যাক ও কারেকশন মন্তব্য</label>
                        <textarea name="coach_feedback" rows="3" placeholder="খেলোয়াড়ের জন্য উৎসাহব্যঞ্জক পরামর্শ ও টেকনিক্যাল সংশোধনী দিন..." class="w-full text-xs rounded-xl border-slate-700 bg-slate-950 text-white focus:ring-emerald-500"></textarea>
                    </div>
                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-800">
                        <button type="button" @click="showReviewModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl">বাতিল</button>
                        <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-black rounded-xl shadow-lg shadow-amber-500/20 transition">স্কোর ও ফিডব্যাক দিন ★</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>

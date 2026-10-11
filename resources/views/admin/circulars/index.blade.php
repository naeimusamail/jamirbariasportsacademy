<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
                    <span>📅</span> {{ __('রেজিস্ট্রেশন সার্কুলার ও ডেডলাইন হাব') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    তারিখ ও সময় অনুযায়ী সকল অনলাইন আবেদন (ভর্তি, ভলান্টিয়ার, ড্রাফট) স্বয়ংক্রিয়ভাবে চালু ও বন্ধের সময়সূচী নিয়ন্ত্রণ
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400 font-mono bg-slate-800/80 px-3 py-1.5 rounded-lg border border-slate-700">
                    🕒 সার্ভার সময়: <strong class="text-emerald-400">{{ now()->format('d M Y, h:i A') }}</strong>
                </span>
            </div>
        </div>
    </x-slot>

    <div x-data="{ createModalOpen: false }" class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 border border-slate-700/80 p-6 rounded-2xl shadow-xl">
        <div class="space-y-1.5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-xl shadow-lg shadow-emerald-900/30">
                    📅
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-black text-white tracking-tight">
                        রেজিস্ট্রেশন সার্কুলার ও ডেডলাইন হাব
                    </h1>
                    <p class="text-xs text-slate-400">
                        তারিখ ও সময় অনুযায়ী সকল অনলাইন আবেদন (ভর্তি, ভলান্টিয়ার, ড্রাফট) স্বয়ংক্রিয়ভাবে চালু ও বন্ধ করার সার্বজনীন নিয়ন্ত্রণ।
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <span class="text-xs text-slate-400 font-mono bg-slate-800/80 px-3 py-2 rounded-xl border border-slate-700">
                🕒 বর্তমান সার্ভার সময়: <strong class="text-emerald-400">{{ now()->format('d M Y, h:i A') }}</strong>
            </span>

            <button @click="createModalOpen = true" 
                    class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black rounded-xl text-xs transition shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <span>➕</span>
                <span>নতুন ভর্তি সার্কুলার তৈরি করুন</span>
            </button>
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl text-sm font-semibold animate-fadeIn">
            <span class="text-lg">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 p-4 bg-rose-500/10 border border-rose-500/30 text-rose-400 rounded-xl text-sm font-semibold animate-fadeIn">
            <span class="text-lg">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Stat Summary Pills -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @php
            $openCount = $circulars->filter(fn($c) => $c->getStatus() === 'open')->count();
            $upcomingCount = $circulars->filter(fn($c) => $c->getStatus() === 'upcoming')->count();
            $closedCount = $circulars->filter(fn($c) => in_array($c->getStatus(), ['closed', 'paused']))->count();
        @endphp

        <div class="bg-slate-900/70 border border-slate-800 rounded-xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <div>
                    <div class="text-xs text-slate-400">উন্মুক্ত ও চলমান সার্কুলার</div>
                    <div class="text-lg font-black text-emerald-400">{{ $openCount }} টি আবেদন খোলা</div>
                </div>
            </div>
            <span class="text-2xl">🟢</span>
        </div>

        <div class="bg-slate-900/70 border border-slate-800 rounded-xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                <div>
                    <div class="text-xs text-slate-400">আসন্ন (শিডিউল করা)</div>
                    <div class="text-lg font-black text-amber-400">{{ $upcomingCount }} টি অপেক্ষমাণ</div>
                </div>
            </div>
            <span class="text-2xl">🟡</span>
        </div>

        <div class="bg-slate-900/70 border border-slate-800 rounded-xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                <div>
                    <div class="text-xs text-slate-400">মেয়াদোত্তীর্ণ বা স্থগিত</div>
                    <div class="text-lg font-black text-rose-400">{{ $closedCount }} টি বন্ধ</div>
                </div>
            </div>
            <span class="text-2xl">🔴</span>
        </div>
    </div>

    <!-- Modal: Create New Admission Circular -->
    <div x-show="createModalOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
         @keydown.escape.window="createModalOpen = false">
        <div @click.away="createModalOpen = false" class="bg-slate-900 border border-slate-700 max-w-2xl w-full rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 text-left relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-start justify-between gap-4 border-b border-slate-800 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 text-xl font-bold">
                        ➕
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white">নতুন ভর্তি সার্কুলার তৈরি করুন</h3>
                        <p class="text-xs text-slate-400">নির্দিষ্ট সেশন বা ব্যাচের জন্য নতুন ভর্তি বিজ্ঞপ্তি প্রকাশ ও নিয়ন্ত্রণ</p>
                    </div>
                </div>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-white p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-sm font-bold">
                    ✕
                </button>
            </div>

            <form action="{{ route('admin.circulars.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="admission">

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">
                        সার্কুলারের শিরোনাম <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="title" required placeholder="যেমন: ২০২৬ সামার ফুটবল ও ক্রিকেট একাডেমি ভর্তি ক্যাম্প"
                           class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">
                        সংক্ষিপ্ত বিবরণী ও নির্দেশনা
                    </label>
                    <textarea name="description" rows="2" placeholder="ভর্তির শর্তাবলী বা সাধারণ পরিচিতি"
                              class="w-full px-3.5 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-emerald-400 mb-1">
                            🚀 আবেদন শুরুর সময়
                        </label>
                        <input type="datetime-local" name="start_date"
                               class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs font-mono text-white focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-rose-400 mb-1">
                            🛑 শেষ সময় / ডেডলাইন
                        </label>
                        <input type="datetime-local" name="end_date"
                               class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs font-mono text-white focus:outline-none focus:border-rose-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-amber-400 mb-1">
                        💰 ভর্তি / আবেদন ফি (ঐচ্ছিক টাকা)
                    </label>
                    <input type="number" step="0.01" name="fee" placeholder="যেমন: 500"
                           class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs font-mono text-white focus:outline-none focus:border-amber-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-amber-400 mb-1">
                            শুরুর পূর্বে বার্তা (Upcoming Message)
                        </label>
                        <textarea name="upcoming_message" rows="2" placeholder="আবেদন শুরুর পূর্বের বার্তা"
                                  class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-rose-400 mb-1">
                            মেয়াদ শেষের বার্তা (Closed Message)
                        </label>
                        <textarea name="closed_message" rows="2" placeholder="সময়সীমা সমাপ্তির পর প্রদর্শিত বার্তা"
                                  class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white"></textarea>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="w-4 h-4 rounded bg-slate-950 border-slate-700 text-emerald-500 focus:ring-emerald-500">
                        <span class="text-xs font-bold text-slate-300">তাত্ক্ষণিক সক্রিয় রাখুন</span>
                    </label>

                    <div class="flex items-center gap-3">
                        <button type="button" @click="createModalOpen = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                            বাতিল
                        </button>
                        <button type="submit" class="px-5 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 text-slate-950 font-black rounded-xl text-xs shadow-lg transition">
                            সার্কুলার প্রকাশ করুন ➔
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Circulars Grid -->
    <div class="space-y-6">
        @foreach($circulars as $circular)
            @php
                $badge = $circular->status_badge;
                $status = $circular->getStatus();
            @endphp
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-200 hover:border-slate-700">
                <!-- Card Header -->
                <div class="p-5 md:p-6 bg-slate-850/60 border-b border-slate-800/80 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-2xl shadow-inner">
                            {{ $circular->type_icon }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h2 class="text-lg font-black text-white tracking-tight">
                                    {{ $circular->type_name }}
                                </h2>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border {{ $badge['bg'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }} {{ $status === 'open' ? 'animate-pulse' : '' }}"></span>
                                    {{ $circular->status_label }}
                                </span>
                                @if($circular->fee)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                        ফি: ৳{{ number_format($circular->fee) }}
                                    </span>
                                @endif
                            </div>
                            @if($circular->tournament)
                                <p class="text-xs text-emerald-400 mt-0.5 flex items-center gap-2 flex-wrap">
                                    <span>🏟️ ভেন্যু: {{ $circular->tournament->venue }}</span>
                                    <span>•</span>
                                    <span class="capitalize">⚽ খেলা: {{ $circular->tournament->sport_type }}</span>
                                    <span>•</span>
                                    <span>টিম সংখ্যা: {{ $circular->tournament->total_teams }}</span>
                                </p>
                            @else
                                <p class="text-xs text-slate-400 mt-0.5">
                                    সার্কুলার আইডি: <code class="text-amber-400 font-mono">#{{ $circular->id }}</code>
                                    • ধরন: <code class="text-slate-300 font-mono">{{ $circular->type }}</code>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        @if($circular->tournament)
                            <a href="{{ route('public.tournaments.show', $circular->tournament->slug) }}" target="_blank"
                               class="px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 text-xs font-semibold text-emerald-300 transition flex items-center gap-1.5">
                                <span>🏆 টুর্নামেন্ট পেজ</span>
                            </a>
                        @endif

                        @if($circular->type === 'admission')
                            <!-- Link to Applicants for this Circular -->
                            <a href="{{ route('admin.admissions.index', ['circular_id' => $circular->id]) }}"
                               class="px-3 py-1.5 rounded-lg bg-teal-500/10 hover:bg-teal-500/20 border border-teal-500/30 text-xs font-bold text-teal-300 transition flex items-center gap-1.5">
                                <span>👥 আবেদনকারী: {{ $circular->admission_applications_count ?? 0 }} জন ➔</span>
                            </a>
                        @endif

                        <!-- Preview Public Link -->
                        <a href="{{ $circular->apply_url }}" target="_blank"
                           class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-semibold text-slate-200 transition flex items-center gap-1.5">
                            <span>🔗 নিবন্ধন ফরম</span>
                        </a>

                        <!-- Quick Pause/Resume Toggle Form -->
                        <form action="{{ route('admin.circulars.toggle', $circular->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $circular->is_active ? 'bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' }}">
                                @if($circular->is_active)
                                    <span>⏸️ স্থগিত</span>
                                @else
                                    <span>▶️ সক্রিয়</span>
                                @endif
                            </button>
                        </form>

                        @if(!$circular->tournament_id)
                            <!-- Delete Circular Form -->
                            <form action="{{ route('admin.circulars.destroy', $circular->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই সার্কুলারটি সম্পূর্ণ মুছে ফেলতে চান?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-xs font-bold text-rose-400 transition" title="সার্কুলার মুছে ফেলুন">
                                    <span>🗑️</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Card Body & Form -->
                <form action="{{ route('admin.circulars.update', $circular->id) }}" method="POST" class="p-5 md:p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Circular Title -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block text-xs font-bold text-slate-300">
                                সার্কুলারের শিরোনাম (Title) <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $circular->title) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                        </div>

                        <!-- Description -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block text-xs font-bold text-slate-300">
                                সংক্ষিপ্ত বিবরণী / নির্দেশনা (Description)
                            </label>
                            <textarea name="description" rows="2"
                                      class="w-full px-3.5 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition"
                                      placeholder="আবেদনকারীদের জন্য সাধারণ পরিচিতি বা নির্দেশনা">{{ old('description', $circular->description) }}</textarea>
                        </div>

                        <!-- Fee (Optional) -->
                        <div class="space-y-1.5 md:col-span-2 bg-slate-950/60 p-3.5 rounded-xl border border-slate-800">
                            <label class="block text-xs font-bold text-amber-400 flex items-center justify-between">
                                <span>💰 নির্ধারিত ভর্তি/রেজিস্ট্রেশন ফি (ঐচ্ছিক টাকা)</span>
                                <span class="text-[10px] text-slate-400 font-normal">খালি রাখলে ফি প্রযোজ্য নয় বা অপরিবর্তিত</span>
                            </label>
                            <input type="number" step="0.01" name="fee" value="{{ old('fee', $circular->fee) }}" placeholder="যেমন: 500"
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-mono text-white focus:outline-none focus:border-amber-500 transition">
                        </div>

                        <!-- Start Date & Time -->
                        <div class="space-y-1.5 bg-slate-950/60 p-4 rounded-xl border border-slate-800">
                            <label class="block text-xs font-bold text-emerald-400 flex items-center justify-between">
                                <span>🚀 আবেদন শুরুর তারিখ ও সময় (Start Date & Time)</span>
                                <span class="text-[10px] text-slate-400 font-normal">খালি রাখলে স্বয়ংক্রিয় উন্মুক্ত</span>
                            </label>
                            <input type="datetime-local" name="start_date" 
                                   value="{{ old('start_date', $circular->start_date ? $circular->start_date->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-mono text-white focus:outline-none focus:border-emerald-500 transition">
                            <p class="text-[11px] text-slate-400">
                                💡 এই সময়ের পূর্বে আবেদন ফরম বন্ধ থাকবে এবং "খুব শীঘ্রই শুরু হবে" নোটিশ দেখাবে।
                            </p>
                        </div>

                        <!-- End Date & Time (Deadline) -->
                        <div class="space-y-1.5 bg-slate-950/60 p-4 rounded-xl border border-slate-800">
                            <label class="block text-xs font-bold text-rose-400 flex items-center justify-between">
                                <span>🛑 আবেদনের শেষ সময় / ডেডলাইন (Deadline)</span>
                                <span class="text-[10px] text-slate-400 font-normal">খালি রাখলে চিরস্থায়ী খোলা</span>
                            </label>
                            <input type="datetime-local" name="end_date" 
                                   value="{{ old('end_date', $circular->end_date ? $circular->end_date->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-mono text-white focus:outline-none focus:border-rose-500 transition">
                            <p class="text-[11px] text-slate-400">
                                💡 এই সময়ের পর স্বয়ংক্রিয়ভাবে ফর্ম বন্ধ হয়ে যাবে এবং নতুন কোনো সাবমিশন গ্রহণ করা হবে না।
                            </p>
                        </div>

                        <!-- Upcoming Notice -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-amber-400">
                                ⏳ শুরুর পূর্বে নোটিশ বার্তা (Upcoming Message)
                            </label>
                            <textarea name="upcoming_message" rows="2"
                                      class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-amber-500 transition"
                                      placeholder="আবেদন শুরুর পূর্ববর্তী সময়ে জনসাধারণের উদ্দেশ্যে প্রদর্শিত নোটিশ">{{ old('upcoming_message', $circular->upcoming_message) }}</textarea>
                        </div>

                        <!-- Closed Notice -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-rose-400">
                                🔒 মেয়াদ সমাপ্তির নোটিশ বার্তা (Closed Message)
                            </label>
                            <textarea name="closed_message" rows="2"
                                      class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-rose-500 transition"
                                      placeholder="আবেদন সময়সীমা শেষ হওয়ার পর প্রদর্শিত নোটিশ">{{ old('closed_message', $circular->closed_message) }}</textarea>
                        </div>
                    </div>

                    <!-- Footer Options & Save Button -->
                    <div class="pt-4 border-t border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <label class="inline-flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ $circular->is_active ? 'checked' : '' }}
                                   class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-slate-900">
                            <span class="text-xs font-bold text-slate-200">
                                মাস্টার সুইচ: সার্কুলার সক্রিয় রাখুন (Active)
                            </span>
                        </label>

                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs shadow-lg shadow-emerald-900/30 transition flex items-center justify-center gap-2">
                            <span>💾</span>
                            <span>{{ $circular->type_name }}-এর সেটিং সেভ করুন</span>
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    <!-- Tournament Deadlines Quick Overview -->
    <div class="bg-slate-900/90 border border-slate-800 rounded-2xl shadow-xl overflow-hidden mt-8">
        <div class="p-5 md:p-6 bg-slate-850/60 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🏆</span>
                <div>
                    <h3 class="text-base font-black text-white">টুর্নামেন্ট রেজিস্ট্রেশন সময়সীমা ও ডেডলাইন</h3>
                    <p class="text-xs text-slate-400">প্রতিটি টুর্নামেন্টের ব্যক্তিগত শুরুর সময় ও রেজিস্ট্রেশন ডেডলাইন স্ট্যাটাস</p>
                </div>
            </div>
            <a href="{{ route('admin.tournaments.index') }}" 
               class="text-xs font-bold text-emerald-400 hover:text-emerald-300 transition">
                সকল টুর্নামেন্ট পরিচালনা →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/80 text-[10px] uppercase font-bold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-5 py-3">টুর্নামেন্টের নাম</th>
                        <th class="px-4 py-3">খেলার ধরণ</th>
                        <th class="px-4 py-3">নিবন্ধন শুরুর সময়</th>
                        <th class="px-4 py-3">রেজিস্ট্রেশন ডেডলাইন</th>
                        <th class="px-4 py-3">বর্তমান স্ট্যাটাস</th>
                        <th class="px-4 py-3 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 font-medium">
                    @forelse($tournaments as $tourn)
                        @php
                            $isOpen = $tourn->isRegistrationOpen();
                            $isUpcoming = $tourn->isRegistrationUpcoming();
                        @endphp
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-white">{{ $tourn->name }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $tourn->venue }}</div>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="capitalize text-slate-300">{{ $tourn->sport_type }}</span>
                            </td>
                            <td class="px-4 py-3.5 font-mono text-[11px]">
                                @if($tourn->registration_start_date)
                                    <span class="text-emerald-400">{{ $tourn->registration_start_date->format('d M Y, h:i A') }}</span>
                                @else
                                    <span class="text-slate-500">তাত্ক্ষণিক খোলা</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 font-mono text-[11px]">
                                @if($tourn->registration_deadline)
                                    <span class="text-rose-400">{{ $tourn->registration_deadline->format('d M Y, h:i A') }}</span>
                                @else
                                    <span class="text-slate-500">নির্দিষ্ট নেই</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                @if($isOpen)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        নিবন্ধন উন্মুক্ত
                                    </span>
                                @elseif($isUpcoming)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        আসন্ন
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-400 border border-rose-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                        নিবন্ধন শেষ
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <a href="{{ route('admin.tournaments.edit', $tourn->id) }}" 
                                   class="text-xs font-semibold text-emerald-400 hover:underline">
                                    সম্পাদনা
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-6 text-center text-slate-500">কোনো টুর্নামেন্ট ডাটা পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    </div>
</x-app-layout>

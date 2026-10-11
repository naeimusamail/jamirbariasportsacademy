<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>একাডেমির নিয়মাবলী ও শর্তাবলী | জামিরবাড়িয়া স্পোর্টস একাডেমি</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-slate-950">

    <!-- Top Navbar -->
    <header x-data="{ mobileMenu: false }" class="border-b border-slate-800/80 bg-slate-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-400 to-amber-400 flex items-center justify-center text-slate-950 font-black text-xl sm:text-2xl shadow-lg shadow-emerald-500/20">
                    ⚽
                </div>
                <div>
                    <span class="text-base sm:text-lg font-black tracking-tight text-white block">জামিরবাড়িয়া একাডেমি</span>
                    <span class="text-[9px] sm:text-[10px] uppercase tracking-widest text-emerald-400 font-bold block">ACADEMY CODE OF CONDUCT</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-5 text-sm font-semibold text-slate-300">
                <a href="{{ url('/') }}" class="hover:text-white transition">হোম</a>
                <a href="{{ route('public.tournaments.index') }}" class="text-amber-400 hover:text-amber-300 transition">টুর্নামেন্ট হাব</a>
                <a href="{{ route('admission.create') }}" class="text-emerald-400 hover:text-emerald-300 transition">অনলাইন ভর্তি</a>
                <a href="{{ route('rules') }}" class="text-white border-b-2 border-emerald-400 pb-1">একাডেমির নিয়মাবলী</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('admission.create') }}" class="px-3.5 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-xl text-xs transition shadow-md shadow-emerald-500/20">
                    ভর্তি আবেদন ➔
                </a>

                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenu, 'block': !mobileMenu}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'block': mobileMenu, 'hidden': !mobileMenu}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenu" x-transition class="md:hidden border-t border-slate-800 bg-slate-900/95 px-4 py-4 space-y-2 text-sm font-semibold text-slate-200">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-xl hover:bg-slate-800">🏠 মূল হোমপেজ</a>
            <a href="{{ route('public.tournaments.index') }}" class="block px-3 py-2 rounded-xl text-amber-400 hover:bg-slate-800">🏆 টুর্নামেন্ট হাব</a>
            <a href="{{ route('live.index') }}" class="block px-3 py-2 rounded-xl text-rose-400 hover:bg-slate-800">🔴 লাইভ ম্যাচ সেন্টার</a>
            <a href="{{ route('admission.create') }}" class="block px-3 py-2 rounded-xl text-emerald-400 hover:bg-slate-800">📝 অনলাইন ভর্তি ফরম</a>
            <a href="{{ route('rules') }}" class="block px-3 py-2 rounded-xl bg-slate-800 text-emerald-300">📜 একাডেমি কোড অফ কন্ডাক্ট</a>
        </div>
    </header>

    <!-- Hero Header -->
    <section class="py-14 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-950 border-b border-slate-800 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-emerald-500/10 blur-[130px] rounded-full pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                <span>📜</span> একাডেমি কোড অফ কন্ডাক্ট ও নির্দেশিকা
            </div>

            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                জামিরবাড়িয়া স্পোর্টস একাডেমি <span class="bg-gradient-to-r from-emerald-400 to-teal-300 bg-clip-text text-transparent">নিয়মাবলী ও শর্তাবলী</span>
            </h1>

            <p class="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
                শৃঙ্খলা, নিয়মানুবর্তিতা ও পারস্পরিক শ্রদ্ধা একজন সেরা ক্রীড়াবিদ গড়ে তোলার প্রথম ভিত্তি। একাডেমির সুস্থ ক্রীড়া পরিবেশ ও খেলোয়াড়দের সর্বোচ্চ বিকাশ নিশ্চিত করতে এই নীতিমালা সকলের জন্য প্রযোজ্য।
            </p>
        </div>
    </section>

    <!-- Main Content: Category-wise Rules -->
    <main class="py-12 max-w-5xl mx-auto px-4 sm:px-6 space-y-10">

        <!-- 1. Discipline & Behavior Rules -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl font-black shrink-0">
                    🥇
                </div>
                <div>
                    <h2 class="text-lg font-black text-white">১. শৃঙ্খলা ও ক্রীড়াসুলভ আচরণ (Discipline & Fair Play)</h2>
                    <p class="text-xs text-slate-400">মাঠ ও মাঠের বাইরে শৃঙ্খলা বজায় রাখা প্রতিটি খেলোয়াড়ের জন্য বাধ্যতামূলক</p>
                </div>
            </div>

            <ul class="space-y-3 text-xs sm:text-sm text-slate-300 leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <span class="text-emerald-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>কোচ ও স্টাফদের সম্মান:</strong> প্রধান কোচ, সহকারী কোচ এবং একাডেমি কর্মকর্তাদের প্রতিটি সিদ্ধান্ত ও কারিগরি নির্দেশনা সর্বোচ্চ শ্রদ্ধার সাথে মেনে চলতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-emerald-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>সহ-খেলোয়াড়দের প্রতি সৌহার্দ্য:</strong> সহপাঠী খেলোয়াড়দের সাথে সর্বদা ভ্রাতৃত্বপূর্ণ ও উৎসাহমূলক আচরণ করতে হবে। কোনো ধরনের কটূক্তি, গালাগালি বা অশোভন অঙ্গভঙ্গি সম্পূর্ণ নিষিদ্ধ।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-emerald-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>বুলিং ও র্যাগিংয়ে জিরো টলারেন্স:</strong> একাডেমির সীমানায় বা সামাজিক মাধ্যমে কোনো খেলোয়াড়ের সাথে বুলিং, র্যাগিং বা বৈষম্যমূলক আচরণ প্রমাণিত হলে তাৎক্ষণিক বহিষ্কার করা হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-emerald-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>নেশাজাতীয় দ্রব্য বর্জন:</strong> ধূমপান, তামাকজাত দ্রব্য বা যেকোনো ক্ষতিকর পদার্থ বহন ও গ্রহণ একাডেমিতে কঠোরভাবে নিষিদ্ধ।</span>
                </li>
            </ul>
        </div>

        <!-- 2. Attendance & Punctuality -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-2xl font-black shrink-0">
                    ⏰
                </div>
                <div>
                    <h2 class="text-lg font-black text-white">২. সময়ানুবর্তিতা ও উপস্থিতি (Attendance & Punctuality)</h2>
                    <p class="text-xs text-slate-400">প্রতিটি অনুশীলনে সঠিক সময়ে মাঠে উপস্থিত থাকা বাধ্যতামূলক</p>
                </div>
            </div>

            <ul class="space-y-3 text-xs sm:text-sm text-slate-300 leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <span class="text-amber-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>১৫ মিনিট পূর্বে উপস্থিতি:</strong> নির্ধারিত প্র্যাকটিস শুরু হওয়ার অন্তত ১৫ মিনিট আগে মাঠে উপস্থিত হয়ে ওয়ার্ম-আপের জন্য প্রস্তুত হতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-amber-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>ডিজিটাল হাজিরা রেকর্ড:</strong> প্রতিটি সেশনে কোচ বা একাডেমি ম্যানেজমেন্টের কাছে নিয়মিত ডিজিটাল অ্যাটেনডেন্স নিশ্চিত করতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-amber-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>ছুটির পূর্বানুমতি:</strong> অসুস্থতা বা জরুরি কারণে অনুশীলনে অনুপস্থিত থাকতে হলে অভিভাবক কর্তৃক কোচের নিকট পূর্বানুমতি বা অবগত করতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-amber-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>৮০% উপস্থিতির আবশ্যকতা:</strong> একাডেমি সার্টিফিকেট, টুর্নামেন্ট টিম সিলেকশন এবং স্কলারশিপ মূল্যায়নের জন্য ন্যূনতম ৮০% উপস্থিতি বজায় রাখতে হবে।</span>
                </li>
            </ul>
        </div>

        <!-- 3. Kit, Uniform & Gear Rules -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-500/10 border border-teal-500/20 text-teal-400 flex items-center justify-center text-2xl font-black shrink-0">
                    🎽
                </div>
                <div>
                    <h2 class="text-lg font-black text-white">৩. একাডেমি কিট ও পোশাক বিধি (Uniform & Safety Gear)</h2>
                    <p class="text-xs text-slate-400">নিরাপত্তা ও একতাবদ্ধতার প্রতীক হিসেবে নির্ধারিত জার্সি ও গিয়ার পরিধান</p>
                </div>
            </div>

            <ul class="space-y-3 text-xs sm:text-sm text-slate-300 leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <span class="text-teal-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>অফিশিয়াল একাডেমি কিট:</strong> একাডেমির নির্ধারিত অফিসিয়াল প্র্যাকটিস জার্সি, শর্টস ও ট্রাউজার পরিধান করে মাঠে প্রবেশ করতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-teal-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>উপযুক্ত স্পোর্টস শু ও বুট:</strong> ফুটবল ও ক্রিকেটের জন্য উপযোগী বুট বা স্পাইক এবং ব্যাডমিন্টনের জন্য নন-মার্কিং ইনডোর শু ব্যবহার বাধ্যতামূলক।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-teal-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>সুরক্ষামূলক গিয়ার (Safety Equipment):</strong> ফুটবলে শিনগার্ড (Shin Guard) এবং ক্রিকেটে ব্যাটিং প্যাড, হেলমেট ও গ্লাভস ছাড়া নেটে ব্যাটিং করা সম্পূর্ণ নিষেধ।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-teal-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>ডিজিটাল আইডি কার্ড:</strong> একাডেমির ডিজিটাল প্লেয়ার আইডি কার্ড সর্বদা সাথে রাখতে হবে এবং প্রবেশদ্বারে প্রদর্শন করতে হবে।</span>
                </li>
            </ul>
        </div>

        <!-- 4. Fee & Financial Policy -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center text-2xl font-black shrink-0">
                    💳
                </div>
                <div>
                    <h2 class="text-lg font-black text-white">৪. ফি ও আর্থিক নীতিমালা (Fees & Payment Terms)</h2>
                    <p class="text-xs text-slate-400">একাডেমির সুষ্ঠু পরিচালনা ও সরঞ্জাম রক্ষণাবেক্ষণের নীতিমালা</p>
                </div>
            </div>

            <ul class="space-y-3 text-xs sm:text-sm text-slate-300 leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <span class="text-rose-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>মাসিক ফি পরিশোধের সময়সীমা:</strong> প্রতি মাসের মাসিক প্রশিক্ষণ ফি সংশ্লিষ্ট মাসের ১০ তারিখের মধ্যে অনলাইন পেমেন্ট (বিকাশ/নগদ/রকেট/ব্যাংক) বা একাডেমি কাউন্টারে পরিশোধ করতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-rose-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>ডিজিটাল মানি রিসিট:</strong> প্রতিটি ফি পরিশোধের পর সফটওয়্যার জেনারেটেড ডিজিটাল পেমেন্ট রিসিট বা এসএমএস সংগ্রহ ও সংরক্ষণ করতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-rose-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>ফি অফেরতযোগ্যতা:</strong> ভর্তি ফি ও প্রদত্ত প্রশিক্ষণ ফি অফেরতযোগ্য (Non-Refundable)।</span>
                </li>
            </ul>
        </div>

        <!-- 5. Tournaments, Matches & Free Agents Policy -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-2xl font-black shrink-0">
                    🏆
                </div>
                <div>
                    <h2 class="text-lg font-black text-white">৫. টুর্নামেন্ট ও টিম সিলেকশন নীতিমালা (Tournaments & Team Draft)</h2>
                    <p class="text-xs text-slate-400">একাডেমিক ও উন্মুক্ত লোকাল টুর্নামেন্টে অংশগ্রহণের নিয়মাবলী</p>
                </div>
            </div>

            <ul class="space-y-3 text-xs sm:text-sm text-slate-300 leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <span class="text-indigo-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>রেজিস্ট্রেশন ডেডলাইন:</strong> যেকোনো টুর্নামেন্টে নির্ধারিত শেষ সময়সীমার (Registration Deadline) পূর্বে প্লেয়ার অ্যাকাউন্ট দিয়ে আবেদন সম্পন্ন করতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-indigo-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>দলহীন প্লেয়ারদের ড্রাফট পুল:</strong> যাদের দল নেই, তারা "দল ছাড়া (Free Agent)" হিসেবে নিবন্ধিত হবেন এবং টেকনিক্যাল কমিটির মূল্যায়নে অ্যাডমিন তাদের উপযুক্ত স্কোয়াডে অন্তর্ভুক্ত করবেন।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-indigo-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>অ্যাম্পায়ার ও রেফারির সিদ্ধান্ত:</strong> ম্যাচে ম্যাচ অফিশিয়াল, আম্পায়ার এবং রেফারির সিদ্ধান্তই চূড়ান্ত। রেফারির সাথে অযাচিত বিতর্ক শাস্তিযোগ্য অপরাধ।</span>
                </li>
            </ul>
        </div>

        <!-- 6. Facility & Ground Safety -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
            <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center text-2xl font-black shrink-0">
                    🏟️
                </div>
                <div>
                    <h2 class="text-lg font-black text-white">৬. মাঠ ও সরঞ্জামের যত্ন (Ground & Facility Care)</h2>
                    <p class="text-xs text-slate-400">একাডেমির সম্পদ ও পরিবেশ সুরক্ষার দায়িত্ব সবার</p>
                </div>
            </div>

            <ul class="space-y-3 text-xs sm:text-sm text-slate-300 leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <span class="text-cyan-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>সরঞ্জাম যথাযথ ব্যবহার:</strong> বল, কোণ, নেট, উইকেট এবং ফিটনেস সামগ্রী ব্যবহারের পর নির্দিষ্ট স্থানে গুছিয়ে রাখতে হবে।</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-cyan-400 font-bold text-base mt-[-2px]">✓</span>
                    <span><strong>পরিচ্ছন্নতা রক্ষা:</strong> মাঠে কোনো প্লাস্টিকের বোতল, খাবারের প্যাকেট বা ময়লা ফেলা যাবে না। নির্ধারিত ডাস্টবিন ব্যবহার করতে হবে।</span>
                </li>
            </ul>
        </div>

        <!-- Bottom Action Box -->
        <div class="bg-gradient-to-r from-emerald-950/40 via-slate-900 to-slate-950 border border-emerald-500/30 rounded-3xl p-6 sm:p-8 text-center space-y-4 shadow-2xl">
            <h3 class="text-xl sm:text-2xl font-black text-white">
                আপনি কি একাডেমি রুলসের সাথে একমত?
            </h3>
            <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto">
                পেশাদার ক্রীড়াবিদ হওয়ার স্বপ্নে আজই জামিরবাড়িয়া স্পোর্টস একাডেমিতে যোগ দিন এবং নিজের ক্রীড়া প্রতিভা বিকশিত করুন।
            </p>
            <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('admission.create') }}" class="px-8 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black rounded-2xl text-xs sm:text-sm transition shadow-lg shadow-emerald-500/20">
                    অনলাইন ভর্তি আবেদন ➔
                </a>
                <a href="{{ url('/') }}" class="px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-2xl text-xs sm:text-sm border border-slate-700 transition">
                    &larr; হোমপেজে ফিরুন
                </a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-950 py-10 text-center text-xs text-slate-500 space-y-2">
        <p class="font-semibold text-slate-400">জামিরবাড়িয়া স্পোর্টস একাডেমি • Jamirbaria Sports Academy</p>
        <p>© {{ date('Y') }} সর্বস্বত্ব সংরক্ষিত। একাডেমি রুলস ও কোড অফ কন্ডাক্ট পলিসি।</p>
    </footer>

</body>
</html>


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Jamirbaria Sports Academy') }} - সেন্ট্রাল লগইন</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            function typewriter(words, prefix = '') {
                return {
                    words: words,
                    prefix: prefix,
                    text: '',
                    wordIndex: 0,
                    charIndex: 0,
                    isDeleting: false,
                    isFocused: false,
                    init() {
                        this.tick();
                    },
                    tick() {
                        if (this.isFocused) {
                            setTimeout(() => this.tick(), 300);
                            return;
                        }
                        const currentWord = this.words[this.wordIndex] || '';
                        if (this.isDeleting) {
                            this.text = currentWord.substring(0, this.charIndex - 1);
                            this.charIndex--;
                        } else {
                            this.text = currentWord.substring(0, this.charIndex + 1);
                            this.charIndex++;
                        }

                        let delta = this.isDeleting ? 35 : 75;

                        if (!this.isDeleting && this.charIndex === currentWord.length) {
                            delta = 1800; // pause at completed word
                            this.isDeleting = true;
                        } else if (this.isDeleting && this.charIndex === 0) {
                            this.isDeleting = false;
                            this.wordIndex = (this.wordIndex + 1) % this.words.length;
                            delta = 450;
                        }

                        setTimeout(() => this.tick(), delta);
                    }
                }
            }
        </script>
    </head>
    <body class="font-sans antialiased text-slate-100 bg-slate-950 selection:bg-emerald-500 selection:text-slate-950">
        <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 sports-bg-pitch relative overflow-hidden">
            <!-- Background Glow Orbs -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Academy Top Brand -->
            <div class="mb-6 text-center relative z-10">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 p-0.5 shadow-xl shadow-emerald-950 flex items-center justify-center transform group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full rounded-[14px] bg-slate-950 flex items-center justify-center text-2xl">
                            ⚽
                        </div>
                    </div>
                    <div class="text-left">
                        <h1 class="text-xl font-black text-white tracking-tight group-hover:text-emerald-400 transition-colors">
                            জামিরবাড়িয়া স্পোর্টস একাডেমি
                        </h1>
                        <span class="text-[11px] text-emerald-400 font-semibold tracking-wider block">
                            JAMIRBARIA SPORTS ACADEMY • একাউন্ট পোর্টাল
                        </span>
                    </div>
                </a>
            </div>

            <!-- Login Container Card -->
            <div class="w-full sm:max-w-md bg-slate-900/80 backdrop-blur-xl border border-slate-800 p-6 sm:p-8 rounded-3xl shadow-2xl relative z-10">
                {{ $slot }}
            </div>

            <!-- Footer Quick Links -->
            <div class="mt-6 text-center text-xs text-slate-500 relative z-10 flex items-center gap-4">
                <a href="/" class="hover:text-emerald-400 transition-colors">মূল ওয়েবসাইট</a>
                <span>•</span>
                <a href="{{ route('rules') }}" class="hover:text-emerald-400 transition-colors">একাডেমি রুলস ও টার্মস</a>
                <span>•</span>
                <span class="font-mono">সেশন ২০২৬</span>
            </div>
        </div>
    </body>
</html>

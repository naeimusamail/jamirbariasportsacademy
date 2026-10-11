<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'জামিরবাড়িয়া স্পোর্টস একাডেমি') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased text-slate-100 bg-slate-950 selection:bg-emerald-500 selection:text-slate-950">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-950 sports-turf-mesh flex">
            
            <!-- Left Sidebar Navigation (Desktop Left Fixed + Mobile Off-Canvas Drawer) -->
            @include('layouts.navigation')

            <!-- Main App Area (Offset on desktop: lg:pl-72) -->
            <div class="flex-1 flex flex-col min-w-0 lg:pl-72 transition-all duration-200">
                
                <!-- Clean Top Header Bar -->
                @include('layouts.header')

                <!-- Page Heading / Actions (Optional) -->
                @if (isset($header))
                    <header class="bg-slate-900/60 border-b border-slate-800/80 px-4 py-4 sm:px-6 lg:px-8 backdrop-blur-md">
                        <div class="w-full">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content Slot -->
                <main class="flex-1 w-full min-w-0">
                    {{ $slot ?? '' }}
                    @yield('content')
                </main>

                <!-- Academy Footer -->
                <footer class="py-4 px-6 border-t border-slate-800/60 bg-slate-950/60 text-center text-xs text-slate-500">
                    <p>© {{ date('Y') }} জামিরবাড়িয়া স্পোর্টস একাডেমি • সর্বস্বত্ব সংরক্ষিত</p>
                </footer>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>

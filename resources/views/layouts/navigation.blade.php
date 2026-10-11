<!-- DESKTOP LEFT SIDEBAR -->
<aside class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 lg:left-0 lg:z-40 border-r border-slate-800/90 shadow-2xl">
    @include('layouts.sidebar-content')
</aside>

<!-- MOBILE OFF-CANVAS SIDEBAR DRAWER -->
<div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>

    <!-- Sliding Sidebar Container -->
    <div class="fixed inset-0 flex">
        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative mr-14 flex w-full max-w-xs flex-1 flex-col bg-slate-900 border-r border-slate-800 shadow-2xl">
            @include('layouts.sidebar-content')
        </div>
    </div>
</div>

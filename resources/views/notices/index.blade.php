<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                    {{ __('একাডেমি নোটিশ বোর্ড (Notices & Announcements)') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">জরুরি ঘোষণা, টুর্নামেন্ট সূচি ও নোটিফিকেশন</p>
            </div>
            <a href="{{ route('notices.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow">
                + নতুন নোটিশ প্রকাশ করুন
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($notices as $notice)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border {{ $notice->is_pinned ? 'border-emerald-500/50 bg-emerald-50/10' : 'border-gray-100 dark:border-gray-700' }} transition">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-700/60 pb-3 mb-4">
                            <div class="flex items-center gap-2">
                                @if($notice->is_pinned)
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                        📌 পিন করা নোটিশ
                                    </span>
                                @endif
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                    {{ $notice->sport->name ?? 'সকল খেলা' }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-400 font-mono">
                                প্রকাশের তারিখ: {{ $notice->notice_date }}
                            </div>
                        </div>

                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">
                            {{ $notice->title }}
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 leading-relaxed whitespace-pre-line">
                            {{ $notice->content }}
                        </p>

                        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex justify-end">
                            <form method="POST" action="{{ route('notices.destroy', $notice) }}" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই নোটিশটি মুছে ফেলতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">
                                    মুছে ফেলুন ✕
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-10 text-center text-gray-500">
                        এখনো কোনো নোটিশ প্রকাশ করা হয়নি।
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $notices->links() }}
            </div>
        </div>
    </div>
</x-app-layout>


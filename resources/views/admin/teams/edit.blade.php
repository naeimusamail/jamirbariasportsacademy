<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                {{ __('ক্লাব / টিমের তথ্য পরিবর্তন (Edit Club / Team)') }} - {{ $team->name }}
            </h2>
            <a href="{{ route('admin.teams.show', $team) }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                &larr; ক্লাবের বিস্তারিত পেজে ফিরে যান
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 rounded-xl text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.teams.update', $team) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Team Logo with 300x300 Cropper -->
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center gap-5">
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-2xl bg-gray-200 dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                                @if($team->logo)
                                    <img id="team-logo-preview" src="{{ asset('storage/' . $team->logo) }}" alt="Team Logo" class="w-full h-full object-cover">
                                @else
                                    <img id="team-logo-preview" src="" alt="Team Logo" class="w-full h-full object-cover hidden">
                                    <span id="team-logo-placeholder" class="text-gray-400 text-xs text-center px-1">লোগো নেই</span>
                                @endif
                            </div>
                            <span id="team-crop-badge" class="hidden absolute -bottom-2 -right-2 bg-emerald-500 text-white font-bold text-[10px] px-2 py-0.5 rounded-full shadow">✓ 300×300</span>
                        </div>
                        <div class="flex-1 w-full space-y-1.5">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">টিম লোগো পরিবর্তন করুন (Team Logo)</label>
                            <input type="file" name="logo" id="team-logo-input" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/10 file:text-emerald-600 dark:file:text-emerald-400 hover:file:bg-emerald-500/20 cursor-pointer">
                            <input type="hidden" name="cropped_logo" id="team-cropped-logo">
                            <p class="text-[11px] text-gray-400">নতুন ছবি বাছাই করলে ৩০০×৩০০ মাপে ক্রপ করার পপআপ আসবে।</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">টিমের নাম *</label>
                            <input type="text" name="name" value="{{ old('name', $team->name) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">সংক্ষিপ্ত নাম (Short Code)</label>
                            <input type="text" name="short_name" value="{{ old('short_name', $team->short_name) }}" maxlength="10" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-mono uppercase">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">খেলার ধরন *</label>
                            <select name="sport_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                @foreach($sports as $sp)
                                    <option value="{{ $sp->id }}" {{ old('sport_id', $team->sport_id) == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">বয়স ক্যাটাগরি *</label>
                            <select name="category" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                @foreach(['Senior', 'U-19', 'U-16', 'U-14', 'U-12'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $team->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">টিম কোচ</label>
                            <input type="text" name="coach_name" value="{{ old('coach_name', $team->coach_name) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">অধিনায়ক (Captain)</label>
                            <input type="text" name="captain_name" value="{{ old('captain_name', $team->captain_name) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <!-- Statistics Inputs -->
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700">
                        <h4 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-3">ম্যাচ রেকর্ড ও পয়েন্ট</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                            <div>
                                <label class="block text-[11px] text-gray-500 mb-1">মোট ম্যাচ</label>
                                <input type="number" min="0" name="matches_played" value="{{ old('matches_played', $team->matches_played) }}" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 font-mono">
                            </div>
                            <div>
                                <label class="block text-[11px] text-emerald-600 mb-1">জয় (Won)</label>
                                <input type="number" min="0" name="matches_won" value="{{ old('matches_won', $team->matches_won) }}" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 font-mono text-emerald-600">
                            </div>
                            <div>
                                <label class="block text-[11px] text-rose-600 mb-1">হার (Lost)</label>
                                <input type="number" min="0" name="matches_lost" value="{{ old('matches_lost', $team->matches_lost) }}" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 font-mono text-rose-600">
                            </div>
                            <div>
                                <label class="block text-[11px] text-amber-600 mb-1">ড্র/টাই</label>
                                <input type="number" min="0" name="matches_drawn" value="{{ old('matches_drawn', $team->matches_drawn) }}" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 font-mono text-amber-600">
                            </div>
                            <div>
                                <label class="block text-[11px] text-blue-600 mb-1">পয়েন্ট</label>
                                <input type="number" min="0" name="points" value="{{ old('points', $team->points) }}" class="w-full rounded-xl text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 font-mono text-blue-600 font-bold">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">দলের বিবরণ ও পরিচিতি</label>
                        <textarea name="description" rows="3" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">{{ old('description', $team->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">স্ট্যাটাস *</label>
                        <select name="status" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                            <option value="active" {{ old('status', $team->status) == 'active' ? 'selected' : '' }}>সক্রিয় (Active)</option>
                            <option value="inactive" {{ old('status', $team->status) == 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয় (Inactive)</option>
                        </select>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('admin.teams.show', $team) }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-semibold">
                            বাতিল
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow transition">
                            আপডেট সংরক্ষণ করুন &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 300x300 Cropper Modal Dialog -->
    <div id="cropper-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm hidden">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-blue-500 text-lg">✂️</span>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">টিম লোগো ক্রপ করুন (৩০০ × ৩০০ পিক্সেল)</h3>
                    </div>
                </div>
                <button type="button" id="cropper-close-btn" class="text-gray-400 hover:text-gray-600 dark:hover:text-white text-xl font-bold">&times;</button>
            </div>

            <div class="p-4 flex-1 overflow-hidden flex items-center justify-center bg-gray-100 dark:bg-gray-900">
                <div class="max-h-[50vh] max-w-full">
                    <img id="cropper-image" src="" alt="Crop Image" class="max-w-full block">
                </div>
            </div>

            <div class="px-4 py-2.5 bg-gray-50 dark:bg-gray-900/60 border-t border-gray-200 dark:border-gray-700 flex flex-wrap items-center justify-center gap-2 text-xs">
                <button type="button" id="crop-zoom-in" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">🔍+ জুম ইন</button>
                <button type="button" id="crop-zoom-out" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">🔍- জুম আউট</button>
                <button type="button" id="crop-rotate-left" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">↺ ৯০° বামে</button>
                <button type="button" id="crop-rotate-right" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">↻ ৯০° ডানে</button>
                <button type="button" id="crop-reset" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">⟲ রিসেট</button>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <button type="button" id="crop-cancel-btn" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600">বাতিল</button>
                <button type="button" id="crop-confirm-btn" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow flex items-center gap-1.5">
                    <span>✓ ৩০০×৩০০ সাইজে সংরক্ষণ করুন</span>
                </button>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/cropperjs/cropper.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('vendor/cropperjs/cropper.min.js') }}"></script>
        <script>
            let cropper = null;
            const logoInput = document.getElementById('team-logo-input');
            const cropperModal = document.getElementById('cropper-modal');
            const cropperImage = document.getElementById('cropper-image');
            const croppedLogoInput = document.getElementById('team-cropped-logo');
            const previewImg = document.getElementById('team-logo-preview');
            const placeholder = document.getElementById('team-logo-placeholder');
            const cropBadge = document.getElementById('team-crop-badge');

            logoInput.addEventListener('change', function(e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    const file = files[0];
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        cropperImage.src = evt.target.result;
                        cropperModal.classList.remove('hidden');
                        if (cropper) {
                            cropper.destroy();
                        }
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 1,
                            viewMode: 1,
                            dragMode: 'move',
                            autoCropArea: 0.9,
                            restore: false,
                            guides: true,
                            center: true,
                            highlight: false,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            toggleDragModeOnDblclick: false,
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });

            document.getElementById('crop-zoom-in').addEventListener('click', () => cropper && cropper.zoom(0.1));
            document.getElementById('crop-zoom-out').addEventListener('click', () => cropper && cropper.zoom(-0.1));
            document.getElementById('crop-rotate-left').addEventListener('click', () => cropper && cropper.rotate(-90));
            document.getElementById('crop-rotate-right').addEventListener('click', () => cropper && cropper.rotate(90));
            document.getElementById('crop-reset').addEventListener('click', () => cropper && cropper.reset());

            function closeCropper() {
                cropperModal.classList.add('hidden');
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            }
            document.getElementById('cropper-close-btn').addEventListener('click', closeCropper);
            document.getElementById('crop-cancel-btn').addEventListener('click', closeCropper);

            document.getElementById('crop-confirm-btn').addEventListener('click', function() {
                if (!cropper) return;
                const canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                const base64Url = canvas.toDataURL('image/png');
                croppedLogoInput.value = base64Url;
                previewImg.src = base64Url;
                previewImg.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
                if (cropBadge) cropBadge.classList.remove('hidden');

                closeCropper();
            });
        </script>
    @endpush
</x-app-layout>


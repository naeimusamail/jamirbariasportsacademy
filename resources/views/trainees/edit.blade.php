<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                {{ __('ট্রেইনি তথ্য পরিবর্তন (Edit Trainee)') }}
            </h2>
            <a href="{{ route('trainees.show', $trainee) }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                &larr; প্রোফাইলে ফিরুন
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

                <form method="POST" action="{{ route('trainees.update', $trainee) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="border-b border-gray-100 dark:border-gray-700 pb-4">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">১. প্রাথমিক ও ব্যক্তিগত তথ্য</h3>
                    </div>

                    <!-- Photo Upload with 300x300 Cropper -->
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center gap-5">
                        <div class="relative group">
                            <div class="w-28 h-28 rounded-xl bg-gray-200 dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                                @if($trainee->photo)
                                    <img id="trainee-edit-preview" src="{{ asset('storage/' . $trainee->photo) }}" alt="Photo" class="w-full h-full object-cover">
                                @else
                                    <img id="trainee-edit-preview" src="" alt="Photo" class="w-full h-full object-cover hidden">
                                    <span id="trainee-edit-placeholder" class="text-gray-400 text-xs text-center px-1">ছবি নেই</span>
                                @endif
                            </div>
                            <span id="trainee-edit-badge" class="hidden absolute -bottom-2 -right-2 bg-emerald-500 text-white font-bold text-[10px] px-2 py-0.5 rounded-full shadow">✓ 300×300</span>
                        </div>
                        <div class="flex-1 w-full space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">প্লেয়ারের ছবি পরিবর্তন করুন (Photo)</label>
                                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-full">৩০০ × ৩০০ পিক্সেল (১:১)</span>
                            </div>
                            <input type="file" name="photo" id="trainee-edit-input" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/10 file:text-emerald-600 dark:file:text-emerald-400 hover:file:bg-emerald-500/20 cursor-pointer">
                            <input type="hidden" name="cropped_photo" id="trainee-edit-cropped-photo">
                            <p class="text-[11px] text-gray-400">নতুন ছবি বাছাই করার পর পপআপে জুম ও রোটেট করে সঠিক ৩০০×৩০০ মাপে কেটে নিতে পারবেন।</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ভর্তি নম্বর *</label>
                            <input type="text" name="admission_no" value="{{ old('admission_no', $trainee->admission_no) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-mono">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">প্লেয়ারের পূর্ণ নাম *</label>
                            <input type="text" name="name" value="{{ old('name', $trainee->name) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">পিতা / অভিভাবকের নাম *</label>
                            <input type="text" name="guardian_name" value="{{ old('guardian_name', $trainee->guardian_name) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">যোগাযোগের মোবাইল নম্বর *</label>
                            <input type="text" name="phone" value="{{ old('phone', $trainee->phone) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">জরুরি যোগাযোগ নম্বর</label>
                            <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $trainee->emergency_phone) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">জন্ম তারিখ</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $trainee->date_of_birth) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">রক্তের গ্রুপ</label>
                            <select name="blood_group" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="">নির্বাচন করুন</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group', $trainee->blood_group) == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">জাতীয় পরিচয়পত্র / জন্মনিবন্ধন নং (NID / Birth Cert)</label>
                            <input type="text" name="nid_or_birth_cert" value="{{ old('nid_or_birth_cert', $trainee->nid_or_birth_cert) }}" placeholder="১০ বা ১৭ ডিজিট" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm font-mono">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ঠিকানা</label>
                            <input type="text" name="address" value="{{ old('address', $trainee->address) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>
                    </div>

                    <div class="border-b border-gray-100 dark:border-gray-700 pb-4 pt-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white">২. খেলা ও একাডেমি তথ্য</h3>
                                <p class="text-xs text-gray-400">খেলোয়াড়ের খেলাসমূহ নির্বাচন ও পরিবর্তন করুন (মাল্টি-স্পোর্টস সাপোর্টেড)</p>
                            </div>
                            <span class="self-start sm:self-auto px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                ✓ মাল্টি-স্পোর্টস সাপোর্টেড
                            </span>
                        </div>
                    </div>

                    <!-- Multi-Sport Selection Cards -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            প্রশিক্ষণ খেলাসমূহ (এক বা একাধিক খেলা নির্বাচন করুন) *
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($sports as $sp)
                                @php
                                    $isChecked = is_array(old('sports')) 
                                        ? in_array($sp->id, old('sports')) 
                                        : $trainee->hasSport($sp->id);
                                @endphp
                                <label class="relative flex flex-col p-3 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-emerald-500 cursor-pointer bg-gray-50/50 dark:bg-gray-900/50 transition has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/40 dark:has-[:checked]:bg-emerald-950/20">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-2xl">{{ $sp->icon ?? '⚽' }}</span>
                                        <input type="checkbox" name="sports[]" value="{{ $sp->id }}" {{ $isChecked ? 'checked' : '' }} class="rounded text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                    </div>
                                    <span class="font-bold text-xs text-gray-900 dark:text-white">{{ $sp->name }}</span>
                                    @if($trainee->sport_id == $sp->id)
                                        <span class="mt-1 text-[9px] font-bold text-emerald-600">★ প্রধান খেলা</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ট্রেনিং ব্যাচ (Batch)</label>
                            <select name="batch_id" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="">কোনো ব্যাচ নেই</option>
                                @foreach($batches as $b)
                                    <option value="{{ $b->id }}" {{ old('batch_id', $trainee->batch_id) == $b->id ? 'selected' : '' }}>{{ $b->name }} ({{ $b->time_slot }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">বয়সভিত্তিক ক্যাটাগরি *</label>
                            <select name="category" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                @foreach(['U-12', 'U-14', 'U-16', 'U-19', 'Senior'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $trainee->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">খেলার পজিশন</label>
                            <input type="text" name="position" value="{{ old('position', $trainee->position) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">জার্সি নম্বর</label>
                            <input type="text" name="jersey_no" value="{{ old('jersey_no', $trainee->jersey_no) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">মাসিক প্রশিক্ষণ ফি *</label>
                            <input type="number" step="50" name="monthly_fee" value="{{ old('monthly_fee', $trainee->monthly_fee) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">ভর্তির তারিখ *</label>
                            <input type="date" name="admission_date" value="{{ old('admission_date', $trainee->admission_date) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">স্ট্যাটাস *</label>
                            <select name="status" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm">
                                <option value="active" {{ old('status', $trainee->status) == 'active' ? 'selected' : '' }}>সক্রিয়</option>
                                <option value="inactive" {{ old('status', $trainee->status) == 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <div>
                            <!-- Delete form trigger handled separately or below -->
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('trainees.show', $trainee) }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-semibold">
                                বাতিল
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow transition">
                                আপডেট সংরক্ষণ করুন
                            </button>
                        </div>
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
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">ছবি ক্রপ করুন (৩০০ × ৩০০ পিক্সেল)</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">প্রয়োজনমতো জুম বা রোটেট করে সঠিক পজিশনে আনুন</p>
                    </div>
                </div>
                <button type="button" id="cropper-close-btn" class="text-gray-400 hover:text-gray-600 dark:hover:text-white text-xl font-bold">&times;</button>
            </div>

            <!-- Cropping Workspace -->
            <div class="p-4 flex-1 overflow-hidden flex items-center justify-center bg-gray-100 dark:bg-gray-900">
                <div class="max-h-[50vh] max-w-full">
                    <img id="cropper-image" src="" alt="Crop Image" class="max-w-full block">
                </div>
            </div>

            <!-- Cropper Controls Toolbar -->
            <div class="px-4 py-2.5 bg-gray-50 dark:bg-gray-900/60 border-t border-gray-200 dark:border-gray-700 flex flex-wrap items-center justify-center gap-2 text-xs">
                <button type="button" id="crop-zoom-in" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">🔍+ জুম ইন</button>
                <button type="button" id="crop-zoom-out" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">🔍- জুম আউট</button>
                <button type="button" id="crop-rotate-left" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">↺ ৯০° বামে</button>
                <button type="button" id="crop-rotate-right" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">↻ ৯০° ডানে</button>
                <button type="button" id="crop-reset" class="px-3 py-1.5 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-300">⟲ রিসেট</button>
            </div>

            <!-- Modal Action Buttons -->
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
            const photoInput = document.getElementById('trainee-edit-input');
            const cropperModal = document.getElementById('cropper-modal');
            const cropperImage = document.getElementById('cropper-image');
            const croppedPhotoInput = document.getElementById('trainee-edit-cropped-photo');
            const previewImg = document.getElementById('trainee-edit-preview');
            const placeholder = document.getElementById('trainee-edit-placeholder');
            const cropBadge = document.getElementById('trainee-edit-badge');

            photoInput.addEventListener('change', function(e) {
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
                            aspectRatio: 1, // 1:1 square
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

            // Controls
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

            // Confirm Crop & Generate 300x300 Output
            document.getElementById('crop-confirm-btn').addEventListener('click', function() {
                if (!cropper) return;
                const canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                const base64Url = canvas.toDataURL('image/jpeg', 0.92);
                croppedPhotoInput.value = base64Url;
                previewImg.src = base64Url;
                previewImg.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
                if (cropBadge) cropBadge.classList.remove('hidden');

                closeCropper();
            });
        </script>
    @endpush
</x-app-layout>


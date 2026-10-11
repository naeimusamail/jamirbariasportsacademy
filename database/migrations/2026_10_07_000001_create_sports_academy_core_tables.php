<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Sports / Disciplines
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->default('⚽');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Coaches
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->nullable()->constrained('sports')->nullOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('designation')->default('ট্রেইনার'); // হেড কোচ / সহকারী কোচ
            $table->string('experience')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // 3. Batches
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->constrained('sports')->cascadeOnDelete();
            $table->foreignId('coach_id')->nullable()->constrained('coaches')->nullOnDelete();
            $table->string('name'); // e.g. ফুটবল মর্নিং ব্যাচ
            $table->string('days'); // e.g. শনি, সোম, বুধ
            $table->string('time_slot'); // e.g. সকাল ৭:০০ - ৮:৩০
            $table->string('ground')->default('প্রধান মাঠ');
            $table->integer('capacity')->default(30);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // 4. Trainees / Players
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->string('admission_no')->unique(); // JSA-2026-001
            $table->foreignId('sport_id')->constrained('sports')->cascadeOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('batches')->nullOnDelete();
            $table->string('name');
            $table->string('guardian_name');
            $table->string('phone');
            $table->string('emergency_phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->enum('category', ['U-12', 'U-14', 'U-16', 'U-19', 'Senior'])->default('U-16');
            $table->string('position')->nullable(); // স্ট্রাইকার, স্পিনার, ইত্যাদি
            $table->string('jersey_no')->nullable();
            $table->text('address')->nullable();
            $table->decimal('monthly_fee', 10, 2)->default(1000.00);
            $table->date('admission_date')->default(now());
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // 5. Attendances
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->unique(['trainee_id', 'batch_id', 'date']);
        });

        // 6. Payments / Fee Collections
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique(); // INV-2026-001
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
            $table->string('title'); // মার্চ মাসের মাসিক ফি / ভর্তি ফি
            $table->enum('fee_type', ['monthly', 'admission', 'jersey', 'tournament', 'other'])->default('monthly');
            $table->decimal('amount', 10, 2);
            $table->string('month')->nullable(); // জানুয়ারি, ফেব্রুয়ারি...
            $table->string('year', 4)->default('2026');
            $table->enum('payment_method', ['cash', 'bkash', 'nagad', 'bank'])->default('cash');
            $table->enum('status', ['paid', 'due'])->default('paid');
            $table->date('payment_date')->default(now());
            $table->string('note')->nullable();
            $table->timestamps();
        });

        // 7. Notices
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->nullable()->constrained('sports')->nullOnDelete();
            $table->string('title');
            $table->text('content');
            $table->date('notice_date')->default(now());
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('trainees');
        Schema::dropIfExists('batches');
        Schema::dropIfExists('coaches');
        Schema::dropIfExists('sports');
    }
};


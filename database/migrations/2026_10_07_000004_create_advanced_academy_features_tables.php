<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Photo in trainees table (check if column exists first or add)
        if (!Schema::hasColumn('trainees', 'photo')) {
            Schema::table('trainees', function (Blueprint $table) {
                $table->string('photo')->nullable()->after('address');
            });
        }

        // 2. Online Admission Applications
        Schema::create('admission_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->unique(); // APP-2026-001
            $table->foreignId('sport_id')->constrained('sports')->cascadeOnDelete();
            $table->string('name');
            $table->string('guardian_name');
            $table->string('phone');
            $table->string('emergency_phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->enum('category', ['U-12', 'U-14', 'U-16', 'U-19', 'Senior'])->default('U-16');
            $table->string('position')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('trainee_id')->nullable()->constrained('trainees')->nullOnDelete();
            $table->timestamps();
        });

        // 3. Player Fitness & Performance Records
        Schema::create('fitness_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
            $table->date('test_date');
            $table->decimal('height_cm', 5, 2)->nullable(); // e.g. 165.5 cm
            $table->decimal('weight_kg', 5, 2)->nullable(); // e.g. 58.0 kg
            $table->decimal('bmi', 4, 1)->nullable();
            $table->decimal('sprint_100m_sec', 4, 2)->nullable(); // 100m sprint time
            $table->string('yoyo_score')->nullable(); // Yo-Yo / Beep test score
            $table->enum('stamina_level', ['Excellent', 'Good', 'Average', 'Needs Improvement'])->default('Good');
            $table->integer('matches_played')->default(0);
            $table->integer('goals_or_runs')->default(0); // ফুটবল: গোল, ক্রিকেট: রান
            $table->integer('wickets_or_assists')->default(0); // ফুটবল: অ্যাসিস্ট, ক্রিকেট: উইকেট
            $table->integer('coach_rating')->default(4); // ১ থেকে ৫ স্টার
            $table->text('coach_remarks')->nullable();
            $table->timestamps();
        });

        // 4. Academy Expenses & Accounts
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no')->unique(); // EXP-2026-001
            $table->string('title'); // e.g. নতুন ফুটবল কিট ও ১০টি বল ক্রয়
            $table->string('category', 60)->default('sports_gear');
            $table->decimal('amount', 10, 2);
            $table->date('expense_date');
            $table->enum('payment_method', ['cash', 'bkash', 'nagad', 'bank'])->default('cash');
            $table->string('paid_to')->nullable(); // কাকে দেওয়া হয়েছে
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('fitness_records');
        Schema::dropIfExists('admission_applications');
    }
};


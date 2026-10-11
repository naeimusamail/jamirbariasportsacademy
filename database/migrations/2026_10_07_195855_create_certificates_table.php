<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_no')->unique();
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
            $table->foreignId('sport_id')->nullable()->constrained('sports')->nullOnDelete();
            $table->string('title');
            $table->string('certificate_type')->default('completion'); // completion, achievement, participation, appreciation
            $table->string('event_or_course')->nullable();
            $table->date('issue_date');
            $table->text('description')->nullable();
            $table->string('grade_or_rank')->nullable();
            $table->string('instructor_name')->default('পরিচালক ও প্রধান প্রশিক্ষক');
            $table->string('status')->default('issued'); // issued, revoked
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

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
        Schema::create('training_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches')->cascadeOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('batches')->nullOnDelete();
            $table->foreignId('trainee_id')->nullable()->constrained('trainees')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('sport_type')->default('ফুটবল');
            $table->string('drill_category')->default('fitness'); // fitness, tactical, technical, recovery
            $table->date('due_date');
            $table->string('priority')->default('normal'); // high, normal, low
            $table->string('status')->default('pending'); // pending, completed, reviewed
            $table->text('player_note')->nullable();
            $table->integer('coach_score')->nullable(); // 1 to 10
            $table->text('coach_feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_tasks');
    }
};

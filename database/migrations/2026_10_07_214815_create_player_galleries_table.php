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
        Schema::create('player_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
            $table->foreignId('team_player_id')->nullable()->constrained('team_players')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path');
            $table->enum('category', ['match_action', 'training', 'celebration', 'promo', 'other'])->default('match_action');
            $table->string('match_name')->nullable();
            $table->date('event_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_galleries');
    }
};

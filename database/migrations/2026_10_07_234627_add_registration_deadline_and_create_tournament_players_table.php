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
        if (!Schema::hasColumn('tournaments', 'registration_deadline')) {
            Schema::table('tournaments', function (Blueprint $table) {
                $table->dateTime('registration_deadline')->nullable()->after('end_date');
            });
        }

        if (!Schema::hasTable('tournament_players')) {
            Schema::create('tournament_players', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('trainee_id')->nullable()->constrained('trainees')->nullOnDelete();
                $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
                $table->string('player_name');
                $table->string('player_phone');
                $table->string('position')->nullable();
                $table->string('jersey_no', 10)->nullable();
                $table->string('status', 30)->default('registered'); // registered, assigned, confirmed
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_players');

        if (Schema::hasColumn('tournaments', 'registration_deadline')) {
            Schema::table('tournaments', function (Blueprint $table) {
                $table->dropColumn('registration_deadline');
            });
        }
    }
};

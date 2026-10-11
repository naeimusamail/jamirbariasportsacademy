<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Teams Table
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name', 10)->nullable();
            $table->string('slug')->unique();
            $table->foreignId('sport_id')->nullable()->constrained('sports')->nullOnDelete();
            $table->string('sport_type', 50)->default('cricket');
            $table->string('category', 50)->default('Senior');
            $table->string('logo')->nullable();
            $table->string('coach_name')->nullable();
            $table->string('captain_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('matches_played')->default(0);
            $table->integer('matches_won')->default(0);
            $table->integer('matches_lost')->default(0);
            $table->integer('matches_drawn')->default(0);
            $table->integer('points')->default(0);
            $table->string('status', 20)->default('active');
            $table->timestamps();
        });

        // 2. Team Players Table
        Schema::create('team_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('trainee_id')->nullable()->constrained('trainees')->nullOnDelete();
            $table->string('name');
            $table->string('jersey_no', 10)->nullable();
            $table->string('role', 100)->default('All-Rounder');
            $table->string('batting_style', 100)->nullable();
            $table->string('bowling_style', 100)->nullable();
            $table->boolean('is_captain')->default(false);
            $table->boolean('is_vice_captain')->default(false);
            $table->string('photo')->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamps();
        });

        // 3. Match Player Stats / Cricinfo Scorecard Table
        Schema::create('match_player_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_match_id')->constrained('live_matches')->cascadeOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('team_player_id')->constrained('team_players')->cascadeOnDelete();
            $table->integer('inning')->default(1);
            $table->integer('batting_order')->default(0);
            $table->string('dismissal_type', 100)->default('not out');
            $table->integer('runs_scored')->default(0);
            $table->integer('balls_faced')->default(0);
            $table->integer('fours')->default(0);
            $table->integer('sixes')->default(0);
            $table->decimal('strike_rate', 6, 2)->default(0.00);
            
            // Bowling stats
            $table->decimal('overs_bowled', 4, 1)->default(0.0);
            $table->integer('maidens')->default(0);
            $table->integer('runs_conceded')->default(0);
            $table->integer('wickets_taken')->default(0);
            $table->decimal('economy_rate', 5, 2)->default(0.00);
            $table->integer('dots')->default(0);

            // Fielding & Football stats
            $table->integer('catches')->default(0);
            $table->integer('run_outs')->default(0);
            $table->integer('stumpings')->default(0);
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->boolean('is_player_of_match')->default(false);
            $table->timestamps();
        });

        // 4. Enhance live_matches with team links & match summary info
        Schema::table('live_matches', function (Blueprint $table) {
            $table->foreignId('team_a_id')->nullable()->after('team_a')->constrained('teams')->nullOnDelete();
            $table->foreignId('team_b_id')->nullable()->after('team_b')->constrained('teams')->nullOnDelete();
            $table->string('toss_winner')->nullable()->after('venue');
            $table->string('toss_decision', 20)->nullable()->after('toss_winner');
            $table->string('match_result')->nullable()->after('toss_decision');
            $table->string('player_of_match')->nullable()->after('match_result');
        });
    }

    public function down(): void
    {
        Schema::table('live_matches', function (Blueprint $table) {
            $table->dropForeign(['team_a_id']);
            $table->dropForeign(['team_b_id']);
            $table->dropColumn(['team_a_id', 'team_b_id', 'toss_winner', 'toss_decision', 'match_result', 'player_of_match']);
        });

        Schema::dropIfExists('match_player_stats');
        Schema::dropIfExists('team_players');
        Schema::dropIfExists('teams');
    }
};


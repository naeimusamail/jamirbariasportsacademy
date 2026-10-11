<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Allow any sport type in live_matches
        Schema::table('live_matches', function (Blueprint $table) {
            $table->string('sport_type', 50)->default('football')->change();
        });

        // 2. Add multi-sport stats to match_player_stats
        Schema::table('match_player_stats', function (Blueprint $table) {
            $table->integer('yellow_cards')->default(0)->after('assists');
            $table->integer('red_cards')->default(0)->after('yellow_cards');
            $table->integer('minutes_played')->default(0)->after('red_cards');
            $table->boolean('clean_sheet')->default(false)->after('minutes_played');
            $table->integer('sets_won')->default(0)->after('clean_sheet');
            $table->integer('points_scored')->default(0)->after('sets_won');
            $table->string('timing_record', 50)->nullable()->after('points_scored');
            $table->string('position_rank', 100)->nullable()->after('timing_record');
        });

        // 3. Add position to team_players for non-cricket sports
        Schema::table('team_players', function (Blueprint $table) {
            $table->string('position', 100)->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('team_players', function (Blueprint $table) {
            $table->dropColumn('position');
        });

        Schema::table('match_player_stats', function (Blueprint $table) {
            $table->dropColumn([
                'yellow_cards',
                'red_cards',
                'minutes_played',
                'clean_sheet',
                'sets_won',
                'points_scored',
                'timing_record',
                'position_rank',
            ]);
        });
    }
};


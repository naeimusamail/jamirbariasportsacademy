<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update Trainees table for Local Players support
        Schema::table('trainees', function (Blueprint $table) {
            if (!Schema::hasColumn('trainees', 'player_type')) {
                $table->enum('player_type', ['academic', 'local'])->default('academic')->after('admission_no');
            }
            if (!Schema::hasColumn('trainees', 'nid_or_birth_cert')) {
                $table->string('nid_or_birth_cert')->nullable()->after('blood_group');
            }
            if (!Schema::hasColumn('trainees', 'organization_or_area')) {
                $table->string('organization_or_area')->nullable()->after('address'); // এলাকা / ক্লাব / পাড়া
            }
        });

        // 2. Tournaments Table (Academic & Local)
        if (!Schema::hasTable('tournaments')) {
            Schema::create('tournaments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->enum('tournament_type', ['academic', 'local'])->default('academic'); // একাডেমি vs লোকাল টুর্নামেন্ট
                $table->foreignId('sport_id')->nullable()->constrained('sports')->nullOnDelete();
                $table->string('sport_type', 50)->default('football');
                $table->string('banner')->nullable();
                $table->string('venue')->default('জামিরবাড়িয়া প্রধান স্পোর্টস গ্রাউন্ড');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->decimal('entry_fee', 10, 2)->default(0);
                $table->string('prize_pool')->nullable(); // e.g. "চ্যাম্পিয়ন ৳৫০,০০০ + ট্রফি"
                $table->integer('total_teams')->default(8);
                $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');
                $table->text('rules')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 3. Tournament Teams Pivot / Standings
        if (!Schema::hasTable('tournament_teams')) {
            Schema::create('tournament_teams', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
                $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
                $table->string('group_name', 20)->default('গ্রুপ ক'); // Group A, Group B
                $table->integer('matches_played')->default(0);
                $table->integer('won')->default(0);
                $table->integer('lost')->default(0);
                $table->integer('drawn')->default(0);
                $table->integer('points')->default(0);
                $table->timestamps();
            });
        }

        // 4. Update Live Matches Table to link Tournaments
        Schema::table('live_matches', function (Blueprint $table) {
            if (!Schema::hasColumn('live_matches', 'tournament_id')) {
                $table->foreignId('tournament_id')->nullable()->after('sport_type')->constrained('tournaments')->nullOnDelete();
            }
            if (!Schema::hasColumn('live_matches', 'tournament_type')) {
                $table->enum('tournament_type', ['academic', 'local'])->default('academic')->after('tournament_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('live_matches', function (Blueprint $table) {
            if (Schema::hasColumn('live_matches', 'tournament_id')) {
                $table->dropForeign(['tournament_id']);
                $table->dropColumn('tournament_id');
            }
            if (Schema::hasColumn('live_matches', 'tournament_type')) {
                $table->dropColumn('tournament_type');
            }
        });

        Schema::dropIfExists('tournament_teams');
        Schema::dropIfExists('tournaments');

        Schema::table('trainees', function (Blueprint $table) {
            if (Schema::hasColumn('trainees', 'player_type')) {
                $table->dropColumn('player_type');
            }
            if (Schema::hasColumn('trainees', 'nid_or_birth_cert')) {
                $table->dropColumn('nid_or_birth_cert');
            }
            if (Schema::hasColumn('trainees', 'organization_or_area')) {
                $table->dropColumn('organization_or_area');
            }
        });
    }
};

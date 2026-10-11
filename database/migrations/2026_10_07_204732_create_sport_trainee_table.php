<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sport_trainee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainee_id')->constrained('trainees')->onDelete('cascade');
            $table->foreignId('sport_id')->constrained('sports')->onDelete('cascade');
            $table->string('position')->nullable();
            $table->string('jersey_no')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->unique(['trainee_id', 'sport_id']);
        });

        // Add sports_applied to admission_applications for multi-sport applications
        if (Schema::hasTable('admission_applications') && !Schema::hasColumn('admission_applications', 'sports_applied')) {
            Schema::table('admission_applications', function (Blueprint $table) {
                $table->json('sports_applied')->nullable()->after('sport_id');
            });
        }

        // Automatically populate sport_trainee from existing trainees
        $trainees = DB::table('trainees')->whereNotNull('sport_id')->get();
        $now = now();
        foreach ($trainees as $t) {
            DB::table('sport_trainee')->insertOrIgnore([
                'trainee_id' => $t->id,
                'sport_id' => $t->sport_id,
                'position' => $t->position,
                'jersey_no' => $t->jersey_no,
                'is_primary' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('admission_applications') && Schema::hasColumn('admission_applications', 'sports_applied')) {
            Schema::table('admission_applications', function (Blueprint $table) {
                $table->dropColumn('sports_applied');
            });
        }
        Schema::dropIfExists('sport_trainee');
    }
};

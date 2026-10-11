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
        Schema::table('admission_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('admission_applications', 'name_en')) {
                $table->string('name_en')->nullable()->after('name');
            }
        });

        Schema::table('trainees', function (Blueprint $table) {
            if (!Schema::hasColumn('trainees', 'name_en')) {
                $table->string('name_en')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_applications', function (Blueprint $table) {
            if (Schema::hasColumn('admission_applications', 'name_en')) {
                $table->dropColumn('name_en');
            }
        });

        Schema::table('trainees', function (Blueprint $table) {
            if (Schema::hasColumn('trainees', 'name_en')) {
                $table->dropColumn('name_en');
            }
        });
    }
};

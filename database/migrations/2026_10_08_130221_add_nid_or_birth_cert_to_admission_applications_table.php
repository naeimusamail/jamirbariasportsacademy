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
            if (!Schema::hasColumn('admission_applications', 'nid_or_birth_cert')) {
                $table->string('nid_or_birth_cert')->nullable()->after('blood_group');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_applications', function (Blueprint $table) {
            if (Schema::hasColumn('admission_applications', 'nid_or_birth_cert')) {
                $table->dropColumn('nid_or_birth_cert');
            }
        });
    }
};

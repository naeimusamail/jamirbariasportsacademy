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
            if (!Schema::hasColumn('admission_applications', 'organization_or_area')) {
                $table->string('organization_or_area')->nullable()->after('address');
            }
            if (!Schema::hasColumn('admission_applications', 'jersey_no')) {
                $table->string('jersey_no')->nullable()->after('position');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_applications', function (Blueprint $table) {
            if (Schema::hasColumn('admission_applications', 'organization_or_area')) {
                $table->dropColumn('organization_or_area');
            }
            if (Schema::hasColumn('admission_applications', 'jersey_no')) {
                $table->dropColumn('jersey_no');
            }
        });
    }
};

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
        // 1. Drop unique constraint on `type` in registration_circulars to allow multiple circulars of same type (e.g. multiple admission sessions)
        Schema::table('registration_circulars', function (Blueprint $table) {
            // Drop unique index if it exists
            $table->dropUnique('registration_circulars_type_unique');
            $table->index('type');
            $table->decimal('fee', 10, 2)->nullable()->after('description');
        });

        // 2. Add registration_circular_id to admission_applications table
        Schema::table('admission_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('registration_circular_id')->nullable()->after('application_no');
            $table->foreign('registration_circular_id')
                ->references('id')
                ->on('registration_circulars')
                ->nullOnDelete();
        });

        // 3. Backfill existing applications with current admission circular
        $admissionCircularId = DB::table('registration_circulars')->where('type', 'admission')->value('id');
        if ($admissionCircularId) {
            DB::table('admission_applications')
                ->whereNull('registration_circular_id')
                ->update(['registration_circular_id' => $admissionCircularId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_applications', function (Blueprint $table) {
            $table->dropForeign(['registration_circular_id']);
            $table->dropColumn('registration_circular_id');
        });

        Schema::table('registration_circulars', function (Blueprint $table) {
            $table->dropColumn('fee');
            $table->dropIndex(['type']);
            $table->unique('type');
        });
    }
};

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
        Schema::table('live_matches', function (Blueprint $table) {
            $table->foreignId('scorer_id')->nullable()->after('scorer_code')->constrained('users')->nullOnDelete();
            $table->string('scorer_name')->nullable()->after('scorer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_matches', function (Blueprint $table) {
            $table->dropConstrainedForeignId('scorer_id');
            $table->dropColumn('scorer_name');
        });
    }
};

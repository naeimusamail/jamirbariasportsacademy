<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('live_matches', function (Blueprint $table) {
            $table->boolean('is_official')->default(false)->after('sport_type'); // একাডেমি অফিশিয়াল ম্যাচ কিনা
        });
    }

    public function down(): void
    {
        Schema::table('live_matches', function (Blueprint $table) {
            $table->dropColumn('is_official');
        });
    }
};


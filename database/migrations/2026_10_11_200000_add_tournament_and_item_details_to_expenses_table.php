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
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('tournament_id')->nullable()->after('voucher_no');
            $table->unsignedBigInteger('volunteer_id')->nullable()->after('tournament_id');
            $table->string('item_name')->nullable()->after('title');
            $table->decimal('unit_price', 10, 2)->nullable()->after('item_name');
            $table->decimal('quantity', 10, 2)->default(1)->after('unit_price');
            $table->string('receipt_photo')->nullable()->after('note');

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['tournament_id']);
            $table->dropForeign(['volunteer_id']);
            $table->dropColumn([
                'tournament_id',
                'volunteer_id',
                'item_name',
                'unit_price',
                'quantity',
                'receipt_photo',
            ]);
        });
    }
};


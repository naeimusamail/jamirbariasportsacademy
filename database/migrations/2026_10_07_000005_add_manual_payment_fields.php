<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add manual payment tracking to payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method', 50)->default('cash')->change();
            $table->string('transaction_id')->nullable()->after('payment_method');
            $table->string('sender_number')->nullable()->after('transaction_id');
            $table->string('received_by')->nullable()->after('sender_number');
        });

        // 2. Add manual payment fields to admission_applications table
        Schema::table('admission_applications', function (Blueprint $table) {
            $table->string('payment_method', 50)->default('cash')->after('photo');
            $table->decimal('payment_amount', 10, 2)->default(1000)->after('payment_method');
            $table->string('transaction_id')->nullable()->after('payment_amount');
            $table->string('sender_number')->nullable()->after('transaction_id');
            $table->string('payment_status', 30)->default('submitted')->after('sender_number');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['transaction_id', 'sender_number', 'received_by']);
        });

        Schema::table('admission_applications', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_amount', 'transaction_id', 'sender_number', 'payment_status']);
        });
    }
};

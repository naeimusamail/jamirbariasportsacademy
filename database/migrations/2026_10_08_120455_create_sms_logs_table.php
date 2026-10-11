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
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_group'); // all, defaulters, batch, custom
            $table->integer('recipient_count')->default(0);
            $table->text('sample_recipients')->nullable();
            $table->text('message');
            $table->integer('sms_parts')->default(1);
            $table->string('gateway_status')->default('simulated'); // delivered, simulated, failed
            $table->foreignId('sent_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};

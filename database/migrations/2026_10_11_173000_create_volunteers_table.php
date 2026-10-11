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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('volunteer_no')->unique(); // e.g. VOL-2026-001
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('phone');
            $table->string('emergency_phone')->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->default('male');
            $table->string('blood_group', 10)->nullable();
            $table->string('tshirt_size', 10)->default('M'); // S, M, L, XL, XXL
            $table->string('department')->default('general'); // ground, media, medical, security, hospitality, technical, general
            $table->string('organization_or_institution')->nullable(); // School / College / Job
            $table->text('address');
            $table->text('experience')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('tournament_id')->nullable()->constrained('tournaments')->nullOnDelete();
            $table->text('assigned_duties')->nullable();
            $table->string('assigned_venue')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected, active
            $table->timestamp('approved_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};


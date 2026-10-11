<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_matches', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title'); // যেমন: জামিরবাড়িয়া চ্যাম্পিয়নশিপ কাপ - ফাইনাল
            $table->enum('sport_type', ['football', 'cricket', 'badminton', 'other'])->default('football');
            $table->string('tournament_name')->nullable();
            
            // Team A
            $table->string('team_a');
            $table->string('team_a_score')->default('0'); // ফুটবল: 2, ক্রিকেট: 145/4 (18.2)
            
            // Team B
            $table->string('team_b');
            $table->string('team_b_score')->default('0'); // ফুটবল: 1, ক্রিকেট: 120/8 (16.0)

            // Live status & summary
            $table->enum('status', ['upcoming', 'live', 'finished'])->default('upcoming');
            $table->string('current_summary')->nullable(); // যেমন: ২য় হাফ চলমান (৭৫ মিনিট) / জয়ের জন্য ১২ বলে ১০ রান দরকার
            $table->string('venue')->default('জামিরবাড়িয়া প্রধান স্পোর্টস গ্রাউন্ড');
            $table->dateTime('match_datetime')->nullable();

            // Live Streaming (YouTube, Facebook, etc.)
            $table->string('stream_url')->nullable(); // YouTube / Facebook video URL
            $table->string('stream_platform')->default('youtube'); // youtube, facebook, custom
            $table->boolean('is_streaming')->default(false);

            // Scorer access & security
            $table->string('scorer_code')->index(); // যে কেউ ম্যাচ বানালে এই কোড বা লিংক দিয়ে স্কোর আপডেট করবে
            $table->string('creator_name')->nullable(); // যে ব্যক্তি ম্যাচ তৈরি করেছেন
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('live_match_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_match_id')->constrained('live_matches')->cascadeOnDelete();
            $table->string('time_marker')->nullable(); // e.g. 25', 12.4 ov
            $table->enum('event_type', ['goal', 'wicket', 'four', 'six', 'card', 'foul', 'substitution', 'commentary', 'break'])->default('commentary');
            $table->string('title')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_match_events');
        Schema::dropIfExists('live_matches');
    }
};


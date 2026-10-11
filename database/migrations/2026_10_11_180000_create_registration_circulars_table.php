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
        Schema::create('registration_circulars', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique(); // admission, volunteer, local_player
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->text('upcoming_message')->nullable();
            $table->text('closed_message')->nullable();
            $table->timestamps();
        });

        // Add registration_start_date to tournaments table if missing
        if (Schema::hasTable('tournaments') && !Schema::hasColumn('tournaments', 'registration_start_date')) {
            Schema::table('tournaments', function (Blueprint $table) {
                $table->dateTime('registration_start_date')->nullable()->after('venue');
            });
        }

        // Seed default circulars
        $now = now();
        $defaults = [
            [
                'type' => 'admission',
                'title' => '২০২৬ শিক্ষাবর্ষে ফুটবল ও ক্রিকেট বিভাগে একাডেমি ভর্তি সার্কুলার',
                'description' => 'জমিরবাড়িয়া স্পোর্টস একাডেমিতে বিভিন্ন বয়সভিত্তিক ক্যাটাগরিতে নিয়মিত প্রশিক্ষণার্থীদের অনলাইন ভর্তি আবেদন ফরম।',
                'is_active' => true,
                'start_date' => null,
                'end_date' => null,
                'upcoming_message' => '২০২৬ শিক্ষাবর্ষের ভর্তি আবেদন প্রক্রিয়া খুব শীঘ্রই শুরু হবে। বিস্তারিত তথ্যের জন্য একাডেমি অফিসের সাথে যোগাযোগ করুন।',
                'closed_message' => '২০২৬ শিক্ষাবর্ষের প্রাথমিক ভর্তি আবেদন সময়সীমা সমাপ্ত হয়েছে। পরবর্তী সার্কুলারের জন্য অপেক্ষা করুন।',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'volunteer',
                'title' => 'একাডেমি ও টুর্নামেন্ট ভলান্টিয়ার (স্বেচ্ছাসেবক) নিয়োগ সার্কুলার',
                'description' => 'জমিরবাড়িয়া স্পোর্টস একাডেমির বাৎসরিক টুর্নামেন্ট ও বিভিন্ন ইভেন্ট সুশৃঙ্খলভাবে পরিচালনার জন্য উদ্যমী ভলান্টিয়ার আহ্বান করা হচ্ছে।',
                'is_active' => true,
                'start_date' => null,
                'end_date' => null,
                'upcoming_message' => 'ভলান্টিয়ার আবেদন প্রক্রিয়া খুব শীঘ্রই শুরু হতে যাচ্ছে। নতুন নোটিশের জন্য যুক্ত থাকুন।',
                'closed_message' => 'স্বেচ্ছাসেবক (ভলান্টিয়ার) আবেদন প্রক্রিয়া বর্তমানে বন্ধ রয়েছে বা নির্ধারিত সময়সীমা সমাপ্ত হয়েছে।',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'local_player',
                'title' => 'উন্মুক্ত লোকাল প্লেয়ার টুর্নামেন্ট ড্রাফট পাস নিবন্ধন',
                'description' => 'ক্লাব ও উন্মুক্ত টুর্নামেন্টে অংশগ্রহণের জন্য স্থানীয় প্রতিভাবান খেলোয়াড়দের ড্রাফট ও ডিজিটাল প্লেয়ার পাসে অন্তর্ভুক্তি।',
                'is_active' => true,
                'start_date' => null,
                'end_date' => null,
                'upcoming_message' => 'লোকাল প্লেয়ার ড্রাফট নিবন্ধন খুব শীঘ্রই শুরু হবে। প্রস্তুতি নিয়ে রাখুন।',
                'closed_message' => 'লোকাল প্লেয়ার টুর্নামেন্ট ড্রাফট নিবন্ধনের সময়সীমা সমাপ্ত হয়েছে।',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('registration_circulars')->insert($defaults);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_circulars');

        if (Schema::hasTable('tournaments') && Schema::hasColumn('tournaments', 'registration_start_date')) {
            Schema::table('tournaments', function (Blueprint $table) {
                $table->dropColumn('registration_start_date');
            });
        }
    }
};


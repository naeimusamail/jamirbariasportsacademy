<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdmissionApplication;
use App\Models\FitnessRecord;
use App\Models\Expense;
use App\Models\Trainee;
use App\Models\Sport;
use Carbon\Carbon;

class AdvancedFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        $football = Sport::where('name', 'like', '%ফুটবল%')->first() ?? Sport::first();
        $cricket = Sport::where('name', 'like', '%ক্রিকেট%')->first() ?? Sport::skip(1)->first() ?? Sport::first();

        // 1. Seed Admission Applications
        if (AdmissionApplication::count() === 0 && $football) {
            AdmissionApplication::create([
                'application_no' => 'APP-2026-001',
                'sport_id' => $football->id,
                'name' => 'সাকিবুল হাসান মাহিম',
                'guardian_name' => 'মো: হাসান জামিল',
                'phone' => '01711223344',
                'emergency_phone' => '01811223344',
                'date_of_birth' => '2012-05-14',
                'blood_group' => 'B+',
                'category' => 'U-14',
                'position' => 'মিডফিল্ডার',
                'address' => 'জামিরবাড়িয়া বাজার সংলগ্ন, ময়মনসিংহ',
                'status' => 'pending',
            ]);

            AdmissionApplication::create([
                'application_no' => 'APP-2026-002',
                'sport_id' => $cricket ? $cricket->id : $football->id,
                'name' => 'রাকিবুল ইসলাম শাওন',
                'guardian_name' => 'মোঃ রফিকুল ইসলাম',
                'phone' => '01912345678',
                'emergency_phone' => '01712345678',
                'date_of_birth' => '2010-08-20',
                'blood_group' => 'O+',
                'category' => 'U-16',
                'position' => 'উইকেটকিপার ব্যাটসম্যান',
                'address' => 'ফুলপুর রোড, জামিরবাড়িয়া',
                'status' => 'pending',
            ]);
        }

        // 2. Seed Fitness Records for Existing Trainees
        $trainees = Trainee::take(5)->get();
        if (FitnessRecord::count() === 0 && $trainees->isNotEmpty()) {
            foreach ($trainees as $index => $trainee) {
                // Test 1 (2 months ago)
                FitnessRecord::create([
                    'trainee_id' => $trainee->id,
                    'test_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                    'height_cm' => 165 + ($index * 2),
                    'weight_kg' => 55 + ($index * 3),
                    'bmi' => round((55 + ($index * 3)) / (( (165 + ($index * 2)) / 100) ** 2), 1),
                    'sprint_100m_sec' => 13.5 - ($index * 0.2),
                    'yoyo_score' => '17.4',
                    'stamina_level' => 'Good',
                    'matches_played' => 3,
                    'goals_or_runs' => 2 + $index,
                    'wickets_or_assists' => 1,
                    'coach_rating' => 4,
                    'coach_remarks' => 'প্রাথমিক টেস্ট সম্পন্ন। গতি সন্তোষজনক, তবে স্ট্যামিনায় আরও মনোযোগ প্রয়োজন।',
                ]);

                // Test 2 (Recent Assessment)
                FitnessRecord::create([
                    'trainee_id' => $trainee->id,
                    'test_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                    'height_cm' => 166 + ($index * 2),
                    'weight_kg' => 56 + ($index * 3),
                    'bmi' => round((56 + ($index * 3)) / (( (166 + ($index * 2)) / 100) ** 2), 1),
                    'sprint_100m_sec' => 12.8 - ($index * 0.2),
                    'yoyo_score' => '18.6',
                    'stamina_level' => 'Excellent',
                    'matches_played' => 7,
                    'goals_or_runs' => 6 + ($index * 2),
                    'wickets_or_assists' => 3,
                    'coach_rating' => 5,
                    'coach_remarks' => 'চমৎকার উন্নতি! স্প্রিন্ট স্পিড উল্লেখযোগ্যভাবে বৃদ্ধি পেয়েছে এবং ট্যাকটিক্যাল ড্রিলসে খুব ভালো করছে।',
                ]);
            }
        }

        // 3. Seed Expenses
        if (Expense::count() === 0) {
            Expense::create([
                'voucher_no' => 'EXP-2026-001',
                'title' => '১০টি প্রফেশনাল ফুটবল ও মার্কার কোণ ক্রয়',
                'category' => 'sports_gear',
                'amount' => 12500,
                'expense_date' => Carbon::now()->subDays(12)->format('Y-m-d'),
                'payment_method' => 'cash',
                'paid_to' => 'অলিম্পিক স্পোর্টস গ্যালারি',
                'note' => 'ক্যাশ মেমো নং: ৮৪৫২',
            ]);

            Expense::create([
                'voucher_no' => 'EXP-2026-002',
                'title' => 'প্রধান গ্রাউন্ড ঘাস ছাঁটাই ও গোলপোস্ট নেট মেরামত',
                'category' => 'ground_maintenance',
                'amount' => 4500,
                'expense_date' => Carbon::now()->subDays(8)->format('Y-m-d'),
                'payment_method' => 'bkash',
                'paid_to' => 'গ্রাউন্ড কর্মী সালাম ও দল',
                'note' => 'bKash TrxID: 9XF78L10',
            ]);

            Expense::create([
                'voucher_no' => 'EXP-2026-003',
                'title' => 'কোচিং স্টাফদের সেপ্টেম্বর মাসের বেতন সম্মানী',
                'category' => 'coach_salary',
                'amount' => 35000,
                'expense_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'payment_method' => 'bank',
                'paid_to' => 'হেড কোচ ও সহকারী কোচবৃন্দ',
                'note' => 'ব্যাংক পে-স্লিপ মাধ্যমে পরিশোধিত',
            ]);

            Expense::create([
                'voucher_no' => 'EXP-2026-004',
                'title' => 'ফ্রেন্ডলি ম্যাচে ট্রেইনিদের নাস্তা ও পানি সরবরাহ',
                'category' => 'refreshment',
                'amount' => 2800,
                'expense_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'payment_method' => 'cash',
                'paid_to' => 'জামিরবাড়িয়া মিষ্টান্ন ভান্ডার',
                'note' => 'ম্যাচ রিফ্রেশমেন্ট বিল',
            ]);
        }
    }
}

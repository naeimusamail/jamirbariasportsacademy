<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certificate;
use App\Models\Trainee;
use App\Models\Sport;
use Carbon\Carbon;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $trainees = Trainee::take(4)->get();
        if ($trainees->isEmpty()) {
            return;
        }

        $football = Sport::where('name', 'like', '%ফুটবল%')->first();
        $cricket = Sport::where('name', 'like', '%ক্রিকেট%')->first();

        // Certificate 1: Completion
        Certificate::firstOrCreate(
            ['certificate_no' => 'JSA-CERT-2026-0001'],
            [
                'trainee_id' => $trainees[0]->id,
                'sport_id' => $trainees[0]->sport_id ?? ($football->id ?? null),
                'title' => 'প্রশিক্ষণ সমাপ্তি ও উচ্চতর ক্রীড়া দক্ষতা সনদপত্র',
                'certificate_type' => 'completion',
                'event_or_course' => 'বেসিক স্পোর্টস স্কিলস ও ফিটনেস প্রোগ্রাম ২০২৬',
                'issue_date' => Carbon::parse('2026-03-15'),
                'description' => 'জামিরবাড়িয়া স্পোর্টস একাডেমির নিয়মিত প্রশিক্ষণ কার্যক্রমে একনিষ্ঠতার সাথে অংশগ্রহণ ও নির্ধারিত ক্রীড়া মডিউল সফলভাবে সমাপ্ত করার স্বীকৃতিস্বরূপ এই সনদপত্র প্রদান করা হলো।',
                'grade_or_rank' => 'এ+ (A+)',
                'instructor_name' => 'পরিচালক ও প্রধান প্রশিক্ষক',
                'status' => 'issued',
            ]
        );

        // Certificate 2: Tournament Champion
        if (isset($trainees[1])) {
            Certificate::firstOrCreate(
                ['certificate_no' => 'JSA-CERT-2026-0002'],
                [
                    'trainee_id' => $trainees[1]->id,
                    'sport_id' => $trainees[1]->sport_id ?? ($cricket->id ?? null),
                    'title' => 'আন্তঃএকাডেমি টুর্নামেন্ট চ্যাম্পিয়ন গৌরব সম্মাননা',
                    'certificate_type' => 'achievement',
                    'event_or_course' => 'স্বাধীনতা কাপ টি-২০ একাডেমি টুর্নামেন্ট ২০২৬',
                    'issue_date' => Carbon::parse('2026-03-26'),
                    'description' => 'জামিরবাড়িয়া স্পোর্টস একাডেমি আয়োজিত টুর্নামেন্টে অসামান্য ক্রীড়াশৈলী ও দলগত নেতৃত্ব প্রদর্শন করে চ্যাম্পিয়ন গৌরব অর্জন করায় এই সম্মাননা পত্র প্রদান করা হলো।',
                    'grade_or_rank' => 'চ্যাম্পিয়ন ট্রফি ও গোল্ড মেডেল',
                    'instructor_name' => 'পরিচালক ও প্রধান প্রশিক্ষক',
                    'status' => 'issued',
                ]
            );
        }

        // Certificate 3: MVP Award
        if (isset($trainees[2])) {
            Certificate::firstOrCreate(
                ['certificate_no' => 'JSA-CERT-2026-0003'],
                [
                    'trainee_id' => $trainees[2]->id,
                    'sport_id' => $trainees[2]->sport_id ?? null,
                    'title' => 'সেরা অল-রাউন্ডার প্লেয়ার অব দ্য টুর্নামেন্ট সম্মাননা',
                    'certificate_type' => 'appreciation',
                    'event_or_course' => 'গ্রীষ্মকালীন ফুটবল সুপার লিগ ২০২৬',
                    'issue_date' => Carbon::parse('2026-04-01'),
                    'description' => 'টুর্নামেন্টে সর্বোত্তম অল-রাউন্ড নৈপুণ্য ও দৃষ্টান্তমূলক ক্রীড়া প্রতিভা প্রদর্শনপূর্বক \'প্লেয়ার অব দ্য টুর্নামেন্ট / শ্রেষ্ঠ খেলোয়াড়\' খেতাব অর্জন করায় এই গৌরবময় সনদপত্র প্রদান করা হলো।',
                    'grade_or_rank' => 'প্লেয়ার অব দ্য টুর্নামেন্ট (MVP)',
                    'instructor_name' => 'পরিচালক ও প্রধান প্রশিক্ষক',
                    'status' => 'issued',
                ]
            );
        }
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sport;
use App\Models\Coach;
use App\Models\Batch;
use App\Models\Trainee;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Notice;

class SportsAcademySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Sports (Standard single names)
        $football = Sport::where('name', 'ফুটবল')->orWhere('name', 'like', 'ফুটবল%')->first()
            ?: Sport::create([
                'name' => 'ফুটবল',
                'icon' => '⚽',
                'description' => 'পেশাদার ফুটবল ড্রিবলিং, পাসিং ও ট্যাকটিক্যাল ট্রেনিং',
            ]);

        $cricket = Sport::where('name', 'ক্রিকেট')->orWhere('name', 'like', 'ক্রিকেট%')->first()
            ?: Sport::create([
                'name' => 'ক্রিকেট',
                'icon' => '🏏',
                'description' => 'ব্যাটিং, পেস ও স্পিন বোলিং এবং নেট প্র্যাকটিস',
            ]);

        $athletics = Sport::where('name', 'অ্যাথলেটিক্স')->orWhere('name', 'like', 'অ্যাথলেটিক্স%')->first()
            ?: Sport::create([
                'name' => 'অ্যাথলেটিক্স',
                'icon' => '🏃',
                'description' => 'স্প্রিন্ট, স্ট্যামিনা ও শারীরিক সক্ষমতা বৃদ্ধি',
            ]);

        $badminton = Sport::where('name', 'ব্যাডমিন্টন')->orWhere('name', 'like', 'ব্যাডমিন্টন%')->first()
            ?: Sport::create([
                'name' => 'ব্যাডমিন্টন',
                'icon' => '🏸',
                'description' => 'স্ম্যাশ, ফুটওয়ার্ক ও ইনডোর কোর্ট প্র্যাকটিস',
            ]);

        // 2. Coaches
        $coach1 = Coach::create([
            'sport_id' => $football->id,
            'name' => 'রফিকুল ইসলাম',
            'phone' => '01712-112233',
            'email' => 'rafiq.coach@jamirbaria.com',
            'designation' => 'প্রধান ফুটবল কোচ',
            'experience' => 'সাবেক জাতীয় দল ও ৮ বছরের একাডেমি কোচিং অভিজ্ঞতা',
            'status' => 'active',
        ]);

        $coach2 = Coach::create([
            'sport_id' => $cricket->id,
            'name' => 'তারেক আহমেদ',
            'phone' => '01819-445566',
            'email' => 'tarek.cricket@jamirbaria.com',
            'designation' => 'লেভেল-২ ক্রিকেট ট্রেইনার',
            'experience' => 'বিসিবি সার্টিফাইড ক্রিকেট কোচ',
            'status' => 'active',
        ]);

        $coach3 = Coach::create([
            'sport_id' => $athletics->id,
            'name' => 'ফাহিম হাসান',
            'phone' => '01911-778899',
            'email' => 'fahim.fitness@jamirbaria.com',
            'designation' => 'ফিটনেস ট্রেইনার ও ফিজিও',
            'experience' => 'বিকেএসপি প্রশিক্ষিত স্পোর্টস ট্রেইনার',
            'status' => 'active',
        ]);

        // 3. Batches
        $batch1 = Batch::create([
            'sport_id' => $football->id,
            'coach_id' => $coach1->id,
            'name' => 'ফুটবল অনূর্ধ্ব-১৬ মর্নিং ব্যাচ',
            'days' => 'শনি, সোম, বুধ',
            'time_slot' => 'সকাল ৬:৩০ - ৮:০০',
            'ground' => 'গ্রাউন্ড ১ (প্রধান মাঠ)',
            'capacity' => 25,
            'status' => 'active',
        ]);

        $batch2 = Batch::create([
            'sport_id' => $football->id,
            'coach_id' => $coach1->id,
            'name' => 'ফুটবল জুনিয়র ইভনিং ব্যাচ',
            'days' => 'রবি, মঙ্গল, বৃহস্পতি',
            'time_slot' => 'বিকাল ৩:৩০ - ৫:০০',
            'ground' => 'গ্রাউন্ড ১ (প্রধান মাঠ)',
            'capacity' => 25,
            'status' => 'active',
        ]);

        $batch3 = Batch::create([
            'sport_id' => $cricket->id,
            'coach_id' => $coach2->id,
            'name' => 'ক্রিকেট নেট প্র্যাকটিস ব্যাচ',
            'days' => 'শনি, রবি, মঙ্গল, বুধ',
            'time_slot' => 'বিকাল ৩:৪৫ - ৫:৪৫',
            'ground' => 'নেট প্র্যাকটিস ব্লক বি',
            'capacity' => 20,
            'status' => 'active',
        ]);

        $batch4 = Batch::create([
            'sport_id' => $athletics->id,
            'coach_id' => $coach3->id,
            'name' => 'ফিটনেস ও রানিং স্কোয়াড',
            'days' => 'প্রতিদিন (শুক্র বাদে)',
            'time_slot' => 'সকাল ৬:০০ - ৭:০০',
            'ground' => 'রানিং ট্র্যাক এ',
            'capacity' => 30,
            'status' => 'active',
        ]);

        // 4. Trainees
        $traineesData = [
            [
                'admission_no' => 'JSA-2026-001',
                'sport_id' => $football->id,
                'batch_id' => $batch1->id,
                'name' => 'তানভীর আহমেদ সামি',
                'guardian_name' => 'মো: দেলোয়ার হোসেন',
                'phone' => '01711-223344',
                'emergency_phone' => '01711-998877',
                'date_of_birth' => '2010-05-14',
                'blood_group' => 'A+',
                'category' => 'U-16',
                'position' => 'স্ট্রাইকার (Forward)',
                'jersey_no' => '10',
                'address' => 'জামিরবাড়িয়া বাজার রোড, ময়মনসিংহ',
                'monthly_fee' => 1200.00,
                'admission_date' => '2026-01-10',
                'status' => 'active',
            ],
            [
                'admission_no' => 'JSA-2026-002',
                'sport_id' => $football->id,
                'batch_id' => $batch1->id,
                'name' => 'মাহমুদুল হাসান শুভ',
                'guardian_name' => 'আব্দুর রাজ্জাক',
                'phone' => '01822-334455',
                'emergency_phone' => '01822-556677',
                'date_of_birth' => '2011-03-22',
                'blood_group' => 'B+',
                'category' => 'U-16',
                'position' => 'গোলকিপার (Goalkeeper)',
                'jersey_no' => '1',
                'address' => 'দক্ষিণ জামিরবাড়িয়া, ময়মনসিংহ',
                'monthly_fee' => 1200.00,
                'admission_date' => '2026-01-12',
                'status' => 'active',
            ],
            [
                'admission_no' => 'JSA-2026-003',
                'sport_id' => $football->id,
                'batch_id' => $batch2->id,
                'name' => 'আরিফুল ইসলাম রাফি',
                'guardian_name' => 'শফিকুল ইসলাম',
                'phone' => '01933-445566',
                'emergency_phone' => '01933-778899',
                'date_of_birth' => '2013-08-11',
                'blood_group' => 'O+',
                'category' => 'U-14',
                'position' => 'মিডফিল্ডার (Midfielder)',
                'jersey_no' => '8',
                'address' => 'কলেজ পাড়া, জামিরবাড়িয়া',
                'monthly_fee' => 1000.00,
                'admission_date' => '2026-02-01',
                'status' => 'active',
            ],
            [
                'admission_no' => 'JSA-2026-004',
                'sport_id' => $cricket->id,
                'batch_id' => $batch3->id,
                'name' => 'সাদমান সাকিব',
                'guardian_name' => 'গোলাম সারোয়ার',
                'phone' => '01644-556677',
                'emergency_phone' => '01644-112233',
                'date_of_birth' => '2009-11-05',
                'blood_group' => 'AB+',
                'category' => 'U-16',
                'position' => 'টপ অর্ডার ব্যাটার',
                'jersey_no' => '18',
                'address' => 'স্টেশন রোড, ভালুকা/ময়মনসিংহ',
                'monthly_fee' => 1500.00,
                'admission_date' => '2026-01-15',
                'status' => 'active',
            ],
            [
                'admission_no' => 'JSA-2026-005',
                'sport_id' => $cricket->id,
                'batch_id' => $batch3->id,
                'name' => 'নাঈম হাসান',
                'guardian_name' => 'জালাল উদ্দিন',
                'phone' => '01755-667788',
                'emergency_phone' => '01755-334422',
                'date_of_birth' => '2010-09-18',
                'blood_group' => 'O-',
                'category' => 'U-16',
                'position' => 'পেস বোলার',
                'jersey_no' => '99',
                'address' => 'জামিরবাড়িয়া পূর্বপাড়া',
                'monthly_fee' => 1500.00,
                'admission_date' => '2026-02-10',
                'status' => 'active',
            ],
            [
                'admission_no' => 'JSA-2026-006',
                'sport_id' => $athletics->id,
                'batch_id' => $batch4->id,
                'name' => 'সাব্বির হোসেন',
                'guardian_name' => 'মোবারক হোসেন',
                'phone' => '01866-778899',
                'emergency_phone' => '01866-001122',
                'date_of_birth' => '2012-01-25',
                'blood_group' => 'B+',
                'category' => 'U-14',
                'position' => '১০০ মিটার স্প্রিন্টার',
                'jersey_no' => '7',
                'address' => 'পশ্চিম জামিরবাড়িয়া',
                'monthly_fee' => 800.00,
                'admission_date' => '2026-02-15',
                'status' => 'active',
            ],
        ];

        $createdTrainees = [];
        foreach ($traineesData as $data) {
            $createdTrainees[] = Trainee::create($data);
        }

        // 5. Attendance
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        foreach ($createdTrainees as $idx => $tr) {
            Attendance::create([
                'trainee_id' => $tr->id,
                'batch_id' => $tr->batch_id,
                'date' => $today,
                'status' => $idx == 2 ? 'absent' : ($idx == 4 ? 'late' : 'present'),
                'note' => $idx == 2 ? 'অসুস্থতার ছুটি' : null,
            ]);

            Attendance::create([
                'trainee_id' => $tr->id,
                'batch_id' => $tr->batch_id,
                'date' => $yesterday,
                'status' => 'present',
                'note' => null,
            ]);
        }

        // 6. Payments
        $invIndex = 1;
        foreach ($createdTrainees as $tr) {
            // Admission Fee
            Payment::create([
                'invoice_no' => 'INV-2026-' . str_pad($invIndex++, 4, '0', STR_PAD_LEFT),
                'trainee_id' => $tr->id,
                'title' => 'নতুন ভর্তি ফি ও কিট চার্জ',
                'fee_type' => 'admission',
                'amount' => 2000.00,
                'month' => 'জানুয়ারি',
                'year' => '2026',
                'payment_method' => 'bkash',
                'status' => 'paid',
                'payment_date' => $tr->admission_date,
                'note' => 'ভর্তি ও অফিসিয়াল জার্সি প্রদান',
            ]);

            // Monthly Fee
            Payment::create([
                'invoice_no' => 'INV-2026-' . str_pad($invIndex++, 4, '0', STR_PAD_LEFT),
                'trainee_id' => $tr->id,
                'title' => 'চলতি মাসের প্রশিক্ষণ ফি',
                'fee_type' => 'monthly',
                'amount' => $tr->monthly_fee,
                'month' => 'অক্টোবর',
                'year' => '2026',
                'payment_method' => $invIndex % 2 == 0 ? 'cash' : 'nagad',
                'status' => $invIndex == 5 ? 'due' : 'paid',
                'payment_date' => date('Y-m-d'),
                'note' => $invIndex == 5 ? 'বকেয়া' : 'পরিশোধিত',
            ]);
        }

        // 7. Notices
        Notice::create([
            'sport_id' => $football->id,
            'title' => 'আন্তঃউপজেলা অনূর্ধ্ব-১৬ ফুটবল প্রীতি ম্যাচ',
            'content' => 'আগামী শুক্রবার বিকাল ৩টায় জামিরবাড়িয়া প্রধান মাঠে একাডেমি একাদশের প্রীতি ম্যাচ অনুষ্ঠিত হবে। সকল প্লেয়ারকে সময়মতো উপস্থিত থাকতে হবে।',
            'notice_date' => date('Y-m-d'),
            'is_pinned' => true,
        ]);

        Notice::create([
            'sport_id' => $cricket->id,
            'title' => 'ক্রিকেট নতুন স্পেশাল নেট সেশন ও ফিটনেস টেস্ট',
            'content' => 'রোববার সকাল ৭টায় সকল ক্রিকেট ট্রেইনিদের স্পেশাল ফিটনেস এবং ইয়ো-ইয়ো টেস্ট নেওয়া হবে। ট্রেইনার তারেক আহমেদ উপস্থিত থাকবেন।',
            'notice_date' => date('Y-m-d', strtotime('-2 days')),
            'is_pinned' => false,
        ]);

        Notice::create([
            'sport_id' => null,
            'title' => 'একাডেমির নতুন জার্সি ও ট্রেইনিং কিট বিতরণ',
            'content' => 'যে সকল শিক্ষার্থী নতুন ভর্তি হয়েছেন তারা অফিস রুম থেকে জার্সি ও প্র্যাকটিস কিট সংগ্রহ করুন।',
            'notice_date' => date('Y-m-d', strtotime('-5 days')),
            'is_pinned' => true,
        ]);
    }
}


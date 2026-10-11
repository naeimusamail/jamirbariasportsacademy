<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingTask;
use App\Models\Coach;
use App\Models\Batch;
use App\Models\Trainee;
use Carbon\Carbon;

class TrainingTaskSeeder extends Seeder
{
    public function run(): void
    {
        $coach = Coach::first();
        $batchFootball = Batch::where('name', 'LIKE', '%ফুটবল%')->first() ?: Batch::first();
        $batchCricket = Batch::where('name', 'LIKE', '%ক্রিকেট%')->first();
        
        $trainees = Trainee::take(4)->get();
        $tanvir = $trainees[0] ?? null;
        $mahmud = $trainees[1] ?? null;

        if (!$coach) {
            return;
        }

        $tasks = [
            // ⚽ FOOTBALL DRILLS
            [
                'title' => '১০০মি. এক্সিলারেশন ও স্প্রিন্ট টেস্ট ড্রিল',
                'description' => 'ওয়ার্ম-আপের পর ৩ সেট ১০০ মিটার স্প্রিন্ট সর্বোচ্চ গতিতে সম্পন্ন করুন। প্রতিটি সেটের মাঝে ২ মিনিট সক্রিয় বিশ্রাম নিন।',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'fitness',
                'coach_id' => $coach->id,
                'batch_id' => $batchFootball ? $batchFootball->id : null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->subDays(2),
                'priority' => 'high',
                'status' => 'reviewed',
                'player_note' => 'কোচের নির্দেশমতো ৩ সেট স্প্রিন্ট সম্পন্ন করেছি। গড় সময় ১২.৮ সেকেন্ড লেগেছে।',
                'coach_score' => 9,
                'coach_feedback' => 'চমৎকার স্পিড ও এক্সিলারেশন। পরবর্তী সেশনে স্টার্টিং পোস্টারের দিকে আরও মনোযোগ দিতে হবে।',
            ],
            [
                'title' => 'কোন ড্রিবলিং ও ফার্স্ট-টাচ বল কন্ট্রোল অনুশীলন',
                'description' => '১০টি কোনের ভেতর দিয়ে বাম ও ডান উভয় পায়ে জিগ-জ্যাগ ড্রিবলিং করুন। দৈনিক ২০ মিনিট ড্রিবলিং ও বল কন্ট্রোল প্র্যাকটিস আবশ্যক।',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'technical',
                'coach_id' => $coach->id,
                'batch_id' => $batchFootball ? $batchFootball->id : null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->addDays(1),
                'priority' => 'normal',
                'status' => 'completed',
                'player_note' => 'আজ ৩০ মিনিট দুই পায়ে ড্রিবলিং অনুশীলন সম্পন্ন করেছি। কোনের ভেতর দিয়ে বল নিয়ন্ত্রণ আগের চেয়ে অনেক নিখুঁত হয়েছে।',
                'coach_score' => null,
                'coach_feedback' => null,
            ],
            [
                'title' => 'বক্সের বাইরে থেকে ডাইরেক্ট ফ্রি-কিক ও পেনাল্টি কার্লিং টেকনিক',
                'description' => 'ডি-বক্সের বাইরে ২০ গজ দূর থেকে ওয়াল ম্যানিকুইনের উপর দিয়ে বলের ভেতরের অংশ দিয়ে ২০টি কার্লিং শট মারুন।',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'technical',
                'coach_id' => $coach->id,
                'batch_id' => $batchFootball ? $batchFootball->id : null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->addDays(3),
                'priority' => 'high',
                'status' => 'pending',
                'player_note' => null,
                'coach_score' => null,
                'coach_feedback' => null,
            ],
            [
                'title' => 'হাই-প্রেসিং ও ট্যাকটিক্যাল ডিফেন্সিভ পজিশনিং ড্রিল',
                'description' => 'ম্যাচ পরিস্থিতিতে উইং থেকে ক্রস আসলে সঠিক পজিশনিং নেওয়া এবং দ্রুত কাউন্টারে বল পাস দেওয়ার টেকটিক্যাল ড্রিল।',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'tactical',
                'coach_id' => $coach->id,
                'batch_id' => $batchFootball ? $batchFootball->id : null,
                'trainee_id' => $mahmud ? $mahmud->id : null,
                'due_date' => Carbon::now()->subDays(1),
                'priority' => 'normal',
                'status' => 'reviewed',
                'player_note' => 'ভিডিও বিশ্লেষণ দেখেছি এবং মাঠে পজিশনিং প্র্যাকটিস করেছি।',
                'coach_score' => 8,
                'coach_feedback' => 'ভালো অগ্রগতি। অফ-দ্য-বল রান আরও দ্রুত করতে হবে।',
            ],
            [
                'title' => 'ম্যাচ-পরবর্তী ডাইনামিক স্ট্রেচিং ও ফোম রোলিং রিকভারি',
                'description' => 'ভারী প্র্যাকটিসের পর ২০ মিনিট ডাইনামিক হ্যামস্ট্রিং, কোয়াডস ও কাফ স্ট্রেচিং এবং ফোম রোলার দিয়ে পেশীর ক্লান্তি দূর করার সেশন।',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'recovery',
                'coach_id' => $coach->id,
                'batch_id' => $batchFootball ? $batchFootball->id : null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->subDays(3),
                'priority' => 'low',
                'status' => 'completed',
                'player_note' => 'সেশন শেষে পুরো ২০ মিনিট স্ট্রেচিং ও পর্যাপ্ত হাইড্রেশন করেছি। শরীর অনেক হালকা লাগছে।',
                'coach_score' => null,
                'coach_feedback' => null,
            ],

            // 🏏 CRICKET DRILLS
            [
                'title' => 'নেট ব্যাটিংয়ে ফ্রন্ট-ফুট কভার ড্রাইভ ও শট সিলেকশন ড্রিল',
                'description' => 'নেটে থ্রো-ডাউন এবং বোলিং মেশিনে ৫০টি ফুল-লেংথ বল ফেস করে নিখুঁত ফ্রন্ট-ফুট কভার ড্রাইভ ও ব্যালেন্স অনুশীলন।',
                'sport_type' => 'ক্রিকেট',
                'drill_category' => 'technical',
                'coach_id' => $coach->id,
                'batch_id' => $batchCricket ? $batchCricket->id : null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->subDays(1),
                'priority' => 'high',
                'status' => 'reviewed',
                'player_note' => 'নেটে ৫০টি বল ফেস করেছি। বিশেষ করে ফ্রন্ট-ফুট এগিয়ে এনে কভার ড্রাইভ নিখুঁত করার চেষ্টা করেছি।',
                'coach_score' => 10,
                'coach_feedback' => 'অসাধারণ টেকনিক ও হেড পজিশন! ফুটওয়ার্ক পুরোপুরি সময়োপযোগী ছিল।',
            ],
            [
                'title' => 'হাই ক্যাচিং ও ক্লোজ-ইন রিফ্লেক্স ফিল্ডিং প্র্যাকটিস',
                'description' => 'ক্যাচিং ব্যাটের সাহায্যে ৩০টি স্কাই ক্যাচ এবং স্লিপ কর্ডনে ২০টি রিফ্লেক্স ডাইভিং ক্যাচ অনুশীলন সম্পন্ন করুন।',
                'sport_type' => 'ক্রিকেট',
                'drill_category' => 'technical',
                'coach_id' => $coach->id,
                'batch_id' => $batchCricket ? $batchCricket->id : null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->addDays(2),
                'priority' => 'normal',
                'status' => 'pending',
                'player_note' => null,
                'coach_score' => null,
                'coach_feedback' => null,
            ],
            [
                'title' => 'পাওয়ারপ্লেতে টাইট লাইন-লেংথ বলিং ও ইয়র্কার ড্রিল',
                'description' => 'স্টাম্পের গোড়ায় জুতার বাক্স রেখে ডেথ ওভারে লাগাতার ১২টি নিখুঁত ইয়র্কার ও ওয়াইড ইয়র্কার ডেলিভারি অনুশীলন।',
                'sport_type' => 'ক্রিকেট',
                'drill_category' => 'tactical',
                'coach_id' => $coach->id,
                'batch_id' => $batchCricket ? $batchCricket->id : null,
                'trainee_id' => $mahmud ? $mahmud->id : null,
                'due_date' => Carbon::now()->addDays(4),
                'priority' => 'high',
                'status' => 'pending',
                'player_note' => null,
                'coach_score' => null,
                'coach_feedback' => null,
            ],

            // 🏃 ATHLETICS & FITNESS DRILLS
            [
                'title' => 'ব্লক স্টার্ট ও ৫০ মিটার ইনিশিয়াল বার্স্ট স্প্রিন্ট টেস্ট',
                'description' => 'স্টার্টিং ব্লক থেকে লো ড্রাইভ অ্যাঙ্গেলে ৫ সেট ৫০ মিটার এক্সিলারেশন সম্পন্ন করুন। প্রতিটি সেটের টাইমিং নোট করুন।',
                'sport_type' => 'অ্যাথলেটিক্স',
                'drill_category' => 'fitness',
                'coach_id' => $coach->id,
                'batch_id' => null,
                'trainee_id' => $mahmud ? $mahmud->id : null,
                'due_date' => Carbon::now()->subDays(2),
                'priority' => 'high',
                'status' => 'reviewed',
                'player_note' => '৫ সেট সফলভাবে শেষ করেছি। সেরা টাইমিং ছিল ৬.২ সেকেন্ড।',
                'coach_score' => 9,
                'coach_feedback' => 'রিঅ্যাকশন টাইম ও ফাস্ট স্টেপ এক্সিলেন্ট ছিল। স্প্রিন্ট ফিনিশে হেড স্ট্রেট রেখো।',
            ],
            [
                'title' => 'কোর স্ট্যাবিলিটি: ৩ মিনিট এলবো প্ল্যাঙ্ক ও বার্পি সার্কিট',
                'description' => '৩ রাউন্ড: ১ মিনিট স্ট্যাটিক প্ল্যাঙ্ক + ১৫টি বার্পি + ২০টি মাউন্টেন ক্লাইম্বার্স। বিরতি ৩০ সেকেন্ড।',
                'sport_type' => 'সাধারণ ফিটনেস',
                'drill_category' => 'fitness',
                'coach_id' => $coach->id,
                'batch_id' => null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->addDays(2),
                'priority' => 'normal',
                'status' => 'pending',
                'player_note' => null,
                'coach_score' => null,
                'coach_feedback' => null,
            ],

            // 🏸 BADMINTON DRILLS
            [
                'title' => 'শাটলকক ফুটওয়ার্ক ড্রিল ও ব্যাকহ্যান্ড ড্রপ শট প্র্যাকটিস',
                'description' => 'কোর্টের ৬টি কোণায় ৬-পয়েন্ট শাটল ফুটওয়ার্ক ড্রিল এবং নেটের সামনে ২০টি সূক্ষ্ম ব্যাকহ্যান্ড ড্রপ শট অনুকরণ।',
                'sport_type' => 'ব্যাডমিন্টন',
                'drill_category' => 'technical',
                'coach_id' => $coach->id,
                'batch_id' => null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->subDays(1),
                'priority' => 'normal',
                'status' => 'reviewed',
                'player_note' => 'কোর্টে ৬-পয়েন্ট ড্রিল ২৫ মিনিট অনুশীলন করেছি। রিস্ট ড্রপ ভালো হয়েছে।',
                'coach_score' => 9,
                'coach_feedback' => 'চমৎকার কব্জির মোচড়। অপোনেন্টকে বিভ্রান্ত করতে এই শট খুব কার্যকর হবে।',
            ],
            [
                'title' => 'হাই জাম্প স্ম্যাশ ও কুইক কোর্ট রিকভারি ড্রিল',
                'description' => 'রিয়ার কোর্ট থেকে জাম্প নিয়ে ড্রাইভ স্ম্যাশ মেরে পুনরায় বেসলাইনে দ্রুত ফিরে আসার ২৫টি ট্রায়াল সম্পন্ন করুন।',
                'sport_type' => 'ব্যাডমিন্টন',
                'drill_category' => 'tactical',
                'coach_id' => $coach->id,
                'batch_id' => null,
                'trainee_id' => $tanvir ? $tanvir->id : null,
                'due_date' => Carbon::now()->addDays(3),
                'priority' => 'high',
                'status' => 'pending',
                'player_note' => null,
                'coach_score' => null,
                'coach_feedback' => null,
            ],
        ];

        foreach ($tasks as $taskData) {
            TrainingTask::updateOrCreate(
                [
                    'title' => $taskData['title'],
                    'coach_id' => $taskData['coach_id'],
                ],
                $taskData
            );
        }
    }
}

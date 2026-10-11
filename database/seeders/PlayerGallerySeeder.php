<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlayerGallery;
use App\Models\Trainee;
use App\Models\TeamPlayer;
use App\Models\User;

class PlayerGallerySeeder extends Seeder
{
    public function run(): void
    {
        $trainee = Trainee::first();
        if (!$trainee) return;

        $teamPlayer = TeamPlayer::where('trainee_id', $trainee->id)->orWhere('name', 'LIKE', '%তানভীর%')->first();
        $admin = User::where('role', 'admin')->first();

        $photos = [
            [
                'title' => 'ফাইনাল ম্যাচে ফ্রি-কিক থেকে জয়সূচক গোল মুহূর্ত',
                'description' => '৮৮ তম মিনিটে ডি-বক্সের বাইরে থেকে নেওয়া দুর্দান্ত কার্লিং শটে বল জালে জড়ায়। জামিরবাড়িয়া চ্যাম্পিয়নশিপ কাপের শ্বাসরুদ্ধকর ফাইনাল।',
                'image_path' => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=1000&auto=format&fit=crop',
                'category' => 'match_action',
                'match_name' => 'জামিরবাড়িয়া চ্যাম্পিয়নশিপ লিগ ২০২৬',
                'event_date' => '2026-09-28',
                'is_featured' => true,
            ],
            [
                'title' => 'অফিসিয়াল একাডেমি জার্সি উন্মোচন ও প্রোমো পোর্ট্রেট',
                'description' => '২০২৬ সিজনের নতুন হোম জার্সি ও স্পনসর কিট সম্বলিত একাডেমি মিডিয়া প্রোমো ফটোশুট।',
                'image_path' => 'https://images.unsplash.com/photo-1517649763962-0c623266ddc0?q=80&w=1000&auto=format&fit=crop',
                'category' => 'promo',
                'match_name' => 'সিজন ওপেনিং প্রোমো ২০২৬',
                'event_date' => '2026-09-15',
                'is_featured' => true,
            ],
            [
                'title' => 'চ্যাম্পিয়নশিপ ট্রফি ও সেরা খেলোয়াড়ের পুরস্কার অর্জন',
                'description' => 'টুর্নামেন্টে সেরা পারফর্মার হিসেবে সম্মানিত হওয়া এবং ট্রফি উদযাপনের আনন্দঘন মুহূর্ত।',
                'image_path' => 'https://images.unsplash.com/photo-1522778119026-d647f0596c20?q=80&w=1000&auto=format&fit=crop',
                'category' => 'celebration',
                'match_name' => 'জামিরবাড়িয়া গোল্ড কাপ ফাইনাল ২০২৬',
                'event_date' => '2026-10-02',
                'is_featured' => true,
            ],
            [
                'title' => 'সকালের স্পিড ও অ্যাজিলিটি ট্রেনিং সেশন',
                'description' => 'কোচ রফিকুল ইসলামের সরাসরি নির্দেশনায় ট্যাকটিক্যাল পজিশনিং ও হাই-ইনটেনসিটি ড্রিল প্রস্তুতি।',
                'image_path' => 'https://images.unsplash.com/photo-1526232761682-d26e03ac148e?q=80&w=1000&auto=format&fit=crop',
                'category' => 'training',
                'match_name' => 'একাডেমি ড্রিল ক্যাম্প ২০২৬',
                'event_date' => '2026-10-05',
                'is_featured' => false,
            ],
            [
                'title' => 'টি-টোয়েন্টি টুর্নামেন্টে নিখুঁত কভার ড্রাইভ শট',
                'description' => 'পাওয়ারপ্লেতে বাউন্ডারি হাঁকানোর দর্শনীয় অ্যাকশন মুহূর্ত। একাডেমি ক্রিকেট উইংয়ের অন্যতম সেরা ইনিংস।',
                'image_path' => 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=1000&auto=format&fit=crop',
                'category' => 'match_action',
                'match_name' => 'আন্তঃজেলা টি-টোয়েন্টি প্রিমিয়ার কাপ',
                'event_date' => '2026-09-20',
                'is_featured' => false,
            ],
            [
                'title' => 'সোশ্যাল মিডিয়া প্রোমো ও ডিজিটাল ফিটনেস কার্ড পোর্ট্রেট',
                'description' => 'ডিজিটাল আইডি ও ওয়েবসাইট স্পটলাইটের জন্য গৃহীত হাই-ডেফিনিশন অ্যাথলেটিক পোর্ট্রেট।',
                'image_path' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000&auto=format&fit=crop',
                'category' => 'promo',
                'match_name' => 'প্লেয়ার অফ দ্য মান্থ ফিচার',
                'event_date' => '2026-09-10',
                'is_featured' => false,
            ],
        ];

        foreach ($photos as $p) {
            PlayerGallery::firstOrCreate(
                [
                    'trainee_id' => $trainee->id,
                    'title' => $p['title'],
                ],
                array_merge($p, [
                    'team_player_id' => $teamPlayer ? $teamPlayer->id : null,
                    'uploaded_by' => $admin ? $admin->id : null,
                ])
            );
        }

        // Also add a couple photos for second trainee if available
        $trainee2 = Trainee::skip(1)->first();
        if ($trainee2) {
            PlayerGallery::firstOrCreate(
                [
                    'trainee_id' => $trainee2->id,
                    'title' => 'ট্র্যাক অ্যান্ড ফিল্ড ১০০ মিটার স্প্রিন্ট ফিনিশিং মুহূর্ত',
                ],
                [
                    'description' => 'বার্ষিক অ্যাথলেটিক্স মিটে ১১.২ সেকেন্ড টাইমিং নিয়ে প্রথম স্থান অর্জনের গৌরবময় মুহূর্ত।',
                    'image_path' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?q=80&w=1000&auto=format&fit=crop',
                    'category' => 'match_action',
                    'match_name' => 'বার্ষিক অ্যাথলেটিক্স মিট ২০২৬',
                    'event_date' => '2026-10-01',
                    'is_featured' => true,
                    'uploaded_by' => $admin ? $admin->id : null,
                ]
            );
        }
    }
}


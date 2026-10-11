<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LiveMatch;
use App\Models\LiveMatchEvent;

class LiveMatchSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Live Football Match
        $match1 = LiveMatch::create([
            'slug' => 'jamirbaria-cup-final-football-2026',
            'title' => 'জামিরবাড়িয়া গোল্ড কাপ ফাইনাল ২০২৬',
            'sport_type' => 'football',
            'tournament_name' => 'জামিরবাড়িয়া একাডেমি চ্যাম্পিয়নশিপ',
            'team_a' => 'জামিরবাড়িয়া একাডেমি একাদশ',
            'team_a_score' => '2',
            'team_b' => 'ময়মনসিংহ রাইডার্স স্পোর্টস ক্লাব',
            'team_b_score' => '1',
            'status' => 'live',
            'current_summary' => '২য় হাফ চলমান • ৭০ মিনিট (জামিরবাড়িয়া ১ গোলে এগিয়ে)',
            'venue' => 'জামিরবাড়িয়া প্রধান একাডেমি স্টেডিয়াম',
            'match_datetime' => now()->subMinutes(75),
            'stream_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'stream_platform' => 'youtube',
            'is_streaming' => true,
            'scorer_code' => '1234',
            'creator_name' => 'হেড কোচ রফিকুল ইসলাম',
        ]);

        LiveMatchEvent::create([
            'live_match_id' => $match1->id,
            'time_marker' => "65'",
            'event_type' => 'goal',
            'title' => 'গোললল! (Goal for Jamirbaria)',
            'description' => '১০ নম্বর জার্সিধারী তানভীর আহমেদ সামির দুর্দান্ত দূরপাল্লার বাঁ-পায়ের জোরালো শটে বল জালে! জামিরবাড়িয়া ২-১ গোলে এগিয়ে গেল!',
        ]);

        LiveMatchEvent::create([
            'live_match_id' => $match1->id,
            'time_marker' => "52'",
            'event_type' => 'card',
            'title' => 'হলুদ কার্ড (Yellow Card)',
            'description' => 'ফাউল করায় রাইডার্সের ডিফেন্ডারকে হলুদ কার্ড দেখালেন রেফারি।',
        ]);

        LiveMatchEvent::create([
            'live_match_id' => $match1->id,
            'time_marker' => "38'",
            'event_type' => 'goal',
            'title' => 'সমতাসূচক গোল (Goal for Mymensingh)',
            'description' => 'কর্নার কিক থেকে দুর্দান্ত হেডারে ময়মনসিংহের সমতায় ফেরা (১ - ১)।',
        ]);

        LiveMatchEvent::create([
            'live_match_id' => $match1->id,
            'time_marker' => "14'",
            'event_type' => 'goal',
            'title' => 'উদ্বোধনী গোল! (First Goal)',
            'description' => 'ম্যাচের শুরুতেই চমৎকার পাসিং কম্বিনেশনে জামিরবাড়িয়ার প্রথম গোল!',
        ]);

        // 2. Live Cricket Match
        $match2 = LiveMatch::create([
            'slug' => 't20-cricket-trophy-jamirbaria-vs-bhaluka',
            'title' => 'টি-টোয়েন্টি চ্যালেঞ্জ ট্রফি ২০২৬',
            'sport_type' => 'cricket',
            'tournament_name' => 'ময়মনসিংহ বিভাগীয় একাডেমি লিগ',
            'team_a' => 'জামিরবাড়িয়া একাডেমি টাইগার্স',
            'team_a_score' => '162/4 (18.4 ov)',
            'team_b' => 'ভালুকা ইয়ুথ ইলেভেন',
            'team_b_score' => '158/8 (20 ov)',
            'status' => 'live',
            'current_summary' => 'জামিরবাড়িয়ার জয়ের জন্য ৮ বলে প্রয়োজন মাত্র ৩ রান! ব্যাট করছেন সাদমান সাকিব (৬৪*)',
            'venue' => 'জামিরবাড়িয়া ওভাল গ্রাউন্ড',
            'match_datetime' => now()->subHours(2),
            'stream_url' => null,
            'stream_platform' => 'youtube',
            'is_streaming' => false,
            'scorer_code' => '5678',
            'creator_name' => 'কোচ তারেক আহমেদ',
        ]);

        LiveMatchEvent::create([
            'live_match_id' => $match2->id,
            'time_marker' => '18.3 ov',
            'event_type' => 'four',
            'title' => 'দারুণ বাউন্ডারি! চার!',
            'description' => 'সাদমানের দুর্দান্ত কভার ড্রাইভ! বিদ্যুৎ গতিতে বল বাউন্ডারি রশি স্পর্শ করলো।',
        ]);

        LiveMatchEvent::create([
            'live_match_id' => $match2->id,
            'time_marker' => '17.1 ov',
            'event_type' => 'six',
            'title' => 'বিশাল ছক্কা! (MAXIMUM SIX)',
            'description' => 'লং-অনের উপর দিয়ে বল সোজা গ্যালারিতে! ৮৫ মিটার লম্বা বিশাল ছক্কা!',
        ]);

        LiveMatchEvent::create([
            'live_match_id' => $match2->id,
            'time_marker' => '15.4 ov',
            'event_type' => 'wicket',
            'title' => 'উইকেট পতন! বোল্ড!',
            'description' => 'পেসারের দুর্দান্ত ইয়র্কারে স্টাম্প উপড়ে গেল। জামিরবাড়িয়ার ৪র্থ উইকেটের পতন।',
        ]);

        // 3. Upcoming Match
        LiveMatch::create([
            'slug' => 'u14-junior-football-derby',
            'title' => 'অনূর্ধ্ব-১৪ ফ্রেন্ডলি ডার্বি ম্যাচ',
            'sport_type' => 'football',
            'tournament_name' => 'উইকেন্ড ইয়ুথ ফেস্টিভ্যাল',
            'team_a' => 'জামিরবাড়িয়া জুনিয়র একাদশ',
            'team_a_score' => '0',
            'team_b' => 'ত্রিশাল ফুটবল একাডেমি',
            'team_b_score' => '0',
            'status' => 'upcoming',
            'current_summary' => 'ম্যাচ শুরু হবে শুক্রবার বিকাল ৩:৩০ টায়',
            'venue' => 'জামিরবাড়িয়া গ্রাউন্ড ২',
            'match_datetime' => now()->addDays(2),
            'scorer_code' => '9999',
            'creator_name' => 'একাডেমি এডমিন',
        ]);
    }
}


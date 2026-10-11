<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sport;
use App\Models\Team;
use App\Models\TeamPlayer;
use App\Models\LiveMatch;
use App\Models\LiveMatchEvent;
use App\Models\MatchPlayerStat;
use App\Models\Trainee;

class TeamAndCricinfoSeeder extends Seeder
{
    public function run(): void
    {
        $cricket = Sport::where('name', 'like', '%ক্রিকেট%')->first();
        $football = Sport::where('name', 'like', '%ফুটবল%')->first();
        $badminton = Sport::where('name', 'like', '%ব্যাডমিন্টন%')->first();
        $athletics = Sport::where('name', 'like', '%অ্যাথলেটিক্স%')->first();

        $trainees = Trainee::take(15)->get();

        // ==============================================================
        // 1. CRICKET TEAMS & MATCHES
        // ==============================================================
        $tigers = Team::firstOrCreate(
            ['slug' => 'jamirbaria-tigers'],
            [
                'name' => 'জামিরবাড়িয়া টাইগার্স',
                'short_name' => 'JBT',
                'sport_id' => $cricket ? $cricket->id : null,
                'sport_type' => 'cricket',
                'category' => 'সিনিয়র এ-দল',
                'coach_name' => 'তারেক আহমেদ',
                'captain_name' => 'তামিম ইকবাল রাজু',
                'description' => 'জামিরবাড়িয়া স্পোর্টস একাডেমির শীর্ষ ক্রিকেট দল। জেলা ও বিভাগীয় টুর্নামেন্টের বর্তমান চ্যাম্পিয়ন।',
                'matches_played' => 12,
                'matches_won' => 9,
                'matches_lost' => 2,
                'matches_drawn' => 1,
                'points' => 28,
                'status' => 'active',
            ]
        );

        $lions = Team::firstOrCreate(
            ['slug' => 'jamirbaria-lions'],
            [
                'name' => 'জামিরবাড়িয়া লায়ন্স',
                'short_name' => 'JBL',
                'sport_id' => $cricket ? $cricket->id : null,
                'sport_type' => 'cricket',
                'category' => 'অনূর্ধ্ব-১৬ যুব একাদশ',
                'coach_name' => 'আশরাফুল ইসলাম',
                'captain_name' => 'সাকিবুল হাসান শান্ত',
                'description' => 'একাডেমির প্রতিশ্রুতিশীল তরুণ প্রতিভাদের নিয়ে গঠিত যুব ক্রিকেট দল।',
                'matches_played' => 10,
                'matches_won' => 7,
                'matches_lost' => 3,
                'matches_drawn' => 0,
                'points' => 21,
                'status' => 'active',
            ]
        );

        $blues = Team::firstOrCreate(
            ['slug' => 'jashore-blues'],
            [
                'name' => 'যশোর ব্লুজ ক্রিকেট ক্লাব',
                'short_name' => 'JSRB',
                'sport_id' => $cricket ? $cricket->id : null,
                'sport_type' => 'cricket',
                'category' => 'আমন্ত্রিত দল',
                'coach_name' => 'কামরুল ইসলাম',
                'captain_name' => 'মাহমুদুল হাসান',
                'description' => 'যশোর প্রিমিয়ার লিগের স্বনামধন্য ক্রিকেট ক্লাব।',
                'matches_played' => 8,
                'matches_won' => 5,
                'matches_lost' => 3,
                'matches_drawn' => 0,
                'points' => 15,
                'status' => 'active',
            ]
        );

        // Tigers Squad
        $p1 = TeamPlayer::firstOrCreate(
            ['team_id' => $tigers->id, 'jersey_no' => 28],
            [
                'name' => 'তামিম ইকবাল রাজু',
                'role' => 'Top-order Batter',
                'batting_style' => 'Right-hand bat',
                'bowling_style' => 'Right-arm offbreak',
                'is_captain' => true,
                'is_vice_captain' => false,
                'status' => 'active',
                'trainee_id' => $trainees->get(0)?->id,
            ]
        );

        $p2 = TeamPlayer::firstOrCreate(
            ['team_id' => $tigers->id, 'jersey_no' => 75],
            [
                'name' => 'সাকিবুল হাসান শান্ত',
                'role' => 'All-Rounder',
                'batting_style' => 'Left-hand bat',
                'bowling_style' => 'Slow left-arm orthodox',
                'is_captain' => false,
                'is_vice_captain' => true,
                'status' => 'active',
                'trainee_id' => $trainees->get(1)?->id,
            ]
        );

        $p3 = TeamPlayer::firstOrCreate(
            ['team_id' => $tigers->id, 'jersey_no' => 15],
            [
                'name' => 'মুশফিকুর রহমান সৈকত',
                'role' => 'Wicketkeeper-Batter',
                'batting_style' => 'Right-hand bat',
                'is_captain' => false,
                'is_vice_captain' => false,
                'status' => 'active',
                'trainee_id' => $trainees->get(2)?->id,
            ]
        );

        $p4 = TeamPlayer::firstOrCreate(
            ['team_id' => $tigers->id, 'jersey_no' => 90],
            [
                'name' => 'মুস্তাফিজুর রহমান রুবেল',
                'role' => 'Fast Bowler',
                'batting_style' => 'Left-hand bat',
                'bowling_style' => 'Left-arm fast',
                'is_captain' => false,
                'is_vice_captain' => false,
                'status' => 'active',
                'trainee_id' => $trainees->get(3)?->id,
            ]
        );

        // Blues Squad
        $bp1 = TeamPlayer::firstOrCreate(
            ['team_id' => $blues->id, 'jersey_no' => 7],
            [
                'name' => 'মাহমুদুল হাসান',
                'role' => 'Top-order Batter',
                'batting_style' => 'Right-hand bat',
                'is_captain' => true,
                'status' => 'active',
            ]
        );
        $bp2 = TeamPlayer::firstOrCreate(
            ['team_id' => $blues->id, 'jersey_no' => 33],
            [
                'name' => 'তাসকিন আহমেদ ইমন',
                'role' => 'Fast Bowler',
                'bowling_style' => 'Right-arm fast',
                'is_vice_captain' => true,
                'status' => 'active',
            ]
        );
        $bp3 = TeamPlayer::firstOrCreate(
            ['team_id' => $blues->id, 'jersey_no' => 22],
            [
                'name' => 'লিটন চন্দ্র রায়',
                'role' => 'Wicketkeeper-Batter',
                'batting_style' => 'Right-hand bat',
                'status' => 'active',
            ]
        );

        // Cricket Match
        $cricketMatch = LiveMatch::firstOrCreate(
            ['slug' => 'jamirbaria-championship-final-2026'],
            [
                'title' => 'জামিরবাড়িয়া চ্যাম্পিয়নশিপ ফাইনাল ২০২৬',
                'tournament_name' => 'স্বাধীনতা কাপ ২০২৬ - ফাইনাল',
                'sport_type' => 'cricket',
                'team_a' => 'যশোর ব্লুজ ক্রিকেট ক্লাব',
                'team_b' => 'জামিরবাড়িয়া টাইগার্স',
                'team_a_id' => $blues->id,
                'team_b_id' => $tigers->id,
                'team_a_score' => '১৫৮/৬ (২০.০ ওভ)',
                'team_b_score' => '১৬২/৪ (১৯.২ ওভ)',
                'current_summary' => 'জামিরবাড়িয়া টাইগার্স ৪ উইকেটে জয়ী!',
                'venue' => 'জামিরবাড়িয়া একাডেমি মূল স্টেডিয়াম',
                'status' => 'finished',
                'scorer_code' => 'sc_jbt_final_2026',
                'match_datetime' => now()->subDays(2),
                'toss_winner' => 'যশোর ব্লুজ ক্রিকেট ক্লাব',
                'toss_decision' => 'bat',
                'match_result' => 'জামিরবাড়িয়া টাইগার্স ৪ উইকেটে বিজয়ী (৪ বল বাকি থাকতে)',
                'player_of_match' => 'তামিম ইকবাল রাজু (৭৬ রান, ৪৮ বল)',
                'is_streaming' => false,
            ]
        );

        // Cricket Stats
        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $cricketMatch->id, 'team_player_id' => $bp1->id, 'inning' => 1],
            [
                'team_id' => $blues->id,
                'batting_order' => 1,
                'dismissal_type' => 'কট শান্ত বোল্ড রুবেল',
                'runs_scored' => 54,
                'balls_faced' => 38,
                'fours' => 6,
                'sixes' => 2,
                'strike_rate' => 142.11,
            ]
        );
        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $cricketMatch->id, 'team_player_id' => $p4->id, 'inning' => 1],
            [
                'team_id' => $tigers->id,
                'overs_bowled' => 4.0,
                'maidens' => 1,
                'runs_conceded' => 22,
                'wickets_taken' => 3,
                'economy_rate' => 5.50,
            ]
        );
        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $cricketMatch->id, 'team_player_id' => $p1->id, 'inning' => 2],
            [
                'team_id' => $tigers->id,
                'batting_order' => 1,
                'dismissal_type' => 'নট আউট',
                'runs_scored' => 76,
                'balls_faced' => 48,
                'fours' => 8,
                'sixes' => 3,
                'strike_rate' => 158.33,
                'is_player_of_match' => true,
            ]
        );

        // ==============================================================
        // 2. FOOTBALL TEAMS & MATCHES
        // ==============================================================
        $jbfc = Team::firstOrCreate(
            ['slug' => 'jamirbaria-fc'],
            [
                'name' => 'জামিরবাড়িয়া ফুটবল ক্লাব (এফসি)',
                'short_name' => 'JBFC',
                'sport_id' => $football ? $football->id : null,
                'sport_type' => 'football',
                'category' => 'সিনিয়র একাদশ',
                'coach_name' => 'রফিকুল ইসলাম',
                'captain_name' => 'আরিফুল ইসলাম রাকিব',
                'description' => 'জামিরবাড়িয়ার পেশাদার ফুটবল স্কোয়াড। আক্রমণাত্মক ফুটবল ও ট্যাকটিক্যাল কৌশলের জন্য সুপরিচিত।',
                'matches_played' => 14,
                'matches_won' => 10,
                'matches_lost' => 1,
                'matches_drawn' => 3,
                'points' => 33,
                'status' => 'active',
            ]
        );

        $kpfc = Team::firstOrCreate(
            ['slug' => 'khulna-pioneer-fc'],
            [
                'name' => 'খুলনা পাইওনিয়ার ফুটবল ক্লাব',
                'short_name' => 'KPFC',
                'sport_id' => $football ? $football->id : null,
                'sport_type' => 'football',
                'category' => 'আমন্ত্রিত দল',
                'coach_name' => 'শাহজাহান মিয়া',
                'captain_name' => 'মেহেদী হাসান জাহিদ',
                'description' => 'খুলনা প্রথম বিভাগ ফুটবল লিগের শীর্ষ ক্লাব।',
                'matches_played' => 11,
                'matches_won' => 6,
                'matches_lost' => 3,
                'matches_drawn' => 2,
                'points' => 20,
                'status' => 'active',
            ]
        );

        // Football Squad Players
        $fp1 = TeamPlayer::firstOrCreate(
            ['team_id' => $jbfc->id, 'jersey_no' => 10],
            [
                'name' => 'আরিফুল ইসলাম রাকিব',
                'role' => 'Striker',
                'position' => 'সেন্টার ফরোয়ার্ড (CF)',
                'is_captain' => true,
                'is_vice_captain' => false,
                'status' => 'active',
                'trainee_id' => $trainees->get(4)?->id,
            ]
        );

        $fp2 = TeamPlayer::firstOrCreate(
            ['team_id' => $jbfc->id, 'jersey_no' => 8],
            [
                'name' => 'তানভীর আহমেদ',
                'role' => 'Midfielder',
                'position' => 'সেন্ট্রাল অ্যাটাকিং মিডফিল্ডার (CAM)',
                'is_captain' => false,
                'is_vice_captain' => true,
                'status' => 'active',
                'trainee_id' => $trainees->get(5)?->id,
            ]
        );

        $fp3 = TeamPlayer::firstOrCreate(
            ['team_id' => $jbfc->id, 'jersey_no' => 1],
            [
                'name' => 'মাহিনুল ইসলাম',
                'role' => 'Goalkeeper',
                'position' => 'প্রধান গোলরক্ষক (GK)',
                'is_captain' => false,
                'is_vice_captain' => false,
                'status' => 'active',
                'trainee_id' => $trainees->get(6)?->id,
            ]
        );

        $fp4 = TeamPlayer::firstOrCreate(
            ['team_id' => $jbfc->id, 'jersey_no' => 4],
            [
                'name' => 'হাসানুল বান্না',
                'role' => 'Defender',
                'position' => 'সেন্টার ব্যাক (CB)',
                'is_captain' => false,
                'is_vice_captain' => false,
                'status' => 'active',
                'trainee_id' => $trainees->get(7)?->id,
            ]
        );

        // Opponent Football Players
        $kfp1 = TeamPlayer::firstOrCreate(
            ['team_id' => $kpfc->id, 'jersey_no' => 9],
            [
                'name' => 'মেহেদী হাসান জাহিদ',
                'role' => 'Striker',
                'position' => 'স্ট্রাইকার',
                'is_captain' => true,
                'status' => 'active',
            ]
        );

        // Football Match
        $footballMatch = LiveMatch::firstOrCreate(
            ['slug' => 'inter-district-football-cup-semifinal-2026'],
            [
                'title' => 'আন্তঃজেলা ফুটবল কাপ ২০২৬ - সেমিফাইনাল',
                'tournament_name' => 'আন্তঃজেলা ফুটবল কাপ ২০২৬',
                'sport_type' => 'football',
                'team_a' => 'খুলনা পাইওনিয়ার ফুটবল ক্লাব',
                'team_b' => 'জামিরবাড়িয়া ফুটবল ক্লাব (এফসি)',
                'team_a_id' => $kpfc->id,
                'team_b_id' => $jbfc->id,
                'team_a_score' => '১',
                'team_b_score' => '২',
                'current_summary' => 'জামিরবাড়িয়া এফসি ২ - ১ গোলে জয়ী!',
                'venue' => 'জামিরবাড়িয়া একাডেমি ফুটবল গ্রাউন্ড ১',
                'status' => 'finished',
                'scorer_code' => 'sc_jbfc_semi_2026',
                'match_datetime' => now()->subDay(),
                'toss_winner' => 'জামিরবাড়িয়া ফুটবল ক্লাব (এফসি)',
                'toss_decision' => 'field',
                'match_result' => 'জামিরবাড়িয়া এফসি ২ - ১ গোলে বিজয়ী (ফাইনালে উত্তীর্ণ)',
                'player_of_match' => 'আরিফুল ইসলাম রাকিব (২ গোল)',
                'is_streaming' => false,
            ]
        );

        // Football Player Match Stats
        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $footballMatch->id, 'team_player_id' => $fp1->id],
            [
                'team_id' => $jbfc->id,
                'goals' => 2,
                'assists' => 0,
                'minutes_played' => 90,
                'yellow_cards' => 0,
                'red_cards' => 0,
                'is_player_of_match' => true,
            ]
        );

        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $footballMatch->id, 'team_player_id' => $fp2->id],
            [
                'team_id' => $jbfc->id,
                'goals' => 0,
                'assists' => 2,
                'minutes_played' => 88,
                'yellow_cards' => 0,
                'red_cards' => 0,
            ]
        );

        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $footballMatch->id, 'team_player_id' => $fp4->id],
            [
                'team_id' => $jbfc->id,
                'goals' => 0,
                'assists' => 0,
                'minutes_played' => 90,
                'yellow_cards' => 1,
                'red_cards' => 0,
            ]
        );

        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $footballMatch->id, 'team_player_id' => $fp3->id],
            [
                'team_id' => $jbfc->id,
                'goals' => 0,
                'assists' => 0,
                'minutes_played' => 90,
                'clean_sheet' => false,
            ]
        );

        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $footballMatch->id, 'team_player_id' => $kfp1->id],
            [
                'team_id' => $kpfc->id,
                'goals' => 1,
                'assists' => 0,
                'minutes_played' => 90,
                'yellow_cards' => 0,
            ]
        );

        // Football Events
        LiveMatchEvent::firstOrCreate(
            ['live_match_id' => $footballMatch->id, 'time_marker' => "৫৪' মিনিট"],
            [
                'event_type' => 'goal',
                'title' => 'গোওওওল! রাকিবের জোড়া গোল!',
                'description' => 'তানভীরের নিখুঁত কর্নার থেকে হেডে জামিরবাড়িয়া এফসিকে এগিয়ে দিলেন অধিনায়ক রাকিব (২-১)!',
            ]
        );
        LiveMatchEvent::firstOrCreate(
            ['live_match_id' => $footballMatch->id, 'time_marker' => "৩৪' মিনিট"],
            [
                'event_type' => 'goal',
                'title' => 'গোওওল! জামিরবাড়িয়ার সমতা!',
                'description' => 'বক্সের বাইরে থেকে রাকিবের বাঁকানো বুলেট শটে সমতায় ফিরল একাডেমি দল (১-১)।',
            ]
        );

        // ==============================================================
        // 3. BADMINTON TEAMS & MATCHES
        // ==============================================================
        $shuttlers = Team::firstOrCreate(
            ['slug' => 'jamirbaria-shuttlers'],
            [
                'name' => 'জামিরবাড়িয়া শাটলার্স',
                'short_name' => 'JBS',
                'sport_id' => $badminton ? $badminton->id : null,
                'sport_type' => 'badminton',
                'category' => 'সিনিয়র স্কোয়াড',
                'coach_name' => 'কামরুল হাসান',
                'captain_name' => 'নাফিস ইকবাল',
                'description' => 'একাডেমির ইনডোর ব্যাডমিন্টন চ্যাম্পিয়ন দল।',
                'matches_played' => 8,
                'matches_won' => 7,
                'matches_lost' => 1,
                'matches_drawn' => 0,
                'points' => 21,
                'status' => 'active',
            ]
        );

        $badmintonPlayer1 = TeamPlayer::firstOrCreate(
            ['team_id' => $shuttlers->id, 'jersey_no' => 7],
            [
                'name' => 'নাফিস ইকবাল',
                'role' => 'Singles Specialist',
                'position' => 'সিঙ্গেলস ও মিক্সড ডাবলস',
                'is_captain' => true,
                'status' => 'active',
            ]
        );

        $badmintonMatch = LiveMatch::firstOrCreate(
            ['slug' => 'academy-badminton-cup-final-2026'],
            [
                'title' => 'একাডেমি ব্যাডমিন্টন ওপেন ২০২৬ - ফাইনাল',
                'tournament_name' => 'উইন্টার ব্যাডমিন্টন টুর্নামেন্ট',
                'sport_type' => 'badminton',
                'team_a' => 'কুষ্টিয়া শাটলার্স ক্লাব',
                'team_b' => 'জামিরবাড়িয়া শাটলার্স',
                'team_b_id' => $shuttlers->id,
                'team_a_score' => '১ সেট',
                'team_b_score' => '২ সেট',
                'current_summary' => 'জামিরবাড়িয়া শাটলার্স ২-১ সেটে চ্যাম্পিয়ন! (২১-১৮, ১৯-২১, ২১-১৫)',
                'venue' => 'জামিরবাড়িয়া ইনডোর ব্যাডমিন্টন কোর্ট',
                'status' => 'finished',
                'scorer_code' => 'sc_jbs_badminton_2026',
                'match_datetime' => now()->subDays(3),
                'match_result' => 'জামিরবাড়িয়া শাটলার্স ২ - ১ সেটে চ্যাম্পিয়ন',
                'player_of_match' => 'নাফিস ইকবাল (২১-১৫ নির্ণায়ক সেটে জয়ী)',
                'is_streaming' => false,
            ]
        );

        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $badmintonMatch->id, 'team_player_id' => $badmintonPlayer1->id],
            [
                'team_id' => $shuttlers->id,
                'sets_won' => 2,
                'points_scored' => 61,
                'is_player_of_match' => true,
            ]
        );

        // ==============================================================
        // 4. ATHLETICS TEAMS & MATCHES
        // ==============================================================
        $athleticsTeam = Team::firstOrCreate(
            ['slug' => 'jamirbaria-athletics-club'],
            [
                'name' => 'জামিরবাড়িয়া অ্যাথলেটিক্স ক্লাব',
                'short_name' => 'JBAC',
                'sport_id' => $athletics ? $athletics->id : null,
                'sport_type' => 'athletics',
                'category' => 'ওপেন ডিভিশন',
                'coach_name' => 'ফাহিম হাসান',
                'captain_name' => 'জাহিদুল ইসলাম রানা',
                'description' => 'স্প্রিন্ট, হাই জাম্প, লং জাম্প ও ট্র্যাক অ্যান্ড ফিল্ড অ্যাথলেটিক্স দল।',
                'matches_played' => 6,
                'matches_won' => 5,
                'matches_lost' => 1,
                'matches_drawn' => 0,
                'points' => 15,
                'status' => 'active',
            ]
        );

        $athlete1 = TeamPlayer::firstOrCreate(
            ['team_id' => $athleticsTeam->id, 'jersey_no' => 9],
            [
                'name' => 'জাহিদুল ইসলাম রানা',
                'role' => 'Sprinter (100m/200m)',
                'position' => '১০০ মিটার স্প্রিন্ট স্পেশালিস্ট',
                'is_captain' => true,
                'status' => 'active',
            ]
        );

        $athleticsMatch = LiveMatch::firstOrCreate(
            ['slug' => 'annual-athletics-100m-sprint-2026'],
            [
                'title' => 'বার্ষিক অ্যাথলেটিক্স মিট ২০২৬ - ১০০ মিটার স্প্রিন্ট ফাইনাল',
                'tournament_name' => 'বিভাগীয় অ্যাথলেটিক্স ট্রফি',
                'sport_type' => 'athletics',
                'team_a' => 'আমন্ত্রিত অ্যাথলেটস',
                'team_b' => 'জামিরবাড়িয়া অ্যাথলেটিক্স ক্লাব',
                'team_b_id' => $athleticsTeam->id,
                'team_a_score' => '১০.৮৯ সেকেন্ড',
                'team_b_score' => '১০.৭২ সেকেন্ড',
                'current_summary' => 'জাহিদুল রানা ১০.৭২ সেকেন্ডে রেকর্ড গড়ে স্বর্ণপদক জয়ী!',
                'venue' => 'জামিরবাড়িয়া সেন্ট্রাল অ্যাথলেটিক ট্র্যাক',
                'status' => 'finished',
                'scorer_code' => 'sc_jbac_athletics_2026',
                'match_datetime' => now()->subDays(4),
                'match_result' => 'জামিরবাড়িয়া ক্লাবের জাহিদুল রানা স্বর্ণপদক বিজয়ী',
                'player_of_match' => 'জাহিদুল ইসলাম রানা (১০.৭২ সে.)',
                'is_streaming' => false,
            ]
        );

        MatchPlayerStat::firstOrCreate(
            ['live_match_id' => $athleticsMatch->id, 'team_player_id' => $athlete1->id],
            [
                'team_id' => $athleticsTeam->id,
                'timing_record' => '10.72s',
                'position_rank' => '১ম স্থান (স্বর্ণপদক)',
                'is_player_of_match' => true,
            ]
        );
    }
}

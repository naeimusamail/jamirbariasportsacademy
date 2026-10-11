<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Sport;
use App\Models\TournamentPlayer;
use App\Models\TournamentTeam;
use App\Models\LiveMatch;

class TournamentRegistrationAndScheduleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sport::firstOrCreate(['id' => 1], [
            'name' => 'ফুটবল',
            'slug' => 'football',
            'code' => 'FTB',
            'monthly_fee' => 1000,
        ]);
    }

    public function test_player_can_register_for_tournament_without_team_and_create_player_account(): void
    {
        $tournament = Tournament::create([
            'name' => 'বিজয় দিবস কাপ ২০২৬',
            'slug' => 'bijoy-dibosh-cup-2026',
            'tournament_type' => 'local',
            'sport_type' => 'football',
            'venue' => 'প্রধান মাঠ',
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'end_date' => now()->addDays(10)->format('Y-m-d'),
            'registration_deadline' => now()->addDays(3)->format('Y-m-d H:i:s'),
            'total_teams' => 4,
            'status' => 'upcoming',
        ]);

        $response = $this->post(route('public.tournaments.register.store', $tournament->slug), [
            'account_action' => 'register',
            'player_name' => 'তানভীর আহমেদ',
            'player_phone' => '01711223344',
            'email' => 'tanvir@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'username' => 'tanvir99',
            'position' => 'Forward',
            'jersey_no' => '10',
            'team_id' => null, // Free agent without team
        ]);

        $response->assertRedirect(route('public.tournaments.show', $tournament->slug));

        $this->assertDatabaseHas('users', [
            'email' => 'tanvir@example.com',
            'username' => 'tanvir99',
            'role' => 'player',
        ]);

        $this->assertDatabaseHas('tournament_players', [
            'tournament_id' => $tournament->id,
            'player_name' => 'তানভীর আহমেদ',
            'player_phone' => '01711223344',
            'team_id' => null,
            'status' => 'registered',
        ]);
    }

    public function test_player_cannot_register_after_registration_deadline(): void
    {
        $tournament = Tournament::create([
            'name' => 'গ্রীষ্মকালীন কাপ',
            'slug' => 'summer-cup-2026',
            'tournament_type' => 'local',
            'sport_type' => 'football',
            'venue' => 'প্রধান মাঠ',
            'start_date' => now()->subDay()->format('Y-m-d'),
            'end_date' => now()->addDays(5)->format('Y-m-d'),
            'registration_deadline' => now()->subHours(2)->format('Y-m-d H:i:s'), // Expired
            'total_teams' => 4,
            'status' => 'ongoing',
        ]);

        $user = User::factory()->create(['role' => 'player']);

        $response = $this->actingAs($user)->post(route('public.tournaments.register.store', $tournament->slug), [
            'player_name' => 'রাকিব হাসান',
            'player_phone' => '01811223344',
            'position' => 'Midfielder',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('tournament_players', [
            'tournament_id' => $tournament->id,
            'player_name' => 'রাকিব হাসান',
        ]);
    }

    public function test_admin_can_generate_schedule_and_matches_are_upcoming(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $teamA = Team::create(['name' => 'টিম রেড', 'slug' => 'team-red', 'sport_type' => 'football']);
        $teamB = Team::create(['name' => 'টিম ব্লু', 'slug' => 'team-blue', 'sport_type' => 'football']);

        $tournament = Tournament::create([
            'name' => 'আন্তঃজেলা গোল্ডকাপ',
            'slug' => 'inter-district-gold-cup',
            'tournament_type' => 'local',
            'sport_type' => 'football',
            'venue' => 'জামিরবাড়িয়া সেন্ট্রাল গ্রাউন্ড',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(6)->format('Y-m-d'),
            'registration_deadline' => now()->addDay()->format('Y-m-d H:i:s'),
            'total_teams' => 2,
            'status' => 'upcoming',
        ]);

        TournamentTeam::create(['tournament_id' => $tournament->id, 'team_id' => $teamA->id]);
        TournamentTeam::create(['tournament_id' => $tournament->id, 'team_id' => $teamB->id]);

        $response = $this->actingAs($admin)->post(route('admin.tournaments.generate-schedule', $tournament));

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('live_matches', [
            'tournament_id' => $tournament->id,
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'status' => 'upcoming',
        ]);
    }

    public function test_admin_can_update_match_schedule_date_time_and_venue(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $tournament = Tournament::create([
            'name' => 'চ্যাম্পিয়ন্স ট্রফি',
            'slug' => 'champions-trophy',
            'tournament_type' => 'academic',
            'sport_type' => 'football',
            'venue' => 'ফিল্ড ১',
            'status' => 'upcoming',
        ]);

        $match = LiveMatch::create([
            'slug' => 'match-one-sample',
            'title' => 'ম্যাচ ১',
            'tournament_id' => $tournament->id,
            'team_a' => 'টিম ১',
            'team_b' => 'টিম ২',
            'status' => 'upcoming',
            'venue' => 'ফিল্ড ১',
            'match_datetime' => now()->addDays(3),
            'scorer_code' => 'TEST12',
        ]);

        $newTime = now()->addDays(4)->format('Y-m-d H:i:s');
        $response = $this->actingAs($admin)->patch(route('admin.tournaments.update-match-schedule', [$tournament, $match]), [
            'match_datetime' => $newTime,
            'venue' => 'মেইন স্টেডিয়াম',
            'status' => 'upcoming',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('live_matches', [
            'id' => $match->id,
            'venue' => 'মেইন স্টেডিয়াম',
            'status' => 'upcoming',
        ]);
    }

    public function test_admin_can_assign_team_to_unassigned_registered_player(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $team = Team::create(['name' => 'গ্রিন টাইগার্স', 'slug' => 'green-tigers', 'sport_type' => 'football']);

        $tournament = Tournament::create([
            'name' => 'স্বাধীনতা কাপ',
            'slug' => 'independence-cup',
            'tournament_type' => 'local',
            'sport_type' => 'football',
            'venue' => 'মাঠ ২',
            'status' => 'upcoming',
        ]);

        TournamentTeam::create(['tournament_id' => $tournament->id, 'team_id' => $team->id]);

        $player = TournamentPlayer::create([
            'tournament_id' => $tournament->id,
            'player_name' => 'হাসান মাহমুদ',
            'player_phone' => '01511223344',
            'team_id' => null, // Free agent
            'status' => 'registered',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.tournaments.assign-player', [$tournament, $player]), [
            'team_id' => $team->id,
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tournament_players', [
            'id' => $player->id,
            'team_id' => $team->id,
            'status' => 'assigned',
        ]);

        $this->assertDatabaseHas('team_players', [
            'team_id' => $team->id,
            'name' => 'হাসান মাহমুদ',
        ]);
    }
}


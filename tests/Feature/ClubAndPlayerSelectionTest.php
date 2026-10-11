<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sport;
use App\Models\Team;
use App\Models\Trainee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClubAndPlayerSelectionTest extends TestCase
{
    protected $admin;
    protected $sport;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sport = Sport::firstOrCreate(['name' => 'ক্রিকেট'], ['icon' => '🏏']);
        $this->admin = User::first() ?? User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_and_register_clubs(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.teams.index'));
        $response->assertStatus(200);
        $response->assertSee('ক্লাব ও টিম রেজিস্ট্রেশন');

        $newClubData = [
            'name' => 'নতুন টেস্ট স্পোর্টস ক্লাব',
            'short_name' => 'NTC',
            'sport_id' => $this->sport->id,
            'category' => 'Senior',
            'coach_name' => 'কোচ জামাল',
            'captain_name' => 'অধিনায়ক রাকিব',
            'description' => 'টেস্ট ক্লাবের বিস্তারিত বিবরণ',
            'status' => 'active',
        ];

        $postResponse = $this->actingAs($this->admin)->post(route('admin.teams.store'), $newClubData);
        $postResponse->assertRedirect();

        $this->assertDatabaseHas('teams', [
            'name' => 'নতুন টেস্ট স্পোর্টস ক্লাব',
            'coach_name' => 'কোচ জামাল',
        ]);
    }

    public function test_local_player_registration_uses_team_selection_and_no_duplicate_sports(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('public.local-players.create'));
        $response->assertStatus(200);
        // Verify team_id selection dropdown is removed as per user request
        $response->assertDontSee('name="team_id"', false);
        // Verify multi-step wizard elements
        $response->assertSee('রেজিস্ট্রেশন উইজার্ড');
        $response->assertSee('ধাপ ৪: চূড়ান্ত প্রিভিউ ও যাচাইকরণ');

        // Submit open registration without team_id
        $playerData = [
            'sports' => [$this->sport->id],
            'name' => 'সাকিব হাসান টেস্ট',
            'phone' => '01799887766',
            'emergency_phone' => '01899887766',
            'guardian_name' => 'অভিভাবক টেস্ট',
            'date_of_birth' => '2005-05-15',
            'category' => 'Senior',
            'position' => 'অলরাউন্ডার',
            'jersey_no' => '75',
            'address' => 'সাতক্ষীরা সদর',
        ];

        $postResponse = $this->post(route('public.local-players.store'), $playerData);
        $postResponse->assertSessionHasNoErrors();
        $postResponse->assertRedirect();

        $this->assertDatabaseHas('trainees', [
            'name' => 'সাকিব হাসান টেস্ট',
            'player_type' => 'local',
        ]);
    }
}

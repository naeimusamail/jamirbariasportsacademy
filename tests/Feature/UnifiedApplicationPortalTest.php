<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Sport;
use App\Models\Team;
use App\Models\RegistrationCircular;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnifiedApplicationPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sport::firstOrCreate(['name' => 'ক্রিকেট'], ['icon' => '🏏', 'description' => 'ক্রিকেট']);
        Sport::firstOrCreate(['name' => 'ফুটবল'], ['icon' => '⚽', 'description' => 'ফুটবল']);

        RegistrationCircular::ofType('admission');
        RegistrationCircular::ofType('volunteer');
        RegistrationCircular::ofType('local_player');
    }

    public function test_unified_application_portal_renders_all_three_tracks()
    {
        $response = $this->get(route('public.apply'));

        $response->assertStatus(200);
        $response->assertSee('অনলাইন আবেদন ও নিবন্ধন পোর্টাল');
        $response->assertSee('একাডেমি প্রশিক্ষণার্থী ভর্তি');
        $response->assertSee('লোকাল প্লেয়ার টুর্নামেন্ট পাস');
        $response->assertSee('অফিসিয়াল ভলান্টিয়ার উইং');
    }

    public function test_accessing_admission_shows_unified_portal_with_admission_form()
    {
        $response = $this->get(route('admission.create'));

        $response->assertStatus(200);
        $response->assertSee('অনলাইন আবেদন ও নিবন্ধন পোর্টাল');
        $response->assertSee('নতুন প্লেয়ার ভর্তি আবেদন');
    }

    public function test_accessing_volunteer_shows_unified_portal_with_volunteer_form()
    {
        $response = $this->get(route('volunteer.create'));

        $response->assertStatus(200);
        $response->assertSee('অনলাইন আবেদন ও নিবন্ধন পোর্টাল');
        $response->assertSee('স্বেচ্ছাসেবক আবেদন ফরম');
    }

    public function test_accessing_local_player_shows_unified_portal_with_local_player_form()
    {
        $response = $this->get(route('public.local-players.create'));

        $response->assertStatus(200);
        $response->assertSee('অনলাইন আবেদন ও নিবন্ধন পোর্টাল');
        $response->assertSee('লোকাল প্লেয়ার রেজিস্ট্রেশন উইজার্ড');
    }

    public function test_home_page_and_notice_hub_link_to_unified_application_portal()
    {
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee(route('public.apply'));

        $hubResponse = $this->get(route('public.notice-board'));
        $hubResponse->assertStatus(200);
        $hubResponse->assertSee(route('public.apply'));
    }
}


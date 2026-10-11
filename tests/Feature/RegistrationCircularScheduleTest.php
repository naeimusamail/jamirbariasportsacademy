<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\RegistrationCircular;
use App\Models\Tournament;
use App\Models\Sport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationCircularScheduleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure default circulars exist
        RegistrationCircular::ofType('admission');
        RegistrationCircular::ofType('volunteer');
        RegistrationCircular::ofType('local_player');

        Sport::firstOrCreate(['name' => 'ফুটবল'], ['icon' => '⚽', 'description' => 'ফুটবল বিভাগ']);
    }

    public function test_admin_can_view_circulars_management_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.circulars.index'));
        $response->assertStatus(200);
        $response->assertSee('রেজিস্ট্রেশন সার্কুলার ও ডেডলাইন হাব');
        $response->assertSee('একাডেমি ভর্তি আবেদন');
        $response->assertSee('স্বেচ্ছাসেবক (ভলান্টিয়ার) নিবন্ধন');
    }

    public function test_admin_can_update_circular_dates_and_messages()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $circular = RegistrationCircular::where('type', 'admission')->first();

        $startDate = now()->addDays(2)->format('Y-m-d H:i:s');
        $endDate = now()->addDays(10)->format('Y-m-d H:i:s');

        $response = $this->actingAs($admin)->put(route('admin.circulars.update', $circular->id), [
            'title' => 'নতুন ২০২৬ ভর্তি সার্কুলার',
            'description' => 'ভর্তি বিজ্ঞপ্তি আপডেট বিবরণী',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => '1',
            'upcoming_message' => 'আগামী পরশু থেকে ভর্তি ফরম চালু হবে।',
            'closed_message' => 'ভর্তির সময় শেষ হয়ে গেছে।',
        ]);

        $response->assertSessionHas('success');

        $circular->refresh();
        $this->assertEquals('নতুন ২০২৬ ভর্তি সার্কুলার', $circular->title);
        $this->assertEquals('upcoming', $circular->getStatus());
        $this->assertTrue($circular->isUpcoming());
        $this->assertFalse($circular->isOpen());
    }

    public function test_admin_can_toggle_circular_active_state()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $circular = RegistrationCircular::where('type', 'admission')->first();

        $this->assertTrue($circular->is_active);

        $response = $this->actingAs($admin)->patch(route('admin.circulars.toggle', $circular->id));
        $response->assertSessionHas('success');

        $circular->refresh();
        $this->assertFalse($circular->is_active);
        $this->assertEquals('paused', $circular->getStatus());
        $this->assertFalse($circular->isOpen());
    }

    public function test_upcoming_admission_circular_blocks_submission_and_shows_upcoming_banner()
    {
        $circular = RegistrationCircular::where('type', 'admission')->first();
        $circular->update([
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(15),
            'is_active' => true,
            'upcoming_message' => 'খুব শীঘ্রই নতুন শিক্ষার্থীবৃন্দের ভর্তি শুরু হচ্ছে!',
        ]);

        // GET should show upcoming status
        $response = $this->get(route('admission.create'));
        $response->assertStatus(200);
        $response->assertSee('নিবন্ধন আসন্ন (Upcoming)');
        $response->assertSee('খুব শীঘ্রই নতুন শিক্ষার্থীবৃন্দের ভর্তি শুরু হচ্ছে!');
        $response->assertDontSee('জমা দিন ও আবেদন নিশ্চিত করুন');

        // POST should be rejected
        $postResponse = $this->post(route('admission.store'), [
            'name' => 'রাকিব হাসান',
            'guardian_name' => 'আব্দুর রহিম',
            'phone' => '01711223344',
            'date_of_birth' => '2010-05-15',
            'category' => 'U-16',
            'address' => 'ময়মনসিংহ',
            'payment_method' => 'cash',
            'payment_amount' => 1000,
        ]);

        $postResponse->assertSessionHas('error');
    }

    public function test_closed_admission_circular_blocks_submission_and_shows_closed_banner()
    {
        $circular = RegistrationCircular::where('type', 'admission')->first();
        $circular->update([
            'start_date' => now()->subDays(10),
            'end_date' => now()->subHour(), // Expired
            'is_active' => true,
            'closed_message' => '২০২৬ সালের ভর্তি সময়সীমা শেষ হয়েছে।',
        ]);

        $response = $this->get(route('admission.create'));
        $response->assertStatus(200);
        $response->assertSee('আবেদন গ্রহণ বন্ধ (Closed)');
        $response->assertSee('২০২৬ সালের ভর্তি সময়সীমা শেষ হয়েছে।');
        $response->assertDontSee('জমা দিন ও আবেদন নিশ্চিত করুন');

        $postResponse = $this->post(route('admission.store'), [
            'name' => 'রাকিব হাসান',
            'guardian_name' => 'আব্দুর রহিম',
            'phone' => '01711223344',
            'date_of_birth' => '2010-05-15',
            'category' => 'U-16',
            'address' => 'ময়মনসিংহ',
            'payment_method' => 'cash',
            'payment_amount' => 1000,
        ]);

        $postResponse->assertSessionHas('error');
    }

    public function test_volunteer_circular_schedule_start_and_deadline()
    {
        $circular = RegistrationCircular::where('type', 'volunteer')->first();

        // 1. Upcoming
        $circular->update([
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(7),
            'is_active' => true,
            'upcoming_message' => 'ভলান্টিয়ার আবেদন আগামী শুক্রবার শুরু হবে।',
        ]);

        $response = $this->get(route('volunteer.create'));
        $response->assertStatus(200);
        $response->assertSee('আবেদন আসন্ন (Upcoming)');
        $response->assertSee('ভলান্টিয়ার আবেদন আগামী শুক্রবার শুরু হবে।');

        $postResponse = $this->post(route('volunteer.store'), [
            'name' => 'সাকিব',
            'phone' => '01799887766',
            'gender' => 'male',
            'tshirt_size' => 'M',
            'department' => 'ground',
            'address' => 'ফুলপুর',
        ]);
        $postResponse->assertSessionHas('error');

        // 2. Closed
        $circular->update([
            'start_date' => now()->subDays(5),
            'end_date' => now()->subMinute(),
        ]);

        $response2 = $this->get(route('volunteer.create'));
        $response2->assertStatus(200);
        $response2->assertSee('আবেদন গ্রহণ বন্ধ (Closed)');
    }

    public function test_local_player_circular_schedule_start_and_deadline()
    {
        $circular = RegistrationCircular::where('type', 'local_player')->first();

        // 1. Upcoming
        $circular->update([
            'start_date' => now()->addHours(5),
            'end_date' => now()->addDays(5),
            'is_active' => true,
            'upcoming_message' => 'ড্রাফট খুব শীঘ্রই শুরু হবে।',
        ]);

        $response = $this->get(route('public.local-players.create'));
        $response->assertStatus(200);
        $response->assertSee('নিবন্ধন আসন্ন (Upcoming)');

        $postResponse = $this->post(route('public.local-players.store'), [
            'name' => 'কামাল',
            'phone' => '01712000000',
            'date_of_birth' => '2008-01-01',
            'category' => 'U-16',
            'address' => 'জামিরবাড়িয়া',
        ]);
        $postResponse->assertSessionHas('error');
    }

    public function test_tournament_registration_with_upcoming_and_deadline()
    {
        $sport = Sport::first();
        $tournament = Tournament::create([
            'name' => 'প্রিমিয়ার গোল্ড কাপ ২০২৬',
            'slug' => 'premier-gold-cup-2026',
            'sport_id' => $sport->id,
            'sport_type' => 'football',
            'venue' => 'প্রধান স্টেডিয়াম',
            'registration_start_date' => now()->addDays(2),
            'registration_deadline' => now()->addDays(7),
            'status' => 'upcoming',
            'total_teams' => 8,
        ]);

        // Upcoming registration
        $this->assertTrue($tournament->isRegistrationUpcoming());
        $this->assertFalse($tournament->isRegistrationOpen());

        $response = $this->get(route('public.tournaments.register', $tournament->slug));
        $response->assertRedirect(route('public.tournaments.show', $tournament->slug));
        $response->assertSessionHas('error');

        // Expired registration
        $tournament->update([
            'registration_start_date' => now()->subDays(5),
            'registration_deadline' => now()->subHour(),
        ]);
        $tournament->refresh();

        $this->assertFalse($tournament->isRegistrationUpcoming());
        $this->assertFalse($tournament->isRegistrationOpen());
        $this->assertTrue($tournament->isRegistrationClosed());

        $response2 = $this->get(route('public.tournaments.register', $tournament->slug));
        $response2->assertRedirect(route('public.tournaments.show', $tournament->slug));
        $response2->assertSessionHas('error');
    }

    public function test_creating_tournament_event_automatically_creates_registration_circular()
    {
        $sport = Sport::first();
        $tournament = Tournament::create([
            'name' => 'বিজয় দিবস কাপ ২০২৬',
            'tournament_type' => 'local',
            'sport_id' => $sport->id,
            'sport_type' => 'football',
            'venue' => 'জামিরবাড়িয়া প্রধান মাঠ',
            'registration_start_date' => now()->addDay(),
            'registration_deadline' => now()->addDays(8),
            'status' => 'upcoming',
            'total_teams' => 16,
        ]);

        // Assert circular was automatically created
        $circular = RegistrationCircular::where('tournament_id', $tournament->id)->first();
        $this->assertNotNull($circular);
        $this->assertStringContainsString('বিজয় দিবস কাপ ২০২৬', $circular->title);
        $this->assertEquals('tournament_' . $tournament->id, $circular->type);
        $this->assertTrue($circular->is_active);
        $this->assertEquals($tournament->registration_start_date->format('Y-m-d H:i:s'), $circular->start_date->format('Y-m-d H:i:s'));
        $this->assertEquals($tournament->registration_deadline->format('Y-m-d H:i:s'), $circular->end_date->format('Y-m-d H:i:s'));

        // Admin circulars hub displays this event circular
        $admin = User::factory()->create(['role' => 'admin']);
        $adminResponse = $this->actingAs($admin)->get(route('admin.circulars.index'));
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('বিজয় দিবস কাপ ২০২৬');

        // When tournament updates, circular syncs
        $tournament->update([
            'name' => 'বিজয় দিবস গোল্ড কাপ ২০২৬ (আপডেট)',
            'registration_deadline' => now()->addDays(12),
        ]);

        $circular->refresh();
        $this->assertStringContainsString('বিজয় দিবস গোল্ড কাপ ২০২৬ (আপডেট)', $circular->title);
        $this->assertEquals($tournament->registration_deadline->format('Y-m-d H:i:s'), $circular->end_date->format('Y-m-d H:i:s'));

        // When tournament is deleted, circular is removed
        $tournament->delete();
        $this->assertNull(RegistrationCircular::where('tournament_id', $tournament->id)->first());
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\RegistrationCircular;
use App\Models\AdmissionApplication;
use App\Models\Tournament;
use App\Models\Sport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CircularBasedApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sport::firstOrCreate(['name' => 'ফুটবল'], ['icon' => '⚽', 'description' => 'ফুটবল বিভাগ']);
        Sport::firstOrCreate(['name' => 'ক্রিকেট'], ['icon' => '🏏', 'description' => 'ক্রিকেট বিভাগ']);

        // Default circulars
        RegistrationCircular::ofType('admission');
        RegistrationCircular::ofType('volunteer');
        RegistrationCircular::ofType('local_player');
    }

    public function test_admin_can_create_new_admission_circular()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.circulars.store'), [
            'type' => 'admission',
            'title' => '২০২৬ সামার ফুটবল ও ক্রিকেট একাডেমি ভর্তি ক্যাম্প',
            'description' => 'গ্রীষ্মকালীন বিশেষ ভর্তি প্রশিক্ষণ কার্যক্রম।',
            'fee' => 750,
            'start_date' => now()->subDay()->format('Y-m-d\TH:i'),
            'end_date' => now()->addDays(20)->format('Y-m-d\TH:i'),
            'upcoming_message' => 'ক্যাম্প শীঘ্রই শুরু হবে।',
            'closed_message' => 'ক্যাম্পের ভর্তি শেষ।',
            'is_active' => '1',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('registration_circulars', [
            'title' => '২০২৬ সামার ফুটবল ও ক্রিকেট একাডেমি ভর্তি ক্যাম্প',
            'type' => 'admission',
            'fee' => 750,
        ]);
    }

    public function test_admission_application_is_stored_under_specific_circular()
    {
        $sport = Sport::first();

        $customCircular = RegistrationCircular::create([
            'type' => 'admission',
            'title' => 'অনূর্ধ্ব-১৬ ফুটবল বিশেষ ভর্তি সেশন',
            'fee' => 500,
            'is_active' => true,
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDays(10),
        ]);

        // Form renders with specific circular
        $response = $this->get(route('admission.create', ['circular_id' => $customCircular->id]));
        $response->assertStatus(200);
        $response->assertSee('অনূর্ধ্ব-১৬ ফুটবল বিশেষ ভর্তি সেশন');
        $response->assertSee('500');

        // Submit application specifying the circular_id
        $postResponse = $this->post(route('admission.store'), [
            'circular_id' => $customCircular->id,
            'sport_id' => $sport->id,
            'sports' => [$sport->id],
            'name' => 'তানভীর আহমেদ',
            'guardian_name' => 'আব্দুল হাকিম',
            'phone' => '01799887766',
            'date_of_birth' => '2010-08-20',
            'category' => 'U-16',
            'address' => 'জামিরবাড়িয়া',
            'payment_method' => 'cash',
            'payment_amount' => 500,
        ]);

        $postResponse->assertSessionHasNoErrors();
        $this->assertDatabaseHas('admission_applications', [
            'name' => 'তানভীর আহমেদ',
            'registration_circular_id' => $customCircular->id,
        ]);
    }

    public function test_admin_can_filter_applications_by_circular()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $sport = Sport::first();

        $circular1 = RegistrationCircular::create([
            'type' => 'admission',
            'title' => 'সার্কুলার এক',
            'is_active' => true,
        ]);

        $circular2 = RegistrationCircular::create([
            'type' => 'admission',
            'title' => 'সার্কুলার দুই',
            'is_active' => true,
        ]);

        $app1 = AdmissionApplication::create([
            'application_no' => 'APP-2026-901',
            'registration_circular_id' => $circular1->id,
            'sport_id' => $sport->id,
            'name' => 'আবেদনকারী এক',
            'guardian_name' => 'অভিভাবক এক',
            'phone' => '01700000001',
            'date_of_birth' => '2010-01-01',
            'category' => 'U-14',
            'address' => 'ময়মনসিংহ',
            'payment_method' => 'cash',
            'payment_amount' => 500,
        ]);

        $app2 = AdmissionApplication::create([
            'application_no' => 'APP-2026-902',
            'registration_circular_id' => $circular2->id,
            'sport_id' => $sport->id,
            'name' => 'আবেদনকারী দুই',
            'guardian_name' => 'অভিভাবক দুই',
            'phone' => '01700000002',
            'date_of_birth' => '2010-02-02',
            'category' => 'U-16',
            'address' => 'ময়মনসিংহ',
            'payment_method' => 'cash',
            'payment_amount' => 500,
        ]);

        // Filter by circular 1
        $response = $this->actingAs($admin)->get(route('admin.admissions.index', ['circular_id' => $circular1->id]));
        $response->assertStatus(200);
        $response->assertSee('আবেদনকারী এক');
        $response->assertDontSee('আবেদনকারী দুই');
    }

    public function test_tournament_creation_syncs_circular_and_apply_url_points_to_tournament_register()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $tournament = Tournament::create([
            'name' => 'গোল্ড কাপ টুর্নামেন্ট ২০২৬',
            'slug' => 'gold-cup-2026',
            'sport_type' => 'football',
            'tournament_type' => 'local',
            'venue' => 'একাডেমি স্টেডিয়াম',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(20),
            'registration_start_date' => now()->subDay(),
            'registration_deadline' => now()->addDays(5),
            'total_teams' => 16,
            'entry_fee' => 1500,
            'status' => 'upcoming',
        ]);

        $circular = RegistrationCircular::where('tournament_id', $tournament->id)->first();
        $this->assertNotNull($circular);
        $this->assertEquals(route('public.tournaments.register', 'gold-cup-2026'), $circular->apply_url);
        $this->assertTrue($circular->isOpen());
    }

    public function test_home_page_shows_circular_details_modal_and_apply_links()
    {
        $customCircular = RegistrationCircular::create([
            'type' => 'admission',
            'title' => 'স্পেশাল একাডেমি ভর্তি ২০২৬',
            'description' => 'সকল আগ্রহী খেলোয়াড়দের জন্য ভর্তি আহ্বান।',
            'fee' => 1200,
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('স্পেশাল একাডেমি ভর্তি ২০২৬');
        $response->assertSee(route('admission.create', ['circular_id' => $customCircular->id]));
        $response->assertSee('activeCircular');
    }
}

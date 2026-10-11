<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VolunteerManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_volunteer_application_form_loads()
    {
        $response = $this->get(route('volunteer.create'));
        $response->assertStatus(200);
        $response->assertSee('স্বেচ্ছাসেবক আবেদন ফরম');
    }

    public function test_public_volunteer_application_stores_and_converts_bangla_digits()
    {
        $response = $this->post(route('volunteer.store'), [
            'name' => 'তানভীর আহমেদ',
            'name_en' => 'Tanvir Ahmed',
            'phone' => '০১৭১২-৩৪৫৬৭৮', // Bangla digits should convert to 01712-345678
            'emergency_phone' => '০১৮১২-৯৮৭৬৫৪',
            'email' => 'tanvir@example.com',
            'gender' => 'male',
            'blood_group' => 'B+',
            'tshirt_size' => 'L',
            'department' => 'ground',
            'organization_or_institution' => 'ঢাকা কলেজ',
            'address' => 'জামিরবাড়িয়া, ফুলপুর, ময়মনসিংহ',
            'experience' => 'পূর্বে ৩টি টুর্নামেন্টে ভলান্টিয়ার করেছি।',
        ]);

        $volunteer = Volunteer::first();
        $this->assertNotNull($volunteer);
        $this->assertEquals('তানভীর আহমেদ', $volunteer->name);
        $this->assertEquals('Tanvir Ahmed', $volunteer->name_en);
        $this->assertEquals('01712-345678', $volunteer->phone); // Converted English digits!
        $this->assertEquals('01812-987654', $volunteer->emergency_phone);
        $this->assertStringStartsWith('VOL-', $volunteer->volunteer_no);
        $this->assertEquals('pending', $volunteer->status);

        $response->assertRedirect(route('volunteer.tracking', $volunteer->volunteer_no));
    }

    public function test_volunteer_tracking_and_printable_id_card_render()
    {
        $volunteer = Volunteer::create([
            'volunteer_no' => 'VOL-2026-001',
            'name' => 'রাকিবুল হাসান',
            'name_en' => 'Rakibul Hasan',
            'phone' => '01700000000',
            'gender' => 'male',
            'tshirt_size' => 'XL',
            'department' => 'medical',
            'address' => 'ময়মনসিংহ',
            'status' => 'approved',
            'assigned_duties' => 'ফার্স্ট এইড ও প্রাথমিক চিকিৎসা বক্স হ্যান্ডলিং',
            'assigned_venue' => 'প্রধান গ্রাউন্ড',
        ]);

        // Tracking page
        $trackResponse = $this->get(route('volunteer.tracking', $volunteer->volunteer_no));
        $trackResponse->assertStatus(200);
        $trackResponse->assertSee('VOL-2026-001');
        $trackResponse->assertSee('ফার্স্ট এইড ও প্রাথমিক চিকিৎসা');

        // Printable ID badge
        $idResponse = $this->get(route('volunteer.id-card', $volunteer->volunteer_no));
        $idResponse->assertStatus(200);
        $idResponse->assertSee('OFFICIAL VOLUNTEER');
        $idResponse->assertSee('VOL-2026-001');
    }

    public function test_admin_can_view_volunteers_hub_and_update_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $volunteer = Volunteer::create([
            'volunteer_no' => 'VOL-2026-002',
            'name' => 'আরিফুল ইসলাম',
            'phone' => '01711111111',
            'gender' => 'male',
            'tshirt_size' => 'M',
            'department' => 'security',
            'address' => 'জামিরবাড়িয়া',
            'status' => 'pending',
        ]);

        // Admin index
        $indexResponse = $this->actingAs($admin)->get(route('admin.volunteers.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('VOL-2026-002');

        // Admin update status to approved
        $statusResponse = $this->actingAs($admin)->post(route('admin.volunteers.update-status', $volunteer->id), [
            'status' => 'approved',
        ]);
        $statusResponse->assertSessionHas('success');

        $this->assertEquals('approved', $volunteer->fresh()->status);
        $this->assertNotNull($volunteer->fresh()->approved_at);
    }

    public function test_admin_can_assign_volunteer_duty_and_tournament()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $tournament = Tournament::create([
            'name' => 'জামিরবাড়িয়া কাপ ২০২৬',
            'slug' => 'jamirbaria-cup-2026',
            'sport_type' => 'cricket',
            'status' => 'ongoing',
            'start_date' => now(),
        ]);

        $volunteer = Volunteer::create([
            'volunteer_no' => 'VOL-2026-003',
            'name' => 'হাসান মাহমুদ',
            'phone' => '01722222222',
            'gender' => 'male',
            'tshirt_size' => 'L',
            'department' => 'media',
            'address' => 'ফুলপুর',
            'status' => 'pending',
        ]);

        $assignResponse = $this->actingAs($admin)->post(route('admin.volunteers.assign-duty', $volunteer->id), [
            'assigned_duties' => 'লাইভ স্ট্রিম ক্যামেরা ও ফটোগ্রাফি হ্যান্ডলিং',
            'assigned_venue' => 'ভিআইপি প্রেস গ্যালারি',
            'tournament_id' => $tournament->id,
            'department' => 'media',
        ]);

        $assignResponse->assertSessionHas('success');

        $volunteer->refresh();
        $this->assertEquals('approved', $volunteer->status);
        $this->assertEquals('লাইভ স্ট্রিম ক্যামেরা ও ফটোগ্রাফি হ্যান্ডলিং', $volunteer->assigned_duties);
        $this->assertEquals('ভিআইপি প্রেস গ্যালারি', $volunteer->assigned_venue);
        $this->assertEquals($tournament->id, $volunteer->tournament_id);
    }
}

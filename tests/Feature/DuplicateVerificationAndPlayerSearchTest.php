<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sport;
use App\Models\Trainee;
use App\Models\Batch;
use App\Services\PlayerDocumentVerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DuplicateVerificationAndPlayerSearchTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Sport $sport;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'username' => 'superadmin',
            'email' => 'admin@jamirbaria.test',
        ]);

        $this->sport = Sport::create([
            'name' => 'ফুটবল (Football)',
            'type' => 'team',
            'icon' => '⚽',
        ]);
    }

    public function test_verification_service_detects_duplicate_nid_and_phone()
    {
        Trainee::create([
            'admission_no' => 'JSA-2026-101',
            'player_type' => 'academic',
            'sport_id' => $this->sport->id,
            'name' => 'সাকিব আল হাসান',
            'guardian_name' => 'অভিভাবক',
            'phone' => '01711223344',
            'date_of_birth' => '1995-05-15',
            'nid_or_birth_cert' => '19951234567890123',
            'category' => 'Senior',
            'address' => 'ঢাকা',
            'monthly_fee' => 1000,
            'admission_date' => '2026-01-01',
            'status' => 'active',
        ]);

        $service = app(PlayerDocumentVerificationService::class);

        // 1. Exact NID match
        $report1 = $service->checkDuplicate([
            'nid_or_birth_cert' => '19951234567890123',
            'phone' => '01899999999',
        ]);
        $this->assertTrue($report1['is_strict_duplicate']);
        $this->assertEquals('danger', $report1['severity']);

        // 2. Formatted NID match (with dashes/spaces)
        $report2 = $service->checkDuplicate([
            'nid_or_birth_cert' => '1995-1234-5678-90123',
            'phone' => '01899999999',
        ]);
        $this->assertTrue($report2['is_strict_duplicate']);

        // 3. Phone match with +88 prefix
        $report3 = $service->checkDuplicate([
            'phone' => '+8801711223344',
            'nid_or_birth_cert' => '9999999999',
        ]);
        $this->assertTrue($report3['is_strict_duplicate']);

        // 4. Suspected duplicate by Name + DOB
        $report4 = $service->checkDuplicate([
            'name' => 'সাকিব আল হাসান',
            'date_of_birth' => '1995-05-15',
            'phone' => '01500000000',
            'nid_or_birth_cert' => '5555555555',
        ]);
        $this->assertTrue($report4['has_duplicate']);
        $this->assertEquals('warning', $report4['severity']);

        // 5. Clean unique record
        $report5 = $service->checkDuplicate([
            'name' => 'মুশফিকুর রহিম',
            'date_of_birth' => '1998-09-01',
            'phone' => '01688888888',
            'nid_or_birth_cert' => '7777777777',
        ]);
        $this->assertFalse($report5['has_duplicate']);
        $this->assertEquals('clean', $report5['severity']);
    }

    public function test_realtime_verification_api_endpoint()
    {
        Trainee::create([
            'admission_no' => 'JSA-2026-102',
            'player_type' => 'academic',
            'sport_id' => $this->sport->id,
            'name' => 'তামিম ইকবাল',
            'guardian_name' => 'অভিভাবক',
            'phone' => '01811223344',
            'nid_or_birth_cert' => '1234567890',
            'category' => 'Senior',
            'address' => 'চট্টগ্রাম',
            'monthly_fee' => 1200,
            'admission_date' => '2026-01-01',
            'status' => 'active',
        ]);

        $response = $this->postJson(route('api.verify-player-document'), [
            'phone' => '01811223344',
            'nid_or_birth_cert' => '1234567890',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'report' => [
                'has_duplicate' => true,
                'is_strict_duplicate' => true,
            ],
        ]);
    }

    public function test_local_player_registration_blocks_duplicate_document()
    {
        Trainee::create([
            'admission_no' => 'JSA-LOC-001',
            'player_type' => 'local',
            'sport_id' => $this->sport->id,
            'name' => 'লিটন দাস',
            'guardian_name' => 'অভিভাবক',
            'phone' => '01700112233',
            'nid_or_birth_cert' => '8888999911',
            'category' => 'Senior',
            'address' => 'দিনাজপুর',
            'monthly_fee' => 0,
            'admission_date' => '2026-01-01',
            'status' => 'active',
        ]);

        $initialCount = Trainee::where('player_type', 'local')->count();

        // Attempt to register local player with same NID
        $response = $this->post(route('public.local-players.store'), [
            'sports' => [$this->sport->id],
            'name' => 'নতুন লিটন',
            'phone' => '01900112233',
            'date_of_birth' => '1996-02-02',
            'category' => 'Senior',
            'address' => 'দিনাজপুর',
            'nid_or_birth_cert' => '8888999911', // Duplicate!
        ]);

        $response->assertSessionHasErrors('nid_or_birth_cert');
        $this->assertEquals($initialCount, Trainee::where('player_type', 'local')->count());
    }

    public function test_universal_player_search_finds_by_various_fields()
    {
        $playerUser = User::factory()->create([
            'role' => 'player',
            'username' => 'mashrafe02',
            'email' => 'mashrafe@jamirbaria.test',
        ]);

        $trainee = Trainee::create([
            'admission_no' => 'JSA-2026-777',
            'player_type' => 'academic',
            'sport_id' => $this->sport->id,
            'name' => 'মাশরাফি বিন মর্তুজা',
            'guardian_name' => 'অভিভাবক',
            'phone' => '01755667788',
            'nid_or_birth_cert' => '19835566778899',
            'category' => 'Senior',
            'jersey_no' => '02',
            'position' => 'পেস বোলার',
            'address' => 'নড়াইল',
            'monthly_fee' => 1500,
            'admission_date' => '2026-01-01',
            'status' => 'active',
        ]);

        $playerUser->update(['trainee_id' => $trainee->id]);

        // Search by Admission ID
        $resId = $this->actingAs($this->admin)->get(route('admin.players.search', ['q' => 'JSA-2026-777']));
        $resId->assertStatus(200);
        $resId->assertSee('মাশরাফি বিন মর্তুজা');

        // Search by Username
        $resUser = $this->actingAs($this->admin)->get(route('admin.players.search', ['q' => 'mashrafe02']));
        $resUser->assertStatus(200);
        $resUser->assertSee('JSA-2026-777');

        // Search by Email
        $resMail = $this->actingAs($this->admin)->get(route('admin.players.search', ['q' => 'mashrafe@jamirbaria.test']));
        $resMail->assertStatus(200);
        $resMail->assertSee('মাশরাফি বিন মর্তুজা');

        // Search by NID
        $resNid = $this->actingAs($this->admin)->get(route('admin.players.search', ['q' => '19835566778899']));
        $resNid->assertStatus(200);
        $resNid->assertSee('মাশরাফি বিন মর্তুজা');

        // Search by Phone
        $resPhone = $this->actingAs($this->admin)->get(route('admin.players.search', ['q' => '01755667788']));
        $resPhone->assertStatus(200);
        $resPhone->assertSee('মাশরাফি বিন মর্তুজা');
    }

    public function test_admin_duplicate_audit_hub_renders_successfully()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.duplicate-audit.index'));
        $response->assertStatus(200);
        $response->assertSee('ডুপ্লিকেট ডকুমেন্ট ও প্লেয়ার অডিট হাব');
    }
}

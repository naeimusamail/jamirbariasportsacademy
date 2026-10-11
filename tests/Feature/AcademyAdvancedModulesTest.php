<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Trainee;
use App\Models\AdmissionApplication;
use App\Models\Sport;
use App\Models\Batch;

class AcademyAdvancedModulesTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first() ?? User::factory()->create();
        \App\Models\RegistrationCircular::where('type', 'admission')->update([
            'is_active' => true,
            'start_date' => null,
            'end_date' => null,
        ]);
    }

    public function test_public_routes_render_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/live');
        $response->assertStatus(200);

        $response = $this->get('/admission');
        $response->assertStatus(200);

        $response = $this->get('/admission/track');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_renders_with_advanced_metrics(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_admissions_workflow_renders(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/admissions');
        $response->assertStatus(200);

        $application = AdmissionApplication::first();
        if ($application) {
            $response = $this->actingAs($this->admin)->get("/admin/admissions/{$application->id}");
            $response->assertStatus(200);
        }
    }

    public function test_player_fitness_performance_renders(): void
    {
        $response = $this->actingAs($this->admin)->get('/performances');
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get('/performances/create');
        $response->assertStatus(200);

        $trainee = Trainee::first();
        if ($trainee) {
            $response = $this->actingAs($this->admin)->get("/performances/{$trainee->id}");
            $response->assertStatus(200);
        }
    }

    public function test_academy_expenses_and_accounting_renders(): void
    {
        $response = $this->actingAs($this->admin)->get('/expenses');
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get('/expenses/create');
        $response->assertStatus(200);
    }

    public function test_trainee_profile_and_id_card_renders(): void
    {
        $sport = Sport::first() ?? Sport::create(['name' => 'ক্রিকেট', 'code' => 'CR', 'status' => 'active']);
        $trainee = Trainee::first() ?? Trainee::create([
            'admission_no' => 'JSA-TEST-999',
            'sport_id' => $sport->id,
            'name' => 'টেস্ট প্লেয়ার ২',
            'guardian_name' => 'অভিভাবক',
            'phone' => '01711223344',
            'category' => 'U-16',
            'monthly_fee' => 1000,
            'admission_date' => date('Y-m-d'),
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get("/trainees/{$trainee->id}");
        $response->assertStatus(200);
        $response->assertSee('আইডি কার্ড প্রিন্ট');
    }

    public function test_admission_submission_with_manual_payment_and_cropped_photo(): void
    {
        $sport = Sport::first() ?? Sport::create([
            'name' => 'ফুটবল',
            'code' => 'FB',
            'status' => 'active'
        ]);

        // 1x1 transparent png in base64 data URI
        $dummyBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        $response = $this->post('/admission', [
            'sport_id' => $sport->id,
            'name' => 'সাকিবুল হাসান',
            'guardian_name' => 'মাসুদ রানা',
            'phone' => '01711122233',
            'emergency_phone' => '01811122233',
            'date_of_birth' => '2010-05-15',
            'blood_group' => 'B+',
            'category' => 'U-16',
            'position' => 'মিডফিল্ডার',
            'address' => 'জামিরবাড়িয়া, ময়মনসিংহ',
            'payment_method' => 'bkash',
            'payment_amount' => 1000,
            'transaction_id' => 'BKASH992819',
            'sender_number' => '01711122233',
            'cropped_photo' => $dummyBase64,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('admission_applications', [
            'name' => 'সাকিবুল হাসান',
            'payment_method' => 'bkash',
            'transaction_id' => 'BKASH992819',
            'sender_number' => '01711122233',
        ]);
    }

    public function test_payment_management_with_manual_payment(): void
    {
        $trainee = Trainee::first();
        if (!$trainee) {
            $sport = Sport::first() ?? Sport::create(['name' => 'ক্রিকেট', 'code' => 'CR', 'status' => 'active']);
            $trainee = Trainee::create([
                'admission_no' => 'JSA-TEST-001',
                'sport_id' => $sport->id,
                'name' => 'টেস্ট প্লেয়ার',
                'guardian_name' => 'অভিভাবক',
                'phone' => '01700000000',
                'category' => 'U-16',
                'monthly_fee' => 1000,
                'admission_date' => date('Y-m-d'),
                'status' => 'active',
            ]);
        }

        $response = $this->actingAs($this->admin)->post('/payments', [
            'invoice_no' => 'INV-TEST-' . uniqid(),
            'trainee_id' => $trainee->id,
            'title' => 'মাসিক প্রশিক্ষণ ফি',
            'fee_type' => 'monthly',
            'amount' => 1200,
            'month' => 'অক্টোবর',
            'year' => '2026',
            'payment_method' => 'rocket',
            'transaction_id' => 'RCK8827461',
            'sender_number' => '01700000000-9',
            'received_by' => 'হিসাবরক্ষক',
            'status' => 'paid',
            'payment_date' => date('Y-m-d'),
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('payments', [
            'trainee_id' => $trainee->id,
            'payment_method' => 'rocket',
            'transaction_id' => 'RCK8827461',
        ]);
    }
}

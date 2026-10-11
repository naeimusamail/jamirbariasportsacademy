<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Sport;
use App\Models\Batch;
use App\Models\Trainee;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\LiveMatch;

class NewSaaSFeaturesUpgradeTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Sport $cricket;
    protected Batch $morningBatch;
    protected Trainee $trainee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'username' => 'admin_tester',
        ]);

        $this->cricket = Sport::create([
            'name' => 'ক্রিকেট',
            'slug' => 'cricket',
            'icon' => 'cricket-bat',
            'type' => 'team',
        ]);

        $this->morningBatch = Batch::create([
            'sport_id' => $this->cricket->id,
            'name' => 'সকালের ব্যাচ',
            'time_slot' => '07:00 AM - 09:00 AM',
            'days' => 'শনি, সোম, বুধ',
        ]);

        $this->trainee = Trainee::create([
            'admission_no' => 'TR-TEST-001',
            'name' => 'সাকিব হাসান',
            'guardian_name' => 'আবুল হাসান',
            'phone' => '01711111111',
            'sport_id' => $this->cricket->id,
            'batch_id' => $this->morningBatch->id,
            'category' => 'U-16',
            'player_type' => 'academic',
            'monthly_fee' => 1000,
            'admission_date' => date('Y-m-d'),
            'status' => 'active',
        ]);
    }

    public function test_fee_defaulters_page_renders_and_filters_correctly(): void
    {
        // Trainee has no payment for 'অক্টোবর', so is a defaulter
        $response = $this->actingAs($this->admin)->get(route('payments.defaulters', ['month' => 'অক্টোবর', 'year' => date('Y')]));

        $response->assertStatus(200);
        $response->assertSee('বকেয়া ফি তালিকা');
        $response->assertSee('সাকিব হাসান');
        $response->assertSee('TR-TEST-001');
    }

    public function test_financial_cashbook_report_renders_successfully(): void
    {
        Payment::create([
            'invoice_no' => 'INV-TEST-001',
            'trainee_id' => $this->trainee->id,
            'title' => 'মাসিক বেতন',
            'fee_type' => 'monthly',
            'amount' => 1000,
            'month' => 'অক্টোবর',
            'year' => date('Y'),
            'payment_method' => 'bkash',
            'status' => 'paid',
            'payment_date' => date('Y-m-d'),
        ]);

        Expense::create([
            'voucher_no' => 'EXP-TEST-001',
            'title' => 'বল ও গ্লাভস ক্রয়',
            'category' => 'sports_gear',
            'amount' => 400,
            'expense_date' => date('Y-m-d'),
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($this->admin)->get(route('reports.financial', ['month' => 'অক্টোবর', 'year' => date('Y')]));

        $response->assertStatus(200);
        $response->assertSee('আর্থিক ক্যাশ বুক ও লাভ-ক্ষতির বিবরণী');
        $response->assertSee('1,000'); // total income
        $response->assertSee('400');   // total expense
        $response->assertSee('600');   // net profit
    }

    public function test_player_report_card_renders_with_academic_metrics(): void
    {
        $response = $this->actingAs($this->admin)->get(route('trainees.report-card', $this->trainee));

        $response->assertStatus(200);
        $response->assertSee('প্লেয়ার বাৎসরিক মূল্যায়ন ও একাডেমিক রিপোর্ট কার্ড');
        $response->assertSee('সাকিব হাসান');
        $response->assertSee('TR-TEST-001');
        $response->assertSee('জামিরবাড়িয়া স্পোর্টস একাডেমি');
    }

    public function test_csv_exports_stream_valid_csv_data(): void
    {
        // Trainees CSV
        $traineesCsv = $this->actingAs($this->admin)->get(route('trainees.export'));
        $traineesCsv->assertStatus(200);
        $traineesCsv->assertHeader('content-type', 'text/csv; charset=utf-8');

        // Payments CSV
        $paymentsCsv = $this->actingAs($this->admin)->get(route('payments.export'));
        $paymentsCsv->assertStatus(200);
        $paymentsCsv->assertHeader('content-type', 'text/csv; charset=utf-8');

        // Expenses CSV
        $expensesCsv = $this->actingAs($this->admin)->get(route('expenses.export'));
        $expensesCsv->assertStatus(200);
        $expensesCsv->assertHeader('content-type', 'text/csv; charset=utf-8');
    }

    public function test_sms_portal_renders_and_broadcast_sends_successfully(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.sms.index'));
        $response->assertStatus(200);
        $response->assertSee('বাল্ক SMS ব্রডকাস্ট');

        $sendResponse = $this->actingAs($this->admin)->post(route('admin.sms.send'), [
            'recipient_group' => 'all',
            'message' => 'প্রিয় অভিভাবক, আগামী রবিবার একাডেমি বন্ধ থাকবে।',
        ]);

        $sendResponse->assertSessionHas('success');
        $this->assertDatabaseHas('sms_logs', [
            'recipient_group' => 'all',
            'gateway_status' => 'delivered',
        ]);
        $this->assertGreaterThanOrEqual(1, \App\Models\SmsLog::latest()->first()->recipient_count);
    }

    public function test_backup_portal_renders_and_download_works(): void
    {
        $indexResponse = $this->actingAs($this->admin)->get(route('admin.backup.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('সিস্টেম ব্যাকআপ ও ডাটাবেজ সেন্টার');

        $downloadResponse = $this->actingAs($this->admin)->get(route('admin.backup.download'));
        $downloadResponse->assertStatus(200);
        $downloadResponse->assertHeader('content-type', 'application/sql');
    }

    public function test_tournament_points_table_recalculates_on_match_completion(): void
    {
        $tournament = Tournament::create([
            'name' => 'চ্যাম্পিয়নশিপ ট্রফি ২০২৬',
            'sport_id' => $this->cricket->id,
            'tournament_type' => 'academic',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+7 days')),
            'entry_fee' => 0,
            'status' => 'ongoing',
        ]);

        $teamA = Team::create(['name' => 'টাইগার্স একাদশ', 'slug' => 'tigers-xi-' . time(), 'sport_id' => $this->cricket->id]);
        $teamB = Team::create(['name' => 'লায়ন্স একাদশ', 'slug' => 'lions-xi-' . time(), 'sport_id' => $this->cricket->id]);

        $tournament->teams()->attach([$teamA->id, $teamB->id]);

        $match = LiveMatch::create([
            'slug' => 'match-tigers-vs-lions-' . time(),
            'tournament_id' => $tournament->id,
            'sport_type' => 'cricket',
            'team_a' => $teamA->name,
            'team_a_id' => $teamA->id,
            'team_b' => $teamB->name,
            'team_b_id' => $teamB->id,
            'title' => 'টাইগার্স বনাম লায়ন্স',
            'venue' => 'প্রধান মাঠ',
            'status' => 'finished',
            'is_official' => true,
            'scorer_code' => '1234',
            'match_result' => $teamA->name . ' ২০ রানে জয়ী',
        ]);

        $tournament->recalculatePointsTable();

        $tournamentTeams = $tournament->fresh()->tournamentTeams()->orderByDesc('points')->get();
        $this->assertCount(2, $tournamentTeams);

        // Team A won 1 match, points = 2
        $topTeam = $tournamentTeams[0];
        $this->assertEquals($teamA->id, $topTeam->team_id);
        $this->assertEquals(1, $topTeam->won);
        $this->assertEquals(2, $topTeam->points);
    }
}

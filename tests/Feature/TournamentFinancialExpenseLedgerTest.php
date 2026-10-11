<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tournament;
use App\Models\Expense;
use App\Models\Volunteer;
use App\Models\Sport;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TournamentFinancialExpenseLedgerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $tournament;
    protected $volunteer;

    protected function setUp(): void
    {
        parent::setUp();

        $sport = Sport::firstOrCreate(['name' => 'ক্রিকেট'], ['icon' => '🏏', 'description' => 'ক্রিকেট বিভাগ']);

        $this->admin = User::factory()->create(['role' => 'admin']);

        $this->tournament = Tournament::create([
            'sport_id' => $sport->id,
            'name' => 'বিজয় গোল্ড কাপ ক্রিকেট ২০২৬',
            'slug' => 'bijoy-gold-cup-2026',
            'type' => 'knockout',
            'registration_deadline' => now()->addDays(5)->toDateString(),
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(15)->toDateString(),
            'entry_fee' => 1500,
            'status' => 'upcoming',
        ]);

        $this->volunteer = Volunteer::create([
            'volunteer_no' => 'VOL-2026-001',
            'name' => 'তানভীর আহমেদ',
            'phone' => '01711998877',
            'address' => 'জামিরবাড়িয়া, ফুলবাড়িয়া, ময়মনসিংহ',
            'status' => 'approved',
            'tournament_id' => $this->tournament->id,
        ]);
    }

    public function test_admin_can_access_tournament_finances_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.tournaments.finances', $this->tournament));

        $response->assertStatus(200);
        $response->assertSee('আর্থিক হিসাব ও বাজেট লেজার');
        $response->assertSee('বিজয় গোল্ড কাপ ক্রিকেট ২০২৬');
        $response->assertSee('নতুন টুর্নামেন্ট খরচ এন্ট্রি');
    }

    public function test_admin_can_add_volunteer_expense_voucher()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.tournaments.finances.store', $this->tournament), [
                'voucher_no' => 'EXP-BGC-001',
                'title' => 'ভলান্টিয়ার ডিউটি এলাউন্স ও টি-শার্ট',
                'category' => 'volunteer_allowance',
                'amount' => 1200,
                'volunteer_id' => $this->volunteer->id,
                'expense_date' => now()->toDateString(),
                'payment_method' => 'bkash',
                'paid_to' => 'তানভীর আহমেদ',
                'note' => 'মাঠ নিরাপত্তা ডিউটি সম্মানী',
            ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('expenses', [
            'voucher_no' => 'EXP-BGC-001',
            'tournament_id' => $this->tournament->id,
            'volunteer_id' => $this->volunteer->id,
            'category' => 'volunteer_allowance',
            'amount' => 1200,
        ]);

        $this->assertEquals(1200, $this->tournament->fresh()->volunteer_expenses);
    }

    public function test_admin_can_add_sports_gear_expense_with_unit_price_calculation()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.tournaments.finances.store', $this->tournament), [
                'voucher_no' => 'EXP-BGC-002',
                'title' => 'ম্যাচ ক্রিকেট বল ও ব্যাট ক্রয়',
                'item_name' => 'ডিউক লেদার ক্রিকেট বল',
                'category' => 'cricket_balls',
                'unit_price' => 350,
                'quantity' => 10,
                'calc_auto' => '1',
                'amount' => 0, // Should be auto-calculated to 3500
                'expense_date' => now()->toDateString(),
                'payment_method' => 'cash',
                'paid_to' => 'স্পোর্টস জোন মিরপুর',
                'note' => '১০ পিস সিমি ম্যাচ বল',
            ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('expenses', [
            'voucher_no' => 'EXP-BGC-002',
            'tournament_id' => $this->tournament->id,
            'item_name' => 'ডিউক লেদার ক্রিকেট বল',
            'category' => 'cricket_balls',
            'unit_price' => 350,
            'quantity' => 10,
            'amount' => 3500,
        ]);
    }

    public function test_tournament_budget_ledger_computes_income_expense_and_balance()
    {
        // Add 2 teams linked via tournament_teams with entry fee 1500 each => 3000 income
        $team1 = Team::create([
            'name' => 'রাইডার্স একাদশ',
            'slug' => 'riders-11',
            'sport_id' => $this->tournament->sport_id,
            'captain_name' => 'সাকিব',
            'status' => 'active',
        ]);
        $team2 = Team::create([
            'name' => 'টাইটান্স একাদশ',
            'slug' => 'titans-11',
            'sport_id' => $this->tournament->sport_id,
            'captain_name' => 'তামিম',
            'status' => 'active',
        ]);

        \App\Models\TournamentTeam::create([
            'tournament_id' => $this->tournament->id,
            'team_id' => $team1->id,
        ]);
        \App\Models\TournamentTeam::create([
            'tournament_id' => $this->tournament->id,
            'team_id' => $team2->id,
        ]);

        // Add 2 expenses: 1000 + 1500 = 2500
        Expense::create([
            'tournament_id' => $this->tournament->id,
            'voucher_no' => 'EXP-1',
            'title' => 'আম্পায়ার ফি',
            'category' => 'umpire_fees',
            'amount' => 1000,
            'expense_date' => now()->toDateString(),
            'payment_method' => 'cash',
        ]);

        Expense::create([
            'tournament_id' => $this->tournament->id,
            'voucher_no' => 'EXP-2',
            'title' => 'ট্রফি ও মেডেল',
            'category' => 'prizes_trophies',
            'amount' => 1500,
            'expense_date' => now()->toDateString(),
            'payment_method' => 'cash',
        ]);

        $this->assertEquals(3000, $this->tournament->fresh()->total_income);
        $this->assertEquals(2500, $this->tournament->fresh()->total_expenses);
        $this->assertEquals(500, $this->tournament->fresh()->net_balance);
    }

    public function test_admin_can_view_printable_official_audit_sheet()
    {
        Expense::create([
            'tournament_id' => $this->tournament->id,
            'voucher_no' => 'EXP-PRINT-01',
            'title' => 'মাঠ সংস্কার ও রোলার ভাড়া',
            'category' => 'ground_maintenance',
            'amount' => 2000,
            'expense_date' => now()->toDateString(),
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.tournaments.finances.print', $this->tournament));

        $response->assertStatus(200);
        $response->assertSee('টুর্নামেন্ট আয়-ব্যয় ও অডিট ভাউচার বিবরণী');
        $response->assertSee('EXP-PRINT-01');
        $response->assertSee('মাঠ সংস্কার ও রোলার ভাড়া');
        $response->assertSee('হিসাবরক্ষক');
        $response->assertSee('টুর্নামেন্ট ডিরেক্টর');
    }

    public function test_admin_can_export_tournament_finances_csv()
    {
        Expense::create([
            'tournament_id' => $this->tournament->id,
            'voucher_no' => 'EXP-CSV-01',
            'title' => 'ক্রিকেট বল ক্রয়',
            'item_name' => 'এসএস বল',
            'unit_price' => 400,
            'quantity' => 5,
            'category' => 'cricket_balls',
            'amount' => 2000,
            'expense_date' => now()->toDateString(),
            'payment_method' => 'bkash',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.tournaments.finances.export', $this->tournament));

        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));
    }

    public function test_general_expenses_index_filters_by_tournament()
    {
        $academyExp = Expense::create([
            'voucher_no' => 'EXP-ACAD-01',
            'title' => 'সাধারণ অফিস বিদ্যুৎ বিল',
            'category' => 'office_rent',
            'amount' => 1500,
            'expense_date' => now()->toDateString(),
            'payment_method' => 'cash',
        ]);

        $trnExp = Expense::create([
            'tournament_id' => $this->tournament->id,
            'voucher_no' => 'EXP-TRN-01',
            'title' => 'টুর্নামেন্ট সাউন্ড সিস্টেম',
            'category' => 'refreshment',
            'amount' => 800,
            'expense_date' => now()->toDateString(),
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('expenses.index', ['tournament_id' => $this->tournament->id]));

        $response->assertStatus(200);
        $response->assertSee('EXP-TRN-01');
        $response->assertDontSee('EXP-ACAD-01');
    }
}

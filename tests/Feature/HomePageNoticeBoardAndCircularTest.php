<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Notice;
use App\Models\RegistrationCircular;
use App\Models\Tournament;
use App\Models\Sport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageNoticeBoardAndCircularTest extends TestCase
{
    use RefreshDatabase;

    protected $sport;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sport = Sport::firstOrCreate(['name' => 'ক্রিকেট'], ['icon' => '🏏', 'description' => 'ক্রিকেট বিভাগ']);
        Sport::firstOrCreate(['name' => 'ফুটবল'], ['icon' => '⚽', 'description' => 'ফুটবল বিভাগ']);

        // Initialize default circulars
        RegistrationCircular::ofType('admission');
        RegistrationCircular::ofType('volunteer');
        RegistrationCircular::ofType('local_player');
    }

    public function test_home_page_shows_recent_notices_and_circulars_widget_and_hub_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Hero widget shows recent notices and circulars
        $response->assertSee('সার্কুলার');
        $response->assertSee('নোটিশ');
        $response->assertSee('সকল নোটিশ ও সার্কুলার হাব');
        $response->assertSee(route('public.notice-board'));
    }

    public function test_home_page_displays_recent_notices_and_ticker()
    {
        $notice1 = Notice::create([
            'sport_id' => $this->sport->id,
            'title' => 'গ্রীষ্মকালীন ক্রিকেট ট্রায়াল ক্যাম্প ২০২৬',
            'content' => 'সকল ট্রেইনিদের আগামী শুক্রবার সকাল ৮টায় মাঠে উপস্থিত থাকতে বলা হচ্ছে।',
            'notice_date' => now()->toDateString(),
            'is_pinned' => true,
        ]);

        $notice2 = Notice::create([
            'title' => 'একাডেমি মাঠ রক্ষণাবেক্ষণ নোটিশ',
            'content' => 'শনিবার পিচ রোলার কাজ চলবে তাই প্র্যাকটিস বন্ধ থাকবে।',
            'notice_date' => now()->toDateString(),
            'is_pinned' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('গ্রীষ্মকালীন ক্রিকেট ট্রায়াল ক্যাম্প ২০২৬');
        $response->assertSee('একাডেমি মাঠ রক্ষণাবেক্ষণ নোটিশ');
        $response->assertSee('জরুরি');
        $response->assertSee('জরুরি ঘোষণা'); // Ticker badge
    }

    public function test_home_page_shows_tournament_registration_circular_in_recent_widget()
    {
        $tournament = Tournament::create([
            'sport_id' => $this->sport->id,
            'name' => 'বিজয় গোল্ড কাপ ২০২৬',
            'slug' => 'bijoy-gold-cup-2026',
            'type' => 'knockout',
            'registration_deadline' => now()->addDays(5)->toDateString(),
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(15)->toDateString(),
            'entry_fee' => 1200,
            'status' => 'upcoming',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('বিজয় গোল্ড কাপ ২০২৬ - প্লেয়ার নিবন্ধন সার্কুলার');
    }

    public function test_dedicated_notice_board_page_renders_full_hub()
    {
        $response = $this->get(route('public.notice-board'));

        $response->assertStatus(200);
        $response->assertSee('অফিসিয়াল বিজ্ঞপ্তি ও নোটিশ হাব');
        $response->assertSee('সকল সার্কুলার');
        $response->assertSee('একাডেমি ভর্তি');
        $response->assertSee('ভলান্টিয়ার');
    }

    public function test_dedicated_notice_board_shows_upcoming_and_closed_status()
    {
        $admission = RegistrationCircular::where('type', 'admission')->first();
        $admission->update([
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(10),
            'upcoming_message' => 'আগামী পরশু থেকে ভর্তি ফরম চালু হবে',
        ]);

        $volunteer = RegistrationCircular::where('type', 'volunteer')->first();
        $volunteer->update([
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(2),
            'closed_message' => 'ভলান্টিয়ার কোটা পূরণ হয়েছে',
        ]);

        $response = $this->get(route('public.notice-board'));

        $response->assertStatus(200);
        $response->assertSee('আসন্ন');
        $response->assertSee('সময়সীমা শেষ');
    }

    public function test_admin_sees_control_shortcuts_on_dedicated_notice_hub()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('public.notice-board'));

        $response->assertStatus(200);
        $response->assertSee('সার্কুলার সময়সূচী হাব');
        $response->assertSee('নতুন নোটিশ দিন');
    }
}

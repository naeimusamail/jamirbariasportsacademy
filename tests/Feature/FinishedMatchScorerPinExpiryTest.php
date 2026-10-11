<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\LiveMatch;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinishedMatchScorerPinExpiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_live_match_allows_pin_verification_and_access()
    {
        $match = LiveMatch::create([
            'slug' => 'test-live-match-1',
            'title' => 'Test Match',
            'sport_type' => 'cricket',
            'team_a' => 'Team A',
            'team_b' => 'Team B',
            'venue' => 'Main Ground',
            'status' => 'live',
            'scorer_code' => 'PIN123',
        ]);

        $response = $this->post(route('scorer.verify-pin', $match->slug), [
            'scorer_code' => 'PIN123',
        ]);

        $response->assertRedirect(route('matches.scorer', $match->slug));
        $this->assertEquals(true, session("scorer_authenticated_match_{$match->id}"));
    }

    public function test_finished_match_rejects_pin_verification_as_expired()
    {
        $match = LiveMatch::create([
            'slug' => 'test-finished-match-1',
            'title' => 'Finished Match',
            'sport_type' => 'cricket',
            'team_a' => 'Team A',
            'team_b' => 'Team B',
            'venue' => 'Main Ground',
            'status' => 'finished',
            'scorer_code' => 'PIN999',
        ]);

        $response = $this->post(route('scorer.verify-pin', $match->slug), [
            'scorer_code' => 'PIN999',
        ]);

        $response->assertSessionHasErrors('scorer_code');
        $this->assertNull(session("scorer_authenticated_match_{$match->id}"));
    }

    public function test_finished_match_quick_access_redirects_with_expired_notice()
    {
        $match = LiveMatch::create([
            'slug' => 'test-finished-match-2',
            'title' => 'Finished Match 2',
            'sport_type' => 'football',
            'team_a' => 'Team A',
            'team_b' => 'Team B',
            'venue' => 'Main Ground',
            'status' => 'finished',
            'scorer_code' => 'PIN888',
        ]);

        $response = $this->get(route('scorer.quick-access', ['slug' => $match->slug, 'code' => 'PIN888']));

        $response->assertRedirect(route('live.show', $match->slug));
        $response->assertSessionHas('error');
    }

    public function test_non_admin_scorer_cannot_score_finished_match()
    {
        $scorer = User::factory()->create([
            'role' => 'scorer',
        ]);

        $match = LiveMatch::create([
            'slug' => 'test-finished-match-3',
            'title' => 'Finished Match 3',
            'sport_type' => 'cricket',
            'team_a' => 'Team A',
            'team_b' => 'Team B',
            'venue' => 'Main Ground',
            'status' => 'finished',
            'scorer_code' => 'PIN777',
            'scorer_id' => $scorer->id,
        ]);

        $response = $this->actingAs($scorer)->get(route('matches.scorer', $match->slug));
        $response->assertStatus(403);
    }

    public function test_admin_can_still_access_and_score_finished_match()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $match = LiveMatch::create([
            'slug' => 'test-finished-match-4',
            'title' => 'Finished Match 4',
            'sport_type' => 'cricket',
            'team_a' => 'Team A',
            'team_b' => 'Team B',
            'venue' => 'Main Ground',
            'status' => 'finished',
            'scorer_code' => 'PIN666',
        ]);

        $response = $this->actingAs($admin)->get(route('matches.scorer', $match->slug));
        $response->assertStatus(200);
    }
}


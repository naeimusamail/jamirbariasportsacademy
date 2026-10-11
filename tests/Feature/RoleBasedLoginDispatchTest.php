<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RoleBasedLoginDispatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_logs_in_with_username_and_redirects_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'username' => 'admin_user',
            'email' => 'admin@jamirbaria.com',
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'login' => 'admin_user',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('dashboard.admin'));
    }

    public function test_player_logs_in_with_username_and_redirects_to_player_dashboard(): void
    {
        $player = User::factory()->create([
            'username' => 'player_user',
            'email' => 'player@jamirbaria.com',
            'role' => 'player',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'login' => 'player_user',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($player);
        $response->assertRedirect(route('dashboard.player'));
    }

    public function test_coach_logs_in_with_username_and_redirects_to_coach_dashboard(): void
    {
        $coach = User::factory()->create([
            'username' => 'coach_user',
            'email' => 'coach@jamirbaria.com',
            'role' => 'coach',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'login' => 'coach_user',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($coach);
        $response->assertRedirect(route('dashboard.coach'));
    }

    public function test_scorer_logs_in_with_username_and_redirects_to_scorer_dashboard(): void
    {
        $scorer = User::factory()->create([
            'username' => 'scorer_user',
            'email' => 'scorer@jamirbaria.com',
            'role' => 'scorer',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'login' => 'scorer_user',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($scorer);
        $response->assertRedirect(route('dashboard.scorer'));
    }

    public function test_dashboard_route_dispatches_proper_view_based_on_role(): void
    {
        $player = User::factory()->create([
            'username' => 'player_two',
            'role' => 'player',
        ]);

        $response = $this->actingAs($player)->get(route('dashboard'));
        $response->assertOk();
        $response->assertViewIs('dashboards.player');
    }
}


<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReportsControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Team $team;

    protected function setUp(): void
    {
        parent::setUp();

        $this->team = Team::factory()->create();
        $this->admin = User::factory()->create();
        $this->admin->teams()->attach($this->team, ['role' => 'admin']);
    }

    public function test_show_reports_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->get("/{$this->team->slug}/admin/reports");

        $response->assertStatus(200);
    }

    public function test_show_daily_reports_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->get("/{$this->team->slug}/admin/daily-reports");

        $response->assertStatus(200);
    }
}

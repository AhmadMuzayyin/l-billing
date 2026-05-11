<?php

namespace Tests\Feature\Legacy;

use App\Models\Legacy\NetworkRouter;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoutersControllerTest extends TestCase
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

    public function test_show_routers_list(): void
    {
        $response = $this->actingAs($this->admin)
            ->get("/{$this->team->slug}/admin/routers");

        $response->assertStatus(200);
    }

    public function test_create_router_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/{$this->team->slug}/admin/routers", [
                'name' => '',
                'ip_address' => 'invalid',
                'username' => '',
                'password' => '',
                'port' => 99999,
            ]);

        $response->assertSessionHasErrors(['name', 'ip_address']);
    }

    public function test_create_router_success(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/{$this->team->slug}/admin/routers", [
                'name' => 'Test Router',
                'ip_address' => '192.168.1.1',
                'username' => 'admin',
                'password' => 'password123',
                'port' => 8728,
            ]);

        $this->assertDatabaseHas('tbl_routers', [
            'name' => 'Test Router',
            'ip_address' => '192.168.1.1',
        ]);
    }
}

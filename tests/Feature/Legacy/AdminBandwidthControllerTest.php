<?php

namespace Tests\Feature\Legacy;

use App\Models\Legacy\BandwidthProfile;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBandwidthControllerTest extends TestCase
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

    public function test_show_bandwidth_list(): void
    {
        $response = $this->actingAs($this->admin)
            ->get("/{$this->team->slug}/admin/bandwidth");

        $response->assertStatus(200);
    }

    public function test_create_bandwidth_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/{$this->team->slug}/admin/bandwidth", [
                'name' => '',
                'upload_limit' => -1,
                'download_limit' => -1,
            ]);

        $response->assertSessionHasErrors(['name', 'upload_limit']);
    }

    public function test_create_bandwidth_success(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/{$this->team->slug}/admin/bandwidth", [
                'name' => 'Premium 5Mbps',
                'upload_limit' => 5,
                'download_limit' => 10,
            ]);

        $this->assertDatabaseHas('tbl_bandwidth', [
            'name' => 'Premium 5Mbps',
        ]);
    }
}

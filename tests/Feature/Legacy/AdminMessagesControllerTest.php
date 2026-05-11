<?php

namespace Tests\Feature\Legacy;

use App\Models\Legacy\Customer;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMessagesControllerTest extends TestCase
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

    public function test_show_messages_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->get("/{$this->team->slug}/admin/messages");

        $response->assertStatus(200);
    }

    public function test_send_message_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/{$this->team->slug}/admin/messages/send", [
                'title' => '',
                'message' => '',
            ]);

        $response->assertSessionHasErrors(['title', 'message']);
    }

    public function test_show_bulk_message_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get("/{$this->team->slug}/admin/messages/bulk");

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPlansControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsAdmin(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }

    public function test_plans_page_can_be_rendered(): void
    {
        $user = $this->actingAsAdmin();

        $response = $this
            ->actingAs($user)
            ->get(route('legacy.admin.internet-plan'));

        $response->assertOk();
    }

    public function test_plan_can_be_created_from_admin_module(): void
    {
        $user = $this->actingAsAdmin();

        $response = $this
            ->actingAs($user)
            ->post(route('legacy.admin.internet-plan.store'), [
                'name_plan' => 'Plan Basic',
                'id_bw' => 1,
                'price' => 100000,
                'type' => 'Hotspot',
                'validity' => 30,
                'validity_unit' => 'Days',
                'routers' => 'router-1',
                'prepaid' => 'yes',
                'plan_type' => 'Personal',
                'enabled' => true,
                'is_radius' => false,
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tbl_plans', [
            'name_plan' => 'Plan Basic',
            'type' => 'Hotspot',
            'validity' => 30,
        ]);
    }
}

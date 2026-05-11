<?php

namespace Tests\Feature\Legacy;

use App\Models\Legacy\Plan;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerPackageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create();
    }

    public function test_show_packages_list(): void
    {
        $response = $this->actingAs($this->customer)
            ->get(route('legacy.customer.buy-package'));

        $response->assertStatus(200);
    }

    public function test_show_package_purchase_page(): void
    {
        $plan = Plan::factory()->create();

        $response = $this->actingAs($this->customer)
            ->get(route('legacy.customer.buy-package.purchase', $plan));

        $response->assertStatus(200);
    }
}

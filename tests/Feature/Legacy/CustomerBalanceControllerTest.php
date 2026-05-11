<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerBalanceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create();
    }

    public function test_show_balance_page(): void
    {
        $response = $this->actingAs($this->customer)
            ->get(route('legacy.customer.buy-balance'));

        $response->assertStatus(200);
    }

    public function test_show_topup_form(): void
    {
        $response = $this->actingAs($this->customer)
            ->get(route('legacy.customer.buy-balance.create'));

        $response->assertStatus(200);
    }
}

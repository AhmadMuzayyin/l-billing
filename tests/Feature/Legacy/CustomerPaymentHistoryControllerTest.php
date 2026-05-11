<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerPaymentHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create();
    }

    public function test_show_payment_history_page(): void
    {
        $response = $this->actingAs($this->customer)
            ->get(route('legacy.customer.payment-history'));

        $response->assertStatus(200);
    }

    public function test_show_monthly_payment_page(): void
    {
        $response = $this->actingAs($this->customer)
            ->get(route('legacy.customer.payment-history.monthly'));

        $response->assertStatus(200);
    }
}

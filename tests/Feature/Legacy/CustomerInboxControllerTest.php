<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerInboxControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create();
    }

    public function test_show_inbox_page(): void
    {
        $response = $this->actingAs($this->customer)
            ->get(route('legacy.customer.inbox'));

        $response->assertStatus(200);
    }

    public function test_inbox_with_messages(): void
    {
        \DB::table('tbl_customers_inbox')->insert([
            'customer_id' => $this->customer->id,
            'subject' => 'Test Message',
            'body' => 'This is a test message',
            'date_created' => now(),
            'from' => 'System',
        ]);

        $response = $this->actingAs($this->customer)
            ->get(route('legacy.customer.inbox'));

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCustomersControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsAdmin(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }

    public function test_customers_page_can_be_rendered(): void
    {
        $user = $this->actingAsAdmin();

        $response = $this
            ->actingAs($user)
            ->get(route('legacy.admin.customers'));

        $response->assertOk();
    }

    public function test_customer_can_be_created_from_admin_module(): void
    {
        $user = $this->actingAsAdmin();

        $response = $this
            ->actingAs($user)
            ->post(route('legacy.admin.customers.store'), [
                'username' => 'cust001',
                'password' => 'password',
                'password_confirmation' => 'password',
                'fullname' => 'Customer Satu',
                'email' => 'cust001@example.com',
                'phonenumber' => '081234567890',
                'status' => 'Active',
                'balance' => 0,
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tbl_customers', [
            'username' => 'cust001',
            'fullname' => 'Customer Satu',
            'email' => 'cust001@example.com',
        ]);
    }
}

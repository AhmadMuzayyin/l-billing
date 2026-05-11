<?php

namespace Tests\Feature\Legacy;

use App\Models\Legacy\Voucher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerVoucherActivationTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsCustomer(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }

    public function test_voucher_page_can_be_rendered(): void
    {
        $user = $this->actingAsCustomer();

        $response = $this
            ->actingAs($user)
            ->get(route('legacy.customer.voucher'));

        $response->assertOk();
    }

    public function test_voucher_can_be_activated(): void
    {
        $user = $this->actingAsCustomer();

        Voucher::query()->create([
            'type' => 'Hotspot',
            'routers' => 'router-1',
            'id_plan' => 1,
            'code' => 'VC-001',
            'user' => '',
            'status' => 'new',
            'generated_by' => 1,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('legacy.customer.voucher.activate'), [
                'code' => 'VC-001',
                'customer_username' => 'cust001',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tbl_voucher', [
            'code' => 'VC-001',
            'status' => 'used',
            'user' => 'cust001',
        ]);
    }
}

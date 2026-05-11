<?php

namespace Database\Factories;

use App\Models\Legacy\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'fullname' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'phonenumber' => $this->faker->phoneNumber(),
            'password' => bcrypt('password'),
            'status' => 'active',
            'service_type' => 'hotspot',
            'auto_renewal' => 1,
            'balance' => 0,
            'created_at' => now(),
            'last_login' => now(),
        ];
    }
}

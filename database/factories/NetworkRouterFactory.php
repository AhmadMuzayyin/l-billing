<?php

namespace Database\Factories;

use App\Models\Legacy\NetworkRouter;
use Illuminate\Database\Eloquent\Factories\Factory;

class NetworkRouterFactory extends Factory
{
    protected $model = NetworkRouter::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'ip_address' => $this->faker->ipv4(),
            'username' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'port' => $this->faker->numberBetween(1024, 65535),
        ];
    }
}

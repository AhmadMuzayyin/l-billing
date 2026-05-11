<?php

namespace Database\Factories\Legacy;

use App\Models\Legacy\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_plan' => $this->faker->words(2, true),
            'type' => 'Hotspot',
            'price' => $this->faker->numberBetween(10000, 100000),
            'validity' => $this->faker->randomElement([7, 30, 90]),
            'validity_unit' => 'Days',
            'is_radius' => false,
            'enabled' => true,
            'id_bw' => 1,
            'routers' => '0',
        ];
    }
}

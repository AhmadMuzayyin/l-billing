<?php

namespace Database\Factories;

use App\Models\Legacy\BandwidthProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class BandwidthProfileFactory extends Factory
{
    protected $model = BandwidthProfile::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'upload_limit' => $this->faker->numberBetween(1, 100),
            'download_limit' => $this->faker->numberBetween(1, 100),
            'burst_upload' => $this->faker->numberBetween(10, 200),
            'burst_download' => $this->faker->numberBetween(10, 200),
        ];
    }
}

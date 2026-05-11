<?php

namespace Database\Factories;

use App\Models\Legacy\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'customer_id' => null,
            'title' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'send_by' => 1,
            'created_at' => now(),
        ];
    }
}

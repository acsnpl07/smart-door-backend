<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AppApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppApiKeyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppApiKey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'door_id' => 1,
            'key' => Str::random(32)
        ];
    }
}

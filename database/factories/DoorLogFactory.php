<?php

namespace Database\Factories;

use App\Models\DoorLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoorLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoorLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'is_camera' => 1,
            'entered' => 0,
            'image_url' => 'https://picsum.photos/200'
        ];
    }
}

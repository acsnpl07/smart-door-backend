<?php

namespace Database\Factories;

use App\Models\DoorLog;
use App\Models\DoorNotification;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoorNotificationFactory extends Factory
{
    protected $model = DoorNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'door_id' => 1,
            'door_log_id' => $this->faker->randomElement([ function(){
                return  DoorLog::factory()->create()->id;
            }  , null]),
            'title' => $this->faker->words(3, true),
            'body' => $this->faker->sentence,
        ];
    }
}

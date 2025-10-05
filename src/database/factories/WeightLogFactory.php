<?php

namespace Database\Factories;

use App\Models\WeightLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    protected $model = WeightLog::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::find(1);
        return [
            'user_id' => $user->id,
            'date' => $this->faker->date(),
            'weight' => $this->faker->randomFloat(1, 0, 99.9),
            'calories' => $this->faker->randomNumber(),
            'exercise_time' => $this->faker->time('H:i'),
            'exercise_content' => $this->faker->text(120)
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\School;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'school_id' => School::fa,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}

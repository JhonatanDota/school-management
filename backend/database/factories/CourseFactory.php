<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\School;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $schoolIds = School::pluck('id')->toArray();

        return [
            'school_id' => $this->faker->randomElement($schoolIds),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
        ];
    }
}

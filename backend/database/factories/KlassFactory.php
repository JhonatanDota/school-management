<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Klass;
use App\Models\School;
use App\Models\Course;
use App\Models\Teacher;

class KlassFactory extends Factory
{
    protected $model = Klass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'teacher_id' => Teacher::factory(),
            'original_start_date' => $this->faker->dateTime(),
        ];
    }
}

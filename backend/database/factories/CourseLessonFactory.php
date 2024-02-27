<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CourseLesson;
use App\Models\Course;

class CourseLessonFactory extends Factory
{
    protected $model = CourseLesson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'name' => $this->faker->name(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Klass;
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
        $courses = Course::get()->toArray();
        $course = $this->faker->randomElement($courses);

        $teachers = Teacher::where('school_id', $course['school_id'])->get()->toArray();
        $teacher = $this->faker->randomElement($teachers);


        return [
            'course_id' => $course['id'],
            'teacher_id' => $teacher['id'],
        ];
    }
}

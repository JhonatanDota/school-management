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
        $schools = School::has('courses')->has('teachers')->pluck('id')->toArray();
        $schoolId = $this->faker->randomElement($schools);

        $courses = Course::where('school_id', $schoolId)->pluck('id')->toArray();
        $courseId = $this->faker->randomElement($courses);

        $teachers = Teacher::where('school_id', $schoolId)->pluck('id')->toArray();
        $teacherId = $this->faker->randomElement($teachers);

        return [
            'course_id' => $courseId,
            'teacher_id' => $teacherId,
            'original_start_date' => $this->faker->dateTime(),
        ];
    }
}

<?php

namespace App\Repositories;

use App\Models\Course;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseRepository
{
    /**
     * Retrieve paginated Courses.
     *
     * @param int $schoolId
     * @return LengthAwarePaginator
     */

    public function all(int $schoolId): LengthAwarePaginator
    {
        return Course::where('school_id', $schoolId)->paginate();
    }

    /**
     * Retrieve Course.
     *
     * @param  int $id
     * @return Course|null
     */

    public function find(int $id): ?Course
    {
        return Course::find($id);
    }

    /**
     * Create Course.
     *
     * @param array $data
     * @return Course
     */

    public function create(array $data): Course
    {
        return Course::create($data)->refresh();
    }

    /**
     * Update Course.
     *
     * @param Course $course
     * @param  array $data
     * @return Course
     */

    public function update(Course $course, array $data): Course
    {
        $course->update($data);
        return $course;
    }

    /**
     * Retrieve Course Lessons.
     *
     * @param  Course $course
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function lessons(Course $course): Collection
    {
        return $course->lessons;
    }
}

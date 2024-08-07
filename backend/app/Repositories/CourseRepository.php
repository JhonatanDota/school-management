<?php

namespace App\Repositories;

use App\Models\Course;

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
     * @return Course
     */

    public function find(int $id): Course
    {
        return Course::findOrFail($id);
    }
}

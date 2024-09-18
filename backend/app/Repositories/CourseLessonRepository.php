<?php

namespace App\Repositories;

use App\Models\CourseLesson;

class CourseLessonRepository
{
    /**
     * Retrieve Course Lesson.
     *
     * @param  int $id
     * @return CourseLesson|null
     */

    public function find(int $id): ?CourseLesson
    {
        return CourseLesson::find($id);
    }

    /**
     * Create Course Lesson.
     *
     * @param array $data
     * @return CourseLesson
     */

    public function create(array $data): CourseLesson
    {
        return CourseLesson::create($data)->refresh();
    }

    /**
     * Update Course Lesson.
     *
     * @param CourseLesson $courseLesson
     * @param  array $data
     * @return CourseLesson
     */

    public function update(CourseLesson $courseLesson, array $data): CourseLesson
    {
        $courseLesson->update($data);
        return $courseLesson;
    }
}

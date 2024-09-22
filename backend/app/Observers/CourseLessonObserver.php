<?php

namespace App\Observers;

use App\Models\CourseLesson;

class CourseLessonObserver
{

    /**
     * Handle the CourseLesson "creating" event.
     *
     * @param  \App\Models\CourseLesson  $courseLesson
     * @return void
     */
    public function creating(CourseLesson $courseLesson): void
    {
        $course = $courseLesson->course;
        $courseLessonsCount = $course->lessons()->count();

        $courseLesson->order = $courseLessonsCount + 1;
    }
}

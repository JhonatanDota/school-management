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
    public function creating(CourseLesson $courseLesson)
    {
        $course = $courseLesson->course;
        $lastCourseLesson = $course->courseLessons->last();
        $nextOrder = $lastCourseLesson ? $lastCourseLesson->order + 1 : 1;

        $courseLesson->order = $nextOrder;
    }
}

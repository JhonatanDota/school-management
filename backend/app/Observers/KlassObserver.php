<?php

namespace App\Observers;

use App\Models\Klass;
use App\Helpers\DateHelpers;
use App\Models\ScheduledLesson;

class KlassObserver
{
    /**
     * Handle the Klass "created" event.
     *
     * @param  \App\Models\Klass  $klass
     * @return void
     */
    public function created(Klass $klass): void
    {
        $course = $klass->course;
        $courseLessons = $course->courseLessons;
        $nextDatetime = $klass->original_start_date;

        foreach ($courseLessons as $courseLesson) {
            $scheduledLessons[] = [
                'course_lesson_id' => $courseLesson->id,
                'klass_id' => $klass->id,
                'datetime' => $nextDatetime,
            ];

            $nextDatetime = DateHelpers::sumDays($nextDatetime, 7);
        }

        if(isset($scheduledLessons)) ScheduledLesson::insert($scheduledLessons);
    }
}

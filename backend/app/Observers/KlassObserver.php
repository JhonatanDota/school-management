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
        $toInsertScheduledLessons = array();

        foreach ($courseLessons as $courseLesson) {
            $toInsertScheduledLessons[] = [
                'course_lesson_id' => $courseLesson->id,
                'klass_id' => $klass->id,
                'datetime' => DateHelpers::sumDays($klass->original_start_date, 7),
            ];
        }

        ScheduledLesson::insert($toInsertScheduledLessons);
    }
}

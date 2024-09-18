<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseLesson;

use Illuminate\Auth\Access\HandlesAuthorization;

class CourseLessonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a course lesson.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Course $course
     * @return bool
     */
    public function create(User $user, Course $course): bool
    {
        return $user->school_id == $course->school_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseLesson $courseLesson
     * @return bool
     */
    public function view(User $user, CourseLesson $courseLesson): bool
    {
        return $user->school_id == $courseLesson->course->school_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseLesson $courseLesson
     * @return bool
     */
    public function update(User $user, CourseLesson $courseLesson): bool
    {
        return $user->school_id == $courseLesson->course->school_id;
    }
}

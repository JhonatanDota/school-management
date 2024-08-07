<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Course  $course
     * @return bool
     */
    public function view(User $user, Course $course): bool
    {
        return $user->school_id == $course->school_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Course  $course
     * @return bool
     */
    public function update(User $user, Course $course): bool
    {
        return $user->school_id == $course->school_id;
    }
}

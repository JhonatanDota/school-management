<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;

use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Teacher  $teacher
     * @return bool
     */
    public function view(User $user, Teacher $teacher): bool
    {
        return $user->school_id == $teacher->school_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Teacher  $teacher
     * @return bool
     */
    public function update(User $user, Teacher $teacher): bool
    {
        return $user->school_id == $teacher->school_id;
    }
}

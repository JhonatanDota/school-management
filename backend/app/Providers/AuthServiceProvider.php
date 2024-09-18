<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Teacher;
use App\Policies\TeacherPolicy;

use App\Models\Course;
use App\Policies\CoursePolicy;

use App\Models\CourseLesson;
use App\Policies\CourseLessonPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Teacher::class => TeacherPolicy::class,
        Course::class => CoursePolicy::class,
        CourseLesson::class => CourseLessonPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

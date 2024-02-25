<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\SchoolSeeder;
use Database\Seeders\TeacherSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\CourseLessonSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SchoolSeeder::class,
            TeacherSeeder::class,
            CourseSeeder::class,
            CourseLessonSeeder::class,
        ]);
    }
}

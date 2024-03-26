<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\SchoolSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TeacherSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\CourseLessonSeeder;
use Database\Seeders\KlassSeeder;

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
            UserSeeder::class,
            TeacherSeeder::class,
            CourseSeeder::class,
            CourseLessonSeeder::class,
            KlassSeeder::class,
        ]);
    }
}

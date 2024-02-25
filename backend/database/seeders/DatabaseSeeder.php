<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\SchoolSeeder;
use Database\Seeders\TeacherSeeder;

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
        ]);
    }
}

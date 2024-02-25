<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klass;

class KlassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Klass::factory()->count(7)->create();
    }
}

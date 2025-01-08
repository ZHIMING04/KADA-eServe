<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,  // Use UserSeeder if you went with option 2
            // or UsersSeeder::class if you went with option 1
        ]);
    }
} 
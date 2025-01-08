<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone' => $faker->numerify('01########'),
                'ic' => $faker->numerify('############'),
                'address' => $faker->address,
                'city' => $faker->city,
                'poskod' => $faker->postcode,
                'state' => $faker->state,
                'DOB' => $faker->date('Y-m-d', '-18 years'),
                'gender' => $faker->randomElement(['Lelaki', 'Perempuan']),
                'gred' => $faker->randomElement(['M40', 'B40', 'T20']),
                'salary' => $faker->numberBetween(2000, 10000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

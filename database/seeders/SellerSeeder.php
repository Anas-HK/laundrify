<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SellerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Insert 10 random seller accounts
        for ($i = 1; $i <= 10; $i++) {
            DB::table('sellers')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'accountIsApproved' => $faker->boolean, // Randomly assign true or false
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
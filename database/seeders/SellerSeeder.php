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

        for ($i = 1; $i <= 10; $i++) {
            DB::table('sellers')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'profile_image' => $faker->imageUrl(640, 480, 'people', true, 'Faker'), // Generate random image URL
                'city' => $faker->city,
                'area' => $faker->streetName,
                'accountIsApproved' => $faker->boolean, // Randomly assign true or false
                'is_deleted' => false, // Default to false
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
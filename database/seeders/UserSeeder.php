<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Insert admin account
        DB::table('users')->insert([
            'id' => 1,
            'sellerType' => 1, // Admin
            'name' => 'admin',
            'email' => 'ceo@gmail.com',
            'password' => Hash::make('laundrify$9999'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert 20 random user accounts with random sellerType
        for ($i = 2; $i <= 21; $i++) {
            DB::table('users')->insert([
                'sellerType' => $faker->randomElement([2, 3]), // Randomly assign Buyer or Seller
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
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

        // Admin User
        DB::table('users')->insert([
            'id' => 1,
            'sellerType' => 1,
            'name' => 'Admin User',
            'email' => 'admin@laundrify.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'mobile' => $faker->phoneNumber,
            'address' => $faker->streetAddress,
            'address2' => $faker->secondaryAddress,
            'city' => $faker->city,
            'state' => $faker->state,
            'zip' => $faker->postcode,
            'pickup_time' => $faker->randomElement(['morning', 'afternoon', 'evening']),
            'is_verified' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create 10 Buyers
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'sellerType' => 2,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'mobile' => $faker->phoneNumber,
                'address' => $faker->streetAddress,
                'address2' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'pickup_time' => $faker->randomElement(['morning', 'afternoon', 'evening']),
                'is_verified' => $faker->boolean,
                'otp' => $faker->numberBetween(100000, 999999),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Create 5 Sellers
        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'sellerType' => 3,
                'name' => $faker->company,
                'email' => $faker->unique()->companyEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'mobile' => $faker->phoneNumber,
                'address' => $faker->streetAddress,
                'address2' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'pickup_time' => null,
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
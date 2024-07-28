<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate 10 dummy users
        for ($i = 1; $i <= 50; $i++) {
            $createdAt = Carbon::now()->subDays(rand(0, 365))->toDateTimeString();
            $updatedAt = Carbon::createFromTimestamp(rand(strtotime($createdAt), time()))->toDateTimeString();

            DB::table('users')->insert([
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Hashing the password
                'role' => 'customer', // Set role to 'user'
                'status' => 'active', // Set status to 'active'
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}

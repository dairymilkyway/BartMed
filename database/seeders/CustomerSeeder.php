<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate 10 dummy customers
        for ($i = 1; $i <= 50; $i++) {
            $createdAt = Carbon::now()->subDays(rand(0, 365))->toDateTimeString();
            $updatedAt = Carbon::createFromTimestamp(rand(strtotime($createdAt), time()))->toDateTimeString();

            DB::table('customers')->insert([
                'user_id' => $i, // Ensure this matches the user ID
                'name' => $faker->name,
                'address' => $faker->address,
                'number' => $faker->phoneNumber,
                'img_path' => 'images/customer' . $i . '.jpg',
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate 20 fake records for products table
        for ($i = 0; $i < 500; $i++) {
            DB::table('products')->insert([
                'brand_id' => $faker->numberBetween(1, 20), // Assuming you have 20 brands seeded
                'product_name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 10, 1000),
                'stocks' => $faker->numberBetween(0, 100),
                'category' => $faker->word,
                'img_path' => $faker->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

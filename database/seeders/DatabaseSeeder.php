<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
            $this->call(UserSeeder::class);
            $this->call(AdminSeeder::class);
            $this->call(BrandsSeeder::class);
            $this->call(ProductsSeeder::class);
            $this->call(CustomerSeeder::class);
            $this->call(OrdersSeeder::class);
            $this->call(OrdersProductSeeder::class);
        }
    
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersProductSeeder extends Seeder
{
    /**
     * Seed the order_product table with 50 records.
     *
     * @return void
     */
    public function run()
    {
        // Fetching IDs from orders and products tables
        $orderIds = DB::table('orders')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        // Make sure there are orders and products available
        if (empty($orderIds) || empty($productIds)) {
            $this->command->error('Orders or Products table is empty.');
            return;
        }

        // Inserting 50 records into the order_product table
        foreach (range(1, 50) as $index) {
            DB::table('order_product')->insert([
                'order_id' => $orderIds[array_rand($orderIds)],
                'product_id' => $productIds[array_rand($productIds)],
                'quantity' => rand(1, 5), // Random quantity between 1 and 5
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

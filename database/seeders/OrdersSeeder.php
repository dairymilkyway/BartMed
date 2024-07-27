<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersSeeder extends Seeder
{
    /**
     * Seed the orders table.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['pending', 'delivered', 'shipped', 'canceled'];
        $couriers = ['J&t', 'LBC'];
        $paymentMethods = ['Gcash', 'Paypal', 'Credit Card', 'Cash on Delivery'];

        // Assuming you have a customers table with at least some customers
        $customerIds = DB::table('customers')->pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            DB::table('orders')->insert([
                'customer_id' => $customerIds[array_rand($customerIds)],
                'order_status' => $statuses[array_rand($statuses)],
                'courier' => $couriers[array_rand($couriers)],
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

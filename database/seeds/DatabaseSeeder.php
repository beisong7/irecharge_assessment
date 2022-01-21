<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(GatewaysTableSeeder::class);
         $this->call(CustomersTableSeeder::class);
//         $this->call(EndpointTableSeeder::class);
         $this->call(TransactionTableSeeder::class);
//         $this->call(PaymentTableSeeder::class);
    }
}

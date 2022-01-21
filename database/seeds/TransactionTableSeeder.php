<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Gateway;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::get();
        foreach ($customers as $customer){
            factory(Transaction::class, 1)->create(
                [
                    "customer_id"=>$customer->uuid
                ]
            );
        }
    }
}

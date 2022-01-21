<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
//    public function testAllCustomers()
//    {
//        $response = $this->get('/customers');
//
//        $response->assertStatus(200);
//    }

    public function testCreateCustomer()
    {
        $customer = factory(Customer::class)->create();
//        dd($customer->toArray());
        $transaction = factory(Transaction::class)->create(
            [
                "customer_id"=>$customer->uuid
            ]
        );

        $this->assertSame($transaction->tx_ref, $customer->latestTransaction->tx_ref);

    }
}

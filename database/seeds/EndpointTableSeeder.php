<?php

use Illuminate\Database\Seeder;
use App\Models\Endpoint;
use App\Models\Gateway;

class EndpointTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gateway = Gateway::first();
        if(!empty($gateway)){
            $endpoints = [
                ["charge_card","v3/charges?type=card","post"],
                ["verify_payment","transactions/{id}/verify","get"],
            ];
            foreach ($endpoints as $endpoint){
                factory(Endpoint::class, 1)->create(
                    [
                        "gateway_id"=>$gateway->uuid,
                        "name"=>$endpoint[0],
                        "link"=>$endpoint[1],
                        "method"=>$endpoint[2],
                    ]
                );
            }

        }
    }
}

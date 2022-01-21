<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Transaction;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        "uuid"=>$faker->uuid,
        "customer_id"=>$faker->uuid,
        "tx_ref"=> Str::random(16),
        "amount" => random_int(10000, 80000),
        "tx_id" => 123456789,
        "status" => "failed",
        "meta" => "test payments",
        "completed" => true,
        "success" => false,
        "gateway_msg" => "test items",
        "start" => time(),
        "ends" =>time(),
    ];
});

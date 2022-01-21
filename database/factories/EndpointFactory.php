<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Endpoint;
use Faker\Generator as Faker;

$factory->define(Endpoint::class, function (Faker $faker) {
    return [
        "uuid"=>$faker->uuid,
        "gateway_id"=>$faker->uuid,
        "name"=>$faker->name,
        "link"=>$faker->url,
        "method"=>"get",
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Gateway;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Gateway::class, function (Faker $faker) {
    return [
        "uuid"=>$faker->uuid,
        "name"=>"Flutter Wave",
        "live"=>1,
        "test_public_key"=>encrypt(""),
        "test_private_key"=>encrypt(""),
        "test_encryption_key"=>encrypt(""),
        "link"=>"/",
//        "live_public_key"=>"",
//        "live_private_key"=>"",
//        "live_encryption_key"=>"",
    ];
});

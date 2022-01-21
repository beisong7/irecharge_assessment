<?php

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class GatewaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Gateway::class, 1)->create();
    }
}

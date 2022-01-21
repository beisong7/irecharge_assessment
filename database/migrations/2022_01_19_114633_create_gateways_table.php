<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGateWaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->boolean('live'); //live or test
            $table->longText('test_public_key')->nullable();
            $table->longText('test_private_key')->nullable();
            $table->longText('test_encryption_key')->nullable();
            $table->longText('live_public_key')->nullable();
            $table->longText('live_private_key')->nullable();
            $table->longText('live_encryption_key')->nullable();
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gate_ways');
    }
}

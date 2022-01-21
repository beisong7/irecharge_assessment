<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('customer_id')->nullable();
            $table->string('tx_ref')->nullable();
            $table->integer('tx_id')->nullable();
            $table->float('amount', 12, 2)->nullable();
            $table->string('status')->nullable();
            $table->text('meta')->nullable();
            $table->boolean('completed')->nullable();
            $table->boolean('success')->nullable();
            $table->text('gateway_msg')->nullable();
            $table->bigInteger('start')->nullable(); // time the payment was initiated
            $table->bigInteger('ends')->nullable(); // time the payment was completed
            $table->timestamps();

            $table->foreign('customer_id')->references('uuid')->on('customers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('customer_id')->nullable();
            $table->uuid('transaction_id')->nullable();
            $table->float('amount', 12, 2)->nullable();
            $table->string('reference_id')->nullable(); //gateway reference id
            $table->text('comments')->nullable(); //any comment relevant to the payment
            $table->boolean('success')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('uuid')->on('customers')->onDelete('cascade');
            $table->foreign('transaction_id')->references('uuid')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

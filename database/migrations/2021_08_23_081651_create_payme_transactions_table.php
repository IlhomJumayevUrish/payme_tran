<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payme_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('paycom_transaction_id')->nullable();
            $table->string('param_id' )->nullable();
            $table->integer('order_id' )->nullable();
            $table->string('paycom_time')->nullable();
            $table->dateTime('paycom_time_datetime')->nullable();
            $table->dateTime('create_time')->nullable();
            $table->string('perform_time')->nullable();
            $table->string('cancel_time')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('state')->nullable();
            $table->integer('reason')->nullable();
            $table->string('receivers')->nullable();
            $table->string('transaction_created',50)->nullable();
            $table->string('transaction_canceled', 50)->nullable();
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
        Schema::dropIfExists('payme_transactions');
    }
}

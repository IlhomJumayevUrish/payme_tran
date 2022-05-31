<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('user_fio')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('type')->nullable();
            $table->string('psystem')->nullable();
            $table->decimal('amount', 15,2)->nullable();
            $table->dateTime('date_pay')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('bills');
    }
}

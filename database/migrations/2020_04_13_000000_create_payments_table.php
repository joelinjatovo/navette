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
        if( ! Schema::hasTable('payments') ) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->string('payment_type', 100)->nullable();
                $table->text('payment_id')->nullable();
                $table->string('status', 100)->default('ping')->nullable();
                $table->float('amount', 20, 4)->nullable();
                $table->string('currency', 3)->nullable();
                $table->unsignedBigInteger('order_id')->nullable();
                $table->foreign('order_id')->references('id')->on('orders');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('payments');
    }
}

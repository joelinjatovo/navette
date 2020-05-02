<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('payment_tokens') ) {
            Schema::create('payment_tokens', function (Blueprint $table) {
                $table->id();
                $table->string('payment_type', 100)->nullable();
                $table->float('amount', 20, 4)->nullable();
                $table->string('currency', 3)->nullable();
                $table->text('token')->nullable();
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
        Schema::dropIfExists('payment_tokens');
    }
}

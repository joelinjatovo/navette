<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('phones') ) {
            Schema::create('phones', function (Blueprint $table) {
                $table->id();
                $table->string('type', 20);
                $table->string('phone_country_code', 10);
                $table->string('phone_number', 20);
                $table->string('phone', 30);
                $table->unsignedBigInteger('order_id')->index()->nullable();
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->unsignedBigInteger('user_id')->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('phones');
    }
}

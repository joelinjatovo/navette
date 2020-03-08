<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('order_point') ) {
            Schema::create('order_point', function (Blueprint $table) {
                $table->id();
                $table->string('type', 20)->nullable();
                $table->unsignedBigInteger('order_id')->index();
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->unsignedBigInteger('point_id')->index();
                $table->foreign('point_id')->references('id')->on('points')->onDelete('cascade');
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
        Schema::dropIfExists('order_point');
    }
}

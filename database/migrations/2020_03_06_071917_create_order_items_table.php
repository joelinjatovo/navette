<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('order_items') ) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->string('status', 50);
                $table->integer('place');
                $table->float('price', 20, 4);
                $table->float('total', 20, 4);
                $table->float('vat', 2, 2)->default(0);
                $table->boolean('preordered')->default(false);
                $table->boolean('privatized')->default(false);
                
                $table->unsignedBigInteger('order_id')->index()->nullable();
                $table->foreign('order_id')->references('id')->on('zones')->onDelete('cascade');
                
                $table->dateTime('attached_at')->nullable();
                $table->dateTime('canceled_at')->nullable();
                $table->dateTime('detached_at')->nullable();
                $table->unsignedBigInteger('car_id')->index()->nullable();
                $table->foreign('car_id')->references('id')->on('travels')->onDelete('cascade');
                
                $table->unsignedBigInteger('travel_id')->index()->nullable();
                $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
                
                $table->unsignedBigInteger('zone_id')->index()->nullable();
                $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
                
                $table->dateTime('started_at')->nullable();
                $table->unsignedBigInteger('start_point_id')->index();
                $table->foreign('start_point_id')->references('id')->on('points')->onDelete('cascade');
                
                $table->dateTime('arrived_at')->nullable();
                $table->unsignedBigInteger('arrival_point_id')->index();
                $table->foreign('arrival_point_id')->references('id')->on('points')->onDelete('cascade');
                
                $table->dateTime('returned_at')->nullable();
                $table->unsignedBigInteger('return_point_id')->index()->nullable();
                $table->foreign('return_point_id')->references('id')->on('points')->onDelete('cascade');
                
                $table->unsignedBigInteger('author_id')->index()->nullable();
                $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
                
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
        Schema::dropIfExists('order_items');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('orders') ) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('status', 50);
                $table->integer('place');
                $table->float('price', 20, 4); // HT
                $table->float('total', 20, 4); // TTC
                $table->string('currency', 3);
                $table->float('vat', 2, 2)->default(0);
                $table->boolean('preordered')->default(false);
                $table->boolean('privatized')->default(false);
                $table->string('contact_name', 100);
                $table->string('contact_email', 100);
                $table->ipAddress('ip')->nullable();
                $table->macAddress('mac')->nullable();
                
                $table->unsignedBigInteger('phone_id')->index();
                $table->foreign('phone_id')->references('id')->on('phones')->onDelete('cascade');
                
                $table->unsignedBigInteger('travel_id')->index()->nullable();
                $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
                
                $table->dateTime('attached_at')->nullable();
                $table->dateTime('canceled_at')->nullable();
                $table->dateTime('detached_at')->nullable();
                $table->unsignedBigInteger('car_id')->index()->nullable();
                $table->foreign('car_id')->references('id')->on('travels')->onDelete('cascade');
                
                $table->dateTime('started_at')->nullable();
                $table->unsignedBigInteger('start_point_id')->index()->nullable();
                $table->foreign('start_point_id')->references('id')->on('points')->onDelete('cascade');
                
                $table->dateTime('arrived_at')->nullable();
                $table->unsignedBigInteger('arrival_point_id')->index()->nullable();
                $table->foreign('arrival_point_id')->references('id')->on('points')->onDelete('cascade');
                
                $table->dateTime('returned_at')->nullable();
                $table->unsignedBigInteger('return_point_id')->index()->nullable();
                $table->foreign('return_point_id')->references('id')->on('points')->onDelete('cascade');
                
                $table->unsignedBigInteger('author_id')->index();
                $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
                
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}

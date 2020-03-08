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
                $table->string('status', 50)->nullable();
                $table->integer('place');
                $table->float('price', 20, 4)->nullable(); // HT
                $table->float('total', 20, 4)->nullable(); // TTC
                $table->string('currency', 3)->nullable();
                $table->float('vat', 2, 2)->default(0);
                $table->boolean('preordered')->default(false);
                $table->boolean('privatized')->default(false);
                $table->string('contact_name', 100)->nullable();
                $table->string('contact_email', 100)->nullable();
                $table->ipAddress('ip')->nullable();
                $table->macAddress('mac')->nullable();
                $table->unsignedBigInteger('phone_id')->index();
                $table->foreign('phone_id')->references('id')->on('phones')->onDelete('cascade');
                $table->unsignedBigInteger('travel_id')->index()->nullable();
                $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
                $table->dateTime('assigned_at')->nullable();
                $table->dateTime('actived_at')->nullable();
                $table->dateTime('canceled_at')->nullable();
                $table->dateTime('moved_at')->nullable();
                $table->dateTime('finished_at')->nullable();
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
                $table->unsignedBigInteger('user_id')->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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

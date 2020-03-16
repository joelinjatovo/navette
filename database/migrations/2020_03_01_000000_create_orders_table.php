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
                $table->float('vat', 2, 2)->default(0);
                $table->float('amount', 20, 4)->nullable(); // HT
                $table->integer('place');
                $table->float('subtotal', 20, 4)->nullable(); // amount * place
                $table->float('total', 20, 4)->nullable(); // subtotal + subtotal * TVA
                $table->string('currency', 3)->nullable();
                $table->boolean('preordered')->default(false);
                $table->boolean('privatized')->default(false);
                $table->unsignedBigInteger('car_id')->index()->nullable();
                $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
                $table->unsignedBigInteger('club_id')->index()->nullable();
                $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
                $table->unsignedBigInteger('zone_id')->index()->nullable();
                $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
                $table->unsignedBigInteger('travel_id')->index()->nullable();
                $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
                $table->unsignedBigInteger('user_id')->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('order_id')->index()->nullable();
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->ipAddress('ip_address')->nullable();
                $table->macAddress('mac_address')->nullable();
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

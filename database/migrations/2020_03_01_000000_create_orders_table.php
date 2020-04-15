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
                $table->string('status', 50)->default('ping')->nullable();
                $table->string('type', 50)->default('go')->nullable();
                $table->float('vat', 2, 2)->default(0);
                $table->float('amount', 20, 4)->nullable(); // HT
                $table->integer('place');
                $table->float('subtotal', 20, 4)->nullable(); // amount * place
                $table->float('total', 20, 4)->nullable(); // subtotal + subtotal * TVA
                $table->string('currency', 3)->nullable();
                $table->boolean('preordered')->default(false);
                $table->boolean('privatized')->default(false);
                $table->bigInteger('distance_value')->nullable();
                $table->string('distance')->nullable();
                $table->bigInteger('delay_value')->nullable();
                $table->string('delay')->nullable();
                $table->text('direction')->nullable();
                $table->string('payment_type', 100)->nullable();
                $table->dateTime('picked_at')->nullable();
                $table->dateTime('payed_at')->nullable();
                $table->dateTime('completed_at')->nullable();
                $table->dateTime('canceled_at')->nullable();
                $table->string('canceler_role')->nullable();
                $table->unsignedBigInteger('canceled_by')->index()->nullable();
                $table->foreign('canceled_by')->references('id')->on('users');
                $table->unsignedBigInteger('car_id')->index()->nullable();
                $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
                $table->unsignedBigInteger('club_id')->index()->nullable();
                $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
                $table->unsignedBigInteger('zone_id')->index()->nullable();
                $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
                $table->string('ride_status', 50)->default('none')->nullable();
                $table->unsignedBigInteger('ride_id')->index()->nullable();
                $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
                $table->unsignedBigInteger('user_id')->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('driver_id')->index()->nullable();
                $table->foreign('driver_id')->references('id')->on('users');
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

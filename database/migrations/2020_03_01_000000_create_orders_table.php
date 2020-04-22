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
                $table->string('type', 50)->default('go')->nullable(); // go, back, go-back
                $table->string('status', 50)->default('ping')->nullable();
                $table->boolean('preordered')->default(false);
                $table->boolean('privatized')->default(false);
                $table->float('vat', 2, 2)->default(0);
                $table->float('amount', 20, 4)->nullable(); // HT
                $table->integer('place')->default(0);
                $table->bigInteger('distance')->default(0);
                $table->float('subtotal', 20, 4)->nullable(); // amount * place
                $table->float('total', 20, 4)->nullable(); // subtotal + subtotal * TVA
                $table->string('currency', 3)->nullable();
                $table->ipAddress('ip_address')->nullable();
                $table->macAddress('mac_address')->nullable();
                $table->string('payment_status', 100)->nullable();
                $table->string('payment_type', 100)->nullable();
                $table->dateTime('payed_at')->nullable();
                $table->dateTime('completed_at')->nullable();
                $table->dateTime('canceled_at')->nullable();
                $table->string('canceler_role')->nullable();
                $table->unsignedBigInteger('canceler_id')->index()->nullable();
                $table->foreign('canceler_id')->references('id')->on('users');
                $table->unsignedBigInteger('car_id')->index()->nullable();
                $table->foreign('car_id')->references('id')->on('cars');
                $table->unsignedBigInteger('club_id')->index()->nullable();
                $table->foreign('club_id')->references('id')->on('clubs');
                $table->unsignedBigInteger('zone_id')->index()->nullable();
                $table->foreign('zone_id')->references('id')->on('zones');
                $table->unsignedBigInteger('user_id')->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders');
    }
}

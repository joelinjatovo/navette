<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('items') ) {
            Schema::create('items', function (Blueprint $table) {
                $table->id();
                $table->string('type', 50)->default('go')->nullable();
                $table->string('status', 50)->default('ping')->nullable();
                $table->boolean('preordered')->default(false);
                $table->boolean('privatized')->default(false);
                $table->bigInteger('distance_value')->nullable();
                $table->string('distance')->nullable();
                $table->bigInteger('delay_value')->nullable();
                $table->string('delay')->nullable();
                $table->text('direction')->nullable();
                $table->dateTime('ride_at')->nullable();
                $table->string('ride_status', 50)->default('none')->nullable();
                $table->unsignedBigInteger('ride_id')->index()->nullable();
                $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
                $table->unsignedBigInteger('driver_id')->index()->nullable();
                $table->foreign('driver_id')->references('id')->on('users');
                $table->unsignedBigInteger('car_id')->index()->nullable();
                $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
                $table->unsignedBigInteger('club_id')->index()->nullable();
                $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
                $table->unsignedBigInteger('zone_id')->index()->nullable();
                $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
                $table->unsignedBigInteger('order_id')->index();
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('items');
    }
}

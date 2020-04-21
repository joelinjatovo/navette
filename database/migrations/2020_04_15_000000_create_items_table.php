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
                $table->bigInteger('distance_value')->nullable();
                $table->string('distance')->nullable();
                $table->bigInteger('duration_value')->nullable();
                $table->string('duration')->nullable();
                $table->text('direction')->nullable();
                $table->dateTime('ride_at')->nullable();
                $table->dateTime('completed_at')->nullable();
                $table->unsignedBigInteger('ride_id')->index()->nullable();
                $table->foreign('ride_id')->references('id')->on('rides');
                $table->unsignedBigInteger('driver_id')->index()->nullable();
                $table->foreign('driver_id')->references('id')->on('users');
                $table->uuid('point_id')->index()->nullable();
                $table->foreign('point_id')->references('id')->on('points');
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

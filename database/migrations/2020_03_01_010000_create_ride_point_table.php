<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidePointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('ride_point') ) {
            Schema::create('ride_point', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->integer('order')->default(0);
                $table->dateTime('arrived_at')->nullable();
                $table->unsignedBigInteger('ride_id')->index();
                $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
                $table->uuid('point_id')->index();
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
        Schema::dropIfExists('ride_point');
    }
}

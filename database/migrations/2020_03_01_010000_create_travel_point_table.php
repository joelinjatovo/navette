<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('travel_point') ) {
            Schema::create('travel_point', function (Blueprint $table) {
                $table->id();
                $table->integer('order')->default(0);
                $table->dateTime('arrived_at')->nullable();
                $table->unsignedBigInteger('travel_id')->index();
                $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
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
        Schema::dropIfExists('travel_point');
    }
}

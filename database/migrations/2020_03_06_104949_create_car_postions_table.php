<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarPostionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('car_postions') ) {
            Schema::create('car_postions', function (Blueprint $table) {
                $table->id();
                
                $table->unsignedBigInteger('car_id')->index();
                $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
                
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
        Schema::dropIfExists('car_postions');
    }
}

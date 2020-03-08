<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('travels') ) {
            Schema::create('travels', function (Blueprint $table) {
                $table->id();
                $table->string('status', 50);
                $table->unsignedBigInteger('car_id')->index()->nullable();
                $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
                $table->unsignedBigInteger('driver_id')->index()->nullable();
                $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('user_id')->index()->nullable();
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
        Schema::dropIfExists('travels');
    }
}

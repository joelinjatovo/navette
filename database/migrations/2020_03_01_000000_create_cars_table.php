<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('cars') ) {
            Schema::create('cars', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('year', 4);
                $table->integer('place');
                $table->unsignedBigInteger('club_id')->index()->nullable();
                $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
                $table->unsignedBigInteger('car_model_id')->index();
                $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('cascade');
                $table->unsignedBigInteger('driver_id')->index()->nullable();
                $table->foreign('driver_id')->references('id')->on('users');
                $table->unsignedBigInteger('user_id')->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('cars');
    }
}

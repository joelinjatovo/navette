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
                $table->string('name');
                $table->string('year');
                $table->integer('place');
                $table->unsignedBigInteger('car_model_id')->index();
                $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('cascade');
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

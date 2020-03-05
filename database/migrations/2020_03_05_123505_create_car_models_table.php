<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('car_models') ) {
            Schema::create('car_models', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('year');
                $table->integer('place');
                $table->unsignedBigInteger('car_brand_id')->index();
                $table->foreign('car_brand_id')->references('id')->on('car_brands')->onDelete('cascade');
                $table->unsignedBigInteger('car_type_id')->index();
                $table->foreign('car_type_id')->references('id')->on('car_types')->onDelete('cascade');
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
        Schema::dropIfExists('car_models');
    }
}

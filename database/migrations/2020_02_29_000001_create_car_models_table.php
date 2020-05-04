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
                $table->string('name', 100);
                $table->string('year', 4);
                $table->integer('place');
                $table->unsignedBigInteger('car_brand_id')->nullable();
                $table->foreign('car_brand_id')->references('id')->on('car_brands');
                $table->unsignedBigInteger('car_type_id')->nullable();
                $table->foreign('car_type_id')->references('id')->on('car_types');
                $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('car_models');
    }
}

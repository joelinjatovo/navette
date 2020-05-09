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
                $table->string('status', 50)->nullable();
                $table->string('type', 50)->nullable();
                $table->integer('order')->default(0);
                $table->bigInteger('distance_value')->nullable();
                $table->string('distance')->nullable();
                $table->bigInteger('duration_value')->nullable();
                $table->string('duration')->nullable();
                $table->text('direction')->nullable();
                $table->unsignedBigInteger('ride_id')->nullable();
                $table->foreign('ride_id')->references('id')->on('rides');
                $table->uuid('point_id')->nullable();
                $table->foreign('point_id')->references('id')->on('points');
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
        Schema::dropIfExists('ride_point');
    }
}
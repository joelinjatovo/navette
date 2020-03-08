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
                $table->integer('level');
                $table->string('status', 50);
                $table->unsignedBigInteger('parent_id')->index();
                $table->dateTime('started_at')->nullable();
                $table->unsignedBigInteger('start_point_id')->index();
                $table->foreign('start_point_id')->references('id')->on('points')->onDelete('cascade');
                $table->dateTime('arrived_at')->nullable();
                $table->unsignedBigInteger('arrival_point_id')->index();
                $table->foreign('arrival_point_id')->references('id')->on('points')->onDelete('cascade');
                $table->dateTime('returned_at')->nullable();
                $table->unsignedBigInteger('return_point_id')->index()->nullable();
                $table->foreign('return_point_id')->references('id')->on('points')->onDelete('cascade');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('rides') ) {
            Schema::create('rides', function (Blueprint $table) {
                $table->id();
                $table->string('status', 50)->default('created');
                $table->dateTime('start_at')->nullable(); // Date prevue
                $table->dateTime('started_at')->nullable(); // Date reelle
                $table->dateTime('completed_at')->nullable();
                $table->dateTime('canceled_at')->nullable();
                $table->bigInteger('distance_value')->nullable();
                $table->string('distance')->nullable();
                $table->bigInteger('duration_value')->nullable();
                $table->string('duration')->nullable();
                $table->text('direction')->nullable();
                $table->json('route')->nullable();
                $table->unsignedBigInteger('car_id')->nullable();
                $table->foreign('car_id')->references('id')->on('cars');
                $table->unsignedBigInteger('driver_id')->nullable();
                $table->foreign('driver_id')->references('id')->on('users');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('rides');
    }
}

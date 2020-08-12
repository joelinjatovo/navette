<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRideItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('ride_item') ) {
            Schema::create('ride_item', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type', 50)->nullable();
                $table->integer('place')->default(0);
                $table->string('status', 50)->nullable();
                $table->integer('order')->default(0);
                $table->bigInteger('distance_value')->nullable();
                $table->string('distance')->nullable();
                $table->bigInteger('duration_value')->nullable();
                $table->string('duration')->nullable();
                $table->text('direction')->nullable();
                $table->json('leg')->nullable();
                $table->dateTime('arrived_at')->nullable(); // date reel
                $table->dateTime('start_at')->nullable(); // date prevu
                $table->dateTime('started_at')->nullable();
                $table->dateTime('canceled_at')->nullable();
                $table->dateTime('complete_at')->nullable();
                $table->dateTime('completed_at')->nullable();
                $table->unsignedBigInteger('ride_id')->nullable();
                $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
                $table->unsignedBigInteger('item_id')->nullable();
                $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
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
        Schema::dropIfExists('ride_item');
    }
}

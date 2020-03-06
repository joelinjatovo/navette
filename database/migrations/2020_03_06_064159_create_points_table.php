<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('points') ) {
            Schema::create('points', function (Blueprint $table) {
                $table->id();
                $table->string('name', 200);
                $table->decimal('long', 10, 7);
                $table->decimal('lat', 10, 7);
                $table->decimal('alt', 10, 7);
                
                $table->unsignedBigInteger('author_id')->index()->nullable();
                $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
                
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
        Schema::dropIfExists('points');
    }
}

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
                $table->uuid('id')->primary();
                $table->string('name', 200);
                $table->decimal('lng', 10, 7);
                $table->decimal('lat', 10, 7);
                $table->decimal('alt', 10, 7)->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
            });
            
            Schema::table('points', function($table) {
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('points');
    }
}

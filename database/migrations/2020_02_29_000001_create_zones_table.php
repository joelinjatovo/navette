<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('zones') ) {
            Schema::create('zones', function (Blueprint $table) {
                $table->id();
                $table->string('name', 200);
                $table->integer('distance');
                $table->string('unit', 10)->default('m');
                $table->float('privatizedPrice', 20, 4); // HT
                $table->float('price', 20, 4); // HT
                $table->string('currency', 3);
                $table->unsignedBigInteger('user_id')->index();
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
        Schema::dropIfExists('zones');
    }
}

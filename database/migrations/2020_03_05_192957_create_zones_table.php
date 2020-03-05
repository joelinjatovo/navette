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
                $table->string('name');
                $table->integer('distance');
                $table->string('unit')->default('km');
                $table->unsignedBigInteger('author_id')->index();
                $table->foreign('author_id')->references('id')->on('users');
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
        Schema::dropIfExists('zones');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('images') ) {
            Schema::create('images', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('mime');
                $table->string('type')->nullable();
                $table->text('url');
                $table->unsignedBigInteger('imageable_id')->index()->nullable();
                $table->string('imageable_type')->nullable();
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
        Schema::dropIfExists('images');
    }
}

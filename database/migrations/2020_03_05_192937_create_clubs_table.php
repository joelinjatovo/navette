<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('clubs') ) {
            Schema::create('clubs', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->decimal('long', 10, 7);
                $table->decimal('lat', 10, 7);
                $table->decimal('alt', 10, 7);
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
        Schema::dropIfExists('clubs');
    }
}

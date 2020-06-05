<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('discussion') ) {
            Schema::create('discussion', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_1_id')->nullable();
                $table->foreign('user_1_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('user_2_id')->nullable();
                $table->foreign('user_2_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('discussion');
    }
}

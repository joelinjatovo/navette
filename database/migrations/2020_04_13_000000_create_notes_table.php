<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('notes') ) {
            Schema::create('notes', function (Blueprint $table) {
                $table->id();
                $table->string('type')->nullable();
                $table->text('description')->nullable();
                $table->unsignedBigInteger('star')->nullable();
                $table->float('amount', 20, 4)->nullable(); // 
                $table->string('currency', 3)->nullable();
                $table->unsignedBigInteger('notable_id')->index();
                $table->string('notable_type');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('notes');
    }
}

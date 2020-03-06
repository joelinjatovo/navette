<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('api_tokens') ) {
            Schema::create('api_tokens', function (Blueprint $table) {
                $table->id();
                $table->string('token', 100)->index();
                $table->string('name', 100);
                $table->string('version', 100);
                $table->string('agent', 50)->nullable();
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
        Schema::dropIfExists('api_tokens');
    }
}

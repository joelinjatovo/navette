<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('access_logs') ) {
            Schema::create('access_logs', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->unsignedBigInteger('user_id')->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users');
                $table->integer('status')->default(0);
                $table->string('url')->nullable();
                $table->string('referer')->nullable();
                $table->string('user_agent')->nullable();
                $table->string('country', 2)->nullable();
                $table->ipAddress('ip')->nullable();
                $table->string('platform', 100)->nullable();
                $table->boolean('api')->default(false);
                $table->unsignedBigInteger('api_key_id')->index()->nullable();
                $table->foreign('api_key_id')->references('id')->on('api_keys');
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
        Schema::dropIfExists('access_logs');
    }
}

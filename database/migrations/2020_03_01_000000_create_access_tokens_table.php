<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('access_tokens') ) {
            Schema::create('access_tokens', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->text('scopes');
                $table->unsignedBigInteger('user_id')->index();
                $table->foreign('user_id')->references('id')->on('users');
                $table->boolean('revoked')->default(false);
                $table->dateTime('expires_at')->nullable();
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
        Schema::dropIfExists('access_tokens');
    }
}

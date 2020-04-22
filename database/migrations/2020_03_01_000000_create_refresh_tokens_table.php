<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefreshTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('refresh_tokens') ) {
            Schema::create('refresh_tokens', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->text('scopes');
                $table->uuid('access_token_id')->nullable();
                $table->foreign('access_token_id')->references('id')->on('access_tokens');
                $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('refresh_tokens');
    }
}

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
                $table->id();
                $table->text('scopes');
                
                $table->unsignedBigInteger('access_token_id')->index();
                $table->foreign('access_token_id')->references('id')->on('access_tokens')->onDelete('cascade');
                
                $table->unsignedBigInteger('user_id')->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                
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
        Schema::dropIfExists('refresh_tokens');
    }
}

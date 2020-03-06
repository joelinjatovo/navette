<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('api_keys') ) {
            Schema::create('api_keys', function (Blueprint $table) {
                $table->id();
                $table->text('scopes');
                $table->string('name', 100);
                $table->string('version', 100);
                $table->string('user_agent', 50)->nullable();
                $table->boolean('revoked')->default(0);
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
        Schema::dropIfExists('api_keys');
    }
}

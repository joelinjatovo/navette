<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('users') ) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('locale', 2)->default('fr');
                $table->string('facebook_id', 200)->nullable();
                $table->string('phone', 20)->nullable();
                $table->timestamp('phone_verified_at')->nullable();
                $table->string('password');
                $table->boolean('active')->default(true);
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

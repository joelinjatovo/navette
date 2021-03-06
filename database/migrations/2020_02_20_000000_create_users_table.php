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
                $table->string('stripe_id', 200)->nullable();
                $table->string('payment_method_id', 200)->nullable();
                $table->string('facebook_id', 200)->nullable();
                $table->uuid('code')->nullable()->unique();
                $table->string('first_name', 100)->nullable();
                $table->string('last_name', 100)->nullable();
                $table->string('birthday', 100)->nullable();
                $table->string('name', 100)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('phone', 20)->nullable();
                $table->string('password');
                $table->string('address', 100)->nullable();
                $table->string('postal_code', 100)->nullable();
                $table->string('locale', 2)->default('fr');
                $table->timestamp('activated_at')->nullable();
                $table->timestamp('blocked_at')->nullable();
                $table->timestamp('phone_verified_at')->nullable();
                $table->string('phone_verification_code')->nullable();
                $table->timestamp('phone_verification_expires_at')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('users');
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

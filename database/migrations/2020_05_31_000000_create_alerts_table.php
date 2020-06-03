<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasTable('alerts') ) {
			Schema::create('alerts', function (Blueprint $table) {
				$table->id();
                $table->boolean('is_public')->default(true);
                $table->string('event');
                $table->string('type');
                $table->string('title');
                $table->text('description');
                $table->string('uri');
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
        Schema::dropIfExists('alerts');
    }
}

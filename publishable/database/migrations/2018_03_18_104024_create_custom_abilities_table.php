<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable()->unique();
            $table->string('name')->unique();
            $table->timestamps();

            $table->integer('ability_category_id')->unsigned();
            $table->foreign('ability_category_id')->references('id')->on('ability_categories');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::dropIfExists('abilities');
    }
}

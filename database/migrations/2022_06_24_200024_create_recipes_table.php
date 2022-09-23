<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('info')->nullable();
            $table->enum('difficulty', ['very easy', 'easy', 'medium', 'hard', 'very hard']);
            $table->integer('time_to_cook')->nullable();
            $table->integer('time_to_prepare')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('yield_quantity')->nullable();
            $table->string('yield_unit_measure')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}

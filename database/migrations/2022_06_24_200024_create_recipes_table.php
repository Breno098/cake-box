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
            $table->enum('difficulty', [1, 2, 3, 4, 5]);
            $table->time('time_to_cook')->nullable();
            $table->time('time_to_prepare')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('yield_quantity')->nullable();
            $table->enum('yield_unit_measure', ['Pedaço', 'Fatia', 'Gramas'])->nullable();
            $table->string('wallpaper')->nullable();
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

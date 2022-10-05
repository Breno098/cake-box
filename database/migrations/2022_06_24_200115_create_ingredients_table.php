<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit_measure')->nullable();
            $table->integer('kcal')->nullable();
            $table->integer('fat')->nullable();
            $table->integer('saturates')->nullable();
            $table->integer('carbs')->nullable();
            $table->integer('sugars')->nullable();
            $table->integer('fibre')->nullable();
            $table->integer('protein')->nullable();
            $table->integer('salt')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('ingredients');
    }
}

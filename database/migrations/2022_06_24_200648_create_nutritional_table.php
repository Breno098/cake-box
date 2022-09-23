<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutritionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutritional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained();
            $table->string('unit_measure')->nullable();
            $table->integer('kcal')->nullable();
            $table->integer('fat')->nullable();
            $table->integer('saturates')->nullable();
            $table->integer('carbs')->nullable();
            $table->integer('sugars')->nullable();
            $table->integer('fibre')->nullable();
            $table->integer('protein')->nullable();
            $table->integer('salt')->nullable();
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
        Schema::dropIfExists('nutritional');
    }
}

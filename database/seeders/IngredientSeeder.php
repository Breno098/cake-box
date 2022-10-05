<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Ingredient;
use App\Models\Nutritional;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $namesSequence = new Sequence(
            ['name' => 'Água'],
            ['name' => 'Alface'],
            ['name' => 'Alho'],
            ['name' => 'Amendois'],
            ['name' => 'Amido de milho'],
            ['name' => 'Amêndoa'],
            ['name' => 'Aromatizante'],
            ['name' => 'Aveia'],
            ['name' => 'Avelã'],
            ['name' => 'Azeite'],
            ['name' => 'Açúcar'],
            ['name' => 'Açúcar invertido'],
            ['name' => 'Açúcar mascavo'],
            ['name' => 'Banana'],
            ['name' => 'Cacau em pó'],
            ['name' => 'Canela em cascas'],
            ['name' => 'Canela em pó'],
            ['name' => 'Carne (bovina)'],
            ['name' => 'Castanhas'],
            ['name' => 'Cebola'],
            ['name' => 'Cenoura'],
            ['name' => 'Cereja'],
            ['name' => 'Chocolate'],
            ['name' => 'Chocolate em pó'],
            ['name' => 'Chocolate granulado'],
            ['name' => 'Coco'],
            ['name' => 'Emulsificante'],
            ['name' => 'Farinha'],
            ['name' => 'Fermento'],
            ['name' => 'Fermento em pó'],
            ['name' => 'Frango'],
            ['name' => 'Gema de ovo'],
            ['name' => 'Leite'],
            ['name' => 'Leite em pó'],
            ['name' => 'Leite de coco'],
            ['name' => 'Manteiga'],
            ['name' => 'Margarina'],
            ['name' => 'Maçã'],
            ['name' => 'Milho'],
            ['name' => 'Morango'],
            ['name' => 'Mostarda'],
            ['name' => 'Nozes'],
            ['name' => 'Ovo'],
            ['name' => 'Peixe'],
            ['name' => 'Pimenta'],
            ['name' => 'Pimenta do reino'],
            ['name' => 'Polvilho'],
            ['name' => 'Salsa'],
            ['name' => 'Tomate'],
            ['name' => 'Uva'],
            ['name' => 'Vinagre'],
            ['name' => 'Óleo'],
            ['name' => 'Óleo de coco'],
        );

        Ingredient::factory()
            ->state($namesSequence)
            ->count($namesSequence->count())
            ->create();
    }
}

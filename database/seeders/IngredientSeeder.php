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
            ['name' => 'Ovo'],
            ['name' => 'Açucar'],
            ['name' => 'Manteiga'],
            ['name' => 'Água'],
            ['name' => 'Farinha'],
            ['name' => 'Chocolate em pó'],
            ['name' => 'Chocolate granulado'],
            ['name' => 'Óleo'],
            ['name' => 'Fermento'],
        );

        Ingredient::factory()
            ->state($namesSequence)
            ->count($namesSequence->count())
            ->has(Image::factory())
            ->create();
    }
}

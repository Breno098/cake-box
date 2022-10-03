<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Direction;
use App\Models\Image;
use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\Nutritional;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directionsFactory = Direction::factory()
            ->state(new Sequence(
                ['order' => 1],
                ['order' => 2],
                ['order' => 3]
            ))
            ->count(3);

        Recipe::factory(50)
            ->has(Image::factory()->count(2))
            ->has(Comment::factory()->count(3))
            ->has($directionsFactory)
            ->hasAttached(Ingredient::inRandomOrder()->limit(2)->get(), [
                'quantity' => rand(10, 500),
                'unit_measure' => 'gramas'
            ])
            ->create();
    }
}

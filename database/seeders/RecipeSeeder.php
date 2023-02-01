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
        Recipe::factory(15)
            ->has(Comment::factory()->count(3))
            ->create()
            ->each(function(Recipe $recipe) {
                foreach (range(1, random_int(1, 5)) as $image) {
                    $recipe->images()->create(Image::factory()->make([
                        'image_type' => Recipe::class,
                        'image_id' => $recipe->id
                    ])->toArray());
                }

                foreach (range(1, random_int(1, 10)) as $order) {
                    $recipe->directions()->create(Direction::factory()->make(['order' => $order])->toArray());
                }

                Ingredient::inRandomOrder()
                    ->limit(5)
                    ->each(function(Ingredient $ingredient) use ($recipe){
                        $recipe->ingredients()->attach($ingredient->id, [
                            'quantity' => fake()->numberBetween(1, 300),
                            'unit_measure' => fake()->randomElement(['Unidade', 'Grama', 'Quilo', 'Mililitro', 'Litro', 'Colher'])
                        ]);
                    });
            });
    }
}

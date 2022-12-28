<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            app()->environment('production')  ? $this->production() : $this->development()
        );
    }

     /**
     * @return string[]
     */
    private function production(): array
    {
        return [
            UserSeeder::class,
            IngredientSeeder::class,
            RecipeSeeder::class,
            PostSeeder::class
        ];
    }

     /**
     * @return string[]
     */
    private function development(): array
    {
        return [
            UserSeeder::class,
            IngredientSeeder::class,
            RecipeSeeder::class,
            PostSeeder::class
        ];
    }

}

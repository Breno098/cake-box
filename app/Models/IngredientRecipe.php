<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $id
 * @property int $ingredient_id
 * @property int $recipe_id
 * @property int $quantity
 * @property string $unit_measure
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Recipe $recipe
 * @property Ingredient $ingredient
 */
class IngredientRecipe extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'recipe_id',
        'quantity',
        'unit_measure',
    ];

    /**
     * @return Recipe
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * @return Ingredient
     */
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int|null $id
 * @property string $name
 * @property string $unit_measure
 * @property int $kcal
 * @property int $fat
 * @property int $saturates
 * @property int $carbs
 * @property int $sugars
 * @property int $fibre
 * @property int $protein
 * @property int $salt
 * @property string $image
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Recipe[]|Collection $recipes
 * @property Image $image
 */
class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_measure',
        'kcal',
        'fat',
        'saturates',
        'carbs',
        'sugars',
        'fibre',
        'protein',
        'salt',
        'image'
    ];

    /**
     * @return Recipe[]|Collection|BelongsToMany
     */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->using(IngredientRecipe::class);
    }

    /**
     * @return Image|MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->withDefault();
    }

    /**
     * Scopes
     */

    public function scopeByName(Builder $builder, $name)
    {
        return $builder->when($name, function(Builder $query, $name) {
            return $query->where('name', $name);
        });
    }
}

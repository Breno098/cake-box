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
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Recipe[]|Collection $recipes
 * @property Nutritional $nutritional
 * @property Image $image
 */
class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * @return Recipe[]|Collection|BelongsToMany
     */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->using(IngredientRecipe::class);
    }

    /**
     * @return Nutritional|HasOne
     */
    public function nutritional(): HasOne
    {
        return $this->hasOne(Nutritional::class)->withDefault();
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

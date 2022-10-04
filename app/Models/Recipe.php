<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int|null $id
 * @property string $title
 * @property string $description
 * @property string $difficulty
 * @property int $time_to_cook
 * @property int $time_to_prepare
 * @property int $rating
 * @property int $yield_quantity
 * @property string $yield_unit_measure
 * @property string $wallpaper
 * @property string $image_1
 * @property string $image_2
 * @property string $image_3
 * @property string $image_4
 * @property string $image_5
 * @property string $image_6
 * @property string $yield_unit_measure
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Ingredient[]|Collection $ingredients
 * @property Direction[]|Collection $directions
 * @property Comment[]|Collection $comments
 * @property Image[]|Collection $images
 */
class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'info',
        'difficulty',
        'time_to_cook',
        'time_to_prepare',
        'rating',
        'yield_quantity',
        'yield_unit_measure',
        'wallpaper',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'image_6',
    ];

    protected $casts = [
        'difficulty' => 'integer'
    ];

    /**
     * @return Ingredient[]|Collection|BelongsToMany
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
            ->using(IngredientRecipe::class)
            ->withPivot(['quantity', 'unit_measure']);
    }

    /**
     * @return Direction[]|Collection|HasMany
     */
    public function directions(): HasMany
    {
        return $this->hasMany(Direction::class)->orderBy('order');
    }

    /**
     * @return Comment[]|Collection|MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return Image[]|Collection|MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Attributes
     */
    /**
     * @return string
     */
    public function getHoursToCookAttribute(): string
    {
        return $this->time_to_cook ? date('H', $this->time_to_cook) : '0';
    }

    /**
     * @return string
     */
    public function getMinutesToCookAttribute(): string
    {
        return $this->time_to_cook ? date('i', $this->time_to_cook) : '0';
    }
}

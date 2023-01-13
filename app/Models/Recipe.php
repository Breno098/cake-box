<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    ];

    protected $casts = [
        'difficulty' => 'integer',
    ];

    /**
     * @return Ingredient[]|Collection|BelongsToMany
     */
    public function ingredients(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Ingredient::class)
            ->using(IngredientRecipe::class)
            ->withPivot(['quantity', 'ingredient_recipe.unit_measure as unit_measure']);
    }

    /**
     * @return Direction[]|Collection|HasMany
     */
    public function directions(): HasMany|Collection
    {
        return $this->hasMany(Direction::class)->orderBy('order');
    }

    /**
     * @return Comment[]|Collection|MorphMany
     */
    public function comments(): MorphMany|Collection
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

     /**
     * @return Image[]|Collection|MorphMany
     */
    public function images(): MorphMany|Collection
    {
        return $this->morphMany(Image::class, 'image');
    }

     /**
     * @return UserAction[]|Collection|MorphMany
     */
    public function actions(): MorphMany|Collection
    {
        return $this->morphMany(UserAction::class, 'origin');
    }

    /**
     * @return UserAction[]|Collection|MorphMany
     */
    public function likes(): MorphMany|Collection
    {
        return $this->actions()->where('action', UserAction::LIKE);
    }

    /**
     * @return UserAction[]|Collection|MorphMany
     */
    public function saves(): MorphMany|Collection
    {
        return $this->actions()->where('action', UserAction::SAVE);
    }

    /**
     * @return UserAction[]|Collection|MorphMany
     */
    public function likesByAuthUser(): MorphMany|Collection
    {
        return $this->likes()->when(auth()->check(), function(Builder $query, $name) {
            return $query->where('user_id', auth()->user()->id);
        });
    }

     /**
     * @return UserAction[]|Collection|MorphMany
     */
    public function savesByAuthUser(): MorphMany|Collection
    {
        return $this->saves()->when(auth()->check(), function(Builder $query, $name) {
            return $query->where('user_id', auth()->user()->id);
        });
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

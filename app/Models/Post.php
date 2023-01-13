<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int|null $id
 * @property string $title
 * @property string $description
 * @property string $link_video
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $creator
 * @property Image[]|Collection $images
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'link_video',
        'created_by',
    ];

    /**
     * @return BelongsTo|User
     */
    public function creator(): BelongsTo|User
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();;
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
        return $this->likes()->when(auth()->check(), function(Builder $query) {
            return $query->where('user_id', auth()->user()->id);
        });
    }

     /**
     * @return UserAction[]|Collection|MorphMany
     */
    public function savesByAuthUser(): MorphMany|Collection
    {
        return $this->saves()->when(auth()->check(), function(Builder $query) {
            return $query->where('user_id', auth()->user()->id);
        });
    }

    /**
     * Actions
     */
    /**
     * @return void
     */
    public function toLike(User $user)
    {
        $this->actions()->create([
            'action' => UserAction::LIKE,
            'user_id' => $user->id
        ]);
    }

    /**
     * @return void
     */
    public function dislike(User $user)
    {
        $this->actions()->where([
            'action' => UserAction::LIKE,
            'user_id' => $user->id
        ])->delete();
    }

    /**
     * @return void
     */
    public function toSave(User $user)
    {
        $this->actions()->create([
            'action' => UserAction::SAVE,
            'user_id' => $user->id
        ]);
    }

    /**
     * @return void
     */
    public function notSave(User $user)
    {
        $this->actions()->where([
            'action' => UserAction::SAVE,
            'user_id' => $user->id
        ])->delete();
    }
}

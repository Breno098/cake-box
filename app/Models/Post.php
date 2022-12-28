<?php

namespace App\Models;

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

}

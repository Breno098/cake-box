<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property int|null $id
 * @property string $name
 * @property string $path
 * @property int $size
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read string $storage_link
 */
class Image extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'path',
        'size',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'storage_link',
    ];


     /**
     * @return MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Attributes
     */
    public function getStorageLinkAttribute()
    {
        return Storage::url($this->path);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int|null $id
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'imageable_id',
        'imageable_type',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Attributes
     */
    /**
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }
}

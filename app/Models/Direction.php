<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null $id
 * @property string $description
 * @property int $order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Recipe $recipe
 */
class Direction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'order',
    ];

    /**
     * @return Recipe|HasOne
     */
    public function recipe(): HasOne
    {
        return $this->hasOne(Recipe::class);
    }
}

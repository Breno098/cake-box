<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int|null $id
 * @property int $user_id
 * @property string $action
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UserAction extends Model
{
    use HasFactory;

    const LIKE = 'like';
    const SAVE = 'save';

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'action',
    ];

    // protected static function booted()
    // {
    //     static::saving(function ($model) {
    //         $model->user_id = auth()->user()->id ?? 1;
    //     });
    // }

     /**
     * @return MorphTo
     */
    public function originable()
    {
        return $this->morphTo();
    }

    /**
     * Scopes
     */
    public function scopeByAuthUser(Builder $builder)
    {
        return $builder->when(auth()->check(), function(Builder $query) {
            return $query->where('user_id', auth()->user()->id);
        });
    }

}

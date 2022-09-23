<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutritional extends Model
{
    use HasFactory;

    public $table = 'nutritional';

    protected $fillable = [
        'unit_measure',
        'kcal',
        'fat',
        'saturates',
        'carbs',
        'sugars',
        'fibre',
        'protein',
        'salt',
    ];

    public function ingredients()
    {
        return $this->hasOne(Ingredient::class);
    }
}

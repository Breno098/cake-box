<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $id
 * @property string $name
 * @property string $email
 * @property string $whatsapp
 * @property string $instagram
 * @property string $facebook
 * @property string $linkedin
 * @property string $phone
 * @property string $cellphone
 * @property string $info
 * @property string $web_site
 * @property string $specialty
 * @property string $photo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'instagram',
        'facebook',
        'linkedin',
        'phone',
        'cellphone',
        'info',
        'web_site',
        'specialty',
        'photo'
    ];
}

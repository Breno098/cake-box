<?php

namespace App\Helpers\Support;

use Illuminate\Support\Arr;

trait EnumForSelect
{
    public static function forSelect(): array
    {
        if (empty(self::cases())) {
            return [];
        }

        if (property_exists(Arr::first(self::cases()), 'value')) {
            return array_combine(
                array_column(self::cases(), 'value'),
                array_column(self::cases(), 'name')
            );
        }

        return array_column(self::cases(), 'name');
    }
}

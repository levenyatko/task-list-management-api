<?php

/**
 *
 * @class EnumToArray
 * @package App\Traits
 */

namespace App\Traits;

trait EnumToArray
{
    public static function toArray(): array
    {
        return array_map(
            fn(self $enum) => $enum->value,
            self::cases()
        );
    }
}

<?php

namespace App\Trait;

trait EnumTrait
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
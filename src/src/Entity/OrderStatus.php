<?php

namespace App\Entity;

enum OrderStatus: string
{
    case NEW = 'new';
    case PROCESSING = 'processing';
    case SOLVED = 'solved';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

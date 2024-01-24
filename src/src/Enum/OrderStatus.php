<?php

namespace App\Enum;

use App\Trait\EnumTrait;

enum OrderStatus: string
{
    use EnumTrait;
    
    case NEW = 'new';
    case PROCESSING = 'processing';
    case SOLVED = 'solved';
}

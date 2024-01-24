<?php

namespace App\Entity;
use App\Trait\EnumTrait;

enum OrderStatus: string
{
    use EnumTrait;
    
    case NEW = 'new';
    case PROCESSING = 'processing';
    case SOLVED = 'solved';
}

<?php

namespace App\Enum;

use App\Trait\EnumTrait;

enum Role: string
{
    case ROLE_USER = "ROLE_USER";
    case ROLE_MANAGER = "ROLE_MANAGER";
}

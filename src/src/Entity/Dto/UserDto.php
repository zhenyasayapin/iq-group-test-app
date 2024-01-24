<?php

namespace App\Entity\Dto;

use App\Enum\Role;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto extends AbstractDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(
        min: 3,
        max: 255
    )]        
    public $username;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(
        min: 3,
        max: 255
    )]        
    public $plainPassword;

    #[Assert\NotBlank] 
    #[Assert\Choice(callback: [Role::class, 'values'])]
    public $role;
}
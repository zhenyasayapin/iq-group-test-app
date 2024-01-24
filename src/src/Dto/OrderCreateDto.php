<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class OrderCreateDto extends AbstractDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(
        max: 255
    )]
    public $topic;
    
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(
        max: 255
    )]    
    public $message;
}
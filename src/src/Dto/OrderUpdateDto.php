<?php

namespace App\Dto;

use App\Enum\OrderStatus;
use Symfony\Component\Validator\Constraints as Assert;

class OrderUpdateDto extends AbstractDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(
        max: 255
    )]        
    public $comment;
    
    #[Assert\NotBlank]
    #[Assert\Choice(callback: [OrderStatus::class, 'values'])]
    public $status;
}
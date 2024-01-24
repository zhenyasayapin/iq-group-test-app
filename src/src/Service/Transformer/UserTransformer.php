<?php

namespace App\Service\Transformer;

use App\Entity\User;

class UserTransformer
{
    public function transform(User $user): array
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ];
    }
}

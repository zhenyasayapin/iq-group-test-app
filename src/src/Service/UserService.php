<?php

namespace App\Service;

use App\Entity\Dto\UserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher
    ) {}
    public function create(UserDto $userDto)
    {
        $user = new User();

        $password = $this->hasher->hashPassword($user, $userDto->plainPassword);

        $user->setPassword($password);
        $user->setUsername($userDto->username);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
